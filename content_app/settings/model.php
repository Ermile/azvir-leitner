<?php
namespace content_app\settings;
use \lib\debug;
use \lib\utility;

class model extends \mvc\model
{
	function put_edit()
	{
		$user_id = $this->login('id');
		$schedule = utility::post('schedule');
		$cardno = utility::post('cardno');
		// $schedule = utility::post('schedule');

		$qry = $this->sql()->table('options')->set('option_value', $schedule)
			->where('user_id', $user_id)
			->and('option_cat', 'options')
			->and('option_key', 'schedule');
		$qry->update();

		$qry = $this->sql()->table('options')->set('option_value', $cardno)
			->where('user_id', $user_id)
			->and('option_cat', 'options')
			->and('option_key', 'cardno');
		$qry->update();


		$this->commit(function()
		{
			debug::true(T_("Update Successfully"));
		});

		$this->rollback(function()
		{
			debug::error(T_("Update Failed"));
		});
		
		// var_dump(4);exit();
	}
}
?>
