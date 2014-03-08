<?php
include 'header.php';
?>
<div class="center jump">
    <p class=""><?php echo $info ;?></p>
</div>
    <script type="text/javascript">
        <?php if($jumpUrl){ ?>
            setTimeout(function(){
                location.href = '<?php echo $jumpUrl; ?>';
            },1000);
        <?php
        }else{
        ?>
            setTimeout(function(){
                history.go(-1);
            },1000);
        <?php
        }?>

    </script>
<?php
include 'footer.php';
?>