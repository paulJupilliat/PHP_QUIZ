<?php
session_start();
require_once('controllers/controller.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch($_GET['action']) {
        case 'login':
            login();
            break;
        case 'signup':
            signup();
            break;
        case 'newsignup':
            newSignup($_GET['pseudo'], $_GET['mdp'], $_GET['mdp2'], $_GET['nom'], $_GET['prenom'], $_GET['age']);
            break;
        case 'connexion':
            connexion($_GET['name'], $_GET['mdp']);
            break;
        case 'logout':
            session_destroy();
            header("Location: index.php");
            break;
        default:
            echo "Erreur 404 : la page que vous recherchez n'existe pas.";
    }
} else {
    home();
}
?>