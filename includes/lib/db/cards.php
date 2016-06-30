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
			case 'learned':
			case 'expired':
			case 'all':
				$qry = self::queryCreator($_user_id, $_cat_id, $_type);
				$qry = self::queryCreator($_user_id, $_cat_id, $_type);
				break;

			// case 'all':
			// 	$qry = self::queryCreator($_user_id, $_cat_id, 'expired');
			// 	$qry .= "\nUNION\n\t\t";
			// 	$qry .= self::queryCreator($_user_id, $_cat_id, 'unlearned');
			// 	break;

			default:
				return null;
				break;
		}
		$groupby  = "GROUP BY cardlists.id";

		// add order if needed
		if($_order === true)
		{
			$qry .= " \nORDER BY id ASC";
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



	private static function queryCreator($_user_id, $_cat_id, $_type)
	{
		$join     = "";
		$criteria = "";
		switch ($_type)
		{
			case 'unlearned':
				$join     = "LEFT JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				// $criteria = "cardusages.cardlist_id IS NULL";
				// $criteria =
				// 	"
				// 	(
				// 		cardusages.cardusage_status = 'skip' OR
				// 		cardusages.cardusage_status IS NULL
				// 	)
				// 	AND
				// 	(
				// 		cardusages.cardlist_id IS NULL
				// 		OR cardusages.user_id = $_user_id
				// 	)";
				$criteria =
					"					(
						cardusages.cardlist_id IS NULL
						OR
						(
							cardusages.cardlist_id IS NOT NULL AND
							cardusages.user_id <> $_user_id
						)
					)";

				// $criteria =
				// 	"
				// 	(
				// 		cardusages.cardlist_id IS NULL
				// 	)";

				break;

			// list expired card as first then list unlearned card for this user
			case 'all':
				$join     = "LEFT JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				// $criteria = "
				// (
				// 	(
				// 		cardusages.cardusage_expire < now() AND
				// 		cardusages.cardusage_status <> 'disable' AND
				// 		cardusages.user_id = $_user_id
				// 	)
				// 	OR
				// 	(
				// 		cardusages.cardlist_id IS NULL
				// 	)
				// 	OR
				// 	(
				// 		cardusages.id NOT IN(SELECT id FROM cardusages WHERE user_id = 8 ) OR
				// 		cardusages.id IS NULL
				// 	)
				// )
				// ";

				$criteria = "
				(
					(
						cardusages.cardusage_expire < now() AND
						cardusages.cardusage_status <> 'disable' AND
						cardusages.user_id = $_user_id
					)
					OR
					(
						cardlists.id NOT IN(SELECT cardlist_id FROM cardusages WHERE user_id = $_user_id )
					)
				)
				";
				break;

			// list expired cards
			case 'expired':
				$criteria = "cardusages.cardusage_expire < now() AND ";
			// list learned cards
			case 'learned':
				if(!$criteria)
				{
					$criteria = "cardusages.cardusage_expire > now() AND ";
				}
			// list all cards at least one time is checked
			case 'checked':
				$join     = "INNER JOIN cardusages ON cardusages.cardlist_id = cardlists.id";
				$criteria .= "\n". "cardusages.cardusage_status <> 'disable' AND";
				$criteria .= "\n". "cardusages.user_id = $_user_id";
				break;


			default:
				return null;
				break;
		}

		$qry =
			"SELECT
				cardlists.id as id,
				IF(cardusages.user_id <> $_user_id, null, cardusages.cardusage_deck) as deck,
				(SELECT paper_text from papers WHERE id = cards.card_front) as front,
				(SELECT paper_text from papers WHERE id = cards.card_back) as back,
				ROUND(cardusages.cardusage_trysuccess * 100 / cardusages.cardusage_try)as ratio,
				cardusages.cardusage_expire > now() as status,
				cardusages.cardusage_expire as expire
			FROM
				cardlists

			INNER JOIN cards ON cardlists.card_id = cards.id
			$join

			WHERE
				cardlists.term_id = $_cat_id AND

				$criteria
		";
		// return created query
		return $qry;
	}


	public static function tag($_card)
	{
		$qry =
		"SELECT
			terms.term_meta as category,
			terms.term_title as title
		FROM
			terms
		INNER JOIN termusages ON termusages.term_id = terms.id

		WHERE
			termusages.termusage_foreign = 'cards' AND
			termusages.termusage_id = $_card
		LIMIT 1
		";

		$result = \lib\db::get($qry, 'title', true);
		return $result;
	}

}
?>