<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\utility\social\tg as bot;

class menu
{
	public static $return = false;

	public static function exec($_cmd)
	{
		$response = null;
		switch ($_cmd['command'])
		{
			case 'main':
			case '/main':
			case 'mainmenu':
			case 'menu':
			case '/menu':
			case 'منو۰':
				$response = self::main();
				break;

			case 'return':
			case 'بازگشت':
				// switch ($_cmd['text'])
				// {
				// 	case 'بازگشت به منوی اصلی':
				// 	default:
				// 		$response = user::start();
				// 		break;
				// }
				// $response = self::returnBtn();
				$response = user::start();
				break;

			default:
				break;
		}

		// automatically add return to end of keyboard
		if(self::$return)
		{
			// if has keyboard
			if(isset($response['reply_markup']['keyboard']))
			{
				$response['reply_markup']['keyboard'][] = ['بازگشت'];
			}
		}

		return $response;
	}



	/**
	 * create mainmenu
	 * @param  boolean $_onlyMenu [description]
	 * @return [type]             [description]
	 */
	public static function main($_onlyMenu = false)
	{
		// define
		$menu =
		[
			'keyboard' =>
			[
				["شروع یادگیری"],
				["درباره ℹ", "ثبت بازخورد"],
			],
		];

		if($_onlyMenu)
		{
			return $menu;
		}

		$txt_text = "منوی اصلی\n\n";

		$result =
		[
			[
				// 'method'       => 'editMessageReplyMarkup',
				'text'         => $txt_text,
				'reply_markup' => $menu,
			],
		];

		// return menu
		return $result;
	}
}
?>