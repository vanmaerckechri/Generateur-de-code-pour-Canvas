<?php

require('./model/model.php');
$auth = new Authentification();
if (isset($_GET['log']) && $_GET['log'] === 'out')
{
    $sessionAuthOk = $auth->disconnect();
}
else
{
	//Récupérer les valeurs 'login' et 'pwd' de session
	$auth->updateSession();
	$sessionLoginInfo = $auth->sessionInfo();
	//pour la version en ligne//require('humhum.php');
	//Verifier si ces valeurs correspondent à l'un des membres de la db.
	$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
	$crud = new Crud($dbCoordinates);
	$columns = array ("id");
	$whereDyn = array ("login" => array($sessionLoginInfo['login']), "password" => array($sessionLoginInfo['password']));
	$operator = "AND";
	$memberExist = $crud->select($columns, $whereDyn, $operator);
	//Passer la variable 'sessionAuthOk' en 'true' ou 'false' pour afficher les options de membres.
	$sessionAuthOk = $auth->testConnection($memberExist);
}
function home()
{
    require('./view/indexView.php');
}
function auth()
{
	require('./view/logView.php');
}

echo $sessionAuthOk;

