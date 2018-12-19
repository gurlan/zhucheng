<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
    <link href="/template/css/style.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="keywords" content="<?php echo $SEO['keyword'];?>"/>
    <meta name="description" content="<?php echo $SEO['description'];?>">
    <script type="text/javascript" src="/template/js/jquery1.42.min.js"></script>
    <script type="text/javascript" src="/template/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="/template/js/TouchSlide.1.0.js"></script>
</head>