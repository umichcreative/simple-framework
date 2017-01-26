<?php

class Db
{
    static private $_db = false;
    static private $_config = array(
        'host'     => 'localhost',
        'port'     => 3306,
        'database' => '',
        'username' => '',
        'password' => '',
        'prefix'   => ''
    );

    static public function config( $config )
    {
        $config = array_merge(
            array(
                'host'     => 'localhost',
                'port'     => 3306,
                'database' => '',
                'username' => '',
                'password' => '',
                'prefix'   => ''
            ),
            $config
        );

        self::$_config = $config;
    }

    static public function query( $sql, $values = array() ) {
        self::_connect();

        $sql = str_replace( 'PREFIX_', self::$_config['prefix'], $sql );

        $stmt = self::$_db->prepare( $sql );

        foreach( $values as $key => $val ) {
            if( is_null( $val ) ) {
                $type = PDO::PARAM_NULL;
            }
            else if( is_numeric( $val ) ) {
                $type = PDO::PARAM_INT;
            }
            else {
                $type = PDO::PARAM_STR;
            }

            $length = $val ? null : 0;
            $stmt->bindParam(
                $key,
                $values[ $key ],
                $type,
                $length
            );
        }

        $res = $stmt->execute();

        return $stmt->fetchAll( PDO::FETCH_OBJ );
    }

    static private function _connect() {
        if( self::$_db ) {
            return;
        }

        try {
            $port = self::$_config['port'] ? ';port='. self::$_config['port'] : null;

            self::$_db = new PDO(
                "mysql:host=". self::$_config['host'] ."{$port};dbname=". self::$_config['database'],
                self::$_config['username'],
                self::$_config['password']
            );
            self::$_db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
        } catch( PDOException $e ) {
            echo $e->getMessage();
            die('db connection error');
        }
    }
}
