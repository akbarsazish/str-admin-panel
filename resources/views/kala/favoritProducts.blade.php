@extends('layout.layout')
@section('content')
<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px;
        background-color:#ffffff66; padding:5px; width: 100%; max-height: 85vh; overflow: auto;">
    </div>
</div>

<section class="search container topDistance">
    <div class="o-page__content" style="margin: 0 auto">
        <div class="c-listing" style="padding:0; width:100%;">
            <div class="rowAli">
                <audio controls preload="auto" id="ring" style="display: none;">
                    <source src="{{url('/resources/assets/beep.mp3')}}" controls></source>
                </audio>
                @foreach ($favorits as $item)
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
                     <div class="col-50 medium-25 mb-1 listKalaAtmedia">
                        <audio id="ring" src="{{url('/resources/assets/beep.mp3')}}"  controls style="display:none" preload="auto"></audio>
                        <div class="c-product-box py-1 c-promotion-box mobile-promotion-box">
                            <div class="row row-cols-2" style="width:100%; font-size: 12px;display:{{$showTakhfifPercent}}">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="takhfif-round">{{$percentResult}}%</div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                </div>
                            </div>
                            <a href="{{url('/descKala/'.$item->GoodGroupSn.'/itemCode/'.$item->GoodSn)}}" class="c-product-box__img c-promotion-box__image">
                            @if(file_exists('resources/assets/images/kala/' . $item->GoodSn . '_1.jpg'))
								<img @if($logoPos==0) class="topLeft" @else class="topRight" @endif alt="" src="{{ url('/resources/assets/images/starfood.png')}}">
                                <img alt="" src="{{url('/resources/assets/images/kala/' . $item->GoodSn . '_1.jpg') }}">
                            @else
                                <img alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}">
                            @endif
                            </a>
                            
                            <a href="{{url('/descKala/'.$item->GoodGroupSn.'/itemCode/'.$item->GoodSn)}}" class="title fw-bold kala-list-title text-center" style="text-decoration: none; color:black; height:44px;">{{ $item->GoodName }}</a>
                            <div class="c-product-box__content kala-list-price" style="width: 93%; height:44px">
                                <div class="d-flex justify-content-between kalaGroup" style="border-top: 1px solid gray;border-bottom: 1px solid gray;height:55px;">
                                    <button style="background: transparent; font-size:22px" id="hear{{$item->GoodSn}}" onclick="SetFavoriteGood({{$item->GoodSn}})" @if($item->favorite=='YES')   class="fas fa-heart text-danger" @else  class="far fa-heart" @endif ></button>
                                        @if($overLine==1)
                                        <div class="prikalaGroupPricece text-end fw-bold" style="color:red; font-size:14px;"><del>{{number_format($item->Price4/$currency)}} </del> {{$currencyName}}</div>
                                        @endif
                                        @if($item->Amount>0 or $item->activePishKharid>0 or $item->freeExistance>0)
                                        <span class="prikalaGroupPricece text-end fw-bold">{{number_format($item->Price3/$currency)}} {{$currencyName}}</span>
                                        @else
                                        @if($item->requested==0)
                                            <span class="prikalaGroupPricece text-end fw-bold mt-1" id="request{{$item->GoodSn}}"> <button value="0" id="preButton{{$item->GoodSn}}"  onclick="requestProduct({{Session::get('psn')}},{{$item->GoodSn}})" style="padding-right:10px;background-color:rgb(249, 6, 6); font-size:14px;" class="btn-add-to-cart">خبرم کنید <i class="fas fa-bell"></i></button></span>
                                        @else
                                            <span class="prikalaGroupPricece text-end fw-bold" id="norequest{{$item->GoodSn}}"> <button value="1" id="afterButton{{$item->GoodSn}}"  style="padding-right:10px;  border: 2px solid rgb(251, 10, 10);
                                                background-color: white; color: rgb(232, 20, 20); font-size: 16px;
                                                cursor: pointer;" onclick="cancelRequestKala({{Session::get('psn')}},{{$item->GoodSn}})" class="btn-add-to-cart">اعلام شد</button>
                                            </span>
                                        @endif
                                        @endif
                                </div>
                              </div>
                            <div class="c-product__add pt-1 pb-1 mt-3" style="display: flex; justify-content:center;">
                                <div class='c-product__add'  id="bought{{$item->GoodSn}}">
                                    @if($item->activePishKharid<1)
                                        @if($item->bought=='Yes' and $item->Amount>0)
                                            <a class='btn-add-to-cart' value='' id="updatedBought{{$item->GoodSn}}" onclick='UpdateQty({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})'
                                                style='width:auto;text-align: center; padding-right: 10px; background-color: #39ae00; font-weight: bold;'
                                                class='updateData btn-add-to-cart'>{{ $item->Amount / $item->PackAmount }}{{ $item->secondUnit }}
                                                معادل
                                            {{ $item->Amount / 1  }}{{ $item->UNAME}}  </a>
                                        @endif
                                        @if($item->callOnSale==1)
                                        <button value="" style="padding-right:8px; background-color:#e40707; font-weight: bold; display: inline;" class="btn-add-to-cart">برای خرید تماس بگیرید
                                            <i class="far fa-shopping-cart text-white ps-2"></i>
                                        </button>
                                        @else
                                            @if($item->Amount>0 or $item->freeExistance>0)
                                                <button id="noBought{{$item->GoodSn}}" value="" style="padding-right:8px; background-color:#e40707; font-weight: bold; @if($item->bought=='No') display: inline; @else display: none; @endif " onclick="AddQty({{$item->GoodSn}},this)" class="btn-add-to-cart">انتخاب تعداد
                                                <i class="far fa-shopping-cart text-white ps-2"></i>
                                            </button>
                                            @else
                                            <button id="btnCount_789" value="" style="padding-right:10px;  border: 1px solid rgb(202, 199, 199);font-weight:bold;
                                            background-color: rgb(202, 199, 199);color: rgb(80, 78, 78); font-size: 16px; cursor: pointer;" class="btn-add-to-cart">ناموجود &nbsp; <i class="fas fa-ban" style="color:red;font-size:18px;"></i> </button>
                                            @endif
                                        @endif
                                    @else
                                        @if($item->bought!='Yes')
                                        <div class="c-product__add mt-0" id="beforeBought{{$item->GoodSn}}">
                                            <button id="preBought{{$item->GoodSn}}" value="" onclick="AddQtyPishKharid({{$item->GoodSn}},this)" style="padding-right:10px;background-color:rgb(244, 8, 67);" class="btn-add-to-cart">پیش خرید &nbsp; <i class="fas fa-shopping-basket" style="color:rgb(10, 9, 9);font-size:18px;"></i></button>
                                        </div>
                                        @else
                                            <div class="c-product__add mt-0">
                                                <a class='btn-add-to-cart' value='' id="updatedPishKharid{{$item->GoodSn}}"
                                                    onclick='updatePishKharid({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})'
                                                        style='width:auto;text-align:center; padding-right:10px; background-color: #6e3f06; font-weight: bold;'
                                                        class='updateData btn-add-to-cart'>{{ $item->Amount / $item->PackAmount }}{{ $item->secondUnit }}
                                                        معادل
                                                    {{ $item->Amount / 1  }}{{ $item->UName}}
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
		@if(showEnamad("enamadOther")==1)
		   <div class="container topDistance">
			   <div class="row mb-4"> 
				   <div class="col-lg-4 col-md-4 col-sm-4"> </div>
					<div class="col-lg-4 col-md-4 col-sm-4 about-img">
					<a referrerpolicy="origin" href="https://trustseal.enamad.ir/?id=220841&amp;code=dgsiolxgvdofskzzy34r">
						<img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=220841&amp;Code=dGSIolXgVdoFskzzY34R"
							 alt="" style="cursor:pointer" id="dGSIolXgVdoFskzzY34R">
					</a>
					<img referrerpolicy='origin' id='nbqewlaosizpjzpefukzrgvj'
						 style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=249763&p=uiwkaodspfvljyoegvkaxlao",
				"Popup", "toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
						 alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=249763&p=odrfshwlbsiyyndtwlbqqfti' />
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4"> </div>
				</div> 
			</div>
		 @endif
</section>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('6f1056113f58f9b3fa86', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('App\\Events\\NotifyUsers', function(data) {
      alert(JSON.stringify(data.text));
    });

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
        },
        error: function (msg) {
            console.log(msg);
        }
    });
}
</script>
<!-- <script src="{{ url('/resources/assets/js/script.js')}}"></script> -->
@endsection