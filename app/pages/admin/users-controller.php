
<?php 
 
 $section = $_GET['section'] ?? 'dashboard';

 $action = $_GET['action'] ?? 'view';//add

 $id = $_GET['id'] ?? '0';
?>



<?php

if($action == 'add'){
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
        redirect_admin_users();
        
      }
    }
  }else if($action == 'edit'){
    $query = "select * from users where id =:id limit 1";
    $row = query_row($query,['id' => $id]);
    if(!empty($_POST)){
      if($row){

      $errors = [];
  
      if(empty($_POST['username'])){
        $errors['username'] = "A username is required";
      }else if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
          $errors['username'] = "A username has to be just letters";
      }
    
      if(!empty($_POST['password']) && strlen($_POST['password']) < 8){
        $errors['password'] = "Password needs to be 8 or more characters";
      }else if($_POST['password'] !== $_POST['retype_password']){
        $errors['password'] = "Passwords do not match";
      }
  
      $query = "select id from users where email = :email && id != :id limit 1";// full colons means provided later
      $email = query($query, ['email'=>$_POST['email'],'id' => $id]); // could use $_POST['email'] if i did email = ? in query
      // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page
  
      if(empty($_POST['email'])){
        $errors['email'] = 'A email is required';
      }else if($email){
          $errors['email'] = "That email is already in use";
      }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ 
        $errors['email'] = "Not a valid email";
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
          }


      if(empty($errors)){
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['role'] = $_POST['role'];
        $data['id'] = $id;

        if(empty($_POST['password']) ){
            $query = "update users set username=:username, email=:email, role=:role where id = :id limit 1";// full colons means provided later
          
        }else{
          $data['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
          $query = "update users set username=:username, email=:email, password=:password, role=:role where id = :id limit 1";// full colons means provided later 
         
        }
         if(!empty($destination) && !empty($_POST['password'])){
               $data['image'] = $destination;
               $query = "update users set username=:username, email=:email, password=:password, role=:role, image=:image where id = :id limit 1";// full colons means provided later
          }

          if(!empty($destination) && empty($_POST['password'])){
            $data['image'] = $destination;
            $query = "update users set username=:username, email=:email, role=:role, image=:image where id = :id limit 1";// full colons means provided later
          }
          
        query($query, $data);
        redirect_admin_users();
  
      }
    } //uploads/Screen Shot 2023-03-13 at 11.24.55 AM.png
  }
  }if($action== 'delete'){
    $query = "select * from users where id =:id limit 1";
    $row = query_row($query,['id' => $id]);
    if(isset($_POST['deleteBtn'])){
      if($row){

      
      if(empty($errors)){
        $data['id'] = $id;

        $query = "delete from users where id = :id limit 1";
        query($query, $data);

        if(file_exists($row['image'])){
          unlink($row['image']);
        }
  
        redirect_admin_users();
  
  
        
      }
    }
  }
  }
  ?>