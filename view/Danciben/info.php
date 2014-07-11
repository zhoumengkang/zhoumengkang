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
                h3 a{
                    float: right;
                    display: inline-block;
                    padding-left: 20px;
                    font-size: 16px;
                    font-weight: 500;
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
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $info[0]['id']; ?>"/>
                <table>
                    <tr>
                        <td>单词</td>
                        <td><input type="text" name="word" value="<?php echo $info[0]['word']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>翻译</td>
                        <td><input type="text" name="translate"  value="<?php echo $info[0]['translate']; ?>"/></td>
                    </tr>
                    <tr>
                        <td>例句</td>
                        <td><textarea name="sentence"  cols="60" rows="10"><?php echo $info[0]['sentence']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>来源</td>
                        <td><input type="text" name="from" style="width: 442px;" value="<?php echo $info[0]['from']; ?>"/></td>
                    </tr>
                </table>
                <input type="submit"/>
            </form>
            <div style="padding-top:10px">
                <?php
                if($flag){
                    if($flag>0){
                        echo '<font color="green">成功</font>';
                    }else{
                        echo '<font color="red">失败</font>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php
include 'footer.php';
?>