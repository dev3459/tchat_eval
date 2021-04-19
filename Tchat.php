<?php
session_start();
require_once './Classes/DB.php';

//Creating a $task variable with a default value of list
$task = "list";

//If the GET of task exists then we save the GET task in the variable $task
if(isset($_GET['task'])){
    $task = $_GET['task'];
}

//If the $task variable has a precise value then it calls the corresponding function otherwise it displays the messages
if($task === "write"){
    postMessage();
}elseif($task === "connexion") {
    MessageConnexion();
}elseif($task === "deconnexion") {
    MessageDeconnexion();
}else{
    getMessages();
}

//Function that displays the messages that are stored in the database
function getMessages(){
    $db = new DB();
    $request = $db->getDbLink();
    $resultats = $request->query("SELECT message.date_publish, user.pseudo, message.message FROM message, user WHERE message.user_fk = user.id ORDER BY date_publish DESC LIMIT 20");
    $messages = $resultats->fetchAll();
    echo json_encode($messages);
}

//Function to record a message in the DB
function postMessage(){
    if(!isset($_POST['user_fk']) || !isset($_POST['message'])){
        echo json_encode(["status" => "error", "message" => "Merci de renseigner les champs obligatoire"]);
        return;
    }

    $user_fk = $_POST['user_fk'];
    $message = $_POST['message'];

    $db = new DB();
    $request = $db->getDbLink();
    $query = $request->prepare("INSERT INTO message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => $message,
        ":user_fk" => $user_fk
    ]);
}

//Function to display a connection message
function MessageConnexion(){
    $db = new DB();
    $request = $db->getDbLink();

    $query = $request->prepare("INSERT INTO message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => "L'utilisateur " . $_SESSION['user']['pseudo'] . " viens de se connecter !",
        ":user_fk" => 1
    ]);

    header('Location: ./index.php');
}

//Function to display a disconnection message
function MessageDeconnexion(){
    $db = new DB();
    $request = $db->getDbLink();

    $query = $request->prepare("INSERT INTO message SET message = :message, user_fk = :user_fk");
    $query->execute([
        ":message" => "L'utilisateur " . $_SESSION['user']['pseudo'] . " viens de se déconnecter !",
        ":user_fk" => 1
    ]);

    header('Location: ./connect.php?deconnexion=0604');
}