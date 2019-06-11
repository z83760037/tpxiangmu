<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 11:33
 */

namespace app\admin\model;


use think\Model;

class About extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

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