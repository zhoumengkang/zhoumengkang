<?php
/**
 * description  : 路由表
 * @author      : zhoumengkang
 * createTime   : 17/3/14 23:28
 */
return array(
    //一级路由
    'blog/index'=>'./',
    'blog/about'=>'about.html',
    'blog/tags' =>'tags.html',
    //二级路由
    'blog/blog' =>array(
        1=>'[id].html',
        2=>'[id]-[p].html'
    ),
    'blog/readbytags'=>array(
        1=>'tag-[tag].html',
        2=>'tag-[tag]-[p].html'
    ),
    //三级路由
    'blog/bloglist'=>array(
        'nav'=>array(
            '1'=>array(
                1=>'notebook.html',
                2=>'notebook-[p].html',
            ),
            '2'=>array(
                1=>'homesick.html',
                2=>'homesick-[p].html',
            ),
            '3'=>array(
                1=>'playground.html',
                2=>'playground-[p].html',
            ),
        )
    ),
    'site/index'=>'sites.html',
    'danci/index'=>'danciben.html'
);