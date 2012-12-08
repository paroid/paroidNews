<?php
include('simple_html_dom.php');
$url='http://stackoverflow.com/?tab=week';
$html=file_get_html($url);
$pattern='/title=\s*\"([\s\S]*?)\"/';
$str=preg_replace($pattern,'',$html);
$html=str_get_html($str);
/*$fp=fopen("res.htm","w");
fwrite($fp,preg_replace($pattern,'',$html));
fclose($fp);*/
$top=$html->find('div.question-summary');
echo '<div id="topQ">';
foreach($top as $e){
    echo '<div class="entry"><div class="SOpre"><span class="vote">'.$e->children(0)->children(0)->children(0)->plaintext.'</span><span class="ans"><span class="ansNum">';
    echo $e->children(0)->children(1)->children(0)->plaintext.'</span>answers</span></div><div class="SOcontent"><span class="qtitle">';
    $title=$e->find('a.question-hyperlink',0);
    $title->href='http://stackoverflow.com'.$title->href;
    echo  $title->outertext.'</span>';
    $tags=$e->children(1)->find('a.post-tag');
    if($tags){
        echo '<br/><span class="tag">';
        foreach($tags as $t){
            $t->href='http://stacjoverflow.com'.$t->href;
            echo $t->outertext;
        }
        echo '</span>';
    }
    echo '</div></div>';
}
echo '</div>';
?>



