<?php 


include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

if(isset($_GET['id'])){

$categoryid=$_GET['id'];

$query="DELETE FROM category WHERE id='$categoryid'";

$execute=mysqli_query($connection,$query);

if($execute){

$_SESSION['successMessage']="Catagory Deleted";
redirect("categories.php");

}else{

$_SESSION['errorMessage']="Something Went Wrong";
redirect("categories.php");

}


}



 ?>