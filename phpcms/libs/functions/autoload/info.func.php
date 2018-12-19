<?php
/*
 **  ���ݵ�������excel�ļ�
 ** param   $cnTable ����;$enTable �ֶ�
 ** $cnTable = array('bid'=>'����','shop'=>'����');
 ** $enTable=array('bid','shop');
 ** $data=array(array('bid'=>1,'shop'=>'�����̳�'));
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
 *  info.func.php ������Ϣ������
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2011-03-15
 */
 /*
 ** ��ȡ����Ŀ����������Ŀ
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
 * ������չʾ����
 * @param intval $siteid ����վ��
 * @param intval $id ���ID
 * @return ���ع�����
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
 * ����ת��Ϊ����
 */
 function numtochar($num){
    $num = (string)$num;
    for($i=1; $i<=strlen($num); $i++){
        $w = substr($num, -1*$i, 1);
        switch(($i-1)%4){
        case 1:
            $rate = "ʮ";
            break;
        case 2:
            $rate = "��";
            break;
        case 3:
            $rate = "ǧ";
            break;
        default:
            switch($i){
            case 1:
                $rate = "";
                break;
            case 5:
                $rate = "��";
                break;
            case 9:
                $rate = "��";
                break;
            }
        }
        switch($w){
        case "1":
            $word = "һ".$rate.$word;
            break;
        case "2":
            $word = "��".$rate.$word;
            break;
        case "3":
            $word = "��".$rate.$word;
            break;
        case "4":
            $word = "��".$rate.$word;
            break;
        case "5":
            $word = "��".$rate.$word;
            break;
        case "6":
            $word = "��".$rate.$word;
            break;
        case "7":
            $word = "��".$rate.$word;
            break;
        case "8":
            $word = "��".$rate.$word;
            break;
        case "9":
            $word = "��".$rate.$word;
            break;
        default:
            $word = ($i==1) ? $word:"��".$word;
            break;
        }
    }
    return $word;
}
/**
 * �����з�ҳ����ҳ
 */	 
function for_data($content = '',$data=array()){
	$maxcharperpage = $data['maxcharperpage'];
	$paginationtype = $data['paginationtype'];
	$id = $data['id'];
	$catid = $data['catid'];
	$inputtime = $data['inputtime'];
	$page = max(1,intval($_GET['page']));
	if($paginationtype==1) {
		//�Զ���ҳ
		if($maxcharperpage < 10) $maxcharperpage = 500;
		$contentpage = pc_base::load_app_class('contentpage');		
		$content = $contentpage->get_data($content,$maxcharperpage);
	}
	
	if($paginationtype!=0) {
		//�ֶ���ҳ
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
			
			//�������� [/page]ʱ����ʹ�������ҳ
			$pages = content_pages($pagenumber,$page, $pageurls);
		
			
			//�ж�[page]���ֵ�λ���Ƿ��ڵ�һλ 
			
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
 * �жϵ绰��ʽ
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
 * �������Ի�����
 * Enter description here ...
 * @param unknown_type $timestamp
 */	
function timeinterval($timestamp) {
    $format=array('����ǰ','����ǰ','Сʱǰ');
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
 * ����ɸѡURL
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
	//��������α��̬������url�������apacheα��̬֧��9������
	if(strpos(URLRULE,'.html') === FALSE) $urlrule =APP_PATH.'index.php?m=content&c=index&a=lists&catid={$catid}&city={$city}'.$urlpars.'&page={$page}' ;
	else $urlrule =APP_PATH.'list-{$catid}-{$city}'.$urlpars.'-{$page}.html';
	//����get��ֵ����URL
	if (is_array($array)) foreach ($array as $_k=>$_v) {
		if($_k=='page') $_v=1;
		if($type == 1) if($_k==$fieldname) continue;
		$_findme[] = '/{\$'.$_k.'}/';
		$_replaceme[] = $_v;
	}
     //type ģʽ��ʱ�򣬹����ų����ֶ����Ƶ�����
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

	//��������α��̬������url�������apacheα��̬֧��9������
	if(strpos(URLRULE,'.html') === FALSE) $urlrule =APP_PATH.'index.php?m=guestbook&c=index&page={$page}' ;
	else $urlrule =APP_PATH.'list-{$page}.html';
	//����get��ֵ����URL
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
 * ����ɸѡʱ���sql���
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
 * ���ɷ�����Ϣ�е�ɸѡ�˵�
 * @param $field   �ֶ�����
 * @param $modelid  ģ��ID
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
	$all['name'] = 'ȫ��';
	$all['url'] = structure_filters_url($field,array($field=>''),2,$modelid);
	$all['menu'] = $field_value == '' ? '<li class="buxian">'.$all['name'].'</li>' : '<li><a href='.$all['url'].'>'.$all['name'].'</a></li>';
	

	array_unshift($option,$all);	
	return $option;
}

/**
 * ͨ��ָ��keyid��ʽ��ʾ���������˵�
 * @param  $keyid �˵���id
 * @param  $linkageid  �����˵�id
 * @param  $toppatentid �����˵�id
 * @param  $modelid ģ��id
 * @param  $fieldname  �ֶ�����
 * @param  $showall �Ƿ���ʾȫ��
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
	if($showall && !empty($infos)) array_unshift($infos,array('name'=>'ȫ��','url'=>preg_replace('/{\$'.$fieldname.'}/', $linkageid_tmp, $urlrule),'linkageid'=>$linkageid_tmp));
	return $infos;
}
/**
 * ��ȡ�����˵��㼶
 * @param  $keyid     �����˵�����id
 * @param  $linkageid �˵�id
 * @param  $leveltype ��ȡ���� parentid ��ȡ����id child ��ȡʱ��������Ŀ arrchildid ��ȡ����Ŀ����
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
 * ����box�����ֶλ�ȡ��ʾ����
 * @param $field �ֶ�����
 * @param $value �ֶ�ֵ
 * @param $modelid �ֶ�����ģ��id
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
				if($_v) $string .= $option[$_v].' ��';
			}
		break;

		case 'select':
			$string = $option[$value];
		break;

		case 'multiple':
			$value_arr = explode(',',$value);
			foreach($value_arr as $_v) {
				if($_v) $string .= $option[$_v].' ��';
			}
		break;
	}
	return $string;
}
	
/**
 * ��ȡ��Ϣ���û������
 * @param $key ��Ϣģ�Ͳ�������
 * @param $filename �ֶ�ֵ �����ļ����ƣ�Ĭ��Ϊinfo_setting
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
 * ��ȡ��Ϣ���ó�����Ϣ
 * @param $key ���б�ţ�ͨ��Ϊ����ƴ������
 * @param $info ��ȡ��������
 * @param $showall �Ƿ���ʾ����
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
 * �ַ���ȡ ֧��UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function strcut($string, $length, $dot = '...',$offset = 0) {
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	if($offset >= $strlen) return $string;
	$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('��',' ', '&', '"', "'", '��', '��', '��', '<', '>', '��', '��'), $string);
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
		$strcut = str_replace(array('��', '&', '"', "'", '��', '��', '��', '<', '>', '��', '��'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1+$offset;
		$current_str = '';
		$search_arr = array('&',' ', '"', "'", '��', '��', '��', '<', '>', '��', '��','��');
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