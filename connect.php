<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style_global.css">
    <link rel="stylesheet" href="css/style_connect.css">
    <title>Connexion / Inscription</title>
</head>
<body>
    <div id="contains">
        <form action="userExist.php" method="POST">
            <h2>Connexion</h2>
            <input type="text" name="pseudo" placeholder="Pseudo" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button name="buttonValidateC">Se connecter</button>
        </form>

        <form action="userNotExist.php" method="POST">
            <h2>Inscription</h2>
            <input type="text" name="pseudoInscript" placeholder="Votre pseudo" required>
            <input type="text" name="emailInscript" placeholder="Votre email" required>
            <input type="password" name="passwordInscript" placeholder="Créer un mot de passe" required>
            <input type="password" name="passwordConfirmInscript" placeholder="Confirmer le mot de passe" required>
            <div>
                <input type="checkbox" name="accept" id="accept">
                <Label for="accept">En cochant cette case, vous accepter les conditions générales d'utilisation de vos données personnelles.</Label>
            </div>
            <button name="buttonValidateI">S'inscrire</button>
        </form>
    </div>
</body>
</html>