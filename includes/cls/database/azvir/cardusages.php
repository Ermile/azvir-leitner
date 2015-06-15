<?php
namespace database\azvir;
class cardusages 
{
	public $card_id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'card'            ,'type'=>'bigint@20'                       ,'foreign'=>'cards@id!id'];
	public $user_id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $cardcat_id           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'cardcat'         ,'type'=>'int@10'                          ,'foreign'=>'cardcats@id!id'];
	public $cardusage_deck       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'deck'            ,'type'=>'smallint@5'];
	public $cardusage_try        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'try'             ,'type'=>'smallint@5'];
	public $cardusage_trysuccess = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'trysuccess'      ,'type'=>'smallint@5'];
	public $cardusage_expire     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'expire'          ,'type'=>'datetime@'];
	public $cardusage_lasttry    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'lasttry'         ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------foreign
	public function card_id()
	{
		$this->form()->type('select')->name('card_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function cardcat_id()
	{
		$this->form()->type('select')->name('cardcat_');
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