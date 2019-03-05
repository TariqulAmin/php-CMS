<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

if(!loggedin()){

$_SESSION['errorMessage']='Login Required';
redirect('login.php');

}
?>

<?php


if(isset($_POST['submit'])){

    $title=mysqli_real_escape_string($connection,$_POST['title']);
    $category=mysqli_real_escape_string($connection,$_POST['category']);
    $post=mysqli_real_escape_string($connection,$_POST['post']);

    date_default_timezone_set("Asia/Dhaka");
    $time=date("d M Y h:i:sa");

    $admin=$_SESSION['user'];

    $image=$_FILES["image"]["name"];
    $target="upload/".basename($_FILES["image"]["name"]);

if(!empty($title)){

if(strlen($title)<2){

$_SESSION['errorMessage']='Title Should Be ATleast 2 Characters';
redirect("addnewpost.php");

}

else{

$postquery="INSERT INTO admin_panel(datetime,title,category,author,image,post) 
        VALUES('$time','$title','$category','$admin','$image','$post') ";

$execute=mysqli_query($connection,$postquery);
move_uploaded_file($_FILES['image']['tmp_name'],$target);
 
if($execute){

$_SESSION['successMessage']='Post Added Successfully';
redirect("dashboard.php");


}else{

$_SESSION['errorMessage']='Something Went Wrong';
redirect("addnewpost.php");

}      
}    

}else{

$_SESSION['errorMessage']='Title Can Not Be Empty';
redirect("addnewpost.php");
}

}

 ?>


<html>
<head>
	<title>Add New Post</title>
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
                    <li class="nav-item"><a  class="nav-link active" href="addnewpost.php"><i class="fas fa-edit"></i> Add New Post</a></li>
                    <li class="nav-item"><a  class="nav-link" href="categories.php"><i class="fas fa-th-list"></i> Catagories</a></li>
                    <li class="nav-item"><a  class="nav-link" href="#"><i class="fas fa-user-tie"></i> Manage Admins</a></li>
                    <li class="nav-item"><a  class="nav-link" href="comments.php"><i class="far fa-comments"></i> Comments</a></li>
                    <li class="nav-item"><a  class="nav-link " href="#"><i class="fab fa-blogger"></i> Live Blog</a></li>
                    <li class="nav-item"><a  class="nav-link " href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
    		</div>
    		
    		<div class="col-sm-10">
                <div><?php echo successmessage(); echo dangermessage(); ?> </div>
    			<h1>Add New Post</h1>
                
                
                <div class="row">
                <div class="col-sm-6">    
                
                <form action="addnewpost.php" method="POST" enctype="multipart/form-data">
                    
                <div class="form-group">
                    <label class="text-info font-weight-bold">Title:</label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label class="text-info font-weight-bold">Category:</label>
                    <select class="form-control" id="category" name="category">
                    <?php 

                     $query="SELECT * FROM category ORDER BY datetime DESC";
                     $result=mysqli_query($connection,$query);
                     $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                     
                     
                     foreach ($row as $key) {
                         
                      $categoryname=$key['name']; ?>

                      <option><?php echo $categoryname  ?></option>
                         
                     <?php  } ?>   
                        
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-info font-weight-bold">Select Image:</label>
                    <input class="form-control" type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label class="text-info font-weight-bold">Post:</label>
                    <textarea class="form-control" name="post" id="post"></textarea>
                </div>
                    <input class="btn btn-success" type="submit" name="submit" value="Add New Post">
                    
                </form>
    			
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