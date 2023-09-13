@extends('layout/layout');
@section('content')
 <div class="container" style="margin-top:50px; padding-bottom:50px;">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-9 px-0">
            @php  $allMoney=0;  @endphp
               <div class="c-checkout"><br>
                <span class="pt-2 fw-bold" style="font-size:18px; padding-right:20px; padding-top:200px;"> تعداد کالا: {{count($orders)}} عدد </span> <hr>
                        <ul class="c-checkout__items">
                @foreach ($orders as $order)
                    <li class="pe-2 py-3" style="border-bottom:1px solid gray;">
                        <span class="factorContent d-block"> <b> اسم کالا</b>: &nbsp;  {{$order->GoodName}}، {{($order->PackAmount/1).' '.$order->secondUnit.' معادل '.($order->Amount/1).' '.$order->firstUnit}}
                        @php
                            $allMoney+=($order->Price/$currency);
                        @endphp
                        <span class="factorContent d-block"> <b> قیمت کالا </b> : &nbsp;  {{number_format($order->Price/$currency)}} {{$currencyName}} </span>
                        <span class="factorContent d-block"><b> تاریخ و وقت خرید </b> : &nbsp; {{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($order->TimeStamp))->format('Y/m/d H:i:s')}} <i class="fa fa-clock" style="color:#ef3d52;"></i> </span>
                    
                    </li>
                @endforeach
                <input type="hidden" value={{($allMoney-($payedMoney/$currency))}} id="allMoneyToSend">
                <input type="hidden" value={{$orderSn}} id="snOrder">
            </ul>
            <div class="d-flex">
                <div class="p-2 flex-fill">
                    
                    <a class="btn btn-danger text-white d-inline" id="ContinueBasket" href="{{url('/profile')}}" style="display:flex; justify-content:flex-start; text-decoration:none;color:black;"> <i class="fa fa-chevron-circle-right"> </i> بازگشت </a>
                </div>
                <div class="p-2 flex-fill flex-start">
                    @if(($allMoney-($payedMoney/$currency))>0)
                    <a href="{{url('/starfoodFrom')}}">
                    <button type="button" class="btn btn-danger d-flex" id="setPaysStuff" style="display: flex; justify-content:flex-end; float:left; margin-top:-7px"> <i class="fas fa-money-check-alt"> </i> &nbsp; پرداخت </button>     
                    </a>
                    @else
                    پرداخت شده
                    @endif
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
                        <span>{{number_format(($allMoney-($payedMoney/$currency)))}} {{$currencyName}} </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('/resources/assets/js/script.js')}}">

</script>
@endsection