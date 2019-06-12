<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 14:17
 */

namespace app\admin\model;

use think\Db;

class Joinus extends Base
{
    //列表页数据
    public function getJoinusData()
    {
        $data = $this->where('pid',0)->order('sort asc')->select();
        $num  =  $this->where('pid',0)->count();
        $arr = [
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        ];
        return $arr;
    }

    //一级分类添加
    public function addJoinusData($data)
    {
        $sort = $this->where('pid',0)->Max('sort');
        $data['sort'] = $sort+1;
        $data['pid']  = 0;
        $res = $this->save($data);
        return $res;
    }

    //一级分类修改
    public function editJoinusData($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return $this->save($data,['id' => $id]);
    }

    //排序
    public function reorder($id,$sort)
    {
        Db::startTrans();
        try{
            $info = db('joinus')->find($id);
            $data = db('joinus')->where('id','<>',$id)->order('sort asc')->select();
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

    //二级分类列表数据
    public function getJobData($id)
    {
        $data = $this->where('pid',$id)->order('sort asc')->select();
        $num  = $this->where('pid',$id)->count();
        $arr = [
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        ];
        return $arr;
    }

    //二级分类数据天机
    public function addJobData($data)
    {
        $sort = $this->where('pid',$data['pid'])->Max('sort');
        $data['sort'] = $sort+1;
        $res = $this->save($data);
        return $res;
    }

    //二级分类数据修改
    public function editJobData($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return $this->save($data,['id' => $id]);
    }

    //二级分类排序
    public function reorderJob($id,$sort,$pid)
    {
        Db::startTrans();
        try{
            $info = db('joinus')->find($id);
            $data = db('joinus')
                ->where('id','<>',$id)
                ->where('pid',$pid)
                ->order('sort asc')
                ->select();
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