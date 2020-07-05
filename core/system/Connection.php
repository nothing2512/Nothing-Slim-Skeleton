<?php

class Connection
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $stmt;

    public function __construct()
    {
        $this->create();
    }

    private function create()
    {
        $host = Config::DB_HOST;
        $user = Config::DB_USER;
        $pass = Config::DB_PASS;
        $name = Config::DB_NAME;

        $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->pdo = $pdo;
    }

    private function _parse ( $object, $data, $i = 0 ) {

        if ( !isset($data[0]) ) return $object($data);

        $data[$i] = $object($data[$i]);

        if ( $i < sizeof($data) - 1 ) return $this->_parse($object, $data, $i + 1);

        return $data;
    }

    private function _fetch( $data, $object = null) {

        $this->_close();

        return $object != null ? $this->_parse($object, $data) : $data;
    }

    protected function fetch ($object = null ) {

        $data = $this->stmt->fetch();

        if ($data == false) return null;

        return ( object ) $this->_fetch($data, $object);
    }

    protected function fetchAll ( $object = null ) {

        $data = $this->stmt->fetchAll();

        if ($data == false) return [];

        return ( array ) $this->_fetch($data, $object);
    }

    protected function query ( $query, $params = []) {

        try {
            if (is_null($this->pdo)) $this->create();

            $stmt = $this->pdo->prepare($query);

            $stmt->execute($params);

            $this->stmt = $stmt;
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>";
            echo json_encode($params) . "<br>";
            foreach ($params as $key => $value) {
                $query = str_replace($key, $value, $query);
            }
            echo  $query; die();
        }
    }

    protected function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    private function _close() {

        $this->pdo = null;
        $this->stmt = null;
    }
}
