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
         * User Constructor -
         * @param array $data  Initial property values
         *
         * @return void
         */
        public function __construct($data)
        {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            };

        }//end of the User constructor

        /**
         * save Function - saves the user model with the current property values
         * @return void
         */
        public function save()
        {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, :password_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            $stmt->execute();

        }//end of the save Function

    }//end of the User Class
