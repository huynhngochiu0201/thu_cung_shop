<?php

require_once '_users/handling/handling_login.php';
require_once '_users/handling/handling_register.php';
class MyTestSuiteTest extends \PHPUnit\Framework\TestCase
{
    public function testTestInput() {
        $this->assertEquals("Hello World!", test_input("   Hello World!   "));
        $this->assertEquals("O'Hoang", test_input("O\'Hoang"));
    }

    public function testCreateAccount() {
        define('DB_SERVER', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'meow_shop');
        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $result = createAccount($con, 'Hoang', 'hongtrang37@gmail.com', 'Password123@', 'Password123@');
        $this->assertEquals('Email already exists!', $result);

        $result = createAccount($con, 'Hoang', 'H12345@gmail.com', '', '');
        $this->assertEquals('Please enter your password!', $result);

        $result = createAccount($con, 'Hoang', 'H12345@gmail.com', 'Password123', 'Password123');
        $this->assertEquals('Password must contain at least 1 special letter!', $result);

        $result = createAccount($con, 'Hoang', 'H12345@gmail.com', 'Password123@', 'Password123*');
        $this->assertEquals("Confirm passwords don't match!", $result);

        $result = createAccount($con, 'Loc', 'H123456@gmail.com', 'Password123@', 'Password123@');
        $this->assertEquals('Create account successful!', $result);

    }


    // public function testLogin() {
    //     define('DB_SERVER', 'localhost');
    //     define('DB_USER', 'root');
    //     define('DB_PASS', '');
    //     define('DB_NAME', 'meow_shop');
    //     $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    //     $result = loginUser($con, 'hongngoc46@gmail.com', 'A12345@123');
    //     $this->assertEquals("Password or account don't correct!", $result);
    // }


    public function testValidEmail()
    {
        $validator = new YourLoginClass();
        $email = 'test@example.com';
        $result = $validator->validateEmail($email);

        $this->assertTrue($result);
    }




    public function testValidStrongPassword() {

        $validator = new YourLoginClass(); 
        $password = 'H12345!';
        $result = $validator->isStrongPassword($password);

        $this->assertTrue($result);

    }
    

    // public function testPerformLogin() {
    //     define('DB_SERVER', 'localhost');
    //     define('DB_USER', 'root');
    //     define('DB_PASS', '');
    //     //database name
    //     define('DB_NAME', 'meow_shop');
    //     $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    //     // Assuming you have valid test data for email and password
    //     $loginClass = new YourLoginClass();
    //     $result = $loginClass->performLogin($con, 'lengoctuan2406@gmail.com', 'hoang123A@');
    //     $this->assertNotNull($result); //test
    //     // Add more assertions based on your test data
    // }

    
}
