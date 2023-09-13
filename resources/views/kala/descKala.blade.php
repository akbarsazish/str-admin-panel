@extends('layout.layout')
@section('content')
<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px;background-color: #ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;">
    </div>
</div>
@php
$overLine=0;
@endphp
<div class="container topDistance">
    <div class="row bg-white p-3">
            <audio id="ring" src="{{url('/resources/assets/beep.mp3')}}"  controls style="display:none" preload="auto"></audio>
            
            @forelse ($product as $pr)

        <div class="col-lg-4 col-md-4 col-sm-12" style="display: flex; justify-content:center; align-items:center;">
            <button style="background: transparent; font-size: 25px; position: absolute;left: 80%;top: 12%;z-index: 1000;" id="hear{{$pr->GoodSn}}"
                onclick="SetFavoriteGood({{$pr->GoodSn}})" @if($pr->favorite=='YES') class="fas fa-heart text-danger kala-desc-fav" @else  class="far fa-heart" @endif ></button>
        @if(file_exists('resources/assets/images/kala/' . $pr->GoodSn . '_1.jpg'))
            <img @if($logoPos==0) class="topLeft" @else class="topRight"  @endif alt="" src="{{ url('/resources/assets/images/starfood.png')}}">
            <img style="width:250px; height:250px; background: transparent;" class="img-responsive" alt="" src="{{ url('/resources/assets/images/kala/' . $pr->GoodSn . '_1.jpg') }}" />
        @else
            <img alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}">
        @endif
        </div>

     <div class="col-lg-8 col-md-8 col-sm-12">
                        @if($pr->activePishKharid<1)
                            @if($pr->callOnSale==0)
                                @if($pr->AmountExist>0 or $pr->freeExistance>0)
                                    @if($pr->bought=='No')
                                        <button id="noBought{{$pr->GoodSn}}" style="padding-right:10px; font-weight:bold; display:inline; float:left; margin-top:22px;" onclick="AddQty({{$pr->GoodSn}},this)" class="btn-add-to-cart">انتخاب تعداد
                                            <i class="far fa-shopping-cart text-white ps-3"></i></button>
                                    @endif
                                  <div class="d-inline" id="bought{{$pr->GoodSn}}">
                                    @if($pr->bought=='Yes')
                                        <a class='updateData btn-add-to-cart' id="updatedBought{{ $pr->GoodSn }}" onclick='UpdateQty({{ $pr->GoodSn }},this,{{ $pr->SnOrderBYS }})'
                                            style="padding-right:10px; font-weight:bold; display:inline; float:left; margin-top:22px; background-color: #39ae00">{{ $pr->Amount / $pr->PackAmount }}{{ $pr->secondUnit }}
                                            معادل
                                            {{ $pr->Amount / 1  }}{{ $pr->secondUnit}}
                                        </a>
                                    @endif
                                @endif
                            @else
                                <button value="" style="padding-right:8px; background-color:#e40707; font-weight: bold; display: inline;" class="btn-add-to-cart">برای خرید تماس بگیرید
                                    <i class="far fa-shopping-cart text-white ps-2"></i>
                                </button>
                            @endif
                        @else
                            @if($pr->preBought!='Yes')
                                <span id="beforeBought{{$pr->GoodSn}}" style="display:flex; justify-content:flex-end; align-items:flex-end"> 
                                    <button id="preBought{{$pr->GoodSn}}" value="" onclick="AddQtyPishKharid({{$pr->GoodSn}},this)" style="margin-top:22px; background-color:rgb(244, 8, 67); " class="btn-add-to-cart">پیش خرید &nbsp; <i class="fas fa-shopping-basket" style="color:rgb(10, 9, 9);font-size:18px;"></i></button>
                                </span>
                            @else
                                <div class="c-product__add mt-0">
                                    <a class='btn-add-to-cart' value='' id="updatedPishKharid{{$pr->GoodSn}}"
                                        onclick='updatePishKharid({{ $pr->GoodSn }},this,{{ $pr->SnOrderBYS }})'
                                            style='width:auto;text-align:center; padding-right:10px; background-color: #6e3f06;font-weight: bold;'
                                            class='updateData btn-add-to-cart'>{{ $pr->Amount / $pr->PackAmount }}{{ $pr->secondUnit }} معادل
                                            {{ $pr->Amount / 1  }}{{ $pr->UName}}
                                    </a>
                                </div>
                            @endif
                        @endif
                    @if($pr->AmountExist>0)
                        @if($pr->activeTakhfifPercent)
                            @php
                                $overLine=0;
                                $percentResult=0;
                                if($pr->Price4>0 and $pr->Price3>0){
                                    $showTakhfifPercent="none";
                                    $percentResult=round((($pr->Price4-$pr->Price3)*100)/$pr->Price4);
                                    }else{
                                        $percentResult=0;
                                    }
                                    if($percentResult==0 ){
                                        $showTakhfifPercent="none";
                                    }
                                    if($pr->activeTakhfifPercent==1 and $percentResult!=0){
                                        $showTakhfifPercent="flex";
                                        $overLine=1;
                                    }else{
                                        $showTakhfifPercent="none";
                                    }
                            @endphp
                            <span  style='display:{{$showTakhfifPercent}}'> &nbsp; {{$percentResult}}% &nbsp; <b>تخفیف</b></span>
                        @endif
                        @if($overLine==1)
                            <div class="c-price" id="SellPrice_str" style="font-size:16px;" ><del>{{number_format($pr->Price4/$currency)}}</del> {{$currencyName}}</div>
                        @endif
                    @endif

                    @if($pr->AmountExist>0 or $pr->activePishKharid>0 or $pr->freeExistance>0)
                         <span class="c-price original d-inline" id="SellPrice_str" style="color: #39ae00; font-size:16px;">{{number_format($pr->Price3/$currency)}} {{$currencyName}}</span>
                    @else
                        @if($pr->requested==0)
                        <span class="prikalaGroupPricece" id="request{{$pr->GoodSn}}" style="display:flex; justify-content:flex-end; align-items:flex-end">
                           <button value="0" id="preButton{{$pr->GoodSn}}" style="margin-top:22px;" onclick="requestProduct({{Session::get('psn')}},{{$pr->GoodSn}})" class="btn-add-to-cart">خبرم کنید <i class="fas fa-bell"></i></button>
                        </span>
                        @else
                        <span class="prikalaGroupPricece" id="norequest{{$pr->GoodSn}}" style="display:flex; justify-content:flex-end; align-items:flex-end">
                            <button value="1" id="afterButton{{$pr->GoodSn}}" style="margin-top:22px; border:2px solid #fb0a0a; background-color:#fff; color:#e81414" onclick="cancelRequestKala({{Session::get('psn')}},{{$pr->GoodSn}})" class="btn-add-to-cart">اعلام شد</button>
                        </span>
                        @endif
                    @endif
                    <br>
                        <span class="fa-title fw-bold"> {{$pr->GoodName}} </span> <hr>
                        <span class="p-0 m-0"> <b>گروه اصلی : </b> <a href="{{url('listKala/groupId/'.$mainGroupId)}}" class="btn-link-spoiler">{{$groupName}}</a> </span> 
                             <p style="text-align: justify; text-justify: inter-word;"> <strong> کد محصول: </strong> {{$pr->GoodCde}} <br> {{$pr->descKala}} </p>
                        <hr>
                          <div class="row">
                              <h4>کالاهای مشابه</h4>
                                @foreach($assameKalas as $asame)
                                    <div class="col-lg-3 col-md-3 col-sm-4 p-2" style="text-align:center; box-shadow: 0px 2px 2px 2px #888888;">
                                        <a href="{{url('/descKala/'.$mainGroupId.'/itemCode/'.$asame->assameId)}}" class="c-product-box__img c-promotion-box__image">
                                            <img style="width: 50%;hieght:50%;" src="{{ url('/resources/assets/images/kala/' . $asame->assameId . '_1.jpg') }}">
                                        </a>
                                        <a href="{{url('/descKala/'.$mainGroupId.'/itemCode/'.$asame->assameId)}}" style="color:black; text-decoration:none; font-weight:bold;">{{ $asame->GoodName }}</a>
                                    </div>
                                @endforeach
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           @empty
              <p>توضیحاتی ندارد</p>
           @endforelse
            
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
</div>

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
@endsection
