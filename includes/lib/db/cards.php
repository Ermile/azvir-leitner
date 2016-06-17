<?php
namespace lib\db;

/** work with cards **/
class cards
{
	/**
	 *
	 * v1.0
	 */


	public static function get($_cat_id, $_type = 'all', $_order = true, $_limit = 1 )
	{
		if(!$_cat_id)
		{
			return false;
		}
		$qry = '';
		switch ($_type)
		{
			case 'unlearned':
			case 'expired':
				$qry = self::queryCreator($_cat_id, $_type);
				break;

			case 'all':
				$qry = self::queryCreator($_cat_id, 'expired');
				$qry .= "\nUNION\n\t\t";
				$qry .= self::queryCreator($_cat_id, 'unlearned');
				break;

			default:
				return null;
				break;
		}

		// add order if needed
		if($_order === true)
		{
			$qry .= " \nORDER BY ID ASC";
		}
		var_dump($qry);

		if($_limit)
		{
			$qry .= " \nLIMIT $_limit";
			$result = \lib\db::get($qry, null, true);
		}
		else
		{
			$result = \lib\db::get($qry);
		}

		return $result;
	}



	private static function queryCreator($_cat_id, $_type)
	{
		$join    = "";
		$critera = "";
		switch ($_type)
		{
			case 'unlearned':
				$join    = "LEFT JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				$critera = "AND cardusages.cardlist_id IS NULL";
				break;

			case 'expired':
				$join    = "INNER JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				$critera = "AND cardusages.cardusage_expire < DATE(now())";
				break;

			default:
				return null;
				break;
		}

		$qry =
			"SELECT
				cardlists.id as ID,
				(SELECT paper_text from papers WHERE id = cards.card_front) as front,
				(SELECT paper_text from papers WHERE id = cards.card_back) as back
			FROM
				cardlists

			INNER JOIN cards ON cardlists.card_id = cards.id
			$join

			WHERE cardlists.cardcat_id = $_cat_id
			$critera
		";
		// return created query
		return $qry;
	}
}
?>