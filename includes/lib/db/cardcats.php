<?php
namespace lib\db;

/** work with card categories **/
class cardcats
{
	/**
	 *
	 * v1.0
	 */


	/**
	 * check signup and if can add new user
	 * @return [type] [description]
	 */
	public static function catTypes($_return = 'type')
	{
		$qry = "SELECT cardcat_type as type FROM cardcats GROUP BY type";

		// run query
		if($_return && $_return !== 'count')
		{
			$result = \lib\db::get($qry, $_return);
		}
		else
		{
			$result = \lib\db::get($qry);
		}
		// if user want count of result return count of it
		if($_return === 'count')
		{
			return count($result);
		}
		// return last insert id
		return $result;
	}


	/**
	 * check signup and if can add new user
	 * @return [type] [description]
	 */
	public static function catList($_type = null, $_return = 'title')
	{
		$qry = "SELECT cardcat_title as title FROM cardcats";
		if($_type)
		{
			$qry .= " WHERE cardcat_type = '$_type'";
		}

		// run query
		if($_return && $_return !== 'count')
		{
			$result = \lib\db::get($qry, $_return);
		}
		else
		{
			$result = \lib\db::get($qry);
		}
		// if user want count of result return count of it
		if($_return === 'count')
		{
			return count($result);
		}
		// return last insert id
		return $result;
	}
}
?>