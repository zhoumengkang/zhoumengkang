<?php
class BlogAction extends Action{
	public function __construct(){
		parent::__construct();
	}
	//列表页
	public function index(){
		//顶置的帖子
		$top = d()->q('select * from z_blog where `status` = 2 order by toptime desc limit 10');
        //浏览的最多的帖子
        $maxRead = d()->q('select * from z_blog where `status` > 0 order by `count` desc limit 10');
		$links = d()->q('select * from z_link where `status` > 0 order by rank asc');
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 20");
        //dump($tags);exit;
		$num = PERPAGES;
		$page = (int)$_GET['p']?(int)$_GET['p']:1;
		$start = ($page-1)*$num;
		if($_GET['tag']){
			$res = d()->q('select * from z_blog a,z_blog_to_tags b where a.status >0 and a.id = b.blog_id and b.tag_id = '.intval($_GET['tag']).' group by a.id order by a.id desc limit '.$start.','.$num);
			$totalNum = d()->q('select count(distinct b.blog_id) from z_blog a,z_blog_to_tags b where a.status >0 and a.id = b.blog_id and b.tag_id = '.intval($_GET['tag']));
		}/*elseif($_GET['nav']){
			$res = d()->q("select * from z_blog where status > 0 and nav =".intval($_GET['nav'])." order by id desc limit ".$start.','.$num);
			$totalNum = d()->q("select count(*) as num from z_blog where status > 0 and nav =".intval($_GET['nav']));
		}else{
			$res = d()->q('select * from z_blog where status >0 order by id desc limit '.$start.','.$num);
			$totalNum = d()->q('select count(*) as num from z_blog where status >0');
		}*/else{
            if(!$_GET['nav']){$_GET['nav']=1;}
            $res = d()->q("select * from z_blog where status > 0 and nav =".intval($_GET['nav'])." order by id desc limit ".$start.','.$num);
            $totalNum = d()->q("select count(*) as num from z_blog where status > 0 and nav =".intval($_GET['nav']));
        }
		
		if(is_array($res)){
			include './view/index.php';	
		}else{
			include './view/404.php';	
		}
		
	}
	public function rank(){
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
	}
	//登陆和退出
	public function login(){
        $res = d()->q('select id from z_user where id =1 and password ="'.md5(addslashes($_POST['password'])).'"');
        if($res[0]['id']==1){
            $_SESSION['uid']=1;
            echo 1;
        }else{
            echo 0;
        }
	}
	public function logout(){
		session_destroy();
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
        $title = htmlspecialchars($_POST['title'],ENT_QUOTES);
        $content = htmlspecialchars($_POST['content'],ENT_QUOTES);
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
		$tags = d()->q("select b.name,b.id from z_blog_to_tags a,z_tags b where a.blog_id =".$id." and a.tag_id=b.id group by a.tag_id");
		//dump($tags);
        $num = 3;
        $page = (int)$_GET['p']?(int)$_GET['p']:1;
        $start = ($page-1)*$num;
        $comment = d()->q("select * from z_comment where `blogid` = {$id} and`status` > 0 order by `posttime` desc limit ".$start.",".$num);
        /*$comment = array_map(function($data){
            preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$data['content']);
        },$comment);*/
        foreach($comment as $k =>$v){
            $comment[$k]['content'] = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$v['content']);
        }
        //dump($comment);exit;
        $totalNum = d()->q("select count(*) as num from z_comment where `blogid` = {$id} and`status` > 0");


        if($res){
			$this->title = $res[0]['title'].'_周梦康的博客';
			$modify = d()->q("select * from z_modify where blog_id={$id} order by id asc");
			include './view/blog.php';
		}else{
			include './view/404.php';
		}
		$sql = "update z_blog set count=count+1 where id=".$id;
		d()->q($sql);
	}
	
	/*public function getNav(){
		$id = addslashes($_POST['id']);
		$sql = "select * from z_nav where status = 1 and pid = $id";
		$nav = d()->q($sql);
		echo json_encode($nav);
	}*/
	
	public function about(){
        echo '屌丝。。。';
        //$this->jump('发表成功',U('Blog/index'));
    }

    public function tags(){
        $tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS linktimes FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY linktimes DESC LIMIT 300");
        include './view/tagsList.php';
    }
}