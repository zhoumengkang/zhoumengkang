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
    <form action="<?php echo U('Site/add');?>" name="addsite" method="post" >
        <table>
            <tr>
                <td>网站类型：</td>
                <td>
                    <select name="type" id="type">
                        <option value="1">程序</option>
                        <option value="2">设计</option>
                        <option value="3">生活</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>网站名称：</td>
                <td><input type="text" name="name"/></td>
            </tr>
            <tr>
                <td>网站地址：</td>
                <td><input type="text" name="url" style="width: 300px" /></td>
            </tr>
            <tr>
                <td>网站描述：</td>
                <td><input type="text" name="des" style="width: 300px" /></td>
            </tr>
        </table>
        <input type="submit" value="添加"/>
    </form>
    </div>
</div>
<?php
include 'footer.php';
?>