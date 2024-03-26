<?php
include __DIR__ . '/../core/init.php';

  if(!empty($_POST)){
    $errors = [];


    if(empty($_POST['username'])){
      $errors['username'] = "A username is required";
    }else if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
        $errors['username'] = "A username has to be just letters";
    }
  

    if(empty($_POST['password'])){
      $errors['password'] = 'A password is required';
    }else if(strlen($_POST['password']) < 8){
      $errors['password'] = "Password needs to be 8 or more characters";
    }else if($_POST['password'] !== $_POST['retype_password']){
      $errors['password'] = "Passwords do not match";
    }


    $query = "select id from users where email = :email limit 1";// full colons means provided later
    $email = query($query, ['email'=>$_POST['email']]); // could use $_POST['email'] if i did email = ? in query
    // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page

    if(empty($_POST['email'])){
      $errors['email'] = 'A email is required';
    }else if($email){
        $errors['email'] = "That email is already in use";
    }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $errors['email'] = "Not a valid email";

    }

  if(empty($_POST['terms'])){
    $errors['terms'] = 'Please Accept the Terms';
  }

  echo $_POST['password']."<br>". $_POST['retype_password'];


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
              // resize_image($destination);
              
              // resize_image($destination);
          }

    if(empty($errors)){
      $data = [];
      $data['username'] = $_POST['username'];
      $data['email'] = $_POST['email'];
      $data['role'] = $_POST['role'];
      $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
     
      $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";// full colons means provided later
    
      if(!empty($destination))
      {
        $data['image'] = $destination;
        $query = "insert into users (username,email,password,role,image) values (:username,:email,:password,:role,:image)";
      }
      

      query($query, $data);
      redirect_login();

      
    }
  }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
   
    <title>Signin Template · Bootstrap v5.2</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    

<link href="<?=ROOT?>public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?=ROOT?>public/assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form method="post" enctype="multipart/form-data">
   
   
    <h1 class="h3 mb-3 fw-normal">Create account</h1>

  <?php if(!empty($errors)){ ?>
    <div class="alert alert-danger">
      Please fix the errors below
    </div>
  <?php  }?>




       <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 2px solid gray;  border-radius: 4px">                  </div>
                    <input onchange="display_image_edit(this.files[0])" type="file" name="image">
                 </label>

             
         
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }

                  </script>
            </div>


    <div class="form-floating">
      <input value="<?php echo old_value('username')?>" name="username" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
      <label for="floatingInput">Username</label>
    </div>

    <?php if(!empty($errors['username'])){ ?>
      <div class="text-danger">
          <?php echo $errors['username'];?>
      </div>
      <?php }?>


    <div class="form-floating">
      <input value="<?php echo old_value('email')?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <?php if(!empty($errors['email'])){ ?>
      <div class="text-danger">
          <?php echo $errors['email'];?>
      </div>
      <?php }?>

    <div class="form-floating">
      <input value="<?php echo old_value('password')?>"  name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <?php if(!empty($errors['password'])){ ?>
      <div class="text-danger">
          <?php echo $errors['password'];?>
      </div>
      <?php }?>


    <div class="form-floating">
      <input value="<?php echo old_value('retype_password')?>"  name="retype_password" type="password" class="form-control" id="floatingPassword" placeholder="Retype Password">
      <label for="floatingPassword">Retype Password</label>
    </div>

    <div class="form-floating mb-2">
        <select name="role" class="form-select">
              <option value="user">User</option>
              <option value="admin">Admin</option>
          </select>
        <label for="form-select">Role</label>
      </div>


    <div class="my-2">
      Already have an account? <a href="<?=ROOT?>pages/login.php">Login here</a>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input <?php echo old_checked('terms')?> name="terms" type="checkbox" value="remember-me"> Accept terms and conditions
      </label>
    </div>

    <?php if(!empty($errors['terms'])){ ?>
      <div class="text-danger">
          <?php echo $errors['terms'];?>
      </div>
      <?php }?>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Create</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?= date("Y")?></p>
  </form>
</main>


    
  </body>
</html>