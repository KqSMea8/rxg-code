//鍟嗗搧绉婚櫎璐墿杞�
function removeCart(goods_id,type)
{
    var goods_id = parseInt(goods_id);
    $.getJSON(creatUrl("simple/removeCart"),{goods_id:goods_id,type:type},function(content){
        if(content.isError == false)
        {
            $('[name="mycart_count"]').html(content.data['count']);
            $('[name="mycart_sum"]').html(content.data['sum']);
        }
        else
        {
            alert(content.message);
        }
    });
}

//娣诲姞鏀惰棌澶�
function favorite_add_ajax(goods_id,obj)
{
    $.getJSON(creatUrl("simple/favorite_add"),{"goods_id":goods_id,"random":Math.random()},function(content){
        alert(content.message);
    });
}

//璐墿杞﹀睍绀�
function showCart()
{
    $.getJSON(creatUrl("simple/showCart"),{sign:Math.random()},function(content)
    {
        var cartTemplate = template.render('cartTemplete',{'goodsData':content.data,'goodsCount':content.count,'goodsSum':content.sum});
        $('#div_mycart').html(cartTemplate);
        $('#div_mycart').show();
    });
}


//dom杞藉叆鎴愬姛鍚庡紑濮嬫搷浣�
$(function(){
    //璐墿杞︽暟閲忓姞杞�
    if($('[name="mycart_count"]').length > 0)
    {
        $.getJSON(creatUrl("simple/showCart"),{sign:Math.random()},function(content)
        {
            $('[name="mycart_count"]').html(content.count);
        });

        //璐墿杞iv灞傛樉绀哄拰闅愯棌鍒囨崲
        var mycartLateCall = new lateCall(200,function(){showCart();});
        $('[name="mycart"]').hover(
            function(){
                mycartLateCall.start();
            },
            function(){
                mycartLateCall.stop();
                $('#div_mycart').hide('slow');
            }
        );
    }
});

//[ajax]鍔犲叆璐墿杞�
function joinCart_ajax(id,type)
{
    $.getJSON(creatUrl("simple/joinCart"),{"goods_id":id,"type":type,"random":Math.random()},function(content){
        if(content.isError == false)
        {
            var count = parseInt($('[name="mycart_count"]').html()) + 1;
            $('[name="mycart_count"]').html(count);
            alert(content.message);
        }
        else
        {
            alert(content.message);
        }
    });
}

//鍒楄〃椤靛姞鍏ヨ喘鐗╄溅缁熶竴鎺ュ彛
function joinCart_list(id)
{
    $.getJSON(creatUrl("/simple/getProducts"),{"id":id},function(content)
    {
        if(!content || content.length == 0)
        {
            joinCart_ajax(id,'goods');
        }
        else
        {
            artDialog.open(creatUrl("/block/goods_list/goods_id/"+id+"/type/radio/is_products/1"),{
                id:'selectProduct',
                title:'閫夋嫨璐у搧鍒拌喘鐗╄溅',
                okVal:'鍔犲叆璐墿杞�',
                ok:function(iframeWin, topWin)
                {
                    var goodsList = $(iframeWin.document).find('input[name="id[]"]:checked');

                    //娣诲姞閫変腑鐨勫晢鍝�
                    if(goodsList.length == 0)
                    {
                        alert('璇烽€夋嫨瑕佸姞鍏ヨ喘鐗╄溅鐨勫晢鍝�');
                        return false;
                    }
                    var temp = $.parseJSON(goodsList.attr('data'));

                    //鎵ц澶勭悊鍥炶皟
                    joinCart_ajax(temp.product_id,'product');
                    return true;
                }
            })
        }
    });
}