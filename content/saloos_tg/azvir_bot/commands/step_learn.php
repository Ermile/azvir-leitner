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
	private static $maxCard        = 5;
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
		$card_front = $lastCard['front'];
		$card_back  = $lastCard['back'];
		// set card details
		step::set('learn_card_id', $card_id);
		step::set('learn_card_front', $card_front);
		step::set('learn_card_back', $card_back);

		// go to next step
		step::plus();
		$limiter = $limiter +1;
		$txt_text = "`[". step::get('learn_categoryText'). "]` ";
		$txt_text .= "کارت ". $limiter . " از ". self::$maxCard;
		// if has skip show in list
		$txt_text .= "\n".$card_front;
		$list     = ["مشاهده پاسخ ⚖","فعلا رد کن"];

		$result   =
		[
			'text'         => $txt_text,
			// 'reply_markup' => 	$keyboard,
			'reply_markup' => keyboard::draw($list, 'fixed'),

		];

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
				$r = \lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'skip');
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
				\lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'true');
				break;

			case 'خیر':
			case 'نمی‌دونم':
			case 'نمی‌دونم ❌':
			case '👎':
			case 'no':
			case '/no':
				step::plus(1, 'tryFail');
				// save answer false
				\lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'false');
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

		// create output text
		$txt_text = "وضعیت بازبینی *". $try_total. "* کارت این دوره\n\n";
		$txt_text .= self::calcPercentage($result_try);
		$txt_text .= "\n";
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
		$txt = "خلاصه آمار سری کارت‌های `[". step::get('learn_categoryText'). "]`\n";


		$txt .= "کل کارت: ". \lib\db\cardcats::cardCount(step::get('learn_category')). "\n";
		$list = \lib\db\cardusages::cardAnswerSummary(bot::$user_id, step::get('learn_category'));
		$txt .= "دفعات تلاش ". array_sum($list). "\n";
		$txt .= "آمار تلاش ". "\n";
		$txt .= self::calcPercentage($list, 'all');
		$txt .= "\nمحصولی از امایل". "\n";


		return $txt;
	}
}
?>