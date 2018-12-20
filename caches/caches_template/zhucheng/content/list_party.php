<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","head"); ?>
<body>
<?php include template("content","logo"); ?>
<div class="content w1200 fix">
    <!--content_left-->
    <div class="content_left">
        <!--position-->
        <?php include template("content","position"); ?>
        <!--news-->
        <div class="party distance fix">
            <h3><?php echo $CATEGORYS[$catid]['catname'];?></h3>
            <ul>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=1be74f6aa59988ca2d5c47186775fead&action=lists&catid=%24catid&num=8&order=listorder+DESC%2Cinputtime+desc&page=%24page\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 8;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'listorder DESC,inputtime desc','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'listorder DESC,inputtime desc','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
                <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                <li><a href="<?php echo $r['url'];?>"><i><img src="/template/images/party_tb1.jpg"/></i><span><?php echo $r['title'];?></span>
                    <p>【<?php echo date("Y-m-d",$r[inputtime]);?>】</p></a>
                </li>
                <?php $n++;}unset($n); ?>
            </ul>
        </div>
        <!--page-->
        <div class="page fix">
            <?php echo $pages;?>
        </div>
    </div>
    <!--content_right-->
    <?php include template("content","right"); ?>
</div>

<?php include template("content","foot"); ?>