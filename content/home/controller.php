<?php
namespace content\home;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		var_dump(22);
		$this->get()->ALL();
		$this->post()->ALL();

	}

	// for routing check
	function _route()
	{

	}
}
?>
