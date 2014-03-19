<?php
include 'header.php';
?>
<div id="wrap">
    <div class="main">
        <span class="side_title">标签云</span>
        <style type="text/css">
            .tagslist{
                padding: 10px;
                float: left;
            }
            .tagslist span{
                padding-left: 8px;
                color: #bbb;
            }
        </style>
        <div>
            <?php
                if(is_array($tags)){
                    foreach($tags as $k=>$v){
                        echo '<div class="tagslist"><a href="'.U('Blog/index',array('tag'=>$v['id'])).'">'.$v['name'].'</a><span>('.$v['linktimes'].')次</span></div>';
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
