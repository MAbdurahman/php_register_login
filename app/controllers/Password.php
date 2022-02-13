<?php

    namespace app\controllers;

    use app\models\User;
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

        /**
         * requestResetAction Function - sends the password reset link to the specific email
         * @return void
         */
        public function requestResetAction()
        {
            User::sendPasswordReset($_POST['email']);

            View::renderTemplate('password/reset_requested.html');

        }//end of the requestResetAction Function

        /**
         * resetAction Function - shows the reset password form
         * @return void
         */
        public function resetAction()
        {
            $token = $this->route_params['token'];

            $user = User::findByPasswordReset($token);

            if ($user) {

                View::renderTemplate('Password/reset.html', [
                    'token' => $token
                ]);

            } else {

                echo "password reset token invalid";

            }

        }//end of the resetAction Function

        /**
         * resetPasswordAction Function - resets the User's password
         * @return void
         */
        public function resetPasswordAction()
        {
            $token = $_POST['token'];

            $user = User::findByPasswordReset($token);

            if ($user) {

                echo "reset user's password here";

            } else {

                echo "password reset token invalid";

            }

        }// end of the resetPasswordAction Function

    }//end of the Password Class