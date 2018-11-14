/*鍏ㄥ眬鍙橀噺*/
__GOODSID = "";//鍟嗗搧ID

/**
 * @brief 鍟嗗搧绫诲簱
 * @param int goods_id 鍟嗗搧ID鍙傛暟
 * @param int user_id 鐢ㄦ埛ID鍙傛暟
 * @param string promo 娲诲姩绫诲瀷鍙傛暟
 * @param int active_id 娲诲姩ID鍙傛暟
 */
function productClass(goods_id,user_id,promo,active_id)
{
    _self         = this;
    this.goods_id = goods_id; //鍟嗗搧ID
    __GOODSID     = goods_id; //鍟嗗搧ID鍏ㄥ眬
    this.user_id  = user_id;  //鐢ㄦ埛ID
    this.province_id;         //鏀惰揣鍦板潃鐪佷唤ID
    this.province_name;       //鏀惰揣鍦板潃鐪佷唤鍚嶅瓧

    this.promo    = promo;    //娲诲姩绫诲瀷
    this.active_id= active_id;//娲诲姩ID

    /**
     * 鑾峰彇璇勮鏁版嵁
     * @page 鍒嗛〉鏁�
     */
    this.comment_ajax = function(page)
    {
        comment_ajax(page);
    }

    /**
     * 鑾峰彇璐拱璁板綍鏁版嵁
     * @page 鍒嗛〉鏁�
     */
    this.history_ajax = function(page)
    {
        history_ajax(page);
    }

    /**
     * 鑾峰彇鍜ㄨ璁板綍鏁版嵁
     * @page 鍒嗛〉鏁�
     */
    this.refer_ajax = function(page)
    {
        refer_ajax(page);
    }

    /**
     * 鑾峰彇璐拱璁板綍鏁版嵁
     * @page 鍒嗛〉鏁�
     */
    this.discuss_ajax = function(page)
    {
        discuss_ajax(page);
    }

    /**
     * @brief 璁＄畻鍚勭鐗╂祦鐨勮繍璐�
     * @param int provinceId 鐪佷唤ID
     * @param string provinceName 鐪佷唤鍚嶇О
     */
    this.delivery = function(provinceId,provinceName)
    {
        $('[name="localArea"]').text(provinceName);

        var buyNums   = $('#buyNums').val();
        var productId = $('#product_id').val();
        var goodsId   = _self.goods_id;

        //鐗╂祦鏄剧ず妯℃澘
        var deliveryTemplate = '<%if(if_delivery == 0){%><%=name%>锛�<b style="color:#fe6c00">锟�<%=price%></b>锛�<%=description%>锛�&nbsp;&nbsp;';
        deliveryTemplate+= '<%}else{%>';
        deliveryTemplate+= '<%=name%>锛�<b style="color:red">璇ュ湴鍖烘棤娉曢€佽揪</b>&nbsp;&nbsp;<%}%>';

        //閫氳繃鐪佷唤id鏌ヨ鍑洪厤閫佹柟寮忥紝骞朵笖浼犻€佹€婚噸閲忚绠楀嚭杩愯垂,鐒跺悗鏄剧ず閰嶉€佹柟寮�
        $.getJSON(creatUrl("block/order_delivery"),{'province':provinceId,'goodsId':goodsId,'productId':productId,'num':buyNums,'random':Math.random},function(json)
        {
            //娓呯┖閰嶉€佷俊鎭�
            $('#deliveInfo').empty();

            for(var item in json)
            {
                var deliveRowHtml = template.compile(deliveryTemplate)(json[item]);
                $('#deliveInfo').append(deliveRowHtml);
            }
        });

        //淇濆瓨鎵€閫夋嫨鐨勬暟鎹�
        _self.province_id   = provinceId;
        _self.province_name = provinceName;
    }

    /**
     * @brief 鏍规嵁鏂版氮鍦板尯鎺ュ彛鑾峰彇褰撳墠鎵€鍦ㄥ湴鐨勮繍璐�
     */
    this.initLocalArea = function()
    {
        //鏍规嵁IP鏌ヨ鎵€鍦ㄥ湴
        $.getScript('//int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
            var ipAddress = remote_ip_info['province'];

            //鏍规嵁鎺ュ彛杩斿洖鐨勬暟鎹煡鎵句笌iWebShop绯荤粺鍖归厤鐨勫湴鍖�
            $.getJSON(creatUrl("block/searchProvince"),{'province':ipAddress,'random':Math.random},function(json)
            {
                if(json.flag == 'success')
                {
                    //璁＄畻鍚勪釜閰嶉€佹柟寮忕殑杩愯垂
                    _self.delivery(json.area_id,ipAddress);
                }
            });
        });

        //缁戝畾鍦板尯閫夋嫨鎸夐挳浜嬩欢
        $('[name="areaSelectButton"]').bind("click",function(){
            var provinceId   = $(this).attr('value');
            var provinceName = $(this).text();
            _self.delivery(provinceId,provinceName);
        });
    }

    //鍙戣〃璁ㄨ
    this.sendDiscuss = function()
    {
        var userId = _self.user_id;
        if(userId)
        {
            $('#discussTable').show('normal');
            $('#discussContent').focus();
        }
        else
        {
            alert('璇风櫥闄嗗悗鍐嶅彂琛ㄨ璁�!');
        }
    }

    //鍙戝竷璁ㄨ鏁版嵁
    this.sendDiscussData = function()
    {
        var content = $('#discussContent').val();
        var captcha = $('[name="captcha"]').val();

        if($.trim(content)=='')
        {
            alert('璇疯緭鍏ヨ璁哄唴瀹�!');
            $('#discussContent').focus();
            return false;
        }
        if($.trim(captcha)=='')
        {
            alert('璇疯緭鍏ラ獙璇佺爜!');
            $('[name="captcha"]').focus();
            return false;
        }

        $.getJSON(creatUrl("site/discussUpdate"),{'content':content,'captcha':captcha,'random':Math.random,'id':_self.goods_id},function(json)
        {
            if(json.isError == false)
            {
                var discussHtml = template.render('discussRowTemplate',json);
                $('#discussBox').prepend(discussHtml);

                //娓呴櫎鏁版嵁
                $('#discussContent').val('');
                $('[name="captcha"]').val('');
                $('#discussTable').hide('normal');
                changeCaptcha();
            }
            else
            {
                alert(json.message);
            }
        });
    }

    //妫€鏌ラ€夋嫨瑙勬牸鏄惁瀹屽叏
    this.checkSpecSelected = function()
    {
        if(_self.specCount === $('[specId].current').length)
        {
            return true;
        }
        return false;
    }

    //鍒濆鍖栬鏍兼暟鎹�
    this.initSpec = function()
    {
        //鏍规嵁specId鏌ヨ瑙勬牸绉嶇被鏁伴噺
        _self.specCount = 0;
        var tmpSpecId   = "";
        $('[specId]').each(function()
        {
            if(tmpSpecId != $(this).attr('specId'))
            {
                _self.specCount++;
                tmpSpecId = $(this).attr('specId');
            }
        });

        //缁戝畾鍟嗗搧瑙勬牸鍑芥暟
        $('[specId]').bind('click',function()
        {
            //璁剧疆閫変腑鐘舵€�
            $("[specId='"+$(this).attr('specId')+"']").removeClass('current');
            $(this).addClass('current');

            //妫€鏌ユ槸鍚﹂€夋嫨瀹屾垚
            if(_self.checkSpecSelected() == true)
            {
                //鎷兼帴閫変腑鐨勮鏍兼暟鎹�
                var specJSON = [];
                $('[specId].current').each(function()
                {
                    var specData = $(this).data('specData');
                    if(!specData)
                    {
                        alert("瑙勬牸鏁版嵁娌℃湁缁戝畾");
                        return;
                    }

                    specJSON.push({
                        "id":specData.id,
                        "type":specData.type,
                        "value":specData.value,
                        "name":specData.name,
                        "tip":specData.tip,
                    });
                });

                //鑾峰彇璐у搧鏁版嵁骞惰繘琛屾覆鏌�
                $.post(creatUrl("site/getProduct"),{"goods_id":_self.goods_id,"specJSON":specJSON,"random":Math.random},function(json){
                    if(json.flag == 'success')
                    {
                        //璐у搧鏁版嵁娓叉煋
                        $('#data_goodsNo').text(json.data.products_no);
                        $('#data_storeNums').text(json.data.store_nums);$('#data_storeNums').trigger('change');
                        $('#data_groupPrice').text(json.data.group_price);
                        $('#data_sellPrice').text(json.data.sell_price);
                        $('#data_marketPrice').text(json.data.market_price);
                        $('#data_weight').text(json.data.weight);
                        $('#product_id').val(json.data.id);
                    }
                    else
                    {
                        alert(json.message);
                    }
                },'json');
            }
        });
    }

    //妫€鏌ヨ喘涔版暟閲忔槸鍚﹀悎娉�
    this.checkBuyNums = function()
    {
        var minNums   = parseInt($('#buyNums').attr('minNums'));
        minNums   = minNums ? minNums : 1;
        var maxNums   = parseInt($('#buyNums').attr('maxNums'));
        maxNums   = maxNums ? maxNums : parseInt($.trim($('#data_storeNums').text()));

        var buyNums   = parseInt($.trim($('#buyNums').val()));

        //璐拱鏁伴噺灏忎簬0
        if(isNaN(buyNums) || buyNums < minNums)
        {
            $('#buyNums').val(minNums);
            alert("姝ゅ晢鍝佽喘涔版暟閲忎笉寰楀皯浜�"+minNums);
        }

        //璐拱鏁伴噺澶т簬搴撳瓨
        if(buyNums > maxNums)
        {
            $('#buyNums').val(maxNums);
            alert("姝ゅ晢鍝佽喘涔版暟閲忎笉寰楄秴杩�"+maxNums);
        }
    }

    /**
     * 璐墿杞︽暟閲忕殑鍔犲噺
     * @param code 澧炲姞鎴栬€呭噺灏戣喘涔扮殑鍟嗗搧鏁伴噺
     */
    this.modified = function(code)
    {
        var buyNums = parseInt($.trim($('#buyNums').val()));
        switch(code)
        {
            case 1:
            {
                buyNums++;
            }
                break;

            case -1:
            {
                buyNums--;
            }
                break;
        }
        $('#buyNums').val(buyNums);
        $('#buyNums').trigger('change');
    }

    //鍟嗗搧鍔犲叆璐墿杞�
    this.joinCart = function()
    {
        if(_self.checkSpecSelected() == false)
        {
            tips('璇峰厛閫夋嫨鍟嗗搧鐨勮鏍�');
            return;
        }

        var buyNums   = parseInt($.trim($('#buyNums').val()));
        var price     = parseFloat($.trim($('#real_price').text()));
        var productId = $('#product_id').val();
        var type      = productId ? 'product' : 'goods';
        var goods_id  = (type == 'product') ? productId : _self.goods_id;

        $.getJSON(creatUrl("simple/joinCart"),{"goods_id":goods_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content)
        {
            if(content.isError == false)
            {
                //鑾峰彇璐墿杞︿俊鎭�
                $.getJSON(creatUrl("simple/showCart"),{"random":Math.random},function(json)
                {
                    $('[name="mycart_count"]').text(json.count);
                    $('[name="mycart_sum"]').text(json.sum);

                    tips("鐩墠閫夎喘鍟嗗搧鍏�"+json.count+"浠讹紝鍚堣锛氾骏"+json.sum);
                });
            }
            else
            {
                alert(content.message);
            }
        });
    }

    //绔嬪嵆璐拱鎸夐挳
    this.buyNow = function()
    {
        //瀵硅鏍肩殑妫€鏌�
        if(_self.checkSpecSelected() == false)
        {
            tips('璇烽€夋嫨鍟嗗搧鐨勮鏍�');
            return;
        }

        //璁剧疆蹇呰鍙傛暟
        var buyNums = parseInt($.trim($('#buyNums').val()));
        var id      = _self.goods_id;
        var type    = 'goods';

        if($('#product_id').val())
        {
            id   = $('#product_id').val();
            type = 'product';
        }

        //鏅€氳喘涔�
        var url = "/simple/cart2/id/"+id+"/num/"+buyNums+"/type/"+type;

        //鏈変績閿€娲诲姩锛堝洟璐紝鎶㈣喘锛�
        if(_self.promo && _self.active_id)
        {
            url += "/promo/"+_self.promo+"/active_id/"+_self.active_id;
        }

        //椤甸潰璺宠浆
        window.location.href = creatUrl(url);
    }

    //鏋勯€犲嚱鏁�
    !(function()
    {
        //鏍规嵁IP鍦板潃鑾峰彇鎵€鍦ㄥ湴鍖虹殑鐗╂祦杩愯垂
        _self.initLocalArea();

        //鍟嗗搧瑙勬牸鏁版嵁鍒濆鍖�
        _self.initSpec();

        //鎻掑叆璐у搧ID闅愯棌鍩�
        $("<input type='hidden' id='product_id' alt='璐у搧ID' value='' />").appendTo("body");

        //缁戝畾鍟嗗搧鍥剧墖
        $('[thumbimg]').bind('click',function()
        {
            $('#picShow').prop('src',$(this).attr('thumbimg'));
            $('#picShow').attr('rel',$(this).attr('sourceimg'));
            $(this).addClass('current');
        });

        //缁戝畾璁ㄨ鍦堟寜閽�
        $('[name="discussButton"]').bind("click",function(){_self.sendDiscuss();});
        $('[name="sendDiscussButton"]').bind("click",function(){_self.sendDiscussData();});

        //缁戝畾鍟嗗搧鏁伴噺璋冩帶鎸夐挳
        $('#buyAddButton').bind("click",function(){_self.modified(1);});
        $('#buyReduceButton').bind("click",function(){_self.modified(-1);});
        $('#buyNums').bind("change",function()
        {
            //妫€鏌ヨ喘涔版暟閲忔槸鍚﹀悎娉�
            _self.checkBuyNums();

            //杩愯垂鏌ヨ
            _self.delivery(_self.province_id,_self.province_name);
        });

        //绔嬪嵆璐拱鎸夐挳
        $('#buyNowButton').bind('click',function(){_self.buyNow();});

        //鍔犲叆璐墿杞︽寜閽�
        $('#joinCarButton').bind('click',function(){_self.joinCart();});

        //搴撳瓨鍩熺粦瀹氫簨浠�,濡傛灉搴撳瓨涓嶈冻鏃犳硶璐拱鍜屽姞鍏ヨ喘鐗╄溅
        $('#data_storeNums').bind('change',function()
        {
            var storeNum = parseInt($(this).text());
            if(storeNum <= 0)
            {
                alert("褰撳墠璐у搧搴撳瓨涓嶈冻鏃犳硶璐拱");

                //鎸夐挳閿佸畾
                $('#buyNowButton,#joinCarButton').prop('disabled',true);
                $('#buyNowButton,#joinCarButton').addClass('disabled');
            }
            else
            {
                //鎸夐挳瑙ｉ攣
                $('#buyNowButton,#joinCarButton').prop('disabled',false);
                $('#buyNowButton,#joinCarButton').removeClass('disabled');
            }
        });

        //淇冮攢娲诲姩闅愯棌璐墿杞︽寜閽�
        if(_self.promo && _self.active_id)
        {
            $('#joinCarButton').hide();
        }
    }())
}

/**
 * 鑾峰彇璇勮鏁版嵁
 * @page 鍒嗛〉鏁�
 */
comment_ajax = function(page)
{
    if(!page && $.trim($('#commentBox').text()))
    {
        return;
    }

    page = page ? page : 1;
    $.getJSON(creatUrl("site/comment_ajax/page/"+page+"/goods_id/"+__GOODSID),function(json)
    {
        //娓呯┖璇勮鏁版嵁
        $('#commentBox').empty();

        for(var item in json.data)
        {
            var commentHtml = template.render('commentRowTemplate',json.data[item]);
            $('#commentBox').append(commentHtml);
        }
        $('#commentBox').append(json.pageHtml);
    });
}

/**
 * 鑾峰彇璐拱璁板綍鏁版嵁
 * @page 鍒嗛〉鏁�
 */
history_ajax = function(page)
{
    if(!page && $.trim($('#historyBox').text()))
    {
        return;
    }
    page = page ? page : 1;
    $.getJSON(creatUrl("site/history_ajax/page/"+page+"/goods_id/"+__GOODSID),function(json)
    {
        //娓呯┖璐拱鍘嗗彶璁板綍
        $('#historyBox').empty();
        $('#historyBox').parent().parent().find('.pages_bar').remove();

        for(var item in json.data)
        {
            var historyHtml = template.render('historyRowTemplate',json.data[item]);
            $('#historyBox').append(historyHtml);
        }
        $('#historyBox').parent().after(json.pageHtml);
    });
}

/**
 * 鑾峰彇鍜ㄨ璁板綍鏁版嵁
 * @page 鍒嗛〉鏁�
 */
refer_ajax = function(page)
{
    if(!page && $.trim($('#referBox').text()))
    {
        return;
    }
    page = page ? page : 1;
    $.getJSON(creatUrl("site/refer_ajax/page/"+page+"/goods_id/"+__GOODSID),function(json)
    {
        //娓呯┖璇勮鏁版嵁
        $('#referBox').empty();

        for(var item in json.data)
        {
            var commentHtml = template.render('referRowTemplate',json.data[item]);
            $('#referBox').append(commentHtml);
        }
        $('#referBox').append(json.pageHtml);
    });
}

/**
 * 鑾峰彇璐拱璁板綍鏁版嵁
 * @page 鍒嗛〉鏁�
 */
discuss_ajax = function(page)
{
    if(!page && $.trim($('#discussBox').text()))
    {
        return;
    }
    page = page ? page : 1;
    $.getJSON(creatUrl("site/discuss_ajax/page/"+page+"/goods_id/"+__GOODSID),function(json)
    {
        //娓呯┖璐拱鍘嗗彶璁板綍
        $('#discussBox').empty();
        $('#discussBox').parent().parent().find('.pages_bar').remove();

        for(var item in json.data)
        {
            var historyHtml = template.render('discussRowTemplate',json.data[item]);
            $('#discussBox').append(historyHtml);
        }
        $('#discussBox').parent().after(json.pageHtml);
    });
}