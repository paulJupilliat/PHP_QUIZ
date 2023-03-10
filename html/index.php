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
        case 'quizz':
            quizz($_GET['theme']);
            break;
        case 'admin':
            admin();
            break;
        case 'addQuestion':
            addQuestion($_GET['question'], $_GET['type'], $_GET['reponsesProp'], $_GET['theme'], $_GET['otherTheme'], $_GET['reponse']);
            break;
        case 'scoreQuizz':
            scoreQuizz($_GET['quizz']);
            break;
        default:
            // echo $_GET['action']; //Debug
            echo "Erreur 404 : la page que vous recherchez n'existe pas.";
    }
} else {
    home();
}
