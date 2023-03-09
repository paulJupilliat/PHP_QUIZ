<?php
require_once('connect.php');
abstract class Question
{
    protected int $id;
    protected string $interrogation;
    protected string $reponse;
    protected string $theme;
    protected string $propositions;
    protected string $type;

    public function __construct($id, $interrogation, $reponse, $theme, $propositions, $type)
    {
        $this->id = $id;
        $this->interrogation = $interrogation;
        $this->reponse = $reponse;
        $this->theme = $theme;
        $this->propositions = $propositions;
        $this->type = $type;
    }

    public static function getByInterrogation($proposition)
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("SELECT * FROM QUESTIONS WHERE interrogation = :interrogation");
            $query->execute(['interrogation' => $proposition]);
            $question = $query->fetch();
            switch ($question['type']) {
                case 'QCM':
                    $res = new QCM($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCU':
                    $res = new QCU($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCT':
                    $res = new QCT($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], '', $question['type']);
                    break;
                case 'QCS':
                    $res = new QCS($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                default:
                    $res = null;
                    break;
            }
            return $res;
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
    }

    public function getId()
    {
        if (isset($this->id) && $this->id != 0) {
            return $this->id;
        } else {
            return Question::getByInterrogation($this->interrogation)->getId();
        }
    }

    public static function getById($id)
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("SELECT * FROM QUESTIONS WHERE id_question = :id");
            $query->execute(['id' => $id]);
            $question = $query->fetch();
            switch ($question['type']) {
                case 'QCM':
                    $res = new QCM($id, $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCU':
                    $res = new QCU($id, $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCT':
                    $res = new QCT($id, $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCS':
                    $res = new QCS($id, $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                default:
                    $res = null;
                    break;
            }
            return $res;
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
    }

    /*
    * Affiche la question et ces propositions
    *@return ce que l'on veut afficher
    */
    abstract public function display();

    /**
     * Affiche la question et ces propositions pour la relecture
     * @param array $proposition  proposition de l'utilisateur pour la question
     * @return void ce que l'on veut afficher
     */
    abstract public function displayRelecture($proposition);

    /**
     * Push une nouvelle question dans la base de données
     * @param $interrogation interrogation de la question
     * @param $reponse reponse de la question
     * @param $theme theme de la question
     * @param $propositions propositions de la question
     * @param $type type de la question
     * @return int 1 si la question a été ajoutée, 0 si elle n'a pas été ajoutée
     */
    public static function pushQuestion($interrogation, $reponse, $theme, $propositions, $type)
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("INSERT INTO QUESTIONS (interrogation, reponse, theme, propositions, type) VALUES (:interrogation, :reponse, :theme, :propositions, :type)");
            $query->execute(['interrogation' => $interrogation, 'reponse' => $reponse, 'theme' => $theme, 'propositions' => $propositions, 'type' => $type]);
            return 1;
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return 0;
        } finally {
            $db = null;
        }
    }

    /**
     * Push dans la base de données une nouvelle question
     */
    public function pushInBd()
    {
        Question::pushQuestion($this->interrogation, $this->reponse, $this->theme, $this->propositions, $this->type);
    }

    /**
     * Donne toutes les questions d'un theme
     * @param $theme theme des questions
     * @return Question[] tableau de questions
     */
    public static function getQuestionByTheme($theme)
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("SELECT * FROM QUESTIONS WHERE theme = :theme");
            $query->execute(['theme' => $theme]);
            $questions = $query->fetchAll(PDO::FETCH_ASSOC);
            $tab = [];
            foreach ($questions as $question) {
                switch ($question['type']) {
                    case 'QCM':
                        array_push($tab, new QCM($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCU':
                        array_push($tab, new QCU($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCS':
                        array_push($tab, new QCS($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCT':
                        array_push($tab, new QCT($question['id_question'], $question['interrogation'], $question['reponse'], $question['theme'], '', $question['type']));
                        break;
                    default:
                        break;
                }
            }
            return $tab;
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
    }

    /*
    * Donne un tableau de questions aléatoires
    * @param $theme theme des questions
    * @param $nb nombre de questions
    * @return Question[] tableau de questions
    */
    public static function getQuestionAleatoire($theme, $nb)
    {
        $questions = Question::getQuestionByTheme($theme);
        $tab = [];
        for ($i = 0; $i < $nb; $i++) {
            $rand = rand(0, count($questions) - 1);
            array_push($tab, $questions[$rand]);
            unset($questions[$rand]);
            $questions = array_values($questions);
        }
        return $tab;
    }

    /**
     * Donne tous les themes
     * @return string[] tableau de themes
     */
    public static function getThemes()
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare('SELECT DISTINCT theme FROM QUESTIONS');
            $query->execute();
            $themes = $query->fetchAll();
            $tab = [];
            foreach ($themes as $theme) {
                array_push($tab, $theme['theme']);
            }
        } catch (PDOException $e) {
            $tab = "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
        return $tab;
    }

    public function getReponse()
    {
        return $this->reponse;
    }

    public function getInterrogation()
    {
        return $this->interrogation;
    }

    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * Donne si la réponse est bonne ou non
     * @param $tentative réponse de l'utilisateur
     * @return bool vrai si la réponse est bonne
     */
    public function isTrue($tentative)
    {
        return $tentative == $this->reponse;
    }
}

/*
* question de type QCU (question à choix unique)
*/
class QCU extends Question
{
    /**
     * Affiche la question et ses propositions
     * @return mixed ce que l'on veut afficher
     */
    public function display()
    {
        $propositions = explode("|", $this->propositions);
        array_push($propositions, $this->reponse); // On ajoute la réponse à la proposition
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        shuffle($propositions);
        foreach ($propositions as $propositions) {
            $html .= "<input type='radio' class='reponse' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * Affichage pour la relecture après la partie
     * @param array $proposition_user proposition de l'utilisateur
     * @return string html
     */
    public function displayRelecture($proposition_user)
    {
        $propositions = explode("|", $this->propositions);
        array_push($propositions, $this->reponse); // On ajoute la réponse à la proposition
        $html = "<div class='question " . $this->type . " " . strval($this->isTrue($proposition_user) ? 'false' : 'true') . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        foreach ($propositions as $proposition) {
            $html .= "<input type='radio' class='reponse' name='reponse' value='" . $proposition . "' " . strval(in_array($proposition, $proposition_user) ? '' : 'checked') . " disabled>" . $proposition . "<br>";
        }
        $html .= "<p> La réponse était : " . $this->reponse . "</p>";
        $html .= "</div>";
        return $html;
    }
}

/*
* question de type QCS (question avec slider)
*/
class QCS extends Question
{
    /*
    * Affiche la question et son slider (propositions est le max du slider)
    * @return mixed ce que l'on veut afficher
    */

    /**
     * Affiche la question et son slider (propositions est le max du slider)
     * @return mixed ce que l'on veut afficher
     */
    public function display()
    {
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        $html .= "<input type='range' class='reponse' name='reponse' step=1 min='0' max='" . $this->propositions . "' value='0' id='myRange'>";
        $html .= "<p>Value: <span id='value'></span></p>";
        $html .= "<script>
        var slider = document.getElementById('myRange');
        var output = document.getElementById('value');
        output.innerHTML = slider.value;
        slider.oninput = function() {
            output.innerHTML = this.value;
        }
        </script>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Affichage pour la relecture après la partie
     * @param array $proposition_user proposition de l'utilisateur
     * @return string html
     */
    public function displayRelecture($propositionUser)
    {
        $html = "<div class='question " . $this->type . " " . strval($this->isTrue($propositionUser[0]) ? 'true' : 'false') . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        $html .= '<p>La réponse était : ' . $this->isTrue($propositionUser). '</p>';
        $html .= "<input type='range' class='reponse' name='reponse' step=1 min='0' max='" . $this->propositions . "' value='" . $propositionUser[0] . "' id='myRange' disabled>";
        $html .= "<p>Value: <span id='value'>" . $propositionUser[0] . "</span></p>";
        $html .= "<p> La réponse était : " . $this->reponse . "</p>";
        $html .= "</div>";
        return $html;
    }
}

/*
* question de type QCT (question à choix texte)
*/
class QCT extends Question
{

    /**
     * Affiche la question et son champ de texte
     * @return mixed ce que l'on veut afficher
     */
    public function display()
    {
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        $html .= "<input type='text' class='reponse' name='reponse' placeholder='Votre réponse'>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Affichage pour la relecture après la partie
     * @param array $proposition_user proposition de l'utilisateur
     * @return string html
     */
    public function displayRelecture($propositionUser)
    {
        $html = "<div class='question " . $this->type . " " . strval($this->isTrue($propositionUser[0]) ? 'true' : 'false') . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        $html .= "<input type='text' class='reponse' name='reponse' placeholder='Votre réponse' value='" . $propositionUser[0] . "' disabled>";
        $html .= "<p> La réponse était : " . $this->reponse . "</p>";
        $html .= "</div>";
        return $html;
    }
}

// question de type QCM
class QCM extends Question
{
    /**
     * Affiche la question et ces propositions
     * @return mixed ce que l'on veut afficher
     */
    public function display()
    {
        $propositions = explode("|", $this->propositions);
        $propositions = array_merge($propositions, $this->reponseToArray($this->reponse)); // On ajoute les réponses dans les propositions
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        shuffle($propositions);
        foreach ($propositions as $propositions) {
            $html .= "<input type='checkbox' class='reponse' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * Affichage pour la relecture après la partie
     * @param array $proposition_user proposition de l'utilisateur
     * @return string html
     */
    public function displayRelecture($propositionUser)
    {
        $reponse = $this->reponseToArray($this->reponse);
        $propositions = explode("|", $this->propositions);
        $propositions = array_merge($propositions, $reponse); // On ajoute les réponses dans les propositions
        $html = "";
        $nbReponse = 0; // compteur de bonne réponse donnée par l'utilisateur
        foreach ($propositions as $proposition) {
            $html .= "<input type='checkbox' class='reponse" . "' name='reponse' value='" . $proposition . "' " . strval(in_array($proposition, $propositionUser) ? 'checked' : '') . " disabled>" . $proposition . "<br>";
            if (in_array($proposition, $reponse) && in_array($proposition, $propositionUser)) {
                $nbReponse++;
            }
        }
        $html .= "<p> La réponse était : " . $this->reponse . "</p>";
        $html .= "</div>";
        $html = "<div class='question " . $this->type . " " . strval($nbReponse == count($reponse) ? 'true' : 'false') . "'><p class='interrogation'>" . $this->interrogation . "</p>" . $html;
        return $html;
    }

    public function reponseToArray($reponse)
    {
        if (strpos($reponse, '|') !== false) {
            return explode('|', $reponse);
        } else {
            return [$reponse];
        }
    }

    public function isTrue($tentative)
    {
        if (strpos($this->reponse, '|') !== false) {
            $arrayReponses = explode('|', $this->reponse);
            foreach (explode('|', $tentative) as $reponse) {
                if (!in_array($reponse, $arrayReponses)) {
                    return false;
                }
            }
            return true;
        } else {
            return $tentative == $this->reponse;
        }
    }
}
