<?php
namespace content_app\learn;
use lib\saloos;

class controller extends \mvc\controller
{
	function config()
	{
		$this->put('edit')->ALL();
		
	}
}
?>
