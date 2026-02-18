<?php

// Fonction qui authentifie l'utilisateur en inscrivant ses informations dans la session
function authenticateUser( $userData ): void
{
    startSessionIfIsNot();

    // on stocke l'utilisateur à connecter dans la session
    $_SESSION['user'] = $userData;
}

// Fonction qui retourne vrai si un utilisateur est authentifié, faux s'il ne l'est pas
function isAuthenticated(): bool
{
    startSessionIfIsNot();
    // on retourne le résultat du test "si la clé 'user' existe dans $_SESSION et que la valeur de $_SESSION['user'] n'est pas vide"
    return array_key_exists('user', $_SESSION) && !empty($_SESSION['user']);
}

// Fonction qui démarre une session pour donner accès à $_SESSION si ce n'est pas déjà accessible
function startSessionIfIsNot()
{
    if( !isset($_SESSION) )
    {
        session_start();
    }
}