<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 14:26
 */

namespace app\common\model;



class SystemLog extends Base
{
    //自动时间戳
    protected $updateTime = false;//修改时间

    /*
     * 操作日志
     */
    public function addSystemLog(string $msg)
    {
        $admin = session('admin');
        $url = request()->url();
        $data = [
            'msg'     => $admin['name'].$msg,
            'link'    => $url,
            'uid'     => $admin['id'],
        ];
        return $this->save($data);
    }

    //列表数据
    public function getLogData($page,$limit,$querys)
    {
        $size = ($page-1)*$limit;
        if (!empty($querys['start'])) {
            $startTime = strtotime($querys['start']);
        }

        if (!empty($querys['end'])) {
            $endTime   = strtotime($querys['end']);
            $endTime   = $endTime+(3600*24);
        }

        $where = '1=1';
        if (!empty($querys['name'])) {
            $name      = $querys['name'];
            $where .= " And u.name like '$name%'";
        }

        if (!empty($startTime) && empty($endTime)) {
            $where .= " And a.created > $startTime";
        } elseif (empty($startTime) && !empty($endTime)) {
            $where .= " And a.created < $endTime";
        }elseif (!empty($startTime) && !empty($endTime)) {
            $where .= " And a.created > $startTime And a.created < $endTime";
        }

        $data = $this
            ->alias('a')
            ->join('system_user u','a.uid=u.id','left')
            ->order('a.created desc')
            ->where($where)
            ->limit($size,$limit)
            ->field('a.*,u.name')
            ->select();

        $num  = db('system_log')
            ->alias('a')
            ->join('system_user u','a.uid=u.id','left')
            ->where($where)
            ->count();
        $arr  = [
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        ];
        return $arr;
    }
}