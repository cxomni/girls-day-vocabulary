<?php
require_once '../src/Application.php';
use Application\Application;

$activePage = 'lernen';

$languageWord = (isset($_POST['language-word']) and !empty($_POST['language-word'])) ? $_POST['language-word'] : '';
$word = (isset($_POST['word']) and !empty($_POST['word'])) ? $_POST['word'] : '';
$languageTranslation = (isset($_POST['language-translation']) and !empty($_POST['language-translation'])) ? $_POST['language-translation'] : '';
$translation = (isset($_POST['translation']) and !empty($_POST['translation'])) ? $_POST['translation'] : '';

$errorClassWord = $errorClassTranslation = $error = '';
if (!empty($_POST)) {
    if (Application::trueOrFalse($word) and Application::trueOrFalse($translation)) {
        $saved = Application::saveNewTranslation($word, $translation, $languageWord, $languageTranslation);
        if ($saved !== true) {
            $error = '<div class="error-msg">Es trat ein Fehler beim Speichern auf. Gibt es die Übersetzung schon?</div>';
        }
    } else {
        // Error handling
        $error = '<div class="error-msg">Bitte überprüfe die Schreibweise Deiner Eingaben. Es sind nur Wörter ohne Sonderzeichen, Zahlen oder Satzzeichen erlaubt.</div>';
        if (!Application::trueOrFalse($word)) {
            $errorClassWord .= ' error';
        }
        if (!Application::trueOrFalse($translation)) {
            $errorClassTranslation .= ' error';
        }
    }
}
$languages = Application::getLanguages();
$optionsFrom = $optionsTo = '';
foreach ($languages as $language) {
    if ($language['id'] == $languageWord) {
        $optionsFrom .= '<option value="'.$language['id'].'" selected="selected">'.$language['title'].'</option>';
    } else {
        $optionsFrom .= '<option value="'.$language['id'].'">'.$language['title'].'</option>';
    }
    if ($language['id'] == $languageTranslation) {
        $optionsTo .= '<option value="'.$language['id'].'" selected>'.$language['title'].'</option>';
    } else {
        $optionsTo .= '<option value="'.$language['id'].'">'.$language['title'].'</option>';
    }
}

$content = <<<HTML
    <div>
        <h2>Neue Vokabeln hinzufügen</h2>
        <h3>Hier kannst du dem Vokabeltrainer neue Wörter beibringen</h3>
        <ol>                
            <h4>Gehe am besten so vor:</h4>
            <li>Wähle zuerst die Sprache von dem Wort, das du trainieren möchtest.</li>
            <li>Dann schreibst du das Wort in das Eingabefeld.</li>
            <li>Wenn Du das Wort eingetragen hast wähle die Sprache aus in die du übersetzen willst.</li>
            <li>Trage dann die Übersetzung in das neue Eingabefeld. Wenn es mehr als eine sinnvolle Übersetzung gibt, schreibe alle Wörter durch ein Leerzeichen getrennt.</li>
            <li>Wenn du Dir nicht sicher bist, wie man die Wörter schreibt, dann kann Dir Google sicher helfen</li>
        </ol>
        <form id="lerntrainer" action="lernen.php" method="post">
            $error
            <div>
                <select onchange="Vocabulary.disableLanguage(this);" name="language-word" class="required" required>
                    <option value="">Wähle eine Sprache</option>
                    $optionsFrom
                </select>
                <input class="required$errorClassWord" type="text" name="word" value="$word" placeholder="Schreibe das Wort" required/>
            </div>
            <div>
                <select id="language-translation" name="language-translation" class="required" required disabled>
                    <option value="">Wähle eine Sprache</option>
                    $optionsTo
                </select>
                <input class="required$errorClassTranslation" type="text" name="translation" value="$translation" placeholder="Übersetzung(en)" required/>
            </div>
            <div>
                  <input type="submit" value="Speichern"/>
            </div>
        </form>
    </div>
HTML;


include_once 'layout.php';