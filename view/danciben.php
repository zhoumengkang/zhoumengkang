<?php
include 'header.php';
?>
<div id="wrap">
    <div class="main">
                <?php
                echo pagelist($page,$totalNum[0]['num'],100);
            ?>
    </div>
</div>
<?php
include 'footer.php';
?>