<?php
require_once '../src/Application.php';


$activePage = 'home';



$content = <<<HTML
    <h1 style="text-align: center; margin-top: 20px;">Dein Weg zum Vokabel-Profi</h1>
    <div class="image-box-index" style="flex-direction: row;">
        <img style="margin-right: 20px;" height="150" src="img/flags/de.svg"/>
        <img height="150" src="img/flags/gb.svg"/>
    </div>
    <div style="text-align: center;">
        Du willst die Note 1, dann bist Du hier genau richtig.<br/>
        Hier kannst du Deine Vokabeln trainieren, mit anderen teilen und von anderen lernen.<br/>
        Dein Lehrer wird begeistert sein.<br/>
        <strong style="padding-top: 20px;">Lerne lässig und nicht stressig</strong>
    </div>
HTML;


include_once 'layout.php';