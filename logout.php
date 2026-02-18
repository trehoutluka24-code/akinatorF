<?php
session_start();
//Ici on gère tout ce qui est déconnexion du compte
function redirectTo(string $path): void
{
    header("Location: " . $path);
    exit;
}

// On vide la session
$_SESSION = [];
session_destroy();

// On renvoie vers l'accueil
redirectTo("index.php");

include ('./utilities/functions.php');