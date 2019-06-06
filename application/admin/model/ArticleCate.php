<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/5
 * Time: 16:28
 */

namespace app\admin\model;


use think\Db;
use think\Exception;
use think\Model;

class ArticleCate extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

    public function addCateData($data){
        $sort = $this->Max('sort');
        $data['sort'] = $sort+1;
        $res = $this->save($data);
        return $res;
    }

    //修改数据
    public function editCateData($data)
    {
        $id  = $data['id'];
        unset($data['id']);
        $res = $this->where('id',$id)->update($data);
        return $res;
    }

    //排序
    public function reorder($id,$sort)
    {
        Db::startTrans();
        try{
            $info = db('article_cate')->find($id);
            $data = db('article_cate')->where('id','<>',$id)->order('sort asc')->select();
            array_splice($data, $sort-1, 0, [$info]);
            if($data){
                foreach($data as $k => $v){
                    $this->where('id',$v['id'])->update(array('sort'=>$k+1));
                }
            }
            Db::commit();
            return true;
        } catch (Exception $e) {
            Db::rollback();
            return false;
        }
    }
}