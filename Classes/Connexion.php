<?php

session_start();

class Connexion
{
    private PDO $db;

    /**
     * Connection to the database through the DB class
     * @param PDO $database
     */
    public function __construct(PDO $database)
    {
        //
        $this->db = $database;
    }

    /**
     * Function for the user to log in
     * @param string $pseudo The user's nickname
     * @param string $password The user's password
     */
    public function Connect(string $pseudo, string $password)
    {
        session_unset();
        $pseudo = strip_tags($pseudo);
        $password = strip_tags($password);

        $result = $this->db->prepare("SELECT id, pseudo, email, password FROM tchat.user WHERE pseudo = :pseudo");
        $result->bindValue(":pseudo", $pseudo);
        $result->execute();

        if ($result->rowCount() > 0) {
            $data = $result->fetchAll();
            if (password_verify($password, $data[0]["password"])) {
                $_SESSION['user']['id'] = $data[0]["id"];
                $_SESSION['user']['pseudo'] = $pseudo;
                $_SESSION['user']['email'] = $data[0]["email"];
                if($_SESSION['user']['pseudo'] === "Admin"){
                    header('Location: ../index.php');
                }else{
                    header('Location: ../Tchat.php?task=connexion');
                }
            } else {
                header("Location: ../connect.php?error=L'utilisateur ou le mot de passe est incorrect");
            }
        } else {
            header("Location: ../connect.php?error=L'utilisateur ou le mot de passe est incorrect");
        }
    }

    /**
     * Function for the user to register
     * @param string $pseudo The user's nickname
     * @param string $email User email
     * @param string $password The user's password
     * @param string $passwordConfirm confirmation of the user's password
     */
    public function Inscription(string $pseudo, string $email, string $password, string $passwordConfirm)
    {
        session_unset();
        $pseudo = strip_tags($pseudo);
        $email = strip_tags($email);
        $password = strip_tags($password);
        $passwordConfirm = strip_tags($passwordConfirm);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($password === $passwordConfirm) {
                //Check if the username or email already exists
                $result = $this->db->prepare("SELECT pseudo, email FROM tchat.user WHERE pseudo = :pseudo OR email = :email");
                $result->bindValue(":pseudo", $pseudo);
                $result->bindValue(":email", $email);
                $result->execute();

                if ($result->rowCount() > 0) {
                    header("Location: ../connect.php?error=Le pseudo ou l'email est déjà utilisé");
                } else {
                    $result = $this->db->prepare("INSERT INTO tchat.user (pseudo, email, password, acceptCondition) VALUES (:pseudo, :email, :password, :acceptCondition)");
                    $result->bindValue(":pseudo", $pseudo);
                    $result->bindValue(":email", $email);
                    $result->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
                    $result->bindValue(":acceptCondition", true);
                    $result->execute();
                    header("Location: ../connect.php?success=L'utilisateur " . $pseudo . " viens d'être créer avec succès !");
                }
            } else {
                header("Location: ../connect.php?error=Les mots de passes ne correspondent pas");
            }
        } else {
            header("Location: ../connect.php?error=Merci de renseigner une adresse email valide");
        }
    }

    /**
     * On empêche de laisser d'autres développeurs de cloner l'objet
     * pour s'assurer qu'on a bel et bien qu'une seule instance de la connexion db.
     */
    public function __clone(){}
}