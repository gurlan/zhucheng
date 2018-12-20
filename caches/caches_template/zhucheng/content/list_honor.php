<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","head"); ?>
<body>
<?php include template("content","logo"); ?>
<div class="content w1200 fix">
    <!--content_left-->
    <div class="content_left">
        <!--position-->
        <?php include template("content","position"); ?>
        <!--honner-->
        <div class="honner distance fix">
            <h3><?php echo $CATEGORYS[$catid]['catname'];?></h3>
            <ul>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b6ecda21fed20f1c6794ba9d4e5ac79c&action=lists&catid=%24catid&num=9&order=listorder+DESC%2Cinputtime+desc&page=%24page\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 9;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'listorder DESC,inputtime desc','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'listorder DESC,inputtime desc','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
                <?php $i=1?>
                <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                <li  <?php if($i%3==1) { ?>class="honner_list"<?php } ?>><i><img src="<?php echo $r['thumb'];?>"/></i><span><?php echo $r['title'];?></span>
                    <div class="honner_sm"><img src="/template/images/honner_tb2.png"/></div>
                </li>
                <?php $i++?>
                <?php $n++;}unset($n); ?>

            </ul>
        </div>
        <!--page-->
        <div class="page fix">
            <?php echo $pages;?>
        </div>
    </div>
    <div class="honner_tk fix">
        <div class="honner_tkcn fix">
            <div class="honner_tkgb fix"><img src="/template/images/honner_tb1.png"/></div>
            <div class="honner_tknr fix"><img src=""/></div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".honner li").click(function () {
                var img = $(this).children("i").find("img").attr("src");
                var img1 = $(".honner_tknr").find("img").attr("src");
                $(".honner_tk").show();
                $(".honner_tknr img").attr("src", img);
            });
            $(".honner_tkgb").click(function () {
                $(".honner_tk").hide();
            });
        });
    </script>
    <!--content_right-->
    <?php include template("content","right"); ?>
</div>

<?php include template("content","foot"); ?>
