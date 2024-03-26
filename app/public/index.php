
<?php 
    // error_reporting(0);
    require __DIR__ . "/../core/init.php";
    $url = $_GET['url'] ?? 'home';
    $url = strtolower($url);
    $url = explode("/", $url);

    // try{
    //     print_r($url);
    // }catch(Exception $e){
    //     echo $e->getMessage();
    // }

    $page_name = trim($url[0]);
    // print_r($url);
   
    $filename = "../pages/".$page_name.".php"; //we get the first part ofthe url for example /public/admin
        //admin is url[0], then we locate it in the pages and add .php to the end 

    
    // $PAGE = get_pagination_vars();
  

    if(file_exists($filename)) {
        require_once __DIR__ . '/' . $filename;
    }else{
        require_once __DIR__ . "/../pages/404.php"; //we get the first part ofthe url for example /public/admin
    }

    echo "<pre>";
   
    // print_r($url);
    //echo "home page"; 
//url means anything after the public/ part of the full link
// we always use /public first because the .htaccess is in public, so anytime
// we make a search, it must be after /public/etc since the htaccess will reroute us to index.php