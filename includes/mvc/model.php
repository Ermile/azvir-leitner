<?php
namespace mvc;

class model extends \lib\mvc\model
{
	// this function get table name and return all record of it. table name can set in view
	// if user don't pass table name function use current real method name get from url
	public function datatable($_table = null, $_condition = null, $_rename = false)
	{
		$param_search = \lib\utility::get('search');

		// $cpModule     = $this->cpModule();
		$cpModule     = $this->Module();
		$mytype       = null;


		// set columns 
		// get all fields of table and filter fields name for show in datatable, access from columns variable
		switch ($cpModule)
		{
			case 'categories':
			case 'filecategories':
			case 'bookcategories':
			case 'tags':
				$tmp_columns      = \lib\sql\getTable::get('terms');
				unset($tmp_columns['term_type'] );
				unset($tmp_columns['term_slug'] );
				break;

			case 'posts':
			case 'pages':
			case 'books':
			case 'twitter':
			case 'facebook':
			case 'telegram':
				$tmp_columns      = \lib\sql\getTable::get('posts');
				$tmp_columns['post_publishdate']['table'] = true;
				unset($tmp_columns['post_type'] );
				unset($tmp_columns['post_slug'] );
				unset($tmp_columns['user_id'] );
				break;

			case 'attachments':
				$tmp_columns      = \lib\sql\getTable::get('posts');
				$tmp_columns['post_meta']['table'] = true;
				unset($tmp_columns['post_type'] );
				unset($tmp_columns['post_slug'] );
				unset($tmp_columns['post_status'] );
				unset($tmp_columns['user_id'] );
				// add type column
				$tmp_columns['post_meta']['label'] = T_('type');
				$tmp_columns['post_meta']['value'] = 'filetype';
				break;

			case 'users':
				$tmp_columns      = \lib\sql\getTable::get('users');
				unset($tmp_columns['user_pass'] );
				$tmp_columns['user_email']['table'] = true;
				$tmp_columns['user_displayname']['table'] = true;
				$tmp_columns['user_status']['table'] = true;
				break;

			default:
				$tmp_columns      = \lib\sql\getTable::get($cpModule);
				break;
		}


		if (!$_table)
			$_table = $cpModule['table'];
		$qry          = $this->sql()->table($_table);

		switch ($cpModule)
		{
			case 'categories':
			case 'filecategories':
			case 'bookcategories':
			case 'tags':
			case 'books':
			case 'posts':
			case 'pages':
			case 'attachments':
			case 'socialnetwork':
				$mytype = [$cpModule['prefix'].'_type' => $cpModule['type']];
				break;

			case 'profile':
				// $this->data->datarow = $this->model()->datarow('users', $this->login('id'));
				break;

			default:
				$mytype = null;
				break;
		}

		if(is_array($mytype))
		{
			foreach ($mytype as $key => $value)
				$qry = $qry->and($key, $value);
		}
		$total = $qry->select()->num();

		if(is_array($_condition))
		{
			foreach ($_condition as $key => $value)
				$qry = $qry->and($key, $value);
		}
		$param_draw   = \lib\utility::get('draw');
		if(!$param_draw)
			$param_draw = 1;

		if($param_search)
		{
			$qry = $qry->groupOpen('g_search');
			$qry = $qry->and($cpModule['prefix']."_title", 'LIKE', "'%$param_search%'");

			$qry = $qry->or($cpModule['prefix']."_slug", 'LIKE', "'%$param_search%'");
			
			$qry = $qry->or($cpModule['prefix']."_url", 'LIKE', "'%$param_search%'");

			$qry = $qry->groupClose('g_search');

			
		}
		$datatable  = ['draw' => $param_draw, 'total' => $total, 'filter' => $qry->select()->num()];

		// check for start and length
		$param_start  = \lib\utility::get('start');
		$param_length = \lib\utility::get('length');
		$param_sortby = \lib\utility::get('sortby');
		$param_order  = \lib\utility::get('order');


		if(!$param_start)
			$param_start = 0;
		if(!$param_length)
		{
			if($total>100)
				$param_length = 10;
			else
				$param_length = $total - $param_start;
		}

		if(!$param_sortby)
			$param_sortby = 'id';
		if(!$param_order)
			$param_order = 'DESC';


		$qry = $qry->limit($param_start, $param_length);
		$tmp_result = $qry->order($param_sortby, $param_order);
		


		// get only datatable fields on sql for optimizing size of json
		$col = array('id');
		foreach ($tmp_columns as $field => $attr)
		{
			if($attr['table'])
			{
				array_push($col, $field);
			}
		}
		$qry = $qry->field(...$col);
		$qry = $qry->select();

		$tmp_result = $qry->allassoc();


		// $tmp_result = $qry->allassoc();

		foreach ($tmp_result as $id => $row)
		{
			foreach ($row as $key => $value)
			{
				if($_rename)
				{
					$prefix = substr($_table, 0, -1).'_';
					// if(substr($key, 0, strlen($prefix) === $prefix))

					if(strpos($key, $prefix) !== false)
					{
						// remove old key
						unset($tmp_result[$id][$key]);
						// transfer value to new key
						$key = substr($key, strlen($prefix));
						$tmp_result[$id][$key] = $value;
					}
				}

				// if field contain json, decode it
				if(substr($value, 0,1) == '{')
					$tmp_result[$id][$key] = json_decode($value, true);

				switch ($key)
				{
					case 'post_status':
					case 'term_status':
						$tmp_result[$id][$key] = T_($value);
						break;
					
					default:
						# code...
						break;
				}
			}
		}

		$datatable['data']    = $tmp_result;
		$datatable['columns'] = $tmp_columns;

		return $datatable;
	}
}
?>