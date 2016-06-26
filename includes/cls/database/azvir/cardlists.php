<?php
namespace database\azvir;
class cardlists
{
	public $id      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $term_id = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'term'            ,'type'=>'int@10'                          ,'foreign'=>'terms@id!term_title'];
	public $card_id = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'card'            ,'type'=>'bigint@20'                       ,'foreign'=>'cards@id!id'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function term_id()
	{
		$this->form()->type('select')->name('term_')->required();
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