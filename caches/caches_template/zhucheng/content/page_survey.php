<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","head"); ?>
<body>
<?php include template("content","logo"); ?>
<div class="content w1200 fix">
    <!--content_left-->
    <div class="content_left">
        <!--position-->
        <?php include template("content","position"); ?>
        <!--about-->
        <div class="Survey distance fix">
            <h3><?php echo $title;?></h3>
            <?php echo $content;?>
        </div>
    </div>
    <!--content_right-->
    <?php include template("content","right"); ?>
</div>
<?php include template("content","foot"); ?>