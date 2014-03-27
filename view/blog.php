<?php
include 'header.php';
?>
<link rel="stylesheet" href="./editor/plugins/code/prettify.css" />
<script charset="utf-8" src="./editor/plugins/code/prettify.js"></script>
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
						<a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span class="link_title"><?php echo htmlspecialchars_decode($v['title'],ENT_QUOTES);?></span></a>
					</h3>
				</div>
				<div class="article_manage">
					<div style="margin-left:1px">
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
                        <span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>" status="<?php echo $v['status'];?>"><?php if($v['status']==2){echo '取消推荐';}else{echo '推荐';}?></a></span>
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
							echo '<a href="'.U('Blog/readByTags',array('tag'=>$value['id'])).'" style="display: inline;" >'.$value['name'].'</a>';
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
			<?php echo htmlspecialchars_decode($v['content'],ENT_QUOTES);?>
			</div>
			<?php
				}
			}
			?>



	</div>
    <div id="comment">
        <div id="commentList">
            <?php
            if(is_array($comment)){
                foreach($comment as $k=>$v){
                    echo '<div class="commentlist"><div><span name="floor">'.(($_GET['p']*20)+$k+1).'</span> 楼 <a href="'.$v['link'].'" tagert="_blank">'.$v['username'].'</a>'.date("Y-m-d H:i:s",time()).'<div style="float:right">';
                    echo '<a href="javascript:void(0)" targetId="'.$v['id'].'" class="reply_the_comment">回复</a>';
                    if($_SESSION['uid']){
                        echo '<a href="javascript:void(0)" targetId="'.$v['id'].'" class="delreply">删除</a>';
                    }
                    echo '</div></div>'.$v['content'].'</div>';
                }

            }
            ?>
        </div>
        <?php if(is_array($comment)){echo pagelist($page,$totalNum[0]['num'],20);}?>
        <form name="comment">
            <div style=" margin-top: 10px; ">
                <input type="hidden" name="blogid" value="<?php echo $res[0]['id']; ?>"/>
                <input type="hidden" name="replyId" value="0"/>
                <textarea name="comment" cols="50" rows="5" placeholder="说点什么吧，可以使用`xxxx`来插入简短的代码碎片" class="comment_textarea"></textarea>
            </div>
            <div style=" margin:5px 0; ">
                <input type="email" name="email" placeholder="留个邮箱吧" class="comment_input" />
                <input type="text" name="yourname" placeholder="你的大名" class="comment_input" />
                <input type="text" name="blog" placeholder="你的博客地址" class="comment_input" />
                <a href="javascript:void(0)" id="post_comment" issending="false">提交</a>
            </div>
        </form>
    </div>
    <a name="comment_text"></a>
    <script type="text/javascript">
        $(".delreply").click(function(){
            var _e = $(this);
            var id = $(this).attr('targetId');
            ui.confirm('确认删除该留言？',function(){
                var url = U('Comment/del');
                $.post(url,{id:id},function(data){
                    if(parseInt(data.flag)==1){
                        _e.parents('.commentlist').remove();
                        ui.success('删除成功');
                    }else{
                        ui.error('删除失败');
                    }
                },'json')
            },function(){
                return false;
            })
        })
        $(".reply_the_comment").click(function(){
            $("input[name='replyId']").val($(this).attr('targetId'));
            var pre_content = '回复'+$(this).parent().parent().find('span[name="floor"]').text()+'楼: ';
            var callback = function(pre_content){
                $("textarea[name='comment']").css('background','#FFB3B6').focus().val(pre_content);
                setTimeout(function(){
                    $("textarea[name='comment']").css('background','#FFF');
                    setTimeout(function(){
                        $("textarea[name='comment']").css('background','#FFB3B6');
                        setTimeout(function(){
                            $("textarea[name='comment']").css('background','#FFF');
                        },300)
                    },300)
                },300);
            }
            //到底部了，就不要再往下滚了，否则再往上滚的时候会出现滚轮失效的假象
            var scrollHeight = $('a[name="comment_text"]').offset().top;
            if($(document).scrollTop() + $(window).height() + 100 <= $(document).height()){
                $("html,body").animate({scrollTop:scrollHeight},1000,function(){
                    //使得回复框颜色闪一闪
                    callback(pre_content);
                });
            }else{
                callback(pre_content);
            }
        })
        $("textarea[name='comment']").focus(function(){
            //先自动填下留言表单，为留言做准备
            if(!$("input[name='email']").val()){
                var email = getcookie('email');
                if(email){
                    $("input[name='email']").val(email);
                }
            }
            if(!$("input[name='yourname']").val()){
                var yourname = getcookie('yourname');
                if(yourname){
                    $("input[name='yourname']").val(yourname);
                }
            }
            if(!$("input[name='blog']").val()){
                var blog = getcookie('blog');
                if(blog){
                    $("input[name='blog']").val(blog);
                }
            }
        })
        $("#post_comment").click(function(){
            post_comment();
        })
        $('input[name="blog"]').bind('keydown',function(e){
            var key = e.which;
            if(key == 13) {
                post_comment();
            }
        })
    </script>
</div>
<?php
include 'footer.php';
?>