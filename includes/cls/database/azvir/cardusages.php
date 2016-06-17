<?php
namespace database\azvir;
class cardusages
{
	public $id                   = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $user_id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $cardlist_id          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'cardlist'        ,'type'=>'int@11'                          ,'foreign'=>'cardlists@id!id'];
	public $cardusage_answer     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'answer'          ,'type'=>'enum@true,false,skip,'];
	public $cardusage_deck       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'deck'            ,'type'=>'smallint@5'];
	public $cardusage_try        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'try'             ,'type'=>'smallint@5'];
	public $cardusage_trysuccess = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'trysuccess'      ,'type'=>'smallint@5'];
	public $cardusage_spendtime  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'spendtime'       ,'type'=>'smallint@5'];
	public $cardusage_expire     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'expire'          ,'type'=>'datetime@'];
	public $cardusage_lasttry    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'lasttry'         ,'type'=>'timestamp@'];
	public $cardusage_status     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire!enable'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function cardlist_id()
	{
		$this->form()->type('select')->name('cardlist_')->required();
		$this->setChild();
	}

	public function cardusage_answer()
	{
		$this->form()->type('radio')->name('answer')->required();
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

	public function cardusage_spendtime()
	{
		$this->form()->type('number')->name('spendtime')->min()->max('99999');
	}

	public function cardusage_expire()
	{
		$this->form()->type('text')->name('expire');
	}

	public function cardusage_lasttry()
	{
		$this->form()->type('text')->name('lasttry');
	}

	public function cardusage_status()
	{
		$this->form()->type('radio')->name('status')->required();
		$this->setChild();
	}
}
?>