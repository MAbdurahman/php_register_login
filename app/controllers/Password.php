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

            $user = $this->getUserOrExit($token);

            View::renderTemplate('Password/reset.html', [
                'token' => $token
            ]);

        }//end of the resetAction Function

        /**
         * resetPasswordAction Function - resets the User's password
         * @return void
         */
        public function resetPasswordAction()
        {
            $token = $_POST['token'];

            $user = $this->getUserOrExit($token);

            if ($user->resetPassword($_POST['password'])) {

                echo "password valid";

            } else {

                View::renderTemplate('password/reset.html', [
                    'token' => $token,
                    'user' => $user
                ]);

            }

        }// end of the resetPasswordAction Function

        /**
         * getUserOrExit Function - finds the User model associated with the password reset
         * token, or end the request with a message
         * @param string $token Password reset token sent to user
         * @return mixed User object if found and the token hasn't expired, null otherwise
         */
        protected function getUserOrExit($token)
        {
            $user = User::findByPasswordReset($token);

            if ($user) {

                return $user;

            } else {

                View::renderTemplate('password/token_expired.html');
                exit;

            }
        }//end of the getUserOrExit Function

    }//end of the Password Class