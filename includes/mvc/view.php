<?php
namespace mvc;

class view extends \lib\mvc\view
{
	function _construct()
	{
		// define default value for global

		$this->data->site['title']   = T_("Ermile");
		$this->data->site['desc']    = T_("Ermile is new");
		$this->data->site['slogan']  = T_("Ermile is our company");

		$this->data->page['desc']    = T_("Ermile is Inteligent.");

		// add language list for use in display
		$this->global->langlist		= array(
												'fa_IR' => 'فارسی',
												'en_US' => 'English',
												'de_DE' => 'Deutsch'
												);

		$this->url->MainStatic       = false;
		$this->include->css_main     = false;
		$this->include->js_main      = false;
		$this->include->css          = true;
		$this->include->js           = false;
		// if you need to set a class for body element in html add in this value
		// $this->data->bodyclass      = null;

		if(method_exists($this, 'options')){
			$this->options();
		}
	}
}
?>