//鍒涘缓URL鍦板潃
function creatUrl(param)
{
    var urlArray   = [];
    var _tempArray = param.split("/");
    for(var index in _tempArray)
    {
        if(_tempArray[index])
        {
            urlArray.push(_tempArray[index]);
        }
    }

    if(urlArray.length >= 2)
    {
        var iwebshopUrl = _webUrl.replace("_controller_",urlArray[0]).replace("_action_",urlArray[1]);

        //瀛樺湪URL鍙傛暟鎯呭喌
        if(urlArray.length >= 4)
        {
            iwebshopUrl = iwebshopUrl.replace("_paramKey_",urlArray[2]);

            //鍗歌浇鍘熸暟缁勪腑宸茬粡鎷兼帴鐨勬暟鎹�
            urlArray.splice(0,3);

            if(iwebshopUrl.indexOf("?") == -1)
            {
                iwebshopUrl = iwebshopUrl.replace("_paramVal_",urlArray.join("/"));
            }
            else
            {
                var _paramVal_ = "";
                for(var i in urlArray)
                {
                    if(i == 0)
                    {
                        _paramVal_ += urlArray[i];
                    }
                    else if(i%2 == 0)
                    {
                        _paramVal_ += "="+urlArray[i];
                    }
                    else
                    {
                        _paramVal_ += "&"+urlArray[i];
                    }
                }
                iwebshopUrl = iwebshopUrl.replace("_paramVal_",_paramVal_);
            }
        }
        return iwebshopUrl;
    }
    return '';
}

//鍒囨崲楠岃瘉鐮�
function changeCaptcha()
{
    $('#captchaImg').prop('src',creatUrl("site/getCaptcha/random/"+Math.random()));
}

//璧勬簮web璺緞
function webroot(path)
{
    if(!path || typeof(path) != 'string')
    {
        return;
    }
    return path.indexOf('http') == 0 ? path : _webRoot+path;
}

//鍟嗗搧绛涢€�
function searchGoods(url,callback)
{
    var step = 0;
    art.dialog.open(url,
        {
            "id":"searchGoods",
            "title":"鍟嗗搧绛涢€�",
            "okVal":"鎵ц",
            "button":
                [{
                    "name":"鍚庨€€",
                    "callback":function(iframeWin,topWin)
                    {
                        if(step > 0)
                        {
                            iframeWin.window.history.go(-1);
                            this.size(1,1);
                            step--;
                        }
                        return false;
                    }
                }],
            "ok":function(iframeWin,topWin)
            {
                if(step == 0)
                {
                    iframeWin.document.forms[0].submit();
                    step++;
                    return false;
                }
                else if(step == 1)
                {
                    var goodsList = $(iframeWin.document).find('input[name="id[]"]:checked');

                    //娣诲姞閫変腑鐨勫晢鍝�
                    if(goodsList.length == 0)
                    {
                        alert('璇烽€夋嫨瑕佹坊鍔犵殑鍟嗗搧');
                        return false;
                    }
                    //鎵ц澶勭悊鍥炶皟
                    callback(goodsList);
                    return true;
                }
            }
        });
}

//鍏ㄩ€�
function selectAll(nameVal)
{
    if($("input[type='checkbox'][name^='"+nameVal+"']:not(:checked)").length > 0)
    {
        $("input[type='checkbox'][name^='"+nameVal+"']").prop('checked',true);
    }
    else
    {
        $("input[type='checkbox'][name^='"+nameVal+"']").prop('checked',false);
    }
}
/**
 * @brief 鑾峰彇鎺т欢鍏冪礌鍊肩殑鏁扮粍褰㈠紡
 * @param string nameVal 鎺т欢鍏冪礌鐨刵ame鍊�
 * @param string sort    鎺т欢鍏冪礌鐨勭被鍨嬪€�:checkbox,radio,text,textarea,select
 * @return array
 */
function getArray(nameVal,sort)
{
    //瑕乤jax鐨刯son鏁版嵁
    var jsonData = new Array;

    switch(sort)
    {
        case "checkbox":
            $('input[type="checkbox"][name="'+nameVal+'"]:checked').each(
                function(i)
                {
                    jsonData[i] = $(this).val();
                }
            );
            break;
    }
    return jsonData;
}
window.loadding = function(message){var message = message ? message : '姝ｅ湪鎵ц锛岃绋嶅悗...';art.dialog({"id":"loadding","lock":true,"fixed":true,"drag":false}).content(message);}
window.unloadding = function(){art.dialog({"id":"loadding"}).close();}
window.tips = function(mess){art.dialog.tips(mess);}
window.alert = function(mess){art.dialog.alert(String(mess));}
window.confirm = function(mess,bnYes,bnNo)
{
    art.dialog.confirm(
        String(mess),
        function(){typeof bnYes == "function" ? bnYes() : bnYes && (bnYes.indexOf('/') == 0 || bnYes.indexOf('http') == 0) ? window.location.href=bnYes : eval(bnYes);},
        function(){typeof bnNo == "function" ? bnNo() : bnNo && (bnNo.indexOf('/') == 0 || bnNo.indexOf('http') == 0) ? window.location.href=bnNo : eval(bnNo);}
    );
}
/**
 * @brief 鍒犻櫎鎿嶄綔
 * @param object conf
 msg :鎻愮ず淇℃伅;
 form:瑕佹彁浜ょ殑琛ㄥ崟鍚嶇О;
 link:瑕佽烦杞殑閾炬帴鍦板潃;
 */
function delModel(conf)
{
    var ok = null;            //鎵ц鎿嶄綔
    var msg= '纭畾瑕佸垹闄や箞锛�';//鎻愮ず淇℃伅

    if(conf)
    {
        if(conf.form)
        {
            var ok = 'formSubmit("'+conf.form+'")';
        }
        else if(conf.link)
        {
            var ok = 'window.location.href="'+conf.link+'"';
        }

        if(conf.msg)
        {
            var msg = conf.msg;
        }

        if(conf.name && checkboxCheck(conf.name,"璇烽€夋嫨瑕佹搷浣滈」") == false)
        {
            return '';
        }
    }
    if(ok==null && document.forms.length >= 1)
        var ok = 'document.forms[0].submit();';

    if(ok!=null)
    {
        window.confirm(msg,ok);
    }
    else
    {
        alert('鍒犻櫎鎿嶄綔缂哄皯鍙傛暟');
    }
}

//鏍规嵁琛ㄥ崟鐨刵ame鍊兼彁浜�
function formSubmit(formName)
{
    $('form[name="'+formName+'"]').submit();
}

//鏍规嵁checkbox鐨刵ame鍊兼娴媍heckbox鏄惁閫変腑
function checkboxCheck(boxName,errMsg)
{
    if($('input[name="'+boxName+'"]:checked').length < 1)
    {
        alert(errMsg);
        return false;
    }
    return true;
}

//鍊掕鏃�
var countdown=function()
{
    var _self=this;
    this.handle={};
    this.parent={'second':'minute','minute':'hour','hour':""};
    this.add=function(id)
    {
        _self.handle.id=setInterval(function(){_self.work(id,'second');},1000);
    };
    this.work=function(id,type)
    {
        if(type=="")
        {
            return false;
        }

        var e = document.getElementById("cd_"+type+"_"+id);
        var value=parseInt(e.innerHTML);
        if( value == 0 && _self.work( id,_self.parent[type] )==false )
        {
            clearInterval(_self.handle.id);
            return false;
        }
        else
        {
            e.innerHTML = (value==0?59:(value-1));
            return true;
        }
    };
};

/*瀹炵幇浜嬩欢椤甸潰鐨勮繛鎺�*/
function event_link(url)
{
    window.location.href = url;
}

//寤惰繜鎵ц
function lateCall(t,func)
{
    var _self = this;
    this.handle = null;
    this.func = func;
    this.t=t;

    this.execute = function()
    {
        _self.func();
        _self.stop();
    }

    this.stop=function()
    {
        clearInterval(_self.handle);
    }

    this.start=function()
    {
        _self.handle = setInterval(_self.execute,_self.t);
    }
}