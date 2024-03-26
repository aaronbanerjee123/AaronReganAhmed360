<?php 

session_start();

include __DIR__ . '/../core/init.php';

if(session_status() == PHP_SESSION_ACTIVE){
if($_SESSION['USER']){
  $user_image = $_SESSION['USER']['image'];


}

    $user_image= $_SESSION['USER']['image'];

 $id = $_GET['id'];
 $query = "select * from posts where id =:id limit 1";
 $row = query_row($query,['id' => $id]);
 if(!empty($_POST)){
   if($row){

   $errors = [];

   if(empty($_POST['title'])){
     $errors['title'] = "A username is required";
   }
 
   if(empty($_POST['content'])){
     $errors['content'] = "Content is required";

   }


   $allowed = ['image/jpeg','image/png','image/webp'];
       if(!empty($_FILES['image']['name'])){
       
         $destination = "";
         if(!in_array($_FILES['image']['type'], $allowed))
         {
           $errors['image'] = "Image format not supported";
         }else
         // "/Applications/XAMPP/xamppfiles/htdocs/PHP-Blog/public/
           $folder = "uploads/";
           if(!file_exists($folder))
           {
             mkdir($folder, 0777, true);
           }
           $destination = $folder .$_FILES['image']['name'];
           move_uploaded_file($_FILES['image']['tmp_name'], $destination);
      
       }


   if(empty($errors)){
     $data = [];
     $data['title'] = $_POST['title'];
     $data['id'] = $id;
     $data['content'] = $_POST['content'];
     $data['category_id'] = $_POST['category_id'];

     $image_str = ",";

     if(!empty($destination)){
         $image_str = ",image = :image,";
         $data['image'] = $destination;
     }
    
     $query = "update posts set title = :title, content=:content $image_str category_id =:category_id where id = :id limit 1";// full colons means provided later  
     query($query,$data);
    
     redirect_admin_myblogs();

   }
 } 
}
}else{
  redirect_login();
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href = "../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <style>
  header{
    background-color: #7F95D1; /* Change the background color */
  }
 
  .link-gray {
    color: black;
  }

  .link-gray:hover {
    color: black;
    color: lightgray; /* Change color to black on hover */
  }

  
</style>

</head>
<body>
  

<header class="p-3  border-bottom">
    
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      
      
      <a href="<?=ROOT?>pages/home.php" class="nav-link px-2 link-dark" style="font-size: 24px;">InSightInk</a>



        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?=ROOT?>pages/myblogs.php" class="nav-link px-2 link-gray">My Blog</a></li>
          <li><a href="<?=ROOT?>pages/add.php" class="nav-link px-2 link-gray">Add Blog</a></li>
          <?php if(!$_SESSION['USER']) {?>
                      
            <li><a href="<?=ROOT?>pages/login.php" class="nav-link px-2 link-gray">Login</a></li>

            <?php } ?>
        </ul>

        <form class="row align-items-center mb-3 mb-lg-0 me-lg-3" role="search" action="<?=ROOT?>pages/search.php">
            <div class="col-md-auto">
                <input type="search" name="find" class="form-control" placeholder="Search..." aria-label="Search">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-dark">Find</button>
            </div>
        </form>

        <?php if($_SESSION['USER']){ ?>
        <div class="dropdown text-end">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                   aria-expanded="false">
               
                    <img src="<?=ROOT?>pages/<?=$user_image?>" alt="mdo" width="32" height="32"
                         class="rounded-circle">
                </a>
          <ul class="dropdown-menu text-small">
          <?php if($_SESSION['USER']['role'] == 'admin'){?>
              <li><a class="dropdown-item" href="<?=ROOT?>pages/admin.php">Admin</a></li>
             <?php } ?>   
             <li><a class="dropdown-item" href="<?=ROOT?>pages/settings.php">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=ROOT?>pages/logout.php">Sign out</a></li>
          </ul>
        </div>
        <?php } ?>
      </div>
    </div>
  </header>



  <!--slider -->
  <link rel="stylesheet" href="<?=ROOT?>public/assets/slider/ism/css/my-slider.css"/>
  <script src="<?=ROOT?>public/assets/slider/ism/js/ism-2.2.min.js"></script>
    

<div class="ism-slider" data-transition_type="fade" data-play_type="loop" id="my-slider">
  <ol>
    <li>
      <img src="<?=ROOT?>public/assets/slider/ism/image/slides/flower-729514_1280.jpg">
      <div class="<?=ROOT?>public/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>public/assets/slider/ism/image/slides/beautiful-701678_1280.jpg">
      <div class="<?=ROOT?>public/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>public/assets/slider/ism/image/slides/summer-192179_1280.jpg">
      <div class="<?=ROOT?>public/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
    <li>
      <img src="<?=ROOT?>public/assets/slider/ism/image/slides/city-690332_1280.jpg">
      <div class="<?=ROOT?>public/assets/slider/ism-caption ism-caption-0">My slide caption text</div>
    </li>
  </ol>
</div>

<div class="col-md-6 mx-auto">
                  <form method="post" enctype="multipart/form-data">
                
                
                  <h1 class="h3 mb-3 fw-normal text-center">Edit Post</h1>

              <?php if(!empty($row)):?>

                <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger">
                    Please fix the errors below
                  </div>
                <?php  }?>
                    

                <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=ROOT?>pages/<?=$row['image']?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid lightgray; border-radius: 10px;">
                    <input value="<?=ROOT?>pages/<?=$row['image']?>" type="file" name="image" onchange="display_image_edit(this.files[0])" class= " mt-4">
                  </label>
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }
                  </script>
                </div>

                  <div class="form-floating">
                    <input value="<?php echo old_value('title',$row['title'])?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="title">
                    <label for="floatingInput">title</label>
                  </div>

                  <?php if(!empty($errors['title'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['title'];?>
                    </div>
                    <?php }?>
        


                  <div class="form-floating">
                    <input value="<?php echo old_value('content',$row['content'])?>" name="content" type="content" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">content</label>
                  </div>


                  <?php if(!empty($errors['content'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['content'];?>
                    </div>
                    <?php }?>

                           

                  <?php
                    $query = "select * from categories order by id desc";
                    $categories = query($query);


                  ?>
                    

                    <div class="form-floating my-3">
                    <select name="category_id" class="form-select">


                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $category) :?>
                            <option value="<?=old_value('category_id', $category['id'])?>"><?=$category["category"]?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                        </select>
                        <label for="form-floating">Category</label>
                      </div>


                  
                  <button class="mt-4 w-30 btn btn-lg btn-success float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>pages/home.php"><button class="mt-4 w-30 btn btn-lg btn-dark " type="button">back</button>
              </a>

              <?php endif;?>
              </form>
              </div>





</body>
</html>
