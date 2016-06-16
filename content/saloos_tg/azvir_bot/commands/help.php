<?php
namespace content\saloos_tg\azvir_bot\commands;
// use telegram class as bot
use \lib\utility\telegram\tg as bot;

class help
{
	/**
	 * show help message
	 * @return [type] [description]
	 */
	public static function help()
	{
		$text = "*_fullName_*\r\n\n";
		$text .= "دستورات زیر برای کار با ربات در دسترس شماست:\r\n\n";
		$text .= "/learn شروع یادگیری\n";
		$text .= "/504 شروع یادگیری ۵۰۴\n";
		$text .= "/450 شروع یادگیری ۴۵۰\n";

		$text .= "/feedback ثبت بازخورد\n";
		$text .= "/contact تماس با ما\n";
		$text .= "/about درباره _name_\n";
		$text .= "/cancel انصراف و شروع دوباره\n";
		$result =
		[
			[
				'text' => $text,
			],
		];

		return $result;
	}
}
?>