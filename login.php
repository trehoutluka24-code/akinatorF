<?php
session_start();
 
include ('./repository/userRepository.php');

 
$db = connectToDB();
 
if (!empty($_POST)){
    if (isset($_POST['user_name'], $_POST['password'])){
 
        $name = trim(strip_tags($_POST['user_name']));
        $password = trim(strip_tags($_POST['password']));
 
       $user = getUserByUserName($name);
       
 
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['users']['user_name'] = $user['user_name'];
            $_SESSION['users']['id'] = $user['id'];
           
            header("Location: account.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}  
include ('./template/login.phtml');