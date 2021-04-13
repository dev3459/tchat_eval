<?php
    session_start();

    require_once 'Classes/DB.php';
    $db = new DB();
    $db::getInstance();

    $action = "listing";

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action === "message"){
        $db::postMessages();
    }else{
        $db::getMessages();
    }
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style_global.css">
    <link rel="stylesheet" href="./css/style_accueil.css">
    <script src="https://kit.fontawesome.com/9e5ac608ee.js" crossorigin="anonymous"></script>
    <title>Tchat Éval</title>
</head>
<body>
    <div id="contains">
        <?php if(isset($_GET["error"])){ ?>
            <div class="error">
                <span><?= $_GET["error"] ?></span>
                <a href="#" title="Fermer la fenêtre d'erreur">X</a>
            </div>
        <?php }elseif(isset($_GET["success"])){ ?>
            <div class="success">
                <span><?= $_GET["success"] ?></span>
                <a href="#" title="Fermer la fenêtre de succès">X</a>
            </div>
        <?php } ?>

        <div id="top">
            <div id="title">
                <h1>Tchat éval</h1>
            </div>
            <div id="registration">
                <a href="connect.php" title="Connectez-vous pour pouvoir envoyé un message">Inscription / Connexion</a>
            </div>
        </div>
        <div id="tchat">
            <div id="message">
                <span class="date">21:20</span>
                <span class="author">G.G </span>
                <span>:</span>
                <span class="content">test</span>
            </div>
            <div id="writeTchat">
                <form action="#" method="POST">
                    <input type="text" name="message" placeholder="Écrivez un message ici" required>
                    <button><i class="far fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>