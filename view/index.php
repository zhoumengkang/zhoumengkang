<?php
include 'header.php';
?>
<div id="wrap">
    <div id="side">
        <?php if(!$this->ismobile){
            include 'side.php';
        }
        ?>
    </div>
    <div id="main">

        <div class="main" style="margin-bottom: 10px">
            <span class="side_title">顶置</span>
            <?php
            if(is_array($top)){
                foreach($top as $k =>$v){
                    ?>
                    <div class="list_item list_view" blogId="<?php echo $v['id'] ?>">
                        <div class="article_title left">
                            <h3>
                                <a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span><?php echo msubstr(htmlspecialchars_decode($v['title'],ENT_QUOTES),0,50);?></span></a><span class="viewtimes" title="阅读次数">(<?php echo $v['count']?>)</span>
                            </h3>
                        </div>
                        <div class="article_manage">
                            <span class="link_postdate"><?php echo date('Y-m-d H:i:s',$v['ctime'])?></span>

                            <?php if($_SESSION['uid']){ ?>
                                <span class="link_edit"><a href="<?php echo U('Admin/modifyBlog',array('id'=>$v['id']));?>" title="编辑">编辑</a></span>
                                <span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>" status="<?php echo $v['status'];?>">取消推荐</a></span>
                                <span class="link_delete"><a href="javascript:void(0);" deleteId="<?php echo $v['id']?>" title="deletdBlog">删除</a></span>
                            <?php }?>

                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <div class="main">
            <span class="side_title">最新</span>
            <?php
            if(is_array($res)){
                foreach($res as $k =>$v){
                    ?>
                    <div class="list_item list_view" blogId="<?php echo $v['id'] ?>">
                        <div class="article_title left">
                            <h3>
                                <a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span><?php echo msubstr(htmlspecialchars_decode($v['title'],ENT_QUOTES),0,50);?></span></a><span class="viewtimes" title="阅读次数">(<?php echo $v['count']?>)</span>
                            </h3>
                        </div>
                        <div class="article_manage">
                            <span class="link_postdate"><?php echo date('Y-m-d H:i:s',$v['ctime'])?></span>

                            <?php if($_SESSION['uid']){ ?>
                                <span class="link_edit"><a href="<?php echo U('Admin/modifyBlog',array('id'=>$v['id']));?>" title="编辑">编辑</a></span>
                                <span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>" status="<?php echo $v['status'];?>">推荐</a></span>
                                <span class="link_delete"><a href="javascript:void(0);" deleteId="<?php echo $v['id']?>" title="deletdBlog">删除</a></span>
                            <?php }?>

                        </div>
                    </div>
                <?php
                }
                echo pagelist($page,$totalNum[0]['num'],PERPAGES);
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php
include 'footer.php';
?>
