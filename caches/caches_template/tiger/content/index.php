<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<body>
<!--banner-->
<div class="banner fix" id="banner">
    <div class="hd">
        <ul>
            <?php $banner = getads(11)?>
            <?php $n=1;if(is_array($banner[d])) foreach($banner[d] AS $r) { ?>
            <li></li>
            <?php $n++;}unset($n); ?>
        </ul>
    </div>
    <div class="bd">
        <ul>
            <?php $n=1;if(is_array($banner[d])) foreach($banner[d] AS $r) { ?>
            <li><a href="<?php echo $r['linkurl'];?>"><img src="<?php echo $r['imageurl'];?>" /></a></li>
            <?php $n++;}unset($n); ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
    TouchSlide({
        slideCell: "#banner",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "left",
        autoPlay: true,//自动播放
        autoPage: true, //自动分页
        switchLoad: "_src" //切换加载，真实图片路径为"_src"
    });
</script>
<div class="index_nav fix">
    <ul>
        <li><a href="<?php echo $CATEGORYS['9']['url'];?>"><i><img src="<?php echo $CATEGORYS['9']['image'];?>"/></i><span><?php echo $CATEGORYS['9']['catname'];?></span></a></li>
        <li><a href="<?php echo $CATEGORYS['10']['url'];?>"><i><img src="<?php echo $CATEGORYS['10']['image'];?>"/></i><span><?php echo $CATEGORYS['10']['catname'];?></span></a></li>
        <li><a href="<?php echo $CATEGORYS['20']['url'];?>"><i><img src="<?php echo $CATEGORYS['20']['image'];?>"/></i><span><?php echo $CATEGORYS['20']['catname'];?></span></a></li>
    </ul>
</div>
<div class="index_bt1 fix">
    <i></i>
    <h3>公司简介</h3>
</div>
<div class="index_about fix">

    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=2f58b9ef8319b6745d7904b88b08725e&sql=SELECT+%2A+FROM+v9_page+where+catid%3D11\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}pc_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT * FROM v9_page where catid=11 LIMIT 20");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);?>
    <?php $n=1;if(is_array($data)) foreach($data AS $val) { ?>
    <?php echo $val['content'];?>
    <?php $n++;}unset($n); ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</div>
<div class="index_bt2 fix">
    <img src="<?php echo $CATEGORYS['12']['image'];?>"/>
    <h3><?php echo $CATEGORYS['12']['catname'];?></h3>
    <a href="<?php echo $CATEGORYS['12']['url'];?>">更多</a>
</div>
<div class="index_brand fix">
    <ul>
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d02ca9e5d6e3373d7542ec32e143c6e0&action=lists&catid=12&num=9&order=listorder+DESC%2Cinputtime+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'12','order'=>'listorder DESC,inputtime desc','limit'=>'9',));}?>
        <?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
        <li>
            <a href="<?php echo $v['url'];?>"><i><img src="<?php echo $v['thumb'];?>"/></i><span><?php echo $v['title'];?></span></a>
        </li>
        <?php $n++;}unset($n); ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<div class="index_bt2 fix">
    <img src="<?php echo $CATEGORYS['13']['image'];?>"/>
    <h3><?php echo $CATEGORYS['13']['catname'];?></h3>
    <a href="<?php echo $CATEGORYS['13']['url'];?>">更多</a>
</div>
<div class="index_brand fix">
    <ul>
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=21e6f6334c4a13b0633b446fb5d2719b&action=lists&catid=13&num=9&order=listorder+DESC%2Cinputtime+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'13','order'=>'listorder DESC,inputtime desc','limit'=>'9',));}?>

        <?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
        <li>
            <a href="<?php echo $v['url'];?>"><i><img src="<?php echo $v['thumb'];?>"/></i><span><?php echo $v['title'];?></span></a>
        </li>
        <?php $n++;}unset($n); ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<div class="index_bt1 fix">
    <i></i>
    <h3>服务项目</h3>
    <a href="#">更多</a>
</div>
<div class="index_project fix">
    <ul>
        <li><a href="<?php echo $CATEGORYS['15']['url'];?>"><img src="<?php echo $CATEGORYS['15']['image'];?>"/></a></li>
        <li><a href="<?php echo $CATEGORYS['16']['url'];?>"><img src="<?php echo $CATEGORYS['16']['image'];?>"/></a></li>
    </ul>
    <ul>
        <li><a href="<?php echo $CATEGORYS['17']['url'];?>"><img src="<?php echo $CATEGORYS['17']['image'];?>"/></a></li>
    </ul>
</div>
<div class="index_bt1 fix">
    <i></i>
    <h3>寄售流程</h3>
</div>
<div class="index_process fix">
    <img src="/template/images/process_tp.png"/>
</div>
<div class="index_bt1 fix">
    <i></i>
    <h3><?php echo $CATEGORYS['18']['catname'];?></h3>
    <a href="<?php echo $CATEGORYS['18']['url'];?>">更多</a>
</div>
<div class="index_Appraisal fix">
    <ul>
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b2955c94d07f43682ce06ab84bcf801b&action=lists&catid=18&num=3&order=listorder+DESC%2Cinputtime+desc\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'18','order'=>'listorder DESC,inputtime desc','limit'=>'3',));}?>
        <?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
        <li>
            <a href="<?php echo $v['url'];?>" class="tbox">
                <div><i><img src="<?php echo $v['thumb'];?>"/></i></div>
                <div class="index_Appraisalcn">
                    <h3><?php echo $v['title'];?></h3>
                    <span><?php echo date("Y-m-d",$v[inputtime]);?></span>
                </div>
            </a>
        </li>

        <?php $n++;}unset($n); ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<div class="wall fix"></div>

<?php include template("content","footer"); ?>