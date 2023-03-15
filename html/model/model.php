<?php
require('model/connect.php');
require('model/tentative.php');
/**
 * Connexion à la base de données
 * @return PDO $conn connexion à la base de données
 * @throws PDOException si la connexion échoue
 */
function connexion_to_bd()
{
    try {
        $conn = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE . ";port=" . PORT, USER, MDP);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo SERVEUR . "|";
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}
function isPremium($id)
{
    try {
        $db = connexion_to_bd();
        $query = $db->prepare("SELECT premium FROM USERS WHERE pseudo = :pseudo");
        $query->execute(['pseudo' => $id]);
        $result = $query->fetch();
        return $result['premium'];
    } catch (PDOException $e) {
        return "Erreur : " . $e->getMessage();
    } finally {
        $db = null;
    }
}

/**
 * Vérifie si l'utilisateur est connecté
 * @return bool true si l'utilisateur est connecté, false sinon
 */
function checkLoged()
{
    return (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] !== '') ? true : false;
}

/*
* Traite le thème qui est envoyé par le formulaire
* @param string $theme le thème à traiter
* @param string otherTheme le thème à traiter si le thème est autre
* @return string le thème traité
*/
function traitementTheme($theme, $otherTheme)
{
    if ($theme == "other") {
        return $otherTheme;
    } else {
        // first letter in uppercase and the rest in lowercase
        return ucfirst(strtolower($theme));
    }
}
