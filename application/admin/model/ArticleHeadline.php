<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 9:19
 */

namespace app\admin\model;


use think\Model;

class ArticleHeadline extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

    //数据添加
    public function addHeadlineData($data)
    {
        $res = $this->save($data);
        return $res;
    }

    //数据修改
    public function editHeadlineData($data)
    {
        $id  = $data['id'];
        unset($data['id']);
        $res = $this->where('id',$id)->update($data);
        return $res;
    }
}