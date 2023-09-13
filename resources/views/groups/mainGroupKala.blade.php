@extends('layout.layout')
@section('content')
    <!-- Demo styles -->

<style>
     .mySwiper{
        height:105px;
        width:100%;
        background-color:#fff;
        overflow:hidden;
        text-align:center;
     }

     .topSliderImage{
        width:100px !important;
        height: auto !important;
     }

    .imageTile a {
        text-align:center;
        text-decoration:none !important;
        color:red;
        font-size:14px;
      }

   .swiper-button-prev{
            position: relative;
            top: 50%;
            right:10% !important;
            width: 20px;
            height: 33px;
            margin-top: -22px;
            z-index: 10;
            cursor: pointer;
            background-size: 20px 33px;
            background-position: center;
            background-repeat: no-repeat;
    }

   .swiper-button-next {
        position: relative;
            top: 50%;
            left:10% !important;
            width: 20px;
            height: 33px;
            margin-top: -22px;
            z-index: 10;
            cursor: pointer;
            background-size: 20px 33px;
            background-position: center;
            background-repeat: no-repeat;
            color:red !important;
    }

    @media only screen and (max-width: 920px) {
        .swiper-button-next {
        position: relative;
            left:5% !important;
            width: 15px !important;
            height: 24px !important;
            background-size: 15px 24px;
            z-index:9999;
           
           }
        .swiper-button-prev{
             right:5% !important;
             width: 15px !important;
            height: 24px !important;
            background-size: 15px 24px;
            z-index:9999;
            
           }
        .forMobile {
            margin-top:11px !important;
        }
    }

</style>


<link rel="stylesheet" href="{{ url('/resources/assets/vendor/swiper/css/swiper.min.css') }}">
<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px; background-color: #ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;">
    </div>
</div>
<div class="container topDistance">
    <div class="row text-center">
        <div class="col-lg-12">
            <div class="swiper mySwiper border-bottom border-danger">
                    <div class="swiper-wrapper">
                        @php 
                            $groupId=0;
                            @endphp
                            @forelse ($listGroups as $group)
                            @php
                            if($group->id==202){
                                $groupId=202; 
                            }
                        @endphp
                        <div class="swiper-slide" onclick="appendSubGroup({{$group->id}}, {{$mainGrId}},this)">
                                <img class="swiper-slide topSliderImage" role="button"  src="{{ url('resources/assets/images/subgroup/' . $group->id . '.jpg') }}" />
                            <p class="imageTile"> 
                                {{$group->title }} 
                            </p>
                        </div>
                        @empty
                        <div class="swiper-slide">
                             <p class="imageTile">هنوز دسته بندی تعریف نشده است.</p>
                        </div>
                        @endforelse
                    </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        @if($mainGrId==202)
          <span class="govKala">خرید کالاهای دولتی مستلزم کد نقش میباشند.</span>
        @endif
    </div>
 </div>
    
    <div class="starfood-loader" id="loader">
        <div class="preload1">
          <img class="img-load" src="{{url('resources/assets/images/loader.gif')}}">
        </div> <br>
        <h6 class="loader1">
            <span>لطفا </span>
            <span>منتظر</span>
            <span>باشید</span>
            <span>...</span>
        </h6>
    </div>

    <audio id="ring" src="{{url('/resources/assets/beep.mp3')}}"  controls style="display:none" preload="auto"></audio>
    <section class="search px-0 container" style="margin:0 auto 10px;">
        <div class="o-page__content p-0 forMobile" style="margin:1px auto 20px;">
            <div class="c-listing" style="padding: 0%; margin-top:13px; box-shadow:none;">
                <div class="containerAli p-0">
                    <div class="rowAli" id="appendSubGroupKala"> 
                        @forelse ($listKala as $item)
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
                            if($item->activeTakhfifPercent==1 and $percentResult>0 and $item->Amount>0){
                                $showTakhfifPercent="flex";
                                $overLine=1;
                            }else{
                                $showTakhfifPercent="none";
                            }
                        @endphp
                            <div class="col-50 medium-25 listKalaAtmedia">
                                <div class="c-product-box mobile-promotion-box" style="border-radius:8px;">
                                    <span class="takhfif-round" style="display:{{$showTakhfifPercent}};"> {{$percentResult}}%</span>
                                    <a href="/descKala/{{$mainGrId}}/itemCode/{{$item->GoodSn}}" class="c-product-box__img star-loader c-promotion-box__image kala-list-image">
                                        @if(file_exists('resources/assets/images/kala/' . $item->GoodSn . '_1.jpg'))
                                            <img @if($logoPos == 0) class="topLeft" @else class="topRight" @endif src="{{ url('/resources/assets/images/starfood.png')}}">
                                            <img alt="" src="{{ url('/resources/assets/images/kala/' . $item->GoodSn . '_1.jpg') }}">
                                        @else
                                           <img alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}">
                                        @endif
                                    </a>
                                    <a href="/descKala/{{ $mainGrId}}/itemCode/{{$item->GoodSn}}" class="title fw-bold kala-list-title pe-2" style="text-decoration: none; color:black; height:44px;">{{ $item->GoodName }}</a>
                                    <div class="c-product-box__content kala-list-price" style="width: 100%;">
                                        <div class="kalaGroup" style="border-top: 1px solid gray;border-bottom: 1px solid gray;height:55px;">
                                            <button style="background: transparent; font-size:22px;" id="hear{{$item->GoodSn}}" onclick="SetFavoriteGood({{$item->GoodSn}})" @if($item->favorite=='YES') class="fas fa-heart text-danger" @else  class="far fa-heart" @endif ></button>
                                                @if($item->Amount>0 or $item->activePishKharid>0 or $item->freeExistance>0)
                                                    <span class="text-start" style="float:left; font-weight:bold;font-size:18px; color:green; padding-left:4px"> @if($item->activePishKharid>0) @else {{number_format($item->Price3/$currency) }} {{$currencyName}} @endif</span>
                                                @else
                                                    @if($item->requested==0)
                                                        <span class="prikalaGroupPricece fw-bold mt-1 float-start" id="request{{$item->GoodSn}}">
                                                        <button value="0" id="preButton{{$item->GoodSn}}" onclick="requestProduct({{Session::get('psn')}},{{$item->GoodSn}})"  style="padding-right:5px;background-color:rgb(249, 6, 6); font-size:14px; cursor:pointer;" class="btn-add-to-cart">خبرم کنید <i class="fas fa-bell"></i></button>
                                                        </span>
                                                    @else
                                                        <span class="prikalaGroupPricece fw-bold mt-1 float-start" id="norequest{{$item->GoodSn}}">
                                                            <button value="1" id="afterButton{{$item->GoodSn}}" onclick="cancelRequestKala({{Session::get('psn')}},{{$item->GoodSn}})" style="padding-right:5px;background-color:#05cb0e;color:white;font-size:14px;" class="btn-add-to-cart">اعلام شد</button>
                                                        </span>
                                                    @endif
                                                @endif
                                                @if($overLine==1)
                                                    <p class="text-start" style="color:#ef3d52; padding-left:4px; margin-top:-5px"><del>{{number_format($item->Price4/$currency)}} </del> {{$currencyName}}</p>
                                                @endif
                                        </div>
                                        <div class="c-product__add pt-1 pb-1 " style="display: flex; justify-content:center;">
                                            <div class='c-product__add'  id="bought{{$item->GoodSn}}">
                                                @if($item->activePishKharid<1)
                                                    @if($item->bought=='Yes')
                                                        <a class='btn-add-to-cart' id="updatedBought{{$item->GoodSn}}" onclick='UpdateQty({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})' style='width:auto;text-align: center; padding-right: 10px; background-color: #39ae00; font-weight: bold;' class='updateData btn-add-to-cart'>{{ (int)$item->PackAmount }}{{ $item->secondUnit }} معادل{{ $item->Amount / 1  }}{{ $item->UName}}  </a>
                                                    @endif
                                                    @if($item->callOnSale==1)
                                                    <button style="padding-right:8px; background-color:#e40707; font-weight: bold; display: inline;" class="btn-add-to-cart">برای خرید تماس بگیرید <i class="far fa-shopping-cart text-white ps-2"></i></button>
                                                    @else
                                                        @if($item->Amount>0 or $item->freeExistance>0)

                                                        <button id="noBought{{$item->GoodSn}}" style="padding-right:8px; background-color:#e40707; font-weight: bold; @if($item->bought=='No') display: inline; @else display: none; @endif " onclick="AddQty({{$item->GoodSn}},this)" class="btn-add-to-cart">انتخاب تعداد <i class="far fa-shopping-cart text-white ps-2"></i>
                                                        </button>
                                                        @else
                                                            <div class="c-product__add mt-0">
                                                            <button style="padding-right:10px; border: 1px solid rgb(202, 199, 199);font-weight:bold; background-color: rgb(202, 199, 199);color: rgb(80, 78, 78); font-size: 16px; cursor: pointer;" class="btn-add-to-cart p-1">ناموجود &nbsp; <i class="fas fa-ban" style="color:red;font-size:18px;"></i></button>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @else

                                                    @if($item->pishKharid!='Yes')
                                                        <div class="c-product__add mt-0" id="beforeBought{{$item->GoodSn}}">
                                                            <button id="preBought{{$item->GoodSn}}" onclick="AddQtyPishKharid({{$item->GoodSn}},this)" style="padding-right:8px;background-color:rgb(244, 8, 67);" class="btn-add-to-cart p-1">پیش خرید &nbsp; <i class="fas fa-shopping-basket" style="color:rgb(10, 9, 9);font-size:18px;"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="c-product__add mt-0">
                                                            <a class='btn-add-to-cart' id="updatedPishKharid{{$item->GoodSn}}" onclick='updatePishKharid({{ $item->GoodSn }},this,{{ $item->SnOrderBYSPishKharid}})' style='width:auto;text-align: center;padding-right: 10px; background-color: #6e3f06;font-weight: bold;' class='updateData btn-add-to-cart'>{{(int)$item->pishKharidPackAmount.' '.$item->secondUnit }} معادل{{ $item->PishKharidAmount / 1  }}{{ $item->UName}} </a>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						@empty
							<div><h3>هنوز کالایی تعریف نشده است!</h3></div>
                        @endforelse
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
    </section> 


<script src="{{ url('/resources/assets/js/swiper/js/swiper.min.js') }}"></script>
<script src="{{ url('/resources/assets/js/script.js')}}"></script>
<script>


    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 10,
        slidesPerGroup: 1,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        autoplay: {
            delay: 6500,
            disableOnInteraction: !1,
        },

        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 2,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 2,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 2,
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 2,
            }
        }
      });

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

        $("#topSlider").on("click", ()=>{
            alert("you have clicked")
        })


      </script>



    @endsection

