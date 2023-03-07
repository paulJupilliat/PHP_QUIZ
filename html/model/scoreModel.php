<?php
class score
{
    /**
     * Push in the database the tentative of this question for the user
     * @param mixed $interrogation od of the question
     * @param mixed $reponse answer of the user
     * @param mixed $idTentative id of the tentative
     */
    public static function pushTentative($id_quest, $reponse, $idTentative)
    {
        try {
            $connexion = connexion_to_bd();
            $sql = "INSERT INTO QUESTION_TENTATIVES (question_id, proposition) VALUES (:interrogation, :reponse)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':interrogation', $id_quest);
            $stmt->bindParam(':reponse', $reponse);
            $stmt->execute();

            // On récupeère l'id de la tentative_question
            $sql = "SELECT * FROM QUESTION_TENTATIVES ORDER BY id DESC LIMIT 1";
            $stmt = $connexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $quest_tentative_id = $result['id'];

            // insertion de la tentative dans la table do_tenative
            $sql = "INSERT INTO do_tentative (id_tentative, pseudo, quest_tentative_id) VALUES (:idTentative, :pseudo, :quest_tentative_id)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':idTentative', $idTentative);
            $stmt->bindParam(':pseudo', $_SESSION['pseudo']);
            $stmt->bindParam(':quest_tentative_id', $quest_tentative_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
        } finally {
            $connexion = null;
        }
    }

    /**
     * Pull the last id of tentative
     * @return mixed id of the last tentative
     */
    public static function getLastTentative()
    {
        try {
            $connexion = connexion_to_bd();
            $sql = "SELECT * FROM do_tentative ORDER BY id_tentative DESC LIMIT 1";
            $stmt = $connexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id_tentative'];
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
        } finally {
            $connexion = null;
        }
    }

    /*
    * Traite le score du quizz
    * @param string $quizz le quizz à traiter
    * @return int l'id de la tentative
    */
    public static function traitementQuizz($quizz)
    {
        $parQuestion = explode("*", $quizz);
        $id_tentative = Score::getLastTentative() + 1;
        // On regarde par question
        foreach ($parQuestion as $question) {
            $interrogation = explode("!", $question)[0]; // On récupère la partie interrogation
            $interrogation = explode(":", $interrogation)[1]; // On récupère la partie l'interrogation
            $reponse = explode("!", $question)[1]; // On récupère la partie réponse
            $reponse = explode(":", $reponse)[1]; // On récupère les réponses
            $questionBd = Question::getByInterrogation($interrogation);

            Score::pushTentative($questionBd->getId(), $reponse, $id_tentative);
        }
        return $id_tentative;
    }

    /**
     * Get the score of the user
     * @param int $id_tentative id of the tentative
     * @return mixed score of the user
     */
    public static function getScore($id_tentative)
    {
        $score = 0;
        try {
            $connexion = connexion_to_bd();
            // On récupère les quest_tentative_id de la tentative
            $sql = "SELECT * FROM do_tentative WHERE id_tentative = :id_tentative";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id_tentative', $id_tentative);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Pour toutes les questions de la tentative
            foreach ($result as $quest_tentative) {
                // on cherche l'id de la question et la proposition de l'user
                $sql = "SELECT * FROM QUESTION_TENTATIVES WHERE id = :question_id";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(':question_id', $quest_tentative['quest_tentative_id']);
                $stmt->execute();
                $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
                echo $result2['question_id'] . "zzz";
                if (Question::getById($result2['question_id'])->isTrue($result2['proposition'])) {
                    $score++;
                }
            }
            return $score;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
        } finally {
            $connexion = null;
        }
    }
}
