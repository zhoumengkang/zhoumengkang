<?php
include 'header.php';
?>
<div id="wrap">
    <div class="site-list">
        <span class="site-title">程序</span>
        <ul>
            <?php if(is_array($sites)){
                $n = 1;
                foreach($sites as $k =>$v){
                   if($v['type'] ==1){
                       echo "<li>{$n}. <a href=\"{$v['url']}\" title=\"{$v['des']}\">{$v['name']}</a> - {$v['des']}</li>";
                       $n++;
                   }
                }
            }?>
        </ul>
    </div>
    <div class="site-list">
        <span class="site-title">设计</span>
        <ul>
            <?php if(is_array($sites)){
                $n = 1;
                foreach($sites as $k =>$v){
                    if($v['type'] ==2){
                        echo "<li>{$n}. <a href=\"{$v['url']}\" title=\"{$v['des']}\">{$v['name']}</a> - {$v['des']}</li>";
                        $n++;
                    }
                }
            }?>
        </ul>
    </div>
    <div class="site-list">
        <span class="site-title">生活</span>
        <ul>
            <?php if(is_array($sites)){
                $n = 1;
                foreach($sites as $k =>$v){
                    if($v['type'] ==3){
                        echo "<li>{$n}. <a href=\"{$v['url']}\" title=\"{$v['des']}\">{$v['name']}</a> - {$v['des']}</li>";
                        $n++;
                    }
                }
            }?>
        </ul>
    </div>
</div>
<?php
include 'footer.php';
?>