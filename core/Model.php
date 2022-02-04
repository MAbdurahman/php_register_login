<?php

    namespace core;

    use Dotenv\Dotenv;
    use PDO;

    /**
     * Base model
     *
     * PHP version 8.0.13
     */
    abstract class Model
    {

        /**
         * getDB Function - Get the PDO database connection
         * @return mixed
         */
        protected static function getDB()
        {
            static $db = null;

            if ($db === null) {

                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];

                $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username, $password);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return $db;

        }// end of the getDB function
    }//end of the Model abstract class
