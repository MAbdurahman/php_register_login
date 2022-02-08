<?php

    namespace app;

    /**
     * Flash Class - flashes notification messages for one-time display using the
     * session for storage between request
     * PHP version 8.0.13
     */
    class Flash
    {
        /**
         * addMessage Function - adds a message
         * @param string $message  The message content
         * @return void
         */
        public static function addMessage($message)
        {
            // Create array in the session if it doesn't already exist
            if (! isset($_SESSION['flash_notifications'])) {
                $_SESSION['flash_notifications'] = [];
            }

            // Append the message to the array
            $_SESSION['flash_notifications'][] = $message;

        }//end of the addMessage Function

        /**
         * getMessages Function - get all the messages
         * @return mixed  An array with all the messages or null if none set
         */
        public static function getMessages()
        {
            if (isset($_SESSION['flash_notifications'])) {
                $messages = $_SESSION['flash_notifications'];
                unset($_SESSION['flash_notifications']);

                return $messages;
            }
        }//end of the getMessages Function

    }//end of the Flash Class