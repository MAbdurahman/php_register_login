<?php

    namespace app;

    use app\models\User;
    use app\models\RememberedLogin;

    /**
     * Auth Class -
     * PHP version 8.0.13
     */
    class Auth
    {
        /**
         * login Function - starts the session for logged-in user
         * @param User $user - the user model
         * @param boolean $remember_me - remembers the login if true
         * @return void
         */
        public static function login($user, $remember_me)
        {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->id;

            if ($remember_me) {

                if ($user->rememberLogin()) {

                    setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');

                }

            }

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

        /**
         * getUser - retrieves the current logged-in user, from the session or the
         * remember me cookie
         * @return mixed The user model or null if not logged in
         */
        public static function getUser()
        {
            if (isset($_SESSION['user_id'])) {

                return User::findByID($_SESSION['user_id']);

            } else {

                return static::loginFromRememberCookie();

            }

        }//end of the getUser Function

        /**
         * loginFromRememberCookie Function - logins the user from a remembered login cookie
         * @return mixed The user model if login cookie found; null otherwise
         */
        protected static function loginFromRememberCookie()
        {
            $cookie = $_COOKIE['remember_me'] ?? false;

            if ($cookie) {

                $remembered_login = RememberedLogin::findByToken($cookie);

                if ($remembered_login) {

                    $user = $remembered_login->getUser();

                    static::login($user, false);

                    return $user;
                }
            }

        }//end of the loginFromRememberCookie Function

    }//end of the Auth Class