<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/12
 * Time: 10:14
 */

namespace app\admin\controller;


class Log extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open($page,$limit)
    {
        $querys = request()->param();
        $data = model('SystemLog')->getLogData($page,$limit,$querys);
        echo json_encode($data);
    }
}