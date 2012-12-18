<?php
include('phpQuery.php');
$url='http://www.zhibo8.cc/';
$html=curl_file_get_contents($url);
$dom=phpQuery::newDocument($html);
$footballVideo=$dom['div#top10 div.box:first-child'];
$basketballVideo=$dom['div#top10 div.box:last-child'];
$lives=$dom['div#left div.box'];
echo '<div id="sports">';
echo '<div id="video"><h2>足球视频</h2><hr>';
echo $footballVideo['div.video'];
echo '<h2>篮球视频</h2><hr>';
echo $basketballVideo['div.video'];
echo '</div><hr><div id="live"><h2 class="title">直播表</h2>';
foreach($lives as $e){
	$e=pq($e);
	if($e['.content']->is(':has("li b")')){
	echo '<div class="day"><hr>'.$e['.titlebar h2'].'<hr>';
	$i=0;
	$list=$e['ul li:has(b)'];
	foreach($list as $li){
		if($i++>0)
			echo '<hr class="dash">';
		echo '<div class="lists">';
		echo pq($li)->html();
		echo'</div>';
	}
	echo '</div>';
	}
}
echo '</div></div>';
?>

