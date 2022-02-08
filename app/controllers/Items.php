<?php

    namespace app\controllers;

    use app\Auth;
    use core\View;

    /**
     * Items Class
     * PHP version 8.0.13
     */
    class Items extends \core\Controller
    {

        /**
         * indexAction Function - displays an Items index view
         * @return void
         */
        public function indexAction()
        {
            if (! Auth::isLoggedIn()) {
                Auth::rememberRequestedPage();
                $this->redirect('/login');
            }

            View::renderTemplate('items/index.html');

        }//end of the indexAction Function
    }//end of the Items Class