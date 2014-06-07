<?php
/*include 'header.php';*/
?>
<div>
    <form action="<?php echo U('Site/add');?>" name="addsite" method="post" >
        <input type="text" name="webname"/>
        <input type="text" name="weburl"/>
        <input type="submit" value="添加"/>
    </form>
</div>
<?php
/*include 'footer.php';*/
?>