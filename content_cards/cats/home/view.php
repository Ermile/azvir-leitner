<?php
namespace content_cards\cats\home;

class view extends \mvc\view
{
	public function config()
	{
		$this->include->datatable = true;

		// in root page like site.com/admin/banks show datatable
		// get data from database through model
		$this->data->datatable = $this->model()->datatable('cardcats');
		$this->global->js      = array($this->url->myStatic.'js/datatable/jquery.dataTables.min.js');
		// check if datatable exist then get this data
		if($this->data->datatable)
		{
			// get all fields of table and filter fields name for show in datatable, access from columns variable
			$this->include->datatable = true;
			$this->data->columns      = \lib\sql\getTable::get('cardcats');
		}
	}
}
?>
