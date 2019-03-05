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

    $title=mysqli_real_escape_string($connection,$_POST['title']);
    $category=mysqli_real_escape_string($connection,$_POST['category']);
    $post=mysqli_real_escape_string($connection,$_POST['post']);

    date_default_timezone_set("Asia/Dhaka");
    $time=date("d M Y h:i:sa");

    $admin="Tariqul Amin";

    $image=$_FILES["image"]["name"];
    $target="upload/".basename($_FILES["image"]["name"]);


$deleteid=$_GET['delete'];
$deletequery="DELETE FROM admin_panel WHERE id='$deleteid' ";

$execute=mysqli_query($connection,$deletequery);
move_uploaded_file($_FILES['image']['tmp_name'],$target);
 
if($execute){

$_SESSION['successMessage']='Post Deleted Successfully';
redirect("dashboard.php");


}else{

$_SESSION['errorMessage']='Something Went Wrong';
redirect("deletepost.php");

}      
}

 ?>


<html>
<head>
	<title>Delete Post</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>

    <div class="container-fluid">
    	<div class="row">
    		
    		<div class="col-sm-2 mt-5">
    			

    			<ul id="side-bar" class="nav nav-pills flex-column">
    				<li class="nav-item"><a  class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
    				<li class="nav-item"><a  class="nav-link  active" href="addnewpost.php"><i class="fas fa-edit"></i> Add New Post</a></li>
    				<li class="nav-item"><a  class="nav-link " href="categories.php"><i class="fas fa-th-list"></i> Catagories</a></li>
    				<li class="nav-item"><a  class="nav-link" href="#"><i class="fas fa-user-tie"></i> Manage Admins</a></li>
    				<li class="nav-item"><a  class="nav-link" href="#"><i class="far fa-comments"></i> Comments</a></li>
    				<li class="nav-item"><a  class="nav-link " href="#"><i class="fab fa-blogger"></i> Live Blog</a></li>
    				<li class="nav-item"><a  class="nav-link " href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
    		</div>
    		
    		<div class="col-sm-10">
    			<h1>Delete Post</h1>
                <div><?php echo successmessage(); echo dangermessage(); ?> </div>
                
                <div class="row">
                <div class="col-sm-6">

                <?php 

                    $id=$_GET['delete'];
                    $query="SELECT * FROM admin_panel WHERE id=$id ";
                    $result=mysqli_query($connection,$query);

                    $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                    foreach ($row as $key) 

                     {
                         
                         
                         $titleupdate=$key['title'];
                         $categoryupdate=$key['category'];
                         
                         $imageupdate=$key['image'];
                         $postupdate=$key['post'];
                    }   
                    

                    ?>    
                
                <form action="deletepost.php?delete=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                    
                <div class="form-group">
                    <label class="text-info font-weight-bold">Title:</label>
                    <input disabled class="form-control" type="text" name="title" id="title" value="<?php echo $titleupdate ?>">
                </div>
                <div class="form-group">
                    <span class="text-danger">Existing Category: <?php echo $categoryupdate ?>  </span><br>
                    <label class="text-info font-weight-bold">Category:</label>
                    <select disabled class="form-control" id="category" name="category">
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
                    <span class="text-danger">Existing Image: <img style="height: 300px;" src="upload/<?php echo $imageupdate ?>">  </span><br>
                    <label class="text-info font-weight-bold">Select Image:</label>
                    <input disabled class="form-control" type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label class="text-info font-weight-bold">Post:</label>
                    <textarea disabled class="form-control" name="post" id="post" ><?php echo $postupdate ?></textarea>
                </div>
                    <input class="btn btn-block btn-danger" type="submit" name="submit" value="Delete Post">
                    
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