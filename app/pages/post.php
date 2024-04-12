<?php 
    session_start(); 
    include __DIR__ . '/../core/init.php';
    

    $slug = $_GET['slug'];

    if($_SESSION['USER']){
      $user_image = $_SESSION['USER']['image'];
      $user_id = $_SESSION['USER']['id'];
      $query = "INSERT INTO post_views (post_title,user_id) VALUES (:post_title,:user_id)";
      query($query, ['post_title' => $slug, 'user_id' => $user_id]);

    }


    $url = $_SERVER['REQUEST_URI'];
    $url = explode("/",$url);
    trackPageViews($url[4]);    


    $query = "SELECT id from posts where slug=:slug limit 1";
    $row = query_row($query, ['slug' => $slug]);

    $post_id = $row['id'];

    if(!empty($_POST)){
      $comment = $_POST['comment'];
      $query = "INSERT into comments (comment,post_id,user_id) values (:comment, :post_id, :user_id)";
      query($query, ['user_id' => $user_id, 'post_id' => $post_id, 'comment' => $comment]);
    
      
      $query = "INSERT INTO commentData (post_title) VALUES (:post_title)";
      query($query, ['post_title' => $slug]);
    
    }





     
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
      
              <?php if($_SESSION['USER']){ ?>
              <div class="dropdown text-end">
              <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                         aria-expanded="false">
                     
                          <img src="<?=ROOT?>pages/<?=$user_image?>"  alt="mdo" width="32" height="32"
                               class="rounded-circle">
                      </a>
                <ul class="dropdown-menu text-small">
                <?php if($_SESSION['USER']['role'] == 'admin'){?>
                   <li><a class="dropdown-item" href="<?=ROOT?>pages/admin.php">Admin</a></li>
                <?php } ?>   
                  <li><a class="dropdown-item" href="<?=ROOT?>pages/settings.php">Settings</a></li>
                  <li><a class="dropdown-item" href="<?=ROOT?>pages/commentHistory.php">Comment History</a></li>

                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#" onclick="confirmSignOut()">Sign out</a></li>
                </ul>
              </div>
              <?php } ?>
            </div>
          </div>
        </header>


        <div id="confirmationModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Are you sure you want to sign out?</p>
        <div class="text-center">
        
          <button id="yesButton" class="btn btn-danger" onclick="signOut()">Yes</button>
          <button id="noButton" class="btn btn-secondary ms-2" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
      
      
      
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


 <div class="row my-2">
  
        <?php 
          $row = null;
          
          if ($slug) {
            $query = "select * from posts join categories on posts.category_id= categories.id where posts.slug=:slug limit 1";
            $row = query_row($query,['slug'=>$slug]);     
          }
          if(!empty($row)){ 
            $user_id = $row['user_id'];
            $query_2 = "select users.username from users where id=:id limit 1";
            $row2 = query_row($query_2, ['id' => $row['user_id']]);
            include 'includes/post-single.php';      
         }else{
            echo "No items found";
          }
          


        ?>

    <form method="POST" id="comment_form"> <!-- this is the form to post comments-->
    
      <!-- <div class="form-row align-items-center">
          <div class="col-auto">
              <div class="form-group">
                  <input type="text" name="comment" id="comment" class="form-control form-control-sm" placeholder="Enter Comment">
              </div>
          </div>
          <div class="col-auto">
              <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </div> -->
            <div class="container mt-5">
              <div class="row">
                  <div class="col-md-8 offset-md-2"> 
                      <form method="POST" id="comment_form" class="form-inline">
                          <div class="form-group">
                              <label for="commentInput" class="mr-2">Comments</label>
                              <input type="text" name="comment" id="comment" class="form-control" style="width: 100%;" placeholder="Enter Comment"> <!-- Adjusted input width -->
                          </div>
                          <button type="submit" name="submit-button" class="btn btn-dark mt-2" onclick="registerComment()">Submit</button>
                      </form>
                  </div>
              </div>
          </div>


    </form>

    <div id="display_comments" class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- This is to display the comments -->
            <?php 
            $query = "SELECT comments.*, users.username from comments join users on comments.user_id = users.id where post_id=:post_id";
            $rows = query($query,['post_id'=>$post_id]);
            if(!empty($rows)){
                foreach ($rows as $row) { ?>
                    <div class="form-group m-1" style= "border: 2px solid gray;  border-radius: 4px">
                        
                        <h7 style = "color: gray">@<?=$row['username']?></h7>
                        <h6 ><?=$row['comment']?></h6>
                    </div>
                <?php }
            }?>
        </div>
    </div>
</div>


      <div id="newest"></div>

   

  </div>
</main>


    <script src="<?=ROOT?>public/assets/bootstrap/js/bootstrap.bundle.min.js">
  
  
  
  
    </script>
   
   <script>


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
      let post_id = <?php echo $post_id;?>;
      let user_id = <?php echo $user_id;?>

      

      let last_date = formatDateTime(new Date());
        function fetchComments() {
            $.ajax({
              url: 'check_comments.php',
                method: 'GET', // Change the request type to GET
                data: {
                    post_id:post_id,
                    last_date:last_date,
                    user_id:user_id
                    // Pass the post_id as a query parameter
                },
                success: function(response) {
                    // Handle success response
                    console.log('Comments fetched successfully:', response);
            
                    response.forEach(function(comment) {
                  

                    $('#newest').append('<div class="form-group m-1" style= "border: 2px solid gray;  border-radius: 4px"> <h7 style="color:gray">@' + comment.username+  '</h7><h6>' + comment.comment + '</h6>' + '</div>'); //make these comments look better
                });
                  
         
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error fetching comments:', error);
                }
            });
            last_date = formatDateTime(new Date());

        }
        // Fetch comments initially when the document is ready
  
        // Set interval to fetch comments every 4 seconds
        setInterval(fetchComments, 10000); // 4000 milliseconds = 4 seconds
    });


    

     </script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>

    function confirmSignOut() {

      $('#confirmationModal').modal('show');
    }


    function signOut() {

      window.location.href = '<?=ROOT?>pages/logout.php';
    }
    </script>
  
  
  
  </body>
</html>
