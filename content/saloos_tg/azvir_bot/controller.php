<?php
namespace content\saloos_tg\azvir_bot;
// use telegram class as bot
use \lib\utility\telegram\tg as bot;

class controller extends \lib\mvc\controller
{
	/**
	 * allow telegram to access to this location
	 * to send response to our server
	 * @return [type] [description]
	 */
	function _route()
	{
		$myhook = 'saloos_tg/azvir_bot/'.\lib\utility\option::get('telegram', 'meta', 'hookFolder');
		if($this->url('path') == $myhook)
		{
			bot::$api_key     = '223397161:AAHIEGA4XnlkoAv4IHL3iCCBHekoYixlI2A';
			bot::$name        = 'azvir_bot';
			bot::$language    = 'fa_IR';
			bot::$cmdFolder   = '\\'. __NAMESPACE__ .'\commands\\';
			bot::$defaultText = 'تعریف نشده /help';
			bot::$defaultMenu = commands\menu::main(true);
			bot::$fill        =
			[
				'name'     => 'ازویر',
				'fullName' => 'سرویس ازویر',
				// 'about'    => $txt_about,
			];
			$result         = bot::run();

			if(\lib\utility\option::get('telegram', 'meta', 'debug'))
			{
				var_dump($result);
			}
			exit();
		}
	}
}
?>