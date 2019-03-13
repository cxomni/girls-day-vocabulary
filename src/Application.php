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
}