<?php 
session_start();

include __DIR__ . '/../core/init.php';

$url = $_SERVER['REQUEST_URI'];
$url = explode("/",$url);
trackPageViews($url[5]);

if(session_status() == PHP_SESSION_ACTIVE){


if($_SESSION['USER']){
  $user_image = $_SESSION['USER']['image'];

}


if(!$_SESSION['USER']){
  redirect_login();
}

    $user_id = $_SESSION['USER']['id'];
    $user_image = $_SESSION['USER']['image'];
    $query = "select posts.*, categories.category from posts join categories on posts.category_id = categories.id where user_id=:user_id";
    $rows = query($query, ['user_id'=> $user_id]);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href = "../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
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
      
      
      <a href="<?=ROOT?>/pages/home.php" class="nav-link px-2 link-dark" style="font-size: 24px;">InSightInk</a>



        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?=ROOT?>pages/myblogs.php" class="nav-link px-2 link-gray">My Blog</a></li>
          <li><a href="<?=ROOT?>pages/add.php" class="nav-link px-2 link-gray">Add Blog</a></li>
          <?php if(!$_SESSION['USER']) {?>
                      
            <li><a href="<?=ROOT?>pages/login.php" class="nav-link px-2 link-gray">Login</a></li>

            <?php } ?>
        </ul>

        <form class="row align-items-center mb-3 mb-lg-0 me-lg-3" role="search" action="<?=ROOT?>/pages/search.php">
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
            <li><a class="dropdown-item" href="<?=ROOT?>pages/commentHistory.php">Comment History</a></li>

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

    <main class="p-2">
        <h3 class="mx-4">My Blogs</h3>

      <?php if($rows): ?>
                  <div class="row">
                      <?php foreach($rows as $row): ?>
              
                              <?php include 'includes/post-card.php'; ?>
                
                      <?php endforeach; ?>
                  </div>
              <?php else: ?>
                  <div class="text-center">
                      Looks like you haven't posted anything yet
                  </div>
      <?php endif; ?>

</main>
    <script src="<?=ROOT?>public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>


