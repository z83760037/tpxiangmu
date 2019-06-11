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
            'created' => time(),
        ];
        return $this->save($data);
    }
}