<?php
/**
 * description  : 路由表
 * @author      : zhoumengkang
 * createTime   : 17/3/14 23:28
 */
return array(
    //一级路由|规则路由
    'blog/blog'=>'[id]_[p].html',
    //配置多级路由
    'blog/index'=>array(
            //没传参数的情况
            'null'=>'./',
            //规则路由
            'tag'=>'tag_[tag].html',
            //定制路由
            'nav'=>array(
                '1'=>'notebook.html',
                '2'=>'homesick.html',
                '3'=>'playground.html',
            )
        ),
);