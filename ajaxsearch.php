<?php
include("connection.php");
$keyword = $_GET["keyword"];
$query = "select * from students WHERE firstname LIKE '%$keyword%' OR lastname LIKE '%$keyword%' OR email LIKE '%$keyword%'";
// echo $query;die;
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