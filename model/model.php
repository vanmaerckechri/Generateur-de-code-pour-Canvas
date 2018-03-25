<?php
//DOCUMENTATION

//1. Instancier l'objet avec les coordonnées de la DB.

	//exemple:
	/*$dbCoordinates = ["dbHost" => "localhost", "dbPort" => "", "dbName" => "gen_code_canvas", "dbCharset" => "utf8", "dbLogin" => "root", "dbPwd" => "", "table" => "members"];
	$test = new Crud($dbCoordinates);*/

//2. Effectuer une requete custom avec les données 'columns|bindparam' et 'where'.

	//exemple: $columns = array ("COLUMN NAME" => array("VALUE"), "OTHER COLUMN NAME" => array("OTHER VALUE"), "OTHER COLUMN NAME" => array("OTHER VALUE", "AGAIN OTHER VALUE"), ...)

	//exemple de requete SELECT.
		/*$columns = array ("login", "password", "mail");
		$whereDyn = array ("id" => array(220, 222));
		$operator = "AND";
		$members = $test->select($columns, $whereDyn, $operator);*/

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
			$this->_dbHost = $DbHost;
		}
	}
	private function setDbPort($dbPort)
	{
		if (is_string($dbPort))
		{
			$this->_dbPort = $dbPort;
		}
	}
	private function setDbName($dbName)
	{
		if (is_string($dbName))
		{
			$this->_dbName = $dbName;
		}
	}
	private function setDbCharset($dbCharset)
	{
		if (is_string($dbCharset))
		{
			$this->_dbCharset = $dbCharset;
		}
	}
	private function setDbLogin($dbLogin)
	{
		if (is_string($dbLogin))
		{
			$this->_dbLogin = $dbLogin;
		}
	}
	private function setDbPwd($dbPwd)
	{
		if (is_string($dbPwd))
		{
			$this->_dbPwd = $dbPwd;
		}
	}
	private function setTable($table)
	{
		if (is_string($table))
		{
			$this->_table = $table;
		}
	}
	private function setColumns($selectColumns)
	{
		if (is_array($selectColumns))
		{
			$this->_columns = $selectColumns;
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

	private function prepare($columns, $where, $typeReq, $operator)
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
			$prepareDyn .= $typeReq != "INSERT INTO" ? " WHERE ": "";
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
			$req = $this->_db->prepare($prepareDyn);
			$this->execute($columns, $where, $typeReq, $req);
			return $req;
		}
	}

	public function select($columns, $whereDyn, $operator)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'SELECT', $operator);
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
	/*exemple de fonction pour sortir le contenu d'une variable privée.
	public function db() { return $this->_db; }
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
  		if (isset($_SESSION['password']))
  		{
      		$this->setSessionPwd($_SESSION['password']);
  		}
  	}
	private function setSessionLogin($sessionLogin)
	{
		if (is_string($sessionLogin))
		{
			$this->_sessionLogin = $sessionLogin;
		}
	}
	private function setSessionPwd($sessionPwd)
	{
		if (is_string($sessionPwd))
		{
			$this->_sessionPwd = $sessionPwd;
		}
	}
    private function startSession()
    {
        session_start();

        //temporaire pour tester le resultat positif de la requete testConnection!
        $_SESSION['login'] = "name1";
		$_SESSION['password'] = "pwd1";
		//-------------

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
    public function sessionInfo()
    {
    	$sessionInfo = ['login' => $this->_sessionLogin, 'password' => $this->_sessionPwd];
    	return $sessionInfo;
    }

    public function testConnection($memberExist)
    {
    	if (!empty($memberExist))
    	{
        	return TRUE;
        }
        else
        {
        	$_SESSION = array();
        	session_destroy();
        	return FALSE;
        }
    }
}