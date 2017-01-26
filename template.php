<?php

class Template
{
    static private $_wrapperToken = '<!--{CONTENTS}-->';
    static private $_wrapperPath  = 'theme';
    static private $_wrappers     = array(
        'global' => 'framework/theme'
    );
    static private $_styles       = array();
    static private $_scripts      = array();
    static private $_meta         = array();
    static private $_headers      = array(
        'X-UA-Compatible' => 'IE=Edge'
    );
    static private $_vars         = array();

    static public function init()
    {
        // locate custom wrapper
        if( is_dir( SFW_ROOT .'theme' ) ) {
            self::$_wrappers['site'] = 'theme';
        }

        // load theme config (not required)
        if( is_file( SFW_ROOT .'theme'. DIRECTORY_SEPARATOR .'config.php' ) ) {
            include_once( SFW_ROOT .'theme'. DIRECTORY_SEPARATOR .'config.php' );
        }
    }

    static public function var( $name, $value = null )
    {
        if( !is_null( $value ) ) {
            self::$_vars[ $name ] = $value;
        }
        else if( isset( self::$_vars[ $name ] ) ) {
            return self::$_vars[ $name ];
        }
    }

    static public function setMeta( $type, $content )
    {
        if( $content ) {
            self::$_meta[ $type ] = $content;
        }
        else if( isset( self::$_meta[ $type ] ) ) {
            unset( self::$_meta[ $type ] );
        }
    }

    static public function setHeader( $name, $value )
    {
        if( $value ) {
            self::$_headers[ $name ] = $value;
        }
        else if( isset( self::$_headers[ $name ] ) ) {
            unset( self::$_headers[ $name ] );
        }
    }

    static public function remWrapper( $id )
    {
        if( isset( self::$_wrappers[ $id ] ) ) {
            unset( self::$_wrappers[ $id ] );
        }
    }

    static public function render( $tpl )
    {
        foreach( self::$_wrappers as $wrapper ) {
            if( is_file( SFW_ROOT . $wrapper . DIRECTORY_SEPARATOR . $tpl ) ) {
                include SFW_ROOT . $wrapper . DIRECTORY_SEPARATOR . $tpl;
            }
        }
    }

    static public function execute()
    {
        include SFW_ROOT . Uri::$file;

        // SPLIT WRAPPER TPL
        $header = '';
        $footer = '';

        // LOAD WRAPPERS AND FIND AUTOLOAD ASSETS
        foreach( self::$_wrappers as $wrapper ) {
            $tmp = array( SFW_ROOT . $wrapper, 'theme.tpl' );
            if( is_file( implode( DIRECTORY_SEPARATOR, $tmp ) ) ) {
                $parts = array_map( 'trim', explode(
                    self::$_wrapperToken,
                    file_get_contents( implode( DIRECTORY_SEPARATOR, $tmp ) )
                ) );

                $header .= "\n". $parts[0];
                $footer = $parts[1] ."\n". $footer;
            }

            // LOAD WRAPPER STYLES
            $tmp = array( SFW_ROOT . $wrapper, 'styles', '*.css' );
            foreach( glob( implode( DIRECTORY_SEPARATOR, $tmp ) ) as $style ) {
                $style = str_replace( DIRECTORY_SEPARATOR, '/', str_replace( SFW_ROOT, '', $style ) );
                self::$_styles[] = SFW_BASE . $style;
            }

            // LOAD WRAPPER SCRIPTS
            $tmp = array( SFW_ROOT . $wrapper, 'scripts', '*.js' );
            foreach( glob( implode( DIRECTORY_SEPARATOR, $tmp ) ) as $script ) {
                $script = str_replace( DIRECTORY_SEPARATOR, '/', str_replace( SFW_ROOT, '', $script ) );
                self::$_scripts[] = SFW_BASE . $script;
            }
        }

        // FIND PAGE AUTOLOAD STYLESHEET
        $tmp = array( SFW_ROOT . dirname( Uri::$file ), 'styles', str_replace( '.php', '.css', basename( Uri::$file ) ) );
        if( is_file( implode( DIRECTORY_SEPARATOR, $tmp ) ) ) {
            array_shift( $tmp );
            $style = implode( DIRECTORY_SEPARATOR, $tmp );
            $style = str_replace( DIRECTORY_SEPARATOR, '/', str_replace( SFW_ROOT, '', $style ) );
            self::$_styles[] = SFW_BASE . $style;
        }

        // FIND PAGE AUTOLOAD SCRIPT
        $tmp = array( SFW_ROOT . dirname( Uri::$file ), 'scripts', str_replace( '.php', '.js', basename( Uri::$file ) ) );
        if( is_file( implode( DIRECTORY_SEPARATOR, $tmp ) ) ) {
            array_shift( $tmp );
            $script = implode( DIRECTORY_SEPARATOR, $tmp );
            $script = str_replace( DIRECTORY_SEPARATOR, '/', str_replace( SFW_ROOT, '', $script ) );
            self::$_script[] = SFW_BASE . $script;
        }


        // SEND HEADERS
        foreach( self::$_headers as $name => $value ) {
            header( "{$name}: {$value}" );
        }

        // DISPLAY HEADER
        eval( '?>'. $header ."\n".'<?' );

        // DISPLAY PAGE CONTENT
        $tmp = array( SFW_ROOT . dirname( Uri::$file ), 'presentation', str_replace( '.php', '.tpl', basename( Uri::$file ) ) );
        if( is_file( implode( DIRECTORY_SEPARATOR, $tmp ) ) ) {
            include implode( DIRECTORY_SEPARATOR, $tmp );
        }

        // DISPLAY FOOTER
        eval( '?>'."\n". $footer .'<?' );
    }
}
Template::init();
