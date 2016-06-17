<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\utility\telegram\tg as bot;
use \lib\utility\telegram\step;

class handle
{
	public static $return = false;

	public static function exec($_cmd)
	{
		$response = null;
		// check if we are in step then go to next step
		$response = step::check($_cmd['text'], $_cmd['command']);
		if($response)
		{
			return $response;
		}

		switch ($_cmd['command'])
		{
			case '/menu':
			case '/cancel':
			case 'cancel':
			case '/stop':
			case 'menu':
			case 'main':
			case 'mainmenu':
			case 'منو':
				$response = menu::main();
				break;

			case '/learn':
			case 'learn':
			case 'شروع':
			case 'شروع یادگیری':
				$response = step_learn::start();
				break;

			case '/feedback':
			case 'feedback':
			case 'ثبت':
			case 'ثبت بازخورد':
				$response = step_feedback::start();
				break;

			case 'return':
			case 'بازگشت':
				$response = menu::main();
				break;

			default:
				break;
		}

		// automatically add return to end of keyboard
		if(self::$return)
		{
			// if has keyboard
			if(isset($response['replyMarkup']['keyboard']))
			{
				$response['replyMarkup']['keyboard'][] = ['بازگشت'];
			}
		}

		return $response;
	}
}
?>