<?php

    namespace app\controllers;

    use core\View;

    /**
     * Home controller
     * PHP version 8.0.13
     */
    class Home extends \core\Controller
    {
        /**
         * Before filter
         *
         * @return false
         */
        protected function before()
        {
//            echo "(before) ";
//            return false;

        }//end before function

        /**
         * After filter
         *
         * @return void
         */
        protected function after()
        {
//            echo " (after)";

        }//end of the after function

        /**
         * Show the index page
         *
         * @return void
         */
        public function indexAction()
        {
/*            View::render('Home/index.php', [
                'name'    => 'Mahdi',
                'colours' => ['red', 'green', 'blue']
            ]);*/

            View::renderTemplate('home/index.html', [
                'name'    => 'Mahdi',
                'colors' => ['red', 'green', 'blue']
            ]);

        }//end of the indexAction function

    }//end of the Home class