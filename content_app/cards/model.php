<?php
namespace content_app\cards;
use \lib\debug;
use \lib\utility;

class model extends \mvc\model
{
	public function post_add()
	{
		$qry = $this->sql()->table('cards')
					->set('card_front', utility::post('card_front'))
					->set('card_back', utility::post('card_back'));

		$this->insert($qry);
	}

	public function put_edit()
	{
		$qry = $this->sql()->table('cards')
					->set('card_front', utility::post('card_front'))
					->set('card_back', utility::post('card_back'))
					->where('id', $this->childparam('edit'));

		$this->update($qry);
	}

	public function delete_delete33()
	{
		var_dump(2);exit();
		$qry = $this->sql()->table('cards')
					->where('id', $this->childparam('delete'));

		$this->delete($qry);
	}
}
?>
