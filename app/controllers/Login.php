<?php

    namespace app\controllers;

    use app\models\User;
    use core\View;

    /**
     * Login Class - is the Login Controller
     * PHP version 8.0.13
     */
    class Login extends  \core\Controller
    {

        /**
         * newAction Function - displays the login page
         * @return void
         */
        public function newAction()
        {
            View::renderTemplate('login/new.html');
        }//end of the newAction Function

        /**
         * createAction Function - logs in a user
         * @return void
         */
        public function createAction()
        {
            $user = User::authenticate($_POST['email'], $_POST['password']);

            if ($user) {

                session_regenerate_id(true);

                $_SESSION['user_id'] = $user->id;

                $this->redirect('/');

            } else {

                View::renderTemplate('login/new.html', [
                    'email' => $_POST['email']
                ]);
            }

        }//end of the createAction Function

        /**
         * destroyAction Function - logs out a user
         * @return void
         */
        public function destroyAction()
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

            $this->redirect('/');

        }//end of the destroyAction Function

    }//end of the Login Class