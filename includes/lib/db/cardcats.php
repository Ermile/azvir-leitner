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
		$qry = "SELECT term_meta as type FROM terms WHERE term_type = 'cat_card' GROUP BY type";

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
		$qry = "SELECT term_title as title FROM terms WHERE term_type = 'cat_card' AND term_parent IS NULL";
		if($_type)
		{
			$qry .= " AND term_meta = '$_type'";
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


	public static function catDetail($_catName, $_return = 'id')
	{
		$qry = "SELECT * FROM terms WHERE term_type = 'cat_card' AND term_title = '$_catName' LIMIT 1;";
		// run query
		if($_return && $_return !== 'count')
		{
			$result = \lib\db::get($qry, $_return, true);
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


	public static function cardCount($_cat_id)
	{
		if(!is_numeric($_cat_id))
		{
			return false;
		}
		$qry = "SELECT count(*) as total from cardlists WHERE term_id = $_cat_id;";
		$result = \lib\db::get($qry, 'total', true);
		return $result;
	}
}
?>