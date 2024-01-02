<?php
 
 include("connection.php");
 if($_POST["rowid"]){
    $id = $_POST["rowid"];
 }else{
    $id = 'NULL';
 }
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $hobby = $_POST["hobbies"];
    if($hobby){
        $hobbies = implode(',',$hobby);        
    }
    else{
        $hobbies = '';
    }

    $query = "insert into students (`id`, `firstname`	,`lastname`, `email`, `gender`,	`dob`,	`hobbies`) values ($id, '$firstname','$lastname','$email','$gender','$dob','$hobbies') ON DUPLICATE KEY UPDATE `firstname`='$firstname', `lastname`='$lastname',`email`='$email',`gender`='$gender',`dob`='$dob',`hobbies`='$hobbies'";
// echo $query;die;
    $result = mysqli_query($conn, $query);


?>