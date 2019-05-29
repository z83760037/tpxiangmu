<?php
namespace app\admin\validate;
use think\Validate;
use think\Request;

class BaseValidate extends Validate {

	public function goCheck()
	{
		$param   = request()->param();
//		$result	 = $this->batch()->check($param);
		$result	 = $this->check($param);
		if (!$result) {
//			$e = new ParameterException([
//				'msg'	=> $this->getError(),
//			]);
			return $this->getError();
		} else {
			return false;
		}
	}

    protected function isPostitive($value,$rule = '', $data = '',$filed = ''){
        if (is_numeric($value) && is_int($value+0) && ($value + 0) > 0){
            return true;
        } else{
            return false;
        }
    }
}