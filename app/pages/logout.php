<?php
include __DIR__ . '/../core/init.php';
 if(!empty($_SESSION['USER'])){
    unset($_SESSION['USER']);
 }
 session_destroy();


//  redirect_login();
header('Location: ../pages/login.php');