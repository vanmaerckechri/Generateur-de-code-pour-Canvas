<?php

class Crud
{
	private $_db;
	private $_table;

	public function __construct(array $reqDyn)
	{
		$this->hydrate($reqDyn);
		$this->connectDb($this->_db);
	}

	public function hydrate($reqDyn)
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
	public function setDb($db)
	{
		if (is_string($db))
		{
			$this->_db = $db;
		}
	}
	public function setTable($table)
	{
		if (is_string($table))
		{
			$this->_table = $table;
		}
	}
	public function setColumns($selectColumns)
	{
		if (is_array($selectColumns))
		{
			$this->_columns = $selectColumns;
		}
	}

	public function connectDb($dbName)
	{
	    try
	    {
	    	$this->_db = new PDO('mysql:host=localhost; dbname='.$dbName.'; charset=utf8', 'root', '');
	    }
	    catch (Exception $e)
	    {
	      	die('Erreur : ' . $e->getMessage());
	    }
	}

	public function prepare($from, $where, $typeReq)
	{
		if (isset($from) && is_array($from) && isset($where) && is_array($where) && isset($typeReq))
		{
			$prepareDyn = $typeReq." ";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  $this->_table." " : "";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";

			$fromLength = count($from);
			foreach ($from as $key => $value)
			{
				$prepareDyn .= $value;
				if ($key < $fromLength -1)
				{
					$prepareDyn .= ", ";
				}
				else
				{
					$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : "";
					$prepareDyn .= $typeReq == "SELECT" ? " " : "";
				}
			}

			$prepareDyn .= $typeReq == "SELECT" ? "FROM " : "";
			$prepareDyn .= $typeReq == "SELECT" ?  $this->_table : "";
			$prepareDyn .= $typeReq == "SELECT" ? " WHERE ": "";
			$prepareDyn .= $typeReq == "INSERT INTO" ? "VALUES " : "";

			$arrayMultiLength = array_sum(array_map("count", $where));
			$index = 1;
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";
			foreach ($where as $key1 => $title)
			{
				$titleLength = count($title);
				foreach ($title as $key2 => $value);
				{
					$prepareDyn .= $typeReq == "SELECT" ? $key1." = :".$key1.$index : "";
					$prepareDyn .= $typeReq == "INSERT INTO" ? ":".$key1.$index : "";
					if ($index < $arrayMultiLength)
					{
						$prepareDyn .= $typeReq == "SELECT" ? " AND " : "";
						$prepareDyn .= $typeReq == "INSERT INTO" ? ", " : "";
					}
					$index++;
				}
			}
			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : "";
			echo $prepareDyn;
			$req = $this->_db->prepare($prepareDyn);
			$index = 1;
			foreach ($where as $key1 => $title)
			{
				$titleLength = count($title);
				foreach ($title as $key2 => $value);
				{
					$focus = ":".$key1;
					$focus .= $index;
					$req->bindValue($focus, $value);
					$index++;
				}
			}
			return $req;
		}
	}

	public function selectCustom($fromDyn, $whereDyn)
	{
		if (isset($fromDyn) && isset($whereDyn))
		{
			$req = $this->prepare($fromDyn, $whereDyn, 'SELECT');
			$req->execute();

		   	$members = $req->fetchAll();
		   	$req->closeCursor();
		    $req = NULL;
			return $members;
		}
	}

	public function insertCustom($fromDyn, $whereDyn)
	{
		if (isset($fromDyn) && isset($whereDyn))
		{
			$req = $this->prepare($fromDyn, $whereDyn, 'INSERT INTO');
			$req->execute();

		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	/*exemple de fonction pour sortir le contenu d'une variable privée.
	public function db() { return $this->_db; }
	public function table() { return $this->_table; }*/
}


//L'array nécessaire au lancement de l'instanciation.
$dbCoordinates = ["db" => "gen_code_canvas", "table" => "members"];
//Les arrays nécessaires à la requête custom.
	$fromDyn = [0 => "login", 1 => "password", 2 => "mail"];
	//$whereDyn = array ("id" => array(0 => 1), "login" => array(0 => "Chri"));
	$whereDyn = array ("login" => array(0 => "testlogin"), "password" => array(0 => "testpsw"), "mail" => array(0 => "testmail"));

//Instancier l'objet avec les coordonnées de la DB.
$test = new Crud($dbCoordinates);
//Effectuer la selection custom avec les données 'from' et 'where'.
	$members = $test->insertCustom($fromDyn, $whereDyn);

var_dump($members);