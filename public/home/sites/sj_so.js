/*20140621yyd 搜索框自动提示 add*/
(function($){
	var bigAutocomplete = new function(){
		this.currentInputText = null;//目前获得光标的输入框（解决一个页面多个输入框绑定自动补全功能）
		this.functionalKeyArray = [9,20,13,16,17,18,91,92,93,45,36,33,34,35,37,39,112,113,114,115,116,117,118,119,120,121,122,123,144,19,145,40,38,27];//键盘上功能键键值数组
		this.holdText = null;//输入框中原始输入的内容
		
		//初始化插入自动补全div，并在document注册mousedown，点击非div区域隐藏div
		this.init = function(){
			$(".searchbox").append("<div id='keys_content' class='keys_down'></div>");
			$(document).bind('mousedown',function(event){
				var $target = $(event.target);
				if((!($target.parents().andSelf().is('#keys_content'))) && (!$target.is(bigAutocomplete.currentInputText))){
					bigAutocomplete.hideAutocomplete();
				}
			})			
			//鼠标悬停时选中当前行
			$("#keys_content").delegate("tr", "mouseover", function() {
				$("#keys_content tr").removeClass("ct");
				$(this).addClass("ct");
			}).delegate("tr", "mouseout", function() {
				$("#keys_content tr").removeClass("ct");
			});		
			
			
			//单击选中行后，选中行内容设置到输入框中，并执行callback函数
			$("#keys_content").delegate("tr", "click", function() {
				bigAutocomplete.currentInputText.val( $(this).find("div:last").html());
				var callback_ = bigAutocomplete.currentInputText.data("config").callback;
				if($("#keys_content").css("display") != "none" && callback_ && $.isFunction(callback_)){
					callback_($(this).data("jsonData"));
					
				}				
				bigAutocomplete.hideAutocomplete();
			})			
			
		}
		
		this.autocomplete = function(param){
			
			if($(".searchbox").length > 0 && $("#keys_content").length <= 0){
				bigAutocomplete.init();//初始化信息
			}			
			
			var $this = $(this);//为绑定自动补全功能的输入框jquery对象
			
			var $keys_content = $("#keys_content");
			
			this.config = {
			               //width:下拉框的宽度，默认使用输入框宽度
			               width:365,
			               //url：格式url:""用来ajax后台获取数据，返回的数据格式为data参数一样
			               url:null,
			               /*data：格式{data:[{title:null,result:{}},{title:null,result:{}}]}
			               url和data参数只有一个生效，data优先*/
			               data:null,
			               //callback：选中行后按回车或单击时回调的函数
			               callback:null};
			$.extend(this.config,param);
			
			$this.data("config",this.config);
			
			//输入框keydown事件
			$this.keydown(function(event) {
				switch (event.keyCode) {
				case 40://向下键
					
					if($keys_content.css("display") == "none")return;
					
					var $nextSiblingTr = $keys_content.find(".ct");
					if($nextSiblingTr.length <= 0){//没有选中行时，选中第一行
						$nextSiblingTr = $keys_content.find("tr:first");
					}else{
						$nextSiblingTr = $nextSiblingTr.next();
					}
					$keys_content.find("tr").removeClass("ct");
					
					if($nextSiblingTr.length > 0){//有下一行时（不是最后一行）
						$nextSiblingTr.addClass("ct");//选中的行加背景
						$this.val($nextSiblingTr.find("div:last").html());//选中行内容设置到输入框中
						
						//div滚动到选中的行,jquery-1.6.1 $nextSiblingTr.offset().top 有bug，数值有问题
						$keys_content.scrollTop($nextSiblingTr[0].offsetTop - $keys_content.height() + $nextSiblingTr.height() );
						
					}else{
						$this.val(bigAutocomplete.holdText);//输入框显示用户原始输入的值
					}
					
					
					break;
				case 38://向上键
					if($keys_content.css("display") == "none")return;
					
					var $previousSiblingTr = $keys_content.find(".ct");
					if($previousSiblingTr.length <= 0){//没有选中行时，选中最后一行行
						$previousSiblingTr = $keys_content.find("tr:last");
					}else{
						$previousSiblingTr = $previousSiblingTr.prev();
					}
					$keys_content.find("tr").removeClass("ct");
					
					if($previousSiblingTr.length > 0){//有上一行时（不是第一行）
						$previousSiblingTr.addClass("ct");//选中的行加背景
						$this.val($previousSiblingTr.find("div:last").html());//选中行内容设置到输入框中
						
						//div滚动到选中的行,jquery-1.6.1 $$previousSiblingTr.offset().top 有bug，数值有问题
						$keys_content.scrollTop($previousSiblingTr[0].offsetTop - $keys_content.height() + $previousSiblingTr.height());
					}else{
						$this.val(bigAutocomplete.holdText);//输入框显示用户原始输入的值
					}
					
					break;
				case 27://ESC键隐藏下拉框
					
					bigAutocomplete.hideAutocomplete();
					break;
				}
			});		
			
			//输入框keyup事件
			$this.keyup(function(event) {
				var k = event.keyCode;
				var ctrl = event.ctrlKey;
				var isFunctionalKey = false;//按下的键是否是功能键
				for(var i=0;i<bigAutocomplete.functionalKeyArray.length;i++){
					if(k == bigAutocomplete.functionalKeyArray[i]){
						isFunctionalKey = true;
						break;
					}
				}
				//k键值不是功能键或是ctrl+c、ctrl+x时才触发自动补全功能
				if(!isFunctionalKey && (!ctrl || (ctrl && k == 67) || (ctrl && k == 88)) ){
					var config = $this.data("config");
					
					var offset = $this.offset();
					$keys_content.width(config.width);
					//var h = $this.outerHeight() - 1;
					$keys_content.css({"top":129,"margin-left":0});
					
					var data = config.data;
					var url = config.url;
					var keyword_ = $.trim($this.val());
					if(keyword_ == null || keyword_ == ""){
						bigAutocomplete.hideAutocomplete();
						return;
					}					
					if(data != null && $.isArray(data) ){
						var data_ = new Array();
						for(var i=0;i<data.length;i++){
							if(data[i].title.indexOf(keyword_) > -1){
								data_.push(data[i]);
							}
						}
						
						makeContAndShow(data_);
					}else if(url != null && url != ""){//ajax请求数据
						$.post(url,{keyword:keyword_},function(result){
							makeContAndShow(result.data)
						},"json")
					}

					
					bigAutocomplete.holdText = $this.val();
				}
				//回车键
				if(k == 13){
					var callback_ = $this.data("config").callback;
					if($keys_content.css("display") != "none"){
						if(callback_ && $.isFunction(callback_)){
							callback_($keys_content.find(".ct").data("jsonData"));
						}
						$keys_content.hide();						
					}
				}
				
			});	
			
					
			//组装下拉框html内容并显示
			function makeContAndShow(data_){
				if(data_ == null || data_.length <=0 ){
					return;
				}
				
				var cont = "<table><tbody>";
				for(var i=0;i<data_.length;i++){
					cont += "<tr><td><div>" + data_[i].title + "</div></td></tr>"
				}
				cont += "</tbody></table>";
				$keys_content.html(cont);
				$keys_content.show();
				
				//每行tr绑定数据，返回给回调函数
				$keys_content.find("tr").each(function(index){
					$(this).data("jsonData",data_[index]);
				})
			}			
					
			
			//输入框focus事件
			$this.focus(function(){
				bigAutocomplete.currentInputText = $this;
			});
			
		}
		//隐藏下拉框
		this.hideAutocomplete = function(){
			var $keys_content = $("#keys_content");
			if($keys_content.css("display") != "none"){
				$keys_content.find("tr").removeClass("ct");
				$keys_content.hide();
			}			
		}	
	};
	$.fn.bigAutocomplete = bigAutocomplete.autocomplete;	
})(jQuery)

		$(function(){	
		$("#keyword").bigAutocomplete({width:365,data:[
		{title:"白水晶"},{title:"白水晶手链"},{title:"白水晶吊坠"},{title:"白水晶 金蟾"},{title:"白水晶 貔貅"},{title:"白水晶 佛珠"},{title:"白水晶 项链"},{title:"白水晶 塔链"},{title:"白水晶球"},
		{title:"茶水晶"},{title:"茶晶"},{title:"茶水晶手链"},{title:"茶水晶吊坠"},{title:"茶晶 手链"},{title:"茶晶 吊坠"},{title:"茶水晶 金蟾"},{title:"茶水晶 貔貅"},{title:"茶水晶 佛珠"},{title:"茶水晶 项链"},
		{title:"紫水晶"},{title:"紫晶"},{title:"紫水晶手链"},{title:"紫水晶吊坠"},{title:"紫晶 手链"},{title:"紫晶 吊坠"},{title:"紫水晶 金蟾"},{title:"紫水晶 貔貅"},{title:"紫水晶 佛珠"},{title:"紫水晶 项链"},{title:"紫水晶 塔链"},{title:"紫水晶 手排"},{title:"紫晶 手排"},
		{title:"黄水晶"},{title:"黄晶"},{title:"黄水晶手链"},{title:"黄水晶吊坠"},{title:"黄水晶 金蟾"},{title:"黄水晶 貔貅"},{title:"黄水晶 戒指"},{title:"黄水晶 耳钉"},{title:"黄水晶 刻面"},{title:"黄水晶 手排"},
		{title:"紫黄晶"},{title:"紫黄晶手链"},{title:"紫黄晶吊坠"},{title:"紫黄晶 貔貅"},{title:"紫黄 水晶"},{title:"紫黄晶 手排"},{title:"紫黄晶 戒指"},
		{title:"粉水晶"},{title:"粉晶"},{title:"粉水晶手链"},{title:"粉水晶吊坠"},{title:"粉晶 手链"},{title:"粉晶 吊坠"},{title:"粉水晶 金蟾"},{title:"粉水晶 貔貅"},{title:"粉水晶 佛珠"},{title:"粉水晶 手镯"},{title:"粉晶 手镯"},{title:"粉水晶 手排"},{title:"粉晶 手排"},{title:"星光 粉晶"},{title:"星光 粉水晶"},
		{title:"石榴石"},{title:"石榴石手链"},{title:"石榴石吊坠"},{title:"石榴石 佛珠"},{title:"石榴石 项链"},{title:"石榴石 塔链"},{title:"石榴石 耳钉"},{title:"石榴石 玫红"},{title:"石榴石 紫红"},{title:"石榴石 酒红"},{title:"酒红 石榴石"},{title:"玫红 石榴石"},{title:"紫红 石榴石"},{title:"紫牙乌"},{title:"石榴石 手排"},
		{title:"月光石"},{title:"月光石手链"},{title:"月光石吊坠"},{title:"月光石 手链"},{title:"月光石 吊坠"},{title:"月光石 佛珠"},{title:"月光石 耳钉"},{title:"月光石 戒"},{title:"月光石 戒指"},{title:"月光石 戒面"},
		{title:"碧玺"},{title:"碧玺手链"},{title:"碧玺吊坠"},{title:"碧玺 佛珠"},{title:"碧玺 耳钉"},{title:"碧玺 戒面"},{title:"碧玺 戒指"},{title:"碧玺 项链"},{title:"碧玺 塔链"},{title:"黑碧玺"},{title:"红碧玺"},{title:"西瓜碧玺"},{title:"绿碧玺"},{title:"碧玺 手排"},
		{title:"玛瑙"},{title:"玛瑙手链"},{title:"玛瑙吊坠"},{title:"玛瑙 佛珠"},{title:"南红玛瑙"},{title:"玛瑙 戒指"},{title:"玛瑙 项链"},{title:"黑玛瑙"},{title:"红玛瑙"},{title:"水草玛瑙"},{title:"绿玛瑙"},
		{title:"绿幽灵"},{title:"绿幽灵手链"},{title:"绿幽灵吊坠"},{title:"幽灵 手链"},{title:"幽灵 吊坠"},{title:"绿幽灵 聚宝盆"},{title:"绿幽灵 金蟾"},{title:"绿幽灵 貔貅"},{title:"全满 绿幽灵"},{title:"绿幽灵 戒指"},{title:"绿幽灵 戒面"},{title:"绿幽灵 项链"},{title:"绿幽灵 塔链"},{title:"幽灵"},{title:"花幽灵"},{title:"花幽灵 手链"},{title:"花幽灵 吊坠"},{title:"红幽灵"},{title:"白幽灵"},
		{title:"红水晶"},{title:"红水晶手链"},{title:"红水晶吊坠"},{title:"红水晶 佛珠"},{title:"红水晶 项链"},{title:"红水晶 塔链"},
		{title:"兔毛水晶"},{title:"兔毛 水晶"},{title:"兔毛晶"},{title:"兔毛晶 吊坠"},{title:"兔毛晶 手链"},{title:"红兔毛"},{title:"黄兔毛"},
		{title:"发晶"},{title:"发晶手链"},{title:"发晶吊坠"},{title:"发晶 金蟾"},{title:"发晶 貔貅"},{title:"发晶 佛珠"},{title:"发晶 项链"},{title:"发晶 戒指"},{title:"发晶 戒面"},{title:"发晶球"},{title:"发晶 手排"},
		{title:"金发晶"},{title:"金发晶 手链"},{title:"金发晶 吊坠"},{title:"金发晶 貔貅"},{title:"金发晶 金蟾"},{title:"金发晶 佛珠"},{title:"金发晶 项链"},{title:"金发晶 塔链"},{title:"金发晶 戒指"},{title:"金发晶 手排"},
		{title:"铜发晶"},{title:"铜发晶 手链"},{title:"铜发晶 吊坠"},{title:"黑发晶"},{title:"绿发晶"},{title:"彩发晶"},
		{title:"钛晶"},{title:"钛晶手链"},{title:"钛晶吊坠"},{title:"钛晶 貔貅"},{title:"钛晶 金蟾"},{title:"钛晶 佛珠"},{title:"钛晶 项链"},{title:"钛晶 塔链"},{title:"钛晶 戒指"},{title:"钛晶 戒面"},{title:"钛晶 手排"},
		{title:"福禄寿"},{title:"福禄寿手链"},{title:"福禄寿 佛珠"},{title:"福禄寿 项链"},{title:"福禄寿 塔链"},{title:"福禄寿 手排"},
		{title:"萤石"},{title:"萤石手链"},{title:"萤石吊坠"},{title:"萤石 戒指"},{title:"萤石 蓝"},{title:"萤石 绿"},{title:"萤石 紫"},{title:"绿萤石"},{title:"蓝萤石"},{title:"萤石 项链"},{title:"萤石 塔链"},
		{title:"托帕石"},{title:"托帕石手链"},{title:"托帕石吊坠"},{title:"托帕石 佛珠"},{title:"托帕石 耳钉"},{title:"托帕石 戒面"},{title:"托帕石 戒指"},{title:"托帕石 项链"},{title:"托帕石 塔链"},
		{title:"海蓝宝"},{title:"海蓝宝手链"},{title:"海蓝宝吊坠"},{title:"海蓝宝 戒面"},{title:"海蓝宝 戒指"},{title:"海蓝宝 项链"},{title:"海蓝宝 塔链"},{title:"海蓝宝 手镯"},
		{title:"黑曜石"},{title:"黑曜石手链"},{title:"黑曜石吊坠"},{title:"黑曜石 佛珠"},{title:"黑曜石 貔貅"},{title:"黑曜石 貔貅 手链"},{title:"黑曜石 手镯"},{title:"黑曜石 双彩眼"},{title:"黑曜石 双绿眼"},{title:"黑曜石 狐狸"},{title:"黑曜石 佛"},{title:"黑曜石 手排"},{title:"金曜石"},{title:"金曜石 手链"},{title:"金曜石 吊坠"},{title:"金曜石 貔貅 手链"},{title:"冰种黑曜石"},{title:"冰种黑曜石 手链"},{title:"冰种黑曜石吊坠"},{title:"冰种黑曜石 貔貅"},
		{title:"虎眼石"},{title:"虎眼石手链"},{title:"虎眼石吊坠"},{title:"虎眼石 佛珠"},{title:"虎眼石 貔貅"},{title:"虎眼石 手排"},
		{title:"草莓晶"},{title:"草莓晶手链"},{title:"草莓晶吊坠"},
		{title:"红纹石"},{title:"红纹石手链"},{title:"红纹石吊坠"},{title:"红纹石 戒指"},
		{title:"青金石"},{title:"青金石手链"},{title:"青金石吊坠"},{title:"青金石 戒指"},
		{title:"玉髓"},{title:"玉髓 手链"},{title:"玉髓 吊坠"},{title:"蓝玉髓"},
		{title:"红绿宝"},{title:"红绿宝 手链"},{title:"红绿宝 手镯"},{title:"捷克陨石"},{title:"太阳石"},{title:"橄榄石"},{title:"葡萄石"},{title:"紫龙晶"},{title:"砗磲"},
		{title:"雕刻"},{title:"背雕"},{title:"水晶球"},{title:"水晶柱"},{title:"水晶簇"},{title:"水晶洞"},{title:"紫晶洞"},{title:"紫水晶洞"},{title:"开口笑"},{title:"聚宝盆"},{title:"玛瑙 聚宝盆"},{title:"塔链"},{title:"毛衣链"},{title:"水晶聚宝盆"},{title:"水晶耳饰"},{title:"水晶原石"},{title:"水晶雕件"},{title:"水晶七星阵"},	{title:"水晶树"},{title:"水晶把玩"},{title:"水晶车挂"},{title:"佛头"},{title:"本命佛"},{title:"观音"},{title:"菩萨"},{title:"貔貅"},{title:"金蟾"},{title:"狐狸"},{title:"葫芦"},{title:"平安扣"},{title:"四季豆"},{title:"平安瓶"},{title:"长命锁"},{title:"麒麟"},{title:"文昌笔"},{title:"生肖"},{title:"108 佛珠"},{title:"招财 辟邪"},{title:"美容养颜"},{title:"镇宅"},{title:"爱情"},
			],
			callback:function(data){
				$$("searchForm").submit();		
			}});				
})
/*20140621yyd 搜索框自动提示 add*/