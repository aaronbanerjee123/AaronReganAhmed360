<?php
if(!function_exists('query')){
    function query(string $query, array $data = []){
    $string = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
    $con = new PDO($string, DBUSER,DBPASS);

    $stm = $con->prepare($query); 
    $stm->execute($data);
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($result) && !empty($result)){
        return $result;
    }

    return false;
    }
}

if(!function_exists('query_row')) {
function query_row(string $query, array $data = []){
    $string = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
    $con = new PDO($string, DBUSER,DBPASS);

    $stm = $con->prepare($query); 
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($result) && !empty($result)){
        return $result[0];
    }

    return false;
    }
}
if(!function_exists('esc')){
    function esc($str) {
        return htmlspecialchars($str ?? '');
    }

}




// function redirect($page){
//     header('Location: '.$page);
//     die;
// }

if(!function_exists('redirect_login')){
        function redirect_login(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
        die;
    }
}


if(!function_exists('redirect_home')){
    function redirect_home(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
        die;
    }

}


if(!function_exists('redirect_admin')){
    function redirect_admin(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/admin.php');
        die;
    }
}

if(!function_exists('redirect_admin_users')){
    function redirect_admin_users(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/admin.php?section=users');
        die;
    }
    
}

if(!function_exists('redirect_admin_categories')){
    function redirect_admin_categories(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/admin.php?section=categories');
        die;
    }
    
}
if(!function_exists('redirect_admin_posts')){
    function redirect_admin_posts(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/admin.php?section=posts');

        die;
    }
}

if(!function_exists('redirect_admin_myblogs')){
    function redirect_admin_myblogs(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/myblogs.php');

        die;
    }
}

if(!function_exists('redirect_settings')){
    function redirect_settings(){
        header('Location: https://cosc360.ok.ubc.ca/aaron202/app/pages/settings.php');
        die;
    }
}



if(!function_exists('old_value')){
    function old_value($key, $default = ''){
        if(!empty($_POST[$key])){
            return $_POST[$key];
        }
    
    
        return $default;
    }
}


if(!function_exists('old_checked')){
    function old_checked($key){
        if(!empty($_POST[$key])){
            return "checked";
        }
        return "";
    }
}

if(!function_exists('image')){
    function image() {
        echo $_FILES['image'];
    }
}

if(!function_exists('get_image')){
    function get_image($file){
        $file = $file ?? '';
    
        if(file_exists($file)){
            return ROOT . '/' .$file;
        }
    
        return ROOT.'/assets/images/no_image.jpg';
    }
}


if(!function_exists('authenticate')){
    function authenticate($row){
        $_SESSION['USER'] = $row[0];
    }
}


if(!function_exists('user')){
    function user($key=''){
        if(empty($key)){
            return $_SESSION['USER'];
        }
        if(!empty($_SESSION['USER'][$key])){
            return $_SESSION['USER'][$key];
        }
    
        return '';
    }
}


if(!function_exists('logged_in')){
    function logged_in(){
        if(!empty($_SESSION['USER'])){
            return true;
        }
        return false;
    }
    
}


if(!function_exists('str_to_url')){
    function str_to_url($url){
        $url = str_replace("'","",$url);
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9]+~', '',$url);
    
        return $url;
    }

}


if(!function_exists('get_pagination_vars')){
    function get_pagination_vars(){
        //pagination
        $page_number = $_GET['page'];
        $page_number = (empty($page_number) || $page_number<1) ? 1 : (int)$page_number;
        // $page_number = $page_number < 1 ? 1 : $page_number;
    
        $current_link = $_GET['url'] ?? 'home';
        $current_link = ROOT . "/" .$current_link;
    
        $query_string = "";
    
        foreach($_GET as $key => $value){
            if($key != 'url'){
                if($key == 'page' && $value < 1){
                    $query_string .= "&".$key."=1";
                }else{
                    $query_string .= "&".$key."=".$value;
                }
            }
        }
    
    
        if(!strstr($query_string, "page=")){
            $query_string .= "&page=".$page_number;
        }
    
        $query_string = trim($query_string, "&");
    
        $prev_page_number = $page_number - 1 <= 0 ? 1 : $page_number-1;
    
        $current_link .= "?".$query_string;
    
        $first_link = preg_replace("/page=[\w0-9]+/","page=1",$current_link);
    
        $next_link = preg_replace("/page=[\w0-9]+/","page=".($page_number+1),$current_link);
        
        $prev_link= preg_replace("/page=[\w0-9]+/","page=".($prev_page_number),$current_link);
        
        $result = [
         'current_link'  =>$current_link,
         'first_link'    => $first_link,
         'next_link'     => $next_link,
         'prev_link'     => $prev_link,
         '$page_number' => $page_number
        ];
 
        return $result;
 }
 
}

if(!function_exists('create_tables')){
    function create_tables(){
        try {
        $string = "mysql:hostname=".DBHOST.";";
        $con = new PDO($string, DBUSER,DBPASS);
    
        $query = "CREATE DATABASE IF NOT EXISTS ".DBNAME;
        $stm = $con->prepare($query); 
        $stm->execute();
    
        $query = "use ". DBNAME;
        $stm = $con->prepare($query); 
        $stm->execute();
    
        // print_r($con);
        $query = "create table if not exists users(
            id int primary key auto_increment,
            username varchar(50) not null,
            email varchar(100) not null,
            password varchar(255) not null,
            image varchar(1024) null,
            date timestamp default current_timestamp,
            role varchar(10) not null,
    
            key username (username),
            key email (email)
    
        )";
        $stm = $con->prepare($query); 
        $stm->execute();
    
        $query = "create table if not exists categories(
            id int primary key auto_increment,
            category varchar(50) not null,
            slug varchar(100) not null,
            disabled tinyint default 0,
    
            key slug (slug),
            key category (category)
    
        )";



        $stm = $con->prepare($query); 
        $stm->execute();

        $query = "SELECT * FROM categories";
        $rows = query($query);

        if(is_array($rows) && count($rows) != 5){
            $query = "INSERT IGNORE INTO categories (category, disabled, slug) VALUES
            ('fitness', 0, 'fitness'),
            ('food', 0, 'food'),
            ('travel', 0, 'travel'),
            ('lifestyle', 0, 'lifestyle'),
            ('music', 0, 'music')";

            $stm = $con->prepare($query);
            $stm->execute();

        }
       

        $query = "create table if not exists posts(
            id int primary key auto_increment,
            user_id int,
            category_id int,
            title varchar(100) not null,
            content text null,
            image varchar(1024) null,
            date timestamp default current_timestamp,
            slug varchar(100) not null,
    
            key user_id (user_id),
            key category_id (category_id),
            key date (date),
            key slug (slug)
        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();
    
        $query = "create table if not exists comments(
            id int primary key auto_increment,
            post_id int,
            comment text null,
            user_id int,
            date timestamp default current_timestamp
        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();


        $query = "create table if not exists searchterms(
            id int primary key auto_increment,
            search_term text null,
            times_searched int,

            key times_searched(times_searched),
            key search_term(search_term)


        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();

        $query = "create table if not exists post_views(
            id int primary key auto_increment,
            post_title text null,
            user_id int,
            date timestamp default current_timestamp,
            key(post_title)
        
        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();


        $query = "create table if not exists pageViews(
            id int primary key auto_increment,
            page text null,
            user text null,
            date timestamp default current_timestamp,
            key(user)

        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();

        $query = "create table if not exists commentData(
            id int primary key auto_increment,
            date timestamp default current_timestamp,
            post_title text null
        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();
    




        $query = "create table if not exists postAddedData(
            id int primary key auto_increment,
            post_title text null,
            date timestamp default current_timestamp
        )";
    
        $stm = $con->prepare($query); 
        $stm->execute();

        // $query = "INSERT INTO postAddedData (post_title) VALUES ('default')";
        // $stm = $con->prepare($query); 
        // $stm->execute();

        }catch(PDOException $e){
            echo $e;
        }
     }
     create_tables();

    
}

if(!function_exists('trackPageViews')){
        function trackPageViews($page){

        $query = "SELECT * from pageViews WHERE page like :page";
        $rows_search = query($query, ['page' => $page]);

        $user = isset($_SESSION['USER']) ? $_SESSION['USER']['username'] : 'Guest';
        

          $query = "INSERT INTO pageViews (page, user) VALUES (:page, :user)";
          $data['user'] = $user;
          $data['page'] = $page;
          query($query,$data);
        

    }

}