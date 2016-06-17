<?php
namespace database\azvir;
class cardusagedetails
{
	public $id                        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@11'];
	public $cardusage_id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'cardusage'       ,'type'=>'int@10'                          ,'foreign'=>'cardusages@id!id'];
	public $cardusagedetail_answer    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'answer'          ,'type'=>'enum@true,false,skip'];
	public $cardusagedetail_spendtime = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'spendtime'       ,'type'=>'int@11'];
	public $cardusagedetail_deck      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'deck'            ,'type'=>'smallint@6'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function cardusage_id()
	{
		$this->form()->type('select')->name('cardusage_')->required();
		$this->setChild();
	}

	public function cardusagedetail_answer()
	{
		$this->form()->type('radio')->name('answer')->required();
		$this->setChild();
	}

	public function cardusagedetail_spendtime()
	{
		$this->form()->type('number')->name('spendtime')->max('99999999999');
	}

	public function cardusagedetail_deck()
	{
		$this->form()->type('number')->name('deck')->min()->max('999999');
	}
}
?>