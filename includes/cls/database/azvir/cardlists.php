<?php
namespace database\azvir;
class cardlists
{
	public $id         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $cardcat_id = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'cardcat'         ,'type'=>'int@10'                          ,'foreign'=>'cardcats@id!id'];
	public $card_id    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'card'            ,'type'=>'bigint@20'                       ,'foreign'=>'cards@id!id'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function cardcat_id()
	{
		$this->form()->type('select')->name('cardcat_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function card_id()
	{
		$this->form()->type('select')->name('card_')->required();
		$this->setChild();
	}
}
?>