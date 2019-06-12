<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/12
 * Time: 14:07
 */

namespace app\admin\controller;


class Feedback extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open($page,$limit)
    {
        $data = model('UserFeedback')->getFeedbackData($page,$limit);
        echo json_encode($data);
    }
}