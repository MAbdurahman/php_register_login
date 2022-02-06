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
         * Error messages
         * @var array
         */
        public $errors = [];

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
            $this->validate();

            if (empty($this->errors)) {
                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

                $sql = 'INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, :password_hash)';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

                return $stmt->execute();

            }
            return false;

        }//end of the save Function

        /**
         * validate Function - validates current property values, adding validation error messages
         * to the errors array property
         * @return void
         */
        public function validate()
        {
            // Name
            if ($this->name == '') {
                $this->errors[] = 'Name is required!';
            }

            // email address
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                $this->errors[] = 'Valid email is required!';
            }
            if ($this->emailExists($this->email)) {
                $this->errors[] = 'Email already exists!';
            }

            // Password
            if ($this->password != $this->password_confirmation) {
                $this->errors[] = 'Password must match confirmation!';
            }

            if (strlen($this->password) < 8) {
                $this->errors[] = 'Please enter at least 8 characters for the password!';
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one letter!';
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one number!';
            }

        }//end of the validate Function

        /**
         * emailExists Function - ascetains if a user record already exists with the specified email
         * @param string $email email address to search for
         * @return boolean  True if a record already exists with the specified email, false otherwise
         */
        protected function emailExists($email)
        {
            $sql = 'SELECT * FROM users WHERE email = :email';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch() !== false;

        }//end of the emailExits Function

    }//end of the User Class
