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
    else if ($_GET['action'] == 'gallery')
    {
    	gallery();
    }
    else if ($_GET['action'] == 'galrecord')
    {
    	galRecord();
    }
    else if ($_GET['action'] == 'delete')
    {
        deleteDraw();
    }
    else if ($_GET['action'] == 'updtitle')
    {
        updateTitleDraw();
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

$_SESSION['smsAuth'] = "";
$_SESSION['smsLogin'] = "";
$_SESSION['smsMail'] = "";
$_SESSION['smsPwd'] = "";
$_SESSION['smsPwd2'] = "";
