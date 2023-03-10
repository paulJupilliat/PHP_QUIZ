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
        $this->interrogation = $interrogation;
        $this->reponse = $reponse;
        $this->theme = $theme;
        $this->propositions = $propositions;
        $this->type = $type;
    }

    public static function getByInterrogation($proposition){
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("SELECT * FROM QUESTIONS WHERE interrogation = :interrogation");
            $query->execute(['interrogation' => $proposition]);
            $question = $query->fetch();
            switch ($question['type']) {
                case 'QCM':
                    $res = new QCM($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCU':
                    $res = new QCU($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
                    break;
                case 'QCT':
                    $res = new QCT($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], '', $question['type']);
                    break;
                case 'QCS':
                    $res = new QCS($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']);
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

    public static function getById($id)
    {
        try {
            $db = connexion_to_bd();
            $query = $db->prepare("SELECT * FROM QUESTIONS WHERE id = :id");
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
     * Push une nouvelle question dans la base de donn??es
     * @param $interrogation interrogation de la question
     * @param $reponse reponse de la question
     * @param $theme theme de la question
     * @param $propositions propositions de la question
     * @param $type type de la question
     * @return int 1 si la question a ??t?? ajout??e, 0 si elle n'a pas ??t?? ajout??e
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
     * Push dans la base de donn??es une nouvelle question
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
                        array_push($tab, new QCM($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCU':
                        array_push($tab, new QCU($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCS':
                        array_push($tab, new QCS($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], $question['propositions'], $question['type']));
                        break;
                    case 'QCT':
                        array_push($tab, new QCT($question['id'], $question['interrogation'], $question['reponse'], $question['theme'], '', $question['type']));
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
    * Donne un tableau de questions al??atoires
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
            $tab = array();
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

    /**
     * Donne si la r??ponse est bonne ou non
     * @param $tentative r??ponse de l'utilisateur
     * @return bool vrai si la r??ponse est bonne
     */
    public function isTrue($tentative)
    {
        return $tentative == $this->reponse;
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
        $propositions = array_merge($propositions, $this->reponseToArray($this->reponse)); // On ajoute les r??ponses dans les propositions
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        shuffle($propositions);
        foreach ($propositions as $propositions) {
            $html .= "<input type='checkbox' class='reponse' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
        $html .= "</div>";
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
        $html .= "<input type='range' class='reponse' name='reponse' min='0' max='" . $this->propositions . "' value='0' class='slider' id='myRange'>";
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
}

/*
* question de type QCU (question ?? choix unique)
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
        array_push($propositions, $this->reponse); // On ajoute la r??ponse ?? la proposition
        $html = "<div class='question " . $this->type . "'><p class='interrogation'>" . $this->interrogation . "</p>";
        shuffle($propositions);
        foreach ($propositions as $propositions) {
            $html .= "<input type='radio' class='reponse' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
        $html .= "</div>";
        return $html;
    }
}

/*
* question de type QCT (question ?? choix texte)
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
        $html .= "<input type='text' class='reponse' name='reponse' placeholder='Votre r??ponse'>";
        $html .= "</div>";
        return $html;
    }
}
