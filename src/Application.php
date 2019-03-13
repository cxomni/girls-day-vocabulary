<?php
namespace Application;

class Application
{
    private static $config = null;
    private static $initialized = false;

    private function __construct()
    {
    }

    public static function initialize()
    {
        if (!self::$initialized) {
            self::$config = include('../config/config.php');
            self::$initialized = true;
        }
    }
    public static function getDB()
    {
        self::initialize();
        print_r(self::$config);
    }

}