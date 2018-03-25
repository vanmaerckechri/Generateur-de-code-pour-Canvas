<?php

require('./model/model.php');
//Récupérer les valeurs 'login' et 'pwd' de session
$auth = new Authentification();
$sessionLoginInfo = $auth->sessionInfo();
//Utiliser les informations de session en condition lors d'une requête 'select' pour voir si le membre existe.
$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
$crud = new Crud($dbCoordinates);
$columns = array ("id");
$whereDyn = array ("login" => array($sessionLoginInfo[0]), "password" => array($sessionLoginInfo[1]));
$operator = "AND";
$memberExist = $crud->select($columns, $whereDyn, $operator);
//Passer la variable 'sessionAuthOk' en 'true' ou 'false' pour autoriser ou non ce qui sera chargé sur la page.
$sessionAuthOk = $auth->testConnection($memberExist);

echo $sessionAuthOk;

function home()
{
    require('./view/indexView.php');
}