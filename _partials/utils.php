<?php
require_once '../Classes/DB.php';
require_once '../Classes/Connexion.php';

$db = new DB();
$link = $db->getDbLink();

//--------------- Connexion et inscription ------------------//
if (isset($_POST['buttonValidateC'])) {
    $conn = new Connexion($link);
    $conn->Connect($_POST["pseudo"], $_POST["password"]);
} elseif (isset($_POST['buttonValidateI'])) {
    if (isset($_POST['acceptCheckBox'])) {
        $inscr = new Connexion($link);
        $inscr->Inscription($_POST["pseudoInscript"], $_POST["emailInscript"], $_POST["passwordInscript"], $_POST["passwordConfirmInscript"], $_POST['acceptCheckBox']);

    } else {
        header("Location: ../connect.php?error=Merci d'accepter les conditions générales d'utilisation avant de vous inscrires !");
    }
}