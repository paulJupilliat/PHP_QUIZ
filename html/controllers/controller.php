<?php
require_once('model/model.php');
require_once('model/question.php');
require_once('model/popUp.php');
require_once('model/user.php');
function home()
{
    $_SESSION['themes'] = putTheme();
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

/**
 * Affiche la page de quizz
 */
function quizz($theme)
{
    if (checkLoged()) {
        //si je suis prenium
        if (isPremium($_SESSION['pseudo'])) {
            $questions = Question::getQuestionAleatoire($theme, 10);
        } else {
            $questions = Question::getQuestionAleatoireLambda($theme, 2);
        }
        $questions = Question::getQuestionAleatoire($theme, 2);
        require('templates/quizz.php');
    } else {
        header("Location: index.php");
    }
}

/**
 * Donne tous les thèmes
 * @return string[] Tableau contenant tous les thèmes
 */
function putTheme()
{
    $themes = array();
    $themesArray = Question::getThemes();
    if (is_array($themesArray)) {
        foreach ($themesArray as $theme) {
            array_push($themes, $theme);
        }
        return $themes;
    } else {
        // handle the error
        return ['Error: ' . $themesArray];
    }
}

/**
 * Affiche la page d'administration
 */
function admin()
{
    if (checkLoged() && User::isAdmin($_SESSION['pseudo'])) {
        // gestion des questions
        $popUpAddQuest = PopUp::getPopUpAddQuest();
        if (isset($_GET['recherche'])) {
            $allQuestion = Question::getQuestionSearch($_GET['recherche']);
        } else {
            $allQuestion = Question::getAllQuestionsShawn();
        }

        // Exportation et importation
        if (isset($_GET['export'])) {
            Question::exportToJSON();
        }
        if (isset($_FILES['fileToUpload'])) {
            try {
                Question::importFromJSON($_FILES['fileToUpload']);
                unset($_FILES['fileToUpload']);
            } catch (Exception $e) {
                echo '<script>alert("Le fichier selectionné n\'est pas un .json")</script>';
            }
        }

        // Import export user
        if (isset($_GET['exportUser'])) {
            User::exportToJSON();
        }
        if (isset($_FILES['fileToUploadUser'])) {
            try {
                User::importFromJSON($_FILES['fileToUploadUser']);
                unset($_FILES['fileToUploadUser']);
            } catch (Exception $e) {
                echo '<script>alert("Le fichier selectionné n\'est pas un .json")</script>';
            }
        }

        // gestion des utilisateurs
        $allUsers = User::getAllUsers();

        require('templates/admin.php');
    } else {
        header("Location: index.php");
    }
}
function paypal()
{
    if (checkLoged()) {
        require('templates/paypal.php');
    } else {
        header("Location: index.php");
    }
}

function success()
{
    if (checkLoged()) {
        require('templates/success.php');
    } else {
        header("Location: index.php");
    }
}

/**
 * Ajoute une question à la base de données
 */
function addQuestion($question, $type, $reponseProp, $theme, $otherTheme, $reponse)
{
    if (checkLoged() && User::isAdmin($_SESSION['pseudo'])) {
        $theme = traitementTheme($theme, $otherTheme);
        $theme = ucfirst(strtolower($theme));
        switch ($type) {
            case 'text':
                $question = new QCT(0, $question, $reponse, $theme, '', 'QCT', 1, 0);
                $question->pushInBd();
                break;
            case 'radio':
                $question = new QCU(0, $question, $reponse, $theme, $reponseProp, 'QCU', 1, 0);
                $question->pushInBd();
                break;
            case 'checkbox':
                $question = new QCM(0, $question, $reponse, $theme, $reponseProp, 'QCM', 1, 0);
                $question->pushInBd();
                break;
            case 'number':
                $question = new QCS(0, $question, $reponse, $theme, $reponseProp, 'QCS', 1, 0);
                $question->pushInBd();
                break;
            default:
                echo 'Erreur de type de question';
                break;
        }
        header("Location: index.php?action=admin");
    } else {
        header("Location: index.php");
    }
}

/**
 * Affiche la page de score d'un quizz
 * @param string $quizz String brut du quizz avec les questions et les reponses de l'utilisateur
 */
function scoreQuizz(string $quizz)
{
    if (checkLoged()) {
        $tentative = new Tentative($quizz);
        $affichage = $tentative->display();
        require('templates/score.php');
    } else {
        header("Location: index.php");
    }
}

function deleteQuest($id)
{
    if (checkLoged() && User::isAdmin($_SESSION['pseudo'])) {
        Question::deleteQuestion($id);
        header("Location: index.php?action=admin");
    } else {
        header("Location: index.php");
    }
}
