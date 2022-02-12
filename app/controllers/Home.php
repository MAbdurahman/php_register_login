<?php

    namespace app\controllers;

    use app\Auth;
    use core\View;

    /**
     * Home controller
     * PHP version 8.0.13
     */
    class Home extends \core\Controller
    {
        /**
         * Show the index page
         *
         * @return void
         */
        public function indexAction()
        {
            View::renderTemplate('home/index.html');

        }//end before function

        /**
         * Before filter
         *
         * @return false
         */
        protected function before()
        {
//            echo "(before) ";
//            return false;

        }//end of the after function

        /**
         * After filter
         *
         * @return void
         */
        protected function after()
        {
//            echo " (after)";

        }//end of the indexAction function

    }//end of the Home class