<?php 

include 'include/dbconnection.php';
include 'include/session.php';
include 'include/function.php';

?>



<html>
<head>
	<title>Blog Page</title>
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

        if(isset($_GET['searchButton'])){

            $search=$_GET['search'];
            $query="SELECT * FROM admin_panel WHERE 
            datetime LIKE '%$search%' OR
            category LIKE '%$search%' OR
            post LIKE '%$search%' OR
            title LIKE '%$search%' ORDER BY id DESC";
        
        }elseif(isset($_GET['category'])){

            $category=$_GET['category'];
            $query="SELECT * FROM admin_panel WHERE 
            category ='$category' ORDER BY id DESC";
           
        
        }elseif(isset($_GET['page'])){
             
             $page=$_GET['page'];

             
            
             $showpage=($page*3)-3;
             
               if($showpage<0 || $showpage===''){
                   
                   $query="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 0,3";
                
                }else{
                     
                    $query="SELECT * FROM admin_panel ORDER BY id DESC LIMIT $showpage,3";

                }
               
             



        }else{



         $query="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 3";

         }

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
                 <p class="post"><?php 
                  
                  if(strlen($post)>150){
                     
                     $post=substr($post,0,150);

                  }
                     
                 echo $post.'....' ?></p>
             </div>
              <div>
              <?php 
             
              $query="SELECT * FROM comments WHERE admin_panel_id='$id' AND status='on' ";
              $result=mysqli_query($connection,$query);

              $commentno=mysqli_num_rows($result);
              ?>

             <p class="badge badge-success"> <?php echo $commentno ?> Comments</p>

             </div>
             <a class="btn btn-info" href="fullpost.php?id=<?php echo $id ?>">Read More</a>

            </div>

          

         <?php } ?>

        <ul class="pagination justify-content-center">

        <?php 
          
          if(isset($page)){
          if(($page)>1){
          ?> 
          <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo ($page-1) ?>">Previous</a></li>
          
          
          <?php } } ?>
          
          
        <?php 

        $query="SELECT * FROM admin_panel";
        $execute=mysqli_query($connection,$query);

        
        $postno=mysqli_num_rows($execute);

        $pageno=ceil($postno/3);

        for ($i=1; $i <=$pageno ; $i++){
        
        if(isset($page)){
        if($i==$page){  

         ?>
           
            
           <li class="page-item active"> <a class="page-link" href="blog.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
          
           <?php }else{ ?>

           <li class="page-item"> <a class="page-link" href="blog.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
          
           


           <?php  } } } ?>

        <?php 
          
          if(isset($page)){ 
          if($page < $pageno){
         ?>

       <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo ($page+1) ?>">Next</a></li>


         <?php } } ?>   
       </ul>    
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

              $query="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 0,5";

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
               <a class="list-group-item list-group-item-action" href="fullpost.php?id=<?php echo $id ?> " target="_blank">
                 <div class="row">
                   <div class="col-5">
             <img style="height:50px; ; width:70px " class="" src="upload/<?php echo $image ?>">
                   
                   </div>
                   <div class="col-7">
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


    
<div class="footer">
<br>	
<p>Theme by | Tariqul Amin  | &copy; 2018 -- All Rights Reserved</p>

</div>
<div style="height: 10px; background-color: lightblue"></div>    
	
<script src="js/jquery-3.3.1.min.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>