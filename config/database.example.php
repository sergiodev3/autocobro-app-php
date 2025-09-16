<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'nombre_base_de_datos';
    private $username = 'usuario';
    private $password = 'contraseña';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}