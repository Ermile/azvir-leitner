<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\utility\telegram\tg as bot;
use \lib\utility\telegram\step;

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
			$result = step_register::start(__CLASS__, __FUNCTION__);
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
			'reply_markup' => self::drawKeyboard($catTypeList),
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
			step::goto(1);
			return self::step1();
		}
		// save category type
		step::set('learn_categoryType', $_txtCatType);
		$result =
		[
			'text'         => $txt_text,
			'reply_markup' => self::drawKeyboard($catList),
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
		if(is_numeric($_txtCat) || $_txtCat === null)
		{
			$cat_id = step::get('learn_category');
		}
		elseif($_txtCat)
		{
			step::set('learn_categoryText', $_txtCat);
			$cat_id = \lib\db\cardcats::catDetail($_txtCat);
			// save category details
		}
		else
		{
			return false;
		}
		// increase limiter
		step::plus(1, 'limiter');

		step::set('learn_category', $cat_id);

		// get last card details
		$lastCard = \lib\db\cardcats::lastCard($cat_id);
		$limiter  = step::get('limiter');
		if($limiter >= 7)
		{
			step::goto(6);
			return step::goto(6);
		}
		var_dump($lastCard);

		$card_front = 'salam';
		$card_back  = 'سلام';
		// set card details
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
				step::goto(3);
				return self::step3();
				break;

			case 'مشاهده':
			case 'مشاهده پشت کارت':
			case 'مشاهده کارت':
			case 'show card':
			case '/show card':
			case 'show':
			case '/show':
				step::plus();
				$card_back = step::get('learn_card_back');
				$txt_text  = "آیا این کارت را به خاطر داشتید؟\n". $card_back;
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
				break;

			case 'خیر':
			case 'no':
			case '/no':
				// save answer false
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
		step::goto(3);
		return self::step3();
	}





	/**
	 * show last menu
	 * @param  [type] $_item [description]
	 * @return [type]        [description]
	 */
	public static function step6($_item)
	{
		// create output text
		$txt_text = "سوال ". step::get('i')."\n\n";
		switch ($_item)
		{
			case 'ادامه خرید':
			case '/next':
			case 'next':
				step::goto(1);
				return self::step1();
				break;

			case 'مشاهده سبد خرید':
			case 'مشاهده سفارش':
			case '/card':
			case 'card':
			case 'showcard':
				$txt_text = self::showCard();
				// $txt_text = 'بزودی نتایح تهیه و نمایش داده می‌شوند:)';
				break;

			case 'اتمام سفارش':
			case '/paycart':
			case 'paycart':
				$txt_text = self::showCard();
				step::plus();
				return self::step6();
				// $txt_text = 'بزودی نتایح تهیه و نمایش داده می‌شوند:)';
				break;

			case 'بازگشت به منوی اصلی':
			case 'انصراف':
			case '/cancel':
			case 'cancel':
			case '/stop':
			case 'stop':
			case '/return':
			case 'return':
				return self::stop();
				break;

			default:
				$txt_text = 'لطفا یکی از گزینه‌های زیر را انتخاب نمایید';
				break;
		}


		// get name of question
		$result   =
		[
			'text' => $txt_text,
		];
		// return menu
		return $result;
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
				$final_text = "انصراف از ثبت سفارش\n";
			}
			step::stop();
		}
		elseif($_cancel === false)
		{
			$final_text = "سفارش شما تکمیل شد.\n";
			$final_text .= "تا دقایقی دیگر سفارش شما ارسال خواهد شد.\n";
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


	/**
	 * return answer keyborad array or keyboard
	 * @param  boolean $_onlyArray [description]
	 * @return [type]              [description]
	 */
	public static function drawKeyboard($_list = null, $_onlyArray = null)
	{
		if(!$_list)
		{
			return null;
		}
		if($_onlyArray === true)
		{
			// return array contain only list
			$_list = array_keys($_list);
			return $_list;
		}

		$menu =
		[
			'keyboard' => [],
			"one_time_keyboard" => true,
		];

		// calculate number of item in each row
		// max row can used is 3
		$inEachRow  = 1;
		$itemsCount = count($_list);
		$rowUsed    = $itemsCount;
		$rowMax     = 4;
		// if count of items is divided by 2
		if(($itemsCount % 2) === 0)
		{
			$inEachRow = 2;
			$rowUsed   = $itemsCount / 2;
			if($rowUsed > $rowMax)
			{
				if(($itemsCount % 3) === 0)
				{
					$inEachRow = 3;
					$rowUsed   = $itemsCount / 3;
				}
			}
		}
		// if count of items is divided by 3
		if($itemsCount > 6 && ($itemsCount % 3) === 0)
		{
			$inEachRow = 3;
			$rowUsed   = $itemsCount / 3;
		}

		$i = 0;
		foreach ($_list as $key => $value)
		{
			// calc row number
			$row = floor($i/ $inEachRow);
			// add to specefic row
			$menu['keyboard'][$row][] = $value;
			// increment counter
			$i++;
		}
		// $menu['keyboard'][] = ['گزینه سوم'];
		return $menu;
	}
}
?>