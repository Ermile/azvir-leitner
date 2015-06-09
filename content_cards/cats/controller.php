<?php
namespace content_cards\cats;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		// Code
	}

	// for routing check
	function _route()
	{
		$mychild  = $this->child();

		if($mychild === 'add' || $mychild === 'edit')
			$this->display_name	= 'content_cards/cats/display_child.html';

		$this->get()->ALL();
		
		$this->post('add')->ALL('cats/add');
		// $this->post('edit')->ALL('cats/edit');
		$this->put('edit')->ALL('/^[^\/]*\/[^\/]*$/');

		// $this->delete('delete')->ALL('cats/delete');
		$this->delete('delete')->ALL('/^[^\/]*\/[^\/]*$/');
	}
}
?>
