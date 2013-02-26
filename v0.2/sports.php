<?php
include('phpQuery.php');
$url='http://www.zhibo8.cc/';
$html = curl_file_get_contents($url);
$sportsDiv = sportsNewsFormater($html);

$sportsHeader = '<div id="sports">';
$footer = '</div>';

echo $sportsHeader.$sportsDiv.$footer;

class liveOfDay{
	public $date;
	public $lives; //lives of a day
}

function sportsNewsFormater($htmlStr){
	$dom=phpQuery::newDocument($htmlStr);
	$footballVideo=$dom['div#top10 div.box:first-child div.video'];
	$basketballVideo=$dom['div#top10 div.box:last-child div.video'];
	$liveVec=$dom['div#left div.box'];

	$days = parseLive($liveVec);

	$result = '';
	$result .= '<div id="video"><h2>足球视频</h2><hr>';
	$result .= $footballVideo;
	$result .= '<h2>篮球视频</h2><hr>';
	$result .= $basketballVideo;

	$result .= '</div><hr><div id="live"><h2 class="title">直播表</h2>';
	foreach($days as $e){
		$result .= '<div class="day"><hr>'.$e->date.'<hr>';
		$i=0;
		foreach($e->lives as $live){
			if($i++>0)
				$result .= '<hr class="dash">'; //separater
			$result .= '<div class="lists">'.$live.'</div>';
		}
		$result .= '</div>';
	}
	$result .= '</div></div>';
	return $result;
}
function parseLive($liveVec){
	$i=0;
	foreach($liveVec as $e){
		$e=pq($e);
		if($e['.content']->is(':has("li b")')){ //only bold match
			$days[$i] = new liveOfDay();
			$days[$i]->date = $e['.titlebar h2'];
			$j=0;
			$list=$e['ul li:has(b)']; //bold matches of the day
			foreach($list as $li){
				$days[$i]->lives[$j++] = pq($li)->html();
			}
			++$i;
		}
	}
	return $days;
}
?>

