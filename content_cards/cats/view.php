<?php
namespace content_cards\cats;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->datatable = $this->model()->get_cats();
		// var_dump($this->data->datatable);

		// $myform                 = $this->createform('@'.db_name.'.Cardcats', $this->data->child);
	}
}
?>
