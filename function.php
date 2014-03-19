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
    if(ROUTE){
        //TODO
        //路由规则里全写成小写吧
        $router_key = strtolower(trim($url));
        //导入路由
        $router_ruler   =   include(dirname(__FILE__).'/route.php');
        //路由命中
        if(isset($router_ruler[$router_key])){
            //eg $router_key = 'blog/index';
            $real_url = $router_ruler[$router_key];
            if(is_array($params)){
                //$params = array('tag'=>1);
                foreach($params as $k=>$v){
                    //判断是否为二级路由
                    if(is_array($real_url)){
                        //$real_url = array(
                        //          'null'=>'./',
                        //          'nav'=>array(
                        //                  '1' => 'note.html',
                        //                  '2' => 'home.html',
                        //                  '3' => 'xxxx.html'
                        //                  ),
                        //          'tag'=>'tag_[tag].html'
                        //          );

                        foreach($real_url as $key => $value){
                            //$params = array('nav'=>1);
                            //$value = array('1'=>'note.html','2'=>'home.html');
                            if(is_array($value)){
                                if($key == $k){
                                    //$k = nav
                                    //$key = nav
                                    //三级路由命中
                                    $real_url = $value[$v];
                                }
                            }else{
                                if($key == $k){
                                    //二级路由命中
                                    //$value = 'tag_[tag].html';
                                    $real_url = routeReg($value,$k,$v);
                                }
                            }
                        }
                    }else{
                        //$params = array('id'=>1,'p'=>2);
                        //$real_url;//'[id]_[p].html'
                        //'['.$k.']';//[id]
                        $real_url = routeReg($real_url,$k,$v);
                    }
                }
            }
        }else{
            $real_url = urlBuild($url,$params);
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
    $url=explode('/',$url);
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
 * @param string  $routeStr url正则字符串，类似于'tag'=>'tag_[tag].html'
 * @param string  $key      url正则中的 [关键字],如上面的的tag
 * @param string  $value    需要替换正则字符串里面的关键字的实际参数值
 * @return string $url      返回最终匹配完的伪静态地址
 */
function routeReg($routeStr,$key,$value){
    if(strstr($routeStr,'['.$key.']')){
        $url   =   str_replace('['.$key.']',$value,$routeStr);
    }
    //针对参数传递不完整的，比如传了id，但是没有传p（默认为第一页，所以需要给一个默认值）
    $url = preg_replace('/(\[.*?\])/',1,$url);
    return $url;
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