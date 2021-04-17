<?php
session_start();
require_once './Classes/DB.php';

$task = "list";

if(isset($_GET['task'])){
    $task = $_GET['task'];
}

if($task === "write"){
    postMessage();
}elseif($task === "connexion") {
    MessageConnexion();
}elseif($task === "deconnexion") {
    MessageDeconnexion();
}else{
    getMessages();
}

function getMessages(){
    $db = new DB();
    $request = $db->getDbLink();
    $resultats = $request->query("SELECT message.date_publish, user.pseudo, message.message FROM tchat.message, tchat.user WHERE message.user_fk = user.id ORDER BY date_publish DESC LIMIT 20");
    $messages = $resultats->fetchAll();
    echo json_encode($messages);
}

function postMessage(){
    if(!isset($_POST['user_fk']) || !isset($_POST['message'])){
        echo json_encode(["status" => "error", "message" => "Merci de renseigner les champs obligatoire"]);
        return;
    }

    $user_fk = $_POST['user_fk'];
    $message = $_POST['message'];

    $db = new DB();
    $request = $db->getDbLink();
    $query = $request->prepare("INSERT INTO tchat.message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => $message,
        ":user_fk" => $user_fk
    ]);

    echo json_encode(["status" => "success"]);
}

function MessageConnexion(){
    $db = new DB();
    $request = $db->getDbLink();

    $query = $request->prepare("INSERT INTO tchat.message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => "L'utilisateur " . $_SESSION['user']['pseudo'] . " viens de se connecter !",
        ":user_fk" => 1
    ]);

    header('Location: ./index.php');
}

function MessageDeconnexion(){
    $db = new DB();
    $request = $db->getDbLink();

    $query = $request->prepare("INSERT INTO tchat.message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => "L'utilisateur " . $_SESSION['user']['pseudo'] . " viens de se déconnecter !",
        ":user_fk" => 1
    ]);

    header('Location: ./connect.php?deconnexion=0604');
}