<?php
include('phpQuery.php');

$url='https://news.ycombinator.com/';
$html=curl_file_get_contents($url);
$hackerNewsDiv = hackerNewsFormater($html);

$url='http://www.reddit.com/r/programming';
$html=curl_file_get_contents($url);
$redditProgrammingDiv = redditFormatter($html);

$url='http://www.reddit.com/r/technology';
$html=curl_file_get_contents($url);
$redditTechnologyDiv = redditFormatter($html);

$geekDivHeader = '<div id="geek">';
$footer = '</div>';
$hackerNewsHeader = '<div id="HN"><div class="caption">Hacker News</div><br/>';
$hackerNewsFooter = '</div>';
$separater = '<hr><br/>';
$redditProgramHeader = '<div id="RPro"><div class="caption">Reddit Programming</div><br/>';
$redditTechHeader = '<div id="RCha"><div class="caption">Reddit Technology</div><br/>';

echo $geekDivHeader;

echo $hackerNewsHeader;
echo $hackerNewsDiv;
echo $footer.$separater;

echo $redditProgramHeader;
echo $redditProgrammingDiv;
echo $footer.$separater;

echo $redditTechHeader;
echo $redditTechnologyDiv;
echo $footer.$footer;

function hackerNewsFormater($htmlStr){
	$dom=phpQuery::newDocument($htmlStr);
	$titleVec=$dom['table table td.title:has(a)'];
	$infoVec=$dom['table table td.subtext'];
	//parse Title
	$titles = parseHackerNewsTitle($titleVec);
	//parse Info
	parseHackerNewsInfo($infoVec,$points,$comments);

	$result='';
	$i=0;
	foreach($titles as $e){
		$result .= '<div class="entry"><div class="pre">';
		$result .= '<span class="point">'.$points[$i].'</span>'; //points
		$result .= '</div><div class="content">';
		$result .= $titles[$i].'<br/>';	//title $ domain
		$result .= $comments[$i];		//comments 			
		$result .= '</div></div>';
		++$i;
	}
	return $result;
}

function parseHackerNewsTitle($titleVec){
	$i=0;
	foreach($titleVec as $e){
		$e=pq($e);
		if($e['a:last-child']->html()!="More"){ // no More
			pq($e['a'])->addClass('title');
			$titles[$i++]=$e->html();	//title $ domain
		}
	}
	return $titles;
}

function parseHackerNewsInfo($infoVec,&$points,&$comments){
	$i=0;
	foreach($infoVec as $e){
		$points[$i]=parseHackerNewsPoint(pq($e));
		$comments[$i++]=parseHackerNewsComment(pq($e));
	}
}
function parseHackerNewsPoint($item){
	if($item->is(':has(span))')){ //has point
		$item=$item['span'];
		$item=explode(' ',$item->html(),2);
		return $item[0];
	}
	else//no point
		return '•';
}
function parseHackerNewsComment($item){
	if(count($item['a'])==2){	//has comment
		$item=pq($item['a:nth-child(3)']);
		$item->addClass('comments');
		return $item;
	}
	else//no comment
		return '';
}


function redditFormatter($htmlStr){
	$dom=phpQuery::newDocument($htmlStr);
	$entryVec=$dom['div.entry'];
	$pointVec=$dom['div.score.unvoted'];
	//parse points
	parseRedditPoint($pointVec,$points);
	$i=0;
	$result = '';
	foreach($entryVec as $e){
		parseRedditInfo($e,$title,$domain,$comment);

		$result .= '<div class="entry"><div class="pre">';
		$result .= '<span class="point">'.$points[$i++].'</span>'; //points
		$result .= '</div><div class="content">';
		$result .=$title.'&nbsp;'.$domain.'<br/>'; //title & domain
		$result .= $comment;	//comments
		$result .= '</div></div>';
	}
	return $result;
}

function parseRedditPoint($pointVec,&$points){
	$i=0;
	foreach($pointVec as $e){
		$points[$i++]=pq($e)->html();
	}
}

function parseRedditInfo($item,&$title,&$domain,&$comment){
		$e=pq($item);
		$title = $e['p a.title'];
		$domain = $e['p span.domain'];
		$comment = '';

		if($e->is(':has("a.comments")')){ // has comment
			$comment=pq($e['a.comments']);
			$comment->addClass('comments');
			$strs=explode(' ',$comment->html(),2);//get comment num
			if(intval($strs[0][0])==0)// 0 comment
				$comment->html('discuss');
			else    
				$comment->html($strs[0].' comments');
		}
}

?>
