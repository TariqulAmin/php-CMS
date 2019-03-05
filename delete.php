<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';



if(isset($_GET['id'])){

$commentid=$_GET['id'];

$query="DELETE FROM comments WHERE id='$commentid' ";
$execute=mysqli_query($connection,$query);

if($execute){

$_SESSION['successMessage']="Comment Deleted Successfully.";

redirect("comments.php");

}
else{

$_SESSION['errorMessage']="Something Went Wrong.";
redirect("comments.php");
}



}




 ?>