<?php
namespace app\common\model;

use think\Model;

class SystemMune extends Model
{
	public function getMuneAll()
	{
		// $role = session('admin')['role'];
		$ids = db('system_role')->where('id',1)->find();
		$data = db('system_mune')->where('id','in',$ids['ids'])->select();
		return $this->tree($data) ;
	}

	public function tree($data ,$pid = 0) {
    	$tmp = array();
    	foreach ($data as $key => $value) {
        	if($value['pid'] == $pid) {
            	$value['tree'] = $this->tree($data ,$value['id']);
            	$tmp[] = $value;            
        	}
   	 	}
    	return $tmp;
	}

	public function getMune()
	{
		$data = $this->all();
		return $this->tree($data);
	}
}