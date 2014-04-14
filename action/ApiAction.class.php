<?php
class ApiAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    /**
     * 微博卡片式文章显示
     */
    public function weiboCard(){
        $urlArray = parse_url(urldecode($_GET['url']));
        preg_match('/\/([0-9]+).html/', htmlspecialchars($urlArray['path']),$match);//获取文章id
        $id = $match[1];
        $q = d();
        $res =$q->q("select * from z_blog where id = {$id} ");
        //echo $q->lastsql();
        $title = $res[0]['title'];
        $content = msubstr(cleanTheWhitespace(htmlspecialchars_decode($res[0]['content'],ENT_QUOTES)),0,200);
        /*{
            "object_type": "article",
            "display_name": "新浪微博深耕中小V：采用“单向关系+帐号标签”账号推荐机制，沉淀优质内容和用户关系",
            "image": {
                "url": "http://img.t.sinajs.cn/t4/appstyle/open/images/webmaster/linkcard/resources/linkcard_img_type_2.jpg",
                "width": 120,
                "height": 120
            },
            "author": {
                "display_name": "36氪",
                "url": "http://www.quankr.com/",
                "object_type": "person"
            },
            "summary": "目前微博的用户结构可以基本概括为，“上层寡头化，中层断裂，以及底层碎片化”的倒“丁”字模型。而调整推荐机制后，用户整体结构更趋向于橄榄型。尤其是重点推荐“兴趣型选手”，有助于在垂直的兴趣领域进行深耕，沉淀更多的 PGC 内容，就又回到之前说的“沉淀优质内容和用户关系”上。",
            "url": "http://www.36kr.com/p/207851.html",
            "links": {
                "url": "http://www.36kr.com/p/207851.html",
                "scheme": "scheme://www.36kr.com/p/207851",
                "display_name": "阅读全文"
            },
            "tags": [
                {
                    "display_name": "column"
                }
            ],
            "create_at": "2013年11月22日"
        }*/
        $data['object_type'] = 'article';
        $data['display_name'] = $title;
        $data['image'] = array(
            "url"=>"http://mengkang.net/view/images/php.jpg",
            "width"=>120,
            "height"=>120
        );
        $data['author'] = array(
            "display_name"=>'北剅轩',
            "url"=>'http://mengkang.net/',
            "object_type"=>"person"
        );
        $data['summary'] = $content;
        $data['url'] = 'http://mengkang.net/'.$id.'.html';
        $data['links'] = array(
            "url"=>"http://mengkang.net/".$id.'.html',
            "scheme"=>"scheme://mengkang.net/".$id.'.html',
            "display_name"=>"阅读全文"
        );
        $data['create_at'] = date('Y年m月d日',$res[0]['ctime']);
        echo json_encode($data);

    }
}