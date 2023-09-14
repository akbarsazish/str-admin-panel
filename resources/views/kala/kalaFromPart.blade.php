@extends('layout.layout')
@section('content')
<style>
    html, body{
        margin: 0 auto;
        padding: 0;
    }

.divResult{
    margin: 0 auto;
}
.result{
    margin:0 auto;
    text-align:center;
    font-size:32px;
    color:red;
    font-weight:bold;

}
.searchResult {
    margin-top:10px;
    display: block;
}

.youmean {
    margin-top:30px; 
    font-size:16px;
}

.searched{
    color:red;
    font-size:22px !important;
    font-weight:bold;
}

.searchImage {
    width:360px;
    height:auto;
    display: block;
    margin:0 auto;
}

.resultDesc {
    margin-bottom:120px;
}
</style>

<div class="modalBackdrop">
    <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px; background-color:#ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;">
    </div>
</div>
<section class="container topDistance">
    <div class="o-page__content">
        <div class="c-listing p-1">
            <div class="containerAli p-0">
                <div class="rowAli p-0">
                    @forelse ($kala  as $item)
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

                        <div class="col-50 medium-25 mb-1 p-0">
                            <audio id="ring" src="{{url('/resources/assets/beep.mp3')}}"  controls style="display:none" preload="auto"></audio>
                            <div class="c-product-box py-1 c-promotion-box" style="position: relative; height:350px">
                                <a href="{{url('/descKala/'.$item->firstGroupId.'/itemCode/'.$item->GoodSn)}}" style="height:60% !important" class="c-product-box__img c-promotion-box__image">
                                   @if(file_exists('resources/assets/images/kala/' . $item->GoodSn . '_1.jpg'))
									<img @if($logoPos==0) class="topLeft" @else class="topRight"  @endif alt="" src="{{ url('/resources/assets/images/starfood.png')}}">
                                    <img alt="" src="{{ url('/resources/assets/images/kala/' . $item->GoodSn . '_1.jpg') }}">
                                    @else
                                    <img alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}">
                                    @endif
                                </a>
                                <div class="c-product-box__content" style="width: 93%; height:40% !important">
                                    <a href="{{url('/descKala/'.$item->firstGroupId.'/itemCode/'.$item->GoodSn)}}" class="title" style="display: block; min-height: 45px">{{ $item->GoodName }}</a>
                                    <div class="d-flex justify-content-between kalaTakhfif" style="border-top: 1px solid gray;border-bottom: 1px solid gray; height:44px;">
                                        <button style="background: transparent; font-size: 18px" id="hear{{$item->GoodSn}}" onclick="SetFavoriteGood({{$item->GoodSn}})" @if($item->favorite=='YES')   class="fas fa-heart text-danger" @else  class="far fa-heart" @endif ></button>
                                        <div>
                                            <span  style='display:{{$showTakhfifPercent}}'></span>
                                            <div style='display:{{$showTakhfifPercent}}'>{{$percentResult}}%</div>
                                        </div>
                                        @if($overLine==1)
                                        <div style="color: #39ae00; display: flex; align-items: center" class="text-end"><del>{{number_format($item->Price4/$currency)}} </del> {{$currencyName}}</div>
                                        @endif
                                        @if($item->Amount>0 or $item->activePishKharid>0 or $item->freeExistance>0)
                                        <span class="prikalaGroupPricece text-end fw-bold">{{number_format($item->Price3/$currency) }} {{$currencyName}}</span>
                                        @else
                                            @if($item->requested==0)
                                                <span class="prikalaGroupPricece text-end fw-bold mt-1" id="request{{$item->GoodSn}}"> <button value="0" id="preButton{{$item->GoodSn}}"  onclick="requestProduct({{Session::get('psn')}},{{$item->GoodSn}})" style="padding-right:10px;background-color:rgb(249, 6, 6); font-size:12px;" class="btn-add-to-cart">خبرم کنید <i class="fas fa-bell"></i></button></span>
                                            @else
                                                <span class="prikalaGroupPricece text-end fw-bold" id="norequest{{$item->GoodSn}}"> <button value="1" id="afterButton{{$item->GoodSn}}"  style="padding-right:10px;  border: 2px solid rgb(251, 10, 10);
                                                    background-color: white;
                                                    color: rgb(232, 20, 20);
                                                    font-size: 16px;
                                                    cursor: pointer;" onclick="cancelRequestKala({{Session::get('psn')}},{{$item->GoodSn}})" class="btn-add-to-cart">اعلام شد</button>
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="c-product__add">
                                    <div class='c-product__add' id="bought{{$item->GoodSn}}">
                                        @if($item->activePishKharid<1)
                                            @if($item->Amount>0 or $item->freeExistance>0)
                                                @if($item->callOnSale ==0)
                                                    @if($item->bought=='Yes')
                                                        <a class='btn-add-to-cart' value=''  id="updatedBought{{$item->GoodSn}}"
                                                            onclick='UpdateQty({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})'
                                                            style='width:auto;text-align: center; padding-right: 10px;
                                                            background-color: #51ef39;
                                                            font-weight: bold;'
                                                            class='updateData btn-add-to-cart'>{{(int)$item->PackAmount .' '. $item->secondUnit }}
                                                            معادل
                                                            {{ ($item->BoughtAmount / 1)  .' '. $item->UName}}  </a>
                                                    @endif
                                                    @if($item->bought=='No')
                                                        <button id="noBought{{$item->GoodSn}}" style="padding-right:10px; font-weight: bold; @if($item->bought=='No') display: inline; @else display: none; @endif "
                                                        onclick="AddQty({{$item->GoodSn}},this)" class="btn-add-to-cart">انتخاب تعداد<i
                                                            class="far fa-shopping-cart text-white ps-2"></i></button>
                                                    @endif
                                                @else
                                                <button style="padding-right:8px; background-color:#e40707; font-weight: bold; display: inline;" class="btn-add-to-cart">برای خرید تماس بگیرید
                                                    <i class="far fa-shopping-cart text-white ps-2"></i>
                                                </button>
                                                @endif
                                            @else
                                            <button id="btnCount_789" style="padding-right:10px;  border: 1px solid rgb(202, 199, 199);font-weight:bold;
                                            background-color: rgb(202, 199, 199);
                                            color: rgb(80, 78, 78);
                                            font-size: 16px;
                                            cursor: pointer;" class="btn-add-to-cart">ناموجود &nbsp; <i class="fas fa-ban" style="color:red;font-size:18px;"></i> </button>
                                            @endif
                                        @else
                                            @if( $item->activePishKharid>0)
                                                <div class="c-product__add mt-0" id="beforeBought{{$item->GoodSn}}">
                                                    <button id="preBought{{$item->GoodSn}}" value="" onclick="AddQtyPishKharid({{$item->GoodSn}},this)" style="padding-right:10px;background-color:rgb(244, 8, 67);" class="btn-add-to-cart">پیش خرید &nbsp; <i class="fas fa-shopping-basket" style="color:rgb(10, 9, 9);font-size:18px;"></i></button>
                                                </div>
                                            @else
                                                <div class="c-product__add mt-0">
                                                    <a class='btn-add-to-cart' value='' id="updatedPishKharid{{$item->GoodSn}}"
                                                        onclick='updatePishKharid({{ $item->GoodSn }},this,{{ $item->SnOrderBYS }})'
                                                            style='width:auto;text-align: center;padding-right: 10px;
                                                            background-color: #6e3f06;
                                                            font-weight: bold;'
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

                    @empty  

                    <div class="col-lg-12 text-center divResult">
                         <div class="searchResult">
                               <img src="{{url('/resources/assets/images/search.webp')}}" alt="" class="searchImage">
                                <span class="result"> محصول یافت نگردید! </span>
                                <p class="youmean">
                                    منظور شما <span class="searched"> {{$kalaName}} </span> با هیچ محصول مطابقت نداشت.
                                </p>
                                <p class="resultDesc">
                                    از عبارت‌های متداول‌تر استفاده کنید و یا املای عبارت وارد‌شده را بررسی کنید.
                                </p>
                         </div>
                    </div>
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
@endsection
