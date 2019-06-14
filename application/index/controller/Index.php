<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/13
 * Time: 9:58
 */

namespace app\index\controller;


use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //文章
        $article = model('Article')->getArticleData(1,20);

        //24小时
        $articleNew = model('ArticleNews')->getNewsFalsh(1,20,1);

        //热门文章
        $articleHit = model('Article')->hit(5);

        //轮播
        $headline = model('ArticleHeadline')->where('status' ,1)->order('created desc')->select();
//        dump($headline);
        $this->assign([
            'article'    => $article,
            'articleNew' => $articleNew,
            'articleHit' => $articleHit,
            'headline'   => $headline,
        ]);
        return $this->fetch();
    }
}