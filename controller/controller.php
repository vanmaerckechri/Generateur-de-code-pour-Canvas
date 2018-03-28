<?php
require('./model/model.php');
$auth = new Authentification();
//ACTIVATION D'UN COMPTE!
if (isset($_GET['code']) && $_GET['action'] === "log" && $_GET['log'] === "in")
{
	$code = $auth->filterInputs($_GET['code'], "alnum");
	//Chargement DB.
	//require('humhum.php');
	$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
	$crud = new Crud($dbCoordinates);
	//Verification code existe et si le compte doit être activé.
	$columns = array ("id");
	$whereDyn = array ("activateCode" => array($code), "activate" => array("0"));
	$operator = "AND";
	$memberToActivate = $crud->select($columns, $whereDyn, $operator);
	if (isset($memberToActivate[0]['id']) && !empty($memberToActivate[0]['id']))
	{
		$columns = array ("activate" => array("1"));
		$whereDyn = array ("id" => array($memberToActivate[0]['id']));
		$operator = "OR";
		$members = $crud->update($columns, $whereDyn, $operator);
		$_SESSION['smsAuth'] = "Votre compte vient d'être activé!";
	}
}
//ENREGISTRER UN NOUVEAU COMPTE.
if (isset($_POST['register']))
{
	//Récuperation des données d'enregistrement pour un nouveau compte utilisateur.
	$newMemberDatas = array();
	$newMemberDatas = $auth->register();
	//Si les inputs sont corrects...
	if (count($newMemberDatas) == 4)
	{
		//Chargement DB.
		//require('humhum.php');
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
			$columns = array ("login" => array($newMemberDatas[0]), "password" => array($newMemberDatas[1]), "mail" => array($newMemberDatas[2]), "activateCode" => array($newMemberDatas[3]));
			$whereDyn = array();
			$operator = "";
			$crud->insert($columns, $whereDyn, $operator);
			$sendMail = new ActivationCode();
			$sendMail-> sendMail($newMemberDatas[2], $newMemberDatas[3]);
		}
		else
		{
			$auth->memberAlreadyExist($memberAlreadyExist, $newMemberDatas[0], $newMemberDatas[2]);
		}
	}
}

//TENTATIVES D'AUTHENTIFICATION.
$auth->auth();
//Récupérer les valeurs 'login' et 'pwd' de session
$sessionLoginInfo = $auth->sessionInfo();
//Chargement DB.
//require('humhum.php');
$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
$crud = new Crud($dbCoordinates);
$columns = array ("activateCode", "activate", "mail");
$whereDyn = array ("login" => array($sessionLoginInfo['login']), "password" => array($sessionLoginInfo['password']));
$operator = "AND";
//Verifier si ces valeurs correspondent à l'un des membres de la DB.
$memberExist = $crud->select($columns, $whereDyn, $operator);
//Passer la variable 'sessionAuthOk' en 'true' ou 'false' pour afficher les options de membres.
$sessionAuthOk = $auth->testConnexion($memberExist);

//DECO VOLONTAIRE!
if (isset($_GET['log']) && $_GET['log'] === 'out')
{
    $sessionAuthOk = $auth->disconnect();
}

//SENDMAIL-SMS!
if (isset($_POST['sendmailactive']))
{
	$sendMail = new ActivationCode();
	$sendMail->sendMail($_POST['mail'], $_POST['activecode']);
}

//VIEWS!
function home()
{
    require('./view/indexView.php');
}
function auth()
{
	require('./view/logView.php');
}
function test()
{
	require('./view/galleryView.php');
}