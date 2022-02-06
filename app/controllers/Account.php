<?php

    namespace app\controllers;

    use \app\models\User;

    /**
     * Account Class -
     * PHP version 8.0.13
     *
     */
    class Account extends \core\Controller
    {
        /**
         * validateEmailAction - validates if email is available (AJAX) for a new signup.
         *
         * @return void
         */
        public function validateEmailAction()
        {
            $is_valid = ! User::emailExists($_GET['email']);

            header('Content-Type: application/json');
            echo json_encode($is_valid);
        }
    }//end of the Account Class