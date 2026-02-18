<?php

include './repository/database.php';

// Fonction qui fait la requête SQL d'ajout d'un utilisateur
function addUser( string $username, string $email, string $clearPassword )
{
    $sql = 'INSERT INTO users (user_name, email, password) VALUES ( :username, :email, :password )';

    $query = connectToDB()->prepare( $sql );

    $query->execute([
        'username' => $username,
        'email' => $email,
        'password' => password_hash( $clearPassword, PASSWORD_BCRYPT )
    ]);
}

function getUserByUserName($name){
    $db = connectToDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt->execute([$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

//déclare 3 fonctions, une qui permet de modifier un mot de passe, l'autre qui permet de sélectionner un mot de passe par l'id d'un utilisateur et une dernière qui lance un delete d'un compte selon un id
function selectPassword($id){
    $db = connectToDB();
    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $password = $stmt->fetch(PDO::FETCH_ASSOC);
    return $password;
}

function updatePassword($passwordNew, $id){
    $db = connectToDB();
   $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $test=$stmt->execute([$passwordNew, $id]);
    
    return $test;
}