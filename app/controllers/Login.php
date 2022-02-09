<?php

    namespace app\controllers;

    use app\Auth;
    use app\models\User;
    use core\View;
    use app\Flash;

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
            $remember_me = isset($_POST['remember_me']);

            if ($user) {

                Auth::login($user, $remember_me);

                Flash::addMessage('Successful login');
                $this->redirect(Auth::getReturnToPage());


            } else {

                Flash::addMessage('Unsuccessful login, try again!', Flash::WARNING);
                View::renderTemplate('login/new.html', [
                    'email' => $_POST['email'],
                    'remember_me' => $remember_me
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
            $this->redirect('/login/show-logout-message');

        }//end of the destroyAction Function

        /**
         * showLogoutMessageAction Function - shows a 'logged out' flash message and redirect to the
         * homepage.  Necessary to use the flash messages as they use the session and at the end of
         * logout method (destroyAction).  The session is destroyhed so a new action needs to called
         * in order to use the session.
         * @return void
         */
        public function showLogoutMessageAction()
        {
            Flash::addMessage('Logout successful');

            $this->redirect('/');

        }//end of the showLogoutMessageAction Function

    }//end of the Login Class