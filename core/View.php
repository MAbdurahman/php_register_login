<?php

    namespace core;

    /**
     * View class
     * PHP version 8.0.13
     */
    class View
    {
        /**
         * Render a view file
         *
         * @param string $view  The view file
         * @param array $args  Associative array of data to display in the view (optional)
         * @return void
         */
        public static function render($view, $args = [])
        {
            extract($args, EXTR_SKIP);

            $file = dirname(__DIR__) . "/app/views/$view";  // relative to Core

            if (is_readable($file)) {
                require $file;

            } else {
                throw new \Exception("$file not found");

            }
        }//end of the render function

        /**
         * Render a view template using Twig
         *
         * @param string $template  The template file
         * @param array $args  Associative array of data to display in the view (optional)
         *
         * @return void
         */
        public static function renderTemplate($template, $args = [])
        {
            static $twig = null;

            if ($twig === null) {
                $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/app/views');
                $twig = new \Twig_Environment($loader);
                $twig->addGlobal('is_logged_in', \app\Auth::isLoggedIn());

            }

            echo $twig->render($template, $args);
        }//end of renderTemplate function

    }//end of the class View