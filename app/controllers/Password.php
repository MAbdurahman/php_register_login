<?php

    namespace app\controllers;

    use core\View;

    /**
     * Password Class -
     * PHP version 8.0.13
     */
    class Password extends \core\Controller
    {

        /**
         * forgotAction Function - shows the forgotten password page
         * @return void
         */
        public function forgotAction()
        {
            View::renderTemplate('password/forgot.html');

        }//end of the forgotAction Function

    }//end of the Password Class