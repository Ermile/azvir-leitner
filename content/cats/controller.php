<?php
namespace content\cats;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		// var_dump(22);
		$this->get()->ALL();
		$this->post('test2')->ALL();
		// $this->route_check_true = true;
	}

	// for routing check
	function _route()
	{
		// var_dump(20);

	}
}
?>
