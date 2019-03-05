<?php 

require_once 'include/dbconnection.php';
require_once 'include/session.php';
require_once 'include/function.php';

if(isset($_POST['submit'])){

$username=mysqli_real_escape_string($connection,$_POST['username']);
$password=mysqli_real_escape_string($connection,$_POST['password']);


if(!empty($username) && !empty($password)){

$query="SELECT * FROM registration WHERE username='$username' AND password='$password' ";
$result=mysqli_query($connection,$query);

if($result){

if(mysqli_num_rows($result)==0){


$_SESSION['errorMessage']='Invalid Username/Password';
redirect("login.php");

}elseif(mysqli_num_rows($result)==1){

$row=mysqli_fetch_all($result,MYSQLI_ASSOC);

foreach ($row as $key) 

{
  $adminid= $key['id'];
  $datetime= $key['datetime'];
  $adminusername= $key['username'];
  $adminaddedby= $key['addedby'];
}

$_SESSION['id']=$adminid;

$_SESSION['user']=$adminusername;
$_SESSION['addedby']=$adminaddedby;


$_SESSION['successMessage']='Welcome '.$_SESSION['user'];
redirect("dashboard.php");


}



}



}else{

$_SESSION['errorMessage']='All Fields Required';
redirect("login.php");

}


}

 ?>


<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/adminstyle.css">
	

	

</head>
<body style="background-color: white">

<div style="height: 10px; background-color: lightblue"></div>
 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
 
 <div class="container-fluid">
   
    <div class="navbar-header">
         <a class="navbar-brand" href="blog.php">
             Tariqul Amin
         </a>
     </div>
     
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> 
     
     <div class="collapse navbar-collapse" id="navbarToggler">
    

     </div>

</div>   

</nav>
<div style="height: 10px; background-color: lightblue"></div>    

     
    <div class="container-fluid">
    	<div class="row">
    		
    		
    		
    		<div class="col-sm-12">
               
                
                <div class="row">
                <div class="col-sm-5 m-auto"> 
                 <div><?php echo successmessage(); echo dangermessage(); ?></div>
                 <br><br>
                 <h1>Login</h1>   
                
                <form action="login.php" method="POST">
                    
                    <div class="form-group">
                      <label class="text-info font-weight-bold">Username</label>
                      
                      <div class="input-group input-group-lg">
                        
                         <div class="input-group-prepend">
                          <span class="input-group-text text-info" id="basic-addon1">
                            <i class="fas fa-at"></i>
                          </span>
                        </div>
                        <input class="form-control"  ype="text" name="username" id="username" placeholder="Username">
                       </div>
                       
                       </div>
                    
                    <div class="form-group">
                        <label class="text-info font-weight-bold">Password</label>
                        
                        <div class="input-group input-group-lg">
                          <div class="input-group-prepend">
                          <span class="input-group-text text-info" id="basic-addon1">
                            <i class="fa fa-lock"></i>
                          </span>
                        </div>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                     
                    <input class="btn btn-block btn-info" type="submit" name="submit" value="Login">
                    
                </form>
    			
                </div>

                </div>

                
                </div>

    		
            </div>
    	</div>
    </div>

  
	
<script src="js/jquery-3.3.1.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>