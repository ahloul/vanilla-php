<?php

namespace Databases;

use PDO;
use PDOException;


class DB
{

    protected static $instance;


    private static $path = 'sqlite:./databases/sample.db';



    private function __construct()
    {

        try {
            self::$instance = new PDO(self::$path);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->sqliteCreateFunction('regexp',
                function ($pattern, $data, $delimiter = '~', $modifiers = 'isuS')
                {
                    if (isset($pattern, $data) === true)
                    {
                        return (preg_match(sprintf('%1$s%2$s%1$s%3$s', $delimiter, $pattern, $modifiers), $data) > 0);
                    }

                    return null;
                }
            );

        } catch (PDOException $e) {
            echo "Sqlite Connection Error: " . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            new DB();
        }

        return self::$instance;
    }

}
