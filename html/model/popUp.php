<?php
require_once('model/model.php');
class PopUp
{
    static function getPopUpAddQuest()
    {
        $themes = '';
        foreach (putTheme() as $theme) {
            $themes .= '"<option value="' . $theme . '">' . $theme . '</option>"';
        }

        return '<form class="popup-content" id="form-new-quest">
                <!-- <input type="hidden" name="action" value="addQuestion"> -->
                <!-- la question -->
                <label for="question">Question</label>
                <input type="text" name="question" id="question" required>
                <!-- le type -->
                <label for="type">Type</label>
                <select name=" type" id="type-quest" required onclick="showReponseProp()">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                </select>
                <!-- les réponses -->
                <div id="reponses-prop">
                    <input type="text" name="reponse" id="reponse" placeholder="Réponse" required>
                </div>
                <!-- le thème -->
                <div>
                    <label for="theme">Thème</label>
                    <select name="theme" id="theme-choice" required onChange="newTheme()">
                        <option value="" disabled selected>Choisir un thème</option>'
            . $themes .
            '<option value="other">Autre</option>
                    </select>
                    <div id="input-other-theme">
                        <input type="text" name="otherTheme" id="otherTheme" placeholder="Autre thème">
                    </div>
                </div>
                <button type="button" onclick="submitNewQuest()" class="validate"> Valider </button>
                <button type="button" class="cancel" onclick="togglePopupAddQuest()"> Annuler </button>
            </form>';
    }
}
