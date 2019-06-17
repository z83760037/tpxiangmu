<?php
namespace app\web\validate;
use app\web\exception\BaseException;
use think\Validate;

class BaseValidate extends Validate {

	public function goCheck()
	{
		$param   = request()->param();
		$result	 = $this->batch()->check($param);
		if (!$result) {
			$e = new BaseException([
				'msg'	=> $this->getError(),
			]);
			throw $e;	
		} else {
			return true;
		}
	}

	protected function isPostitive($value,$rule = '', $data = '',$filed = ''){
		if (is_numeric($value) && is_int($value+0) && ($value + 0) > 0){
			return true;
		} else{
			return false;
		}
	}

	protected function isNotEmpty($value)
	{
		if (empty($value)) {
			return false;
		} else {
			return true;
		}
	}

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataByRule($array)
    {
        if (array_key_exists('user_id',$array) || array_key_exists('uid',$array)) {
            throw new ParameterException(['msg'=>'参数中包含非法参数user_id或uid']);
        }
        $newArray = [];
        foreach ($this->rule as $k => $v) {
            $newArray[$k] = $array[$k];
        }

        return $newArray;
    }


}