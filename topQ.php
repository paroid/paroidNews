<?php
include('phpQuery.php');
$url='http://stackoverflow.com/?tab=week';
$html=curl_file_get_contents($url);
$dom=phpQuery::newDocument($html);
$entry=$dom['div.question-summary'];
echo '<div id="topQ">';
foreach($entry as $e){
	$e=pq($e);
	echo '<div class="entry"><div class="SOpre"><span class="vote">'.$e['div.votes>div.mini-counts']->html().'</span><span class="ans"><span class="ansNum">';
	echo $e['div.status>div.mini-counts']->html().'</span>answers</span></div><div class="SOcontent"><span class="qtitle">';
	echo  $e['div.summary a.question-hyperlink'].'</span>';
	if($e->is(':has("a.post-tag")')){
		$tags=$e['a.post-tag'];
		echo '<br/><span class="tag">';
		foreach($tags as $t){
			echo pq($t);
		}
		echo '</span>';
	}
    echo '</div></div>';
}
echo '</div>';
?>


