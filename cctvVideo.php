<?php		
	/**
	 * CCTV(央视网)视频解析
	 * 作者：wulin (77sec.cn)
	 * 日期：2019/11/26
	 */
	header("Content-type:text/html;charset=utf-8");
	error_reporting(0);
	function curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'
		));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.cctv.com/');//修改Referer
		$contents = curl_exec($ch);
		curl_close($ch);
		return $contents;  
	}
	function getCctv($VideoUrl) {
		$contents = curl($VideoUrl);
		//"videoCenterId","3ebb32c9a2474758b86d8a98f433c3b3");
		//preg_match("~videoCenterId\"\,\"(.*?)\"~", $contents, $matches);
		//echo $contents;
		preg_match("~var guid \= \"(.*?)\"~", $contents, $matches);

		if (count($matches) == 0) {
			echo '无法解析此视频，请换个链接试一下。';
			exit;
		}
		$video_url = $matches[1];
		//echo $video_url;
		//echo "~~~~~~~~~";
		$video_url_parse = "http://asp.cntv.myalicdn.com/asp/hls/main/0303000a/3/default/".$video_url."/main.m3u8?maxbr=2048";
		//echo $video_url_parse;    //输出url
		header("Location: http://player.77sec.cn/m3u8/?url=$video_url_parse");    //header跳转
	
	}
	//test url
	//$VideoUrl = "http://tv.cctv.com/2019/08/20/VIDENG6stn4B5emplSAUTn0I190820.shtml?spm=C84111.PZO22JmjMhJE.S15440.71";
	if(!isset($_GET['url'])）{
		echo "<h1>请在网页后面输入cctv视频地址</h1>";
		header('Refresh:2;url=cctvVideo.php?url=');
		exit;
	}if($_GET['url']==null){
		echo "<h1>请在网页后面输入cctv视频地址</h1>";		
		exit;
	}	
	$VideoUrl = $_GET['url'];
	
	getCctv($VideoUrl);
	//http://asp.cntv.myalicdn.com/asp/hls/main/0303000a/3/default/3ebb32c9a2474758b86d8a98f433c3b3/main.m3u8?maxbr=2048
	exit;

?>		
