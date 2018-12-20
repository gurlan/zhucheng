<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="<?php echo $SEO['keyword'];?>"/>
    <meta name="description" content="<?php echo $SEO['description'];?>">
    <meta name="renderer" content="webkit">
    <meta name="force-rendering" content="webkit">
    <link href="/template/css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/template/js/jquery1.42.min.js"></script>
    <script type="text/javascript" src="/template/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=5210f8e36f0bc59c647f1720333d95cf&action=lists&catid=38&num=1&moreinfo=1+order%3D&return=sys\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$sys = $content_tag->lists(array('catid'=>'38','moreinfo'=>'1 order=','limit'=>'1',));}?>
<?php $sys = $sys[1]?>