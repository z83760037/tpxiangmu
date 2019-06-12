<?php
namespace app\admin\controller;


class Index extends Base
{
    public function index()
    {	
    	$data = model('SystemMune')-> getMuneAll();
    	$this->assign('mune',$data);
        return view();
    }

    public function home()
    {   
    	$data = [
                'data' => [
                    ['value'=>335, 'name'=>'直接访问'],
                    ['value'=>310, 'name'=>'邮件营销'],
                    ['value'=>234, 'name'=>'联盟广告'],
                    ['value'=>135, 'name'=>'视频广告'],
                    ['value'=>1548, 'name'=>'搜索引擎']
                ],
                'name' => 'ada',
        ];
        $data2 = [
                    'data' => [
                        ['value'=>335, 'name'=>'直接'],
                        ['value'=>310, 'name'=>'邮件'],
                        ['value'=>234, 'name'=>'联盟'],
                        ['value'=>135, 'name'=>'视频'],
                        ['value'=>1548, 'name'=>'搜索'],
                    ],
                    'name' => 123
                ];
        //用户总数
        $userNum = model('User')->count();

        //今天注册数
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));//今天零点时间戳
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//第二天零时时间戳
        $register = model('User')->where('created','>',$beginToday)->where('created','<',$endToday)->count();

        //文章总数
        $article = model('Article')->count();

        //待审核文章数
        $articlenum = model('Article')->where('status',0)->count();

        $this->assign('data',json_encode($data));
        $this->assign('data2',json_encode($data2));
        $this->assign([
            'usernum'  => $userNum,
            'register' => $register,
            'article'  => $article,
            'articlenum' => $articlenum,
        ]);
    	return view();
    }
}