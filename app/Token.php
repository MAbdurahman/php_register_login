<?php

    namespace app;


    /**
     * Token Class -
     * PHP version 8.0.13
     */
    class Token
    {
        /**
         * The token value
         * @var array
         */
        protected $token;

        /**
         * Token Constructor - creates a new random token or assign an existing one, if a
         * parameter is passed.
         * @param string $value (optional) A token value
         * @return void
         */
        public function __construct($token_value = null)
        {
            if ($token_value) {

                $this->token = $token_value;

            } else {

                $this->token = bin2hex(random_bytes(16));  // 16 bytes = 128 bits = 32 hex characters

            }

        }//end of the Token Constructor

        /**
         * getValue Function - gets the token value
         * @return string The value
         */
        public function getValue()
        {
            return $this->token;

        }//end of the getValue Function

        /**
         * getHash Function - get the hashed value of the $token value
         * @return string The hashed value
         */
        public function getHash()
        {
            return hash_hmac('sha256', $this->token, $_ENV['SECRET_KEY']);  // sha256 = 64 chars

        }//end of the getHash Function

    }//end of the Token Class