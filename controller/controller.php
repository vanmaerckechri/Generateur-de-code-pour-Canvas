<?php
require('./model/model.php');
//CHARGEMENT DB!
//require('humhum.php');
$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
$auth = new Authentification();
//PASSWORD OUBLIE!
	//envoi du mail et systeme pour que le lien ne fonctionne qu'une seule fois.
if (isset($_POST['lost']) && isset($_POST['mail']) && $_GET['action'] === "log" && $_GET['log'] === "lost")
{
	$mail = Authentification::filterInputs($_POST['mail'], "mail");
	$crud = new Crud($dbCoordinates);
	//Verification email valide.
	$columns = array ("id", "password");
	$whereDyn = array ("mail" => array($mail));
	$operator = "OR";
	$accountToResetPwd = $crud->select($columns, $whereDyn, $operator);
	//Si email valide => envoi un mail pour reset password.
	if (!empty($accountToResetPwd))
	{
		$id = $accountToResetPwd[0]['id'];
		$pwd = $accountToResetPwd[0]['password'];
		$rstpwd = $id.$pwd;
		$rstpwd = hash('sha256', $rstpwd);

		SendMail::lostPassword($mail, $id, $rstpwd);
	}
}
	//affichage des champs de la reinitialisation du pwd oublié (sous conditions).
if (isset($_GET['log']) && isset($_GET['rstpwd']) && $_GET['log'] == 'resetpwd')
{
	$GLOBALS['resetPwd'] = FALSE;
	//nettoyage des inputs.
	$id = Authentification::filterInputs($_GET['resetpwd'], "alnum");
	$code = Authentification::filterInputs($_GET['rstpwd'], "alnum");
	//Filtrer l'acces à la page.
	$crud = new Crud($dbCoordinates);
	$columns = array ("password");
	$whereDyn = array ("id" => array($id));
	$operator = "OR";
	$accountInfo = $crud->select($columns, $whereDyn, $operator);
	if (!empty($accountInfo))
	{
		$pwdDB = $accountInfo[0]['password'];
		$codeDB = $id.$pwdDB;
		$codeDB = hash('sha256', $codeDB);
		if ($code === $codeDB)
		{
			$GLOBALS['resetPwd'] = TRUE;
		}
	}
}
	//tester et enregistrer le nouveau mdp.
if (isset($_GET['log']) && $_GET['log'] ==="newpwd" && isset($_POST['newpwd']))
{
	$pwd = $auth->updatePwd();
	$id = Authentification::filterInputs($_POST['newpwd'], "alnum");
	if (isset($pwd) && !empty($pwd) && $pwd != FALSE)
	{
			//Enregistrement.
		$crud = new Crud($dbCoordinates);
		$columns = array ("password" => array($pwd));
		$whereDyn = array ("id" => array($id));
		$operator = "";
		$crud->update($columns, $whereDyn, $operator);
		$_SESSION['smsAuth'] = "<p class='sms'>Votre password a bien été modifié</p>";
	}
	$GLOBALS['resetPwd'] = TRUE;
}

//ACTIVATION D'UN COMPTE!
if (isset($_GET['code']) && $_GET['action'] === "log" && $_GET['log'] === "in")
{
	$code = $auth->filterInputs($_GET['code'], "alnum");
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
		$_SESSION['smsAuth'] = "<p class='sms'>Votre compte vient d'être activé!</p>";
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
			$sendMail = new SendMail();
			$sendMail-> activeAccount($newMemberDatas[2], $newMemberDatas[3]);
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
$crud = new Crud($dbCoordinates);
$columns = array ("activateCode", "activate", "mail");
$whereDyn = array ("login" => array($sessionLoginInfo['login']), "password" => array($sessionLoginInfo['password']));
$operator = "AND";
$groupBy = TRUE;
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
	$sendMail = new SendMail();
	$sendMail->activeAccount($_POST['mail'], $_POST['activecode']);
}


//VIEWS!
function home()
{
	//MENU ENREGISTREMENT CANVAS
	if ($GLOBALS['sessionAuthOk'] === TRUE)
	{
		ob_start();
		?>
		<form action="index.php?action=galrecord" id="galRecordForm" method="post">
				<input type="hidden" name="id_dessin" id="id_dessin" value=''>
		        <input type="hidden" name="titre_dessin" id="titre_dessin" value=''>
		        <input type="hidden" name="record_code" id="record_code" value=''>
                <input type="hidden" name="record_png" id="record_png" value=''>
		  		<input class="button_unselect" type="submit" id="recordSubmit" value="record">
		</form>
		<?php
		$GLOBALS['recordButton'] = ob_get_clean();
	}
	else
	{
		$GLOBALS['recordButton'] = "";
	}
    require('./view/indexView.php');
}
function auth()
{
	require('./view/logView.php');
}
function gallery()
{
    //filtrer le nombre de dessins par page.
    $_POST['parPage'] = isset($_POST['parPage']) ? $_POST['parPage'] : 10; 
    Gallery::filterDessinParPage($_POST['parPage']);
    //filtrer pages par catégories.
    $_POST['trierPar'] = isset($_POST['trierPar']) ? $_POST['trierPar'] : "date"; 
    $tri = Gallery::filterDessinParCat($_POST['trierPar']);
    //repertorier les sous dossiers de la gallerie(id_membre)
    $sousDossiers = array();
    if($dossier = opendir('./assets/gallery'))
    {
       while(($sousDossier = readdir($dossier)))
       {
            if ($sousDossier != "." && $sousDossier != "..")
            {
                array_push($sousDossiers, $sousDossier);
            }
       }
    }
    $fichiersDessin = Gallery::displayDessins($tri);
    /*
    //repertorier les fichiers des sous-dossiers de la gallerie(id_dessin)
    $fichiersDessin = array();
    $idDessins = array();
    foreach ($sousDossiers as $sousDossier)
    {
        if($dossier = opendir('./assets/gallery/'.$sousDossier))
        {
           while(($fichierDessin = readdir($dossier)))
           {
                if ($fichierDessin != "." && $fichierDessin != "..")
                {
                    $fichierDessin = str_replace(array(".canvas", ".png"), "", $fichierDessin);
                    array_push($fichiersDessin, $sousDossier."/".$fichierDessin);
                    array_push($idDessins, $fichierDessin);
                }
           }
        }
    }
    //retirer les doublons.
    $fichiersDessin = array_unique($fichiersDessin);
    //reindexer.
    $fichiersDessin = array_values($fichiersDessin);
    $dessinsInfo = Gallery::displayInfo($idDessins);
    */
    require('./view/galleryView.php');
    }
function galRecord()
{
	//formulaire pour l'enregistrement des nouveaux dessins.
	$code = RecordDraw::filter($_POST['record_code']);
    $png = $_POST['record_png'];

	if (isset($_POST['newTitreDessin']))
	{
		RecordDraw::newRecord($code, $png, $_POST['newTitreDessin']);	
	}
    require('./view/galRecordView.php');
}