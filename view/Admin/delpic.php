<?php
include 'header.php';
?>
    <style type="text/css">
        input{
            height: 24px;
        }
    </style>
    <div id="wrap">
        <div class="site-list">
            <form action="<?php echo U('Admin/delpic');?>" name="addsite" method="post" >
                <table>
                    <tr>
                        <td>图片地址：</td>
                        <td>
                            <input type="text" name="url" size="130"/>
                        </td>
                    </tr>
                    <tr>
                        <td>验证码：</td>
                        <td>
                            <input type="text" name="password" placeholder="自定义密码"/>
                        </td>
                    </tr>
                </table>
                <input type="submit" value="删除"/>
            </form>
        </div>
    </div>
<?php
include 'footer.php';
?>