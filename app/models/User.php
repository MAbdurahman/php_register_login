<?php

    namespace app\models;

    use Dotenv\Dotenv;
    use PDO;
    use app\Token;
    use app\Mail;
    use core\View;

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
        public function __construct($data = [])
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
            if (static::emailExists($this->email)) {
                $this->errors[] = 'Email already exists!';
            }

            // Password
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
        public static function emailExists($email)
        {
            return static::findByEmail($email) !== false;

        }//end of the emailExits Function

        /**
         * findByEmail Function - finds a user model by email address
         * @param string $email email address to search for
         * @return mixed User object if found, false otherwise
         *
         */
        public static function findByEmail($email)
        {
            $sql = 'SELECT * FROM users WHERE email = :email';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();

        }//end of the findByEmail Function

        /**
         * authenticate Functionn - authenticates a user by email and password.
         * @param string $email email address
         * @param string $password password
         *
         * @return mixed  The user object or false if authentication fails
         */
        public static function authenticate($email, $password)
        {
            $user = static::findByEmail($email);

            if ($user) {
                if (password_verify($password, $user->password_hash)) {
                    return $user;
                }
            }

            return false;

        }//end of the authenticate Function

        /**
         * findByID Function - finds a models/User by its ID
         * @param string $id The user ID
         * @return mixed User object if found, false otherwise
         */
        public static function findByID($id)
        {
            $sql = 'SELECT * FROM users WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();

        }//end of the findByID Function

        /**
         * rememberLogin Function - remembers the login by inserting a new unique token into the
         * remembered_logins table for this user record
         * @return boolean  True if the login was remembered successfully, false otherwise
         */
        public function rememberLogin()
        {
            $token = new Token();
            $hashed_token = $token->getHash();
            $this->remember_token = $token->getValue();

            $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now


            $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

            return $stmt->execute();

        }//end of the rememberLogin Function

        /**
         * sendPasswordReset Function - sends password reset instructions to the user specified
         * @param string $email - the specified email
         * @return void
         */
        public static function sendPasswordReset($email)
        {
            $user = static::findByEmail($email);

            if ($user) {

                if ($user->startPasswordReset()) {

                    $user->sendPasswordResetEmail();
                }

            }
        }//end of the sendPasswordReset Function

        /**
         * startPasswordReset Function - starts the password reset process by generating
         * a new token and expiry_timestamp
         * @return void
         */
        protected function startPasswordReset()
        {
            $token = new Token();
            $hashed_token = $token->getHash();
            $this->password_reset_token = $token->getValue();

            $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

            $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();

        }//end of the startPasswordReset Function

        /**
         * sendPasswordResetEmail Function - sends password reset instructions in an
         * email to the User
         * @return void
         */
        protected function sendPasswordResetEmail()
        {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

            $text = View::getTemplate('password/reset_email.txt', ['url' => $url]);
            $html = View::getTemplate('password/reset_email.html', ['url' => $url]);

            Mail::send($this->email, 'Password reset', $text, $html);

        }//end of the sendPasswordResetEmail Function

    }//end of the User Class
