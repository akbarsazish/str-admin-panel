@extends('layout/layout');
@section('content')
 <div class="container topDistance">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-9 px-0">
            @php  $allMoney=0;  @endphp
               <div class="c-checkout"><br>
                <span class="pt-2 fw-bold" style="font-size:18px; padding-right:20px; padding-top:200px;"> تعداد کالا: {{count($factorBYS)}} عدد </span> <hr>
                        <ul class="c-checkout__items">
                            @foreach ($factorBYS as $buy)
                                <li class="pe-2 py-3" style="border-bottom:1px solid gray;">
                                    <span class="factorContent d-block"> <b> اسم کالا</b>: &nbsp;  {{$buy->GoodName}}، {{($buy->PackAmnt/1).' '.$buy->secondUnit.' معادل'.($buy->Amount/1).' '.$buy->firstUnit}}
                                    @php
                                        $allMoney+=($buy->Price/$currency);
                                    @endphp
                                    <span class="factorContent d-block"> <b> قیمت کالا </b> : &nbsp;  {{number_format($buy->Price/$currency)}} {{$currencyName}} </span>
                                    <span class="factorContent d-block"><b> تاریخ و وقت خرید </b> : &nbsp;  {{$buy->factorDate}}  <i class="fa fa-clock" style="color:#ef3d52;"></i>  {{$buy->factorTime}}</span>
                                </li>
                            @endforeach
                      </ul>
                      <div class="d-flex">
                        <div class="p-2 flex-fill">
                            <a class="btn btn-danger text-white d-inline" id="ContinueBasket" href="{{url('/profile')}}" style="display:flex; justify-content:flex-start; text-decoration:none;color:black;"> <i class="fa fa-chevron-circle-right"> </i> بازگشت </a>
                        </div>
                        <div class="p-2 flex-fill flex-start">
                            <input type="hidden" id="FacCode">
                                <form method="post" action="{{url('/carts')}}">
                                    <button type="submit" class="btn btn-danger d-flex" style="display: flex; justify-content:flex-end; float:left; margin-top:-7px"> <i class="fas fa-money-check-alt"> </i> &nbsp; پرداخت </button>
                                    <input type="hidden" value="4805" data-val="true" data-val-required="The FacCode field is required."
                                        id="FacCode" name="FacCode">
                                    <input type="hidden" value="60965000" data-val="true"
                                        data-val-required="The TotalPrice field is required." id="TotalPrice" name="TotalPrice">
                                    <input name="__RequestVerificationToken" type="hidden" value="CfDJ8PoDj-KjmZNGiwUrpBfXiEgLXjx_Y7HMP2TAA0f8L-q_ymRhs0B8b8q3YXG27N6s1pssBRNFELnzPzh7OLoyuRnnnOTNjrXic3TFLWcAA2HV8G8tSsWIKm9v0N1gpGmJjy0LQOIlz3hF24VnWEPHtKpz1EFMKOj5TNovSgoEXdx-wyOdM1cvti9V1lMmCD4RsA">
                           </form>
                        </div>
                      </div>
                   </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 px-0">
                    <div class="c-checkout-summary">
                        <ul class="c-checkout-summary__summary">
                            <li>
                                <span>قیمت کالاها (۱)</span>
                                <span>0 {{$currencyName}}</span>
                            </li>
                            <!--incredible-->
                            <li class="c-checkout-summary__discount">
                                <span> تخفیف کالاها </span>
                                <span class="discount-price">0 {{$currencyName}}</span>
                            </li>
                            <!--incredible-->
                            <li class="has-devider">
                                <span>جمع</span>
                                <span> {{number_format($allMoney)}} {{$currencyName}} </span>
                            </li>
                            <li>
                                <span>هزینه ارسال</span>
                                <span>0</span>
                            </li>
                            <li class="has-devider">
                                <span> مبلغ قابل پرداخت </span>
                                <span>{{number_format($allMoney)}} {{$currencyName}} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

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
        <script src="{{ url('/resources/assets/js/script.js')}}"></script>
@endsection