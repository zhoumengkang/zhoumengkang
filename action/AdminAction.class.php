<?php
class AdminAction extends Action{
	public function __construct(){
		parent::__construct();
		if(!$_SESSION['uid']){
			$url = U('Blog/login');
			header("Location: {$url}");
		}
	}
	public function info(){
		if($_POST){
			$sql = 'update z_info set `name`="'.$_POST['name'].'",`des`="'.$_POST['des'].'" where id =1';
			$flag = d()->q($sql);
			if($flag==1){
				$this->info = d()->q("select * from z_info");
			}

		}
		include './view/info.php';	
	}
	public function links(){
		if($_POST){
			//dump($_POST);
			if($_POST['id']){
				//update
				$sql = "update z_link set `name`='{$_POST['name']}',`url`='{$_POST['url']}',`rank`='{$_POST['rank']}' where `id`='{$_POST['id']}'";
				$flag = d()->q($sql);
				$_POST=null;
			}else{
				//insert
				$sql = "insert into z_link(`name`,`url`,`rank`)values('{$_POST['name']}','{$_POST['url']}',{$_POST['rank']})"; 
				//dump($sql);
				$flag = d()->q($sql);
				$_POST=null;
			}
		}
		$links = d()->q('select * from z_link order by rank asc');
		include './view/links.php';	
	}
	public function delLinks(){
		$sql = "delete from z_link where `id` =".$_POST['id'];
		d()->q($sql);
	}
	public function nav(){
		$sql = "select * from z_nav";
		$res = d()->q($sql);
		include './view/navlist.php';	
	}
	/*public function tags(){
		$res = d()->q("select * from z_nav");
		include './view/tags.php';	
	}*/
	public function addNav(){
		//先查询
		//$_POST['name']='zmk12233322s';
		//$_POST['pid'] = 1;
		$pid = $_POST['pid']?$_POST['pid']:0;
		$sql ="select id from z_nav where name='{$_POST['name']}'";
		$res = d()->q($sql);
		if($res[0]['id']>0){
			echo  false;
			return;
		}
		//查无此项再插入
		$sql = "insert into z_nav(`name`,`pid`,`status`)values('{$_POST['name']}',{$pid},1)";
		$id = d()->q($sql);
		echo $id;
	}
	public function navSwitch(){
		if($_POST['flag']==1){
			$sql = "update z_nav set `status` =1 where `id`=".$_POST['id'];
			echo $res = d()->q($sql);
		}else{
			$sql = "update z_nav set `status` =0 where `id`=".$_POST['id'];
			echo $res = d()->q($sql);
		}
		
	}
	public function recommend(){
		$sql = "update z_blog set `status` = 2 ,`toptime`=".time()." where `id`= ".intval($_POST['id']);
		//echo $sql;
		$res = d()->q($sql);
		//dump(d()->lastsql()) ;
		echo $res;
	}
	public function deleteBlog(){
		$sql = "update z_blog set `status` = 0 where `id`= ".intval($_POST['id']);
		$res = d()->q($sql);
		echo $res;
	}
	public function modifyBlog(){
		$action = $_GET['a'];
		$id = intval($_GET['id']);
		//查文章
		$sql = "select * from z_blog where id=$id";
		$blog = d()->q($sql);
		//dump($blog);
		$sql ="select b.id,b.name from z_blog_to_tags a , z_tags b where a.blog_id=$id and a.tag_id = b.id group by a.tag_id";
		$selectedTags=d()->q($sql);
		//dump($selectedTags);
		$selectedTags_str='';
		if(is_array($selectedTags)){
			foreach ($selectedTags as $k => $v) {
				$selectedTags_str.=$v['id'].',';
			}
		}
		include './view/post.php';
	}
	//日志的修改
	public function doModify(){
		//dump($_POST);
		//获取修改之前的标签与文章表的关系表的数据
		$original_tags = $_POST['original_tags'];
		$original_tags = trim($original_tags,',');
		$original_tags = explode(',', $original_tags);
		//新关系
		$tags1 = $_POST['selected_tags'];
		//dump($tags1);
		$tags1 = explode('addtags',$tags1);
		array_shift($tags1);
		//dump($tags1);
		$tags2=$_POST['tags'];
		if($tags2){
			$tags2=str_replace('，',',',$tags2);
			$tags2=explode(',',$tags2);
			//dump($tags2);
			foreach($tags2 as $k=>$v){
				//dump($v);
				$id = d()->q('select id from z_tags where name = "'.$v.'"' );
				$ddd = d()->lastsql();
				//dump($ddd);
				//dump($id);
				if($id[0]>0){
					$tags3[]=$id[0]['id'];
					//dump($tags3);
				}else{
					$id = d()->q('insert into z_tags (`name`,`status`) values ("'.$v.'",1) ');
					//echo '新插入的数据<br/>';
					dump($id);
					$tags3[]=$id;
				}
			}
			$tags1=array_merge($tags3,$tags1);
		}
		$result = array_diff($original_tags, $tags1);//删除的标签
		$result2 = array_diff($tags1,$original_tags);//新增的标签

		//dump($result);
		//dump($result2);
		foreach ($result as $k => $v) {
			d()->q("delete from z_blog_to_tags where blog_id={$_POST['id']} and tag_id={$v}");
		}
		foreach ($result2 as $k => $v) {
			d()->q("insert into z_blog_to_tags (`blog_id`,`tag_id`) values({$_POST['id']},{$v})");
		}
		//标签处理完毕
		//更新文章
        $title = htmlspecialchars($_POST['title'],ENT_QUOTES);
        $content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$sql ="update z_blog set `title`='{$title}',`nav`={$_POST['nav']},`content`='{$content}' where id=".$_POST['id'];


		//dump($sql);
        $model = d();
		$res =$model->q($sql);
		dump($res);dump($model->lastsql());exit;
		//修改日志记录

		$sql = "insert into z_modify(`blog_id`,`reason`,`mtime`)values(".$_POST['id'].",'".$_POST['modifyLog']."',".time().")";
		$modifyRes=d()->q($sql);	

        if($res){
        	$url = U('Blog/blog/',array('id'=>$_POST['id']));
            $this->jump('文章修改成功',$url);
        }else{
        	$url = U('Admin/modifyBlog/',array('id'=>$_POST['id']));
            $this->jump('文章修改失败',$url);
        }
	}
}