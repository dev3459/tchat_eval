<?php

require_once './Classes/DB.php';
require_once './Classes/Connexion.php';


Connexion::Connect($_POST["pseudo"], $_POST["password"]);