
<?php 
 
 $section = $_GET['section'] ?? 'dashboard';

 $action = $_GET['action'] ?? 'view';//add

 $id = $_GET['id'] ?? '0';
?>


<?php

if($action == 'add'){
    if(!empty($_POST)){
      $errors = [];
  
  
      if(empty($_POST['title'])){
        $errors['title'] = "A title is required";
      }
    
  
      if(empty($_POST['content'])){
        $errors['content'] = 'Content required';
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
              // resize_image($destination);
              
              // resize_image($destination);
          }else{
            $errors['image'] = 'Post needs an image';
          }

          $slug = str_to_url($_POST['title']);
        //   echo $slug;
        //   $query = "select id from categories where slug = :slug limit 1";// full colons means provided later
        //   $slug2 = query($query, ['slug'=>$slug]); // could use $_POST['email'] if i did email = ? in query
        //   // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page
      
          // if($slug2){
          //   $slug = $slug2.rand(1000,9999);
          // } 



      if(empty($errors)){
        $data = [];
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['slug'] = str_to_url($_POST['title']);
        $data['category_id'] = $_POST['category_id'];
        $data['user_id'] = user('id');
  
        $data['image'] = $destination;
        $query = "insert into posts (title,content,category_id,slug,user_id,image) values (:title,:content,:category_id,:slug,:user_id,:image)";// full colons means provided later
       
        print_r($data);
    
        query($query, $data);
        redirect_admin_posts();
        
      }
    }
  }else if($action == 'edit'){
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
       
        redirect_admin_posts();
  
      }
    } 
  }
  }if($action == 'delete'){
    $query = "select * from posts where id =:id limit 1";
    $row = query_row($query,['id' => $id]);
    if(isset($_POST['deleteBtn'])){
      if($row){

      
      if(empty($errors)){
        $data['id'] = $id;

        $query = "delete from posts where id = :id limit 1";
        query($query, $data);
        if(file_exists($row['image'])){
            unlink($row['image']);
        }

  
        redirect_admin_posts();
  
  
        
      }
    }
  }
  }
  ?>