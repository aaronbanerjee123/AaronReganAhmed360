<?php
//vendor/bin/phpunit test/loginTest.php

// Include the PHPUnit framework autoload file
require_once 'vendor/autoload.php';



require_once 'app/pages/login.php';

class LoginTest extends \PHPUnit\Framework\TestCase
{

    public function testLogin()
    {
        // Create a POST request simulation with the email and password
        $_POST['email'] = 'test@gmail.com';
        $_POST['password'] = 'testtest';

        // Capture the output of the login code
        ob_start();
        include 'app/pages/login.php';
        $output = ob_get_clean();

        // Check if the login was successful (expecting redirection)
        $this->assertStringContainsString('Location: ../pages/home.php', xdebug_get_headers());

        // Alternatively, you can check for the presence of specific elements on the redirected page
        // For example, if you have a session message indicating successful login
        // $this->assertStringContainsString('You are now logged in', $output);
    }


}