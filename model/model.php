<?php

class Crud
{
	private $_db;
	private $_table;
	private $_whereDyn;
	private $_bindparamDyn;

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

	public function setWhere($where)
	{
		if (isset($where) && is_array($where))
		{
			$this->_whereDyn = " WHERE ";
			$this->_bindparamDyn = "";
			foreach ($where as $key1 => $title)
			{
				$index = 0;
				$titleLength = count($title);
				foreach ($title as $key2 => $value);
				{
					$this->_whereDyn .= $key1." = :".$key1.$key2." ";
					$this->_bindparamDyn .= '$req->bindParam("'.$key1.$key2.'", "'.$value.'");';
					if ($index < $titleLength)
					{
						$this->_whereDyn .= "AND ";
					}
				}
				$index++;
			}
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

	public function selectCustom($selectColumns)
	{
		if (isset($selectColumns))
		{
			//Les attributs doivent être des arrays. S'ils ne le sont pas, ils sont convertis.
			$selectColumns = !is_array($selectColumns) ? [$selectColumns] : $selectColumns;

			$columnsLength = count($selectColumns);
			$reqDyn = "SELECT ";
			foreach ($selectColumns as $key => $value)
			{
				if ($key < $columnsLength - 1)
				{
					$reqDyn .= $value.", ";
				}
				else
				{
					$reqDyn .= $value." ";
				}
			}
			$reqDyn .= "FROM ";
			$reqDyn .= $this->_table;
			$reqDyn .= $this->_whereDyn;
			echo $reqDyn.'<br>';
			$req = $this->_db->prepare($reqDyn);
			$this->_bindparamDyn;
			$req->execute();
		   	$members = $req->fetchAll();
		   	$req->closeCursor();
		    $req = NULL;

			return $members;
		}
	}

	public function db() { return $this->_db; }
	public function table()	{ return $this->_table; }
}

$whereDyn = array ("id" => array(0 => 1), "nick" => array(0 => "Chri"));
$reqDyn = ["db" => "gen_code_canvas", "table" => "members", "where" => $whereDyn];
$selectColumns = [0 => "login", 1 => "password", 2 => "mail"];


$test = new Crud($reqDyn);

$members = $test->selectCustom($selectColumns);

var_dump($members);



////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////
///////////////////////////


