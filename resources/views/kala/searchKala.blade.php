@extends('layout.layout')
@section('content')
<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px; background-color:
             #ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;">
    </div>
    </div>
<section class="search px-0 container">
<div class="o-page__content" >
<article>
    <div class="c-listing">
        <div class="containerAli">
            <div class="rowAli">
                @foreach ($kala as $item)
                @php 
                $overLine=0;
                $showTakhfifPercent="none";
                $percentResult=0;
                if($item->Price4>0 and $item->Price3>0){
                    $percentResult=round((($item->Price4-$item->Price3)*100)/$item->Price4);
                    }else{
                        $percentResult=0;
                    }
                    if($percentResult==0 ){
                        $showTakhfifPercent="none";
                    }
                    if($item->activeTakhfifPercent==1 and $percentResult!=0){
                        $showTakhfifPercent="flex";
                        $overLine=1;
                    }else{
                        $showTakhfifPercent="none";
                    }
                @endphp
                    <div class="col-50 medium-25 mb-1">
                        <audio id="ring" src="{{url('/resources/assets/beep.mp3')}}"  controls style="display:none" preload="auto"></audio>
                        <div class="c-product-box py-1 c-promotion-box" style="min-height: 290px">
                            <a href="" class="c-product-box__img c-promotion-box__image">
								<img @if($logoPos==0) class="topLeft" @else class="topRight"  @endif alt="" src="{{ url('/resources/assets/images/starfood.png')}}">
                                <img alt="" src="{{ url('/resources/assets/images/kala/' . $item->GoodSn . '_1.jpg') }}">
                            </a>
                            <div class="c-product-box__content" style="width: 93%">
                                <a href="/descKala/itemCode/{{$item->GoodSn}}" class="title"
                                    style="display: block; min-height: 45px">{{ $item->GoodName }}</a>
                                <div class="d-flex justify-content-between"
                                    style="border-top: 1px solid gray;border-bottom: 1px solid gray;">
                                    <button style="background: transparent; font-size: 25px" id="hear{{$item->GoodSn}}" onclick="SetFavoriteGood({{$item->GoodSn}})" @if($item->favorite=='YES')   class="fas fa-heart text-danger" @else  class="far fa-heart" @endif ></button>
                                    <div style=''>
                                        <span  style=''>تخفیف</span>
                                        <div style=''>{{$percentResult}}%</div>
                                    </div>

                                    @if($item->Amount>0 )
                                    <span style="color: #39ae00; display: flex; align-items: center" class="price text-end">{{ $item->Price4/$currency }} {{$currencyName}}</span>
                                    <span style="color: #39ae00; display: flex; align-items: center" class="price text-end">{{ $item->Price3/$currency }} {{$currencyName}}</span>
                                    @else
                                    <span class="prikalaGroupPricece text-end fw-bold" id="request{{$item->GoodSn}}"> <button id="norequest{{$item->GoodSn}}" onclick="requestProduct({{Session::get('psn')}},{{$item->GoodSn}})" style="padding-right:10px;background-color:green;" class="btn-add-to-cart">اطلاع دهید</button></span>
                                    @endif
                                </div>
                            </div>
                            <div class="c-product__add">
                                <input type="hidden" value="515" id="PCode">
                                <input type="hidden" value="515" id="515">
                                <input type="hidden" value="count_515" id="count_515">
                                <input type="hidden" value="count1_515" id="count1_515">
                                <input type="hidden" value="1080" id="Exist_515">
                                <div class='c-product__add'  id="bought{{$item->GoodSn}}">
                                @if($item->bought=='Yes')
                                    <a class='btn-add-to-cart' value=''  id="updatedBought{{$item->GoodSn}}"
                                    onclick='UpdateQty({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})' 
                                        style='width:auto;text-align: center;    padding-right: 10px;
                                        background-color: #51ef39;
                                        font-weight: bold;'
                                        class='updateData btn-add-to-cart'>{{ $item->Amount / $item->PackAmount }}{{ $item->secondUnit }}
                                        معادل
                                        {{ $item->Amount / 1  }}{{ $item->firstUnit}}  </a>
                                        @endif
                                </div>
                                <button id="noBought{{$item->GoodSn}}" value="" style="padding-right:10px; font-weight: bold; @if($item->bought=='No') display: inline; @else display: none; @endif "
                                    onclick="AddQty({{$item->GoodSn}},this)" class="btn-add-to-cart">انتخاب تعداد<i
                                        class="far fa-shopping-cart text-white ps-2"></i></button> 
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</article>
</div>
</section>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function goBack() {
        window.history.back();
    }
    function AddQty(code, event) {
    $.ajax({
        type: "POST",
        url: "{{ url('/getUnits') }}",
        data: {_token: "{{ csrf_token() }}", Pcode: code },
        dataType: "json",
        success: function (msg) {
            $("#unitStuffContainer").html(msg);
            const modal = document.querySelector('.modalBackdrop');
            const modalContent = modal.querySelector('.modal');
            modal.classList.add('active');
            modal.addEventListener('click', () => {
                modal.classList.remove('active');
            });
            // modalContent.addEventListener('click', (e) => e.stopPropagation());
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

function UpdateQty(code, event, SnOrderBYS) {
        $.ajax({
            type: "get",
            url: "{{ url('/getUnitsForUpdate') }}",
            data: {
                _token: "{{ csrf_token() }}",
                Pcode: code
            },
            dataType: "json",
            success: function(msg) {
                $("#unitStuffContainer").html(msg);
                $(".SnOrderBYS").val(SnOrderBYS);

                const modal = document.querySelector('.modalBackdrop');
                const modalContent = modal.querySelector('.modal');
                modal.classList.add('active');
                modal.addEventListener('click', () => {
                    modal.classList.remove('active');
                });

                // modalContent.addEventListener('click', (e) => e.stopPropagation());
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    }

function SetFavoriteGood(snGood) {
$.ajax({
        type: "get",
        url: "{{ url('/setFavorite')}}",
        data: {_token: "{{ csrf_token() }}", goodSn: snGood },
        dataType: "json",
        success: function (msg) {
            var goodSn=msg.split('_')[1];
            var flag=msg.split('_')[0];
            if(flag=="added"){
             $('#hear'+goodSn).addClass('fas fa-heart text-danger');
            }
            if(flag=="deleted"){
             $('#hear'+goodSn).removeClass('fas fa-heart text-danger');
             $('#hear'+goodSn).addClass('far fa-heart');
            }
            // alert('added favorit'+msg);
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

window.onload = function() {
$(document).on('click', '.addData', (function() {
        var amountUnit=$(this).val().split('_')[0];
        var productId=$(this).val().split('_')[1];
        var showText=$(this).text()
    $.ajax({
        type: "get",
        url: "{{ url('/buySomething') }}",
        data: {_token: "{{ csrf_token() }}", kalaId: productId,amountUnit:amountUnit },
        dataType: "json",
        success: function (msg) {
        $('#bought'+productId).prepend(`<a class='btn-add-to-cart' value=''
            onclick='UpdateQty(,this,)' 
            style='width:auto;text-align: center;    padding-right: 10px;
            background-color: #51ef39;
            font-weight: bold;'
            class='updateData btn-add-to-cart'>`+showText+`</a>`);
            $('#noBought'+productId).css('display','none');
            var buys=parseInt($('#basketCountWeb').text());
            $('#basketCountWeb').text(buys+1)                               
        }
        ,
        error: function (msg) {
            console.log(msg);
        }
    });
}));

$(document).on('click', '.updateData', (function() {


    var amountUnit = $(this).val().split('_')[0];
    var productId = $(this).val().split('_')[1];
    var orderId = $('.SnorderBYS').val();
    var showText=$(this).text();
    $.ajax({
        type: "get",
        url: "{{ url('/updateOrderBYS') }}",
        data: {
            _token: "{{ csrf_token() }}",
            kalaId: productId,
            amountUnit: amountUnit,
            orderBYSSn: orderId
        },
        dataType: "json",
        success: function(msg) {
            $('#updatedBought'+productId).text(showText);
        },
        error: function(msg) {
            console.log(msg);
        }
    });
    }));
}
</script>
@endsection