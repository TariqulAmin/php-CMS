<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

if(isset($_POST['submit'])){

    $name=mysqli_real_escape_string($connection,$_POST['name']);
    $email=mysqli_real_escape_string($connection,$_POST['email']);
    $comment=mysqli_real_escape_string($connection,$_POST['comment']);

    date_default_timezone_set("Asia/Dhaka");
    $time=date("d M Y h:i:sa");
    $postid=$_GET['id'];

    

if(!empty($name) && !empty($email) && !empty($comment)){

if(strlen($comment)>500){

$_SESSION['errorMessage']='Only 500 Characters Allowed';
}

else{

$query="INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id) 
        VALUES ('$time','$name','$email','$comment','Pending','off','$postid') ";

$execute=mysqli_query($connection,$query);

 
if($execute){

$_SESSION['successMessage']='Comment Submitted Successfully';
redirect("fullpost.php?id={$postid}");


}else{

$_SESSION['errorMessage']='Comment Did Not Add';
redirect("fullpost.php?id={$postid}");

}      
}    

}else{

$_SESSION['errorMessage']='All Fields Must be Required';

}

}

 ?>



<html>
<head>
	<title>Full Blog Post</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/publicstyle.css">
	

	

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
          <a class="nav-link" href="blog.php">Blog</a>
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

<div class="container">
    
   <div class="blog-header">
    <h1>Complete Responsive CMS Blog</h1>
    <p class="lead">Complelte Blog Using Php</p>
   </div>

   <div class="row">
       <div class="col-sm-8">

        <?php 

        if(isset($_GET['id'])){

          $id=$_GET['id'];

        $query="SELECT * FROM admin_panel WHERE id=$id";

         

         $result=mysqli_query($connection,$query);

         $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
         foreach ($row as $key) 

         {
             $id=$key['id'];
             $datetime=$key['datetime'];
             $title=$key['title'];
             $category=$key['category'];
             $admin=$key['author'];
             $image=$key['image'];
             $post=$key['post'];
          ?>
         
          
            <div class="blogpost">  
             
             <img class="img-thumbnail img-responsive w-100" src="upload/<?php echo $image ?>">
             <div class="caption">
                 <h2 class="text-info font-weight-bold"><?php echo $title ?></h2>
                 <p class="text-muted font-weight-bold">Category: <?php echo $category ?> Published on: <?php echo $datetime ?></p>
                 <p class="post"><?php echo nl2br($post)?></p>
             </div>

             
            </div>

         <?php }
           } ?>
       <br><br><br>
       <h5 class="text-info">User Comment:</h5>
       <?php 

        $commentId=$_GET['id'];
        $queryComment="SELECT * FROM comments WHERE admin_panel_id='$commentId' AND status='on' ";
        $result=mysqli_query($connection,$queryComment);
        $row=mysqli_fetch_all($result,MYSQLI_ASSOC);

        foreach ($row as $key) 
        {
          $commentDate=$key['datetime'];

          $commentName=$key['name'];
          $comment=$key['comment'];

          ?>
        <div style="background-color: lightgray" class="comment">
          <div class="row">
            
            <div class="col-sm-2">
              <img class="mt-3 px-3" src="images/man.png" style="height: 70px;">
            </div>
          
          <div class="col-sm-9">
             <p class="text-info font-weight-bold"><?php echo $commentName ?></p>
             <p class="text-muted font-weight-bold"><?php echo $commentDate ?></p>
             <p class="text-muted"><?php echo $comment ?></p>
          </div>

          </div>
        </div>
        <br><br>   
        <?php } ?>

        
       <div><?php echo successmessage(); echo dangermessage(); ?> </div>
       <h3 class="text-info">Add Your Comment:</h3>
       
       <form action="fullpost.php?id=<?php echo $id ?>" method="POST">
                    
                <div class="form-group">
                    <label class="text-info font-weight-bold">Name:</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                </div>
                 <div class="form-group">
                    <label class="text-info font-weight-bold">Email:</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email">
                </div>
                
                <div class="form-group">
                    <label class="text-info font-weight-bold">Comment:</label>
                    <textarea class="form-control" name="comment" id="comment"></textarea>
                </div>
                    <input class="btn btn-primary" type="submit" name="submit" value="Comment">
                    
                </form> 
           
       </div>


       <div class="offset-sm-1 col-sm-3">
           <h2>About Me</h2>
           <img style="width: 75%;" class="img-fluid rounded-circle" src="images/beauty.jpeg">
           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
           tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
           quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
           consequat.</p>

           <div class="card">
            <div class="card-header bg-primary text-white">Recent Post</div>
            <div class="card-body">
            <ul class="list-group list-group-flush">
              
            <?php 

              $query="SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0,5";

              $result=mysqli_query($connection,$query);

              $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
              foreach ($row as $key) 

               {
                 $id=$key['id'];
                 $datetime=$key['datetime'];
                 $title=$key['title'];
                 
                 $admin=$key['author'];
                 $image=$key['image'];

                 if(strlen($datetime)>11){

                      $datetime=substr($datetime,0,11);
                 }
               ?>
               <a class="list-group-item" href="fullpost.php?id=<?php echo $id ?> " target="_blank">
                 <div class="row">
                   <div class="col-sm-5">
             <img style="height:50px; ; width:70px " class="" src="upload/<?php echo $image ?>">
                   
                   </div>
                   <div class="col-sm-7">
                     <p class="text-info font-weight-bold"><?php echo $title ?></p>
                     <p class="text-muted"><?php echo $datetime ?></p>
                   </div>

                 </div>

               </a>
               
                 
             <?php } ?>
            </ul> 
            </div> 
            <div class="card-footer"></div>
          </div>
             <br><br>
           <div class="card">
            <div class="card-header bg-primary text-white">Categories</div>
            
              <ul class="list-group list-group-flush">
               <?php 

                     $query="SELECT * FROM category ORDER BY name";
                     $result=mysqli_query($connection,$query);
                     $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
                     
                     
                     foreach ($row as $key) {
                         
                        $categoryname=$key['name'];
                      
                       ?> 

                       <a class="list-group-item list-group-item-action" href="blog.php?category=<?php echo $categoryname ?> "><?php echo $categoryname ?></a>
                    
                    <?php } ?> 

                </ul>
             
            <div class="card-footer"></div>
          </div>
      
       </div>
   </div>

</div>


<br>    
<div class="footer">
<br>	
<p>Theme by | Tariqul Amin  | &copy; 2018 -- All Rights Reserved</p>

</div>
<div style="height: 10px; background-color: lightblue"></div>    
	
<script src="js/jquery-3.3.1.min.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>