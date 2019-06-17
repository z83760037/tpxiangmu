<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/17
 * Time: 13:57
 */

namespace app\web\controller\v1;


use app\web\validate\isIdNotNull;
use app\web\exception\ArticleException;
use app\web\exception\BaseException;
use think\Controller;

class Article extends Controller
{
    /* url  web/api/v1/article
     * 文章分页列表
     * @param int $page 页数
     * @param int $limit 显示的数量
     * return json
     */
    public function getArticleLimit($page = 1,$limit = 10)
    {
        $key = 'ArticleLimit'.$page;
        //获取缓存
        $cacheData = cache($key);
        if (!empty($cacheData)) {
            return json($cacheData);
        }
        $data = model('Article')->getArticleData($page,$limit,['type' => 1]);
        if (empty($data)) {
            throw new ArticleException();
        }
        cache($key,$data,43200);
        return json($data);
    }

    /*
     *  url web/api/v1/detail/aid
     *  文章详情页
     *  @param int $aid 文章id
     *  return json
     */
    public function detail($aid)
    {
        (new isIdNotNull())->goCheck();
        model('Article')->where('id',$aid)->setInc('hits');   // 原数值加1
        model('Article')->where('id',$aid)->setInc('balance',0.04);   // 原数值加1
//        $key = 'article'.$aid;
//        //获取缓存
//        $cacheData = cache($key);
//        if (!empty($cacheData)) {
//            return json($cacheData);
//        }
        //文章详情
        $data['article'] = model('Article')->getArticleById($aid,1);
        $data['otherArticleData'] = model('Article')->otherArticle($aid);
//        cache($key,$data,43200);
        return json($data);
    }

    /*  url web/api/v1/common/aid
     *  文章评论
     */
    public function commentLoadMore($aid,$page,$limit)
    {
        $data = model('ArticleCommen')->getCommonDataByAid($aid,$page,$limit);
    }
}