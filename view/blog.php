<?php
include 'header.php';
?>
<link rel="stylesheet" href="./editor/kindeditor-4.1.7/plugins/code/prettify.css" />
<script charset="utf-8" src="./editor/kindeditor-4.1.7/plugins/code/prettify.js"></script>
<script>
$(function(){ prettyPrint(); });
</script>
<div id="wrap">
	<div id="blog">
			<?php
			if($res){
				foreach($res as $k =>$v){
			?>
			<div class="list_item">			
				<div class="article_title">
					<h3>
						<a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span class="link_title"><?php echo htmlspecialchars_decode($v['title']);?></span></a>
					</h3>
				</div>
				<div class="article_manage">
					<div style="margin-left:6px">
						<!-- Baidu Button BEGIN -->
						<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
						<a class="bds_qzone"></a>
						<a class="bds_sqq"></a>
						<a class="bds_qq"></a>
						<a class="bds_tsina"></a>
						<a class="bds_tqq"></a>
						<a class="bds_renren"></a>
						<a class="bds_douban"></a>
						<a class="bds_tieba"></a>
						<a class="bds_mshare"></a>
						<span class="bds_more"></span>
						<a class="shareCount"></a>
						</div>
						<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=623514" ></script>
						<script type="text/javascript" id="bdshell_js"></script>
						<script type="text/javascript">
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
						</script>
						<!-- Baidu Button END -->
					</div>
					<span class="link_postdate"><?php echo date('Y-m-d H:i:s',$v['ctime'])?></span>
					<span class="link_view" title="阅读次数"><a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>" title="阅读次数">阅读</a>(<?php echo $v['count']?>)</span>
					
					<?php if($_SESSION['uid']){ ?>
                        <span class="link_edit"><a href="<?php echo U('Admin/modifyBlog',array('id'=>$_GET['id']))?>" title="编辑">编辑</a></span>
                        <span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>">顶置</a></span>
                        <span class="link_delete"><a href="javascript:void(0);" deleteId="<?php echo $v['id']?>" title="deletdBlog">删除</a></span>
					<?php } ?>
				</div>
			</div>
			<div class="content">
				<?php if (is_array($tags)){ ?>
					<div class="tags" style="margin-bottom: 5px;">
					标签 : 
					<?php
						foreach ($tags as $key => $value) {
							echo '<a href="'.U('Blog/index',array('tag'=>$value['id'])).'" style="display: inline;" >'.$value['name'].'</a>';
						}
					?>
					</div>
				<?php
                }
                if(is_array($modify)){
                ?>
                    <!--下面是修改记录(如果有的话)-->
                    <div id="modify">
                        <?php foreach($modify as $kk =>$vv){ ?>
                            <div class="modify">
                                <div class="modify_time">更新时间：<i><?php echo date('Y-m-d H:i:s',$vv['mtime']); ?></i></div>
                                <div class="modify_reason">修改原因：<?php echo $vv['reason']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
			<?php echo htmlspecialchars_decode($v['content']);?>
			</div>
			<?php
				}
			}
			?>


            <div id="comment">
                <div id="commentList">
                    <?php
                    if(is_array($comment)){
                        foreach($comment as $k=>$v){

                        echo '<div class="commentlist"><div><a href="'.$v['link'].'">'.$v['username'].'</a>'.date("Y-m-d H:i:s",time()).'</div>'.$v['content'].'</div>';

                        }
                    }
                    ?>
                </div>
                <div>
                    <input type="hidden" name="blogid" value="<?php echo $res[0]['id']; ?>"/>
                    <textarea name="comment" cols="50" rows="5" placeholder="说点什么吧，可以使用`xxxx`来插入简短的代码碎片（模仿的markdown你懂的）" class="comment_textarea"></textarea>
                </div>
                <div style=" margin:5px 0; ">
                    <input type="email" name="email" placeholder="留个邮箱吧" class="comment_input" />
                    <input type="text" name="yourname" placeholder="你的大名" class="comment_input" />
                    <input type="text" name="blog" placeholder="你的博客地址" class="comment_input" />
                    <a href="javascript:void(0)" id="post_comment" issending="false">提交</a>
                </div>
            </div>
            <script type="text/javascript">
                $("textarea[name='comment']").focus(function(){
                    //先自动填下留言表单，为留言做准备
                    var email = getcookie('email');
                    if(email){
                        $("input[name='email']").val(email);
                    }
                    var yourname = getcookie('yourname');
                    if(yourname){
                        $("input[name='yourname']").val(yourname);
                    }
                    var blog = getcookie('blog');
                    if(blog){
                        $("input[name='blog']").val(blog);
                    }
                })



                $("#post_comment").click(function(){
                    post_comment();
                })
                $(this).bind('keydown',function(e){
                    var key = e.which;
                    if(key == 13) {
                        post_comment();
                    }
                })
            </script>
	</div>

</div>
<?php
include 'footer.php';
?>