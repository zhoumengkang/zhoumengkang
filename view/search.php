<?php
include 'header.php';
?>
    <div id="wrap">
        <div class="main" style="margin-bottom: 15px;">
            <span class="side_title" style=" float: left; margin-right: 20px; ">搜索</span>
            <form name="search" action="<?php echo U('Blog/search');?>" method="post" data-test="1">
                <input type="text" name="keyword" value="" placeholder="输入关键词" style="height: 20px;padding: 3px 5px;font-size: 14px;" />
            </form>
        </div>
        <div class="main">
            <span class="side_title">结果</span>
            <?php
            if(is_array($res)){
                foreach($res as $k =>$v){
                    ?>
                    <div class="list_item list_view" blogId="<?php echo $v['id'] ?>">
                        <div class="article_title left">
                            <h3>
                                <a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span><?php echo msubstr(htmlspecialchars_decode($v['title'],ENT_QUOTES),0,50);?></span></a>
                            </h3>
                        </div>
                    </div>
                <?php
                }
                echo pagelist($page,$totalNum[0]['num'],PERPAGES);
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
<?php
include 'footer.php';
?>