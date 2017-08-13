<?php

namespace lib;

/**
 * Description of Model
 *
 * @author Gabriel Schmidt Cordeiro <gabrielscordeiro2012@gmail.com.br>
 */
class Model extends Config {

    protected $conn;

    public function __construct() {
        try {
            $this->conn = new \PDO("mysql:host=" . self::srvMyhost . ";dbname=" . self::srvMydbname, self::srvMyuser, self::srvMypass);
            $this->conn->exec("set names" . self::charset);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    /**
     * @todo Realiza select no banco sendo passado um SQL específico
     * @param string $sql 
     * @return array $arr
     */
    public function Select($sql) {
        try {
            $state = $this->conn->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex) {
            die($ex->getMessage() . "SQL: " . $sql);
        }

        $arr = array();

        while ($row = $state->fetchObject()) {
            $arr[] = $row;
        }

        return $arr;
    }

    /**
     * @todo Realiza insert no banco sendo passado um objeto e a respectiva tabela
     * @params Object $obj, string $table
     * @return array
     */
    public function Insert($obj, $table) {
        try {
            $sql = "INSERT INTO {$table} (" . implode(",", array_keys((array) $obj)) . ") VALUES('" . implode("','", array_values((array) $obj)) . "')";
            $state = $this->conn->prepare($sql);
            $state->execute(array('widgets'));
        } catch (\PDOException $ex) {
            die($ex->getMessage() . "SQL: " . $sql);
        }
        return array(
            'success' => true,
            'feedback' => '',
            'codigo' => $this->last($table)
        );
    }

    public function Update($obj, $condiction, $table) {
        try {
            foreach ($obj as $key => $value) {
                $dados[] = "'{$key}' = " . is_null($value) ? " NULL" : "'{$value}'";
            }
            foreach ($condiction as $key => $value) {
                $where[] = "'{$key}'" . is_null($value) ? " IS NULL" : " = '{$value}'";
            }

            $sql = "UPDATE {$table} SET" . implode(",", $dados) . " WHERE " . implode(' AND', $where);

            $state = $this->conn->prepare($sql);
            $state->execute(array('widgets'));
        } catch (\PDOException $ex) {
            die($ex->getMessage() . "SQL: " . $sql);
        }

        return array(
            'success' => true,
            'feedback' => ''
        );
    }

    public function Delete($condiction, $table) {
        try {
            foreach ($condiction as $key => $value) {
                $where[] = "'{$key}'" . is_null($value) ? " IS NULL" : " = '{$value}'";
            }

            $sql = "DELETE FROM {$table} WHERE " . implode(' AND', $where);

            $state = $this->conn->prepare($sql);
            $state->execute(array('widgets'));
        } catch (\PDOException $ex) {
            die($ex->getMessage() . "SQL: " . $sql);
        }
        return array(
            'success' => true,
            'feedback' => ''
        );
    }

    /**
     * @todo retorna o ID do último registro lançado 
     * @return int $id
     */
    public function last($table) {
        try {
            $state = $this->conn->prepare("SELECT last_insert_id() AS last FROM {$table}");
            $state->execute();
            $state = $state->fetchObject();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }

        return $state->last;
    }

    /**
     * @todo recebe lista de objetos e retorna primeira linha da lista
     * @return array 
     */
    public function first($obj) {
        if (isset($obj[0])) {
            return $obj[0];
        } else {
            return null;
        }
    }

    public function setObject($obj, $values, $exists = true) {
        if (is_object($obj)) {
            if (count($values) > 0) {
                foreach ($values as $key => $value) {
                    if (property_exists($obj, $key) || $exists) {
                        $obj->key = $values->key;
                    }
                }
            }
        }
    }

}
