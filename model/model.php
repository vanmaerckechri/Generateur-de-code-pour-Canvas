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

	public function prepare($from, $where)
	{
		if (isset($from) && is_array($from) && isset($where) && is_array($where))
		{
			$fromLength = count($from);
			$prepareDyn = "SELECT ";
			foreach ($from as $key => $value)
			{
				if ($key < $fromLength - 1)
				{
					$prepareDyn .= $value.", ";
				}
				else
				{
					$prepareDyn .= $value." ";
				}
			}
			$prepareDyn .= "FROM ";
			$prepareDyn .= $this->_table;
			$prepareDyn .= " WHERE ";
			$arrayMultiLength = array_sum(array_map("count", $where));
			$index = 1;
			foreach ($where as $key1 => $title)
			{
				$titleLength = count($title);
				foreach ($title as $key2 => $value);
				{
					$prepareDyn .= $key1." = :".$key1.$index;
					if ($index < $arrayMultiLength)
					{
						$prepareDyn .= " AND ";
					}
					$index++;
				}
			}

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
			$req = $this->prepare($fromDyn, $whereDyn);
			$req->execute();

		   	$members = $req->fetchAll();
		   	$req->closeCursor();
		    $req = NULL;
			return $members;
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
$whereDyn = array ("id" => array(0 => 1), "login" => array(0 => "Chri"));

//Instancier l'objet avec les coordonnées de la DB.
$test = new Crud($dbCoordinates);
//Effectuer la selection custom avec les données 'from' et 'where'.
$members = $test->selectCustom($fromDyn, $whereDyn);

var_dump($members);