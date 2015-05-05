<?php
namespace database\azvir;
class carddetails 
{
	public $user_id           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $card_id           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'card'            ,'type'=>'bigint@20'                       ,'foreign'=>'cards@id!card_title'];
	public $carddetails_date  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'datetime@'];
	public $carddetail_status = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@success,fail,ignore,change'];

	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function card_id()
	{
		$this->form()->type('select')->name('card_')->required();
		$this->setChild();
	}

	public function carddetails_date()
	{
		$this->form()->type('text')->name('date')->required();
	}

	public function carddetail_status()
	{
		$this->form()->type('radio')->name('status')->required();
		$this->setChild();
	}
}
?>