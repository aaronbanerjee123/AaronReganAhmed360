<?php 

// session_start();


include __DIR__ . '/../core/init.php';
if(session_status() == PHP_SESSION_ACTIVE){
    if($_SESSION['USER']){
        $user_image = $_SESSION['USER']['image'];
      
      
      }
      
          if(!$_SESSION['USER']){
              redirect_login();
          }
          
          $query = "select * from categories";
          $rows = query($query, []);
          $user_image = $_SESSION['USER']['image'];
      
          if(!empty($_POST)) {
              $errors = [];
          
              if(empty($_POST['title'])) {
                  $errors['title'] = "A title is required";
              }
            
              if(empty($_POST['content'])) {
                  $errors['content'] = 'Content required';
              }
          
              $allowed = ['image/jpeg', 'image/png', 'image/webp'];
              if(!empty($_FILES['image']['name'])) {
                  $destination = "";
                  if(!in_array($_FILES['image']['type'], $allowed)) {
                      $errors['image'] = "Image format not supported";
                  } else {
                      $folder =   "uploads/";
                      if(!file_exists($folder)) {
                          mkdir($folder, 0777, true);
                      }
                      $destination = $folder . $_FILES['image']['name'];
                      move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                  }
              } else {
                  $errors['image'] = 'Post needs an image';
              }
        
              $slug = str_to_url($_POST['title']);
        
              if(empty($errors)) {
                  $data = [];
                  $data['title'] = $_POST['title'];
                  $data['content'] = $_POST['content'];
                  $data['slug'] = str_to_url($_POST['title']);
                  $data['category_id'] = $_POST['category_id'];
                  $data['user_id'] = user('id');
                  $data['image'] = $destination;
                  $query = "insert into posts (title, content, category_id, slug, user_id, image) values (:title, :content, :category_id, :slug, :user_id, :image)";
                  query($query, $data);
                  redirect_home();
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
    <title>Add New Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                      
            <li><a href="<?=ROOT?>pages/login" class="nav-link px-2 link-gray">Login</a></li>

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
            <li><a class="dropdown-item" href="<?=ROOT?>pages/admin.php">Admin</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>pages/settings.php">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=ROOT?>pages/logout.php">Sign out</a></li>
          </ul>
        </div>
        <?php } ?>
      </div>
    </div>
  </header>


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

    <div class="container text-center">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h1>Add a New Blog</h1>

                <div class="my-2">
                    Featured Image: <br>
                    <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="../public/assets/images/addimage.png" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid lightgray; border-radius: 10px;">
                        <div style="text-align: center;">
                            <input onchange="display_image_edit(this.files[0])" type="file" name="image" style="margin-top: 10px;">
                        </div>
                    </label>

                    <script>
                        function display_image_edit(file) {
                            document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
                        }
                    </script>
                </div>

                <?php if(!empty($errors['image'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['image']?>
                    </div>
                <?php endif; ?>

                <div class="form-group my-3">
                    <label for="titleFormControlInput1">Title</label>
                    <input type="text" class="form-control" id="titleFormControlInput1" value="<?=old_value('title')?>" name="title" placeholder="Enter title">
                </div>

                <?php if(!empty($errors['title'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['title']?>
                    </div>
                <?php endif; ?>

                <div class="form-group my-3">
                    <label for="exampleFormControlSelect1">Select the category</label>
                    <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                        <?php foreach($rows as $row): ?>
                            <option value="<?=$row['id']?>"><?=$row['category']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group my-3">
                    <label for="contentArea">Content</label>
                    <textarea class="form-control" name="content" value="<?=old_value('content')?>" id="contentArea" rows="3"></textarea>
                </div>

                <?php if(!empty($errors['content'])): ?>
                    <div class="alert alert-danger">
                        <?=$errors['content']?>
                    </div>
                <?php endif; ?>

                <button type="submit" data-role="update" class="btn btn-dark my-3">Submit</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('button[data-role=update]').on('click', function() {
                alert('hello');
            });
        });
    </script>
</body>
</html>
