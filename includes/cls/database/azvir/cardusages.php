<?php
namespace database\azvir;
class cardusages
{
	public $cardlist_id          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'cardlist'        ,'type'=>'int@11'                          ,'foreign'=>'cardlists@id!id'];
	public $user_id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $cardusage_deck       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'deck'            ,'type'=>'smallint@5'];
	public $cardusage_try        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'try'             ,'type'=>'smallint@5'];
	public $cardusage_trysuccess = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'trysuccess'      ,'type'=>'smallint@5'];
	public $cardusage_expire     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'expire'          ,'type'=>'datetime@'];
	public $cardusage_lasttry    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'lasttry'         ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------foreign
	public function cardlist_id()
	{
		$this->form()->type('select')->name('cardlist_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}

	public function cardusage_deck()
	{
		$this->form()->type('number')->name('deck')->min()->max('99999');
	}

	public function cardusage_try()
	{
		$this->form()->type('number')->name('try')->min()->max('99999');
	}

	public function cardusage_trysuccess()
	{
		$this->form()->type('number')->name('trysuccess')->min()->max('99999');
	}

	public function cardusage_expire()
	{
		$this->form()->type('text')->name('expire');
	}

	public function cardusage_lasttry()
	{
		$this->form()->type('text')->name('lasttry');
	}
}
?>