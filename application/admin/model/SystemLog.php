<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 14:26
 */

namespace app\admin\model;


use think\Model;

class SystemLog extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
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

//        $startTime = strtotime($querys['starttime']);
//        $endTime   = strtotime($querys['endtime']);
        $where = '1=1';
        if (!empty($querys['name'])) {
            $name      = $querys['name'];
            $where .= " And u.name like '$name%'";
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