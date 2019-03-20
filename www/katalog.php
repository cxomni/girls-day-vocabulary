<?php
require_once '../src/Application.php';
use Application\Application;

$activePage = 'katalog';

$languageWord = (isset($_POST['language-word']) and !empty($_POST['language-word'])) ? $_POST['language-word'] : '';
$languageTranslation = (isset($_POST['language-translation']) and !empty($_POST['language-translation'])) ? $_POST['language-translation'] : '';

$languages = Application::getLanguages();
$optionsFrom = $optionsTo = $fromIcon = $toIcon = '';
$catalog = '';
foreach ($languages as $language) {
    if ($language['id'] == $languageWord) {
        $fromIcon = "/img/flags/".$language['icon'];
        $optionsFrom .= '<option value="'.$language['id'].'" selected="selected">'.$language['title'].'</option>';
    } else {
        $optionsFrom .= '<option value="'.$language['id'].'">'.$language['title'].'</option>';
    }
    if ($language['id'] == $languageTranslation) {
        $toIcon = "/img/flags/".$language['icon'];
        $optionsTo .= '<option value="'.$language['id'].'" selected>'.$language['title'].'</option>';
    } else {
        $optionsTo .= '<option value="'.$language['id'].'">'.$language['title'].'</option>';
    }
}


if (!empty($_POST)) {
    $translations = Application::getTranslations($languageWord, $languageTranslation);
//    echo '<pre>';
//    print_r($translations);
//    echo '</pre>';
    if (empty($translations)) {
        $catalog .= '<div class="catalog empty">Es wurden keine Übersetzungen für deine Auswahl gefunden</div>';
    } else {
        $pages = count($translations);
        $hidden = '';
        $catalog .= '<div class="catalog">';
        foreach ($translations as $page => $translation) {
            $p = $page+1;
            if ($p > 1) {
                $hidden = ' hidden';
            }
            $catalog .= '<div id="page-'.$p.'" class="catalog-page'.$hidden.'">';
            $catalog .= '<div class="catalog-row">';
            $catalog .= '<div class="catalog-from-col">';
            $catalog .= '<img height="25px" src="'.$fromIcon.'"/>';
            $catalog .= '</div>';
            $catalog .= '<div class="catalog-to-col">';
            $catalog .= '<img height="25px" src="'.$toIcon.'"/>';
            $catalog .= '</div>';
            $catalog .= '</div>';
            foreach ($translation as $t) {
                $catalog .= '<div class="catalog-row">';
                $catalog .= '<div class="catalog-from-col wiedergabe" data-lang="'.$languageWord.'">';
                $catalog .= $t['from'];
                $catalog .= '</div>';
                $catalog .= '<div class="catalog-to-col wiedergabe" data-lang="'.$languageTranslation.'">';
                $catalog .= $t['to'];
                $catalog .= '</div>';
                $catalog .= '</div>';
            }
            if ($pages > 1) {
                $catalog .= '<div class="catalog-row">';
                if ($p > 1) {
                    $catalog .= '<div class="catalog-from-col goto" onclick="Vocabulary.goTo('.$page.')">';
                    $catalog .= '<img height="25px" src="/img/icons8-links-26.png"/>';
                } else {
                    $catalog .= '<div class="catalog-from-col">';
                }
                $catalog .= '</div>';
                if ($p < $pages) {
                    $catalog .= '<div class="catalog-to-col goto" onclick="Vocabulary.goTo('.($p+1).')">';
                    $catalog .= '<img height="25px" src="/img/icons8-rechts-26.png"/>';
                } else {
                    $catalog .= '<div class="catalog-to-col">';
                }
                $catalog .= '</div>';
                $catalog .= '</div>';
            }
            $catalog .= '<h4>Seite '.$p.' / '.$pages.'</h4>';
            $catalog .= '</div>';
        }
        $catalog .= '</div>';
        $catalog .= '</div>';
    }
}


$content = <<<HTML
    <div>
        <h2>Vokabeln Übersicht</h2>
        <h3>Sieh Dir die Übersetzungen an</h3>
        <form id="lerntrainer" action="katalog.php" method="post">
            <div>
                <label for="language-word">Von:</label>
                <select id="language-word"  onchange="Vocabulary.disableLanguage(this);" name="language-word" class="required" required>
                    <option value="">Wähle eine Sprache</option>
                    $optionsFrom
                </select>
                <label for="language-translation">Nach:</label>
                <select id="language-translation" name="language-translation" class="required" required disabled>
                    <option value="">Wähle eine Sprache</option>
                    $optionsTo
                </select>
            </div>
            <div>
                  <input type="submit" value="Anzeigen"/>
            </div>
        </form>
        $catalog
    </div>
HTML;



include_once 'layout.php';