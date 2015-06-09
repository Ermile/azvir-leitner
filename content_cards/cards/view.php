<?php
namespace content_cards\cards;

class view extends \mvc\view
{
	function config()
	{
		$this->include->datatable = true;

		$this->data->datatable = $this->model()->datatable('cards');

		$this->global->js = array($this->url->myStatic.'js/datatable/jquery.dataTables.min.js');

		if ($this->data->datatable) {
			$this->include->datatable = true;
			$this->data->columns = \lib\sql\getTable::get('cards');
		}

		if ($this->child() === 'edit')
			$this->data->datarow = $this->model()->datarow('cards', $this->childparam('edit'));
	}
}
?>
