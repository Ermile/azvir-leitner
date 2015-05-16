<?php
namespace cls\form;

class account extends \lib\form
{
	public function __construct($function=null)
	{
		if ($function and method_exists($this, $function))
		{
			$this->$function();
		}
		else
		{
			return;
		}
	}

	private function cat()
	{
		$this->cardcat_title = $this->make()->type('text')->name('cardcat_title');
		$this->submit	= $this->make('submit')->title(T_('Create'));
	}
}
?>