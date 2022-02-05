<?php

    namespace app\controllers;

    use \core\View;

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
    }//end of the SignUp Class