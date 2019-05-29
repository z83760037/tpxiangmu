<?php
namespace app\admin\controller;

use think\Controller;
// use app\admin\common\Adminuser;

class Index extends Controller
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
        $this->assign('data',json_encode($data));
        $this->assign('data2',json_encode($data2));
    	return view();
    }
}