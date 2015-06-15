<?php
namespace database\azvir;
class cardcats 
{
	public $id             = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $user_id        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $cardcat_type   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'type'            ,'type'=>'varchar@50'];
	public $cardcat_title  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@50'];
	public $cardcat_slug   = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'slug'            ,'type'=>'varchar@50'];
	public $cardcat_desc   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $cardcat_url    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'url'             ,'type'=>'varchar@200'];
	public $cardcat_parent = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'parent'          ,'type'=>'int@10'                          ,'foreign'=>'cardcats@id!cardcat_title'];
	public $cardcat_count  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'count'           ,'type'=>'smallint@5'];
	public $cardcat_status = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire,public,private,protected!enable'];
	public $date_modified  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_');
		$this->setChild();
	}

	public function cardcat_type()
	{
		$this->form()->type('text')->name('type')->maxlength('50');
	}

	public function cardcat_title()
	{
		$this->form('#title')->type('text')->name('title')->maxlength('50')->required();
	}

	public function cardcat_slug()
	{
		$this->form('#slug')->type('text')->name('slug')->maxlength('50')->required();
	}

	public function cardcat_desc()
	{
		$this->form('#desc')->type('textarea')->name('desc');
	}

	public function cardcat_url()
	{
		$this->form()->type('textarea')->name('url')->maxlength('200')->required();
	}

	public function cardcat_parent()
	{
		$this->form()->type('select')->name('parent');
		$this->setChild();
	}

	public function cardcat_count()
	{
		$this->form()->type('number')->name('count')->min()->max('99999');
	}

	public function cardcat_status()
	{
		$this->form()->type('radio')->name('status')->required();
		$this->setChild();
	}

	public function date_modified(){}
}
?>