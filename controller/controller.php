<?php
require('./model/model.php');
$auth = new Authentification();

if (isset($_POST['register']))
{
	//Récuperation des données d'enregistrement pour un nouveau compte utilisateur.
	$newMemberDatas = array();
	$newMemberDatas = $auth->register();
	//Si les inputs sont corrects...
	if (count($newMemberDatas) == 4)
	{
		//Chargement DB.
		$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
		$crud = new Crud($dbCoordinates);
		//Verification membre pas encore présent dans la DB.
		$columns = array ("login", "mail");
		$whereDyn = array ("login" => array($newMemberDatas[0]), "mail" => array($newMemberDatas[2]));
		$operator = "OR";
		$memberAlreadyExist = $crud->select($columns, $whereDyn, $operator);
		//Si le membre n'est pas encore présent dans la DB...
		if (!$memberAlreadyExist)
		{

			//Enregistrement.
			$columns = array ("login" => array($newMemberDatas[0]), "password" => array($newMemberDatas[1]), "mail" => array($newMemberDatas[2]), "activate" => array($newMemberDatas[3]));
			$whereDyn = array();
			$operator = "";
			$crud->insert($columns, $whereDyn, $operator);
			$_SESSION['smsAuth'] = "Vous venez de recevoir un lien de validation dans votre boîte mail!";
			header('Location: index.php?action=log&log=in');
		}
		else
		{
			$auth->memberAlreadyExist($memberAlreadyExist, $newMemberDatas[0], $newMemberDatas[2]);
		}
	}
}

//Tentatives d'authentification.
$auth->auth();
//Récupérer les valeurs 'login' et 'pwd' de session
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
$sessionAuthOk = $auth->testConnexion($memberExist);

//Deco volontaire.
if (isset($_GET['log']) && $_GET['log'] === 'out')
{
    $sessionAuthOk = $auth->disconnect();
}

function home()
{
    require('./view/indexView.php');
}
function auth()
{
	require('./view/logView.php');
}
