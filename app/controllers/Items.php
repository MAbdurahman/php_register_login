<?php

    namespace app\controllers;

    use core\View;

    /**
     * Items Class
     * PHP version 8.0.13
     */
    class Items extends Authenticated
    {


        /**
         * indexAction Function - displays an Items index view
         * @return void
         */
        public function indexAction()
        {
            View::renderTemplate('items/index.html');

        }//end of the indexAction Function

        /**
         * newAction Function - add a new item
         * @return void
         */
        public function newAction()
        {
            echo "new action";

        }//end of the newAction Function

        /**
          showAction - displays an item
         * @return void
         */
        public function showAction()
        {
            echo "show action";

        }//end of the showAction Function

    }//end of the Items Class