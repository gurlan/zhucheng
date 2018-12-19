<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<body>
<div class="news_nr fix">
    <div class="news_bt fix"><h3><?php echo $title;?></h3></div>
    <div class="news_date fix"><span><?php echo $inputtime;?></span><em><?php echo $author;?></em></div>
    <div class="news_xq fix">
       <?php echo $content;?>
    </div>
</div>
<?php include template("content","footer"); ?>
