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

	public function prepare($columns, $where, $typeReq)
	{
		if (isset($columns) && is_array($columns) && isset($where) && is_array($where) && isset($typeReq))
		{
			$prepareDyn = $typeReq." ";
			$prepareDyn .= $typeReq == "INSERT INTO" || $typeReq == "UPDATE" ?  $this->_table." " : "";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";
			$prepareDyn .= $typeReq == "UPDATE" ? "SET " : "";

			$columnsLength = count($columns);
			foreach ($columns as $key => $value)
			{
				$prepareDyn .= $typeReq == "UPDATE" || $typeReq == "INSERT INTO" ? $key : $value;
				if ($key < $columnsLength)
				{
					$prepareDyn .= $typeReq == "INSERT INTO" || $typeReq == "SELECT" ? ", " : " = :";
					$prepareDyn .= $typeReq == "UPDATE" ? $key.", " : "";
				}
			}

			$prepareDyn = $typeReq != "DELETE" ? substr($prepareDyn, 0, strlen($prepareDyn) - 2) : $prepareDyn;
			$prepareDyn .= " ";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  ") " : " ";
			$prepareDyn .= $typeReq == "SELECT" || $typeReq == "DELETE" ? "FROM " : "";
			$prepareDyn .= $typeReq == "SELECT" || $typeReq == "DELETE" ?  $this->_table : "";

			$prepareDyn .= $typeReq != "INSERT INTO" ? " WHERE ": "";
			$prepareDyn .= $typeReq == "INSERT INTO" ? "VALUES " : "";
			$prepareDyn .= $typeReq == "INSERT INTO" ?  "( " : "";

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
							$prepareDyn .= " OR ";
						}
						$index++;
					}
				}
			}
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
			echo $prepareDyn;
			//BINDPARAM.
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
						echo '$req->bindValue('.$focus.', '.$value.')';
						$index++;
					}
				}
			}
			if ($typeReq == "UPDATE" || $typeReq == "INSERT INTO")
			{
				foreach ($columns as $key => $value)
				{
					$key = ":".$key;
					$req->bindValue($key, $value[0]);
					echo '<br>$req->bindValue('.$key.', '.$value[0].')';
				}
				$index = 1;
				foreach ($where as $key1 => $title)
				{
					foreach ($title as $key2 => $value)
					{
						$focus = ":".$key1.$index;
						$req->bindValue($focus, $value);
						echo '<br>$req->bindValue('.$focus.', '.$value.')';
						$index++;
					}
				}
			}
			return $req;
		}
	}

	public function select($columns, $whereDyn)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'SELECT');
			$req->execute();

		   	$members = $req->fetchAll();
		   	$req->closeCursor();
		    $req = NULL;
			return $members;
		}
	}

	public function insert($columns, $whereDyn)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'INSERT INTO');
			$req->execute();

		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	public function update($columns, $whereDyn)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'UPDATE');
			$req->execute();

		   	$req->closeCursor();
		    $req = NULL;
		}
	}

	public function delete($columns, $whereDyn)
	{
		if (isset($columns) && isset($whereDyn))
		{
			$req = $this->prepare($columns, $whereDyn, 'DELETE');
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
//FROM ou équivalent de la requete => '$columns': valeur = nom colonne.
//WHERE ou équivalent de la de la requete => '$whereDyn': nom array enfant = nom colonne. valeur(s) de l'array enfant = contenu colonne.
	//exemple de requete SELECT.
		/*$columns = array ("login", "password", "mail");
		$whereDyn = array ("id" => array(2, 5));
		$members = $test->select($columns, $whereDyn);*/
	//exemple de requete INSERT.
		/*$columns = array ("login" => array("testlogin"), "password" => array("testpsw"), "mail" => array("testmail"));
		$whereDyn = array();
		$members = $test->insert($columns, $whereDyn);*/
	//exemple de requete UPDATE.
		/*$columns = array ("login" => array("ttt"), "password" => array("ppp"), "mail" => array("mmm"));
		$whereDyn = array ("id" => array(2, 5));
		$members = $test->update($columns, $whereDyn);*/
	//exemple de requete DELETE.
		/*$columns = array ();
		$whereDyn = array ("id" => array(1, 3));
		$members = $test->delete($columns, $whereDyn);*/
	var_dump($members);