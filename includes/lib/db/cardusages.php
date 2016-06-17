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
		var_dump(11);
		$criteria = "user_id = $_user_id AND cardlist_id = $_cardlist_id ";
		// get last answer of this card for this user if exist
		// update old record to expire and get last answer
		$qry =
			"UPDATE cardusages SET cardusage_status = 'expire' WHERE $criteria AND cardusage_status = 'enable';
			SELECT
				id as id,
				cardusage_deck as deck,
				cardusage_try as try,
				cardusage_trysuccess as trysuccess
			FROM cardusages
			WHERE $criteria
			ORDER BY id DESC
			LIMIT 1
			";
		$lastRecord     = \lib\db::get($qry, null, true);
		$new_deck       = $lastRecord['try'];
		$new_try        = 1 + $lastRecord['try'];
		$new_trysuccess = 1 + $lastRecord['trysuccess'];
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
				// do nothing
				break;
		}

		var_dump($lastRecord);

		$ansDate = date('Y-m-d H:i:s');
		$expDate = date('Y-m-d H:i:s', strtotime("+2 days"));
		// create query string
		$qry = "INSERT INTO posts
		(
			`user_id`,
			`cardlist_id`,
			`cardusage_answer`,
			`cardusage_deck`,
			`cardusage_try`,
			`cardusage_trysuccess`,
			`cardusage_spendtime`,
			`cardusage_expire`,
			`cardusage_lasttry`,
			`cardusage_status`
		)
		VALUES
		(
			$_user_id,
			$_cardlist_id,
			'$_answer',
			$new_deck,
			$new_try,
			$new_trysuccess,
			$_spendTime,
			'$expDate',
			'$ansDate',
			'enable'
		)";
		// run query
		$result        = \lib\db::query($qry);
		// return last insert id
		$answerId    = \lib\db::insert_id();

		return $answerId;
	}
}
?>