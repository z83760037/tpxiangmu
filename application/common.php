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

function isMobile()
{
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

//时间函数
function formatDate($time){
//    $time = strtotime($time);
    $str = '';
    if (!empty($time)){
        $now =time();
        $timepart = $now-$time;
        if($timepart<= 60) //1分钟内
        {
            $str = "刚刚";
        }
        else if($timepart < 60*60 && $timepart > 60  ) //1小时内 显示多少分钟
        {
            $str = floor($timepart/60)."分钟前";
        }
        else if($timepart < 60*60*24  && $timepart > 60*60  ) //1天内 显示多少小时
        {
            $str = floor($timepart / (60*60))."小时前";
        }
        else if ($timepart < 60*60*24*7  && $timepart > 60*60*24){//一周以内
            $str = floor($timepart / (60*60*24))."天前";
        } else if ($timepart < 60*60*24*30  && $timepart > 60*60*24*7){//一月以内
            $str = floor($timepart / (60*60*24*7))."周前";
        } else if ($timepart < 60*60*24*365  && $timepart > 60*60*24*30){//一年以内
            $str = floor($timepart / (60*60*24*30))."个月前";
        } else if ($timepart > 60*60*24*365){//一年以后
            $str = floor($timepart / (60*60*24*365))."年前";
        }
    }
    return $str;
}
/**
 * php时间轴函数 ，刚刚、1分钟前、1小时前、一天前、两天前、具体日期
 * 时间格式化
 */
function formatDate2($time){
    $str = '';
    if (!empty($time)){
        $now =time();
        $timepart = $now-$time;
        if($timepart<= 60) //1分钟内
        {
            $str = "刚刚";
        }
        else if($timepart < 60*60 && $timepart > 60  ) //1小时内 显示多少分钟
        {
            $str = floor($timepart/60)."分钟前";
        }
        else if($timepart < 60*60*24  && $timepart > 60*60  ) //1天内 显示多少小时
        {
            $str = floor($timepart / (60*60))."小时前";
        }
        /* else if ($timepart < 60*60*24*3  && $timepart > 60*60*24) //3天内 显示1天前 2天前
         {
             $str = floor($timepart / (60*60*24))."天前";
         }*/
        else
        {
            $str = date('Y-m-d',$time); //超过3天 具体日期
        }
    }
    return $str;
}

//返回json数据
function show_json($data) {
    return json(['errorCode' => 0 , 'data' => $data]);
}