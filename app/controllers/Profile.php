<?php

    namespace app\controllers;

    use \core\View;

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
            View::renderTemplate('profile/show.html');

        }//end of the showAction Function

    }//end of the Profile Class