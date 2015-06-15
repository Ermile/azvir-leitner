<?php
namespace content_app\cats;
use \lib\saloos;

class controller extends \mvc\controller
{
	public function config()
	{
		// Code
		$mychild  = $this->child();
		// var_dump($this->model_name);
		// var_dump(1);exit();

		if($mychild === 'add' || $mychild === 'edit')
			$this->display_name	= 'content_app/cats/display_child.html';

		switch ($mychild)
		{
			case 'add':
				$this->post('add')->ALL('cats/add');
				$this->get()->ALL();
				break;

			case 'edit':
				// $this->post('edit')->ALL('cats/edit');
				$this->put('edit')->ALL('/^[^\/]*\/[^\/]*$/');
				$this->get()->ALL();
				break;

			case 'delete':
				// $this->delete('delete')->ALL('cats/delete');
				$this->post('delete')->ALL('cats/delete');
				$this->get('delete')->ALL();
				break;
		}
	}
}
?>
