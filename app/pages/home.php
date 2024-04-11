<?php
session_start();

include __DIR__ . '/../core/init.php';

  if($_SESSION['USER']){
    $user_image = $_SESSION['USER']['image'];
  }

  $url = $_SERVER['REQUEST_URI'];
  $url = explode("/",$url);
  trackPageViews($url[5]);

 
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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

        <?php if($_SESSION['USER']['username']){ ?>
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
  <!-- end slider -->

    <main class="p-2">
        <h3 class="mx-4">Trending</h3>

 <div class="row my-2" id="blogs-container-trending">
  
        <?php 

        $query = "SELECT post_title, COUNT(*) as times_visited from post_views GROUP BY post_title ORDER by times_visited DESC LIMIT 3";
        $postData = query($query);
        
      if($postData && !empty($postData)){
       foreach($postData as $data){
         $query = "SELECT posts.*,categories.category from posts join categories on posts.category_id= categories.id and posts.slug = :slug order by posts.id desc limit 1";
         $rows= query($query,['slug' => $data['post_title']]);
         $row = $rows[0];
         include 'includes/post-card.php';

       }
      }

?>
  
  </div>
  <h3 class="mx-4">All Blogs</h3>
  <div class="row my-2" id="blogs-container">
<?php

        $query = "select posts.*,categories.category from posts join categories on posts.category_id= categories.id order by posts.id desc";
        $rows = query($query);


          if($rows){
            foreach($rows as $row){
              include 'includes/post-card.php';
            }
          }else{
            echo "No items found";
          }
          
        ?>
  </div>
    </main>
    </body>
</html>

    <script src="<?=ROOT?>public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.read-more').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            let card = button.closest('.border');
            let truncatedContent = card.querySelector('#truncatedContent');
            let fullContent = card.querySelector('.full-content');

            if (truncatedContent.style.display === 'none') {
                truncatedContent.style.display = 'block';
                fullContent.style.display = 'none';
                button.textContent = 'Read more';
            } else {
                truncatedContent.style.display = 'none';
                fullContent.style.display = 'block';
                button.textContent = 'Read less';
            }
        });
    });
});

function formatDateTime(date) {
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');
    let hours = String(date.getHours()).padStart(2, '0');
    let minutes = String(date.getMinutes()).padStart(2, '0');
    let seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

$(document).ready(function() {
    // Function to fetch updates from the server
    function checkForUpdates() {
        $.ajax({
            url: 'check_updates.php',
            method: 'GET',
            data: {
                last_date: last_date, // Pass the last timestamp to the server
          
            },
            success: function(response) {
                // Process the updates received from the server
                console.log('Updates:', response);

                response.forEach(function(blog) {
                  
                    $.ajax({
                       url: 'includes/post-card-async.php',
                      method: 'POST',
                      data: {
                            id: blog.id
                            
                        },
                        success: function(htmlResponse) {
                            // Prepend the HTML content generated by PHP to the blog container
                            $('#blogs-container').prepend(htmlResponse);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching HTML content:', error);
                        }
                    });
                });

                // Update the last timestamp to the latest one received
                last_date = formatDateTime(new Date());
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    var last_date = formatDateTime(new Date()); // Initialize last timestamp
    var id = ''; // Initialize blog ID
    // Call the function to check for updates every 5 seconds (adjust as needed)
    setInterval(checkForUpdates, 5000); // 5000 milliseconds = 5 seconds
});

   
    



 </script>

  </body>
  

</html>

