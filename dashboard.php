<?php 
require_once 'include/dbconnection.php';
require_once 'include/session.php';
require_once 'include/function.php';

?>
<?php  

if(!loggedin()){

$_SESSION['errorMessage']='Login Required';
redirect('login.php');

}
?>


<html>
<head>
	<title>Admin Dashboard</title>
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
    				<li class="nav-item"><a  class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
    				<li class="nav-item"><a  class="nav-link " href="addnewpost.php"><i class="fas fa-edit"></i> Add New Post</a></li>
    				<li class="nav-item"><a  class="nav-link" href="categories.php"><i class="fas fa-th-list"></i> Catagories</a></li>
    				<li class="nav-item"><a  class="nav-link" href="admins.php"><i class="fas fa-user-tie"></i> Manage Admins</a></li>
    				<li class="nav-item">

                                      <?php 

                                          $querycomment="SELECT status FROM comments WHERE status='off'";
                                          $result=mysqli_query($connection,$querycomment);
                                          $rownum=mysqli_num_rows($result);
                                          

                                  
                                          

                                        ?>
              <a  class="nav-link" href="comments.php"><i class="far fa-comments"></i>Comments <span class="badge badge-warning ml-3"><?php echo $rownum ?></span></a>
            </li>
    				<li class="nav-item"><a  class="nav-link " href="blog.php?page=1" target="_blank"><i class="fab fa-blogger"></i> Live Blog</a></li>
    				<li class="nav-item"><a  class="nav-link " href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
    		</div>
    		
    		<div class="col-sm-10">
                <div><?php echo successmessage(); echo dangermessage(); ?></div>

    			<h1 class="mt-2">Admin Dashboard</h1>
                   <div>
                       <table class="table table-striped table-bordered table-hover">
                           <thead>
                               <tr>
                                   <th>NO</th>
                                   <th>Post Title</th>
                                   <th>Date & Time</th>
                                   <th>Author</th>
                                   <th>Category</th>
                                   <th>Banner</th>
                                   <th>Comments</th>
                                   <th>Action</th>
                                   <th>Details</th>
                               </tr>
                           </thead>

                           <?php 
                            $query="SELECT * FROM admin_panel ORDER BY id DESC";
                            $result=mysqli_query($connection,$query);
                            $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                            $id=1; 
                            foreach ($row as $key)
                            

                            {
                                 $realid=$key['id'];
                                 $datetime=$key['datetime'];
                                 $title=$key['title'];
                                 $category=$key['category'];
                                 $admin=$key['author'];
                                 $image=$key['image'];
                                 $post=$key['post'];

                             ?>

                             <tbody>
                                 <tr>
                                     <td><?php echo $id ?></td>
                                     <td class="text-info"><?php 
                                      if(strlen($title)>9){

                                        $title=substr($title,0,9);
                                        $title=$title.'..';
                                      }

                                     echo $title ?></td>
                                     
                                     <td><?php 
                                      if(strlen($datetime)>11){

                                        $datetime=substr($datetime,0,11);
                                        
                                      }

                                     echo $datetime ?></td>
                                     <td><?php echo $admin ?></td>
                                     <td><?php echo $category?></td>
                                     <td> <img style="height:50px; width: 80px" src="upload/<?php echo $image ?>"> </td>
                                     <td>
                                       <?php 

                                          $querycomment="SELECT status FROM comments WHERE status='off' AND admin_panel_id='$realid' ";
                                          $result=mysqli_query($connection,$querycomment);
                                          $rownumoff=mysqli_num_rows($result);
                                          

                                          $querycomment="SELECT status FROM comments WHERE status='on' AND admin_panel_id='$realid'";
                                          $result=mysqli_query($connection,$querycomment);
                                          $rownumon=mysqli_num_rows($result);
                                          

                                        ?>

                                     <span class="badge badge-danger"><?php echo $rownumoff ?></span>
                                     <span class="badge badge-success ml-4"><?php echo $rownumon ?></span>    

                                     </td>
                                     <td>
                                        
                                        <a class="btn btn-primary" href="editpost.php?edit=<?php echo $realid ?>">Edit</a>
                                        <a class="btn btn-danger" href="deletepost.php?delete=<?php echo $realid ?>">Delete</a>

                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="fullpost.php?id=<?php echo $realid ?>" target="_blank">Live Preview</a>
                                    </td>
                                 </tr>
                             </tbody>
                             

                             <?php  $id++;  } ?>    
                            
                       </table>

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