<?php

namespace Source\Core;

use PDO;
use Exception;

abstract class Model{
    
    private static PDO $connection;

    private array $data;

    protected string $table;

    protected string $idField;

    protected bool $logTimestamp;

    public function __construct(){
        static::setConnection(Connection::getConnection());
    }

    public function __set(string $key, mixed $value){

        $this->data[$key] = $value;

    }

    public function __get(string $key): mixed{

        return $this->data[$key];

    }

    public static function setConnection(PDO $connection){
        static::$connection = $connection;
    }

    private function format($value){

        if (is_string($value) && !empty($value)) {

            return "'" . addslashes($value) . "'";

        } else if (is_bool($value)) {

            return $value ? 'TRUE' : 'FALSE';

        } else if ($value !== '') {

            return $value;

        } else {

            return "NULL";

        }
    }

    private function convertData(): array{

        $newData = [];

        foreach ($this->data as $key => $value) {
            
            if (is_scalar($value)) {

                $newData[$key] = $this->format($value);

            }

        }

        return $newData;
    }

    /**
     * @throws Exception
     */
    public function save(){

        $newData = $this->convertData();
 
        if (isset($this->data[$this->idField])) {

            $sets = [];

            foreach ($newData as $key => $value) {

                if ($key == $this->idField) continue;

                $sets[] = "{$key} = {$value}";
            }

            if($this->logTimestamp === TRUE){

                $sets[] = "updated_at = '" . date('Y-m-d H:i:s') . "'";
            
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->idField} = {$this->data[$this->idField]};";

            echo $sql;

        } else {

            if($this->logTimestamp == TRUE){

                $newData['created_at'] = "'" . date('Y-m-d H:i:s') . "'";
                
                $newData['updated_at'] = "'" . date('Y-m-d H:i:s') . "'"; 

            }

            $sql = "INSERT INTO {$this->table} (" . implode(', ', array_keys($newData)) . ') VALUES (' . implode(',', array_values($newData)) . ');';
        
        }

        if (static::$connection) {

            return static::$connection->exec($sql);

        } else {

            throw new Exception("Error: no database connection.");

        }
    }

    /**
     * @throws Exception
     */
    public static function find(int $parameter)
    {
        $class = get_called_class();
        $idField = (new $class())->idField;
        $table = (new $class())->table;
    
        $sql = 'SELECT * FROM ' . (is_null($table) ? strtolower($class) : $table);
        $sql .= ' WHERE ' . (is_null($idField) ? 'id' : $idField);
        $sql .= " = {$parameter} ;";
    
        if (static::$connection) {

            $result = static::$connection->query($sql);
    
            if ($result) {
    
                $newObject = $result->fetchObject(get_called_class());
            }
    
            return $newObject;

        } else {

            throw new Exception("Error: no database connection.");
        
        }
    }

    /**
     * @throws Exception
     */
    public static function all(string $filter = '', int $limit = 0, int $offset = 0){

        $class = get_called_class();
        $table = (new $class())->table;
        $sql = 'SELECT * FROM ' . (is_null($table) ? strtolower($class) : $table);
        $sql .= ($filter != '') ? " WHERE {$filter}" : "";
        $sql .= ($limit > 0) ? " LIMIT {$limit}" : "";
        $sql .= ($offset > 0) ? " OFFSET {$offset}" : "";
        $sql .= ';';
    
        if (static::$connection) {
            $result = static::$connection->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } else {
            throw new Exception("Error: no database connection.");
        }

    }

    public static function findFisrt(string $filter = ''){
        return static::all($filter, 1);
    }

    /**
     * @throws Exception
     */
    public function delete(){

        if (isset($this->data[$this->idField])) {
    
            $sql = "DELETE FROM {$this->table} WHERE {$this->idField} = {$this->data[$this->idField]};";
    
            if (static::$connection) {
                return static::$connection->exec($sql);
            } else {
                throw new Exception("Error: no database connection.");
            }
        }
    }   

}