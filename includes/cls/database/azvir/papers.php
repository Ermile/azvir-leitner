<?php
namespace database\azvir;
class papers
{
	public $id         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@20'];
	public $paper_text = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'text'            ,'type'=>'text@'];

	//--------------------------------------------------------------------------------id
	public function id(){}

	public function paper_text()
	{
		$this->form()->type('textarea')->name('text')->required();
	}
}
?>