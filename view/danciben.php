<?php
include 'header.php';
?>
<div id="wrap">
    <div class="main">
        <style type="text/css">
            h3{
                font-size: 50px;
                line-height: 60px;
                color: #6D6D6D;
                margin: 0;
            }
            blockquote{
                font-style: italic;
                color: #797979;
                font-weight: 800;
                border: 1px #AFFDC1 solid;
                background-color: #D0FDDB;
                padding: 6px;
                margin: 0;
            }
            blockquote p{
                margin: 0;
            }
            span.translate{
                font-size: 16px;
                padding: 5px 9px;
                background: #DDD;
                color: #6D6D6D;
                font-weight: 800;
            }
            blockquote span{
                font-size: 16px;
                padding: 1px 7px 3px;
                margin: 0 2px;
                background: #DDD;
                color: #6D6D6D;
                font-weight: 800;
            }
        </style>
        <ul>
            <?php if(is_array($danciben)){
                foreach($danciben as $v){ ?>
                    <li data-id="<?php echo $v['id']?>" data-check="0">
                        <h3><?php echo $v['word'];?></h3>
                        <div style="display: none">
                            <p><span class="translate"><?php echo $v['translate'];?></span></p>
                            <blockquote>
                                <p><?php echo $v['sentence'];?></p>
                            </blockquote>
                        </div>

                    </li>
            <?php }} ?>
        </ul>
        <script type="text/javascript">
            $("li").hover(function(){
                var tmpele = $(this).find("div");
                var word = $(this).find('h3').text();
                var sentence = tmpele.find("blockquote p").html();
                if(!tmpele.attr("data-check")){
                    tmpele.find("blockquote p").html(sentence.replace(word,'<span>'+word+'</span>'));
                    tmpele.attr("data-check",1);
                }
                tmpele.fadeIn();
            },function(){
                var tmpli = $(this);
                setTimeout(function(){
                    tmpli.find("div").fadeOut();
                },1000);
            })
        </script>
        <?php echo pagelist($page,$totalNum[0]['num'],$num);?>
    </div>
</div>
<?php
include 'footer.php';
?>