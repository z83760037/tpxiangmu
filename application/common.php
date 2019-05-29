<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//加密
function mdPassword($password){
    return   md5(hash('sha256', $password).'HHsTieBu377mJtkg');
}

//树
function tree($data ,$pid = 0) {
    $tmp = array();
    foreach ($data as $key => $value) {
        if($value['pid'] == $pid) {
            $value['tree'] =tree($data ,$value['id']);
            $tmp[] = $value;
        }
    }
    return $tmp;
}

//树
function levelTree($cateRes,$pid=0,$level=0){
    static $arr=array();
    foreach ($cateRes as $k => &$v) {
        if($v['pid']==$pid){
            $v['level']=$level;
            $arr[]=$v;
            levelTree($cateRes,$v['id'],$level+1);
        }
    }
    return $arr;
}