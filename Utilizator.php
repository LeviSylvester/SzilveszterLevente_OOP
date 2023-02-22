<?php
require_once 'ConexiuneBD.php';
class Utilizator {
    private $id;
    private $nume_utilizator;
    private $parola;
    private $tip_utilizator;
    private $conexiune_bd;

    public function __construct($id = null) {
        $this->conexiune_bd = new ConexiuneBD();
        if($id) {
            $sql = "SELECT * FROM utilizatori WHERE id = ?";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([$id]);
            $utilizator = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $id;
            $this->nume_utilizator = $utilizator['nume_utilizator'];
            $this->parola = $utilizator['parola'];
            $this->tip_utilizator = $utilizator['tip_utilizator'];
        }
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNumeUtilizator($nume_utilizator) {
        $this->nume_utilizator = $nume_utilizator;
    }

    public function setParola($parola) {
        $this->parola = password_hash($parola, PASSWORD_DEFAULT);
    }

    public function setTipUtilizator($tip_utilizator) {
        $this->tip_utilizator = $tip_utilizator;
    }

    public function getId() {
        return $this->id;
    }

    public function getNume() {
        return $this->nume_utilizator;
    }

    public function getParola() {
        return $this->parola;
    }

    public function getTipUtilizator() {
        return $this->tip_utilizator;
    }

    public function salveaza() {
        if($this->id) {
            $sql = "UPDATE utilizatori SET nume_utilizator = ?, parola = ?, tip_utilizator = ? WHERE id = ?";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([
                $this->nume_utilizator,
                $this->parola,
                $this->tip_utilizator,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO utilizatori (nume_utilizator, parola, tip_utilizator) VALUES (?, ?, ?)";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([
                $this->nume_utilizator,
                $this->parola,
                $this->tip_utilizator
            ]);
            $this->id = $this->conexiune_bd->obtinePDO()->lastInsertId();
        }
    }

    public function sterge() {
        if($this->id) {
            $sql = "DELETE FROM utilizatori WHERE id = ?";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([$this->id]);
            $this->id = null;
        }
    }

    public static function toate() {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM utilizatori";
        $stmt = $conexiune_bd->obtinePDO()->query($sql);
        $utilizatori = [];
        while($utilizator = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilizatori[] = new Utilizator($utilizator['id']);
        }
        return $utilizatori;
    }

    public static function autentifica($nume_utilizator, $parola) {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM utilizatori WHERE nume_utilizator = ?";
        $stmt = $conexiune_bd->obtinePDO()->prepare($sql);
        $stmt->execute([$nume_utilizator]);
        $utilizator = $stmt->fetch(PDO::FETCH_ASSOC);
        if($utilizator && password_verify($parola, $utilizator['parola'])) {
            return new Utilizator($utilizator['id']);
        }
        return false;
    }

    public function esteAutor() {
        return $this->tip_utilizator == 'autor';
    }

    public function esteEditor() {
        return $this->tip_utilizator == 'editor';
    }

    public function esteCititor() {
        return $this->tip_utilizator == 'cititor';
    }
}
