<?php
namespace content_cards\cats\add;
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
}
?>
