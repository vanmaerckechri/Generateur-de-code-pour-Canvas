<?php
//DOCUMENTATION

//1. Instancier l'objet avec les coordonnées de la DB.

	//exemple:
	/*$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members", "tableSec" => ""];
	$test = new Crud($dbCoordinates);*/

//2. Effectuer une requete custom avec les données 'columns|bindparam' et 'where'.

	//exemple: $columns = array ("COLUMN NAME" => array("VALUE"), "OTHER COLUMN NAME" => array("OTHER VALUE"), "OTHER COLUMN NAME" => array("OTHER VALUE", "AGAIN OTHER VALUE"), ...)

	//exemple de requete SELECT.
		/*$columns = array ("login", "password", "mail");
		$whereDyn = array ("id" => array(220, 222));
		$operator = "AND";
		$groupBy = TRUE;
		$order = "date";
		$members = $test->select($columns, $whereDyn, $operator, $groupBy, $order);*/

	//exemple de requete INSERT.
		/*$columns = array ("login" => array("name1", "name2"), "password" => array("pwd1", "pwd2", "pw3"), "mail" => array("mail1", "mail2"));
		$whereDyn = array();
		$operator = "OR";
		$members = $test->insert($columns, $whereDyn, $operator);*/

	//exemple de requete UPDATE.
		/*$columns = array ("login" => array("ttt"), "password" => array("ppp"), "mail" => array("mmm"));
		$whereDyn = array ("id" => array(2, 5));
		$operator = "OR";
		$members = $test->update($columns, $whereDyn, $operator);*/

	//exemple de requete DELETE.
		/*$columns = array ();
		$whereDyn = array ("id" => array(1, 3));
		$operator = "OR";
		$members = $test->delete($columns, $whereDyn, $operator);*/
	//var_dump($members);

class Crud
{
	private $dbHost;
	private $_dbPort;
	private $_dbName;
	private $_dbCharset;
	private $_dbLogin;
	private $_dbPwd;

	private $_table;
	private $_tableSec;

	public function __construct(array $reqDyn)
	{
		$this->hydrate($reqDyn);
		$this->connectDb();
	}

	private function hydrate($reqDyn)
  	{
  		foreach ($reqDyn as $key => $value)
  		{
			if (isset($value))
			{
				$method = 'set'.ucfirst($key);
			}
			if (method_exists($this, $method))
    		{
      			$this->$method($value);
    		}
  		}
  	}
	private function setDbHost($DbHost)
	{
		if (is_string($DbHost))
		{
			$this->_dbHost = htmlspecialchars($DbHost);
		}
	}
	private function setDbPort($dbPort)
	{
		if (is_int($dbPort))
		{
			$this->_dbPort = htmlspecialchars($dbPort);
		}
	}
	private function setDbName($dbName)
	{
		if (is_string($dbName))
		{
			$this->_dbName = htmlspecialchars($dbName);
		}
	}
	private function setDbCharset($dbCharset)
	{
		if (is_string($dbCharset))
		{
			$this->_dbCharset = htmlspecialchars($dbCharset);
		}
	}
	private function setDbLogin($dbLogin)
	{
		if (is_string($dbLogin))
		{
			$this->_dbLogin = htmlspecialchars($dbLogin);
		}
	}
	private function setDbPwd($dbPwd)
	{
		if (is_string($dbPwd))
		{
			$this->_dbPwd = htmlspecialchars($dbPwd);
		}
	}
	private function setTable($table)
	{
		if (is_string($table))
		{
			$this->_table = htmlspecialchars($table);
		}
	}
	private function setTableSec($tableSec)
	{
		if (is_string($tableSec))
		{
			$this->_tableSec = htmlspecialchars($tableSec);
		}
	}
	private function setColumns($selectColumns)
	{
		if (is_array($selectColumns))
		{
			$this->_columns = htmlspecialchars($selectColumns);
		}
	}

	private function connectDb()
	{
	    try
	    {
	    	$this->_db = new PDO('mysql:host='.$this->_dbHost.'; port='.$this->_dbPort.';dbname='.$this->_dbName.'; charset='.$this->_dbCharset.'', ''.$this->_dbLogin.'', ''.$this->_dbPwd.'');
	    	$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	    catch (Exception $e)
	    {
	      	die('Erreur : ' . $e->getMessage());
	    }
	}

	private function execute($columns, $where, $typeReq, $req)
	{
		//BINDVALUE 'SELECT' et 'DELETE'.
		if ($typeReq == "SELECT" || $typeReq == "DELETE")
		{
			$index = 1;
			foreach ($where as $key1 => $title)
			{
				foreach ($title as $key2 => $value)
				{
					$focus = ":".$key1;
					$focus .= $index;
					$req->bindValue($focus, $value);
					$index++;
				}
			}
		$req->execute();
		}
		//BINDVALUE 'UPDATE' et 'INSERT INTO'.
		if ($typeReq == "UPDATE" || $typeReq == "INSERT INTO")
		{
			//on boucle n fois (n = le nombre d'éléments du plus grand array)
			$counts = array_map('count', $columns);
			$biggestArray = array_flip($counts)[max($counts)];
			$loopLength = count($columns[$biggestArray]);
			for ($i = 0; $i < $loopLength; $i++)
			{
				$index = 1;
				//Les binds conditions.
				foreach ($where as $key1 => $title)
				{
					foreach ($title as $key2 => $value)
					{
						$focus = ":".$key1.$index;
						$req->bindValue($focus, $value);
						$index++;
					}
				}
				//Les binds colonnes.
				foreach ($columns as $key1 => $value)
				{
					$key = ":".$key1;
					if (isset($value[$i]))
					{
						$req->bindValue($key1, $value[$i]);
					}
					else
					{
						$req->bindValue($key1, '');
					}
				}
				$req->execute();
			}
		}
	}

	private function prepare($columns, $where, $typeReq, $operator, $groupBy = "", $order = "")
	{
		if (isset($columns) && is_array($columns) && isset($where) && is_array($where) && isset($typeReq))
		{
			//Type de requête.
			$prepareDyn = $typeReq." ";
			//La table pour les requêtes 'insert into' et 'update'.
			$prepareDyn .= $typeReq == "INSERT INTO" || $typeReq == "UPDATE" ?  $this->_table." " : "";
			//Colonnes
			$columnsLength = count($columns);
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";
			$prepareDyn .= $typeReq == "UPDATE" ? "SET " : "";
			foreach ($columns as $key => $value)
			{	
				$forSelectGroupBy = $value;
				$prepareDyn .= $typeReq == "UPDATE" || $typeReq == "INSERT INTO" ? $key : $value;
				if ($key < $columnsLength)
				{
					$prepareDyn .= $typeReq == "INSERT INTO" || $typeReq == "SELECT" ? ", " : " = :";
					//Les binds liés aux colonnes pour la modification de leurs valeurs lors de l'execute. Uniquement pour les requêtes 'update'!.
					$prepareDyn .= $typeReq == "UPDATE" ? $key.", " : "";
				}
			}
			//Effacer la virgule après la dernière colonne ciblée.
			$prepareDyn = $typeReq != "DELETE" ? substr($prepareDyn, 0, strlen($prepareDyn) - 2) : $prepareDyn;
			$prepareDyn .= " ";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : " ";
			//La table pour les requêtes 'select' et 'delete';
			$prepareDyn .= $typeReq == "SELECT" || $typeReq == "DELETE" ? "FROM " : "";
			$prepareDyn .= $typeReq == "SELECT" || $typeReq == "DELETE" ?  $this->_table : "";
			//Préparation aux conditions et aux binds en fonction de la requête demandée.
			$prepareDyn .= $typeReq != "INSERT INTO" && $where != array() ? " WHERE ": "";
			$prepareDyn .= $typeReq == "INSERT INTO" ? "VALUES ( " : "";
			//Conditions pour les requêtes 'select', 'update' et 'delete'.
			if ($typeReq == "SELECT" || $typeReq == "UPDATE" || $typeReq == "DELETE")
			{
				$arrayMultiLength = array_sum(array_map("count", $where));
				$index = 1;
				foreach ($where as $key1 => $title)
				{
					foreach ($title as $key2 => $value)
					{
						$prepareDyn .= $key1." = :".$key1.$index;
						if ($index < $arrayMultiLength)
						{
							$prepareDyn .= " ".$operator." ";
						}
						$index++;
					}
				}
			}
			//Les binds liés aux colonnes qui serviront à nourrir la nouvelle rangée lors de l'execute. Uniquement pour la requête 'insert into'!.
			if ($typeReq == "INSERT INTO")
			{
				foreach ($columns as $key => $value)
				{
					$prepareDyn .= ":".$key.", ";
				}
				$prepareDyn = substr($prepareDyn, 0, strlen($prepareDyn) - 2);
				$prepareDyn .= " ";			
			}
			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : "";
			$prepareDyn .= $typeReq == "SELECT" && $groupBy == TRUE ? " GROUP BY ".$forSelectGroupBy : "";
			$prepareDyn .= $typeReq == "SELECT" && $order != "" ? " ORDER BY ".$order : "";
			echo $prepareDyn;
			$req = $this->_db->prepare($prepareDyn);
			$this->execute($columns, $where, $typeReq, $req);
			return $req;
		}
	}

	public function select($columns, $whereDyn, $operator, $groupBy = "", $order = "")
	{
		if (isset($columns) && isset($whereDyn) && isset($operator) && isset($groupBy))
		{
			$req = $this->prepare($columns, $whereDyn, 'SELECT', $operator, $groupBy, $order);
		   	$members = $req->fetchAll();
		   	$req->closeCursor();
		    $req = NULL;
			return $members;
		}
	}

	public function insert($columns, $whereDyn, $operator)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'INSERT INTO', $operator);
		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	public function update($columns, $whereDyn, $operator)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'UPDATE', $operator);
		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	public function delete($columns, $whereDyn, $operator)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'DELETE', $operator);
		   	$req->closeCursor();
		    $req = NULL;
		}
	}
	public function db() { return $this->_db; }
	/*exemple de fonction pour sortir le contenu d'une variable privée.
	public function table() { return $this->_table; }*/
}

class Authentification
{
	private $sessionLogin;
	private $sessionPwd;

    public function __construct()
    {
    	$this->startSession();
    	$this->hydrate();
    }
	private function hydrate()
  	{
  		if (isset($_SESSION['login']))
  		{
      		$this->setSessionLogin($_SESSION['login']);
  		}
  		else
		{
			$this->_sessionLogin = '';
		}
  		if (isset($_SESSION['password']))
  		{
      		$this->setSessionPwd($_SESSION['password']);
  		}
  		else
		{
			$this->_sessionPwd = '';
		}
		$this->setSessionSms();
  	}
	private function setSessionLogin($sessionLogin)
	{
		if (is_string($sessionLogin))
		{
			$this->_sessionLogin = htmlspecialchars($sessionLogin);
		}
	}
	private function setSessionPwd($sessionPwd)
	{
		if (is_string($sessionPwd))
		{
			$this->_sessionPwd = htmlspecialchars($sessionPwd);
		}	
	}
	private function setSessionSms()
	{
		if (!isset($_SESSION['smsAuth']))
		{
			$_SESSION['smsAuth'] = "";
		}
		if (!isset($_SESSION['smsLogin']))
		{
			$_SESSION['smsLogin'] = "";
		}
		if (!isset($_SESSION['smsPwd']))
		{
			$_SESSION['smsPwd'] = "";
		}
		if (!isset($_SESSION['smsPwd2']))
		{
			$_SESSION['smsPwd2'] = "";
		}
		if (!isset($_SESSION['smsMail']))
		{
			$_SESSION['smsMail'] = "";
		}
	}
    public function startSession()
    {
        session_start();
        if(!isset($_SESSION['ip']))
        {
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        if($_SESSION['ip']!=$_SERVER['REMOTE_ADDR'])
        {
            header('Location: index.php?sms=Vous avez été déconnecté pour des raisons de sécurité!');
            $_SESSION = array();
            exit;
        }
    }
    public static function filterInputs($value, $type)
    {
    	$result = FALSE;
    	if (isset($value) && (!empty($value)))
		{
			$filter = htmlspecialchars($value);
			if ($type = "alnum")
			{
				if (ctype_alnum($filter))
				{
					$result = $filter;
				}
			}
			if ($type = "alnumspace")
			{
				if (preg_match('/^[a-z0-9 .\-]+$/i', $filter))
				{
					$result = $filter;
				}
			}
			if ($type = "mail")
			{
				if (filter_var($filter, FILTER_VALIDATE_EMAIL))
				{
					$result = $filter;
				}
			}
		}
		return $result;
    }
    public function register()
    {
    	$newMemberDatas = array();
    	if (isset($_POST['login']) && isset($_POST['pwd']) && isset($_POST['pwd2']) && isset($_POST['mail']))
		{
			$login = $this->filterInputs($_POST['login'], "alnum");
			$pwd = $this->filterInputs($_POST['pwd'], "alnum");
			$pwd2 = $this->filterInputs($_POST['pwd2'], "alnum");
			$mail = $this->filterInputs($_POST['mail'], "mail");
			if ($login != FALSE && $pwd != FALSE && $pwd2 != FALSE && $mail != FALSE)
			{
				if ($pwd === $pwd2)
				{
		    		$pwd = hash('sha256', $pwd);
		    		$activate = hash('sha256', $mail);
					array_push($newMemberDatas, $login, $pwd, $mail, $activate);
				}
				else
				{
					$pwd2 = FALSE;
					$_SESSION['smsPwd2'] = "<p class='smsAlert'>Les passwords sont différents!</p>";
				}
	    	}
	    	$_SESSION['smsLogin'] = $login == FALSE ? "<p class='smsAlert'>Le login ne peut être composé que de lettres et de chiffres</p>" : "";
	    	$_SESSION['smsPwd'] = $pwd == FALSE ? "<p class='smsAlert'>Le password ne peut être composé que de lettres et de chiffres</p>" : "";
	    	$_SESSION['smsMail'] = $mail == FALSE ? "<p class='smsAlert'>Veuillez entrer une adresse mail valide!</p>" : "";
		}
		return $newMemberDatas;
    }
    public function updatePwd()
    {
    	$pwd = "";
    	if (isset($_POST['pwd']) && isset($_POST['pwd2']) && isset($_POST['newpwd']))
		{
			$pwd = $this->filterInputs($_POST['pwd'], "alnum");
			$pwd2 = $this->filterInputs($_POST['pwd2'], "alnum");
			$newpwd = $this->filterInputs($_POST['newpwd'], "alnum");
			if ($pwd != FALSE && $pwd2 != FALSE && $newpwd != FALSE)
			{
				if ($pwd === $pwd2)
				{
		    		$pwd = hash('sha256', $pwd);
		    		return $pwd;
				}
				else
				{
					$pwd2 = FALSE;
					$_SESSION['smsPwd2'] = "<p class='smsAlert'>Les passwords sont différents!</p>";
				}
	    	}
	    	$_SESSION['smsPwd'] = $pwd == FALSE ? "<p class='smsAlert'>Le password ne peut être composé que de lettres et de chiffres</p>" : "";
		}
		return FALSE;
    }
    public function auth()
    {
    	if (isset($_POST['login']) && isset($_POST['pwd']) && isset($_POST['auth']))
		{

			$login = $this->filterInputs($_POST['login'], "alnum");
			$pwd = $this->filterInputs($_POST['pwd'], "alnum");
			if ($login != FALSE && $pwd != FALSE)
			{
				$this->_sessionLogin = $login;
				$_SESSION['login'] = $this->_sessionLogin;

	    		$this->_sessionPwd = hash('sha256', $pwd);
	    		$_SESSION['password'] = $this->_sessionPwd;
	    	}
		}
    }
    public function sessionInfo()
    {
    	$sessionInfo = ['login' => $this->_sessionLogin, 'password' => $this->_sessionPwd];
    	return $sessionInfo;
    }
    public function disconnect()
    {
    	if (!empty($_SESSION))
    	{
	        $_SESSION = array();
	        session_destroy();
	        return FALSE;
	    }
    }
    public function testConnexion($memberExist)
    {
    	if (!empty($memberExist))
    	{
    		if ($memberExist[0]['activate'] == 1)
    		{
    			return TRUE;
    		}
    		else
    		{
    			if (!isset($_POST['register']) && isset($_POST['auth']))
    			{
					$_SESSION['smsAuth'] = "
						<p class='smsAlert'>Votre compte n'est pas activé! Veuillez vérifier votre boîte mail.</p>
						<form action='index.php?action=log&log=in' method='post'>
					       	<input type='hidden' name='mail' id='mail' value='".$memberExist[0]['mail']."'>
					       	<input type='hidden' name='activecode' id='activecode' value='".$memberExist[0]['activateCode']."'>
					       	<input type='hidden' name='sendmailactive' id='sendmailactive' value='1'>
					        <input class='submitHref' type='submit' value=\"envoyer le code d'activation une nouvelle fois\">
						</form>";
				}
    		}
        }
        else
        {
        	$_SESSION['smsAuth'] = isset($_POST['auth']) ? "<p class='smsAlert'>Login ou password incorrect!</p>" : $_SESSION['smsAuth'];
        }
    }
    public function memberAlreadyExist($pseudoOrMail, $InputLogin, $inputMail)
    {
    	foreach ($pseudoOrMail as $column => $values)
    	{
    		foreach ($values as $key => $value)
	    	{
	    		if ($value == $InputLogin)
	    		{
	    			$_SESSION['smsLogin'] = "<p class='smsAlert'>Ce Login existe déjà</p>";
	    		}
	    		if ($value == $inputMail)
	    		{
	    			$_SESSION['smsMail'] = "<p class='smsAlert'>Cette adresse mail existe déjà</p>";
	    		}
	    	}
    	}
    }
}

class SendMail
{
	public function activeAccount($mail, $code)
	{
		$_SESSION['smsAuth'] = "<p class='sms'>Vous venez de recevoir un lien de validation dans votre boîte mail!</p>";
		$_sujet = "Lien d'Activation du Compte!";
		$_message = '<p>Bienvenue! Pour activer votre compte veuillez cliquer sur le lien suivant.
		<a href="https://cvm.one/index.php?action=log&log=in&code='.$code.'">https://cvm.one/index.php?action=log&log=in&code='.$code.'</a></p>';
		$_destinataire = $mail;

		$_headers = "From: \"Générateur de Code pour Canvas\"<robot@cvm.one>\n";
		$_headers .= "Reply-To: admin@cvm.one\n";
		$_headers .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n";
		$_headers .= "Content-Transfer-Encoding: 8bit";
		$_sendMail = mail($_destinataire, $_sujet, $_message, $_headers);
	}
	public function lostPassword($mail, $id, $rstpwd)
	{
		$_SESSION['smsAuth'] = "<p class='sms'>Un mail pour reinitialiser votre password vient de vous être envoyé!</p>";
		$_sujet = "Password Perdu!";
		$_message = '<p>Bienvenue! Cliquer sur le lien suivant pour reinitialiser votre password.
		<a href="https://cvm.one/index.php?action=log&log=resetpwd&resetpwd='.$id.'&rstpwd='.$rstpwd.'">https://cvm.one/index.php?action=log&log=resetpwd&resetpwd='.$id.'&rstpwd='.$rstpwd.'</a></p>';
		$_destinataire = $mail;

		$_headers = "From: \"Générateur de Code pour Canvas\"<robot@cvm.one>\n";
		$_headers .= "Reply-To: admin@cvm.one\n";
		$_headers .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n";
		$_headers .= "Content-Transfer-Encoding: 8bit";
		$_sendMail = mail($_destinataire, $_sujet, $_message, $_headers);
	}
}

class RecordDraw
{
	public static function filter($code)
	{
		if (isset($code) && !empty($code))
		{
			$filter = array("php", "PHP", "'", "?", "$", "#", "<span id=\"lastChild\">", "</span>");
			$codeFilter = str_replace($filter, "", $code);
			$filter = array("<br>");
			$codeFilter = str_replace($filter, "\n", $codeFilter);
			$codeFilter = html_entity_decode($codeFilter);

			return $codeFilter;
		}
	}
	public static function newRecord($code, $png, $titre)
	{
		if (isset($titre) && !empty($titre))
		{
			$titre = htmlspecialchars($titre);
			$titre = Authentification::filterInputs($titre, "alnumspace");
			if ($titre != FALSE)
			{
				if (strlen($titre) > 7 && strlen($titre) < 64)
				{
					//récupère le nom de l'utilisateur.
					$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
					$crud = new Crud($dbCoordinates);
					$columns = array ("login");
					$whereDyn = array ("login" => array($_SESSION['login']), "password" => array($_SESSION['password']));
					$operator = "AND";
					$groupBy = TRUE;
					$login = $crud->select($columns, $whereDyn, $operator, $groupBy);
					$login = $login[0]['login'];
					//Vérifier que le membre n'a pas déjà un fichier portant ce titre.
					$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "dessins"];
					$crud = new Crud($dbCoordinates);
					$columns = array ("id_dessin");
					$whereDyn = array ("nom_membre" => array($login), "titre" => array($titre));
					$operator = "AND";
					$groupBy = TRUE;
					$drawAlreadyExist = $crud->select($columns, $whereDyn, $operator, $groupBy);
					//enregistrement des infos dans la DB à la table 'dessins'.
					if (empty($drawAlreadyExist))
					{
						$date = date("Y-m-d");
						$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "dessins"];
						$crud = new Crud($dbCoordinates);
						$columns = array ("nom_membre" => array($login), "titre" => array($titre), "date" => array($date));
						$whereDyn = array();
						$operator = "";
						$crud->insert($columns, $whereDyn, $operator);
						$db = $crud->db();
						$lastIndex = $db->lastInsertId(); 
						//creation du dossier s'il n'existe pas et du fichier.
						$dossier = './assets/gallery/'.$login;
						if(!is_dir($dossier))
						{
						   mkdir($dossier);
						}
						$fileNameCode = fopen($dossier.'/'.$lastIndex.'.canvas', 'w+');
						//adapter l'id du canvas à l'id du dessin.
						$filter = array("scene");
						$code = str_replace($filter, "scene".$lastIndex, $code);
						//fputs($fileName, $codeFilter);
						fwrite($fileNameCode, $code);
						fclose($fileNameCode);
//
						$image = explode('base64,',$png);
						$fileNamePng = fopen($dossier.'/'.$lastIndex.'.png', 'w+');
						fwrite($fileNamePng,base64_decode($image[1]));
						fclose($fileNamePng);
//
						$_SESSION['smsAuth'] = "<p class='sms'>Votre dessin a bien été enregistré.</p>";
					}
					//demander confirmation d'écrasement.
					else
					{
						$_SESSION['smsAuth'] = "<p class='smsAlert'>Vous avez déjà un dessin portant ce titre!</p>";
					}
				}
				else
				{
					$_SESSION['smsAuth'] = "<p class='smsAlert'>Le titre doit être composé de 8 à 63 caractères!</p>";
				}
			}
			else
			{
				$_SESSION['smsAuth'] = "<p class='smsAlert'>Le Titre ne peut être composé que de lettres et de chiffres!</p>";
			}
		}
		else
		{
			$_SESSION['smsAuth'] = "<p class='smsAlert'>Veuillez entrer un titre!</p>";
		}
	}
}

class Gallery
{
	public static function displayDessins($filterBy)
	{
		$dessinsInfo = array();
		$dbGalleryCoo = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "dessins"];
		$crud = new Crud($dbGalleryCoo);
		$columns = array ("*");
		$whereDyn = array();
		$operator = "";
		$order = $filterBy;
		$groupBy = "";
		$dessinsInfo = $crud->select($columns, $whereDyn, $operator, $groupBy, $order);
		var_dump($dessinsInfo);
	}
	public static function displayInfo($idDessins)
	{
		if (!empty($idDessins))
		{
			//Chargement des informations liées aux dessin de la galerie.
			$dessinsInfo = array();
			$dbGalleryCoo = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "dessins"];
		    $crud = new Crud($dbGalleryCoo);
		    $columns = array ("nom_membre", "titre", "date");
		    $id_dessin = array();
		    foreach ($idDessins as $key => $id)
		    {
				array_push($id_dessin, $id);
		    }
			$whereDyn = array("id_dessin" => $id_dessin);
		    $operator = "OR";
		    $groupBy = "";
		    $dessinsInfo = $crud->select($columns, $whereDyn, $operator, $groupBy);
		    return $dessinsInfo;
		}
	}
	public static function filterDessinParPage($input)
	{
		$input = htmlspecialchars($input);
		$input = (int)$input;
		if ($input >= 10 && $input <= 50)
		{
			$_SESSION['dessinsParPageMax'] = $input;
		}
		else
		{
			$_SESSION['dessinsParPageMax'] = 10;
		}
		$GLOBALS['parPageSelected'] = array();
		for ($i = 0; $i < 5; $i++)
		{
			if ( ($i+1)*10 == $_SESSION['dessinsParPageMax'])
			{
				$GLOBALS['parPageSelected'][$i] = "selected";
			}
			else
			{
				$GLOBALS['parPageSelected'][$i] = "";
			}
		}
	}
	public static function filterDessinParCat($input)
	{
		$input = htmlspecialchars($input);
		if ($input == "date" || $input == "auteur" || $input == "nom")
		{
			$_SESSION['trierParSelect'] = $input;
		}
		else
		{
			$_SESSION['trierParSelect'] = "date";
		}
		$GLOBALS['trierParSelect'] = array();
		$GLOBALS['trierParSelect'][0] = $input == "date" ? "selected" : "";
		$GLOBALS['trierParSelect'][1] = $input == "auteur" ? "selected" : "";
		$GLOBALS['trierParSelect'][2] = $input == "nom" ? "selected" : "";
		echo $input;
	}
}