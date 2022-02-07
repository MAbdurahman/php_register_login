<?php

    namespace app\controllers;

    use app\models\User;
    use core\View;

    /**
     * SignUp.php is a controller for signup\new.html
     *
     * PHP version 8.0.13
     */
    class SignUp extends \core\Controller
    {
        /**
         * newAction Function - shows the signup page
         * @return void
         */
        public function newAction()
        {
            View::renderTemplate('signup/new.html');

        }//end of the newAction Function

        /**
         * createAction Function - Signs up a new user
         * @return void
         */
        public function createAction()
        {
            $user = new User($_POST);

            if ($user->save()) {

                $this->redirect('/signup/success');

            } else {
                View::renderTemplate('signup/new.html', [
                    'user' => $user
                ]);
            }

        }// end of the createAction Function

        /**
         * successAction Function - shows the signup success page
         * @return void
         */
        public function successAction()
        {
            View::renderTemplate('signup/success.html');

        }//end of the successAction Function

    }//end of the SignUp Class