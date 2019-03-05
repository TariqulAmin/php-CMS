<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

?>

<?php  

if(!loggedin()){

$_SESSION['errorMessage']='Login Required';
redirect('login.php');

}
?>

<?php 

if(isset($_POST['submit'])){

$username=mysqli_real_escape_string($connection,$_POST['username']);
$password=mysqli_real_escape_string($connection,$_POST['password']);
$confirmpassword=mysqli_real_escape_string($connection,$_POST['confirmpassword']);
date_default_timezone_set("Asia/Dhaka");
$time=date("d M Y h:i:sa");
$admin=$_SESSION['user'];

if(!empty($username) && !empty($password) && !empty($confirmpassword)){

    if(strlen($password)<6){
    $_SESSION['errorMessage']='Password Needs To Be Greater Than 6 Character';
    redirect("admins.php");
    }else{
       
           if($password !== $confirmpassword){
               
                $_SESSION['errorMessage']='Password Does Not Match';
                redirect("admins.php");


           }else{
              
              $query="INSERT INTO registration (datetime,username,password,addedby) 
              VALUES('$time','$username','$password','$admin') ";
              $execute=mysqli_query($connection,$query);


              if($execute){



              $_SESSION['successMessage']='New Admin Added Successfully';
              redirect("admins.php");


              }else{

              $_SESSION['errorMessage']='Admin Failed To Add';
              redirect("admins.php");


              }

           }

    }


}else{

$_SESSION['errorMessage']='All Fields Required';
redirect("admins.php");

}


}

 ?>


<html>
<head>
	<title>Manage Admins</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/adminstyle.css">
	

	

</head>
<body>

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
    <ul class="navbar-nav">
        <li class="nav-item ">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="blog.php" target="_blank">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Feature</a>
        </li>
  </ul>

  <form id="searchbar" class="form-inline" action="blog.php" method="GET">
   
       
       <input class="form-control" type="text" placeholder="Search" name="search">

   
   <button class="btn btn-info mx-2" type="submit" name="searchButton">Search</button>
      
  </form>
</div>

</div>   

</nav>
<div style="height: 10px; background-color: lightblue"></div>    


    <div class="container-fluid">
    	<div class="row">
    		
    		<div class="col-sm-2 mt-5">
    			

    			<ul id="side-bar" class="nav nav-pills flex-column">
                    <li class="nav-item"><a  class="nav-link " href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="nav-item"><a  class="nav-link " href="addnewpost.php"><i class="fas fa-edit"></i> Add New Post</a></li>
                    <li class="nav-item"><a  class="nav-link" href="categories.php"><i class="fas fa-th-list"></i> Catagories</a></li>
                    <li class="nav-item"><a  class="nav-link  active" href="admins.php"><i class="fas fa-user-tie"></i> Manage Admins</a></li>
                    <li class="nav-item"><a  class="nav-link" href="comments.php"><i class="far fa-comments"></i> Comments</a></li>
                    <li class="nav-item"><a  class="nav-link " href="#"><i class="fab fa-blogger"></i> Live Blog</a></li>
                    <li class="nav-item"><a  class="nav-link " href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
    		</div>
    		
    		<div class="col-sm-10">
                <div><?php echo successmessage(); echo dangermessage(); ?></div>
    			<h1>Manage Admin Access</h1>
                
                <div class="row">
                <div class="col-sm-6">    
                
                <form action="admins.php" method="POST">
                    <div class="form-group">
                        <label class="text-info font-weight-bold">Username</label>
                        <input class="form-control"  ype="text" name="username" id="username" placeholder="Username">
                    </div>
                     <div class="form-group">
                        <label class="text-info font-weight-bold">Password</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                    </div>
                     <div class="form-group">
                        <label class="text-info font-weight-bold">Confirm Password</label>
                        <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Retype Password">
                    </div>
                    <input class="btn btn-success" type="submit" name="submit" value="Register Admin">
                    
                </form>
    			
                </div>

                </div>


                <div class="row">
                <div class="col-sm-12">
                <div class="table-responsive-sm">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Date Time.</th>
                            <th>Username Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php 

                     $query="SELECT * FROM registration ORDER BY id DESC";
                     $result=mysqli_query($connection,$query);
                     $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                     
                     $id=1;
                     foreach ($row as $key) {
                         
                         $adminid=$key['id'];
                         $datetime=$key['datetime'];
                         $username=$key['username'];
                         $addedby=$key['addedby'];

                    ?>
                    
                    <tbody>
                        
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $datetime ?></td>
                            <td><?php echo $username ?></td>
                            <td><?php echo $addedby ?></td>
                            <th><a class="btn btn-danger" href="admindelete.php?id=<?php echo $adminid ?>">Delete</a></th>
                        </tr>
                    </tbody>

                    <?php 

                    $id++;
 
                       }
                       
                     ?>
                </table>
                    
                </div>
                </div>
                </div>
                
                </div>

    		
            </div>
    	</div>
    </div>

<div class="footer">
<br>	
<p>Theme by | Tariqul Amin  | &copy; 2018 -- All Rights Reserved</p>

</div>
<div style="height: 10px; background-color: lightblue"></div>    
	
<script src="js/jquery-3.3.1.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>