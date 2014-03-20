<?php
/**
 * description  : 路由表
 * @author      : zhoumengkang
 * createTime   : 17/3/14 23:28
 */
return array(
    'blog/index'=>'./',
    'blog/about'=>'about.html',
    'blog/tags' =>'tags.html',
    //一级路由|规则路由
    'blog/blog' =>array(
        1=>'[id].html',
        2=>'[id]-[p].html'
    ),
    //配置多级路由
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
    'blog/readbytags'=>array(
        1=>'tag-[tag].html',
        2=>'tag-[tag]-[p].html'
    ),
);