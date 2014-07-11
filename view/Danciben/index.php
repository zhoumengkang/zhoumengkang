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
                .lidiv{
                    display: none;
                }

                .modify{
                    display: inline-block;
                    font-size: 16px;
                    font-weight: 500;
                    float: right;
                    padding-right: 10px;
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
                .from{
                    color: rgb(40, 186, 255)!important;
                    clear: both !important;
                    text-decoration: underline!important;
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

                            <div class="lidiv">
                                <?php if($_SESSION['uid']){
                                    echo '<a class="modify" href="'.U('Danci/info',array('id'=>$v['id'])).'">修改</a>';
                                }?>
                                <p><span class="translate"><?php echo $v['translate'];?></span></p>
                                <blockquote>
                                    <p class="sentence"><?php echo $v['sentence'];?></p>
                                    <?php if($v['from']){ ?>
                                        <p>来自：<a class="from" href="<?php echo $v['from'];?>" ><?php echo $v['from'];?></a></p>
                                    <?php }?>
                                </blockquote>
                            </div>

                        </li>
                    <?php }} ?>
            </ul>
            <script type="text/javascript">
                $("li").hover(function(){
                    var tmpele = $(this).find("div");
                    var word = $(this).find('h3').text();
                    var sentence = tmpele.find("blockquote .sentence").html();
                    if(!tmpele.attr("data-check")){
                        tmpele.find("blockquote .sentence").html(sentence.replace(word,'<span>'+word+'</span>'));
                        tmpele.attr("data-check",1);
                    }
                    tmpele.fadeIn();
                }/*,function(){
                 var tmpli = $(this);
                 setTimeout(function(){
                 tmpli.find("div").fadeOut();
                 },1000);
                 }*/)
            </script>
            <?php echo pagelist($page,$totalNum[0]['num'],$num);?>
        </div>
    </div>
<?php
include 'footer.php';
?>