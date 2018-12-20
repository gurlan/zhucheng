<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","head"); ?>
<body>
<?php include template("content","logo"); ?>
<div class="content w1200 fix">
    <!--content_left-->
    <div class="content_left">
        <!--position-->
        <?php include template("content","position"); ?>
        <!--news-->
        <div class="news_nr distance fix">
            <div class="news_tm fix"><h3><?php echo $title;?></h3></div>
            <div class="news_date fix"><span>来源：<?php echo $copyfrom;?></span><span>作者：<?php echo $author;?></span><span>时间：<?php echo $inputtime;?></span><span  id="hits" style="margin-left: 5px"></span></div>
            <div class="news_xq fix">
               <?php echo $content;?>
            </div>
            <div class="Article fix">
                <a href="<?php echo $previous_page['url'];?>"><span>上一篇：</span><?php echo $previous_page['title'];?></a>
                <a href="<?php echo $next_page['url'];?>"><span>下一篇：</span><?php echo $next_page['title'];?></a>
            </div>

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
<script language="JavaScript" src="<?php echo APP_PATH;?>api.php?op=count&id=<?php echo $id;?>&modelid=<?php echo $modelid;?>"></script>
<script>
    $('#hits').append('次浏览')
</script>