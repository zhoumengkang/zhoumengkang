<?php
class BlogAction extends Action{
    protected $description;
    protected $keywords;
	public function __construct(){
		parent::__construct();
	}
	//首页
	public function index(){
		//顶置的帖子
		$top = d()->q('select * from z_blog where `status` = 2 order by toptime desc limit 10');
        //浏览的最多的帖子
        $maxRead = d()->q('select * from z_blog where `status` > 0 order by `count` desc limit 10');
		$links = d()->q('select id,name,url,rank from z_link where `status` > 0 and `is_mark` = 0 order by `rank` asc');
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 40");

        $res = d()->q("select * from z_blog where status = 1 and `nav` = 1 and `title` != '' order by id desc limit 20");
		
		if(is_array($res)){
			include './view/index.php';	
		}else{
			include './view/404.php';	
		}
		
	}

    /**
     * 根据分类阅读
     */
    public function blogList(){
         //顶置的帖子
		//$top = d()->q('select * from z_blog where `status` = 2 order by toptime desc limit 20');
        //浏览的最多的帖子
        $maxRead = d()->q('select * from z_blog where `status` > 0 order by `count` desc limit 10');
        $links = d()->q('select id,name,url,rank from z_link where `status` > 0 and `is_mark` = 0 order by `rank` asc');
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 40");

		$num = 40;
		$page = (int)$_GET['p']?(int)$_GET['p']:1;
		$start = ($page-1)*$num;
        if(!$_GET['nav']){$_GET['nav']=1;}
        $res = d()->q("select * from z_blog where status = 1 and nav =".intval($_GET['nav'])." order by id desc limit ".$start.','.$num);
        $totalNum = d()->q("select count(*) as num from z_blog where status = 1 and nav =".intval($_GET['nav']));
        if(is_array($res)){
            include './view/blogList.php';
        }else{
            include './view/404.php';
        }
    }

    /**
     * 根据标签分类阅读
     */
    public function readByTags(){
        //顶置的帖子
        //$top = d()->q('select * from z_blog where `status` = 2 order by toptime desc limit 10');
        //浏览的最多的帖子
        $maxRead = d()->q('select * from z_blog where `status` > 0 order by `count` desc limit 10');
        $links = d()->q('select id,name,url,rank from z_link where `status` > 0 and `is_mark` = 0 order by `rank` asc');
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 40");
        //dump($tags);exit;
        $num = 40;
        $page = (int)$_GET['p']?(int)$_GET['p']:1;
        $start = ($page-1)*$num;
        if($_GET['tag']){
            $res = d()->q('select * from z_blog a,z_blog_to_tags b where a.status > 0 and a.id = b.blog_id and b.tag_id = '.intval($_GET['tag']).' group by a.id order by a.id desc limit '.$start.','.$num);
            $totalNum = d()->q('select count(distinct b.blog_id) as num from z_blog a,z_blog_to_tags b where a.status > 0 and a.id = b.blog_id and b.tag_id = '.intval($_GET['tag']));
        }
        if(is_array($res)){
            include './view/readByTags.php';
        }else{
            include './view/404.php';
        }
    }

	/*public function rank(){
		$top = d()->q('select * from z_blog where status = 2 order by toptime desc limit 10');
		$links = d()->q('select * from z_link order by rank asc');
		$num = PERPAGES;
		$page = (int)$_GET['p']?(int)$_GET['p']:1;
		$start = ($page-1)*$num;
		$res = d()->q('select * from z_blog where `status` >0 order by `count` desc limit '.$start.','.$num);
			$totalNum = d()->q('select count(*) as num from z_blog where `status` >0');
		if(is_array($res)){
			include './view/index.php';	
		}else{
			include './view/404.php';	
		}
	}*/
	//登陆和退出
	public function login(){
        $res = d()->q('select id from z_user where id =1 and password ="'.md5(addslashes($_POST['password'])).'"');
        if($res[0]['id']==1){
            $_SESSION['uid']=1;
            //做一个简单的cookie加密
            $time = time();
            d()->q('update z_user set `lastlogin` = '.$time.' where id = 1');
            $cookie = md5($time.'zmk');
            setcookie('blogmaster',$cookie,time()+30*3600*24*30);
            echo 1;
        }else{
            echo 0;
        }
	}
	public function logout(){
		session_destroy();
        setcookie('blogmaster',null,time()-1);
		$url = U('Blog/index');
		header("Location: {$url}");
	}
	//文章发布页面
	public function post(){
		if(!$_SESSION['uid']){
			
			$url = U('Blog/index');
			header("Location: {$url}");

		}
		$action = $_GET['a'];
		include './view/post.php';
	}
	public function doPost(){
		if(!$_SESSION['uid']){
			$url = U('Blog/index');
			header("Location: {$url}");
		}
		//先存文章
		$nav=$_POST['nav']?$_POST['nav']:null;
		//存标签
		//dump($_POST);
		$tags1 = $_POST['selected_tags'];
		$tags1 = explode('addtags',$tags1);
		array_shift($tags1);
		//dump($tags1);
		$tags2=$_POST['tags'];
		
		if($tags2){
			$tags2=str_replace('，',',',$tags2);
			$tags2=explode(',',$tags2);
			//dump($tags2);
			foreach($tags2 as $k=>$v){
				$id = d()->q('select id from z_tags where name = "'.trim($v).'"' );
				//$ddd = d()->lastsql();
				//dump($ddd);
				if($id[0]>0){
					$tags[]=$id[0]['id'];
					//dump($tags);
				}else{
					$id = d()->q('insert into z_tags (`name`) values ("'.$v.'") ');
					//echo '新插入的数据<br/>';
					//dump($id);
					$tags[]=$id;
				}
			}
			$tags1=array_merge($tags,$tags1);
		}
		//dump($tags1);

        //对编辑器生成的无用标签和内容进行过滤
        //echo '<pre>'.htmlspecialchars($_POST['content']).'<pre><hr>';
        $search = array("/<p>\s+<br \/>\s+<\/p>/","/<p>\r\n<pre/","/<\/pre>\r\nCODE_EOF\r\n<\/p>/","/<p>\s+CODE_EOF\s+<\/p>/","/CODE_EOF/");
        $replace = array("","<pre","</pre>","","");
        $_POST['content'] = preg_replace($search,$replace,$_POST['content']);
        //echo '<pre>'.htmlspecialchars($_POST['content']).'<pre>';exit;

        $title = addslashes(htmlspecialchars($_POST['title'],ENT_QUOTES));
        $content = addslashes(htmlspecialchars($_POST['content'],ENT_QUOTES));
		$sql = 'insert into z_blog (`nav`,`title`,`content`,`ctime`)values("'.$nav.'","'.$title.'","'.$content.'",'.time().')';
		$res = d()->q($sql);
		if ($res < 0) {
            $this->jump('文章发表失败');
		}
		//往文章和标签的关系表里写数据
		if (count($tags1)) {
			foreach($tags1 as $v){
				$sql = "insert into z_blog_to_tags (`blog_id`,`tag_id`) values(".$res.",".$v.")";
				$result[] = d()->q($sql);
			}
	 		if(array_product($result)){
				$url = U('Blog/blog/',array('id'=>$res));
                $this->jump('文章发表成功',$url);
			}else{
				$this->jump('文章发表失败');
			}
		} else {
			$url = U('Blog/blog/',array('id'=>$res));
            $this->jump('文章发表成功',$url);
		}
	}

	//内容页
	public function blog(){
		$id = intval($_GET['id']);
		$res =d()->q("select * from z_blog where id = {$id} and `status`>0");
        if(!$res){
            include './view/404.php';
            exit;
        }

        //增加代码标签
        $res[0]['content'] = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$res[0]['content']);
        //还原被替换了的html标签方便匹配<img xxx>
        $res[0]['content'] = htmlspecialchars_decode($res[0]['content'],ENT_QUOTES);
        //把双引号等转义回来
        $this->title = htmlspecialchars_decode($res[0]['title'],ENT_QUOTES);
        $title = str_replace('"',"'",$this->title);
        $count = 0;
        //做懒加载匹配
        $res[0]['content'] = preg_replace_callback(
            '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',
            function($matches) use($title,&$count){
                //$info = getimagesize('http:'.'//'.$_SERVER['HTTP_HOST'].$matches[2]);
                if(strstr($matches[2],"http://")){
                    $info = getimagesize($matches[2]);
                }else{
                    $info = getimagesize(ROOT.$matches[2]);
                }

                //如果宽于480的，给480；窄于480的给实际的宽度
                //如果不写高度，网速快的时候可能感觉不到，如果网速慢，可能会导致页面拉倒下面之后，会“弹回到上面”的效果，之前逛淘宝深受其害。
                if($info[0] < 480){
                    $lazyImg = "<img data-original=\"".$matches[2]."\" width=\"".$info[0]."\" height=\"".$info[1]."\">";
                }else{
                    $_tmpHeight = intval((480*$info[1])/$info[0]);
                    $lazyImg = "<img data-original=\"".$matches[2]."\" width=\"480\" height=\"".$_tmpHeight."\">";
                }
                //找一张比较小的图作为文章的缩略图，供搜索引擎抓取
                if(($count< 1) && (filesize(ROOT.$matches[2])<240000)){
                    $lazyImg = str_replace(">"," alt=\"{$title}\" >",str_replace("data-original","src",$lazyImg));
                    $count++;
                }
                return $lazyImg;
            },
            $res[0]['content']
        );

		$tags = d()->q("select b.name,b.id from z_blog_to_tags a,z_tags b where a.blog_id =".$id." and a.tag_id=b.id group by a.tag_id");
        $num = PERPAGES;
        $page = (int)$_GET['p']?(int)$_GET['p']:1;
        $start = ($page-1)*$num;
        $comment = d()->q("select * from z_comment where `blogid` = {$id} and`status` > 0 order by `posttime` asc limit ".$start.",".$num);
        if(is_array($comment)){
            foreach($comment as $k =>$v){
                $comment[$k]['content'] = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$v['content']);
            }
        }
        $totalNum = d()->q("select count(*) as num from z_comment where `blogid` = {$id} and`status` > 0");

        $this->description = msubstr(cleanTheWhitespace(htmlspecialchars_decode($res[0]['content'],ENT_QUOTES)),0,200);
        $this->keywords = getKeywords($tags);
        $modify = d()->q("select * from z_modify where blog_id={$id} order by id asc");
        include './view/blog.php';

		$sql = "update z_blog set count=count+1 where id=".$id;
		d()->q($sql);
	}
	
	public function about(){
        include './view/about.php';
        //$this->jump('发表成功',U('Blog/index'));
    }

    public function tags(){
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 300");
        include './view/tagsList.php';
    }

    public function search(){
        if($_GET['keyword']){
            $keyword = htmlspecialchars(trim($_GET['keyword']));
            $res = d()->q("SELECT id,title,ctime from `z_blog` WHERE `title` LIKE '%".$keyword."%' AND status > 0");
        }
        include './view/search.php';
    }

    public function sitemap(){
        //生成sitemap,然后用伪静态配合
        header("Content-Type: text/xml; charset=utf-8");
        $siteUrl = "http://mengkang.net/";
        $header = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
        $content = "    <url>
        <loc>%s</loc>
        <lastmod>%s</lastmod>
        <changefreq>%s</changefreq>
        <priority>%s</priority>
    </url>\r\n";
        $header .= sprintf($content,$siteUrl,Date('Y-m-d',time()),'daily','1.0');
        $header .= sprintf($content,$siteUrl."notebook.html" ,Date('Y-m-d',time()),'daily','0.9');
        $header .= sprintf($content,$siteUrl."homesick.html" ,Date('Y-m-d',time()),'daily','0.9');
        $header .= sprintf($content,$siteUrl."playground.html" ,Date('Y-m-d',time()),'daily','0.9');
        $header .= sprintf($content,$siteUrl."tags.html" ,Date('Y-m-d',time()),'daily','0.9');

        $blogs = d()->q("SELECT `id`,`ctime` from `z_blog` WHERE status > 0 order by `id` DESC limit 200");

        foreach($blogs as $k=>$v){
            $header .= sprintf($content,$siteUrl.$v['id'].".html" ,Date('Y-m-d',$v['ctime']),'yearly','0.6');
        }

        $header .= "</urlset>";
        echo $header;
    }

    //增加404控制器
    public function error404(){
        include './view/404.php';
    }

    //单词本
    public function danciben(){
        include './view/danciben.php';
    }
}