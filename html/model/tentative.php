<?php
class Tentative
{
    private $idTentative;
    private $pseudo;
    /**
     * Array of all questions of the tentative
     * @var array $questionTentative array of QuestionTentative
     */
    private $questionTentative;

    /**
     * Value of the score
     * @var string $score score/nb of question
     */
    private $score;

    /**
     * Constructor of the class
     * @param mixed $arg id of the tentative or string of the quizz
     */
    public function __construct($arg)
    {
        if (is_string($arg)) {
            $this->constructString($arg);
        } elseif (is_int($arg)) {
            $this->constructInt($arg);
        }
    }

    private function constructInt(int $idTenatative)
    {
        $this->idTentative = $idTenatative;
        $this->questionTentative = [];
        $result = Tentative::getAllContentTentative($idTenatative);
        $this->pseudo = $result[0]['pseudo'];
        foreach ($result as $row) {
            $question = Question::getById($row['question_id']);
            array_push($this->questionTentative, $question);
        }
        $this->score = $this->getScore();
    }

    /**
     * Create quizz and push it in the database with the tentative of the user
     * @param string $quizz string of the quizz with the tentative of the user(format: questionX=interrogation:str!proposition:reponse*questionY=interrogation:str!proposition:reponse)
     */
    private function constructString(string $quizz)
    {
        $parQuestion = explode("*", $quizz);
        $this->idTentative = Tentative::getLastTentative() + 1;
        $this->pseudo = $_SESSION['pseudo'];
        $this->questionTentative = [];
        // On regarde par question
        foreach ($parQuestion as $question) {
            $interrogation = explode("!", $question)[0]; // On récupère la partie interrogation
            $interrogation = explode(":", $interrogation)[1]; // On récupère la partie l'interrogation
            $reponse = explode("!", $question)[1]; // On récupère la partie réponse
            $reponse = explode(":", $reponse)[1]; // On récupère les réponses
            $questionBd = Question::getByInterrogation($interrogation);

            Tentative::pushTentative($questionBd->getId(), $reponse, $this->idTentative);

            array_push($this->questionTentative, $questionBd);
        }
        $this->score = $this->getScore();
    }

    /**
     * Push in the database the tentative of this question for the user
     * @param mixed $interrogation od of the question
     * @param mixed $reponse answer of the user
     * @param mixed $idTentative id of the tentative
     */
    public static function pushTentative($idQuest, $reponse, $idTentative)
    {
        try {
            $connexion = connexion_to_bd();
            $sql = "INSERT INTO QUESTION_TENTATIVES (question_id, proposition) VALUES (:interrogation, :reponse)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':interrogation', $idQuest);
            $stmt->bindParam(':reponse', $reponse);
            $stmt->execute();

            // On récupeère l'id de la tentative_question
            $sql = "SELECT * FROM QUESTION_TENTATIVES ORDER BY id DESC LIMIT 1";
            $stmt = $connexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $questTentativeId = $result['id'];

            // insertion de la tentative dans la table do_tenative
            $sql = "INSERT INTO do_tentative (id_tentative, pseudo, quest_tentative_id) VALUES (:idTentative, :pseudo, :quest_tentative_id)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':idTentative', $idTentative);
            $stmt->bindParam(':pseudo', $_SESSION['pseudo']);
            $stmt->bindParam(':quest_tentative_id', $questTentativeId);
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

    /**
     * Get the score of the user
     * @param int $idTentative id of the tentative
     * @return mixed score of the user
     */
    public function getScore()
    {
        if ($this->score != null) {
            return $this->score;
        }
        $score = 0;
        $doTentative = Tentative::getAllContentTentative($this->idTentative);
        // Pour toutes les questions de la tentative
        foreach ($doTentative as $quest_tentative) {
            $result2 = Tentative::getidQuestAndProposition($quest_tentative['quest_tentative_id']);
            if (Question::getById($result2['question_id'])->isTrue($result2['proposition'])) {
                $score++;
            }
        }
        $this->$score = $score;
        return $this->$score;
    }

    public function getQuestions()
    {
        return $this->questionTentative;
    }

    /**
     * Get the id of the question and the proposition of the user
     * @param mixed $questTentative id of the question tentative
     * @return array of the id of the question and the proposition of the user
     */
    public static function getidQuestAndProposition($questTentative)
    {
        try {
            $connexion = connexion_to_bd();
            $sql = "SELECT * FROM QUESTION_TENTATIVES WHERE id = :question_id";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':question_id', $questTentative);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
            return [];
        } finally {
            $connexion = null;
        }
    }

    /**
     * Give all questions of the tentative, with user
     * @param mixed $id_tentative id of the tentative
     * @return array array of all the questions of the tentative
     */
    public static function getAllContentTentative($idTentative)
    {
        try {
            $connexion = connexion_to_bd();
            $sql = "SELECT * FROM do_tentative WHERE id_tentative = :id_tentative";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id_tentative', $idTentative);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
            return [];
        } finally {
            $connexion = null;
        }
    }

    /**
     * Get html code of the score
     * @return string html code of the score
     */
    public function display()
    {
        $html = "<div class='score'>";
        $html .= "<h2>Score : " . $this->getScore() . "/" . $this->getNbQuestion() . "</h2>";
        $html .= "</div>";
        $html .= "<div class='questions relecture'>";
        foreach ($this->questionTentative as $question) {
            $html .= $question->displayRelecture($this->getPropositionUser($question->getId()));
        }
        return $html;
    }

    /**
     * Donne le nombre de question de la tentative
     * @param mixed $idTentative id de la tentative
     * @return int nombre de question de la tentative
     */
    public function getNbQuestion()
    {
        return count($this->questionTentative);
    }

    /**
     * Get the proposition of the user for a question with the id
     * @param mixed $idQuest id of the question
     * @return array proposition of the user
     */
    public function getPropositionUser($idQuest)
    {
        $res = [];
        $questTentative = Tentative::getAllContentTentative($this->idTentative);
        foreach ($questTentative as $quest) {
            $result2 = Tentative::getidQuestAndProposition($quest['quest_tentative_id']);
            if ($result2['question_id'] == $idQuest) {
                if (strpos($result2['proposition'], '|') !== false) {
                    $res = explode('|', $result2['proposition']);
                } else {
                    $res = [$result2['proposition']];
                }
                return $res;
            }
        }
        return [];
    }
}
