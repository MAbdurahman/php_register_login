<?php

    namespace app;

    /**
     * Auth Class -
     * PHP version 8.0.13
     */
    class Auth
    {
        /**
         * login Function - starts the session for logged-in user
         * @param User $user The user model
         * @return void
         */
        public static function login($user)
        {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->id;

        }//end of the login Function

        /**
         * logout Function - destroys the sessions for the logged-in user
         * @return void
         */
        public static function logout()
        {
            // Unset all of the session variables
            $_SESSION = [];

            // Delete the session cookie
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            // Finally destroy the session
            session_destroy();

        }//end of the logout Function

        /**
         * isLoggedIn Function - returns an indicator of whether a user is logged-in
         * or not
         * @return boolean
         */
        public static function isLoggedIn()
        {
            return isset($_SESSION['user_id']);

        }//end of the isLoggedIn Function

        /**
         * rememberRequestedPage Function - remembers the originally requested page in the
         * session
         * @return void
         */
        public static function rememberRequestedPage()
        {
            $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];

        }//end of the rememberRequestedPage Function

        /**
         * getReturnToPage Function - retrieves the originally requested page to return to
         * after logging-in, or default to the homepage
         * @return void
         */
        public static function getReturnToPage()
        {
            return $_SESSION['return_to'] ?? '/';

        }//end of the getReturnToPage Function

    }//end of the Auth Class