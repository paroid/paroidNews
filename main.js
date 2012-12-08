var tab='geek';
var Geek=null;
var Sports=null;
var SO=null;
var gr=false;
var sr=false;
var sor=false;


function loadGeek(){
    $('#news').fadeOut().hide();
    $('#loading').show();
	if(gr && tab!='geek'){
		$('#news').empty().append(Geek);
		$('#loading').hide('fast');
		$('#news').fadeIn('fast');
	}
	else{
		$('#news').load('geek.php',function(){
			$('#loading').hide('fast');
			$('#news').fadeIn('fast');
			$('#HN a,#Reddit a').attr({target:'_blank'});
			Geek=$('#geek');
			gr=true;
		});
	}
	tab='geek';
}
function loadSports(){
    $('#news').fadeOut().hide();
    $('#loading').show();
	if(sr && tab!='sports'){
		$('#news').empty().append(Sports);
		qqtx();
		$('#loading').hide('fast');
		$('#news').fadeIn('fast');
	}
	else{
		$('#news').load('sports.php',function(){
			$('#loading').hide('fast');
			$('#news').fadeIn('fast');
			$('#sports a').attr('href',function(){
				var link=$(this).attr('href');
				if(link.substr(0,4)!='http')
					return 'http://www.zhibo8.cc'+link;
				return link;
			});
			$('.lists a:last-child').prev('a').andSelf().remove();
			qqtx();
			Sports=$('#sports');
			sr=true;
	    });
	}
	tab='sports';
}

function loadSO(){
    $('#news').fadeOut().hide();
    $('#loading').show();
	if(sor && tab!='stackOverflow'){
		$('#news').empty().append(SO);
		$('#loading').hide('fast');
		$('#news').fadeIn('fast');
	}
	else{
		$('#news').load('topQ.php',function(){
			$('#loading').hide('fast');
			$('#news').fadeIn('fast');
			$('#topQ a').attr({target:'_blank'});
			SO=$('#topQ');
			sor=true;
	    });
	}
	tab='stackOverflow';
}

function trim(s) { 
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," "); 
    s = s.replace(/\n /,"\n"); return s;
}

function qqtx(){
	$(".lists").each(function(index, element) {
		$(this).hover(function(e) {
			var date = $(this).parent().children('h2').html();
			date = date.split('月');
			date = new Date().getFullYear()+"-"+date[0]+"-"+date[1].split('日')[0];
			var str = $(this).html();
			str = str.toLowerCase();
			str = str.split("<a")[0];
			time = str.split(" ")[0];
			title = str.replace(time,"");
			title = title.replace(/<[^>]+>/g,"");
			title ="<< "+ trim(title)+" >> 直播即将开始 ...."
			var isIE=!!window.ActiveXObject;
			var isIE6=isIE&&!window.XMLHttpRequest;
			if(isIE6){
				$(this).append(' <a class="qqtx"  style="display:inline-block !important;background:#126b05; color:#fff; padding:1px 5px; heigth:20px;line-height:20px;" href="http://qzs.qq.com/snsapp/app/bee/widget/open.htm?content='+encodeURIComponent(title)+'&time='+encodeURIComponent(date+" "+time)+'&advance=5" target="_blank" title="">QQ提醒</a>');
			}else{
				$(this).append('<a class="qqtx"  style="display:inline-block !important;background:#126b05; color:#fff; padding:1px 5px; heigth:20px;line-height:20px;" href="http://qzs.qq.com/snsapp/app/bee/widget/open.htm?content='+encodeURIComponent(title)+'&time='+encodeURIComponent(date+" "+time)+'&advance=5" target="_blank" title="">QQ提醒</a>');
			}
		},function(e) {
			$(this).children(".qqtx").remove();			
		});
	});
}

function toTop () {
	$('html, body').animate({scrollTop:0}, 'slow');
}

$(document).scroll(function () {
    if ($(this).scrollTop() > 256) {
		$("#top").css({'display':'block'});
    }else{
		$("#top").css({'display':'none'}).blur();
	}		        
});
$(document).bind("mousewheel",function(e){$('html,body').stop()}); 	

jQuery(document).ready(function($){
    $('#HN a,#RPro a,#RCha a').attr({target:'_blank'});
	$('#RCha a').attr('href',function(){
		var link=$(this).attr('href');
		if(link.substr(0,4)!='http')
			return 'http://www.reddit.com'+link;
		return link;
	});
	Geek=$('#geek');
	gr=true;
	$('#tmp').load('sports.php',function(){
		$('#loading').hide('fast');
		$('#news').fadeIn('fast');
		$('.lists a:last-child').prev('a').andSelf().remove();
		$('#sports a').attr('href',function(){
			var link=$(this).attr('href');
			if(link.substr(0,4)!='http')
				return 'http://www.zhibo8.cc'+link;
			return link;
		});
		Sports=$('#sports');
		sr=true;
		$('#tmp').empty();
	});
	$('#tmp').load('topQ.php',function(){
		$('#loading').hide('fast');
		$('#news').fadeIn('fast');
		$('#topQ a').attr({target:'_blank'});
		SO=$('#topQ');
		sor=true;
		$('#tmp').empty();
	});
});

