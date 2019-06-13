<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 9:41
 */

namespace app\admin\model;


use think\Db;

class Links extends Base
{
    //数据添加
    public function addLinksData($data)
    {
        $sort = $this->Max('sort');
        $data['sort'] = $sort+1;
        $res = $this->save($data);
        return $res;
    }

    //修改数据
    public function editLinksData($data)
    {
        $id  = $data['id'];
        unset($data['id']);
        $res = $this->save($data,['id' => $id]);
        return $res;
    }

    //排序
    public function reorder($id,$sort)
    {
        Db::startTrans();
        try{
            $info = db('links')->find($id);
            $data = db('links')->where('id','<>',$id)->order('sort asc')->select();
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