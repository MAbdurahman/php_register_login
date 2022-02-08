<?php

    namespace app\controllers;

    /**
     * Authenticated Class -
     * PHP version 8.0.13
     */
    abstract class Authenticated extends \core\Controller
    {
        /**
         * before Function - requires the user to be authenticated before allowing
         * access to all methods in the Controller
         * @return void
         */
        protected function before()
        {
            $this->requireLogin();

        }//end of the before Function

    }//end of the Authenticated Class