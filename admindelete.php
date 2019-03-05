<?php 


include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

if(isset($_GET['id'])){

$id=$_GET['id'];

$query="DELETE FROM registration WHERE id='$id' ";

$execute=mysqli_query($connection,$query);

if($execute){

$_SESSION['successMessage']="Admin Deleted";
redirect("admins.php");

}else{

$_SESSION['errorMessage']="Something Went Wrong";
redirect("admins.php");

}


}



 ?>