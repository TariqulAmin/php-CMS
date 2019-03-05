<?php 

$server="localhost";
$user="root";
$password="";
$database="phpcms";

$connection=mysqli_connect($server,$user,$password,$database);

if(!$connection){

echo 'Database Error'.mysqli_connect_error($connection);

}


 ?>