<?php

require('./model/model.php');

/*function connectDb()
{
    try
    {
    	$db = new PDO('mysql:host=localhost; dbname=gen_code_canvas; charset=utf8', 'root', '');
    	return $db;
    }
    catch (Exception $e)
    {
      	die('Erreur : ' . $e->getMessage());
    }
}

function startSession()
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

/*function testSessionLog($from)
{
	startSession();

	$db = connectDb();
    $login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
    $password = isset($_SESSION['password']) ? $_SESSION['password'] : '';

    $columns = ['login', 'password'];
    $table = 'members';
	$members = selectColumnsFromDb($columns, $table, $db);
	$membersLength = count($members);
	//var_dump($members);

	for ($i = 0; $i < $membersLength; $i++)
	{
        if ($login == $members[$i][0] && $password == $members[$i][1])
        {
        	return;
        }
    }
   	$_SESSION = array();
	session_destroy();
	if ($from != 'index')
	{
    	header("Location: index.php");
    }
}*/


function home()
{
    require('./view/indexView.php');
}