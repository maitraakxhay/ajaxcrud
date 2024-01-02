<?php
include("connection.php");

$query = "select * from students ";
$result = mysqli_query($conn, $query);
if(!$result){
    die("error". mysqli_error($conn));
}
else{
    $row = mysqli_fetch_assoc($result);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    echo json_encode($data);
}
?>