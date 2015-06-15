<?php
namespace content_app\learn;

class view extends \mvc\view
{
	public function config()
	{

		// echo "<pre>";
		$this->data->cardsList = $this->model()->get_list();
		// var_dump($this->data->cardsList);
	}
}
?>
