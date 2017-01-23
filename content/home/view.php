<?php
namespace content\home;

class view extends \mvc\view
{
	public function config()
	{
		// $this->data->bodyel     = "data-spy='scroll' data-offset='0' data-target='#navbar-main'";

		// $this->url->MainStatic       = false;
		// $this->include->css_main     = false;
		$this->include->fontawesome  = true;
		$this->include->chart  = true;
		// $this->include->css          = false;
		// $this->include->js           = false;
	}
}
?>
