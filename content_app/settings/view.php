<?php
namespace content_app\settings;

class view extends \mvc\view
{
	public function config()
	{
// echo "<pre>";
		$this->data->scheduleList = $this->model()->datatable('options', ['option_cat'=> 'schedule']);
		// var_dump($this->data->scheduleList);
		$user_id = $this->login('id');
		// var_dump($user_id);
		$datarow      = $this->model()->datatable('options', ['user_id'=> $user_id]);
		foreach ($datarow as $key => $value)
		{
			$datarow[$value['option_key']] = $value['option_value'];
			unset($datarow[$key]);
		}
		$this->data->datarow = $datarow;
		// var_dump($this->data->datarow);
	}
}
?>
