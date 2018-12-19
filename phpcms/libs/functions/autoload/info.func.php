<?php
/*
 **  数据导出生成excel文件
 ** param   $cnTable 标题;$enTable 字段
 ** $cnTable = array('bid'=>'单号','shop'=>'名称');
 ** $enTable=array('bid','shop');
 ** $data=array(array('bid'=>1,'shop'=>'京东商城'));
 */
function export_data($data,$cnTable,$enTable){
	include PC_PATH.DIRECTORY_SEPARATOR."out.php";				
	$name = mt_rand().'.xls';
	$excel = new ChangeArrayToExcel(PC_PATH.DIRECTORY_SEPARATOR."excel".DIRECTORY_SEPARATOR."sell".DIRECTORY_SEPARATOR.$name);	
	$excel->getExcel($data,$cnTable,$enTable,'other',20);
	header("Content-Type: application/force-download"); 
	header("Content-Disposition: attachment; filename=Excel.xls"); 
	readfile(PC_PATH.DIRECTORY_SEPARATOR."excel".DIRECTORY_SEPARATOR."sell".DIRECTORY_SEPARATOR.$name);
	unlink(PC_PATH.DIRECTORY_SEPARATOR."excel".DIRECTORY_SEPARATOR."sell".DIRECTORY_SEPARATOR.$name);
	exit;
}

/**
 *  info.func.php 分类信息函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2011-03-15
 */
 /*
 ** 获取该栏目下所有子栏目
 */
 function getchild($catid){	
	$siteid = get_siteid();$data = array();
	$CATEGORYS = getcache('category_content_'.$siteid,'commons');
	$info = $CATEGORYS[$catid]['arrchildid'];
	$info = explode(',',$info);	
	foreach($info as $r){
		if($r==$catid||!$r['ismenu']) continue;
		if($CATEGORYS[$r]['child']){
			$data['n'] = 1;
			continue;
		}
		$data['d'][$r]=$CATEGORYS[$r];
	}
	unset($info);
	return $data;
}
/**
 * 代码广告展示函数
 * @param intval $siteid 所属站点
 * @param intval $id 广告ID
 * @return 返回广告代码
 */
function getads($id,$siteid=1) {
	$siteid = intval($siteid);
	$id = intval($id);
	if(!$id || !$siteid) return false;
	$p = pc_base::load_model('poster_model');
	$sdb = pc_base::load_model('poster_space_model');
	$poster_template = getcache('poster_template_'.$siteid, 'commons');
	$info = $sdb->get_one(array('siteid'=>$siteid, 'spaceid'=>$id));
	if(!$info) exit();
	if ($poster_template[$info['type']]['padding']){
		if($info['setting']) $c['setting'] = $info['setting'] = string2array($info['setting']);
	}
	$c['width'] = $info['width'];
	$c['height'] = $info['height'];
	$r = $p->select(array('spaceid'=>$id, 'siteid'=>$siteid), 'disabled, setting,name','','listorder asc,`id` ASC');
	if($r){
		foreach($r as $k=>$val){
			if($val['disabled']) continue;
			$arr = string2array($val['setting']);
			$arr[1]['name']=$val['name'];
			$c['d'][] = $arr[1];
		}
	}else {
		$c['d'] = array();
	}	
	return $c;
}

/**
 * 数字转化为汉字
 */
 function numtochar($num){
    $num = (string)$num;
    for($i=1; $i<=strlen($num); $i++){
        $w = substr($num, -1*$i, 1);
        switch(($i-1)%4){
        case 1:
            $rate = "十";
            break;
        case 2:
            $rate = "百";
            break;
        case 3:
            $rate = "千";
            break;
        default:
            switch($i){
            case 1:
                $rate = "";
                break;
            case 5:
                $rate = "万";
                break;
            case 9:
                $rate = "亿";
                break;
            }
        }
        switch($w){
        case "1":
            $word = "一".$rate.$word;
            break;
        case "2":
            $word = "二".$rate.$word;
            break;
        case "3":
            $word = "三".$rate.$word;
            break;
        case "4":
            $word = "四".$rate.$word;
            break;
        case "5":
            $word = "五".$rate.$word;
            break;
        case "6":
            $word = "六".$rate.$word;
            break;
        case "7":
            $word = "七".$rate.$word;
            break;
        case "8":
            $word = "八".$rate.$word;
            break;
        case "9":
            $word = "九".$rate.$word;
            break;
        default:
            $word = ($i==1) ? $word:"零".$word;
            break;
        }
    }
    return $word;
}
/**
 * 内容中分页符分页
 */	 
function for_data($content = '',$data=array()){
	$maxcharperpage = $data['maxcharperpage'];
	$paginationtype = $data['paginationtype'];
	$id = $data['id'];
	$catid = $data['catid'];
	$inputtime = $data['inputtime'];
	$page = max(1,intval($_GET['page']));
	if($paginationtype==1) {
		//自动分页
		if($maxcharperpage < 10) $maxcharperpage = 500;
		$contentpage = pc_base::load_app_class('contentpage');		
		$content = $contentpage->get_data($content,$maxcharperpage);
	}
	
	if($paginationtype!=0) {
		//手动分页
		$CONTENT_POS = strpos($content, '[page]');
		if($CONTENT_POS !== false) {
			
			$url = pc_base::load_app_class('url', 'content');
			$contents = array_filter(explode('[page]', $content));
			$pagenumber = count($contents);
			if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
				$pagenumber--;
			}
			for($i=1; $i<=$pagenumber; $i++) {
				$pageurls[$i] = $url->show($id, $i, $catid, $inputtime);
			}
			$END_POS = strpos($content, '[/page]');
			if($END_POS !== false) {
				if($CONTENT_POS>7) {
					$content = '[page]'.$title.'[/page]'.$content;
				}
				if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
					foreach($m[1] as $k=>$v) {
						$p = $k+1;
						$titles[$p]['title'] = strip_tags($v);
						$titles[$p]['url'] = $pageurls[$p][0];
					}
				}
			}
			
			//当不存在 [/page]时，则使用下面分页
			$pages = content_pages($pagenumber,$page, $pageurls);
		
			
			//判断[page]出现的位置是否在第一位 
			
			if($CONTENT_POS<7) {
				$content = $contents[$page];
			} else {
				if ($page==1 && !empty($titles)) {
					$content = $title.'[/page]'.$contents[$page-1];
				} else {
					$content = $contents[$page-1];
				}
			}
			
			if($titles) {
				list($title, $content) = explode('[/page]', $content);
				$content = trim($content);
				if(strpos($content,'</p>')===0) {
					$content = '<p>'.$content;
				}
				if(stripos($content,'<p>')===0) {
					$content = $content.'</p>';
				}
			}
		
		}
	}
	$dat['content'] = $content;
	$dat['page'] = $pages;
	return $dat;
}
/**
 * 判断电话格式
 */	 
function is_tel($tel) {
	$boo = true;
	$tel = trim($tel);
	$reg0='/^((13|15|18|17)+\d{9})$/'; 
    //$reg1='/^15[01235789]\d{8}$/';  
    //$reg2='/^18[689]\d{8}$/'; 
	$reg1='/^[0-9-\s-]{6,13}$/'; 
	if(strlen($tel)!=11){
		$boo = false;
	}
	if(preg_match(reg0, $tel)){
		$boo = false;
	}
	if(preg_match(reg1, $tel)){
		$boo = false;
	}
	if(preg_match(reg2, $tel)){
		$boo = false;
	}
	if(preg_match(reg3, $tel)){
		$boo = false;
	}
	return $boo; 	
}
/**
 * 生成人性化日期
 * Enter description here ...
 * @param unknown_type $timestamp
 */	
function timeinterval($timestamp) {
    $format=array('秒钟前','分钟前','小时前');
    if(is_numeric($timestamp)){
         $i=SYS_TIME-$timestamp;
         switch($i){
            case 60>$i: $str=$i.$format[0];break;  
            case 3600>$i: $str=round ($i/60).$format[1];break;
            case 86400>$i: $str=round ($i/3600).$format[2];break;       
            case $i>86400: $str=date('m-d', $timestamp);break;
        }
     }
     return $str;           		
}

/**
 * 构造筛选URL
 */
function structure_filters_url($fieldname,$array=array(),$type = 1,$modelid) {
	if(empty($array)) {
		$array = $_GET;
	} else {
		$array = array_merge($_GET,$array);
	}
	//TODO
	$fields = getcache('model_field_'.$modelid,'model');
	if(is_array($fields) && !empty($fields)) {
		ksort($fields);
		foreach ($fields as $_v=>$_k) {
			if($_k['filtertype'] || $_k['rangetype']) {
				if(strpos(URLRULE,'.html') === FALSE) $urlpars .= '&'.$_v.'={$'.$_v.'}';
				else $urlpars .= '-{$'.$_v.'}';
			}
		}
	}
	//后期增加伪静态等其他url规则管理，apache伪静态支持9个参数
	if(strpos(URLRULE,'.html') === FALSE) $urlrule =APP_PATH.'index.php?m=content&c=index&a=lists&catid={$catid}&city={$city}'.$urlpars.'&page={$page}' ;
	else $urlrule =APP_PATH.'list-{$catid}-{$city}'.$urlpars.'-{$page}.html';
	//根据get传值构造URL
	if (is_array($array)) foreach ($array as $_k=>$_v) {
		if($_k=='page') $_v=1;
		if($type == 1) if($_k==$fieldname) continue;
		$_findme[] = '/{\$'.$_k.'}/';
		$_replaceme[] = $_v;
	}
     //type 模式的时候，构造排除该字段名称的正则
	if($type==1) $filter = '(?!'.$fieldname.'.)';
	$_findme[] = '/{\$'.$filter.'([a-z0-9_]+)}/';
	$_replaceme[] = '';		
	$urlrule = preg_replace($_findme, $_replaceme, $urlrule);	
	return 	$urlrule;
}

function structure_url($array=array()) {
	if(empty($array)) {
		$array = $_GET;
	} else {
		$array = array_merge($_GET,$array);
	}

	//后期增加伪静态等其他url规则管理，apache伪静态支持9个参数
	if(strpos(URLRULE,'.html') === FALSE) $urlrule =APP_PATH.'index.php?m=guestbook&c=index&page={$page}' ;
	else $urlrule =APP_PATH.'list-{$page}.html';
	//根据get传值构造URL
	if (is_array($array)) foreach ($array as $_k=>$_v) {
		if($_k=='page') $_v=1;	
		$_findme[] = '/{\$'.$_k.'}/';
		$_replaceme[] = $_v;
	}
	
	$_findme[] = '/{\$([a-z0-9_]+)}/';
	$_replaceme[] = '';		
	$urlrule = preg_replace($_findme, $_replaceme, $urlrule);	
	return 	$urlrule;
}

/**
 * 构造筛选时候的sql语句
 */
function structure_filters_sql($modelid,$cityid='') {
	//echo $cityid;exit;
	$sql = $fieldname = $min = $max = '';
	$fieldvalue = array();
	$modelid = intval($modelid);
	$model =  getcache('model','commons');
	$fields = getcache('model_field_'.$modelid,'model');
	$fields_key = array_keys($fields);
	//TODO

	$sql = '`status` = \'99\'';
	if(intval($cityid)!=0)  $sql .= ' AND `zone`=\''.$cityid.'\'';
	foreach ($_GET as $k=>$r) {
		if(in_array($k,$fields_key) && intval($r)!=0 && ($fields[$k]['filtertype'] || $fields[$k]['rangetype'])) {
			if($fields[$k]['formtype'] == 'linkage') {
				$datas = getcache($fields[$k]['linkageid'],'linkage');
				$infos = $datas['data'];
				if($infos[$r]['arrchildid']) {
					$sql .=  ' AND `'.$k.'` in('.$infos[$r]['arrchildid'].')';	
				}	
			} elseif($fields[$k]['rangetype']) {
				if(is_numeric($r)) {
					$sql .=" AND `$k` = '$r'";
				} else {
					$fieldvalue = explode('_',$r);
					$min = intval($fieldvalue[0]);
					$max = $fieldvalue[1] ? intval($fieldvalue[1]) : 999999;				
					$sql .=" AND `$k` >= '$min' AND  `$k` < '$max'";
				}
			} else {	
				$sql .=" AND `$k` = '$r'";
			}
		}
	}	
	return $sql;
}

/**
 * 生成分类信息中的筛选菜单
 * @param $field   字段名称
 * @param $modelid  模型ID
 */
function filters($field,$modelid,$diyarr = array()) {
	$fields = getcache('model_field_'.$modelid,'model');
	$options = empty($diyarr) ?  explode("\n",$fields[$field]['options']) : $diyarr;
	$field_value = intval($_GET[$field]);
	foreach($options as $_k) {
		$v = explode("|",$_k);
		$k = trim($v[1]);
		$option[$k]['name'] = $v[0];
		$option[$k]['value'] = $k;
		$option[$k]['url'] = structure_filters_url($field,array($field=>$k),2,$modelid);
		$option[$k]['menu'] = $field_value == $k ? '<li  class="buxian">'.$v[0].'</li>' : '<li><a href='.$option[$k]['url'].'>'.$v[0].'</a></li>' ;
	}
	$all['name'] = '全部';
	$all['url'] = structure_filters_url($field,array($field=>''),2,$modelid);
	$all['menu'] = $field_value == '' ? '<li class="buxian">'.$all['name'].'</li>' : '<li><a href='.$all['url'].'>'.$all['name'].'</a></li>';
	

	array_unshift($option,$all);	
	return $option;
}

/**
 * 通过指定keyid形式显示所有联动菜单
 * @param  $keyid 菜单主id
 * @param  $linkageid  联动菜单id
 * @param  $toppatentid 父级菜单id
 * @param  $modelid 模型id
 * @param  $fieldname  字段名称
 * @param  $showall 是否显示全部
 */
function show_linkage($keyid, $linkageid = 0, $toppatentid = '', $modelid = '', $fieldname='zone' ,$showall = 1) {
	$datas = $infos =array();
	$keyid = intval($keyid);
	$linkageid = intval($linkageid);
	$urlrule = structure_filters_url($fieldname,$array,1,$modelid);
	if($keyid == 0 || $linkageid == 0) return false;
	$datas = getcache($keyid,'linkage');
	$infos = $datas['data'];
	$linkageid_tmp = $infos[$linkageid]['child'] ? $linkageid : $infos[$linkageid]['parentid'];
	if($linkageid_tmp == $toppatentid) $linkageid_tmp = $linkageid;
	if(is_array($infos) && !empty($infos)) {
		foreach ($infos as $k => $v) {
			if($v['parentid'] != $linkageid_tmp) {
				unset($infos[$k]);
				continue;
			}
			$url = preg_replace('/{\$'.$fieldname.'}/', $v['linkageid'], $urlrule);
			$url = str_replace(array('http://','//','~'), array('~','/','http://'), $url);		
			$infos[$k]['url'] = $url;
		}
	}
	if($toppatentid == $linkageid) $linkageid_tmp = '';
	if($showall && !empty($infos)) array_unshift($infos,array('name'=>'全部','url'=>preg_replace('/{\$'.$fieldname.'}/', $linkageid_tmp, $urlrule),'linkageid'=>$linkageid_tmp));
	return $infos;
}
/**
 * 获取联动菜单层级
 * @param  $keyid     联动菜单分类id
 * @param  $linkageid 菜单id
 * @param  $leveltype 获取类型 parentid 获取父级id child 获取时候有子栏目 arrchildid 获取子栏目数组
 */
function get_linkage_level($keyid,$linkageid,$leveltype = 'parentid') {
	$child_arr = $childs = array();
	$leveltypes = array('parentid','child','arrchildid','arrchildinfo');
	$datas = getcache($keyid,'linkage');
	$infos = $datas['data'];
	if (in_array($leveltype, $leveltypes)) {
		if($leveltype == 'arrchildinfo') {
			$child_arr = explode(',',$infos[$linkageid]['arrchildid']);
			foreach ($child_arr as $r) {
				$childs[] = $infos[$r];
			}
			return $childs;
		} else {
			return $infos[$linkageid][$leveltype];
		}
	}	
}


/**
 * 根据box类型字段获取显示名称
 * @param $field 字段名称
 * @param $value 字段值
 * @param $modelid 字段所在模型id
 */
function box($field, $value, $modelid='') {
	$fields = getcache('model_field_'.$modelid,'model');
	extract(string2array($fields[$field]['setting']));
	$options = explode("\n",$fields[$field]['options']);
	foreach($options as $_k) {
		$v = explode("|",$_k);
		$k = trim($v[1]);
		$option[$k] = $v[0];
	}
	$string = '';
	switch($fields[$field]['boxtype']) {
		case 'radio':
			$string = $option[$value];
		break;

		case 'checkbox':
			$value_arr = explode(',',$value);
			foreach($value_arr as $_v) {
				if($_v) $string .= $option[$_v].' 、';
			}
		break;

		case 'select':
			$string = $option[$value];
		break;

		case 'multiple':
			$value_arr = explode(',',$value);
			foreach($value_arr as $_v) {
				if($_v) $string .= $option[$_v].' 、';
			}
		break;
	}
	return $string;
}
	
/**
 * 获取信息配置缓存参数
 * @param $key 信息模型参数参数
 * @param $filename 字段值 缓存文件名称，默认为info_setting
 */
function getinfocache($key, $filename = 'info_setting') {
	$infos = getcache($filename,'commons');
	if(is_array($infos) && !empty($infos) && array_key_exists($key, $infos)) {
		if($key == 'info_modelid') {
			$model =  getcache('model','commons');
			$modelids = explode(',', $infos[$key]);
			if(is_array($modelids)) {
				foreach($modelids as $m) {
					$models[$m] = $model[$m];	
				}
			}
			return $models;
		}	
		return  $infos[$key];
	}	
}

/**
 * 获取信息配置城市信息
 * @param $key 城市编号，通常为城市拼音名称
 * @param $info 获取数据类型
 * @param $showall 是否显示所有
 */
function getcity($key ='', $info = '', $filename = 'info_citys', $showall = '0') {
	$citys = $current_city = array();
	$citys = getcache($filename,'commons');
	$key = strtolower(trim($key));
	if(is_array($citys) && !empty($citys) && !$showall && $info) {
		if(array_key_exists($key, $citys)) {
		    return  $citys[$key][$info];
		} else {
			$current_city = current($citys);
			return $current_city[$info];
		}
		
	} else {
		return $citys;
	}
}

function getlocalinfo($ip) {
	pc_base::load_sys_func('iconv');
	$ip_area = pc_base::load_sys_class('ip_area');
	$localinfo = $ip_area->getcitybyapi($ip);
	$info['name'] = $localinfo['city']; 
	$info['pinyin'] = $localinfo['pinyin']; 
	return $info;

} 

function makeurlrule() {
	if(strpos(URLRULE,'.html') === FALSE) {
		return url_par('page={$'.'page}');
	}
	else {
		$url = preg_replace('/-[0-9]+.html$/','-{$page}.html',get_url());
		return $url;
	}
}

function makecaturl($url, $city, $multi_city = '1') {
	if($multi_city) {
		if(strpos($url,'.html') === FALSE) {
			return $url.'&city='.$city;
		} else {
			return preg_replace('/(-[0-9]+).html$/i', '-'.$city.'$0', $url);
		}
	} else {
		return $url;
	}
}
/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function strcut($string, $length, $dot = '...',$offset = 0) {
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	if($offset >= $strlen) return $string;
	$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {
		$length = intval($length-strlen($dot)-$length/3);
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
		$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1+$offset;
		$current_str = '';
		$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
		$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
		$search_flip = array_flip($search_arr);
		for ($i = $offset; $i < $maxi; $i++) {
			$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			if (in_array($current_str, $search_arr)) {
				$key = $search_flip[$current_str];
				$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
			}
			$strcut .= $current_str;
		}
	}
	return $strcut.$dot;
}

function filtersele($field,$modelid,$diyarr = array()) {
	$fields = getcache('model_field_'.$modelid,'model');
	$options = empty($diyarr) ?  explode("\n",$fields[$field]['options']) : $diyarr;

	
	foreach($options as $_k) {
		$v = explode("|",$_k);
		$k = trim($v[1]);
		$option[$k]['name'] = $v[0];
		$option[$k]['value'] = $k;
		
	}	
	return $option;
}
function yymessage($msg, $url_forward = 'close',$ms='', $ma = '', $dialog = '', $returnjs = '') {
	
	if(defined('IN_ADMIN')) {
		include(admin::admin_tpl('showmessage', 'admin'));
	} else {
		include(template('content', 'yymessage'));
	}
	exit;
}
function qymessage($msg, $url_forward = 'close',$ms='', $ma = '', $dialog = '', $returnjs = '') {
	
	if(defined('IN_ADMIN')) {
		include(admin::admin_tpl('showmessage', 'admin'));
	} else {
		include(template('content', 'qymessage'));
	}
	exit;
}

?>