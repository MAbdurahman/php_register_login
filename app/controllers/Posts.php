<?php

    namespace  app\controllers;

    use \core\View;
    use app\models\Post;

    /**
     * Posts controller
     * PHP version 8.0.13
     */
    class Posts extends \core\Controller
    {

        /**
         * Show the index page
         *
         * @return void
         */
        public function indexAction()
        {
//            echo 'Hello from the index action in the Posts controller!';
//            echo '<p>Query string parameters: <pre>' .
//                htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
            $posts = Post::getAll();

            View::renderTemplate('Posts/index.html', [
                'posts' => $posts
            ]);

        }//end of indexAction function

        /**
         * Show the add new page
         *
         * @return void
         */
        public function addNewAction()
        {
            echo 'Hello from the addNew action in the Posts controller!';

        }//end of the addNewAction function

        /**
         * Show the edit page
         *
         * @return void
         */
        public function editAction()
        {
            echo 'Hello from the edit action in the Posts controller!';
            echo '<p>Route parameters: <pre>' .
                htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';

        }// end of the editAction function

    }//end of the Post Class
