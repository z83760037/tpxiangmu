<?php
namespace app\admin\controller;


class Activity extends Base
{
	public function index()
	{
		return $this->fetch();
	}

	public function open($page = 1,$limit = 10)
	{
		$data = model('Activity')->getActivityAll($page,$limit);
		$num  = model('Activity')->num();
		$arr = [
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        ];
        echo json_encode($arr);
	}
}
  