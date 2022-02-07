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

                $this->redirect('/');

            } else {

                View::renderTemplate('login/new.html', [
                    'email' => $_POST['email']
                ]);
            }

        }//end of the createAction Function
    }//end of the Login Class