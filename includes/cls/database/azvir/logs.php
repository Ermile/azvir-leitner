<?php
namespace database\azvir;
class logs 
{
	public $id             = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'bigint@20'];
	public $logitem_id     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'logitem'         ,'type'=>'smallint@5'                      ,'foreign'=>'logitems@id!id'];
	public $user_id        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $log_status     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'varchar@50'];
	public $log_createdate = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@'];
	public $date_modified  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function logitem_id()
	{
		$this->form()->type('select')->name('logitem_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_');
		$this->setChild();
	}

	public function log_status()
	{
		$this->form()->type('text')->name('status')->maxlength('50');
	}

	public function log_createdate()
	{
		$this->form()->type('text')->name('createdate')->required();
	}

	public function date_modified(){}
}
?>