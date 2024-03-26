<?php
include __DIR__ . '/../core/init.php';
 if(!empty($_SESSION['USER'])){
    unset($_SESSION['USER']);
    session_destroy();
 }
 header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
 header("Pragma: no-cache"); // HTTP 1.0.
 header("Expires: 0"); 
//  redirect_login();
header('Location: ../pages/login.php');