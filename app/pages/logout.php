<?php
include __DIR__ . '/../core/init.php';
 if(!empty($_SESSION['USER'])){
    unset($_SESSION['USER']);
 }

 redirect_login();