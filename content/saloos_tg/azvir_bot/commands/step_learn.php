<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\utility\telegram\tg as bot;
use \lib\utility\telegram\step;
use \lib\utility\telegram\keyboard;
use \lib\utility\telegram\commands;

class step_learn
{
	private static $menu           = ["hide_keyboard" => true];
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

		// increase limiter
		step::plus(1, 'limiter');


		// get last card details
		$user_id  = bot::$user_id;
		$lastCard = \lib\db\cards::get($user_id, $cat_id, 'all');
		// get limiter value
		$limiter  = step::get('limiter');
		if($limiter >= 7)
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

		$txt_text = "کارت $limiter\n".$card_front;
		$keyboard =
		[
			'keyboard' =>
			[
				["مشاهده پشت کارت"],
				["بعدی"],
			],
		];

		$result   =
		[
			'text'         => $txt_text,
			'reply_markup' => 	$keyboard,
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
			case 'skip':
			case '/skip':
				$r = \lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'skip');
				step::goingto(3);
				return self::step3();
				break;

			case 'مشاهده':
			case 'مشاهده پشت کارت':
			case 'مشاهده کارت':
			case 'show card':
			case '/show card':
			case 'show answer':
			case '/show answer':
			case 'show':
			case '/show':
				step::plus();
				$card_back = step::get('learn_card_back');
				// $txt_text  = "آیا این کارت را به خاطر داشتید؟\n". $card_back;
				$txt_text  = $card_back;
				$keyboard  =
				[
					'keyboard' =>
					[
						["بله", "خیر"],
					],
				];

				$result   =
				[
					'text'         => $txt_text,
					'reply_markup' => 	$keyboard,
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
			case 'yes':
			case '/yes':
				// save answer true
				\lib\db\cardusages::saveAnswer(bot::$user_id, step::get('learn_card_id'), 'true');
				break;

			case 'خیر':
			case 'no':
			case '/no':
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

		// create output text
		$txt_text = "وضعیت این دوره شما\n\n";
		$txt_text .= "پاس شده: \n";
		$txt_text .= "ناموفق: \n";
		$txt_text .= "یادگیری مجدد: \n";
		$txt_text .= "_name_ محصولی از ارمایل\n";
		$keyboard  =
		[
			'keyboard' =>
			[
				["شروع دوباره"],
				["بررسی وضعیت"],
				["بازگشت"],
			],
		];

		// get name of question
		$result   =
		[
			'text'         => $txt_text,
			'reply_markup' => 	$keyboard,
		];
		// return menu
		return $result;
	}


	public static function step7($_decision)
	{
		switch ($_decision)
		{
			case 'شروع دوباره':
			case 'learn':
			case '/learn':
				step::set('limiter', 0);
				step::goingto(3);
				return self::step3();
				break;

			case 'بررسی وضعیت':
			case 'review':
			case '/review':
				$txt_text = "نمایش وضعیت طبقه‌ها\n\n";
				$txt_text .= "...\n\n";
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
}
?>