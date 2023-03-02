<?php
abstract class Question
{
    protected int $idQuestion;
    protected string $interrogation;
    protected string $reponse;
    protected string $theme;
    protected string $propositions;
    protected string $type;

    public function __construct($idQuestion, $interrogation, $reponse, $theme, $propositions, $type)
    {
        $this->idQuestion = $idQuestion;
        $this->interrogation = $interrogation;
        $this->reponse = $reponse;
        $this->theme = $theme;
        $this->propositions = $propositions;
        $this->type = $type;
    }

    /*
    * Affiche la question et ces propositions
    *@return ce que l'on veut afficher
    */
    abstract public function display();

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
        $html = "<div class='question'><p>" . $this->interrogation . "</p>";
        foreach ($propositions as $propositions) {
            $html .= "<input type='checkbox' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
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
        $html = "<div class='question'><p>" . $this->interrogation . "</p>";
        $html .= "<input type='range' name='reponse' min='0' max='" . $this->propositions . "' value='0' class='slider' id='myRange'>";
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
        $html = "<div class='question'><p>" . $this->interrogation . "</p>";
        foreach ($propositions as $propositions) {
            $html .= "<input type='radio' name='reponse' value='" . $propositions . "'>" . $propositions . "<br>";
        }
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
        $html = "<div class='question'><p>" . $this->interrogation . "</p>";
        $html .= "<input type='text' name='reponse' placeholder='Votre réponse'>";
        $html .= "</div>";
        return $html;
    }
}
