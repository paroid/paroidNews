<?php
include('phpQuery.php');
$url='http://stackoverflow.com/?tab=week';
$html=curl_file_get_contents($url);
$hotQuestionDiv = hotQuestionFormater($html);

$questionHeader = '<div id="topQ">';
$footer = '</div>';

echo $questionHeader.$hotQuestionDiv.$footer;

class questionEntry{
	public $title;
	public $vote;
	public $answer;
	public $tags;
}

function hotQuestionFormater($htmlStr){
	$dom=phpQuery::newDocument($htmlStr);
	$entryVec = $dom['div.question-summary'];
	$entrys = parseQuestionEntrys($entryVec);

	$result = '';
	foreach($entrys as $e){
		$result .= '<div class="entry"><div class="SOpre"><span class="vote">'.$e->vote.'</span>';
		$result .= '<span class="ans"><span class="ansNum">'.$e->answer.'</span>answers</span></div>';
		$result .= '<div class="SOcontent"><span class="qtitle">'.$e->title.'</span>';
		if($e->tags != '')
			$result .= '<br/><span class="tag">'.$e->tags.'</span>';
		$result .= '</div></div>';
	}
	return $result;
}
function parseQuestionEntrys($entryVec){
	$i=0;
	foreach($entryVec as $e){
		$e=pq($e);
		$entrys[$i] = new questionEntry();
		$entrys[$i]->vote = $e['div.votes>div.mini-counts']->html();
		$entrys[$i]->answer = $e['div.status>div.mini-counts']->html();
		$entrys[$i]->title = $e['div.summary a.question-hyperlink'];
		$entrys[$i]->tags = '';
		if($e->is(':has("a.post-tag")')){
			$tags=$e['a.post-tag'];
			foreach($tags as $t)
				$entrys[$i]->tags .= pq($t);
		}
		++$i;
	}
	return $entrys;
}
?>


