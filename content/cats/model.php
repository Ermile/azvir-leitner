<?php
namespace content\cats;
use \lib\debug;

class model extends \mvc\model
{
	public function get_test($object)
	{
		return 1;
	}

	public function post_test()
	{
		var_dump(22222);
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
