<?php
require('./controller/controller.php');
//pages
if (isset($_GET['action']))
{
	if ($_GET['action'] == 'home')
	{
		/*testSessionLog('index');*/
    	home();
    }
}
else
{
	/*testSessionLog('index');*/
	home();
}