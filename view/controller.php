<?php

require('./model/model.php');
//Récupérer les valeurs 'login' et 'pwd' de session
$auth = new Authentification();
$sessionLoginInfo = $auth->updateCheckSession();
require('humhum.php');

//Utiliser les informations de session en condition lors d'une requête 'select' pour voir si le membre existe.
/*$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];*/
$crud = new Crud($dbCoordinates);
$columns = array ("id");
$whereDyn = array ("login" => array($sessionLoginInfo['login']), "password" => array($sessionLoginInfo['password']));
$operator = "AND";
$memberExist = $crud->select($columns, $whereDyn, $operator);
//Passer la variable 'sessionAuthOk' en 'true' ou 'false' pour autoriser ou non ce qui sera chargé sur la page.
$sessionAuthOk = $auth->testConnection($memberExist);

echo $sessionAuthOk;

function home()
{
    require('./view/indexView.php');
}
function auth()
{
	require('./view/logView.php');
}
if (isset($_GET['log']) && $_GET['log'] === 'out')
{
    $sessionAuthOk = $auth->disconnect();
}
