<?php

    namespace app\controllers;

    use app\Auth;
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

                Auth::login($user);
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
            Auth::logout();
            $this->redirect('/');

        }//end of the destroyAction Function

    }//end of the Login Class