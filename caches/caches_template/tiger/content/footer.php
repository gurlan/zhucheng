<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><div class="footer fix">
    <ul>
        <li <?php if($catid!=19 and  $catid!=10 ) { ?> class="on"<?php } ?>>
            <a href="/">
                <i class="footer_tb1"></i>
                <span>首页</span>
            </a>
        </li>
        <li<?php if($catid==19) { ?> class="on"<?php } ?>>
            <a href="<?php echo $CATEGORYS['19']['url'];?>" >
                <i class="footer_tb2"></i>
                <span><?php echo $CATEGORYS['19']['catname'];?></span>
            </a>
        </li>
        <li <?php if($catid==10) { ?> class="on"<?php } ?>>
            <a href="<?php echo $CATEGORYS['10']['url'];?>">
                <i class="footer_tb3"></i>
                <span><?php echo $CATEGORYS['10']['catname'];?></span>
            </a>
        </li>
    </ul>
</div>
</body>
</html>