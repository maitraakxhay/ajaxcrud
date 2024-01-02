<?php

define("HOSTNAME","localhost");
define("USERNAME","root");
define("PASSWORD","root");
define("DATABASE","form_crud");


$conn = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);

if(!$conn){
    die("Error". mysqli_connect_error());
}
// else{
//     echo "Connected";
// }

?>