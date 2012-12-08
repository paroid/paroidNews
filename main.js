var tab='geek';
var Geek=null;
var Sports=null;
var SO=null;
var gr=false;
var sr=false;
var sor=false;

/*tipTip Library*/
(function($){$.fn.tipTip=function(options){var defaults={activation:"hover",keepAlive:false,maxWidth:"500px",edgeOffset:3,defaultPosition:"bottom",delay:400,fadeIn:200,fadeOut:200,attribute:"tip",content:false,enter:function(){},exit:function(){}};var opts=$.extend(defaults,options);if($("#tiptip_holder").length<=0){var tiptip_holder=$('<div id="tiptip_holder" style="max-width:'+opts.maxWidth+';"></div>');var tiptip_content=$('<div id="tiptip_content"></div>');var tiptip_arrow=$('<div id="tiptip_arrow"></div>');$("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')))}else{var tiptip_holder=$("#tiptip_holder");var tiptip_content=$("#tiptip_content");var tiptip_arrow=$("#tiptip_arrow")}return this.each(function(){var org_elem=$(this);if(opts.content){var org_title=opts.content}else{var org_title=org_elem.attr(opts.attribute)}if(org_title!=""){if(!opts.content){/*org_elem.removeAttr(opts.attribute)*/}var timeout=false;if(opts.activation=="hover"){org_elem.hover(function(){active_tiptip()},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}else if(opts.activation=="focus"){org_elem.focus(function(){active_tiptip()}).blur(function(){deactive_tiptip()})}else if(opts.activation=="click"){org_elem.click(function(){active_tiptip();return false}).hover(function(){},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}function active_tiptip(){opts.enter.call(this);tiptip_content.html(org_title);tiptip_holder.hide().removeAttr("class").css("margin","0");tiptip_arrow.removeAttr("style");var top=parseInt(org_elem.offset()['top']);var left=parseInt(org_elem.offset()['left']);var org_width=parseInt(org_elem.outerWidth());var org_height=parseInt(org_elem.outerHeight());var tip_w=tiptip_holder.outerWidth();var tip_h=tiptip_holder.outerHeight();var w_compare=Math.round((org_width-tip_w)/2);var h_compare=Math.round((org_height-tip_h)/2);var marg_left=Math.round(left+w_compare);var marg_top=Math.round(top+org_height+opts.edgeOffset);var t_class="";var arrow_top="";var arrow_left=Math.round(tip_w-12)/2;if(opts.defaultPosition=="bottom"){t_class="_bottom"}else if(opts.defaultPosition=="top"){t_class="_top"}else if(opts.defaultPosition=="left"){t_class="_left"}else if(opts.defaultPosition=="right"){t_class="_right"}var right_compare=(w_compare+left)<parseInt($(window).scrollLeft());var left_compare=(tip_w+left)>parseInt($(window).width());if((right_compare&&w_compare<0)||(t_class=="_right"&&!left_compare)||(t_class=="_left"&&left<(tip_w+opts.edgeOffset+5))){t_class="_right";arrow_top=Math.round(tip_h-13)/2;arrow_left=-12;marg_left=Math.round(left+org_width+opts.edgeOffset);marg_top=Math.round(top+h_compare)}else if((left_compare&&w_compare<0)||(t_class=="_left"&&!right_compare)){t_class="_left";arrow_top=Math.round(tip_h-13)/2;arrow_left=Math.round(tip_w);marg_left=Math.round(left-(tip_w+opts.edgeOffset+5));marg_top=Math.round(top+h_compare)}var top_compare=(top+org_height+opts.edgeOffset+tip_h+8)>parseInt($(window).height()+$(window).scrollTop());var bottom_compare=((top+org_height)-(opts.edgeOffset+tip_h+8))<0;if(top_compare||(t_class=="_bottom"&&top_compare)||(t_class=="_top"&&!bottom_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_top"}else{t_class=t_class+"_top"}arrow_top=tip_h;marg_top=Math.round(top-(tip_h+5+opts.edgeOffset))}else if(bottom_compare|(t_class=="_top"&&bottom_compare)||(t_class=="_bottom"&&!top_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_bottom"}else{t_class=t_class+"_bottom"}arrow_top=-12;marg_top=Math.round(top+org_height+opts.edgeOffset)}if(t_class=="_right_top"||t_class=="_left_top"){marg_top=marg_top+5}else if(t_class=="_right_bottom"||t_class=="_left_bottom"){marg_top=marg_top-5}if(t_class=="_left_top"||t_class=="_left_bottom"){marg_left=marg_left+5}tiptip_arrow.css({"margin-left":arrow_left+"px","margin-top":arrow_top+"px"});tiptip_holder.css({"margin-left":marg_left+"px","margin-top":marg_top+"px"}).attr("class","tip"+t_class);if(timeout){clearTimeout(timeout)}timeout=setTimeout(function(){tiptip_holder.stop(true,true).fadeIn(opts.fadeIn)},opts.delay)}function deactive_tiptip(){opts.exit.call(this);if(timeout){clearTimeout(timeout)}tiptip_holder.fadeOut(opts.fadeOut)}}})}})(jQuery);

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
			$('#HN a,#RPro a,RCha a').attr({target:'_blank'});
			$('#HN a').attr('href',function(){
				var link=$(this).attr('href');
				if(link.substr(0,4)!='http')
					return 'http://news.ycombinator.com/'+link;
				return link;
			});
			$('#RPro a,#RCha a').attr('href',function(){
				var link=$(this).attr('href');
				if(link.substr(0,4)!='http')
					return 'http://www.reddit.com'+link;
				return link;
			});
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
		$('#topQ .qtitle a').tipTip();
	}
	else{
		$('#news').load('topQ.php',function(){
			$('#loading').hide('fast');
			$('#news').fadeIn('fast');
			$('#topQ a').attr({target:'_blank'});
			$('#topQ a').attr('href',function(){
				var link=$(this).attr('href');
				if(link.substr(0,4)!='http')
					return 'http://stackoverflow.com'+link;
				return link;
			});
			setTip();
			SO=$('#topQ');
			$('#topQ .qtitle a').tipTip();
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

function setTip () {
	$('#topQ .qtitle a').attr('title',function(){
		var title=$(this).attr('title');
		title=title.replace(/\n/g,'<br/>');
		title=title.replace(/ /g,'&nbsp;');
		return title;
	});
	$('#topQ .qtitle a').attr('tip',function(){
		return $(this).attr('title');
	});
	$('#topQ .qtitle a').removeAttr('title');
}


jQuery(document).ready(function($){
	$('#top a').tipTip({defaultPosition:'top',delay:200});
    $('#HN a,#RPro a,#RCha a').attr({target:'_blank'});
	$('#HN a').attr('href',function(){
		var link=$(this).attr('href');
		if(link.substr(0,4)!='http')
			return 'http://news.ycombinator.com/'+link;
		return link;
	});
	$('#RPro a,#RCha a').attr('href',function(){
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
		$('#topQ a').attr('href',function(){
			var link=$(this).attr('href');
			if(link.substr(0,4)!='http')
				return 'http://stackoverflow.com'+link;
			return link;
		});
		setTip();
		SO=$('#topQ');
		sor=true;
		$('#tmp').empty();
	});
});

