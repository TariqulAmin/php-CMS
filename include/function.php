<?php 

require_once 'include/dbconnection.php';
require_once 'include/session.php';

 ?>


<?php 



function redirect($loc){

header("Location:".$loc);
exit;

}


function loggedin(){

	if(isset($_SESSION['id'])){

	return true;

	}else{


		return false;
	}
}



 ?>