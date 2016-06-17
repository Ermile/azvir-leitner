<?php
namespace lib\db;

/** work with cards **/
class cards
{
	/**
	 *
	 * v1.2
	 */


	public static function get($_user_id, $_cat_id, $_type = 'all', $_order = true, $_limit = 1 )
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
				$qry = self::queryCreator($_user_id, $_cat_id, $_type);
				break;

			case 'all':
				$qry = self::queryCreator($_user_id, $_cat_id, 'expired');
				$qry .= "\nUNION\n\t\t";
				$qry .= self::queryCreator($_user_id, $_cat_id, 'unlearned');
				break;

			default:
				return null;
				break;
		}
		var_dump($qry);

		// add order if needed
		if($_order === true)
		{
			$qry .= " \nORDER BY id ASC";
		}

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



	private static function queryCreator($_user_id, $_cat_id, $_type)
	{
		$join     = "";
		$criteria = "";
		// $groupby  = "";
		$groupby  = "GROUP BY cardlists.id";
		switch ($_type)
		{
			case 'unlearned':
				$join     = "LEFT JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				// $criteria = "AND cardusages.cardlist_id IS NULL";
				$criteria =
					"AND
					(
						cardusages.cardusage_status = 'skip' OR
						cardusages.cardusage_status IS NULL
					)
					AND
					(
						cardusages.cardlist_id IS NULL
						OR cardusages.user_id = $_user_id
					)";
				break;

			case 'expired':
				$criteria = " AND cardusages.cardusage_expire < DATE(now())";
				$criteria .= " AND cardusages.cardusage_status = 'enable'";
			case 'learned':
				$join     = "INNER JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				$criteria .= " AND cardusages.user_id = $_user_id";
				break;


			default:
				return null;
				break;
		}

		$qry =
			"SELECT
				cardlists.id as id,
				(SELECT paper_text from papers WHERE id = cards.card_front) as front,
				(SELECT paper_text from papers WHERE id = cards.card_back) as back
			FROM
				cardlists

			INNER JOIN cards ON cardlists.card_id = cards.id
			$join

			WHERE cardlists.cardcat_id = $_cat_id
			$criteria
			$groupby
		";
		// return created query
		return $qry;
	}
}
?>