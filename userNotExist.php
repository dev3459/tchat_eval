<?php

require_once './Classes/DB.php';
require_once './Classes/Connexion.php';

if(!isset($_POST["pseudoInscript"], $_POST["emailInscript"], $_POST["passwordInscript"], $_POST["passwordConfirmInscript"], $_POST["buttonValidateI"])){
    header("Location: ./index.php");
}

Connexion::Inscription($_POST["pseudoInscript"], $_POST["emailInscript"], $_POST["passwordInscript"], $_POST["passwordConfirmInscript"]);