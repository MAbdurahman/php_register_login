<?php

    namespace app\controllers\admin;

    /**
     * Users admin controller
     * PHP version 8.0.13
     */
    class Users extends \core\Controller
    {
        /**
         * Before filter
         *
         * @return void
         */
        protected function before()
        {
            // Make sure an admin user is logged in for example
            // return false;
        }//end of the before function

        /**
         * Show the index page
         *
         * @return void
         */
        public function indexAction()
        {
            echo 'User admin index';

        }//end of the indexAction function

    }//end of the User Class