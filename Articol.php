<?php
require_once 'ConexiuneBD.php';
require_once 'Utilizator.php';
class Articol {
    private $id;
    private $titlu;
    private $continut;
    private $data_publicarii;
    private $id_utilizator;
    private $status;
    private $categorie;
    private $conexiune_bd;

    public function __construct($id = null) {
        $this->conexiune_bd = new ConexiuneBD();
        if ($this->conexiune_bd) {
            if ($id) {
                $sql = "SELECT * FROM articole WHERE id = ?";
                $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
                $stmt->execute([$id]);
                $articol = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $id;
                $this->titlu = $articol['titlu'];
                $this->continut = $articol['continut'];
                $this->data_publicarii = $articol['data_publicarii'];
                $this->id_utilizator = $articol['id_utilizator'];
                $this->status = $articol['status'];
                $this->categorie = $articol['categorie'];
            }
        } else {
            echo "Conexiunea la baza de date nu a putut fi realizată.";
        }
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitlu($titlu) {
        $this->titlu = $titlu;
    }

    public function setContinut($continut) {
        $this->continut = $continut;
    }

    public function setDataPublicarii($data_publicarii) {
        $this->data_publicarii = $data_publicarii;
    }

    public function setIdUtilizator($id_utilizator) {
        $this->id_utilizator = $id_utilizator;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitlu() {
        return $this->titlu;
    }

    public function getContinut() {
        return $this->continut;
    }

    public function getDataPublicarii() {
        return $this->data_publicarii;
    }

    public function getIdUtilizator() {
        return $this->id_utilizator;
    }

    public function getUtilizator() {
        $utilizator = new Utilizator($this->id_utilizator);
        return $utilizator;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function salveaza() {
        if($this->id) {
            $sql = "UPDATE articole SET titlu = ?, continut = ?, data_publicarii = ?, id_utilizator = ?, status = ?, categorie = ?";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([
                $this->titlu,
                $this->continut,
                $this->data_publicarii,
                $this->id_utilizator,
                $this->status,
                $this->categorie,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO articole (titlu, continut, data_publicarii, id_utilizator, status, categorie) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([
                $this->titlu,
                $this->continut,
                $this->data_publicarii,
                $this->id_utilizator,
                $this->status,
                $this->categorie
            ]);
            $this->id = $this->conexiune_bd->obtinePDO()->lastInsertId();
        }
    }

    public function sterge() {
        if($this->id) {
            $sql = "DELETE FROM articole WHERE id = ?";
            $stmt = $this->conexiune_bd->obtinePDO()->prepare($sql);
            $stmt->execute([$this->id]);
            $this->id = null;
        }
    }

    public static function ultimeleArticole($limit = 5) { // parametrul e optional, daca nu se da valoare in index.php, default va fi 5
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM articole ORDER BY data_publicarii DESC LIMIT $limit";
        $stmt = $conexiune_bd->obtinePDO()->query($sql);
        $articole = [];
        while ($articol = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articole[] = new Articol($articol['id']);
        }
        return $articole;
    }

    public static function toate() {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM articole WHERE status = 'aprobat' ORDER BY data_publicarii DESC LIMIT 5";
        $stmt = $conexiune_bd->obtinePDO()->query($sql);
        $articole = [];
        while($articol = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articole[] = new Articol($articol['id']);
        }
        return $articole;
    }

    public static function toateCategorii() {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT categorie FROM articole WHERE status = 'aprobat' GROUP BY categorie";
        $stmt = $conexiune_bd->obtinePDO()->query($sql);
        $categorii = [];
        while($categorie = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorii[] = $categorie['categorie'];
        }
        return $categorii;
    }

    public static function toateDinCategorie($categorie) {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM articole WHERE status = 'aprobat' AND categorie = ? ORDER BY data_publicarii DESC";
        $stmt = $conexiune_bd->obtinePDO()->prepare($sql);
        $stmt->execute([$categorie]);
        $articole = [];
        while($articol = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articole[] = new Articol($articol['id']);
        }
        return $articole;
    }

    public static function gasesteDupaId($id) {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM articole WHERE id = ? AND status = 'aprobat'";
        $stmt = $conexiune_bd->obtinePDO()->prepare($sql);
        $stmt->execute([$id]);
        $articol = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($articol) {
            return new Articol($articol['id']);
        } else {
            return null;
        }
    }

    public static function toateNeaprobate() {
        $conexiune_bd = new ConexiuneBD();
        $sql = "SELECT * FROM articole WHERE status = 'neaprobat' ORDER BY data_publicarii DESC";
        $stmt = $conexiune_bd->obtinePDO()->query($sql);
        $articole = [];
        while($articol = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articole[] = new Articol($articol['id']);
        }
        return $articole;
    }

    public function aproba() {
        $this->setStatus('aprobat');
        $this->salveaza();
    }

    public function respinge() {
        $this->setStatus('respins');
        $this->salveaza();
    }

    public function esteAprobat() {
        return $this->status == 'aprobat';
    }

    public function esteNeaprobat() {
        return $this->status == 'neaprobat';
    }

    public function esteRespins() {
        return $this->status == 'respins';
    }

    public function esteProprietarul($utilizator) {
        return $this->id_utilizator == $utilizator->getId();
    }
}
