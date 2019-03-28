<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width">
    <meta name="robots" CONTENT="noindex, nofollow">
    <title>Girl's Day Vokabeltrainer</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="img/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
    <link href="img/favicon.ico" type="image/x-icon" rel="icon"/>
    <link rel="stylesheet" href="css/main.css"/>
    <script src="js/main.js"></script>
    <?= isset($style) ? '<style>'.$style.'</style>' : '' ?>
</head>
<body>
<div id="header">
    <img src="img/gdvicon.png" alt="Girl's Day Vocabulary Icon"/>
    <h1>Girl's Day Vocabulary Trainer</h1>
</div>
<div id="content">
    <nav>
        <a class="nav-item<?= (isset($activePage) and $activePage == 'home') ? ' active' : '' ?>" href="index.php">Home</a>
        <a class="nav-item<?= (isset($activePage) and $activePage == 'katalog') ? ' active' : '' ?>" href="katalog.php">Katalog</a>
        <a class="nav-item<?= (isset($activePage) and $activePage == 'lernen') ? ' active' : '' ?>" href="lernen.php">Lernen</a>
        <a class="nav-item<?= (isset($activePage) and $activePage == 'abfragen') ? ' active' : '' ?>" href="abfragen.php">Abfragen</a>
    </nav>
    <?= isset($content) ? $content : '' ?>
</div>
<footer id="footer">
    Made with ❤️ by <a href="https://cxomni.net" target="_blank">cx / omni</a> in Munich 🏙️
</footer>
</body>
</html>