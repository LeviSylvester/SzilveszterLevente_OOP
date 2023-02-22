<?php
class ConexiuneBD {
    private $host = "localhost";
    private $utilizator = "root";
    private $parola = "";
    private $nume_baza_de_date = "revista_online";
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->nume_baza_de_date";
            $this->pdo = new PDO($dsn, $this->utilizator, $this->parola);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Conectare esuata: " . $e->getMessage());
        }
    }

    public function obtinePDO() {
        return $this->pdo;
    }
}