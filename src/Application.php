<?php
namespace Application;

class Application
{
    private static $config = null;
    private static $initialized = false;
    private static $db = null;

    /**
     * Constructor is declared private at it follows the singleton-pattern
     */
    private function __construct()
    {
    }

    /**
     * Initialize the application-wide configuration
     */
    public static function initialize(): void
    {
        if (!self::$initialized) {
            self::$config = include('../config/config.php');
            self::$initialized = true;
        }
    }

    /**
     * Returns a PDO Object to make database operations
     * Detailed information can be found here: http://php.net/manual/en/class.pdo.php
     *
     * @return \PDO|null
     */
    public static function getDB(): \PDO
    {
        if (self::$db === null) {
            self::initialize();
            $dsn = "mysql:host=".self::$config['db']['host'].";dbname=".self::$config['db']['database'];
            self::$db = new \PDO($dsn, self::$config['db']['username'], self::$config['db']['password']);
            self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return self::$db;
    }

    /**
     * Gives you a list of all available languages
     *
     * @return array
     */
    public static function getLanguages(): array
    {
        $statement = self::getDB()->prepare('SELECT * FROM languages');
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Saves a new word with its possible translations
     *
     * @param string $word The word which shall be translated
     * @param string $translation The translation(s) which are related to the word
     * @param string $from The language of the word
     * @param string $to The language of the translation(s)
     *
     * @return bool
     */
    public static function saveNewTranslation($word, $translation, $from, $to): bool
    {
        // Preparing statements
        $sWordFind = self::getDB()->prepare("SELECT * FROM words WHERE title = ? and language_id = ?");
        $sWordInsert = self::getDB()->prepare("INSERT INTO words (title, language_id) VALUES (?, ?)");
        $sTranslationFind = self::getDB()->prepare("SELECT * FROM translations WHERE from_id = ? and to_id = ?");
        $sTranslationInsert = self::getDB()->prepare("INSERT INTO translations (from_id, to_id) VALUES (?, ?)");

        // Try to find the word
        $sWordFind->execute([$word, $from]);
        $wordFound = $sWordFind->fetch();

        // Use the Id of the found Id or create new entry and use that Id
        if (!empty($wordFound)) {
            $wordId = $wordFound['id'];
        } else {
            $sWordInsert->execute([$word, $from]);
            $wordId = self::getDB()->lastInsertId();
        }

        // walk through all possible translations and save it
        $translations = explode(" ", $translation);
        foreach ($translations as $t) {
            $sWordFind->execute([$t, $to]);
            $translationFound = $sWordFind->fetch();
            if (!empty($translationFound)) {
                $transId = $translationFound['id'];
            } else {
                $sWordInsert->execute([$t, $to]);
                $transId = self::getDB()->lastInsertId();
            }

            // check if translation exists already (which is usually no)
            $sTranslationFind->execute([$wordId, $transId]);
            $relationFound = $sTranslationFind->fetch();
            if (empty($relationFound)) {
                $sTranslationInsert->execute([$wordId, $transId]);
            }
        }
        return true;
    }


    public static function trueOrFalse($word, $allowSpace = true): bool
    {
        $pattern = '/^[a-zA-ZäöüÄÖÜßáàâÁÀÂéèêÉÈÊíìîÍÌÎóòôÓÒÔúùûÚÙÛß]+$/u';
        if ($allowSpace) {
            $pattern = '/^[a-zA-ZäöüÄÖÜßáàâÁÀÂéèêÉÈÊíìîÍÌÎóòôÓÒÔúùûÚÙÛß ]+$/u';
        }
        if (preg_match($pattern, $word)) {
            return true;
        }
        return false;
    }
}