@extends('layout.layout')
@section('content')

<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px;background-color: #ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;"> </div>
</div>
@php
$allMoney = 0;
$allMoneyProfit=0;
$allMoneyFirst=0;
$allMoneyPishFactor =0;
$snOrder = 0;
$snHDS=0;
$amountExist=0;
$freeExistance=0;
@endphp
@foreach ($orders as $order)
    @php
        if(($order->Price>0 and $order->Price1>0 ) and ($order->Price1>$order->Price)){
            $allMoneyProfit += $order->Price/$currency;
            $allMoneyFirst += $order->Price1/$currency;
        }
    @endphp
    @endforeach
    @php
    $profit=$allMoneyFirst-$allMoneyProfit;
@endphp

<div class="container topDistance">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
            <h4> سبد خرید </h4>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 mb-5">
            <span style="position:fixed; z-index:5; background-color:#00712e; color:#ffffff; padding:12px; border-radius:10px; font-size:16px;">سود شما از این خرید  {{number_format($profit)}} {{$currencyName}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
                <div class="row">
                @foreach ($orders as $order)
                    @php
                        $allMoney += $order->Price/$currency;
                        $snHDS = $order->SnHDS;
                        @endphp

                    <div class="col-lg-6 px-1" id="order{{$order->SnOrderBYS}}" style="background-color:white;">
                        <div class="grid-container">
                            <div class="grid-item">
                                @if(file_exists('resources/assets/images/kala/' . $order->GoodSn . '_1.jpg'))

                            <img class="img-responsive cartPic" src="{{ url('/resources/assets/images/kala/' . $order->SnGood . '_1.jpg') }}" alt=''>
                                @else

                            <img class="img-responsive cartPic" alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}">
                                @endif

                            </div>
                            <div class="grid-item">
                            <a href='' style="color:black;font-size: 14px; font-weight:bold;">{{ $order->GoodName }}</a>  <br>
                            <div class='c-product__add mt-3'>
                                @if($order->AmountExist>0 or $order->freeExistance>0)

                                <a class='btn-add-to-cart' id="updatedBought{{ $order->SnGood }}" value='' onclick='UpdateQty({{ $order->SnGood }},this,{{ $order->SnOrderBYS }})' style='width:auto;text-align: center; cursor:pointer' class='updateData btn-add-to-cart' >{{ (int)$order->PackAmount }} {{ $order->secondUnitName }} معادل{{ $order->Amount / 1 }}{{ $order->UName }}</a>
                                @else

                                <div class="c-product__add">
                                    <button id="btnCount_789" value="" style="padding-right:10px;background-color:black;" class="btn-add-to-cart">** ناموجود **</button>
                                </div>
                                @endif

                                </div>
                                <br>
                                <span style="margin:20px 5px; color:green;">{{number_format($order->Fi / $currency).' '.$currencyName}} </span>
                                <div class='c-checkout__price'>
                                    <span id="orderBYS{{$order->SnOrderBYS}}">{{number_format($order->Price/$currency)}}</span> {{$currencyName}}
                                </div>
                                <input type="text" style="display: none;" name="" value="{{$order->Price/$currency}}" id="Price{{$order->SnOrderBYS}}">
                                <input type="text" style="display: none;" name="" value="{{$currency}}" id="Currency{{$order->SnOrderBYS}}">
                            </div>
                            <div class="grid-item">
                                <button onclick='deleteCart({{ $order->SnOrderBYS }},{{$order->Price/$currency}})' type='button' style="float:left; background:transparent">
                                    <i class='fa fa-trash' style="font-size:18px; color:red">  </i>
                                </button>
                            </div>
                        </div>
                    </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-lg-4 px-1">
                    <div class="grid-container totalBuy">
                        <div class="grid-item">
                            <div class='fw-bold' style='font-size: 16px;'>مبلغ قابل پرداخت</div>
                            <div id="FinalMoneyFactor" style="font-size: 16px;">
                                <span class="allMoney fw-bold"> {{number_format($allMoney) .' '.$currencyName}} </span>
                            </div>
							<div class="alert-info"><p>هزینه‌ای بسته بندی و حمل: <strong class="text-info">رایگان</strong></p></div>
                        </div>
                        <div class="grid-item"> </div>
                            <div class="grid-item pe-5" style="float:left;">
                                <form action="{{url('/shipping')}}" method="post" id='myform'  >
                                @csrf <input type="text" style="display:none" id="allMoneyToSend" name="allMoney" value="{{$allMoney}}">
                                <input type="text" style="display:none" id="" name="profit" value="{{$profit}}">
                                <input type="text" style="display:none" name="allMoneyPishFactor" value="{{$allMoneyPishFactor}}">
                                <input type="text" style="display:none" value="{{$minSalePriceFactor}}" id="minSalePrice">
                                <input type="text" style="display:none" value="{{$changedPriceState}}" id="changePriceState">
                                @if(count($orders ))
                                @if($intervalBetweenBuys > 12)

                                    <a id="notSufficient" style="display: none" class="c-checkout__to-shipping-link">مبلغ کمتر از حداقل است</a>
                                    <a id="continueBuy" type="button" onclick="document.getElementById('myform').submit()"  class="btn btn-md cont c-checkout__to-shipping-link buttonContinue" style="margin-top:5px;display: none;   border: 2px solid black;">ادامه خرید<i class="far fa-shopping-cart fa-xl"> </i> </a>

                                    @if($allMoney < $minSalePriceFactor)
                                       
                                    <a id="ContinueBasket" class="c-checkout__to-shipping-link">مبلغ کمتر از حداقل است</a>
                                    
                                    @else
                                        @if($changedPriceState==0)
                                        
                                        <a type="button" id="contBtnNotChangedPriceStt" onclick="document.getElementById('myform').submit()" class="btn btn-md cont c-checkout__to-shipping-link buttonContinue"><i class="far fa-shopping-cart fa-xl"> </i>ادامه خرید</a>
                                       @else
                                           
                                        <a type="button" id="contBtnChangedPriceStt" data-toggle="modal" data-target="#myModal"  class="btn btn-md cont c-checkout__to-shipping-link buttonContinue"><i class="far fa-shopping-cart fa-xl"> </i>ادامه خرید</a>
                                         @endif
                                    @endif
                                @else
                                    @if($changedPriceState==0)
                                       
                                <a type="button" id="contBtnNotChangedPriceGtt"  onclick="document.getElementById('myform').submit()"  class="btn btn-md cont c-checkout__to-shipping-link buttonContinue" > <i class="far fa-shopping-cart fa-xl"> </i> ادامه خرید</a>
                                    @else
                                     
                                    <a type="button"  id="contBtnChangedPriceGtt"  class="btn btn-md cont showModal c-checkout__to-shipping-link" style="margin-top:5px;   border: 2px solid black;"> <i class="far fa-shopping-cart fa-xl"> </i> ادامه خرید</a>
                                    @endif
                                @endif
                                @endif
                                
                            </div>
                            </form>
                        </div>
                    </div>
                </div> <hr>
        <div class="row">

        @if(count($orderPishKarids)>0)

        <div>
            <h5 class="mt-4"> تعداد اقلام پیش خرید: {{count($orderPishKarids)}}</h5>
        </div>

        @endif

        <div class="col-lg-9">
            <div class="row">

                @php
                    $allMoney = 0;
                    $allMoneyPishFactor =0;
                    $snOrder = 0;
                    $snHDS2=0;
                    $amountExist=0;
                    $freeExistance=0;
                @endphp
            @foreach ($orderPishKarids as $order)
                @php
                    $allMoneyPishFactor += $order->Price/$currency;
                    $snHDS2 = $order->SnHDS;
                @endphp

                <div class="col-lg-6 px-1" id='order{{$order->SnOrderBYSPishKharid}}' style="background-color:white;">
                    <div class="grid-container">
                        <div class="grid-item">
                            <a href=''>
                            <img class="img-responsive cartPic" src="{{ url('/resources/assets/images/kala/' . $order->SnGood . '_1.jpg') }}" alt=''>
                            </a>
                        </div>
                        <div class="grid-item">
                            <p>  {{ $order->GoodName }} </p>
                            <div class='c-product__add'>
                                <a class='btn-add-to-cart' id="updatedPishKharid{{ $order->SnGood }}" onclick='updatePishKharid({{ $order->SnGood }},this,{{ $order->SnOrderBYSPishKharid }})'
                                style='width:auto;text-align: center; padding-right: 10px; background-color: #6e3f06;font-weight: bold;' class='updateData btn-add-to-cart'>{{(int)$order->PackAmount.' '.$order->secondUnitName.' معادل '.($order->Amount / 1) .' '.$order->UName }}</a>
                            </div>
                            <div style="text-align:right">
                                <p class="text-success my-0"> قیمت بعد از فاکتور مشخص می شود. </p>
                            </div>
                        </div>
                        <div class="grid-item">
                            <button onclick='deletePishKhared({{ $order->SnOrderBYSPishKharid }})' type='button' class='mt-2' style="float:left; background:transparent"><i class='fa fa-trash fa-lg me-2' style='color:red'> </i></button>
                            <p class="fw-bold" style="margin-top:120px;"> {{$order->DateOrder}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">کالاهای زیر تغییر قیمت دارند.</h6>
                <button type="button" class="close" data-dismiss="modal" style="color:red">&times;</button>
            </div>
            <div class="modal-body">
            <ul class="list-group list-group-flush">
            @foreach ($orders as $order)
                @if($order->changedPrice==1)
                    <li class="list-group-item" style="font-size:14px">{{$order->GoodName}}</li>
                @endif
            @endforeach
            
        </ul><hr>
            <h6>در صورت ادامه با قیمت جدید ثبت خواهد شد.</h6>
            </div>
            <div class="modal-footer" style="display:flex; align-items:flex-start; justify-content:flex-start">
                <form action="{{url('/updateChangedPrice')}}" method="POST">
                    @csrf

                    <input type="text" name="SnHDS" style="" value="{{$snHDS}}">
                    <button type="submit" class="btn btn-danger float-end" >ادامه <i class="fa fa-repeat"></i></button>
                </form>
                <button type="button" class="btn btn-danger float-end" data-dismiss="modal">خیر <i class="fa fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
		@if(showEnamad("enamadOther")==1)
		   <div class="container">
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
<script>
    
    function deleteCart(SnOrderBYS,moneyAmount) {
    swal({
        title: "حذف از سبد خرید ",
        text: "میخواهید این خرید را حذف کنید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((willDelete) => {
        if(willDelete){
        $.ajax({
        type: "POST",
        url: "{{ url('/deleteBYS') }}",
        data: {
            _token: "{{ csrf_token() }}",
            SnOrderBYS: SnOrderBYS
        },
        dataType: "json",
        success: function(msg) {
        window.location.reload();
        $('#order'+SnOrderBYS).css('display','none');
        let allMoney = parseInt($("#allMoneyToSend").val())-moneyAmount;
        $(".allMoney").text(allMoney.toLocaleString("en-US"));
        $("#allMoneyToSend").val(allMoney);
        var buys=parseInt($('#basketCountWeb').text());
        if(buys>0){
            buys=buys-1;
            $('#basketCountWeb').text(buys);
            $('#basketCountWebBottom').text(buys);
            if(buys==0){
                $('#basketCountWeb').removeClass("headerNotifications1");
                $('#basketCountWeb').addClass("headerNotifications0");
                $('#basketCountWebBottom').removeClass("headerNotifications1");
                $('#basketCountWebBottom').addClass("headerNotifications0");
                $(".cont").css('display','none');
            }
        }
        },
        error: function(msg) {
            console.log(msg);
        }
    });
}
    });
    
}

function deletePishKhared(SnOrderBYS) {
    swal({
        title: "حذف از سبد خرید ",
        text: "میخواهید این خرید را حذف کنید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true
        }).then((willDelete) => {
        if(willDelete){
        $.ajax({
        type: "get",
        url: "{{ url('/deleteOrderPishKharid') }}",
        data: {
            _token: "{{ csrf_token() }}",
            SnOrderBYS: SnOrderBYS
        },
        dataType: "json",
        success: function(msg) {
        $('#order'+SnOrderBYS).css('display','none');
        },
        error: function(msg) {
            console.log(msg);
        }
        });
        }
    });
}
    window.onload=function() {
        $(document).on("click",'.showModal',()=>{
           alert($("#myModal").modal("show"));
        });
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
        var input = document.getElementById("txtsearch");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                if (input === "") {
                    event.preventDefault();
                    window.location.href = "/home";
                } else {
                    event.preventDefault();
                    window.location.href = "/searchKala/" + input.value;
                }
            }
        });
    }
	$(document).on("popstate", function() {
	  location.reload();
	});
    </script>

@endsection