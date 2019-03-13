<?php
if (!empty($_POST)) {
    $languageWord = (isset($_POST['language-word']) and !empty($_POST['language-word'])) ? $_POST['language-word'] : false;
    $word = (isset($_POST['word']) and !empty($_POST['word'])) ? $_POST['word'] : false;
    $languageTranslation = (isset($_POST['language-translation']) and !empty($_POST['language-translation'])) ? $_POST['language-translation'] : false;
    $translation = (isset($_POST['translation']) and !empty($_POST['translation'])) ? $_POST['translation'] : false;

    print_r($languageWord.'<br/>');
    print_r($word.'<br/>');
    print_r($languageTranslation.'<br/>');
    print_r($translation.'<br/>');
    echo ($translation === false) ? 'false' : 'true';
}


$content = <<<HTML
    <div>
        <h2>Das ist die Lernseite</h2>
        <h3>Hier kannst du dem Vokabeltrainer neue Wörter beibringen. Gehe am besten so vor:</h3>
        <ol>
            <li>Wähle zuerst die Sprache von dem Wort, das du trainieren möchtest</li>
            <li>Dann schreibst du das Wort in das Eingabefeld.</li>
            <li>Wenn Du das Wort eingetragen hast wähle die Sprache aus in die du übersetzen willst</li>
            <li>Trage dann die Übersetzung in das neue Eingabefeld. Wenn es mehr als eine sinnvolle Übersetzung gibt, schreibe alle Wörter durch ein Leerzeichen getrennt</li>
            <li>Wenn du Dir nicht sicher bist, wie man die Wörter schreibt, dann kann Dir Google sicher helfen</li>
        </ol>
        <form id="lerntrainer" action="lernen.php" method="post">
            <div>
                <select name="language-word" class="required" required>
                    <option value="">Wähle eine Sprache</option>
                    <option value="de-DE">Deutsch</option>
                    <option value="en-EN">Englisch</option>
                </select>
                <input type="text" name="word" value="" placeholder="Schreibe das Wort"/>
            </div>
            <div>
                <select name="language-translation" class="required" required>
                    <option value="">Wähle eine Sprache</option>
                    <option value="de-DE">Deutsch</option>
                    <option value="en-EN">Englisch</option>
                </select>
                <input type="text" name="translation" value="" placeholder="Übersetzung(en)"/>
            </div>
            <div>
                  <input type="submit" value="Speichern"/>
            </div>
        </form>
    </div>
HTML;


include_once 'layout.php';