<?php 

session_start();


function successmessage(){

if(isset($_SESSION['successMessage'])){

//$_SESSION['successMessage']=null;
$output= "<div class=\"alert alert-success\">".$_SESSION['successMessage']."</div>";
return $output;

}

}

function dangermessage(){

if(isset($_SESSION['errorMessage'])){

//$_SESSION['dangerMessage']=null;
$output= "<div class=\"alert alert-danger\">".$_SESSION['errorMessage']."</div>";;
return $output;
}

}



 ?>