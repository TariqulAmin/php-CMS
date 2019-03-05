<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';



if(isset($_GET['id'])){

$commentid=$_GET['id'];
$admin=$_SESSION['user'];

$query="UPDATE comments SET status='on',approvedby='$admin' WHERE id='$commentid' ";
$execute=mysqli_query($connection,$query);

if($execute){

$_SESSION['successMessage']="Comment Approved.";

redirect("comments.php");

}
else{

$_SESSION['errorMessage']="Something Went Wrong.";
redirect("comments.php");
}



}




 ?>