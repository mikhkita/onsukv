var isDesktop = false,
    isTablet = false,
    isMobile = false,
    progress = new KitProgress("#FFAC00", 2),
    countQueue = {};

function LineBlockHeight(block){

    $(block).css("height","");

    var maxHeight = $(block).innerHeight();

    $(block).each(function(){
      if ( $(this).innerHeight() > maxHeight ) 
      { 
        maxHeight = $(this).innerHeight();
      }
    });
     
    $(block).innerHeight(maxHeight);
}

$(document).ready(function(){	

    if( $(".order-adress-map-form").length ){
        $(".b-input input").each(function(){
            $(this).parents(".b-input").removeClass("focus");
            if( $(this).val() != "" && $(this).val() != "+7 (   )    -  -  " ){
                $(this).parents(".b-input").addClass("not-empty");
            }else{
                $(this).parents(".b-input").removeClass("not-empty");
            }
        });

    }

    if($("#city").val() == "Москва"){
        $('.b-addresss-item__metro').removeClass('hide');
    }

    $("#city").on('change', function(){
        if ($(this).val() == "Москва") {
            $('.b-addresss-item__metro').removeClass('hide');
        } else {
            $('.b-addresss-item__metro').addClass('hide');
        }
    });

    if( typeof autosize == "function" )
        autosize(document.querySelectorAll('textarea'));

    function resize(){
       if( typeof( window.innerWidth ) == 'number' ) {
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;
        } else if( document.documentElement && ( document.documentElement.clientWidth || 
        document.documentElement.clientHeight ) ) {
            myWidth = document.documentElement.clientWidth;
            myHeight = document.documentElement.clientHeight;
        } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
            myWidth = document.body.clientWidth;
            myHeight = document.body.clientHeight;
        }

        if( myWidth > 1024 ){
            isDesktop = true;
            isTablet = false;
            isMobile = false;
        }else if( myWidth > 767 && myWidth < 1023 ){
            isDesktop = false;
            isTablet = true;
            isMobile = false;
        }else{
            isDesktop = false;
            isTablet = false;
            isMobile = true;
        }


        footerOuterHeight = !!$('.b-footer').outerHeight() ? $('.b-footer').outerHeight(true) + 30 : 0,
        headerHeight = 0;
        if($('.b-header').length){
            headerHeight = $('.b-header').outerHeight(true) + $(".b-header").offset().top;
        }
        var minHeight = myHeight - footerOuterHeight - headerHeight;
        if(minHeight >= 0){
            $('.b-content-block').css({
                'min-height': minHeight
            });
        } 
    }

    progress.endDuration = 0.2;

    $(window).resize(resize);
    resize();

    $.fn.placeholder = function() {
        if(typeof document.createElement("input").placeholder == 'undefined') {
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur().parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });
            });
        }
    }
    $.fn.placeholder();

    // $('.b-sort-block a').on('click', function(){
    //     if ($(this).hasClass('active')) {
    //         if ($(this).hasClass('up')) {
    //             $(this).removeClass('up');
    //             $(this).addClass('down');
    //         }
    //         else{
    //             $(this).removeClass('down');
    //             $(this).addClass('up');
    //         }
    //     }
    //     else{
    //         $('.b-sort-block a').removeAttr('class');
    //         $('.b-sort-block a').addClass('icon-arrow');
    //         $(this).addClass('active up');
    //     }
    //     return false;
    // });

    setInterval(function(){
        if( $(".b-gift").length ){
            $(".b-catalog-gifts").show();
        }else{
            $(".b-catalog-gifts").hide();
        }
    }, 200);

/******************************************/

    var menuSlideout = new Slideout({
        'panel': document.getElementById('panel-page'),
        'menu': document.getElementById('mobile-menu'),
        'side': 'left',
        'padding': 300,
        'touch': false
    });

    var catalogSlideout = new Slideout({
        'panel': document.getElementById('panel-page'),
        'menu': document.getElementById('mobile-catalog'),
        'side': 'right',
        'padding': 300,
        'touch': false
    });

    $('.mobile-menu').removeClass("hide");
    $('.mobile-catalog').removeClass("hide");

    $('.burger-menu').click(function() {
        menuSlideout.open();
        $('.mobile-menu').show();
        $('.mobile-catalog').hide();
        $(".b-menu-overlay").show();
        return false;
    });

    $('#catalog-menu-btn').click(function() {
        catalogSlideout.open();
        $('.mobile-catalog').show();
        $('.mobile-menu').hide();
        $(".b-menu-overlay").show();
        return false;
    });

    $('.b-menu-overlay').click(function() {
        menuSlideout.close();
        catalogSlideout.close();
        $('.b-menu-overlay').hide();
        return false;
    });

    menuSlideout.on('open', function() {
        $('.mobile-menu').removeClass("hide");
        $('.burger-menu').addClass("menu-on");
        $(".b-menu-overlay").show();
    });

    catalogSlideout.on('open', function() {
        $('.mobile-catalog').removeClass("hide");
        $(".b-menu-overlay").show();
    });

    menuSlideout.on('close', function() {
        setTimeout(function(){
            $("body").unbind("touchmove");
            $(".b-menu-overlay").hide();
        },100);
    });

    catalogSlideout.on('close', function() {
        setTimeout(function(){
            $("body").unbind("touchmove");
            $(".b-menu-overlay").hide();
        },100);
    });

    // var e = $('.b-menu-overlay, .mobile-menu');
    // var ev = $('.b-menu-overlay, .mobile-catalog');

    // e.touch();
    // ev.touch();

    // e.on('swipeLeft', function(event) {
    //     menuSlideout.close();
    // });

    // ev.on('swipeRight', function(event) {
    //     setTimeout(function(){
    //         $(".b-menu-overlay").hide();
    //     },200);
    //     catalogSlideout.close();
    // });

/******************************************/

    $('.menu-accordion').accordion({
        header: "> div > h3",
        collapsible: true,
        heightStyle: "content",
        active: false
    });

    // Добавление в корзину
    var cartTimeout = 0,
        successTimeout = 0;
    $("body").on("click",".b-btn-to-cart",function(){
        var url = $(this).attr("href"),
            $cont = $(this).parents(".b-basket-count-cont"),
            $this = $(this);

        if( $cont.find("input[name=quantity]").length ){
            $cont.find("input[name=quantity]").val($cont.find("input[name=quantity]").attr("data-min"));
            url = url + "&quantity=" + $cont.find("input[name=quantity]").attr("data-min");
        }
        
        clearTimeout(cartTimeout);

        $(this).parents(".b-basket-count-cont").addClass("b-item-in-basket");

        // if( $(".b-basket-table").length ){
        //     $("body, html").animate({
        //         scrollTop : $(".b-basket-table").offset().top - $(".b-fixed-back").height() - 20
        //     }, 300);    
        // }

        progress.start(1.5);

        $.ajax({
            type: "GET",
            url: url,
            success: function(msg){
                progress.end();

                if( isValidJSON(msg) ){
                    var json = JSON.parse(msg);

                    if( json.result == "success" ){
                        if( json.action == "reload" ){
                            window.location.reload();
                        }else{
                            updateBasket(json.count, json.sum);
                        }
                    }
                }else{
                    alert("Ошибка добавления в корзину");
                }
            },
            error: function(){
                alert("Ошибка добавления в корзину");
            }
        });

        // if( $(".b-top-basket-mobile:visible").length ){
        //     $(".b-basket ul").html("<li class='b-preload-cart'><img src=\"/bitrix/templates/main/html/i/preload.svg\" alt=\"\" class=\"b-svg-preload b-svg-preload-popup\"></li>");

        //     if( !$(".b-basket-table").length ){
        //         $(".b-top-basket-mobile").click();
        //     }else{
        //         $("body, html").animate({
        //             scrollTop : $(".b-inner-cart").offset().top-53
        //         }, 300);
        //     }
        // }

        return false;
    });

    function isValidJSON(src) {
        var filtered = src+"";
        filtered = filtered.replace(/\\["\\\/bfnrtu]/g, '@');
        filtered = filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']');
        filtered = filtered.replace(/(?:^|:|,)(?:\s*\[)+/g, '');

        return (/^[\],:{}\s]*$/.test(filtered));
    }

    function changeWholesale(){
        if( $(".b-dynamic-price").length && $(".b-dynamic-discount-price").length && $(".b-detail-right").length ){
            var value = $(".b-quantity-input").val()*1;

            $(".b-dynamic-discount-price").hide();
            $(".b-dynamic-price.price").show();

            $(".b-dynamic-discount-price").each(function(){
                var from = $(this).attr("data-from")*1;
                if( value >= from ){
                    $(".b-dynamic-price, b-dynamic-discount-price").hide();
                    $(this).show();
                }
            });
        }
    }

    changeWholesale();

    // Изменение количества в каталоге по кнопкам
    $("body").on("click", ".b-change-quantity", function(){
        var $input = $(this).parents(".b-input-cont").find("input"),
            quantity = $input.val()*1,
            side = $(this).attr("data-side"),
            maxBasketCount = $input.attr("data-max")*1,
            minBasketCount = $input.attr("data-min")*1;

        if( (quantity == 0 && side == "-") || (quantity == maxBasketCount && side == "+") ){
            if( quantity == maxBasketCount && side == "+" ){
                $(this).parents(".b-basket-count-cont").find(".b-error-max-count").show();
            }

            return false;
        }
        $(this).parents(".b-basket-count-cont").find(".b-error-max-count").hide();

        if( quantity == minBasketCount && side == "-" ){
            quantity = 0;
        }else{
            quantity = (side == "+")?(quantity+1):(quantity-1);

            if( quantity < minBasketCount ){
                quantity = minBasketCount;
            }
        }        
        
        $input.val(quantity).change();

        if( quantity == 0 ){
            $(this).parents(".b-basket-count-cont").removeClass("b-item-in-basket");
        }

        return false;
    });

    // Изменение количества в каталоге путем ввода
    $("body").on("change", ".b-quantity-input", function(){
        var url = $(this).parents(".input-cont").find(".icon-minus").attr("href"),
            $item = $(".b-cart-item[data-id='"+$(this).parents("li, tr").attr("data-id")+"']"),
            $input = $(this),
            quantity = $input.val()*1,
            maxBasketCount = $input.attr("data-max"),
            minBasketCount = $input.attr("data-min"),
            id = $(this).attr("data-id")*1;

        if( quantity > maxBasketCount ){
            $(this).parents(".b-basket-count-cont").find(".b-error-max-count").show();
        }else{
            $(this).parents(".b-basket-count-cont").find(".b-error-max-count").hide();
        }

        quantity = ( quantity < 0 )?0:quantity;
        quantity = ( quantity > maxBasketCount )?maxBasketCount:quantity;

        if( quantity == 0 ){
            $(this).parents(".b-basket-count-cont").removeClass("b-item-in-basket");
        }else{
            if( quantity < minBasketCount ){
                quantity = minBasketCount;
            }
        }
        
        $input.val(quantity);
        $item.find("p.b-basket-item-count").text(quantity+" шт.");
        $item.find("select.b-basket-item-count").val(quantity);

        ajaxChangeQuantity(id, quantity);
    });

    var quantityDelays = [];

    function ajaxChangeQuantity(id, quantity){
        if( typeof quantityDelays[id] == "undefined" ){
            quantityDelays[id] = 0;
        }
        if( typeof countQueue[id] == "undefined" ){
            countQueue[id] = 0;
        }

        clearTimeout(quantityDelays[id]);

        changeWholesale();

        quantityDelays[id] = setTimeout(function(){
            quantityDelays[id] = 0;

            countQueue[id]++;

            progress.start(1.5);

            $.ajax({
                type: "GET",
                url: "/ajax/?action=QUANTITY",
                data: { 
                    QUANTITY : quantity,
                    ELEMENT_ID : id
                },
                success: function(msg){
                    var reg = /<!--([\s\S]*?)-->/mig;
                    msg = msg.replace(reg, "");
                    var json = JSON.parse(msg);

                    countQueue[id]--;

                    progress.end();

                    if( json.result == "success" ){

                        if( countQueue[id] == 0 && quantityDelays[id] == 0 ){
                            // console.log(json.quantity);
                            $(".b-quantity-input[data-id='"+json.id+"']").val(json.quantity);

                            if( json.quantity == 0 ){
                                $(".b-quantity-input[data-id='"+json.id+"']").parents(".b-basket-count-cont").removeClass("b-item-in-basket");
                            }
                        }

                        updateBasket(json.count, json.sum);
                    }else{
                        alert("Ошибка изменения количеста, пожалуйста, обновите страницу");
                    }
                },
                error: function(){
                    countQueue[id]--;
                }
            });
        }, 500);
    }

    function updateBasket(count, sum){
        $(".cart-count").text( count + " шт." );
        $(".cart-sum").text( sum );

        if( $(".cart-sum").text() == "0" ){
            $(".cart-sum").hide();
            $(".cart-count").hide();
        }else{
            $(".cart-sum").show();
            $(".cart-count").show();
        }
    }

    function trigger(id, event){
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent(event, true, true); 
        document.getElementById(id).dispatchEvent(evt);
    }

    if( $("select#delivery").length ){
        var delTimer = null;
        $("select#delivery").change(function(){
            var price = ($("select#delivery option:checked").attr("data-price"))?$("select#delivery option:checked").attr("data-price"):0 ,
                date = $("select#delivery option:checked").attr("data-date"),
                calc = $("select#delivery option:checked").attr("data-calc");
            $("select#delivery").attr("data-price", price);
            $("select#delivery").attr("data-date", date);

            $("#time").html('');
            $("#mkad").val('');

            $(".b-pickpoint, .b-cdek-choose, .b-order-addr-cont, #b-time-input, #b-mkad-input, #b-metro-input, #b-srok-delivery").hide();

            $(".cdekaddr, .b-postamat-error").remove();
            $("#b-cdek-punk-addr").html("не выбран");

            // if( isValidJSON(price) ){
            //     var json = JSON.parse(price);
            //     if( json.length ){
            //         price = 0;
            //     }
            // }
            // alert(price);
            // console.log(price*1);
            // console.log(typeof price);

            if( $(this).val() !== "53" && $(this).val() !== "54" && $(this).val() !== "55" ){
                $("#b-delivery-price-input").val( price*1 ).trigger("change");
                // trigger("b-delivery-price-input", "change");
            }

            $(".b-delivery-info").hide();
            if( $("#delivery-info-"+$(this).val()).length ){
                $("#delivery-info-"+$(this).val()).show();
            }

            $("#b-date-deliv").html("Дата доставки");

            switch ($(this).val()) {
                case "26":
                    $("#time").html(
                        '<option value="с 10 до 18">с 10 до 18</option>'
                    );
                    $("#b-mkad-input").show();
                    $("#b-time-input").show();
                    break;
                case "27":
                    $("#time").html(
                        '<option value="с 10 до 18">с 10 до 18</option>'+
                        '<option value="с 10 до 15">с 10 до 15</option>'+
                        '<option value="с 13 до 18">с 13 до 18</option>'
                    );
                    $("#b-metro-input").show();
                    $("#b-time-input").show();
                    break;
                case "30":
                    $("#b-date-deliv").html("Дата сборки");
                    $(".b-pickpoint").show();
                    break;
                case "53":
                    $("#b-date-deliv").html("Дата сборки");
                case "54":
                    $("#b-date-deliv").html("Дата сборки");
                case "55":
                    $("#b-date-deliv").html("Дата сборки");
                    $(".b-order-addr-cont").show();
                    if( !$(".b-addr-radio:checked").length ){
                        $(".b-addr-radio").eq(0).prop("checked", true).trigger("change");
                    }else{
                        $(".b-addr-radio:checked").trigger("change");
                    }
                    break;
                case "116":
                    $("#b-date-deliv").html("Дата сборки");
                    break;
                case "120":
                    $("#b-date-deliv").html("Дата сборки");
                    $(".b-cdek-input").show();
                    $("#cdek_type").trigger("change");

                    if( $("#b-srok-delivery").text() != "" ){
                        $("#b-srok-delivery").show();
                    }
                    break;
                default:
                    
                    break;
            }

            disableDates();
        });

        $("#cdek_type").change(function(){
            if( $(this).val() == 2 ){
                $(".b-cdek-addr").hide();
                $(".b-order-addr-cont").show();

                if( !$(".b-addr-radio:checked").length ){
                    $(".b-addr-radio").eq(0).prop("checked", true).trigger("change");
                }else{
                    $(".b-addr-radio:checked").trigger("change");
                }

                $("#city").trigger("change");
            }else{
                $(".b-cdek-addr").show();
                $(".b-order-addr-cont").hide();

                IPOLSDEK_pvz.setPrices();
            }
        });

        $("#b-delivery-price-input").on("change", function(){
            var price = $(this).val();

            console.log($(this).val());

            $("#b-delivery-price").html( price );

            clearTimeout(delTimer);
            delTimer = setTimeout(function(){
                BX.Sale.BasketComponent.sendRequest('refreshAjax', {
                    fullRecalculation: 'Y'
                });
            }, 300);
        });

        $("#mkad").change(function(){
            var value = $(this).val(),
                price = $("select#delivery option:checked").attr("data-price");

            if( value*1 < 0 ){
                $(this).val(0);
                value = 0;
            }
            if( price ){
                price = price*1 + (value * 25);

                $("#b-delivery-price-input").val( price ).trigger("change");
            }
        });

        var $totalsum = $("#total_sum_pickpoint"),
            levels = $totalsum.attr( 'data-levels' ),
            levels_list = [];

        for ( var t = 1; t < levels; t++ ) {
                     // console.log( levels_list, t, levels, $totalsum );
            levels_list.push( {
                'match': new RegExp( $totalsum.attr( 'data-' + t + '-match' ), 'i' ),
                'price': parseFloat( $totalsum.attr( 'data-' + t + '-price' ) ),
                'level': t
            } );
        }

        $( window ).on( 'pickpoint_ready', function() {
            var addr_string = $(".pickpointaddr").val();

            $( '#no_price_to_pocikpoint' ).remove();

            var price_found = false;

            if ( typeof levels_list !== 'undefined' && price_found === false )
            {
                $.each( levels_list, function()
                {
                    try
                    {
                        if ( this.match.test( addr_string ) && price_found === false )
                        {
                            // console.log(this);
                            $("#b-delivery-price-input").val( this.price ).trigger("change");

                            price_found = true;
                        }
                    }
                    catch ( e )
                    {
                        console.error( e );
                    }
                } );
            }

            if ( price_found === false )
            {
                $(".b-delivery-price").after(
                    '<span id="no_price_to_pocikpoint">Окончательную стоимость рассчитывает оператор</span>' );
                $("#b-delivery-price-input").val( 0 ).trigger("change");
            }
        } );

        $(".b-addr-radio").change(function(){
            var address = $(this).attr("data-address"),
                index = $(this).attr("data-index"),
                region = $(this).attr("data-region"),
                city = $(this).attr("data-city"),
                room = $(this).attr("data-room"),
                value = $(this).val();

            $(".basket-checkout-block-btn").addClass("loading");

            if( value == "NEW" ){
                address = index = region = room = "";   

                $(".b-order-addr-new").show();
                $("#js-order-adress-map-input").trigger("focusin").focus();
            }else{
                $(".b-order-addr-new").hide();
            }

            $("#js-order-adress-map-input").val(address);
            $("#city").val(city);
            $("#number-room-input").val(room);
            $("#postal-code").val(index);
            $("#region").val(region);

            if( $("#delivery").val() == "120" ){
                $("#city").trigger("change");
            }else{
                $("#region").trigger("change");
            }
        });

        $("#region").change(function(){
            calculatePost();
        });

        $("#city").on("change", function(){
            // alert($(this).val());
            // console.log($(this).val()+Math.random());
            if( $("select#delivery").val() == "120" ){
                IPOLSDEK_pvz.chooseCity($(this).val());
            }
        });
    }

    function calculatePost(){
        var deliveryID = $("select#delivery").val();
        if( deliveryID != "53" && deliveryID != "54" && deliveryID != "55" ){
            return true;
        }
        
        var sum = $(".basket-coupon-block-total-price-current").attr("data-price").replace(/\D\.+/g,""),
            weigth = $(".basket-coupon-block-total-price-current").attr("data-weigth").replace(/\D\.+/g,""),
            calc = $("#delivery").attr("data-price"),
            priceAr = null,
            price = 0;

        $( '#no_price_to_pocikpoint' ).remove();

        if( isValidJSON(calc) && calc != "" ){
            calc = JSON.parse(calc);

            if( calc.length ){
                priceAr = calc;
            }
        }else{
            priceAr = null;
        }

        price = getDeliveryPriceBySum(sum, priceAr);

        // if( price == null ){

        // }else{
        if( sum*1 >= 20000 || weigth*1 >= 10 || isNeedMessage() ){
            $(".b-delivery-price").after('<span id="no_price_to_pocikpoint" class="red">Точная стоимость доставки будет рассчитана оператором индивидуально и может поменяться.</span>' );
        }

        price *= getPriceK( $("#region").val() );

        $("#b-delivery-price-input").val( price*1 ).trigger("change");
        // }
    }

    function isNeedMessage(){
        var cities = new RegExp( "Магадан|Саратов|Норильск", 'i' );

        return cities.test( $("#region").val() );
    }

    function getDeliveryPriceBySum(sum, priceAr){
        sum = sum*1;

        for( var i in priceAr ){
            var from = priceAr[i][0]*1,
                to = priceAr[i][1]*1,
                price = priceAr[i][2]*1;
            
            if( from <= sum && sum <= to ){
                return price;
            }
        }

        return 0;
    }

    $("body").on("change", "#basket-sort", function(){
        BX.Sale.BasketComponent.sortSortedItems(true);
        BX.Sale.BasketComponent.shownItems = [];
        $("#basket-item-table").html("");
        BX.Sale.BasketComponent.initializeBasketItems();
    });

    function disableDates(){
        var date = $("select#delivery").attr("data-date"),
            deliveryID = $("select#delivery").val();

        $("select#date option").each(function(){
            // if( deliveryID != 4 && $(this).attr("data-isSunday") == "Y" ){
            //     date++;
            // }
            if( $(this).index() < date || ( deliveryID != 32 && $(this).attr("data-isSunday") == "Y" )  || $(this).attr("data-disabled") == "Y"){
                $(this).prop("disabled", true);
            }else{
                $(this).prop("disabled", false);
            }
        });

        if( deliveryID == 53 || deliveryID == 54 || deliveryID == 55 || deliveryID == 30 || deliveryID == 120 ){
            $("select#date").prop( "disabled", true );
        }else{
            $("select#date").prop( "disabled", false );
        }

        // if( !$('select#date option:not([disabled]):selected').length ){
            $("select#date").val( $('select#date option:not([disabled]):first').attr("value") );
        // }
    }

    $(".b-catalog-slider").slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        cssEase: 'ease', 
        speed: 500,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev slick-arrow icon-arrow"></button>',
        nextArrow: '<button type="button" class="slick-next slick-arrow icon-arrow"></button>',
        touchThreshold: 100,
        responsive: [
            {
                breakpoint: 1150,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });

    if( $(".b-detail-text-wrap").length ){
        // console.log([$(".b-detail-text-wrap").height(), $(".b-detail-text").height()]);
        if( $(".b-detail-text-wrap").height() > $(".b-detail-text").height() ){
            $(".b-detail-text-more").css("display", "inline-block");
        }else{
            $(".b-detail-text").removeClass("limit");
        }
    }

    $("body").on("click", ".b-detail-text-more", function(){
        if( $(".b-detail-text").hasClass("limit") ){
            $(".b-detail-text").removeClass("limit");
            $(this).text("Скрыть текст");
        }else{
            $(".b-detail-text").addClass("limit");
            $(this).text("Читать полностью");

            $("body, html").animate({
                scrollTop : $(".b-detail-text").offset().top - 8
            }, 300);
        }

        return false;
    });

    $(".b-reviews-count p").click(function(){
        if( $(".b-detail-reviews").length ){
            $("body, html").animate({
                scrollTop : $(".b-detail-reviews").offset().top + 1
            }, 300);
        }
    });

    $('.b-review-input .b-star').hover(function(){

        var index = parseInt($(this).index()) + 1;

        $(this).parent().find('.b-star').each(function(){
            $(this).css('color', '#CCC');
            if ($(this).index() < index) {
                $(this).css('color', '#FFAC00');
            }
        });
    })

    $('.b-review-input .b-star').mouseout(function() {
        $(this).parent().find('.b-star').css('color', '');
    });

    $('.b-review-input .b-star').on('click', function(){

        var index = parseInt($(this).index()) + 1;
        $(this).parent().removeClass('b-stars-0 b-stars-1 b-stars-2 b-stars-3 b-stars-4 b-stars-5');
        $(this).parent().addClass(('b-stars-'+index));
        $(this).parents('.b-review-input').find('input').val(index);

    });

    $('.item-review-btn').on('click', function(){ // добавить id товара в action формы

        var form = $('#b-review-form').find('form')
        var text = form.attr('action');
        var term = "product_id=";
        var id = $(this).attr('data-id');

        if (text.indexOf(term) != -1){
            if (text.indexOf(term) + term.length == text.length) {
                form.attr('action', text + id);
            }
        }
            
    });

    if ($('#pluploadCont').length){

        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickfiles', // you can pass an id...
            container: document.getElementById('pluploadCont'), // ... or DOM Element itself
            url : $('#b-form-review').attr("data-file-action"),
            multi_selection: false,
            
            filters : {
                max_file_size : '20mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg,jpeg,gif,png"},
                    {title : "Documents", extensions : "doc,docx,pdf,rtf,xls,xlsx"},
                    {title : "Archive", extensions : "zip,rar,7z"},
                ]
            },

            init: {
                PostInit: function() {
                    // var msgNoSupport = document.getElementById('plupload-no-support');
                    // msgNoSupport.parentNode.removeChild(msgNoSupport);
                    
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        if (up.files.length > 1) {
                            up.removeFile(up.files[0]);
                        }
                        // document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        // document.getElementById("pickfiles").innerHTML = "Резюме выбрано";
                        $("#original_filename").val(file.name);
                        document.getElementById("pickfiles").className = "attach successful";
                    });
                    up.start();
                    
                },
                UploadProgress: function(up, file) {
                    document.getElementById("pickfiles").innerHTML = "Загрузка&nbsp;" + file.percent + "%";
                },
                FileUploaded: function(up, file, res) {
                    document.getElementById("pickfiles").innerHTML = "Файл прикреплен";
                    document.getElementById("pickfiles").className = "attach successful";
                    var json = JSON.parse(res.response);
                    $("#random_filename").val(json.filePath); 
                    // console.log(res.response);
                },
                Error: function(up, err) {
                    // alert("При загрузке файла произошла ошибка.\n" + err.code + ": " + err.message);
                    if (err.code == -600) {
                        document.getElementById("pickfiles").innerHTML = "Файл слишком большой";
                        document.getElementById("pickfiles").className = "attach error";
                    };
                    if (err.code == -601) {
                        document.getElementById("pickfiles").innerHTML = "Неверный формат файла";
                        document.getElementById("pickfiles").className = "attach error";
                    };
                }
            }
        });
        uploader.init();
    }

    if( $('.menu-accordion').length ){
        $('.menu-accordion').accordion({
            header: "> div > h3",
            collapsible: true,
            heightStyle: "content",
            active: false
        });
    }

    if( $('.b-accordion-item').length ){
        $('.b-accordion-item').accordion({
            header: ">h3",
            collapsible: true,
            heightStyle: "content",
            active: false
        });
    }

    if( $('.b-delivery-accordion-inner-item').length ){
        $('.b-delivery-accordion-inner-item').accordion({
            header: "h4",
            collapsible: true,
            heightStyle: "content",
            active: false
        });
    }

    if( isIE() ){
        $("body").on('mousedown click', ".b-input input, .b-input textarea", function(e) {
            $(this).parents(".b-input").addClass("focus");
        });
    }

    $("body").on("focusin", ".b-input input, .b-input textarea", function(){
        $(this).parents(".b-input").addClass("focus");
    });

    $("body").on("change", ".b-input select", function(){
        if( $(this).val() != ""){
            $(this).parents(".b-input").addClass("not-empty");
        }else{
            $(this).parents(".b-input").removeClass("not-empty");
        }
    });

    $("body").on("focusout", ".b-input input, .b-input textarea", function(){
        $(this).parents(".b-input").removeClass("focus");
        if( $(this).val() != "" && $(this).val() != "+7 (   )    -  -  " ){
            $(this).parents(".b-input").addClass("not-empty");
        }else{
            $(this).parents(".b-input").removeClass("not-empty");
        }
    });

    function isIE() {
        var rv = -1;
        if (navigator.appName == 'Microsoft Internet Explorer')
        {
            var ua = navigator.userAgent;
            var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat( RegExp.$1 );
        }
        else if (navigator.appName == 'Netscape')
        {
            var ua = navigator.userAgent;
            var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat( RegExp.$1 );
        }
        return rv == -1 ? false: true;
    }

    // // Первая анимация элементов в слайде
    // $(".b-step-slide[data-slick-index='0'] .slider-anim").addClass("show");

    // // Кастомные переключатели (тумблеры)
    // $(".b-step-slider").on('beforeChange', function(event, slick, currentSlide, nextSlide){
    //     $(".b-step-tabs li.active").removeClass("active");
    //     $(".b-step-tabs li").eq(nextSlide).addClass("active");
    // });

    // // Анимация элементов в слайде
    // $(".b-step-slider").on('afterChange', function(event, slick, currentSlide, nextSlide){
    //     $(".b-step-slide .slider-anim").removeClass("show");
    //     $(".b-step-slide[data-slick-index='"+currentSlide+"'] .slider-anim").addClass("show");
    // });


    
	// var myPlace = new google.maps.LatLng(55.754407, 37.625151);
 //    var myOptions = {
 //        zoom: 16,
 //        center: myPlace,
 //        mapTypeId: google.maps.MapTypeId.ROADMAP,
 //        disableDefaultUI: true,
 //        scrollwheel: false,
 //        zoomControl: true
 //    }
 //    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 

 //    var marker = new google.maps.Marker({
	//     position: myPlace,
	//     map: map,
	//     title: "Ярмарка вакансий и стажировок"
	// });

});

function getPriceK(region){
    var regions = [
        'Амурская',
        'Камчатский',
        'Магаданская',
        'Приморский',
        'Саха /Якутия/',
        'Сахалинская',
        'Хабаровский',
        'Чукотский',

        'Алтайский',
        'Забайкальский',
        'Иркутская',
        'Красноярский',
        'Кемеровская',
        'Новосибирская',
        'Омская',
        'Алтай',
        'Бурятия',
        'Тыва',
        'Хакасия',
        'Томская',

        'Курганская',
        'Свердловская',
        'Тюменская',
        'Ханты-Мансийский Автономный округ - Югра',
        'Челябинская',
        'Ямало-Ненецкий',

        'Карелия',
        'Коми',
        'Архангельская',
        'Ненецкий',
        'Мурманская',
    ];

    for( var i in regions ){
        if( region.indexOf(regions[i], 0) !== -1){
            return 2
        }
    }
    return 1;
}

function pickPointHandler(object){
    $(".pickpointinfo").remove();
    $( "#pickpoint-delivery-point" )
        .html( object.name + '<br />' + object.address )
        .after( '<input type="hidden" class="pickpointinfo" name="ORDER_PROP_19" value="' + object.id + '" />' )
        .after( '<input type="hidden" class="pickpointinfo" name="ORDER_PROP_18" value="' + object.name + '" />' )
        .after( '<input type="hidden" class="pickpointinfo pickpointaddr" name="ORDER_PROP_7" value="' + object.address + '" />' );

    $(".b-postamat-error").remove();

    $( window ).trigger( 'pickpoint_ready' );
}