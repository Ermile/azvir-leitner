<?php
namespace content_app\cats;
use \lib\debug;
use \lib\utility;
class model extends \mvc\model
{
	public function post_add()
	{
		$qry = $this->sql()->table('cardcats')
			->set('user_id',       $this->login('id'))
			->set('cardcat_title', utility::post('title'))
			->set('cardcat_desc',  utility::post('desc'));

		$this->insert($qry);
	}

	public function put_edit()
	{
		$qry = $this->sql()->table('cardcats')
			->set('user_id',       $this->login('id'))
			->set('cardcat_title', utility::post('title'))
			->set('cardcat_desc',  utility::post('desc'))
			->where('id',          $this->childparam('edit'));

		$qry = $qry->update();


		$this->commit(function()
		{
			debug::true(T_("Update Successfully"));
			$this->redirector()->set_url('cats');
		});
	}

	// works
	public function get_delete()
	{
		$qry = $this->sql()->table('cardcats')
			->where('id',          $this->childparam('delete'));

		$this->delete($qry);
	}
	public function post_delete()
	{
		var_dump(1);exit();
		$qry = $this->sql()->table('cardcats')
			->where('id',          $this->childparam('delete'));

		$this->delete($qry);
	}



}
?>
