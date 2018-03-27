<?php
require('./controller/controller.php');
//pages
if (isset($_GET['action']))
{
	if ($_GET['action'] == 'home')
	{
    	home();
    }
    else if ($_GET['action'] == 'log' && (!isset($GLOBALS['sessionAuthOk']) || $GLOBALS['sessionAuthOk'] === FALSE))
    {
    	auth();
    }
    else
	{
		home();
	}
}
else
{
	home();
}