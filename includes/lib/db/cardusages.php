<?php
namespace lib\db;

/** work with card and usages of it **/
class cardusages
{
	/**
	 *
	 * v1.0
	 */
	public static $total           = 0;
	public static $total_checked   = 0;
	public static $total_learned   = 0;
	public static $total_expired   = 0;
	public static $total_unlearned = 0;

	/**
	 * save question answers
	 * @return [type] [description]
	 */
	public static function saveAnswer($_user_id, $_cardlist_id, $_answer, $_spendTime = 'null')
	{
		$answer           = null;
		$new_deck         = 0;
		$new_try          = 1;
		$new_trySuccess   = 0;
		$answer_id        = null;
		$answer_spendtime = 0;
		$ansDate          = date('Y-m-d H:i:s');
		// replace with algorithm of expiration
		$criteria         = "user_id = $_user_id AND cardlist_id = $_cardlist_id ";
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
			$answer_id        = $lastRecord['id'];
			$new_deck         = $lastRecord['deck'];
			$new_try          = 1 + $lastRecord['try'];
			$new_trySuccess   = $lastRecord['trysuccess'];
			$answer_spendtime = $lastRecord['spendtime'] + $_spendTime;
		}
		// set next deck
		switch ($_answer)
		{
			case 'false':
				$new_deck = 0;
				break;

			case 'true':
				$new_deck       += 1;
				$new_trySuccess += 1;
				break;

			case 'skip':
			default:
				$new_deck -= 1;
				// do nothing
				break;
		}
		if(!$new_deck || $new_deck <0)
		{
			$new_deck = 0;
		}
		// calculate expire date
		$expDate = self::calcExpire($new_deck, $_answer);

		// if has record update it
		if($lastRecord)
		{
			// create query string
			$qry = "UPDATE cardusages
			SET
				`cardusage_deck` = $new_deck,
				`cardusage_try` = $new_try,
				`cardusage_trysuccess` = $new_trySuccess,
				`cardusage_spendtime` = $answer_spendtime,
				`cardusage_expire` = '$expDate',
				`cardusage_lasttry` = '$ansDate',
				`cardusage_status` = 'enable'
			WHERE $criteria
			";
			$result = \lib\db::query($qry);
			$answer = true;
		}
		else
		{
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
				`cardusage_status`
			)
			VALUES
			(
				$_user_id,
				$_cardlist_id,
				$new_deck,
				$new_try,
				$new_trySuccess,
				$_spendTime,
				'$expDate',
				'$ansDate',
				'enable'
			)";
			// run query
			$result    = \lib\db::query($qry);
			// return last insert id
			$answer_id = \lib\db::insert_id();

		}

		$qryDetails = "INSERT INTO cardusagedetails
		(
			`cardusage_id`,
			`cardusagedetail_answer`,
			`cardusagedetail_spendtime`,
			`cardusagedetail_deck`,
			`cardusagedetail_datetime`
		)
		VALUES
		(
			$answer_id,
			'$_answer',
			$answer_spendtime,
			$new_deck,
			'$ansDate'
		)";
		// run query
		$result = \lib\db::query($qryDetails);
		// return last insert id
		$answer = \lib\db::insert_id();

		// get current point
		// save user points
		$newpoint = 3;

		$userDetail =
		[
			'user'   => $_user_id,
			'cat'    => 'user_'.$_user_id,
			'key'    => 'points',
			'value'  => 'telegram',
			'meta'   => '++',
		];

		// save in options table
		\lib\utility\option::set($userDetail, true);

		return $answer_id;
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


	public static function cardAnswerDeck($_user_id, $_cat_id, $_addUnlearned = true)
	{
		if(!is_numeric($_cat_id))
		{
			return false;
		}
		$qry =
			"SELECT
				count(*) as total,
				cardusages.cardusage_deck as deck,
				IF(cardusages.cardusage_expire > '". date('Y-m-d H:i:s'). "', 'expired', 'learned') as status
			FROM cardusages
			INNER JOIN cardlists ON cardusages.cardlist_id = cardlists.id
			WHERE
				user_id = $_user_id AND
				cardlists.term_id = $_cat_id
			GROUP BY deck, status
			ORDER BY deck, status desc
		";
		$qry_result = \lib\db::get($qry);
		$result     = [];

		foreach ($qry_result as $key => $value)
		{
			$deck          = isset($value['deck']) ? $value['deck']: null;
			$status        = isset($value['status']) ? $value['status']: null;
			$total_checked = isset($value['total']) ? $value['total']: 0;

			if(!isset($result[$deck]['total']))
			{
				$result[$deck]['total'] = 0;
			}
			$result[$deck]['total'] = $result[$deck]['total'] + $total_checked;

			// calc total of each type
			self::$total_checked    = self::$total_checked + $total_checked;
			
			if($status === 'learned')
			{
				self::$total_learned = self::$total_learned + $total_checked;
			}
			elseif($status === 'expired')
			{
				self::$total_expired = self::$total_expired + $total_checked;
			}

			$result[$deck][$status] = (int)$total_checked;
		}
		
		// get total cards in this category
		self::$total            = \lib\db\cardcats::cardCount($_cat_id);
		self::$total_unlearned  = self::$total - self::$total_checked;
		
		ksort($result);

		if($_addUnlearned)
		{
			$unlearned =
			[
				'new' =>
				[
					'total'     => self::$total_unlearned,
					'unlearned' => self::$total_unlearned,
				]
			];
			$result = $unlearned + $result;
		}

		return $result;
	}


	/**
	 * calculate expire date with 3 type of scheduling
	 * @param  [type] $_deck   [description]
	 * @param  string $_method [description]
	 * @return [type]          [description]
	 */
	public static function calcExpire($_deck ,$_type, $_method = 'quadratic')
	{
		// scheduling time on each deck
		$scheduling =
		[
			'linear' =>
			[
				0  => '+5 minutes',
				1  => '+1 days',
				2  => '+2 days',
				3  => '+3 days',
				4  => '+4 days',
				5  => '+5 days',
				6  => '+6 days',
				7  => '+7 days',
				8  => '+8 days',
				9  => '+9 days',
				10 => '+10 days',
			],
			'quadratic' =>
			[
				0  => '+5 minutes',
				1  => '+1 days',
				2  => '+4 days',
				3  => '+9 days',
				4  => '+16 days',
				5  => '+25 days',
				6  => '+36 days',
				7  => '+49 days',
				8  => '+64 days',
				9  => '+81 days',
				10 => '+100 days',
			],
			'exponential' =>
			[
				0  => '+5 minutes',
				1  => '+1 days',
				2  => '+2 days',
				3  => '+4 days',
				4  => '+8 days',
				5  => '+16 days',
				6  => '+32 days',
				7  => '+64 days',
				8  => '+128 days',
				9  => '+256 days',
				10 => '+512 days',
			],
		];

		// set exptime for each deck
		if(isset($scheduling[$_method][$_deck]))
		{
			if($_type === 'skip')
			{
				$expDate = '+30 minutes';
			}
			else
			{
				$expDate = $scheduling[$_method][$_deck];
			}
		}
		elseif($_deck > 9)
		{
			$expDate = $scheduling[$_method][10];
		}
		else
		{
			$expDate = $scheduling[$_method][0];
		}

		$expDate = date('Y-m-d H:i:s', strtotime($expDate));
		// return final date
		return $expDate;
	}
}
?>