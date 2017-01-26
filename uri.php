<?php

class Uri
{
    static public $uri;
    static public $file;

    static public function init()
    {
        self::parse( $_SERVER['REQUEST_URI'] );
    }

    static public function parse( $uri )
    {
        self::$uri = trim(
            preg_replace(
                '/'. preg_quote( $_SERVER['QUERY_STRING'] ) .'$/',
                '',
                $_SERVER['REQUEST_URI']
            ), '?/'
        );

        /** CHECK FOR CONTROLLER **/
        // path to file
        if( is_file( SFW_ROOT . self::$uri .'.php' ) ) {
            self::$file = self::$uri .'.php';
        }
        // path to directory
        else if( is_dir( SFW_ROOT . self::$uri ) && is_file( SFW_ROOT . self::$uri . DIRECTORY_SEPARATOR .'index.php' ) ) {
            self::$file = self::$uri . DIRECTORY_SEPARATOR .'index.php';
        }
        // page not found
        else {
            header( 'HTTP/1.1 404 Not Found' );

            self::$file = 'framework/errors/404.php';
            $tmp = array( dirname( __DIR__ ), 'errors', '404.php' );
            if( file_exists( implode( DIRECTORY_SEPARATOR, $tmp ) ) ) {
                array_shift( $tmp );
                self::$file = implode( DIRECTORY_SEPARATOR, $tmp );
            }
        }
    }
}
Uri::init();
