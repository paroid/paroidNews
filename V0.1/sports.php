<?php
include('simple_html_dom.php');
$url='http://www.zhibo8.cc/';
$html=file_get_html($url);
$top=$html->find('div[id=top10] div[class=box]');
$res=$html->find('div[id=left] div[class=box]');
echo '<div id="sports">';
echo '<div id="video"><h2>足球视频</h2><hr>';
echo $top[0]->children(0)->children(0)->outertext;
echo '<h2>篮球视频</h2><hr>';
echo $top[1]->children(0)->children(0)->outertext;
echo '</div><hr><div id="live"><h2 class="title">直播表</h2>';
foreach($res as $e){
    $list=$e->children(1)->children(0)->find('li');
	if($list==null || $e->children(1)->children(0)->find('b')==null)
		continue;
    echo '<div class="day"><hr>'.$e->children(0)->children(0)->outertext.'<hr>';
    $i=0;
    foreach($list as $li){
        if($li->find('b')){
            if($i++>0)
                echo '<hr class="dash">';
            echo '<div class="lists">';
            echo $li->innertext;
            echo'</div>';
        }
	}
	echo '</div>';
}
echo '</div></div>';
?>


