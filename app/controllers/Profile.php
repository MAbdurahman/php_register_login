<?php

    namespace app\controllers;

    use \core\View;
    use \app\Auth;

    /**
     * Profile.php - is a \app\controllers\Profile class
     * @version 8.0.13
     */
    class Profile extends Authenticated
    {
        /**
         * showAction Function - show the User's profile page
         * @return void
         */
        public function showAction()
        {
            View::renderTemplate('Profile/show.html', [
                'user' => Auth::getUser()
            ]);

        }//end of the showAction Function

        /**
         * editAction - shows the form for editing the User's profile
         * @return void
         */
        public function editAction()
        {
            View::renderTemplate('profile/edit.html', [
                'user' => Auth::getUser()
            ]);

        }//end of the editAction Function

    }//end of the Profile Class