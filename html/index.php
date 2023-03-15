<?php
session_start();
require_once('controllers/controller.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
    switch ($_GET['action']) {
        case 'login':
            login();
            break;
        case 'signup':
            signup();
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
        case 'deleteQuestion':
            deleteQuest($_GET['id']);
            break;
        case 'paypal':
            paypal();
            break;
        case 'success':
            success();
            break;
        case 'historique':
            historique();
            break;
        default:
            // echo $_GET['action']; //Debug
            echo "Erreur 404 : la page que vous recherchez n'existe pas.";
    }
} elseif (isset($_POST['action']) && $_POST['action'] !== '') {
    switch ($_POST['action']) {
        case 'newsignup':
            newSignup($_POST['pseudo'], $_POST['mdp'], $_POST['mdp2'], $_POST['nom'], $_POST['prenom'], $_POST['age']);
            break;
        case 'connexion':
            connexion($_POST['name'], $_POST['mdp']);
            break;
        case 'scoreQuizz':
            scoreQuizz($_POST['quizz']);
            break;
        case 'deleteQuestion':
            deleteQuest($_POST['id']);
            break;
        case 'admin':
            admin();
            break;
        default:
            // echo $_POST['action']; //Debug
            echo "Erreur 404 : la page que vous recherchez n'existe pas.";
    }
} else {
    home();
}
