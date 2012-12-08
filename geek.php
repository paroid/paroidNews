<?php
include('phpQuery.php');

$url='http://news.ycombinator.com/';
$html=curl_file_get_contents($url);

$url='http://www.reddit.com/r/programming';
$html2=curl_file_get_contents($url);

$url='http://www.reddit.com/r/programmingchallenges';
$html3=curl_file_get_contents($url);

$dom=phpQuery::newDocument($html);
$titleLink=$dom['table table td.title:has(a)'];
$info=$dom['table table td.subtext'];

echo '<div id="geek"><div id="HN"><div class="caption">Hacker News</div><br/>';

$points=array();
$comments=array();
$i=0;
foreach($info as $e){
	$tp=pq($e);
	if($tp->is(':has(span))')){
		$tp=$tp['span'];
		$tp=explode(' ',$tp->html(),2);
		$tp=$tp[0];
	}
	else{
		$tp='•';
	}
	$points[$i]=$tp;
	$tp=pq($e);
	if(count($tp['a'])==2){
		$tp=pq($tp['a:nth-child(3)']);
		$tp->addClass('comments');
	}
	else
		$tp='';
	$comments[$i++]=$tp;
}
$i=0;
foreach($titleLink as $e){
	$e=pq($e);
	if($e['a:last-child']->html()!="More"){
		echo '<div class="entry"><div class="pre">';
		echo '<span class="point">'.$points[$i].'</span>'; //points
		echo '</div><div class="content">';
		pq($e['a'])->addClass('title');
		echo $e->html().'<br/>';	//title $ domain
		if($comments[$i]!=''){
			echo $comments[$i];		//comments 
		}
		echo '</div></div>';
		++$i;
	}
}
echo '</div><hr><br/><div id="RPro"><div class="caption">Reddit Programming</div><br/>';

$dom=phpQuery::newDocument($html2);
$entry=$dom['div.entry'];
$pointDom=$dom['div.score.unvoted'];

$points=array();
$i=0;
foreach($pointDom as $e){
	$points[$i++]=pq($e)->html();
}
$i=0;
foreach($entry as $e){
	echo '<div class="entry"><div class="pre">';
	echo '<span class="point">'.$points[$i++].'</span>'; //points
	echo '</div><div class="content">';
	$e=pq($e);
	echo $e['p a.title:first-child'].'&nbsp;'.$e['p span.domain'].'<br/>'; //title & domain
	if($e->is(':has("a.comments")')){
		$comment=pq($e['a.comments']);
		$comment->addClass('comments');
		$strs=explode(' ',$comment->html(),2);
		if(intval($strs[0][0])==0)
			$comment->html('discuss');
		else    
			$comment->html($strs[0].' comments');
		echo $comment;	//comments
	}
	echo '</div></div>';
}

echo '</div><hr><br/><div id="RCha"><div class="caption">Reddit Challenge</div><br/>';

$dom=phpQuery::newDocument($html3);
$entry=$dom['div.entry'];
$pointDom=$dom['div.score.unvoted'];

$points=array();
$i=0;
foreach($pointDom as $e){
	$points[$i++]=pq($e)->html();
}
$i=0;
foreach($entry as $e){
	echo '<div class="entry"><div class="pre">';
	echo '<span class="point">'.$points[$i++].'</span>'; //points
	echo '</div><div class="content">';
	$e=pq($e);
	echo $e['p a.title:first-child'].'&nbsp;'.$e['p span.domain'].'<br/>';
	if($e->is(':has("a.comments")')){
		$comment=pq($e['a.comments']);
		$comment->addClass('comments');
		$strs=explode(' ',$comment->html(),2);
		if(intval($strs[0][0])==0)
			$comment->html('discuss');
		else    
			$comment->html($strs[0].' comments');
		echo $comment;
	}
	echo '</div></div>';
}

echo '</div></div>';
//$html3->clear();
?>
