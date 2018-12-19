<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>phpcms 登录</title>
<link href="<?php echo CSS_PATH?>denglu.css" rel="stylesheet" type="text/css"/>
<script language="Javascript" src="<?php echo JS_PATH?>DD_belatedPNG_0.0.8a.js"></script>
<script language="JavaScript">
<!--
	if(top!=self)
	if(self!=top) top.location=self.location;
//-->
</script>
<script type="text/javascript">
	DD_belatedPNG.fix('div, ul, img, li, input , a');
</script>
</head>

<body onload="javascript:document.myform.username.focus();">
	<div class="header">
    	<div class="logo">
        	<img src="<?php echo IMG_PATH?>img/body_03.jpg" />
        </div>
        <div class="phone">
        	<img src="<?php echo IMG_PATH?>img/diqiu.gif" />
        	<img src="<?php echo IMG_PATH?>img/body_05.jpg" />
        </div>
        <div class="clear"></div>
    </div>

    <div class="content" id="login_bg">
    	<div class="content_1">
        	<div class="content_kk">
            	<h3>网站管理后台系统</h3>
                <ul>
				<form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform">
                	<li><input type="text" value="<?php echo L('username')?>" name="username" onfocus="if(this.value=='<?php echo L('username')?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php echo L('username')?>'};" size="30"/></li>
			
                    <li><input type="password" value="<?php echo L('password')?>"  name="password" onfocus="if(this.value=='<?php echo L('password')?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php echo L('password')?>'};" size="30"/></li>
                    <li id="yzm" class="yzm">
					&nbsp;
					<input type="text" size="7" value="<?php echo L('security_code')?>" style="margin-left:-12px;" name="code" onfocus="if(this.value=='<?php echo L('security_code')?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php echo L('security_code')?>'};"/>
					<?php echo form::checkcode('code_img')?><a href="javascript:document.getElementById('code_img').src='<?php echo SITE_PROTOCOL.SITE_URL.WEB_PATH;?>api.php?op=checkcode&m=admin&c=index&a=checkcode&time='+Math.random();void(0);"><?php echo L('click_change_validate')?></a></li>
					
                    <li><input type="submit" value="" style="background:url(<?php echo IMG_PATH?>img/button.png) no-repeat; border:none; width:112px; height:48px;" name="dosubmit"/></li>
</form>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer">
    	<div class="l"></div>
        <div class="r">

        </div>
    </div>


</body>
</html>