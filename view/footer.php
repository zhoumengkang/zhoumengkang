</div>
<div class="clear"></div>
<footer id="footer">
	<div class="login" id="login">
        <div class="popbackground"></div>
        <div class="popbox loginBox" id="loginBox">
            <div class="innerpopbox">
                <div class="title">
                    <div style="font-weight: 800;color: #2e9fff;text-align: center;">登堂入室 请输入密码</div>
                </div>
                <div class="content password">
                    <input type="password" name="password"/>
                    <div><a href="javascript:void(0)" class="loginActive">进入</a><a href="javascript:void(0)" class="closeLoginBox">返回</a></div>
                </div>
            </div>
        </div>
	</div>
	<span></span>
    <div class="clear"></div>
    <div class="copyright">
        <small>
            <a href="<?php echo U('Blog/about')?>">关于博主</a>
            <?php
            if(!$_SESSION['uid']){
                echo '<a href="javascript:void(0)" name="login">登堂入室</a>';
            }
            ?>
            本程序由
            <a href="<?php echo U('Blog/readbytags',array('tag'=>6));?>" title="关于开发本博客的文章">ZzBlog</a>
            勉强驱动 © 周梦康 2013 - 2014 辽ICP备12007622号-1
            <span style="display:<?php if($_SESSION['uid']){echo 'inline-block';}else{echo 'none';}?>">
                <script type="text/javascript">
                    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fd2adf0c061d575a2921e4a7c41fe9cd6' type='text/javascript'%3E%3C/script%3E"));
                </script>
            </span>
        </small>
    </div>
	<div class="messageBox"></div>

</footer>
</body>
</html>