<?php
namespace content_cards\cats\add;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		$this->get()->ALL();
		$this->post('test')->ALL();

	}

	// for routing check
	function _route()
	{

	}
}
?>
