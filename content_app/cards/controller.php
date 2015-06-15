<?php
namespace content_app\cards;
use \lib\saloos;

class controller extends \mvc\controller
{
	function config()
	{
		// Code
	}

	// // for routing check
	function _route()
	{
		$mychild = $this->child();

		if ($mychild === 'add' || $mychild === 'edit')
			$this->display_name = 'content_app/cards/display_child.html';


		switch ($mychild)
		{
			case 'add':
				$this->post('add')->ALL();
				$this->get()->ALL();
				break;

			case 'edit':
				// $this->post('edit')->ALL('cats/edit');
				$this->put('edit')->ALL('/^[^\/]*\/[^\/]*$/');
				$this->get()->ALL();
				break;

			case 'delete':
				// $this->delete('delete')->ALL('cats/delete');
				$this->post('delete')->ALL();
				$this->get('delete')->ALL();
				break;
		}
	}
}
?>
