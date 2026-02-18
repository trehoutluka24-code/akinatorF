<?php

session_start();
//Ici, on gère la modification des mots de passe des utilisateurs
include ('./repository/userRepository.php');
if (!empty($_POST)){
    if (isset($_POST['password-old'], $_POST['password-new'])){
        
        $passwordOld = trim(strip_tags($_POST['password-old']));
        $passwordNew = trim(strip_tags($_POST['password-new']));
        $idUser = $_SESSION['users']['id'];
        
        $recupPassword = selectPassword($idUser);
        
        if(password_verify($passwordOld, $recupPassword['password'])){
            $test =updatePassword($passwordNew, $idUser);
            
            if($test){
                $error = "Le mot de passe à bien été modifier";
            } else{
                $error = "Une erreur est survenue, veuillez réessayer";
            }
            
        } else{
            
            $error = "Le mot de passe n'est pas correct";
            
        }
            
    }
}

include ('./template/account.phtml');