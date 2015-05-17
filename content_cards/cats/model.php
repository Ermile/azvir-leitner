<?php
namespace content_cards\cats;
use \lib\debug;

class model extends \mvc\model
{
	public function get_cats()
	{
		$datatable = $this->sql()->table('cardcats')->select()->allassoc();
		return $datatable;
	}

	public function post_test($object)
	{
		return 2;
	}

	public function put_test($object)
	{
		return 3;
	}

	public function delete_test($object)
	{
		return 4;
	}

}
?>
