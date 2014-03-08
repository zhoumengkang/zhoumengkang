<?php
function dump($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}
function d(){
	//这里我本来想了好就，思考是不是应该把D.class.php包含进来，但是想到我这走的是index.php，则会自动去加载D.class.php了，事实证明的确如此
	return new D();
}
//生成Url地址
function U($url,$params=false){
	$url=explode('/',$url);
	$site_url   =   SITE_URL.'?m='.$url[0].'&a='.$url[1];
	if($params){
        if(is_array($params)){
            $params =   http_build_query($params);
            $params =   urldecode($params);
        }
        $site_url   .=  '&'.$params;
    }
	return $site_url;
}

/**
 * $p 当前页
 * $total 总数
 * $pre 每页显示的数目
 */
function pagelist($p,$total,$pre){
		parse_str($_SERVER['QUERY_STRING'],$params);
		if($params['p']){
			unset($params['p']);
			$params =   http_build_query($params);
            $params =   urldecode($params);
			$url = $_SERVER['PHP_SELF'].'?'.$params;
		}else{
			$url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		}
		$pages = ceil($total/$pre) ;
        if($pages < 2){
            return '<div class="pages"></div>';
        }
		$str='<div class="pages">';
		if($pages>11){
				if($p<=6){
					for($i=1;$i<=10;$i++){
						if($i == $p){
							$str.='<a href="'.$url.'&p='.$i.'" class="active"><span class="active">'.$i.'</span></a>';
						}else{
							$str.='<a href="'.$url.'&p='.$i.'"><span>'.$i.'</span></a>';
						}
					}
					$str.='...';
					$str.='<a href="'.$url.'$p='.($p+1).'" title="下一页"><span> > </span></a>';
					$str.='<a href="'.$url.'$p='.$pages.'" title="最后一页"><span>>></span></a>';
				}else{
					$start = $p-5;
					$end = $p+5;
					$str.='<a href="'.$url.'$p='.$pages.'" title="第一页"><span><<</span></a>';
					$str.='<a href="'.$url.'$p='.($p-1).'" title="上一页"><span> < </span></a>';
					for($i=$start;$i<$end;$i++){
					if($i == $p){
							$str.='<a href="'.$url.'&p='.$i.'" class="active"><span class="active">'.$i.'</span></a>';
						}else{
							$str.='<a href="'.$url.'&p='.$i.'"><span>'.$i.'</span></a>';
						}
					}
					$str.='...';
					$str.='<a href="'.$url.'$p='.($p+1).'" title="下一页"><span> > </span></a>';
					$str.='<a href="'.$url.'$p='.$pages.'" title="最后一页"><span>>></span></a>';
				}
		}else{
			for($i=1;$i<=$pages;$i++){
				if($i == $p){
					$str.='<a href="'.$url.'&p='.$i.'" class="active"><span class="active">'.$i.'</span></a>';
				}else{
					$str.='<a href="'.$url.'&p='.$i.'"><span>'.$i.'</span></a>';
				}
			}	
		}
		$str.='</div>';
		return $str;

}
/*字符串截取函数*/
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
    $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    if($suffix && $str != $slice) return $slice."...";
    return $slice;
}

function showMsg($string){
	echo '<script>showMsg('.$string.')</script>';
}