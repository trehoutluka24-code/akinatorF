<?php

require_once './repository/database.php';

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