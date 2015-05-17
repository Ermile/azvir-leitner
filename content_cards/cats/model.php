<?php
namespace content_cards\cats;
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

		$this->update($qry);
	}

	public function delete_delete()
	{
		$qry = $this->sql()->table('cardcats')
			->where('id',          $this->childparam('delete'));

		$this->delete($qry);
	}
}
?>
