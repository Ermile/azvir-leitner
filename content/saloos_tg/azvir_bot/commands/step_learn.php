<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\telegram\tg as bot;
use \lib\telegram\step;
use \lib\telegram\keyboard;
use \lib\telegram\commands;

class step_learn
{
	private static $menu           = ["hide_keyboard" => true];
	private static $maxCard        = 10;
	private static $keyborad_final = [ "ادامه ♻", "وضعیت 📊", "بازگشت 🔙"];
	private static $deck_symbols   = ['0⃣', '1⃣', '2⃣', '3⃣', '4⃣', '5⃣', '6⃣', '7⃣', '8⃣', '9⃣', '🔟', 'new' => '🆕'];

	/**
	 * create define menu that allow user to select
	 * @param  boolean $_onlyMenu [description]
	 * @return [type]             [description]
	 */
	public static function start($_skip = null)
	{
		$result = null;
		if($_skip !== true)
		{
			$result = commands\step_register::start(__CLASS__, __FUNCTION__, menu::main(true));
		}
		// if we have result or want to skip, then call step1
		if($result === true || $_skip === true)
		{
			step::start('learn');
			return self::step1();
		}
		else
		{
			// do nothing, wait for registration
			return $result;
		}
	}


	/**
	 * get list of category type and show it to user for select
	 * @return [type] [description]
	 */
	public static function step1()
	{
		// go to next step
		step::plus();
		// set title for
		step::set('textTitle', 'learnCatType');
		// increase custom number
		step::plus(1, 'i');
		// create output message
		$txt_text    = "لطفا یکی از انواع زیر را انتخاب کنید\n\n";
		$txt_text    .= "/cancel انصراف";
		$catTypeList = \lib\db\cardcats::catTypes();
		if(count($catTypeList) === 1 && isset($catTypeList[0]))
		{
			return self::step2($catTypeList[0]);
		}
		$result   =
		[
			'text'         => $txt_text,
			'reply_markup' => keyboard::draw($catTypeList),
		];

		return $result;
	}



	/**
	 * get list of category in this type and show it to user for select
	 * @param  [type] $_answer_txt [description]
	 * @return [type]            [description]
	 */
	public static function step2($_txtCatType)
	{
		// go to next step, step4
		step::plus();
		// set title for
		step::set('textTitle', 'learnCat');
		// increase custom number
		step::plus(1, 'i');
		// create output message
		$txt_text = "لطفا یکی از دسته‌بندی‌های زیر را انتخاب کنید\n\n";
		$catList  = \lib\db\cardcats::catList($_txtCatType);
		// if this cat type is not exist then goto step 1
		if(count($catList) < 1)
		{
			step::goingto(1);
			return self::step1();
		}
		// save category type
		step::set('learn_categoryType', $_txtCatType);
		$result =
		[
			'text'         => $txt_text,
			'reply_markup' => keyboard::draw($catList),
		];

		return $result;
	}


	/**
	 * get list of cards in this category and show it to user for answer
	 * @param  [type] $_answer_txt [description]
	 * @return [type]            [description]
	 */
	public static function step3($_txtCat = null, $_direct = false)
	{
		if($_direct)
		{
			step::start('learn');
			step::goingto(3);
			switch ($_txtCat)
			{
				case '/504':
				case '/450':
					$_txtCat = substr($_txtCat, 1);

				case '504':
				case '450':
					step::set('learn_categoryType', 'english');
					break;

				default:
					break;
			}
		}
		// get cat id
		$cat_id = step::get('learn_category');
		// first time it is null, then get from database and set it for next use
		if(!$cat_id)
		{
			$cat_id = \lib\db\cardcats::catDetail($_txtCat);
			step::set('learn_categoryText', $_txtCat);
			step::set('learn_category', $cat_id);

			$txt_text = self::showSummary(false);
			$msg      =
			[
				'text'         => $txt_text,
				'reply_markup' => 	keyboard::draw(self::$keyborad_final),

			];
			$result = bot::sendResponse($msg);
		}
		// if cat is not exist
		if(!$cat_id)
		{
			return false;
		}
		// get last card details
		$user_id  = bot::$user_id;
		$lastCard = \lib\db\cards::get($user_id, $cat_id, 'all');
		// get limiter value
		$limiter  = step::get('limiter');
		if($limiter >= self::$maxCard)
		{
			step::goingto(6);
			return self::step6();
		}
		// add try number
		step::plus(1, 'tryCounter');

		$card_id     = $lastCard['id'];
		$card_deck   = $lastCard['deck'];
		$card_front  = $lastCard['front'];
		$card_back   = $lastCard['back'];
		$card_status = $lastCard['status'];
		$card_expire = $lastCard['expire'];
		$card_ratio  = $lastCard['ratio'];
		// get tag of this card
		$card_tag   = \lib\db\cards::tag($card_id);

		if(!$card_front)
		{
			$card_front = "روی کارت خالی است!\nلطفا به مدیر اطلاع دهید!";
		}
		if(!$card_back)
		{
			$card_back = "پشت کارت خالی است!\nلطفا به مدیر اطلاع دهید!";
		}
		// set card details
		step::set('learn_card_id', $card_id);
		step::set('learn_card_deck', $card_deck);
		step::set('learn_card_front', $card_front);
		step::set('learn_card_back', $card_back);

		// add status of this card
		if($card_status === '0')
		{
			if(isset(self::$deck_symbols[$card_deck]))
			{
				$card_status = self::$deck_symbols[$card_deck]. "\n";
			}
			$card_status .= 'در '. \lib\utility::humanTiming($card_expire). ' '. T_('Expired'). '❗';
		}
		elseif($card_status === '1')
		{
			$card_status = '🆗';
			if(isset(self::$deck_symbols[$card_deck]))
			{
				$card_status = self::$deck_symbols[$card_deck]. "\n";
			}
			$card_status .= \lib\utility::humanTiming($card_expire);
		}
		else
		{
			$card_status = '🆕';
		}

		// go to next step
		step::plus();
		$limiter = $limiter +1;
		$txt_text = "`[". step::get('learn_categoryText'). '-'. $card_id. '-'. $card_tag ."]` $card_status\n";
		$txt_text .= "کارت ". $limiter . " از ". self::$maxCard;
		// add success ration
		if($card_ratio !== null)
		{
			$txt_text .= "` - ". $card_ratio. "درصد`";
		}
		// if has skip show in list
		$txt_text .= "\n\n*".$card_front. "*";
		$list     = ["پاسخ ⚖","فعلا رد کن"];
		// $list     =
		// [
		// 	['text' => "مشاهده پاسخ ⚖", 'callback_data' => 'showanswer'],
		// 	['text' => "فعلا رد کن", 'callback_data' => 'skip'],
		// ];

		$result   =
		[
			'text'         => $txt_text,
			// 'reply_markup' => 	$keyboard,
			// 'reply_markup' => keyboard::draw($list, 'fixed', 'inline_keyboard'),
			'reply_markup' => keyboard::draw($list),

		];
		step::set('learn_card_sendDate', strtotime(date('Y-m-d H:i:s')));

		// return menu
		return $result;
	}


	/**
	 * get user answer about know card or skip
	 * @param  [type] $_answer_txt [description]
	 * @return [type]            [description]
	 */
	public static function step4($_txtReaction)
	{
		$spendTime = strtotime(date('Y-m-d H:i:s')) - step::get('learn_card_sendDate');
		if($spendTime < 1)
		{
			return false;
		}

		$result = null;
		// if user press next goto step 3 for
		switch ($_txtReaction)
		{
			case 'بعدی':
			case 'فعلا رد کن':
			case 'skip':
			case '/skip':
				bot::$skipText = false;
				step::plus(1, 'trySkip');
				$r = \lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'skip', $spendTime);
				step::goingto(3);
				return self::step3();
				break;

			case 'مشاهده':
			case 'مشاهده پشت کارت':
			case 'مشاهده کارت':
			case 'مشاهده پاسخ':
			case 'مشاهده پاسخ ⚖':
			case 'پاسخ ⚖':
			case 'پاسخ':
			case 'show card':
			case '/show card':
			case 'show answer':
			case '/show answer':
			case 'show':
			case '/show':
				// increase limiter
				step::plus(1, 'limiter');
				// go to next step
				step::plus();
				$card_back = step::get('learn_card_back');
				// $txt_text  = "آیا این کارت را به خاطر داشتید؟\n". $card_back;
				$txt_text  = $card_back;
				$list      = ["بلدم ✅", "نمی‌دونم ❌"];

				// $keyboard  =
				// [
				// 	'keyboard' =>
				// 	[
				// 		["بلدم ✅", "نمی‌دونم ❌"],
				// 	],
				// ];

				$result   =
				[
					'text'         => $txt_text,
					// 'reply_markup' => 	$keyboard,
					'reply_markup'  => keyboard::draw($list),

				];
				break;

			default:
				$txt_text = "لطفا یکی از گزینه‌های موجود را انتخاب کنید!";
				$result   =
				[
					'text'         => $txt_text,
				];
				break;
		}
		return $result;
	}

	public static function step5($_txtAnswer)
	{
		$spendTime = strtotime(date('Y-m-d H:i:s')) - step::get('learn_card_sendDate');
		if($spendTime < 3)
		{
			return false;
		}
		switch ($_txtAnswer)
		{
			case 'بله':
			case 'بلدم':
			case 'بلدم ✅':
			case '👍':
			case 'yes':
			case '/yes':
				step::plus(1, 'trySuccess');
				// save answer true
				\lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'true', $spendTime);
				break;

			case 'خیر':
			case 'نمی‌دونم':
			case 'نمی‌دونم ❌':
			case '👎':
			case 'no':
			case '/no':
				step::plus(1, 'tryFail');
				// save answer false
				\lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'false', $spendTime);
				break;

			default:
				$txt_text = "لطفا یکی از گزینه‌های زیر را انتخاب کنید!";
				$result   =
				[
					'text'         => $txt_text,
				];
				return $result;
				break;
		}

		// go to next card
		step::goingto(3);
		return self::step3();
	}



	/**
	 * show last menu
	 * @param  [type] $_item [description]
	 * @return [type]        [description]
	 */
	public static function step6($_item = null)
	{
		// go to next step
		step::plus();
		$try_total = step::get('tryCounter');
		$result_try =
		[
			// 'total'   => step::get('tryCounter')-1,
			'success' => step::get('trySuccess'),
			'fail'    => step::get('tryFail'),
			'skip'    => step::get('trySkip'),
		];
		foreach ($result_try as $key => $value)
		{
			if(!$value)
			{
				$result_try[$key] = 0;
			}
		}

		// create output text
		$txt_text    = "وضعیت بازبینی *". $try_total. "* کارت این دوره\n";
		$txt_text    .= self::calcPercentage($result_try);
		$txt_text    .= "\n";
		// show rummary if exist
		$txt_summary = '';
		if($result_try['success'])
		{
			$txt_summary .= "*". $result_try['success']. " پاس‌شده*";
		}
		if($result_try['fail'])
		{
			$txt_summary =	$txt_summary? $txt_summary." و ": '';
			$txt_summary .= $result_try['fail']. ' ناموفق';
		}
		if($result_try['skip'])
		{
			$txt_summary =	$txt_summary? $txt_summary." و ": '';
			$txt_summary .= $result_try['skip']. ' نادیده گرفته‌شده';
		}

		$txt_text .= $txt_summary. "\n";
		// $txt_text .= "جزئیات آمار کارت‌های مرورشده ‌";
		$txt_text .= self::calcChartVertical(false)."\n";
		$txt_text .= "_name_ خدمتی از ارمایل @Ermile\n";

		// $keyboard  =
		// [
		// 	'keyboard' =>
		// 	[
		// 		["شروع دوباره ♻"],
		// 		["بررسی وضعیت"],
		// 		["بازگشت"],
		// 	],
		// ];

		// get name of question
		$result   =
		[
			'text'         => $txt_text,
			// 'reply_markup' => 	$keyboard,
			'reply_markup' => 	keyboard::draw(self::$keyborad_final),

		];
		// return menu
		return $result;
	}


	public static function step7($_decision)
	{
		// bot::$skipText = false;
		switch ($_decision)
		{
			case 'شروع دوباره':
			case 'شروع دوباره ♻':
			case 'ادامه ♻':
			case 'learn':
			case '/learn':
				step::set('limiter', 0);
				step::goingto(3);
				return self::step3();
				break;

			case 'بررسی وضعیت':
			case 'وضعیت 📊':
			case 'review':
			case '/review':
				// $txt_text = "نمایش وضعیت طبقه‌ها\n\n";
				// $txt_text .= "...\n\n";
				$txt_text = self::showSummary(true);
				$result   =
				[
					'text'         => $txt_text,
					'reply_markup' => 	keyboard::draw(self::$keyborad_final),

				];
				return $result;
				break;

			case 'بازگشت':
			case 'بازگشت 🔙':
			case '🔙':
			case 'انصراف':
			case 'cancel':
			case '/cancel':
			default:
				return self::stop(false);
				break;
		}

	}



	/**
	 * end define new question
	 * @return [type] [description]
	 */
	public static function stop($_cancel = null, $_text = null)
	{
		// set
		step::set('textTitle', 'stop');

		if($_cancel === true)
		{
			if($_text)
			{
				$final_text = $_text;
			}
			else
			{
				$final_text = "انصراف از ادامه یادگیری\n";
			}
			step::stop();
		}
		elseif($_cancel === false)
		{
			$final_text = "بازگشت به منوی اصلی\n";
			// complete soon
			step::stop();
		}
		else
		{
			$final_text = "انصراف\n";
			step::stop(true);
		}

		// get name of question
		$result   =
		[
			[
				'text'         => $final_text,
				'reply_markup' => menu::main(true),
			],
		];
		// return menu
		return $result;
	}


	private static function calcPercentage($_list, $_result = false)
	{
		$txt_shapes = "";
		$txt_result = "";
		$total = array_sum($_list);
		foreach ($_list as $key => $value)
		{
			$shape           = '';
			$key_new         = $key.'P';
			$_list[$key_new] = $value * 100 / $total;
			$_list[$key_new] = round($_list[$key_new], -1);
			$shapeCounter    = $_list[$key_new] / 10;
			switch ($key)
			{
				case 'true':
				case 'success':
					$shape      = "🔵";
					$txt_result .= $shape. " ". T_('Success')." $value (". $_list[$key_new]. "%)\n";
					break;

				case 'false':
				case 'fail':
					$shape      = "🔴";
					$txt_result .= $shape. " ". T_('Fail')." $value (". $_list[$key_new]. "%)\n";
					break;

				case 'skip':
					$shape      = "⚪";
					$txt_result .= $shape. " ". T_('Skip')." $value (". $_list[$key_new]. "%)\n";
					break;
			}
			$txt_shapes  .= str_repeat($shape, $shapeCounter);
		}

		if($_result === 'array')
		{
			return $_list;
		}
		if($_result === 'all')
		{
			return $txt_shapes. "\n\n". $txt_result;
		}
		return $txt_shapes;
	}


	public static function showSummary($_legend = true)
	{
		$category      = step::get('learn_category');
		// $list          = \lib\db\cardusages::cardAnswerDeck(bot::$user_id, $category);
		// $chart  = self::calcChart($list, 'total');
		$chart2  = self::calcChartVertical(true);
		$currentPoint = \lib\db\users::getDetail(bot::$user_id, 'option_meta', 'user%', 'points');
		// create array to get inline chart of total
		$list_total    =
		[
			'success' => \lib\db\cardusages::$total_checked,
			'skip'    => \lib\db\cardusages::$total_unlearned,
		];

		$txt = "خلاصه آمار سری کارت‌های `[". step::get('learn_categoryText'). "]`\n";

		// $txt .= "شما ". \lib\db\cardusages::$total_checked. " تا از ". \lib\db\cardusages::$total. " کارت را مرورکرده‌اید";
		// $txt .= " و دارای *$currentPoint امتیاز* می‌باشید.\n";
		$txt .= $chart2. "\n";

		if($_legend)
		{
			// total analytics
			$list_total_chart = self::calcPercentage($list_total);
			$txt_msg = "راهنمای خلاصه آمار سری کارت‌های `[". step::get('learn_categoryText'). "]`\n";
			$txt_msg .= $list_total_chart."\n\n";
			
			// show last chart legend
			$txt_msg .= 'ℹ '. str_pad('/all', 10). ' کل کارت‌ها '. \lib\db\cardusages::$total.' عدد'. "\n";
			$txt_msg .= '✅ '. str_pad('/checked', 10). ' '. \lib\db\cardusages::$total_checked.' مرورشده'. "\n";
			$txt_msg .= '⬛ '. str_pad('/learned', 10). ' '. \lib\db\cardusages::$total_learned.' یادگرفته‌شده'. "\n";
			$txt_msg .= '🅾 '. str_pad('/expired', 10). ' '. \lib\db\cardusages::$total_expired.' منقضی‌شده'. "\n";
			$txt_msg .= '🆕 '. str_pad('/unlearned', 10). ' '. \lib\db\cardusages::$total_unlearned.' هنوز بررسی‌نشده'. "\n";
			$txt_msg .= '🔆 در نهایت شما *'. $currentPoint.' امتیاز* کسب کرده‌اید.'. "\n\n";

			$msg      =
			[
				'text'         => $txt_msg,

			];
			$result = bot::sendResponse($msg);
		}

		// $txt .= "یادگرفته‌شده‌ها $count_learned\n";
		// $txt .= "منتظر یادگیری شما $count_remined\n";
		// analytic of each deck
		// $txt .= "\n\nجزئیات آمار کل کارت‌ها ". "\n";
		// $txt .= $chart. "\n";
		$txt .= "ازویر خدمتی از ارمایل @Ermile". "\n";


		return $txt;
	}


	public static function calcChart($_inputList, $_column = 'all', $_onlyArray = false)
	{
		$_showtext = true;
		$result  = "";
		$shape   = "🔷";
		$total   = array_sum($_inputList);
		$divider = 15;

		foreach ($_inputList as $key => $value)
		{
			$key_new              = $key.'P';
			$_inputList[$key_new] = $value * 100 / $total;
			$_inputList[$key_new] = round($_inputList[$key_new], 1);
			$_inputList[$key.'C'] = ceil($_inputList[$key_new] / $divider);

			// add prefix
			if($_showtext)
			{
				$result .= "`[";
				if(is_string($_showtext))
				{
					$result .= $_showtext;
				}
				$result .= $key. "] ". str_pad($value, 3). "` ";
			}

			$result .= str_repeat($shape, $_inputList[$key.'C']);
			$result .= "\n";

			if($_onlyArray)
			{
				$_inputList[$key] = (int)ceil($_inputList[$key_new]);
				unset($_inputList[$key_new]);
				unset($_inputList[$key.'C']);
			}
		}

		if($_onlyArray)
		{
			return $_inputList;
		}
		return $result;
	}



	public static function calcChartVertical($_addUnlearned = false, $_detail = false)
	{
		$chart       = "";
		$max         = 10;
		$devider     = 100 / $max;
		$datalist    = [];
		$_datalist   = \lib\db\cardusages::cardAnswerDeck(bot::$user_id, step::get('learn_category'), $_addUnlearned);
		if($_addUnlearned)
		{
			$total_cards = \lib\db\cardusages::$total;
		}
		else
		{
			$total_cards = \lib\db\cardusages::$total_checked;
		}
		// unset($_datalist[0]);

		// change values to percentage in all condition
		foreach ($_datalist as $deck => $deckValues)
		{
			$total     = isset($deckValues['total'])? $deckValues['total']: 0;
			$learned   = isset($deckValues['learned'])? $deckValues['learned']: 0;
			$expired   = isset($deckValues['expired'])? $deckValues['expired']: 0;
			$unlearned = isset($deckValues['unlearned'])? $deckValues['unlearned']: 0;
			
			$datalist[$deck]['total']     = (int)ceil($total * 100 / $total_cards);
			$datalist[$deck]['learned']   = (int)ceil($learned * 100 / $total);
			$datalist[$deck]['expired']   = (int)ceil($expired * 100 / $total);
			$datalist[$deck]['unlearned'] = (int)ceil($unlearned * 100 / $total);

			if($_detail)
			{
				$chart .= "\n";
				if(isset(self::$deck_symbols[$deck]))
				{
					$chart .= self::$deck_symbols[$deck];
				}
				else
				{
					$chart .= $deck;
				}
				$chart .= str_pad($total.',', 4). " 🔵$learned, 🔴$expired, ⚪$unlearned";
			}
		}

		// get max row to draw only until top row
		$maxRow = max($datalist);
		$maxRow = max(array_column($datalist, 'total'));
		$maxRow = ceil($maxRow / $max) + 1;

		// draw 4 deck in chart
		for ($i=1; $i < 4; $i++)
		{
			if(!isset($_datalist[$i]))
			{
				$datalist[$i] = 0;
			}
		}

		for ($i=0; $i < $max && $i < $maxRow; $i++)
		{
			$chart_row = "";
			foreach ($datalist as $deck => $deckValues)
			{
				if($i === 0)
				{
					if(isset(self::$deck_symbols[$deck]))
					{
						$chart_row .= self::$deck_symbols[$deck];
					}
					else
					{
						$chart_row .= $deck;
					}
				}
				else
				{
					$fill           = $deckValues['total'] / $devider;
					$fill_divided   = $fill - $i +1;
					if(!isset($deckValues['learned']))
					{
						$deckValues['learned'] = 0;
					}
					if(!isset($deckValues['unlearned']))
					{
						$deckValues['unlearned'] = 0;
					}
					$fill_learned   = round($fill * $deckValues['learned'] / 100, 1);
					$fill_expired   = round($fill * $deckValues['expired'] / 100, 1);
					$fill_unlearned = round($fill * $deckValues['unlearned'] / 100, 1);

					if(($fill_learned - $i +1) > 0)
					{
						$fill_type = 'learned';
					}
					elseif(($fill_unlearned - $i +1) > 0)
					{
						$fill_type = 'unlearned';
					}
					else
					{
						$fill_type = 'expired';
					}

					// empty or full
					if($fill_divided > 0)
					{
						// if show normal value learned
						switch ($fill_type)
						{
							case 'learned':
								// if this row is full
								if($fill_divided >= 1.0)
								{
									$chart_row .= "⬛";
								}
								// if more than half
								elseif($fill_divided >= 0.5)
								{
									$chart_row .= '🔲';
								}
								// if less than half
								else
								{
									$chart_row .= '🔳';
								}
								break;
							
							case 'unlearned':
								$chart_row .= '✳';
								break;


							case 'expired':
								if($fill_divided >= 1)
								{
									$chart_row .= "🅾";
								}
								else
								{
									$chart_row .= "🔺";
								}
								break;

							default:
								break;
						}
					}
					// if empty
					else
					{
						$chart_row .= "⬜";
					}
				}
			}

			$chart = $chart_row."\n". $chart;
		}
		// add total of rows into chart first row
		// if($total)
		// {
		// 	$chart = "جزئیات $total کارت مرورشده\n". $chart;
		// }
		return $chart;
	}
}
?>