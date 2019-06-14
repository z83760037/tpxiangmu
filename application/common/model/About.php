<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 11:33
 */

namespace app\common\model;



class About extends Base
{
    //数据添加
    public function addAboutData(array $data)
    {
        return  $this->save($data);
    }

    //数据修改
    public function editAboutData($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return $this->save($data,['id' => $id]);
    }
}