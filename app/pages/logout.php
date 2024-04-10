<?php
session_start();
include __DIR__ . '/../core/init.php';

$url = $_SERVER['REQUEST_URI'];
$url = explode("/",$url);
trackPageViews($url[5]);


 if(!empty($_SESSION['USER'])){
    unset($_SESSION['USER']);
 }
 session_destroy();


//  redirect_login();
header('Location: ../pages/login.php');