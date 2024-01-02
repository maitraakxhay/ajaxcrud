<?php include("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<body>
    <form action="" method="post" onsubmit="return validateform(event); return false;">
        <table class="table table-striped">
            <tr>
                <td>First Name :</td>
                <td><input type="text" name="firstname" id="firstname"></td>
            </tr>
            <tr>
                <td>Last Name :</td>
                <td><input type="text" name="lastname" id="lastname"></td>
            </tr>
            <tr>
                <td>Email :</td>
                <td><input type="email" name="email" id="email"></td>
            </tr>
            <tr>
                <td>Gender :</td>
                <td>
                    <select name="gender" id="gender">
                        <option value="">Choose an Option</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date of Birth :</td>
                <td><input type="date" name="dob" id="dob"></td>
            </tr>
            <tr>
                <td>Hobbies :</td>
                <td><input type="checkbox" name="hobbies[]" value="cricket" id="hobbies">Cricket
                <input type="checkbox" name="hobbies[]" value="football" id="hobbies">Football
                <input type="checkbox" name="hobbies[]" value="hockey" id="hobbies">Hockey</td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="rowid" id="rowid" value="">
                    <input type="submit" name="submitform" value="Submit">
                </td>
            </tr>
        </table>
    </form>
    <div>
        <label>Search:</label>
        <input type="text" name="search" id="search">
    </div>
    <table border="2px" class="table table-striped">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Hobbies</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="rowdata">
        </tbody>
    </table>
 



</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

function validateform(e)
{
    // alert('called');
    e.preventDefault();
    let fname = document.getElementById('firstname').value;
    let lname = document.getElementById('lastname').value;
    let email = document.getElementById('email').value;
    let gender = document.getElementById('gender').value;
    let dob = document.getElementById('dob').value;
    let hobbies = document.getElementsByName('hobbies[]');

    

    if(fname == ""){
        alert("Please Add First Name");
        return false;
    }
    if(lname == ""){
        alert("Please Enter Last Name");
        return false;
    }
    if(email == ""){
        alert("Please Enter Email");
        return false;
    }
    if(gender == ""){
        alert("Please Select Gender");
        return false;
    }
    if(dob == ""){
        alert("Please Choose Date Of Birth");
        return false;
    }
    if(hobbies[0].checked == false && hobbies[1].checked == false && hobbies[2].checked == false){
        alert("Please Select Hobbies");
        return false;
    }
    // insert data to table
    $.ajax({
        type:'POST',
        url:'insert.php',
        data: $('form').serialize(),
        success:function(data){
            getRowData();   
            // alert ("Done");
            return false;

        }
    });

    e.preventDefault();
    return false;
}

function getRowData()
{
    var tbody = '';
    $.ajax({
        type:"GET",
        url:'dataget.php',
        dataType:"JSON",
        success:function(data){
            console.log (data);
            if (data) {
                for(i=0; i<= data.length - 1; i++) {
                    // console.log(data[i].firstname);
                    tbody += '<tr><td>'+data[i].firstname+'</td><td>'+data[i].lastname+'</td><td>'+data[i].email+'</td><td>'+data[i].gender+'</td><td>'+data[i].dob+'</td><td>'+data[i].hobbies+'</td><td><a href="javascript:void(0)" data-id="'+data[i].id+'" class="btn btn-danger edit-btn">Edit</a> <a href="javascript:void(0)" data-id="'+data[i].id+'" class="btn btn-primary delete-btn" >Delete</a></td>';
                    
                }
                console.log(tbody);
                $('#rowdata').html(tbody);
            }
        }
    });

}
$(document).ready(function(){
    //get tbody data
    getRowData();
    
    
    //update data to table
    $(document).on("click",".edit-btn",function() {
        console.log($(this).attr('data-id'));
        let id = $(this).attr('data-id');
        $.ajax({
            type:"POST",
            url:'update.php',
            dataType:"JSON",
            data:{
                "id": id
            },
            success:function(data){
                // console.log ('data');
                // console.log (data);
                // console.log (data.hobbies.split(','));
                $('form #rowid').val(data.id);
                $('form #firstname').val(data.firstname);
                $('form #lastname').val(data.lastname);
                $('form #email').val(data.email);
                $('form #gender').val(data.gender);
                $('form #dob').val(data.dob);
                $('form #hobbies').val(data.hobbies.split(','));
                return false;
            }
        });
    });


    //Delete data of table
    $(document).on("click",".delete-btn",function() {
        console.log($(this).attr('data-id'));
        let id = $(this).attr('data-id');
        $.ajax({
            type:"POST",
            url:'delete.php',
            data:{
                "id": id
            },
            success:function(data){
                getRowData();
                return false;
            }
        });
    });

    //search data in table
    $(document).on("keyup","#search",function() {
        var tbody = '';
        $.ajax({
            type:"GET",
            url:'ajaxsearch.php',
            dataType:"JSON",
            data:{
                keyword:$(this).val()
            },
            success:function(data){
                console.log (data);
                if (data) {
                    for(i=0; i<= data.length - 1; i++) {
                        // console.log(data[i].firstname);
                        tbody += '<tr><td>'+data[i].firstname+'</td><td>'+data[i].lastname+'</td><td>'+data[i].email+'</td><td>'+data[i].gender+'</td><td>'+data[i].dob+'</td><td>'+data[i].hobbies+'</td><td><a href="javascript:void(0)" data-id="'+data[i].id+'" class="btn btn-danger edit-btn">Edit</a> <a href="javascript:void(0)" data-id="'+data[i].id+'" class="btn btn-primary delete-btn" >Delete</a></td>';
                        
                    }
                    console.log(tbody);
                    $('#rowdata').html(tbody);
                }
            }
        });
    });
});
    </script>
</html>