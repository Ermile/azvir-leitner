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
	private static $maxCard        = 2;
	private static $keyborad_final =
	[
		'keyboard' =>
		[
			// ["ادامه خرید", "مشاهده سبد خرید"],
			["ادامه خرید"],
			["اتمام سفارش"],
			["انصراف"],
		],
	];

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
	public static function step3($_txtCat = null)
	{
		// get cat id
		$cat_id = step::get('learn_category');
		// first time it is null, then get from database and set it for next use
		if(!$cat_id)
		{
			$cat_id = \lib\db\cardcats::catDetail($_txtCat);
			step::set('learn_categoryText', $_txtCat);
			step::set('learn_category', $cat_id);
		}
		// if cat is not exist
		if(!$cat_id)
		{
			return false;
		}
		// add try number
		step::plus(1, 'tryCounter');
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

		$card_id    = $lastCard['id'];
		$card_deck  = $lastCard['deck'];
		$card_front = $lastCard['front'];
		$card_back  = $lastCard['back'];
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

		$card_deck_txt = "";
		if($card_deck)
		{
			$card_deck_txt = '-'. $card_deck;
		}

		// go to next step
		step::plus();
		$limiter = $limiter +1;
		$txt_text = "`[". step::get('learn_categoryText'). '-'. $card_id. '-'. $card_tag. $card_deck_txt ."]` ";
		$txt_text .= "کارت ". $limiter . " از ". self::$maxCard;
		// if has skip show in list
		$txt_text .= "\n\n".$card_front;
		$list     = ["مشاهده پاسخ ⚖","فعلا رد کن"];

		$result   =
		[
			'text'         => $txt_text,
			// 'reply_markup' => 	$keyboard,
			'reply_markup' => keyboard::draw($list, 'fixed', 'keyboard'),

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
					'reply_markup'  => keyboard::draw($list, 'fixed'),

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
		$try_total = step::get('tryCounter')-1;
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
		$txt_text = "وضعیت بازبینی *". $try_total. "* کارت این دوره\n";
		$txt_text .= self::calcPercentage($result_try);
		$txt_text .= "\n\n";
		$txt_text .= "*پاس شده: ". $result_try['success']. "*\n";
		$txt_text .= "ناموفق: ". $result_try['fail']. "\n";
		$txt_text .= "نادیده گرفته‌شده: ". $result_try['skip']."\n";
		$txt_text .= "_name_ محصولی از ارمایل\n";
		$list     = ["شروع دوباره ♻", "بررسی وضعیت", "بازگشت"];

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
			'reply_markup' => 	keyboard::draw($list, 'fixed'),

		];
		// return menu
		return $result;
	}


	public static function step7($_decision)
	{
		bot::$skipText = false;
		switch ($_decision)
		{
			case 'شروع دوباره':
			case 'شروع دوباره ♻':
			case 'learn':
			case '/learn':
				step::set('limiter', 0);
				step::goingto(3);
				return self::step3();
				break;

			case 'بررسی وضعیت':
			case 'review':
			case '/review':
				// $txt_text = "نمایش وضعیت طبقه‌ها\n\n";
				// $txt_text .= "...\n\n";
				$txt_text = self::showSummary();
				$result   =
				[
					'text'         => $txt_text,
				];
				return $result;
				break;

			case 'بازگشت':
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
					$shape      = "⚫️";
					$txt_result .= $shape. " ". T_('Success')." $value (". $_list[$key_new]. "%)\n";
					break;

				case 'false':
				case 'fail':
					$shape      = "🔴";
					$txt_result .= $shape. " ". T_('Fail')." $value (". $_list[$key_new]. "%)\n";
					break;

				case 'skip':
					$shape      = "⚪️";
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

	public static function showSummary()
	{
		$category      = step::get('learn_category');
		$count_total   = \lib\db\cardcats::cardCount($category);
		$count_remined = 0;
		$list          = \lib\db\cardusages::cardAnswerDeck(bot::$user_id, $category);
		if(!$list)
		{
			$list =
			[
				0 => 0
			];
		}
		$count_learned = array_sum($list);
		$count_remined = $count_total - $count_learned;
		// create array to get inline chart of total
		$list_total    =
		[
			'success' => $count_learned,
			'skip' => $count_remined,
		];
		$list_total_chart = self::calcPercentage($list_total);

		if($count_learned < $count_total)
		{
			$list[0] = $list[0] + ($count_total - $count_learned);
		}

		$chart  = self::calcChart($list, T_('Deck'));
		$chart2  = self::calcChartVertical($list);

		$txt = "خلاصه آمار سری کارت‌های `[". step::get('learn_categoryText'). "]`\n";
		// total analytics
		$txt .= $list_total_chart."\n\n";
		$txt .= "کل کارت $count_total عدد\n";
		$txt .= "یادگرفته‌شده‌ها $count_learned \n";
		$txt .= "منتظر یادگیری شما $count_remined \n";
		// analytic of each deck
		$txt .= "\n\nجزئیات آمار کارت‌ها ". "\n";
		// $txt .= $chart. "\n";
		$txt .= $chart2;
		$txt .= "\nمحصولی از امایل". "\n";


		return $txt;
	}

	public static function calcChart($_inputList, $_showtext = true, $_onlyArray = false)
	{
		$result  = "";
		$shape   = "⬜️";
		$total   = array_sum($_inputList);
		$divider = 10;

		foreach ($_inputList as $key => $value)
		{
			$key_new              = $key.'P';
			$_inputList[$key_new] = $value * 100 / $total;
			$_inputList[$key_new] = round($_inputList[$key_new], 1);
			$_inputList[$key.'C'] = round($_inputList[$key_new] / $divider, 0);

			// add prefix
			if($_showtext)
			{
				$result .= "`[";
				if(is_string($_showtext))
				{
					$result .= $_showtext;
				}
				$result .= $key. "]` ";
			}

			$result .= str_repeat($shape, $_inputList[$key.'C']);
			$result .= "\n";

			if($_onlyArray)
			{
				$_inputList[$key] = $_inputList[$key_new];
				unset($_inputList[$key_new]);
				unset($_inputList[$key.'C']);
			}
		}

		if($_onlyArray)
		{
			ksort($_inputList);
			return $_inputList;
		}
		return $result;
	}



	public static function calcChartVertical($_datalist)
	{
		$row      = ['0⃣', '1⃣', '2⃣', '3⃣', '4⃣', '5⃣', '6⃣', '7⃣', '8⃣', '9⃣', '🔟'];
		$datalist = self::calcChart($_datalist, null, true);
		$chart    = "";
		$max      = 15;

		for ($i=0; $i < $max; $i++)
		{
			$chart_row = "";
			foreach ($datalist as $key => $value)
			{
				if($i === 0)
				{
					if(isset($row[$key]))
					{
						$chart_row .= $row[$key];
					}
					else
					{
						$chart_row .= $key;
					}
				}
				else
				{
					if(($value / (100 / $max)) > $i)
					{
						if($value % (100 / $max))
						{
							$chart_row .= '🔳';
						}
						else
						{
							$chart_row .= "⬛";
						}
					}
					else
					{
						$chart_row .= "⬜";
					}
				}
			}

			$chart = $chart_row."\n". $chart;
		}
		return $chart;
	}
}
?>