<?php

include("connection.php");
// print_r($_POST);die;
if ($_POST["id"]) {
    $id = $_POST["id"];
    $query = "select * from students where id=".$id;
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("error". mysqli_error($conn));
    }
    else{
        $row = mysqli_fetch_array($result);
        echo json_encode($row);
    }
}
// 

?>