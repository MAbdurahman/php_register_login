<?php

    namespace app\models;

    use PDO;
    use app\Token;

    /**
     * RememberedLogin Class - a model of RememberedLogin
     * PHP version 8.0.13
     */
    class RememberedLogin extends \core\Model
    {
        /**
         * findByToken Function - finds a remembered login model by the token
         * @param string $token The remembered login token
         * @return mixed Remembered login object if found, false otherwise
         */
        public static function findByToken($token)
        {
            $token = new Token($token);
            $token_hash = $token->getHash();

            $sql = 'SELECT * FROM remembered_logins
                WHERE token_hash = :token_hash';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();

        }//end of the findByToken Function

        /**
         * getUser Function - gets the User assodiated with this remembered login
         * @return User The user model
         */
        public function getUser()
        {
            return User::findByID($this->user_id);

        }//end of the getUser Function

        /**
         * hasExpired Function - finds out if the remember token has expired or not, based
         * on the current system time
         * @return boolean True if the token has expired, false otherwise
         */
        public function hasExpired()
        {
            return strtotime($this->expires_at) < time();

        }//end of the hasExpired Function

        /**
         * delete Function - deletes this model
         * @return void
         */
        public function delete()
        {
            $sql = 'DELETE FROM remembered_logins
                WHERE token_hash = :token_hash';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);

            $stmt->execute();

        }//end of the delete Function

    }//end of the RememberedLogin Class