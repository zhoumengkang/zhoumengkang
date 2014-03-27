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

/**
 * Url地址构造函数
 * @param  string $url      控制器和方法 'Blog/blog'
 * @param  array  $params   array('id'=>1,'p'=>3)
 * @return string $real_url 伪静态地址 或者真实的$_SERVER['QUERY_STRING']
 */
function U($url,$params=null){
    //是否开启路由
    if(defined('ROUTE') && ROUTE){
        //导入路由
        $router_ruler   =   include_once(dirname(__FILE__).'/route.php');
        $real_url = route($router_ruler,$url,$params);
    }else{
        $real_url = urlBuild($url,$params);
    }
	return $real_url;
}

/**
 * @param array  $router_ruler 路由表
 * @param string $url          路由键
 * @param array  $params       参数列表
 */
function route($router_ruler,$url,$params){
    //路由规则里全写成小写吧
    $router_key = strtolower(trim(trim($url),'/'));
    if(isset($router_ruler[$router_key])){
        //一级路由
        $real_url = $router_ruler[$router_key];
        //由于规定参数格式必须是数组，所以这里只存在是数组和不是数组（为空）的情况
        if(is_array($real_url)){
            //看其是不是索引数组
            if(array_product(array_map('is_numeric', array_keys($real_url)))==1){
                //二级路由
                if(is_array($params)){
                    $real_url = routeMatch($real_url[count($params)],$params);
                }
            }else{
                //三级路由
                foreach($params as $k =>$v){
                    if(array_key_exists($k,$real_url)){
                        $routeReg = $real_url[$k][$v][count($params)];
                        unset($params[$k]);
                        $real_url = routeMatch($routeReg,$params);
                    }
                }
            }
        }
    }else{
        $real_url = urlBuild($url,$params);
    }
    return $real_url;
}
/**
 * 配合http_build_query实现正常的动态地址，类似于index.php?m=xxx&a=xxx&id=xxx&p=xxx
 * @param  string $url      控制器和方法
 * @param  array  $params   参数列表
 * @return string $real_url 实际地址
 */
function urlBuild($url,$params){
    $url=explode('/',trim($url,'/'));
    $real_url   =   SITE_URL.'?m='.$url[0].'&a='.$url[1];
    if($params){
        if(is_array($params)){
            $params =   http_build_query($params);
            $params =   urldecode($params);
        }
        $real_url   .=  '&'.$params;
    }
    return $real_url;
}

/**
 * 路由匹配
 * @param  string  $routeReg    路由规则字符串，类似于'tag'=>'tag_[tag].html'
 * @param  string  $params      需要替换正则字符串里面的关键字的实际参数值
 * @return string  $routeReg    返回最终匹配完的伪静态地址
 */
function routeMatch($routeReg,$params){
    foreach($params as $key =>$value){
        if(strstr($routeReg,'['.$key.']')){
            $routeReg = str_replace('['.$key.']',$value,$routeReg);
        }
    }
    return $routeReg;
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

/**
 * 清楚内容中的空白，暂时用于输出页面的description
 * @param $str
 * @return mixed
 */
function cleanTheWhitespace($str){
    $toClean = array("\t","\r\n","\r","\n","    ","&nbsp;");
    //顺便把双引号转为了单引号，怕在description中与外围的双引号冲突
    return str_replace('"',"'",str_replace($toClean, "", htmlspecialchars_decode(strip_tags($str),ENT_QUOTES)));
}


function getKeywords($tags){
    $keyword = '';
    if(is_array($tags)){
        if(count($tags)<3){
            foreach($tags as $k=>$v){
                $keyword .=','.$v['name'];
            }
            $keyword .= ',北剅轩,周梦康';
        }else{
            foreach($tags as $k=>$v){
                $keyword .=','.$v['name'];
            }
        }
    }
    return trim($keyword,',');
}

/**
 * 异步请求
 * @param string $url
 * @param array  $post_data
 * @return void
 */
function request_by_fsockopen($url,$post_data=array()){
    $url_array = parse_url($url);
    $hostname = $url_array['host'];
    $port = isset($url_array['port'])? $url_array['port'] : 80;
    $requestPath = $url_array['path'] ."?". $url_array['query'];
    $fp = fsockopen($hostname, $port, $errno, $errstr, 10);
    if (!$fp) {
        echo "$errstr ($errno)";
        return false;
    }
    $method = "GET";
    if(!empty($post_data)){
        $method = "POST";
    }
    $header = "$method $requestPath HTTP/1.1\r\n";
    $header.="Host: $hostname\r\n";
    if(!empty($post_data)){
        $_post = strval(NULL);
        foreach($post_data as $k => $v){
            $_post[]= $k."=".urlencode($v);//
        }
        $_post = implode('&', $_post);
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
        $header .= "Content-Length: ". strlen($_post) ."\r\n";//POST数据的长度
        $header.="Connection: Close\r\n\r\n";//长连接关闭
        $header .= $_post; //传递POST数据
    }else{
        $header.="Connection: Close\r\n\r\n";//长连接关闭
    }
    fwrite($fp, $header);
    //-----------------调试代码区间-----------------
    /*$html = '';
    while (!feof($fp)) {
        $html.=fgets($fp);
    }
    echo $html;*/
    //-----------------调试代码区间-----------------
    fclose($fp);
}