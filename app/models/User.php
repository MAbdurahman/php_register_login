<?php

    namespace app\models;

    use Dotenv\Dotenv;
    use PDO;

    /**
     * User Class - a user Model
     * PHP version 8.0.13
     */
    class User extends \core\Model
    {

        /**
         * Get all the users as an associative array
         *
         * @return array
         */
        public static function getAll()
        {
            $db = static::getDB();
            $stmt = $db->query('SELECT id, name FROM users');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }//end of the User Class
