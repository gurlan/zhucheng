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