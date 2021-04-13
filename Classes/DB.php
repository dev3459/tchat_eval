<?php
class DB{
    private string $host = 'localhost';
    private string $db = 'tchat';
    private string $user = 'root';
    private string $password = '';

    private static ?PDO $dbInstance = null;

    /**
     * DbStatic constructor
     */
    public function __construct()
    {
        try {
            self::$dbInstance = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->password);
            self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $Exception) {
            echo $Exception->getMessage();
        }
    }

    /**
     *Retourne une instance de l'objet PDO
     */
    public static function getInstance(): ?PDO{
        if(null === self::$dbInstance){
            new self();
        }
        return self::$dbInstance;
    }

    //Function pour récupérer tout les messages du tchat.
    public static function getMessages(){
        //on sélectionne les messages
        $request = self::$dbInstance->prepare("SELECT message.date_publish, user.pseudo, message.message FROM tchat.message INNER JOIN tchat.user ON message.user_fk = user.id ORDER BY message.date_publish");
        $request->execute();
        $message = $request->fetchAll();

        echo json_encode($message);
    }

    //Fonction pour écrire un message et le sauvegarder dans la base de données.
    public static function postMessages(){
//        if(isset($_POST['author']))
//
//        $author = $_POST['author'];
//        $content = $_POST['content'];
//
//        $insert = self::$dbInstance->prepare("INSERT INTO tchat.message SET message = :message");
    }

    /**
     * On empêche de laisser d'autres développeurs de cloner l'objet
     * pour s'amuser qu'on a bel et bien qu'une seule instance de la connexion db.
     */
    public function __clone() {}
}