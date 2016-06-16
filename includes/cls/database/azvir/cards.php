<?php
namespace database\azvir;
class cards
{
	public $id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'bigint@20'];
	public $user_id         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $card_front      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'front'           ,'type'=>'int@10'];
	public $card_back       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'back'            ,'type'=>'int@10'];
	public $card_createdate = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@'];
	public $date_modified   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_');
		$this->setChild();
	}

	public function card_front()
	{
		$this->form()->type('number')->name('front')->min()->max('9999999999')->required();
	}

	public function card_back()
	{
		$this->form()->type('number')->name('back')->min()->max('9999999999')->required();
	}

	public function card_createdate(){}

	public function date_modified(){}
}
?>