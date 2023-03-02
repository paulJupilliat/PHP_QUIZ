<?php
require_once('model/model.php');
function home()
{
    require('templates/home.php');
}

/**
 * Affiche la page de connexion
 */
function login()
{
    require('templates/login.php');
}

/**
 * Affiche la page d'inscription
 */
function signup()
{
    require('templates/signup.php');
}
/**
 * Essaye de connecter l'utilisateur à son compte et affiche la page d'accueil, si la connexion échoue, affiche la page de connexion avec un message d'erreur
 */
function connexion($pseudo, $mdp)
{
    $existe = User::checkUser($pseudo, $mdp);
    if ($existe == 1) {
        $_SESSION['pseudo'] = $pseudo;
        header("Location: index.php");
    } elseif ($existe == 0) {
        $err = "Pseudo incorrect";
    } elseif ($existe == -1) {
        $err = "Erreur de connexion";
    } elseif ($existe == -2) {
        $err = "Mot de passe incorrect";
    }
    require('templates/login.php');
}

/**
 * Essaye d'inscrire l'utilisateur et affiche la page d'accueil, si l'inscription échoue, affiche la page d'inscription avec un message d'erreur
 */
function newSignUp($pseudo, $mdp, $mdp2, $nom, $prenom, $age)
{
    if ($mdp == $mdp2) {
        $user = new User($pseudo, $nom, $prenom, $mdp, $age);
        $res = $user->pushInBd();
        echo $res;
        if ($res == 1) {
            $_SESSION['pseudo'] = $pseudo;
            header("Location: index.php");
        } else {
            $err = "Erreur de connexion";
            require('templates/signup.php');
        }
    } else {
        $err = "Les mots de passe ne correspondent pas";
        require('templates/signup.php');
    }

}
