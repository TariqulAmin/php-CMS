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
            <li class="nav-item"><a  class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="nav-item"><a  class="nav-link " href="addnewpost.php"><i class="fas fa-edit"></i> Add New Post</a></li>
            <li class="nav-item"><a  class="nav-link" href="categories.php"><i class="fas fa-th-list"></i> Catagories</a></li>
            <li class="nav-item"><a  class="nav-link" href="#"><i class="fas fa-user-tie"></i> Manage Admins</a></li>
              

            <li class="nav-item">

                                      <?php 

                                          $querycomment="SELECT status FROM comments WHERE status='off'";
                                          $result=mysqli_query($connection,$querycomment);
                                          $rownum=mysqli_num_rows($result);
                                          

                                  
                                          

                                        ?>
              <a  class="nav-link active" href="comments.php"><i class="far fa-comments"></i>Comments <span class="badge badge-warning ml-3"><?php echo $rownum ?></span></a>
            </li>
            
            <li class="nav-item"><a  class="nav-link " href="#"><i class="fab fa-blogger"></i> Live Blog</a></li>
            <li class="nav-item"><a  class="nav-link " href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
    		</div>
    		
    		<div class="col-sm-10">
                <div><?php echo successmessage(); echo dangermessage(); ?></div>

    			<h2 class="mt-2">Un-Approved Comments</h2>
                   <div>
                       <table class="table table-striped table-bordered table-hover">
                           <thead>
                               <tr>
                                   <th>NO</th>
                                   <th>Name</th>
                                   <th>Date</th>
                                   <th>Comment</th>
                                   
                                   <th>Approve</th>
                                   <th>Delete Comment</th>
                                   <th>Details</th>
                               </tr>
                           </thead>

                           <?php 
                            $query="SELECT * FROM comments WHERE status='off' ORDER BY id DESC";
                            $result=mysqli_query($connection,$query);
                            $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                            $srno=1; 
                            foreach ($row as $key)
                            

                            {
                                 $commentid=$key['id'];
                                 $datetimecomment=$key['datetime'];
                                 $personname=$key['name'];
                                 $personcomment=$key['comment'];
                                 $commentedpostid=$key['admin_panel_id'];

                                

                                 if(strlen($personname)>10){

                                  $personname=substr($personname,0,10).'..';
                                 }

                            ?>

                             <tbody>
                                 <tr>
                                     
                                     <td><?php echo $srno ?></td>
                                     <td class="text-info"><?php echo $personname ?></td>
                                     
                                     <td><?php echo $datetimecomment ?></td>
                                     <td><?php echo $personcomment ?></td>
                                     <td><a class="btn btn-success" href="approve.php?id=<?php echo $commentid ?>">Approve</a></td>
                                     <td><a class="btn btn-danger" href="delete.php?id=<?php echo $commentid ?>">Delete</a></td>
                                     <td><a class="btn btn-primary" href="fullpost.php?id=<?php echo            $commentedpostid  ?>" target="_blank">Live Preview</a></td>

                                 </tr>
                             </tbody>
                             

                             <?php  $srno++;  } ?>    
                            
                       </table>

                   </div>

                   <h2 class="mt-2">Approved Comments</h2>
                   <div>
                       <table class="table table-striped table-bordered table-hover">
                           <thead>
                               <tr>
                                   <th>NO</th>
                                   <th>Name</th>
                                   <th>Date</th>
                                   <th>Comment</th>
                                   <th>Approved By</th>
                                   <th>Revert Approve</th>
                                   <th>Delete Comment</th>
                                   <th>Details</th>
                               </tr>
                           </thead>

                           <?php 
                            $query="SELECT * FROM comments WHERE status='on' ORDER BY id DESC";
                            $result=mysqli_query($connection,$query);
                            $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                            $srno=1; 
                            foreach ($row as $key)
                            

                            {
                                 $commentid=$key['id'];
                                 $datetimecomment=$key['datetime'];
                                 $personname=$key['name'];
                                 $personcomment=$key['comment'];
                                 $commentedpostid=$key['admin_panel_id'];
                                 $approvedby=$key['approvedby'];
                                

                                 if(strlen($personname)>10){

                                  $personname=substr($personname,0,10).'..';
                                 }

                            ?>

                             <tbody>
                                 <tr>
                                     
                                     <td><?php echo $srno ?></td>
                                     <td class="text-info"><?php echo $personname ?></td>
                                     
                                     <td><?php echo $datetimecomment ?></td>
                                     <td><?php echo $personcomment ?></td>
                                     <td><?php echo  $approvedby ?></td>
                                     <td><a class="btn btn-warning" href="unapprove.php?id=<?php echo $commentid ?>">Dis-Approve</a></td>
                                     <td><a class="btn btn-danger" href="delete.php?id=<?php echo $commentid ?>">Delete</a></td>
                                     <td><a class="btn btn-primary" href="fullpost.php?id=<?php echo            $commentedpostid ?>" target="_blank">Live Preview</a></td>

                                 </tr>
                             </tbody>
                             

                             <?php  $srno++;  } ?>    
                            
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