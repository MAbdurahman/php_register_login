<?php

    namespace app\controllers;

    use app\Flash;
    use \core\View;
    use \app\Auth;

    /**
     * Profile.php - is a \app\controllers\Profile class
     * @version 8.0.13
     */
    class Profile extends Authenticated
    {
        /**
         * before Function - before filter called before each action method
         * @return void
         */
        protected function before()
        {
            parent::before();

            $this->user = Auth::getUser();

        }//end of the before Function

        /**
         * showAction Function - show the User's profile page
         * @return void
         */
        public function showAction()
        {
            View::renderTemplate('profile/show.html', [
                'user' => $this->user
            ]);

        }//end of the showAction Function

        /**
         * editAction - shows the form for editing the User's profile
         * @return void
         */
        public function editAction()
        {
            View::renderTemplate('profile/edit.html', [
                'user' => $this->user
            ]);

        }//end of the editAction Function

        /**
         * updateAction Function - updates the User's profile
         * @return void
         */
        public function updateAction()
        {

            if ($this->user->updateProfile($_POST)) {

                Flash::addMessage('Changes saved');

                $this->redirect('/profile/show');

            } else {

                View::renderTemplate('profile/edit.html', [
                    'user' => $this->user
                ]);

            }
        }//end of the updateAction Function

    }//end of the Profile Class