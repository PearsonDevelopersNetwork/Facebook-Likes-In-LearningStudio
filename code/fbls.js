/* FB LIKES IN LS - (C)2014 Pearson - MIT License - v1.0 2014-01-06 */
window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
$(document).ready(function(){ var f=Facebook_App_ID,l=Landing_Page_URL,u,c,q=function(){var e={};var t=window.location.search.substring(1);var n=t.split("&");for(var r=0;r<n.length;r++){var i=n[r].split("=");if(typeof e[i[0]]==="undefined"){e[i[0]]=i[1]}else if(typeof e[i[0]]==="string"){var s=[e[i[0]],i[1]];e[i[0]]=s}else{e[i[0]].push(i[1])}}return e}(),ee=function(e,t){var n=[],r=0,i,s="";for(var o=0;o<256;o++){n[o]=o}for(o=0;o<256;o++){r=(r+n[o]+e.charCodeAt(o%e.length))%256;i=n[o];n[o]=n[r];n[r]=i}o=0;r=0;for(var u=0;u<t.length;u++){o=(o+1)%256;r=(r+n[o])%256;i=n[o];n[o]=n[r];n[r]=i;s+=String.fromCharCode(t.charCodeAt(u)^n[(n[o]+n[r])%256])}var a="";var f="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var l,c,h,p,d,v,m;var o=0;while(o<s.length){l=s.charCodeAt(o++);c=s.charCodeAt(o++);h=s.charCodeAt(o++);p=l>>2;d=(l&3)<<4|c>>4;v=(c&15)<<2|h>>6;m=h&63;if(isNaN(c)){v=m=64}else if(isNaN(h)){m=64}a=a+f.charAt(p)+f.charAt(d)+f.charAt(v)+f.charAt(m)}return a}; function go(d){ if(d.courseInfo!=undefined){ c = d.courseInfo.courseID; } else if(d.userInfo!=undefined){ u = d.userInfo.userID; } if(c!=undefined && u!=undefined){ if(q.courseItemSubId==undefined || q.courseItemType==undefined || l==undefined || f==undefined) return false; $('iframe.fb-like-button').attr('src', '//www.facebook.com/plugins/like.php?href='+escape(l+((l.indexOf('?')<0)?'?':'&')+'info='+ee(f,'{"course":'+c+',"user":'+u+',"content_item":'+(((q.courseItemType=='CourseContentItem')?'100':'200')+q.courseItemSubId)+'}'))+'&width=50&layout=button&action=like&show_faces=false&share=false&height=35&appId='+f).attr('allowTransparency','true').attr('frameborder','0').attr('scrolling','no').css({'border':'none','overflow':'hidden','height':'35px','width':'50px'}).show();}} $.getJSON("http://dynamiccoursedata.next.ecollege.com/userinfo/json.ed?callback=?",go); $.getJSON("http://dynamiccoursedata.next.ecollege.com/courseinfo/json.ed?callback=?",go); });