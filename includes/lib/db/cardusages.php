<?php
namespace lib\db;

/** work with card and usages of it **/
class cardusages
{
	/**
	 *
	 * v1.0
	 */


	/**
	 * save question answers
	 * @return [type] [description]
	 */
	public static function saveAnswer($_user_id, $_cardlist_id, $_answer, $_spendTime = 'null')
	{
		$answer         = null;
		$new_deck       = 0;
		$new_try        = 0;
		$new_trysuccess = 0;
		$ansDate        = date('Y-m-d H:i:s');
		// replace with algorithm of expiration
		$expDate        = date('Y-m-d H:i:s', strtotime("+2 days"));

		$criteria = "user_id = $_user_id AND cardlist_id = $_cardlist_id ";
		// get last answer of this card for this user if exist
		// select old values
		$qry =
			"SELECT
				id as id,
				cardusage_deck as deck,
				cardusage_try as try,
				cardusage_trysuccess as trysuccess,
				cardusage_spendtime as spendtime,
				cardusage_meta as meta
			FROM cardusages
			WHERE $criteria
			ORDER BY id DESC
			LIMIT 1
			";
		$lastRecord     = \lib\db::get($qry, null, true);
		if($lastRecord)
		{
			$new_deck       = $lastRecord['deck'];
			$new_try        = 1 + $lastRecord['try'];
			$new_trysuccess = 1 + $lastRecord['trysuccess'];
		}
		// set next deck
		switch ($_answer)
		{
			case 'false':
				$new_deck = 0;
				break;

			case 'true':
				$new_deck += 1;
				break;

			case 'skip':
			default:
				$new_deck -= 1;
				$expDate = date('Y-m-d H:i:s', strtotime("+2 minutes"));
				// do nothing
				break;
		}
		if(!$new_deck || $new_deck <0)
		{
			$new_deck = 0;
		}


		// if has record update it
		if($lastRecord)
		{
			var_dump('update');
			// create query string
			$qry = "UPDATE cardusages
			SET
				`cardusage_deck` = $new_deck,
				`cardusage_try` = $new_try,
				`cardusage_trysuccess` = $new_trysuccess,
				`cardusage_spendtime` = $_spendTime,
				`cardusage_expire` = '$expDate',
				`cardusage_lasttry` = '$ansDate'
			WHERE $criteria
			)";
			var_dump($qry);
			$result = \lib\db::query($qry);
			var_dump($result);
			$answer = true;
		}
		else
		{
			var_dump('insert');
			// create query string to insert answer
			$qry = "INSERT INTO cardusages
			(
				`user_id`,
				`cardlist_id`,
				`cardusage_deck`,
				`cardusage_try`,
				`cardusage_trysuccess`,
				`cardusage_spendtime`,
				`cardusage_expire`,
				`cardusage_lasttry`,
				`cardusage_meta`,
				`cardusage_status`
			)
			VALUES
			(
				$_user_id,
				$_cardlist_id,
				$new_deck,
				$new_try,
				$new_trysuccess,
				$_spendTime,
				'$expDate',
				'$ansDate',
				'NULL',
				'enable'
			)";
			// run query
			$result = \lib\db::query($qry);
			// return last insert id
			$answer = \lib\db::insert_id();
		}


		return $answer;
	}

	public static function cardAnswerSummary($_user_id, $_cat_id)
	{
		if(!is_numeric($_cat_id))
		{
			return false;
		}
		$qry =
			"SELECT
				count(*) as total,
				cardusages.cardusage_answer as type
			FROM cardusages
			INNER JOIN cardlists ON cardusages.cardlist_id = cardlists.id
			WHERE
				user_id = $_user_id AND
				cardlists.term_id = $_cat_id
			GROUP BY type
		";
		$result = \lib\db::get($qry, ['type', 'total']);
		return $result;
	}


	public static function cardAnswerDeck($_user_id, $_cat_id)
	{
		if(!is_numeric($_cat_id))
		{
			return false;
		}
		$qry =
			"SELECT
				count(*) as total,
				cardusages.cardusage_deck as type
			FROM cardusages
			INNER JOIN cardlists ON cardusages.cardlist_id = cardlists.id
			WHERE
				user_id = $_user_id AND
				cardlists.term_id = $_cat_id
			GROUP BY type
		";
		var_dump($qry);
		$result = \lib\db::get($qry, ['type', 'total']);
		return $result;
	}
}
?>