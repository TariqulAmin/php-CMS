<?php 


include 'include/session.php';
include 'include/function.php';


if(isset($_SESSION['id'])){


$_SESSION['id']=null;

redirect('login.php');

}


?>