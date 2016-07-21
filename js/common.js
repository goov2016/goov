if(!Array.indexOf) {  
	 Array.prototype.indexOf = function(obj)  
	 {                
		 for(var i=0; i<this.length; i++)  
		 {  
			 if(this[i]==obj)  
			 {  
				 return i;  
			}  
		 }  
		 return -1;  
	 };  
}

function viewWidth()
{
	return parseInt(document.documentElement.clientWidth);
}
function viewHeight()
{
	return parseInt(document.documentElement.clientHeight) ;
}

Function.prototype.bindAsEventListener = function(object) 
{ 
  var __method = this; 
  return function(event) 
  { 
    __method.call(object, event || window.event); 
  } 
}

Function.prototype.bind = function(object) {
  var __method = this;
  return function() {
    __method.apply(object, arguments);
  }
}
String.prototype.trim= function(){  
    return this.replace(/(^\s*)|(\s*$)/g, "");  
}


function addListener(obj, name, func)
{
	if (obj.addEventListener) {//firefox
		return obj.addEventListener(name, func, false)
	} else if (obj.attachEvent) {//IE
		return obj.attachEvent("on" + name, func);
	} else {
		return obj["on" + name] = func;
	}
}

function removeListener(obj, name, func)
{
	if (obj.removeEventListener) {
		return obj.removeEventListener(name, func, false)
	} else if (obj.detachEvent) {
		return obj.detachEvent("on" + name, func)
	} else {
		return obj["on" + name] = null;
	}
}

function stopEvent(e)
{
	stopEventDefault(e);
	stopEventBubble(e);
}

function stopEventBubble(e)
{
	if (!e) {
		e = window.event;
	}
	if( !e ){       //*** add by nishino
	    return ;
	}
	if (e.preventDefault) {
		e.stopPropagation();
	} else {
		e.cancelBubble = true;
	}
}

function stopEventDefault(e)
{
	if (!e) {
		e = window.event;
	}
	if( !e ){
	    return ;
	}
	if (e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue = false;
	}
}

function getPos(el)
{
	for (var pos = {x:0, y:0}; el; el = el.offsetParent)
	{
		pos.x += el.offsetLeft;
		pos.y += el.offsetTop;
	}
	return pos;
}

function getFirstDayWeekInMonth(year,month)
{
	year = parseInt(year,10);
	month = parseInt(month,10);
	var temp = new Date();
	temp.setFullYear(year);
	temp.setMonth(month-1);
	temp.setDate(1);
	return temp.getDay();
}
function getDaysInMonth(year,month)
{
	year = parseInt(year,10);
	month = parseInt(month,10);
	var newnew_date = new Date(year,month,0);
	return newnew_date.getDate();
}
function showDialog(url, name, width, height) {
	//$("body").addClass("bodydisabled"); 
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    var ret = window.showModalDialog(url, name, "DialogHeight:" + height + "px;DialogWidth:" + width + "px;left:" + left + "px;top:" + top + "px;toolbar:no;menubar:no;scrollbars:no;resizable:no;location:no;status:no");
    //$("body").removeClass("bodydisabled"); 
    return ret;
}

var g_index = 0;
function XXDialog(title,info,sets)
{
	this.name = "XXDialog";
	this.id = g_index++;
	this.x = 0;
	this.y = 0;
	this.drag_move = function(e)
	{
		var dx = e.clientX - this.x;
		var dy = e.clientY - this.y;
		var left = this.dialog.offset().left + dx;
		var top = this.dialog.offset().top + dy;
		this.dialog.css("left",left+"px");
		this.dialog.css("top",top+"px");
		this.x = e.clientX;
		this.y = e.clientY;
	}
	this.stop = function()
	{
		$(document).unbind("mousemove",this._drag_move);
		$(document).unbind("mouseup",this._stop);
		this._drag_move = null;
		this._stop = null;
	}
	this.start = function(e)
	{
		this.x = e.clientX;
		this.y = e.clientY;
		if(this._drag_move == null)
		{
			this._drag_move = this.drag_move.bindAsEventListener(this);
			this._stop = this.stop.bindAsEventListener(this);
			$(document).bind("mousemove",this._drag_move);
			$(document).bind("mouseup",this._stop);
		}
	}
	this.hide = function()
	{
		this.stop();
		document.body.removeChild(this.div_dialog);
		if(this.settings.modal)
		{
			document.body.removeChild(this.div_dialog_mask);
		}
	}
	this.OnOK = function()
	{
		var ret = true;
		if(this.settings.ok_fun != null)
		{
			ret = this.settings.ok_fun(this);
			if(typeof(ret) == "undefined")ret = true;
		}
		if(ret == true)
		{
			this.hide();
		}
	}
	this.OnCancel = function()
	{
		var ret = true;
		if(this.settings.cancel_fun != null)
		{
			ret = this.settings.cancel_fun(this);
			if(typeof(ret) == "undefined")ret = true;
		}
		if(ret == true)
		{
			this.hide();
		}
	}
	//init
	this.settings = new Object();
	
	if(typeof(sets) == "undefined")
	{
		sets = new Object();
	}
	this.settings.width = (typeof(sets.width) == "undefined") ? 400 : sets.width;
	this.settings.height = (typeof(sets.height) == "undefined") ? -1 : sets.height;
	this.settings.modal = (typeof(sets.modal) == "undefined") ? true : sets.modal;
	this.settings.ok = (typeof(sets.ok) == "undefined") ? "" : sets.ok;
	this.settings.ok_fun = (typeof(sets.ok_fun) == "undefined") ? null : sets.ok_fun;
	this.settings.cancel_fun = (typeof(sets.cancel_fun) == "undefined") ? null : sets.cancel_fun;
	this.settings.cancel = (typeof(sets.cancel) == "undefined") ? "" : sets.cancel;
	this.settings.toolbar = (typeof(sets.toolbar) == "undefined") ? false : sets.toolbar;
	this.settings.comment = (typeof(sets.comment) == "undefined") ? "" : sets.comment;
	this.settings.icon = (typeof(sets.icon) == "undefined") ? null : sets.icon;
	
	this.show = function()
	{
		this._start = null;
		this._drag_move = null;
		this._stop = null;
		this._OnCancel = null;
		this._OnOK = null;
		
		this.div_dialog = document.createElement('div');
		this.div_dialog_title = document.createElement('div');
		this.div_dialog_body = document.createElement('div');
		
		this.div_dialog.appendChild(this.div_dialog_title);
		this.div_dialog.appendChild(this.div_dialog_body);
		
		if(this.settings.modal)
		{
			this.div_dialog_mask = document.createElement('div');
			this.dialog_mask = $(this.div_dialog_mask);
			this.dialog_mask.addClass("xx_dialog_mask");
			document.body.appendChild(this.div_dialog_mask);
		}
		document.body.appendChild(this.div_dialog);

		this.dialog = $(this.div_dialog);
		this.dialog_title = $(this.div_dialog_title);
		this.dialog_body = $(this.div_dialog_body);
		
		this.dialog.addClass("xx_dialog_frame");
		this.dialog_title.addClass("xx_dialog_title");
		this.dialog_body.addClass("xx_dialog_body");
		if(this.settings.icon != null)
		{
			this.dialog_body.css('background-image',"url(img/bk_dialog_body_"+this.settings.icon+".jpg)");
		}
		this.dialog_body.html(info);
		
		this.dialog.width(this.settings.width);
		if(this.settings.height>0)
		{
			this.dialog_body.height(this.settings.height-20);
		}
		var str = "<table width='100%' height='100%' border='0'  cellspacing='0' cellpadding='0'><tr><td><span style='display:inline-block;vertical-align:middle;width:22px;height:22px;background:url(img/bk_sprite.png) -44px 0px no-repeat;'>&nbsp;</span>&nbsp;<span>"+title+"</span></td>";
		str += "<td align='right'><span id='dialog_span_x_"+this.id+"' class='xx_dialog_span_x'></span></td></tr></table>";
		this.dialog_title.html(str);
		this._OnCancel = this.OnCancel.bindAsEventListener(this);
		$("#dialog_span_x_"+this.id).click(this._OnCancel);
		
		if(this.settings.toolbar == false)
		{
			if(this.settings.ok_fun != null
				|| this.settings.cancel_fun != null
				|| this.settings.comment != "")
			{
				this.settings.toolbar = true;
			}
		}
		if(this.settings.toolbar)
		{
			this.div_dialog_foot = document.createElement('div');
			this.div_dialog.appendChild(this.div_dialog_foot);
			this.dialog_foot = $(this.div_dialog_foot);
			this.dialog_foot.addClass("xx_dialog_foot");
			this.dialog_foot.append("<span style='float:left;'>"+this.settings.comment+"</span>");
			
			if(this.settings.ok != "")
			{
				//<span class='xx_button_small'>确定</span>
				var str="&nbsp;<input type='button' class='xx_item_button' id='dialog_btn_ok_"+this.id+"' value='"+this.settings.ok+"' />";
				this.dialog_foot.append(str);
				var btn_ok = $("#dialog_btn_ok_"+this.id);
				this._OnOK = this.OnOK.bindAsEventListener(this);
				btn_ok.click(this._OnOK);
			}
			if(this.settings.cancel != "")
			{
				var str="&nbsp;<input type='button' class='xx_item_button' id='dialog_btn_cancel_"+this.id+"' value='"+this.settings.cancel+"' />";
				this.dialog_foot.append(str);
				var btn_cancel = $("#dialog_btn_cancel_"+this.id);
				btn_cancel.click(this._OnCancel);
			}
		}
		var viewWidth=parseInt(document.documentElement.clientWidth);
		var viewHeight=parseInt(document.documentElement.clientHeight);
		var dlgwidth = this.dialog.width();
		var dlgheight = this.dialog.height();
		
		if(dlgheight < (30+30+60))
		{
			this.dialog_body.height(60);
			dlgheight = this.dialog.height();
		}
		var left = (viewWidth-dlgwidth)/2;
		var top = (viewHeight-dlgheight)/2;
		this.dialog.css('left',left+"px");
		this.dialog.css('top',top+"px");
		
		this._drag_move = null;
		this._stop = null;
		this._start = this.start.bindAsEventListener(this);
		this.dialog_title.bind("mousedown",this._start);
	}
}

function showIFrameDialog(url,title,width,height,showok,fun_back)
{
	width = width+10;
	height = height+10;
    g_index++;
    var frm_id = "dlg_frm_"+g_index;
    var str = "<iframe src='"+url+"' id='"+frm_id+"' style='width:100%;height:100%;' frameborder='no' border='0' marginwidth='0' marginheight='0' scrolling='no'/>";
    if(showok)
    {
        new XXDialog(title,str,{
          	width:width,
          	height:height,
          	modal:true,
          	toolbar:true,
          	ok:'确定',
          	ok_fun:function(dlg){
          		var frm = document.getElementById(frm_id);
          		var ret = frm.contentWindow.OnOK();
          		if(ret.status == 'ok')
          		{
          			if(ret.message != '')
          			{
          				alert(ret.message);
          			}
          			if(typeof(fun_back) != "undefined")
          			{
          				fun_back(ret);
          			}
          			return true;
          		}
          		else
          		{
          			if(ret.message != '')
          			{
          				alert(ret.message);
          			}
          			return false;
          		}
          	},
          	cancel:'取消'}).show();
    }
    else
    {
        new XXDialog(title,str,{
          	width:width,
          	height:height,
          	modal:true,
          	toolbar:true,
          	cancel:'Close'}).show();
    }
}
/*
var g_download_iframe = null;
function download_file(url)
{
	if(g_download_iframe == null)
	{
		g_download_iframe = document.createElement("iframe");
		document.body.appendChild(g_download_iframe); 
	}
	// alert(download_file.iframe);
	g_download_iframe.src = url;
	g_download_iframe.style.display = "none";
}
*/

function download_file(url)
{
	window.open (url, '下载', 'height=100, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no');
}

function readCookie(name)
{
	var cookieValue = null;
	var search = name + "=";
	if(document.cookie.length > 0)
	{ 
		offset = document.cookie.indexOf(search);
		if (offset != -1)
		{ 
			offset += search.length;
			end = document.cookie.indexOf(";", offset);
			if (end == -1) 
				end = document.cookie.length;
			cookieValue = unescape(document.cookie.substring(offset, end))
		}
	}
	return cookieValue;
}

function ParseBackJSON(responseData)
{
	try
	{
		if (responseData.status == 200) 
		{
			var ret = eval("(" + responseData.responseText + ")");
			if(ret.status == "notreg")
			{
				alert(ret.message);
				window.location.reload();
			}
			else if(ret.status != "ok")
			{
				alert(ret.message);
			}
			return ret;
		}
		else
		{
			var ret = new Object();
			ret.status = "net_error";
			ret.message = "网络错误";
			alert(ret.message);
			return ret;
		}
	}
	catch(error)
	{
		var ret = new Object();
		ret.status = "server_error";
		ret.message = "服务器内部错误";
		alert(ret.message);
		return ret;
	}
}


//检测是有是有效的ID（以字母开头，【字母】【数字】【_】有效）
function isValidId(str)
{
	var patrn=/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){1,16}$/; 
	if (patrn.exec(str)) 
	{
		return true;
	}
	return false;
}
//是否是邮件地址
function isValidEmail(str) {
	var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
	if (myReg.test(str)) 
		return true; 
	return false; 
}
//是否是汉字
function isValidZh(str)
{
 var reg = /^[\u4e00-\u9fa5]+$/;
 if (reg.test(str))
 	 return true;
 return false;
}
//是否是数字
function isValidNumber (str) {
    var regex = /^[+|-]?\d*\.?\d*$/;
    if (!regex.test(str)){
        return false;
    }
    return true;
}
function isValidDate(str)
{     
    var r = str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);     
    if(r==null)
    {
        return false;     
    }
    else
    {
        var d= new Date(r[1], r[3]-1, r[4]);     
        return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]); 
    }    
}
function isValidTime(str)     
{     
  var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);     
  if (a==null)
 {
    return false;
  }
  if (a[1]>24 || a[3]>60 || a[4]>60)     
  { 
      return false;
  }
  return true;     
} 

//至少4位,最大50位，第一位是字母，后面由字母，数字，下划线和.组成
function isValidName(str)     
{     
  return (/^[a-zA-Z][\.\w]{3,49}$/.test(str));     
} 

//只要是-和数字就行
function isValidTel(str)     
{     
  return (/^[\d-]+$/.test(str));     
}

//只要是-和数字就行
function isValidIMEI(str)     
{     
  return (/^[\d]+$/.test(str));     
}

//长度大于3就行
function isValidPwd(str)     
{     
  return str.length>3;     
}
function FixedZero(str,len)
{
	var ret = ""+str;
	while(ret.length<len)
	{
		ret = "0" + ret;
	}
	return ret;
}

function toFixed(str,len)
{
	str=""+str;
	var val = parseFloat("0"+str);
	if(str.substr(0,1)=="-")
	{
		val = parseFloat(str);
	}
	return val.toFixed(len);
}
function toDate(str)
{
	str = ""+str;
	var year = parseInt("0"+str,10);
	if(year<2000)
	{
		return "";
	}
	return str.substr(0,10);
}

function dateNow()
{
	var today = new Date();
	var year = today.getFullYear();
	var month = today.getMonth();
	var hour = today.getHours();
	var minute = today.getMinutes();
	var second = today.getSeconds();

	month++;
	if(month<10)
		month = "0"+month;
	var day = today.getDate();
	if(day<10)
		day = "0"+today.getDate();
	
	return year+"-"+month + "-" + day;
}
function timeNow()
{
	var today = new Date();
	var year = today.getFullYear();
	var month = today.getMonth();
	var hour = today.getHours();
	var minute = today.getMinutes();
	var second = today.getSeconds();

	month++;
	if(month<10)
		month = "0"+month;
	var day = today.getDate();
	if(day<10)
		day = "0"+today.getDate();
	
	if(hour<10)
		hour = "0"+hour;
	if(minute<10)
		minute = "0"+minute;
	if(second<10)
		hour = "0"+second;
	
	return year+"-"+month + "-" + day  + " " + hour  + ":" + minute  + ":" + second ;
}

g_ajax_index = 0;
function AjaxIndex()
{
	g_ajax_index++;
	return g_ajax_index;
}
function AjaxGetJSON(url)
{
	try
	{
		var ret=$.ajax({ url:url,async:false});
		if (ret.status == 200)
		{
			var ret = eval("(" + ret.responseText + ")");
			if(ret.status == "notreg")
			{
				alert(ret.message);
				window.location.reload();
			}
			else if(ret.status != "ok")
			{
				alert(ret.message);
			}
			return ret;
		}
        else{
            var ret=new Object();
			ret.status="fail";
			ret.message="服务器出错";
			alert(ret.message);
			return ret;
        }
	}
	catch(error)
	{
		var ret=new Object();
		ret.status="fail";
		ret.message="服务器出错";
		alert(ret.message);
		return ret;
	}
}
function AjaxPostJSON(url,postdata)
{
	try
	{
		var ret=$.ajax({
		   type:"post",
		   async:false,
		   cache:false,
		   url: url,
		   data:postdata
		   });
		if (ret.status == 200)
		{
			try
			{
				var ret = eval("(" + ret.responseText + ")");
				if(ret.status == "notreg")
				{
					alert(ret.message);
					window.location.reload();
				}
				else if(ret.status != "ok")
				{
					alert(ret.message);
				}
				return ret;
			}
			catch(error)
			{
				var ret=new Object();
				ret.status="fail";
				ret.message="服务器返回无效数据";
				alert(ret.message);
				return ret;
			}
		}
        else{
            var ret=new Object();
			ret.status="fail";
			ret.message="服务器出错";
			alert(ret.message);
			return ret;
        }
	}
	catch(error)
	{
		var ret=new Object();
		ret.status="fail";
		ret.message="网络通讯错误";
		alert(ret.message);
		return ret;
	}
}
function AjaxGetHTML(url)
{
	try
	{
		var ret=$.ajax({ url:url,async:false});
		if (ret.status == 200)
		{
			return ret.responseText;
		}
		else
		{
			var message="服务器出错";
			alert(message);
			return message;
		}
	}
	catch(error)
	{
		var message="网络通讯错误";
		alert(message);
		return message;
	}
}
function AjaxPostHTML(url,postdata)
{
	try
	{
		var ret=$.ajax({
		   type:"post",
		   async:false,
		   cache:false,
		   url: url,
		   data:postdata
		   });
		if (ret.status == 200)
		{
			return ret.responseText;
		}
        else
		{
			var message="服务器出错";
			alert(message);
			return message;
		}
	}
	catch(error)
	{
		var ret=new Object();
		ret.status="fail";
		ret.message="网络通讯错误";
		return ret;
	}
}
function AjaxPostBack(url,postdata,backfun)
{
	try
	{
		$.ajax({
		   type:"POST",
		   async:true,
		   cache:false,
		   url: url,
		   data:postdata,
		   complete:backfun
		   });
	}
	catch(error)
	{
		var message="网络通讯错误";
		alert(message);
		return message;
	}
}


function Toast()
{
	this.msg = "";
	this.divmsg = null;
	this.width = 400
	this.height = 22;
	this.div = null;
	this.timespan = 2000;
	this.timer = null;
	this.textAlign = "left";
	this.setTime = function(stime)
	{
		this.timespan = stime;
	}
	this.setTextAlign = function(align)
	{
		this.textAlign = align;
	}
	this.setSize = function(width,height)
	{
		this.width = parseInt(width);
		this.height = parseInt(height);
	}
	this.Hide = function()
	{
		if(this.timer != null)
		{
			clearTimeout(this.timer);
		}
		this.timer = null;
		this.div.style.display = "none";
	}
	
	this.timerfun = function(data)
	{
		this.Hide();
	}
	this.Show = function(msg,stime)
	{
		if(stime != null)
		{
			this.timespan = stime;
		}
		this.msg = msg;
		if(this.div == null)
		{
			this.div = document.getElementById("common_toast_9999");
		}
		if(this.div == null)
		{
			this.div = document.createElement("div");
			this.div.id = "common_toast_9999";
			this.div.style.display = "block";
			this.div.style.padding = "10px 10px 10px 10px";
			
			this.div.style.position = "absolute";
			this.div.style.zIndex = "5";
			this.div.style.background = "#FFFFFF";
			this.div.style.border = "solid #a8a1a9 1px";
			
			document.body.appendChild(this.div);
		}
		var viewWidth=parseInt(document.documentElement.clientWidth);
		var viewHeight=parseInt(document.documentElement.clientHeight);
		this.div.style.display = "block";
		this.div.style.top = (viewHeight-this.height)/2 + "px";	
		this.div.style.left = (viewWidth-this.width)/2 + "px";	
		this.div.style.width = this.width + "px";
		this.div.style.height = this.height + "px";
		this.div.style.textAlign=this.textAlign;
		this.div.innerHTML = this.msg;

		if(this.timer != null)
		{
			clearTimeout(this.timer);
		}
		if(this._timerfun == null)
		{
			this._timerfun = this.timerfun.bindAsEventListener(this);
		}
		this.timer = setTimeout(this._timerfun, this.timespan);
	}
	
	this.ShowEx = function(divmsg,stime)
	{
		if(stime != null)
		{
			this.timespan = stime;
		}
		this.divmsg = divmsg;
		if(this.div == null)
		{
			this.div = document.getElementById("common_toast_9999");
		}
		if(this.div == null)
		{
			this.div = document.createElement("div");
			this.div.id = "common_toast_9999";
			this.div.style.display = "block";
			this.div.style.padding = "10px 10px 10px 10px";
			
			this.div.style.position = "absolute";
			this.div.style.zIndex = "5";
			this.div.style.background = "#FFFFFF";
			this.div.style.border = "solid #a8a1a9 1px";
			
			document.body.appendChild(this.div);
		}
		var viewWidth=parseInt(document.documentElement.clientWidth);
		var viewHeight=parseInt(document.documentElement.clientHeight);
		this.div.style.display = "block";
		this.div.style.top = (viewHeight-this.height)/2 + "px";
		this.div.style.left = (viewWidth-this.width)/2 + "px";
		this.div.style.width = this.width + "px";
		this.div.style.height = this.height + "px";
		this.div.style.textAlign=this.textAlign;
		this.div.innerHTML = "";
		this.div.appendChild(this.divmsg);

		if(this.timer != null)
		{
			clearTimeout(this.timer);
		}
		if(this._timerfun == null)
		{
			this._timerfun = this.timerfun.bindAsEventListener(this);
		}
		this.timer = setTimeout(this._timerfun, this.timespan);
	}
}



function makePageBar(allcnt,currentpage,cnt,pagesize)
{
	if(typeof(allcnt)=='undefined')
		allcnt=1;
	return makePageBarEx(allcnt,currentpage,cnt,pagesize,"OnPage");
}
function makePageBarEx(allcnt,currentpage,cnt,pagesize,backname)
{
	currentpage = parseInt(currentpage,10);	
	pagesize = parseInt(pagesize,10);
	allcnt=parseInt(allcnt,10);
	
	cnt = parseInt(cnt,10);
	var total=Math.ceil(allcnt/pagesize);
	var str="";
	if(currentpage < 0)
	{
		currentpage = 0;
	}
	var pagehtml="";
	
	//前一页
	if(currentpage>0)
	{
		pagehtml+="<span onclick='"+backname+"("+(currentpage-1)+");' class='span_page_item'>前一页</span>";
	}
	else
	{
		pagehtml+="<span  class='span_page_item_disabled'>前一页</span>";
	}
	pagehtml+="<span  class='span_page_item_disabled'>" + ((currentpage+1)+"/"+ total)+ "</span>";
	//后一页
	if(currentpage < total-1)
	{
		pagehtml+="<span onclick='"+backname+"("+(currentpage+1)+");' class='span_page_item'>后一页</span>";
	}
	else
	{
		pagehtml+="<span  class='span_page_item_disabled'>后一页</span>";
	}
	if(total>5){
		pagehtml+="<input size='4'><span onclick='"+backname+"(this.previousSibling.value-1>0?this.previousSibling.value-1:0);' class='span_page_item'>转跳</span>";
	}
	return pagehtml;
}
function getRandomColor()
{
	return '#'+((Math.random()*0x1000000<<0).toString(16)).substr(-6);
}



function OnMenu(topindex,suburl)
{
	window.location = suburl+"&topmenu="+topindex;
}

function OnLogout()
{
	var ret = AjaxGetJSON("index.php?rt=svr&act=public&sub=logout");
	if(ret.status == "ok")
	{
		window.location = "index.php";
	}
}


function AjaxGetBack(url,getdata,backfun)
{
	try
	{
		$.ajax({
		   async:true,
		   type:"GET",
		   url: url,
		   dataType: "json",
		   data:getdata,
		   success:backfun
		   });
		   
	}
	catch(error)
	{
		var message="网络通讯错误";
		alert(message);
		return message;
	}
}
