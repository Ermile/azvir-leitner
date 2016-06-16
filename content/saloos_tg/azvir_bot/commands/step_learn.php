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

		step::set('learn_category', $cat_id);

		// get last card details
		$lastCard = \lib\db\cardcats::lastCard($cat_id);
		var_dump($lastCard);
		
		$card_front = 'salam';
		$card_back  = 'سلام';
		// set card details
		step::set('learn_card_front', $card_front);
		step::set('learn_card_back', $card_back);

		// go to next step
		step::plus();

		$txt_text = "کارت\n".$card_front;
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
	public static function step4($_txtAnswer)
	{
		// if user press next goto step 3 for 
		switch ($_txtAnswer)
		{
			case 'بعدی':
			case 'skip':
			case '/skip':
				step::goto(3);
				return self::step3();
				break;
		}


	}


	/**
	 * show last menu
	 * @param  [type] $_item [description]
	 * @return [type]        [description]
	 */
	public static function step5($_item)
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


	public static function step6()
	{
		$final_text = "سفارش شما تکمیل شد.\n";
		$final_text .= "تا دقایقی دیگر سفارش شما ارسال خواهد شد.\n";

		$result   =
		[
			'text'         => $final_text,
			// 'reply_markup' => null,
			// 'reply_markup' => $menu
		];
		// send order to admin of bot
		self::sendOrder();
		// stop order
		step::stop();
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


	/**
	 * save new product to card
	 * @param [type] $_category [description]
	 * @param [type] $_product  [description]
	 * @param [type] $_quantity [description]
	 */
	private static function addToCard($_category, $_product, $_quantity)
	{
		// get current order
		$myorder = step::get('order');
		// add this product to order
		$myorder[$_category][$_product] = $_quantity;
		if($_quantity == 0 && isset($myorder[$_category][$_product]))
		{
			unset($myorder[$_category][$_product]);
			if(isset($myorder[$_category]) && count($myorder[$_category]) === 0)
			{
				unset($myorder[$_category]);
			}
		}
		// save new order
		step::set('order', $myorder);
	}


	/**
	 * show user card
	 * @return [type] [description]
	 */
	private static function showCard()
	{
		$myorder    = step::get('order');
		$txt_card   = "سبد خرید\n";
		$totalPrice = 0;
		if(count($myorder) === 0 )
		{
			$txt_card   = "سبد خرید خالی است!\n";
		}
		else
		{
			foreach ($myorder as $category => $productList)
			{
				$txt_card .= "`$category`\n";
				foreach ($productList as $product => $quantity)
				{
					$productDetail = product::detail($product);
					$price = $productDetail['price'];
					$totalPrice += $quantity * $price;
					$txt_card .= "▫️ $product *". $quantity. "* ✕ `". $price. "`\n";
				}
			}
			$txt_card .= "\nجمع کل:* $totalPrice تومان* 💰";
		}
		return $txt_card;
	}


	private static function saveCard()
	{
			\lib\db\posts::insertOrder(bot::$user_id, $question_id, $answer_id, $_answer_txt);

	}


	// send order to admin
	private static function sendOrder($_desc = null)
	{
		$text   = "🚩 📨 سفارش جدید از ";
		$text   .= bot::response('from', 'first_name');
		$text   .= ' '. bot::response('from', 'last_name');
		$text   .= ' @'. bot::response('from', 'username');
		$text   .= "\n$_desc\n";
		$text   .= self::showCard();
		$text   .= "\nکد کاربر ". bot::response('from');

		$menu =
		[
			'inline_keyboard' =>
			[
				[
					[
						'text'          => 'ثبت در سیستم',
						'callback_data' => 'order_register',
					],
				],
				[
					[
						'text'          => 'کاربر نیاز به تایید',
						'callback_data' => 'order_verification',
					],
				],
			],
		];

		$result =
		[
			'method'       => 'sendMessage',
			'text'         => $text,
			'chat_id'      => '46898544',
			'reply_markup' => $menu,

		];
		var_dump($result);
		$result = bot::sendResponse($result);
		var_dump($result);
		return $result;
	}
}
?>