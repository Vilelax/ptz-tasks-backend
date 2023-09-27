<?php

namespace Source\Core;

use PDO;
use Exception;
use PDOException;

final class Connection{

    private static ?PDO $connection = null;

    /**
     * @throws Exception
     */
    private function __construct(){

    }

    public static function getConnection(): PDO{
        if(self::$connection == NULL){
            self::$connection = self::make(self::load());
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->exec("set names utf8");
        }
        return self::$connection;
    }

    private static function load(): array{
        return [
            "dbms" => DB_DBMS,
            "hostname" => DB_HOSTNAME,
            "port" => DB_PORT,
            "database" => DB_DATABASE,
            "username" => DB_USERNAME,
            "password" => DB_PASSWORD
        ];
    }

    /**
     * @throws Exception
     */
    private static function make(array $data): ?PDO{

        $dbms = isset($data['dbms']) ? $data['dbms'] : NULL;
        $hostname = isset($data['hostname']) ? $data['hostname'] : NULL;
        $port = isset($data['port']) ? $data['port'] : NULL;
        $database = isset($data['database']) ? $data['database'] : NULL;
        $username = isset($data['username']) ? $data['username'] : NULL;
        $password = isset($data['password']) ? $data['password'] : NULL;
    
        if(!is_null($dbms)) {


            try{
                switch (strtoupper($dbms)) {
                    case 'MYSQL' :
                        $port = isset($port) ? $port : 3306 ; return new PDO("mysql:host={$hostname};port={$port};dbname={$database}", $username, $password);
                        break;
                    case 'MSSQL' :
                        $port = isset($port) ? $port : 1433 ;return new PDO("mssql:host={$hostname},{$port};dbname={$database}", $username, $password);
                        break;
                    case 'PGSQL' :
                        $port = isset($port) ? $port : 5432 ;return new PDO("pgsql:dbname={$database}; user={$username}; password={$password}, host={$hostname};port={$port}");
                        break;
                    case 'SQLITE' :
                        return new PDO("sqlite:{$database}");
                        break;
                    case 'OCI8' :
                        return new PDO("oci:dbname={$database}", $username, $password);
                        break;
                    case 'FIREBIRD' :
                        return new PDO("firebird:dbname={$database}",$username, $password);
                        break;
                }
            }catch(PDOException $exception) {
                echo $exception->getMessage();
            }
        } else {
            throw new Exception('Error: database type was not informed');

        }
        return null;
    }

    private function __clone(){

    }

}