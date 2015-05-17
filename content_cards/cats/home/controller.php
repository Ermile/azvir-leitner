<?php
namespace content_cards\cats\home;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		
	}

	// for routing check
	function _route()
	{
		$this->get()->ALL();
		$this->post()->ALL();
	}
}
?>
