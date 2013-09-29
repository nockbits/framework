/* -----------------------------------------------------------------------------------
 * @file: App Js
 * @descp:  This is a custom JS app function for the NBapp
 * @dependency: jquery 1.10 
 * @date: 01-09-2013
 * @author: Austin Noronha
 * -----------------------------------------------------------------------------------
 */

var nbapp = {};
nbapp.conf = {
  ajxMsg:"Please wait, processing your request...",
  ajxErr:"Sorry, the service your trying to reach is currently not responding.<br\/>Kindly try again later.",
  abtNbjs:{title:"NBAPP Custom JS V 1.0", version:"1.0",build:"production", uidl:"a787ed5cfaa3153b268cc2dcd56cf614"},
  baseurl:""
};

nbapp.functions = {
  callAjax: function(url,callback,formName,formValuesPost){
    if(!url) return;
    formValuesPost = formValuesPost || false;
    var formValues;
    if(formValuesPost){
      formValues = formValuesPost;
    }else{
      formValues = (formName) ? $("#"+formName).serialize() : '';
    }
    url += (url.indexOf("?") !== -1) ? "&ajaxmode=1":"?ajaxmode=1";
    var custHeaders = {};
    //custHeaders["Content-type"] = "application/x-www-form-urlencoded";
    
    var that=this;
    var ajaxSetup = {
      url: url,
      cache:false,
      data:formValues,
      type: "POST",
      headers:custHeaders,
      /*dataType: "json",*/
      beforeSend: function(){
        that.ajxShowMsgBox(nbapp.conf.ajxMsg);
      },
      success: function(data,textStatus,jqXHR){
        that.ajxClearMsgBox();
        callback(data);
      },
      error: function(jqXHR,textStatus,errorThrown){
        console.log("[error] textStatus",textStatus,errorThrown);
        that.ajxShowMsgBox(nbapp.conf.ajxErr);
        setTimeout(function(){that.ajxClearMsgBox();}, 4000);
      },
      complete: function(){
        
      }
    };
    $.ajax(ajaxSetup);
  },
  ajxMsgBox:function(msg){
    var info = '';
    info += '<div id="loadme">';	
    info += '<div align="center">'+msg+'</div>';
    info += '<div align="center" style="width:100%;"><img src="./images/nbapploader.gif"\/></div>';
    info +='</div>';		
    return info; 
  },
  modalMsgBox:function(msg,type){
    type = type || "Information";
    var info = '';
    var boxclass = ""
    if(type == "Error") boxclass = "fontred";
    if(type == "Success") boxclass = "fontgreen";
    
    info += '<div id="loadme" class="'+boxclass+'">';	
    info += '<div align="center"><b>'+type+'</b></div>';
    info += '<div align="center">'+msg+'</div><br\/>';
    info += '<div align="center" style="width:100%;"><input class="button-submit" type="button" value="Close" onclick="return nbapp.functions.ajxClearMsgBox();"\/></div>';
    info +='</div>';		
    return info; 
  },
  confirmMsgBox:function(msg,redUrl){
    var info = '';
    info += '<div id="loadme">';	
    info += '<div align="center"><b>[Confirm]</b></div>';
    info += '<div align="center">'+msg+'</div><br\/>';
    info += '<div align="center" style="width:100%;">';
    info += '<input class="button-submit" type="button" value="Ok" onclick="return nbapp.functions.redpage(\''+redUrl+'\');"\/>&nbsp;&nbsp;';
    info += '<input class="button-submit" type="button" value="Cancel" onclick="return nbapp.functions.ajxClearMsgBox();"\/>';
    info += '</div>';
    info +='</div>';		
    return info; 
  },
  ajxShowMsgBox:function(msg){
    var info = this.ajxMsgBox(msg);
    $('#lightbox').show();
    $(".screenboxcont").html("");
    $(".screenboxcont").html(info).find("#loadme").animate({top:"+=24%",opacity:1}, "slow", "swing", function(){});    
    return; 
  },
  ajxShowModalMsgBox:function(msg,type){
    var info = this.modalMsgBox(msg,type);
    $('#lightbox').show();
    $(".screenboxcont").html("");
    $(".screenboxcont").html(info).find("#loadme").animate({top:"+=24%",opacity:1}, "slow", "swing", function(){});    
    return; 
  },
  ajxClearMsgBox:function(){
    var info = '';	
    $(".screenboxcont").find("#loadme").animate({top:"-=24%",opacity:0}, "slow", "swing", function(){
      $(".screenboxcont").html(info);
      $('#lightbox').hide();
    });
    return; 
  },
  ajxClearMsgBoxFast:function(){
    var info = '';	
	$(".screenboxcont").html(info);
	$('#lightbox').hide();
    return; 
  },	
 attachFuncOnload:function(func) {
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
  redpage: function(url){
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
  },
  confDelete: function(delUrl){
    if(delUrl != ""){
      var msg = "Are you sure you want to delete this record?";
      var info = this.confirmMsgBox(msg,delUrl);
      $('#lightbox').show();
      $(".screenboxcont").html("");
      $(".screenboxcont").html(info).find("#loadme").animate({top:"+=24%",opacity:1}, "slow", "swing", function(){});    
      return; 
      
    }
    return false;
  },
  borderBox: function(obj,color){
    color = color || "#E53310";
    obj.css("border-color",color); 
    return;
  },
  shakeBox: function(obj){
    var shakeMar = "10px";
    obj.animate({"margin-left":"+="+shakeMar}, "slow", "swing", function(){})
       .animate({"margin-left":"-="+shakeMar}, "slow", "swing", function(){})
       .animate({"margin-left":"+="+shakeMar}, "slow", "swing", function(){})
       .animate({"margin-left":"-="+shakeMar}, "slow", "swing", function(){}); 
    return;
  },
  scrollTop: function(position){
    position = position || 30;
    $('html,body').animate({scrollTop: position}, 1000);
    return;
  },
  sizeOfArr : function(obj) {
      var size = 0, key;
      for (key in obj) {
          if (obj.hasOwnProperty(key)) size++;
      }
      return size;
  }
};


nbapp.modLogin = {
  formName: "frmLogin",
  validate: function(){
    var usr = $("#" + this.formName).find("#txtUsername");
    var pwd = $("#" + this.formName).find("#txtPassword");
    
    if(usr.val().length <= 3){
      nbapp.functions.borderBox(usr);
      nbapp.functions.shakeBox(usr);
      nbapp.functions.ajxShowModalMsgBox("Please enter a valid username", "Error");
      return false;
    }else{
      nbapp.functions.borderBox(usr,"#97AC77");
    } 
    
    if(pwd.val().length <= 3){
      nbapp.functions.borderBox(pwd);
      nbapp.functions.shakeBox(pwd);
      nbapp.functions.ajxShowModalMsgBox("Please enter a valid password", "Error");
      return false;
    }else{
      nbapp.functions.borderBox(pwd,"#97AC77");
    } 
    
    //server call
    var url= nbapp.conf.baseurl + "index.php?func=login";
    var formName = "frmLogin";
    var callback = function(data){
      var res = JSON.parse(data);
      if(res.nbapp.status == "Failure"){
        nbapp.functions.borderBox(usr);
        nbapp.functions.borderBox(pwd);
        nbapp.functions.ajxShowModalMsgBox("Please enter valid username/password", "Error");
      }else{
        nbapp.functions.ajxShowModalMsgBox("Please wait while you are redirected to dashboard", "Success");
        setTimeout(function(){nbapp.functions.redpage(res.nbapp.redurl);}, 2000);        
      }
      return false;
    };
    nbapp.functions.callAjax(url, callback, formName);
    return false;
  },
  clearMsg: function(){
    nbapp.functions.ajxClearMsgBox();    
    return false;
  }
};

nbapp.sideNav = {
	open: function(cur){
		cur = cur || "";
		if(typeof cur === "object"){
			$(cur).next().slideToggle("slow",function(){
				if($(cur).find("span").hasClass("icon-plus-sign")){
					$(cur).find("span").addClass("icon-minus-sign");
					$(cur).find("span").removeClass("icon-plus-sign");
				}else{
					$(cur).find("span").addClass("icon-plus-sign");
					$(cur).find("span").removeClass("icon-minus-sign");
				}
			});	
		}
	}
};
//decakre the variable in window
window["nbapp"]=nbapp;