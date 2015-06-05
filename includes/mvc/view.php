<?php
namespace mvc;

class view extends \lib\mvc\view
{
	function _construct()
	{
		// define default value for global

		$this->data->site['title']   = T_("Azvir");
		$this->data->site['desc']    = T_("Ermile is new");
		$this->data->site['slogan']  = T_("Ermile is our company");

		$this->data->page['desc']    = T_("Ermile is Inteligent.");


		// $this->url->MainStatic       = false;
		// $this->include->css_main     = false;
		$this->include->css          = true;
		$this->include->js           = false;
		// if you need to set a class for body element in html add in this value
		// $this->data->bodyclass      = null;

		$this->data->display['cards']     = "content_cards/home/layout.html";
	}
}
?>