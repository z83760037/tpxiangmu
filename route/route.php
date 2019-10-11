<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//use think\Route;

//文章
Route::group('api/:version/article',function(){
    Route::get('/','web/:version.article/getArticleLimit');//文章分页数据
    Route::get('/detail/','web/:version.article/detail');//文章详情
    Route::get('/common/','web/:version.article/commentLoadMore');//文章详情
    Route::get('/headline','web/:version.article/headlineData');//轮播图
    Route::post('/common/msg','web/:version.article/msg');//评论添加
    Route::post('/collection','web/:version.article/Collection');//文章收藏
    Route::get('/hits','web/:version.article/hits');//更新浏览量
});


//用户
Route::group('api/:version/user',function(){
    Route::get('/favorites','web/:version.user/favorites');//我的收藏
    Route::get('/myArticle','web/:version.user/userArticle');//我的文章
    Route::get('/myNews','web/:version.user/userNews');//我的收藏
    Route::get('/my','web/:version.user/mine');
    Route::get('/comment','web/:version.user/myComment');//我评论
});