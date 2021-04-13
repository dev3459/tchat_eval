<?php
session_start();

class Connexion extends DB
{
    public static function Connect(string $pseudo, string $password){
        session_unset();
        $pseudo = strip_tags($pseudo);
        $password = strip_tags($password);

        $request = self::getInstance();
        $result = $request->prepare("SELECT pseudo, email, password FROM tchat.user WHERE pseudo = :pseudo");
        $result->bindValue(":pseudo", $pseudo);
        $result->execute();

        if($result->rowCount() > 0){
            $data = $result->fetchAll();
            if(password_verify($password, $data[0]["password"])){
                $_SESSION['user']['pseudo'] = $pseudo;
                $_SESSION['user']['email'] = $data[0]["email"];
                header('Location: ./index.php');
            }else{
                header("Location: ./index.php?error=L'utilisateur ou le mot de passe est incorrect");
            }
        }else{
            header("Location: ./index.php?error=L'utilisateur ou le mot de passe est incorrect");
        }
    }

    public static function Inscription(string $pseudo, string $email, string $password, string $passwordConfirm){
        session_unset();
        $pseudo = strip_tags($pseudo);
        $email = strip_tags($email);
        $password = strip_tags($password);
        $passwordConfirm = strip_tags($passwordConfirm);

        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            if($password === $passwordConfirm){
                $request = self::getInstance();
                $result = $request->prepare("SELECT pseudo FROM tchat.user WHERE pseudo = :pseudo OR email = :email");
                $result->bindValue(":pseudo", $pseudo);
                $result->bindValue(":email", $email);
                $result->execute();

                if($result->rowCount() > 0){
                    header("Location: ./index.php?error=Le pseudo est déjà utilisé");
                }else{
                    $result = $request->prepare("INSERT INTO tchat.user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
                    $result->bindValue(":pseudo", $pseudo);
                    $result->bindValue(":email", $email);
                    $result->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
                    $result->execute();
                    header("Location: ../index.php?success=L'utilisateur " . $_SESSION['user'] . " viens d'être créer avec succès !");
                }
            }else{
                header('Location: ../index.php?error=Les mots de passes ne correspondent pas');
            }
        }else{
            header('Location: ../index.php?error=Merci de renseigner une adresse email valide');
        }
    }
}