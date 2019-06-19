<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/17
 * Time: 13:57
 */

namespace app\web\controller\v1;


use app\web\exception\BaseException;
use app\web\validate\CollectionValidate;
use app\web\validate\Common;
use app\web\validate\isIdNotNull;
use app\web\exception\ArticleException;
use think\Controller;
use think\Db;
use think\Exception;

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
    public function commentLoadMore($aid,$page = 1,$limit = 10)
    {
        $data = model('ArticleCommen')->getCommonDataByAid($aid,$page,$limit);
        return json($data);
    }

    //文章列表轮播
    public function headlineData()
    {
        $data = model('ArticleHeadline')->where('status' ,1)->order('created desc')->select();

        if (empty($data)) {
            throw new ArticleException();
        }
        return json($data);
    }

    //评论
    public function msg()
    {
        (new Common())->goCheck();//数据验证
        $data = request()->param();

        $res = model('ArticleCommen')->addComment($data);

        if ($res) {
            $user = model('ArticleCommen')->getCommenById(model('ArticleCommen')->id);
           return show_json($user);
        } else {
            throw new BaseException(['msg' => '添加失败']);
        }
    }

    //文章收藏
    public function Collection()
    {
        (new CollectionValidate())->goCheck();
        $data = request()->param();
        $res = model('UserCollect')->add($data);

        if ($res) {
            return json(['errorCode'=> 0,'msg' => '成功']);
        } else {
            return json(['errorCode'=> -1,'msg' => '失败']);
        }
    }

    //浏览量
    public function hits($aid)
    {
        Db::startTrans();
        try{
            $ip = request()->ip();
            $browse = model('UserBrowse')->where('bid',$aid)->where('ip',$ip)->find();

            if (empty($browse)) {
                $data = model('Article')->find($aid);
                $data->setInc('hits');   // 原数值加1
                $data->setInc('balance',0.04);   // 原数值加1
                model('User')->where('id',$data['uid'])->setInc('balance',0.04);   // 原数值加1
                model('UserBrowse')->save(['bid'=>$aid,'ip'=>$ip,'type'=>1,'created' => time()]);
            } else {
                $time = time();
                if (($time-$browse['created']) > 3600) {
                    $data = model('Article')->find($aid);
                    $data->setInc('hits');   // 原数值加1
                    $data->setInc('balance',0.04);   // 原数值加1
                    model('User')->where('id',$data['uid'])->setInc('balance',0.04);
                    model('UserBrowse')->where('bid',$aid)->where('ip',$ip)->update(['created'=>$time]);
                } else {
                    return json(['errorCode' => 10000, 'msg' => ($time-$browse['created'])]);
                }
            }
            Db::commit();
            return json(['errorCode' => 0, 'msg' => '成功']);
        } catch (\Exception $e) {
            Db::rollback();
//            throw new ArticleException(['msg' => $e->getMessage()]);
            return json(['errorCode' => 10000, 'msg' => $e->getMessage()],404);
        }

    }
}