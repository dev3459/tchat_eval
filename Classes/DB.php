<?php
class DB{
    private string $host = 'localhost';
    private string $db = 'tchat';
    private string $user = 'root';
    private string $password = '';
    private ?PDO $dbLink;

    /**
     * DbStatic constructor
     */
    public function __construct()
    {
        $this->dbLink = $this->connect();
    }

    public function connect(){
        try {
            $db = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $Exception) {
            echo $Exception->getMessage();
        }

        return $db;
    }

    public function getDbLink(): ?PDO{
        if(is_null($this->dbLink)){
            $this->dbLink = $this->connect();
        }

        return $this->dbLink;
    }

    /**
     * On empêche de laisser d'autres développeurs de cloner l'objet
     * pour s'assurer qu'on a bel et bien qu'une seule instance de la connexion db.
     */
    public function __clone() {}
}