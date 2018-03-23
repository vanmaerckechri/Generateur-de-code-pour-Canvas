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
			$prepareDyn .= $typeReq == "INSERT INTO" || $typeReq == "UPDATE" ?  $this->_table." " : "";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";
			$prepareDyn .= $typeReq == "UPDATE" ? "SET " : "";

			$fromLength = count($from);
			foreach ($from as $key => $value)
			{
				$prepareDyn .= $typeReq == "UPDATE" ? $key : $value.", ";
				if ($key < $fromLength)
				{
					$prepareDyn .= $typeReq != "UPDATE" ? ", " : " = :";
					$prepareDyn .= $typeReq == "UPDATE" ? $key.", " : "";
				}
			}

			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : " ";
			if ($typeReq == "UPDATE")
			{
				$prepareDyn = substr($prepareDyn, 0, strlen($prepareDyn) - 3);
				$prepareDyn .= " ";
			}

			$prepareDyn .= $typeReq == "SELECT" ? "FROM " : "";
			$prepareDyn .= $typeReq == "SELECT" ?  $this->_table : "";
			$prepareDyn .= $typeReq != "INSERT INTO" ? " WHERE ": "";
			$prepareDyn .= $typeReq == "INSERT INTO" ? "VALUES " : "";

			$arrayMultiLength = array_sum(array_map("count", $where));
			$index = 1;
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";

			foreach ($where as $key1 => $title)
			{
				foreach ($title as $key2 => $value)
				{
					$prepareDyn .= $typeReq != "INSERT INTO" ? $key1." = :".$key1.$index : "";
					$prepareDyn .= $typeReq == "INSERT INTO" ? ":".$key1.$index : "";
					if ($index < $arrayMultiLength)
					{
						$prepareDyn .= $typeReq != "INSERT INTO" ? " OR " : "";
						$prepareDyn .= $typeReq == "INSERT INTO" ? ", " : "";
					}
					$index++;
				}
			}
			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : "";
			$req = $this->_db->prepare($prepareDyn);

			//bindParam.
			if ($typeReq == "UPDATE")
			{
				foreach ($from as $key => $value)
				{
					$req->bindValue($key, $value[0]);
				}
			}
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

	public function updateCustom($fromDyn, $whereDyn)
	{
		if (isset($fromDyn) && isset($whereDyn))
		{
			$req = $this->prepare($fromDyn, $whereDyn, 'UPDATE');
			$req->execute();

		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	/*exemple de fonction pour sortir le contenu d'une variable privée.
	public function db() { return $this->_db; }
	public function table() { return $this->_table; }*/
}

//DOCUMENTATION

//1. Instancier l'objet avec les coordonnées de la DB.
$dbCoordinates = ["db" => "gen_code_canvas", "table" => "members"];
$test = new Crud($dbCoordinates);

//3. Effectuer une requete custom avec les données 'from' et 'where'.
//FROM ou équivalent de la requete => '$fromDyn': valeur = nom colonne.
//WHERE ou équivalent de la de la requete => '$whereDyn': nom array enfant = nom colonne. valeur(s) de l'array enfant = contenu colonne.
	//exemple de requete SELECT.
		/*$fromDyn = array ("login", "password", "mail");
		$whereDyn = array ("id" => array(1, 3));
		$members = $test->selectCustom($fromDyn, $whereDyn);*/
	//exemple de requete INSERT.
		/*$fromDyn = array ("login", "password", "mail");
		$whereDyn = array ("login" => array("testlogin"), "password" => array("testpsw"), "mail" => array("testmail"));
		$members = $test->insertCustom($fromDyn, $whereDyn);*/
	//exemple de requete UPDATE.
		//!Pour les update, les valeurs à mettre à jour se trouvent en indice 0 dans le '$fromDyn' et non dans le '$whereDyn'.
		$fromDyn = array ("login" => array("log"), "password" => array("pas"), "mail" => array("em"));
		$whereDyn = array ("id" => array(1, 3));
		$members = $test->updateCustom($fromDyn, $whereDyn);
	var_dump($members);