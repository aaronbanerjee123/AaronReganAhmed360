<?php 
 
 $section = $_GET['section'] ?? 'dashboard';

 $action = $_GET['action'] ?? 'view';//add

 $id = $_GET['id'] ?? '0';
?>



<?php
if($action == 'add'){
    if(!empty($_POST)){
      $errors = [];
    
  
  
      if(empty($_POST['category'])){
        $errors['category'] = "A category is required";
      }else if(!preg_match("/^[a-zA-Z]+$/", $_POST['category'])){
          $errors['category'] = "A category has to be just letters";
      }

      $slug = str_to_url($_POST['category']);
      // echo $slug;
      // $query = "select id from categories where slug = :slug limit 1";// full colons means provided later
      // $slug2 = query($query, ['slug'=>$slug]); // could use $_POST['email'] if i did email = ? in query
      // // to query for info you just type query function, but you must use prepared statements when configuring things in the database like in functions page
  
      // if($slug2){
      //   $slug = $slug2.rand(1000,9999);
      // } 

      if(empty($errors)){  
        $data = [];
        $data['category'] = $_POST['category'];
        $data['slug'] = $slug;
        $data['disabled'] = $_POST['disabled'];
        $query = "insert into categories (category,disabled,slug) values (:category,:disabled,:slug)";// full colons means provided later
        
       
        query($query, $data);
        redirect_admin_categories();
        
      }
    }
  }
  if($action == 'delete'){
    $query = "select * from categories where id =:id limit 1";
    $row = query_row($query,['id' => $id]);
    if(isset($_POST['deleteBtn'])){
      if($row){

      
      if(empty($errors)){
        $data['id'] = $id;

        $query = "delete from categories where id = :id limit 1";
        query($query, $data);

       
        redirect_admin_categories();
  
  
        
      }
    }
  }
  }
  ?>