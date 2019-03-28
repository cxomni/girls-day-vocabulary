<?php
require_once '../src/Application.php';
use Application\Application;

$activePage = 'abfragen';
$hideTrainerForm = '';
$nextButton = '';

$languageWord = (isset($_POST['language-word']) and !empty($_POST['language-word'])) ? $_POST['language-word'] : '';
$languageTranslation = (isset($_POST['language-translation']) and !empty($_POST['language-translation'])) ? $_POST['language-translation'] : '';

$languages = Application::getLanguages();
$optionsFrom = $optionsTo = $fromIcon = $toIcon = '';
$catalog = '';
$style = '';
$langIcons = [];
foreach ($languages as $language) {
    $langIcon = "/img/flags/".$language['icon'];
    $style .= '.'.str_replace("_", "-", $language['id']).':before{content: url("'.$langIcon.'");}';
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


if (!empty($_POST)) {
    $translations = Application::getTrainer($languageWord, $languageTranslation);
    if (isset($translations['end']) and $translations['end'] == false) {
        $nextButton = '<input type="submit" value="Nächste"/>';
    }
//    echo '<pre>';
//    print_r($translations);
//    echo '</pre>';
    if (empty($translations)) {
        $catalog .= '<div class="catalog empty">Es wurden keine Übersetzungen für deine Auswahl gefunden</div>';
    } else {
        $hideTrainerForm = ' class="hidden"';
        $catalog .= '<form action="#"><div class="trainer">';
        foreach ($translations as $page => $translation) {
            $catalog .= '<div class="catalog-row">';
            $catalog .= '<div class="catalog-from-col wiedergabe flagging '.$translation['langFrom'].'" data-lang="'.$translation['langFrom'].'">';
            $catalog .= $translation['from'];
            $catalog .= '</div>';
            $catalog .= '<div class="catalog-to-col solution">';
            $catalog .= '<input type="text" value="" name="solution['.$translation['id'].']" placeholder="Wie lautet Deine Lösung?"/>';
            $catalog .= '</div>';
            $catalog .= '<div class="catalog-to-col wiedergabe solution-hidden" data-lang="'.$translation['langTo'].'">';
            $catalog .= $translation['to'];
            $catalog .= '</div>';
            $catalog .= '</div>';
        }
        $catalog .= '</div>';
        $catalog .= '<div>';
        $catalog .= '<input type="button" class="check" value="Prüfe Deine Angaben"/>';
        $catalog .= '</div>';
        $catalog .= '</form>';
    }
}



$content = <<<HTML
    <div>
        <h2>Vokabeln abfragen</h2>
        <h3>Lass dich vom Vokabel-Trainer abfragen</h3>
        <form id="lerntrainer" action="abfragen.php" method="post"$hideTrainerForm>
            <div>
                <label for="language-word">Zwischen </label>
                <select id="language-word"  onchange="Vocabulary.disableLanguage(this);" name="language-word" class="required" required>
                    <option value="">Wähle eine Sprache</option>
                    $optionsFrom
                </select>
                <label for="language-translation"> und </label>
                <select id="language-translation" name="language-translation" class="required" required disabled>
                    <option value="">Wähle eine Sprache</option>
                    $optionsTo
                </select>
            </div>
            <div>
                  <input type="submit" value="Trainer starten"/>
            </div>
        </form>
        $catalog
    </div>
HTML;


include_once 'layout.php';