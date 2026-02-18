<?php
//ici on sécurise les mots de passe et email des utilisateurs pour éviter tout injection sql lors de l'inscription d'un utilisateur
include ('./repository/database.php');

if (!empty($_POST)){
    
    $db = connectToDB();
    
    
    $name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $errors = array();
    
    if (preg_match('/[\n]/', $email)) {
        $errors["email"] = "Email invalide";
    }
    
    $uppercase = preg_match("/[A-Z]/", $password);
    
    $lowercase = preg_match("/[a-z]/", $password);
    
    $number = preg_match("/[0-9]/", $password);
    
    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $errors["password"] = "Le mot de passe est invalide, il faut au minimum 8 caractères, la présence d'une lettre en majuscule, minuscule et un chiffre dans votre mot de passe.";
    } else {
        
        $secure_password = password_hash($password, PASSWORD_DEFAULT);
        
        $requete = $db->prepare("INSERT INTO users (user_name,password,email) VALUES (:user_name, :password, :email)");
        
        $requete->bindParam(':user_name', $name, PDO::PARAM_STR);
        $requete->bindParam(':password', $secure_password, PDO::PARAM_STR);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        
      $requete->execute();
    }
}

include('./template/register.phtml');



