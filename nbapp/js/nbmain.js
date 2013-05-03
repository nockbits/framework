/* NB- Main JS | nockbits.com
 * Ver 1.0 | 2012-09-20
 * Example:
 * $nb.urlReq="http://localhost/test/simple_ajax_text.php";
 * $nb.htmlResId="result";
 * $nb.formReq="f1";
 * obj=[
 *      {"c":"Authorization","v":"GoogleLogin auth=1"},
 *      {"c":"Authorization-SSL","v":"GoogleLoginSSL auth=21"}
 *		];
 *	$nb.moreHead=obj;
 *	$nb.xmlcall();
 *	
 *	Onload call ajax functions:
 *	function func1() { alert("This is the first."); }
 *	function func2() { alert("This is the second."); }
 *	$nb.xmlonload(func1);
 *	$nb.xmlonload(func2);
 *	$nb.xmlonload(function() {
 *    document.body.style.backgroundColor = '#EFDF95';  
 *  });
 **/
var sampleobj;
(function( window, undefined ) {
	var nbjs={
		xmlHttpReq:false,
		urlReq:false,
		formReq:false,
		qrString:false,
		resType:false,
		moreHead:false,
    htmlResId:false,
    msgspeed:2,
    ajxMsg:"Please wait, processing your request...",
    ajxErr:"Sorry, the service your trying to reach is currently not responding.<br\/>Kindly try again later.",
		logger:{},
		abtNbjs:{ title:"Custom JS V 1.0", version:"1.0",build:"production", uidl:"a787ed5cfaa3153b268cc2dcd56cf614" },
		xmlreq:function(){
			this.xmlHttpReq=false;
			if (window.XMLHttpRequest){ this.xmlHttpReq = new XMLHttpRequest(); this.logger.reg="success";}
			else if (window.ActiveXObject){ this.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP"); this.logger.reg="success";}
			else{ alert("[Ooops!]Sorry, your browser does not support AJAX...!!"); this.logger.reg="failure";}
		},
		xmlhead:function(){		
			this.logger.responsetype=this.resType;
			if(this.resType=='json'){
				this.xmlHttpReq.setRequestHeader("Content-Type","application/json");
				this.xmlHttpReq.setRequestHeader("Accept","application/json");
			}if(this.resType=='xml'){
				this.xmlHttpReq.setRequestHeader("Content-Type","text/xml");
				this.xmlHttpReq.setRequestHeader("Accept","text/xml");
			}else{
				this.xmlHttpReq.setRequestHeader("Content-Type","text/plain; charset=utf-8");
				this.xmlHttpReq.setRequestHeader("Accept","text/plain; charset=utf-8");
			}		
      this.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			if(this.moreHead){
				this.xmlcusthead();
			}
		},
		xmlcusthead:function(){		
			var len=this.moreHead.length;
			for(var i=0;i<len;i++){
				this.xmlHttpReq.setRequestHeader(this.moreHead[i].c,this.moreHead[i].v);
			}
		},
		xmlpost:function(){
			if(this.qrString){ return this.qrString;}
			var form=this.elem(this.formReq);
			var qstr='';
      var len=form.length;
      if(len > 0){
        for(i=0; i<len; i++){
          fld=form.elements[i].name;
          val=form.elements[i].value;
          if(fld) qstr+=fld+'='+escape(val)+'&';
        }
        qstr=qstr.slice(0, -1);
      }else{
        qstr=null;
      }
			this.logger.querystr=qstr;
			return qstr;
		},
		elem:function(id){
			return document.getElementById(id);
		},
    elemname:function(id){
			return document.getElementsByName(id);
		},
    elemtagname:function(id){
			return document.getElementsByTagName(id);
		},
    elemclass:function(id){
      var hasClassName = new RegExp("(?:^|\\s)" + id + "(?:$|\\s)");
      var allElements = this.elemtagname("*");
      var results = [];
      var element;
      for (var i = 0; (element = allElements[i]) != null; i++) {
        var elementClass = element.className;
        if (elementClass && elementClass.indexOf(id) != -1 && hasClassName.test(elementClass))
          results.push(element);
      }
      return results; 
		},
    toggle:function(id){
      var e = this.elem(id);
      var chk = (e.style.display) || false;
      if(chk == 'block' || chk == false){
        e.style.display = 'none';
      }else{
       e.style.display = 'block';
      }
    },
		xmlcall:function(){
			var self=this;
			this.xmlreq();
			this.xmlHttpReq.open('POST', this.urlReq, true);
			this.xmlhead();
			this.xmlHttpReq.onreadystatechange = function(){
				if (self.xmlHttpReq.readyState==4 && self.xmlHttpReq.status==200){
					self.elem(self.htmlResId).innerHTML=self.xmlHttpReq.responseText;
				}else if(self.xmlHttpReq.readyState==1 || self.xmlHttpReq.readyState==2 || self.xmlHttpReq.readyState==3){
					self.elem(self.htmlResId).innerHTML=self.xmlajxmsg(self.ajxMsg);
				}else{
          self.elem(self.htmlResId).innerHTML=self.xmlajxmsg(self.ajxErr);
        }
			}
      this.xmlHttpReq.send(this.xmlpost());		
		},
		xmlonload:function(func) {
			var oldonload = window.onload;
			if (typeof window.onload != 'function') {
				window.onload = func;
			} else {
				window.onload = function() {
				  if (oldonload) {
					oldonload();
				  }
				  func();
				}
			}
		},
    xmlajxmsg:function(msg){
      var info = '';
      info += '<div id="loadme" style="-moz-border-radius:15px;border-radius:15px;position:absolute;top:25%;left:35%;right:5px;background-color:#F6F6F6;width:375px;height:80px;display:block;font-family: Lucida Grande, Verdana, Sans-serif; border:3px solid #EEEEEE; padding: 25px 10px 5px 10px;">';	
      info += '<div align="center" style="padding:3px;width:100%;color:#444444;font-size:12px;font-weight:bold;">'+msg+'</div>';
      info += '<div align="center" style="width:100%;"><img src="./images/loader.gif"\/></div>';
      info +='</div>';		
      return info; 
    },
    openbox:function(id){
      sampleobj= sampleobj || this.elem(id);
      var Speed = this.msgspeed || 2;
      if(!sampleobj.h) sampleobj.h = h;  
      var h=(sampleobj.style.height)||(sampleobj.offsetHeight);h=parseInt(h);
      sampleobj.style.height=(h+Speed)+'px';
      if (h<(sampleobj.h-Speed)){TO=setTimeout(function(){ $nb.openbox() },5); }
    },
    closebox:function(id){
      sampleobj= sampleobj || this.elem(id);
      var Speed = this.msgspeed || 2;
      var h=(sampleobj.style.height)||(sampleobj.offsetHeight);h=parseInt(h);
      sampleobj.style.height=(h-Speed)+'px';
      if (h>Speed){TO=setTimeout(function(){ $nb.closebox() },5); } else {sampleobj.style.display="none";}
    },
    slideboxin:function(id){
      sampleobj= sampleobj || this.elem(id);
      var Speed = this.msgspeed || 0;
      var h=(sampleobj.style.width)||(sampleobj.offsetWidth);h=parseInt(h);
      if(!sampleobj.h) sampleobj.h = h;      
      sampleobj.style.width=(h-Speed)+'px';
      if (h>Speed){TO=setTimeout(function(){ $nb.slideboxin() },5); } else {sampleobj.style.display="none";}
    },
    slideboxout:function(id){
      sampleobj= sampleobj || this.elem(id);
      if(sampleobj.style.display != "block") sampleobj.style.display="block";
      var Speed = this.msgspeed || 0;
      var h=(sampleobj.style.width)||(sampleobj.offsetWidth);h=parseInt(h);       
      if (h<(sampleobj.h-Speed)){
        sampleobj.style.width=(h+Speed)+'px';
        TO=setTimeout(function(){ $nb.slideboxout() },5); 
      }
    },
    debug:function(msg){
      
    }
	};
	//expose it to the global object
	window.$nb=nbjs;
})(window);

/*********************
	redirect page - page redirects supporting all browsers
	@param = string
*********************/
function redpage(url){/*alert('->'+url);*/
	if(url != ""){
		var browser_type=navigator.appName
		var browser_version=parseInt(navigator.appVersion)
		if (browser_type=="Netscape"&&browser_version>=4){
			//if NS 4+	
			window.location.replace(url);
		}else if (browser_type=="Microsoft Internet Explorer"&&browser_version>=4){
			//if IE 4+	
			window.location.replace(url);
		}else{
			//Default goto page (NOT NS 4+ and NOT IE 4+)	
			window.location=url;	
		}
	}
}

/*********************
	confDelete - Confirm Delete
	@param = string
*********************/
function confDelete(delUrl){
	if(delUrl != ""){
		if (confirm("[INFORMATION] Are you sure you want to delete this record?")) {
      redpage(delUrl);
    }
	}
  return false;
}


