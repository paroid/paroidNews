<?php
include('simple_html_dom.php');

$url='http://news.ycombinator.com/';
$html=file_get_html($url);

$url='http://www.reddit.com/r/programming';
$html2=file_get_html($url);

$url='http://www.reddit.com/r/programmingchallenges';
$html3=file_get_html($url);

$res=$html->find('table table td[class=title]');
$comm=$html->find('table table td[class=subtext]');
$i=0;
echo '<div id="geek"><div id="HN"><div class="caption">Hacker News</div><br/>';
foreach($res as $e){
    if($e->find('a') && $e->children(0)->plaintext!='More'){
        echo '<div class="entry"><div class="pre">';
        $p=$comm[$i]->find('span');
        if($p){
            $point=explode(' ',$comm[$i]->children(0)->plaintext,2);
            $point=$point[0];        
            echo '<span class="point">'.$point.'</span>';
        }
        else
            echo '<span class="point">•</span>';

        echo '</div><div class="content">';
        $a=$comm[$i]->find('a',1);
        $e->children(0)->class='title';
        if($a){
            $val='http://news.ycombinator.com/'.$a->href;
            $a->href=$val;
            $a->class='comments';
            echo $e->innertext.'<br/>';            
            echo $a->outertext;
        }
        else{
            $val=$e->children(0)->href;
            if(substr($val,0,4)!='http')
                $e->children(0)->href='http://news.ycombinator.com/'.$val;
            echo $e->innertext;
        }
        echo '</div></div>';
        ++$i;
    }
}
$html->clear();
echo '</div><hr><br/><div id="RPro"><div class="caption">Reddit Programming</div><br/>';


$res=$html2->find('div[class^=entry]');
$points=$html2->find('div[class=score unvoted]');
$j=0;
foreach($res as $e){
    echo '<div class="entry"><div class="pre">';
    echo '<span class="point">'.$points[$j++]->plaintext.'</span>';
    echo '</div><div class="content">';
    echo $e->children(0)->children(0)->outertext.'&nbsp;';
    echo $e->children(0)->children(1)->outertext.'<br/>';
    $comm=$e->find('a[class^=comments]',0);
    if($comm){
        $strs=explode(' ',$comm->plaintext,2);
        if(intval($strs[0][0])==0)
            $comm->plaintext='discuss';
        else    
            $comm->plaintext=$strs[0].' comments';
        echo '<a class="comments" href="'.$comm->href.'" >'.$comm->plaintext."</a>";
    }
    echo '</div></div>';
}
$html2->clear();
echo '</div><hr><br/><div id="RCha"><div class="caption">Reddit Challenge</div><br/>';


$res=$html3->find('div[class^=entry]');
$points=$html3->find('div[class=score unvoted]');
$j=0;
foreach($res as $e){
    echo '<div class="entry"><div class="pre">';
    echo '<span class="point">'.$points[$j++]->plaintext.'</span>';
    echo '</div><div class="content">';
    echo $e->children(0)->children(0)->outertext.'&nbsp;';
    echo $e->children(0)->children(1)->outertext.'<br/>';
    $comm=$e->find('a[class^=comments]',0);
    if($comm){
        $strs=explode(' ',$comm->plaintext,2);
        if(intval($strs[0][0])==0)
            $comm->plaintext='discuss';
        else    
            $comm->plaintext=$strs[0].' comments';
        echo '<a class="comments" href="'.$comm->href.'" >'.$comm->plaintext."</a>";
    }
    echo '</div></div>';
}

echo '</div></div>';
$html3->clear();
?>
