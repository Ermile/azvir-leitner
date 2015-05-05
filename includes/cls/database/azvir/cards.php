<?php
namespace database\azvir;
class cards 
{
	public $id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'bigint@20'];
	public $card_front      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'front'           ,'type'=>'text@'];
	public $card_back       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'back'            ,'type'=>'text@'];
	public $card_createdate = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@'];
	public $date_modified   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}

	public function card_front()
	{
		$this->form()->type('textarea')->name('front')->required();
	}

	public function card_back()
	{
		$this->form()->type('textarea')->name('back')->required();
	}

	public function card_createdate()
	{
		$this->form()->type('text')->name('createdate');
	}

	public function date_modified(){}
}
?>