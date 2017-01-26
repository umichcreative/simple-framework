<?php

/** DATABASE CONNECTIVITY **/
/* COPY THIS TO theme/config.php to enable database connectivity
require( SFW_PATH .'db.php' );
Db::config(array(
    'host'     => 'localhost',
    'port'     => 3306,
    'database' => '',
    'username' => '',
    'password' => '',
    'prefix'   => ''
));
/**/

// path to fw dir
define( 'SFW_PATH', __DIR__ . DIRECTORY_SEPARATOR );
// path to site
define( 'SFW_ROOT', dirname( SFW_PATH ) . DIRECTORY_SEPARATOR );
// url base path
define(
    'SFW_BASE',
    rtrim( str_replace(
        DIRECTORY_SEPARATOR, '/',
        ('/'. str_replace( $_SERVER['DOCUMENT_ROOT'], '', SFW_ROOT ))
    ), '/' ) .'/'
);

require_once( SFW_PATH .'uri.php' );
require_once( SFW_PATH .'template.php' );

Template::execute();
