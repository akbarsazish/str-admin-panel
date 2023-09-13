@extends('layout.layout')
@section('content')
<style>
    .c-checkout-steps li.is-completed:before {
        width: 97%
    }
</style>
<ul class="c-checkout-steps d-none">
    <li class="is-active is-completed">
        <div class="c-checkout-steps__item c-checkout-steps__item--summary" data-title="اطلاعات ارسال"></div>
    </li>
    <li class="is-active is-completed">
        <div class="c-checkout-steps__item c-checkout-steps__item--payment" data-title="اتمام خرید "></div>
    </li>
</ul>
<div class="container topDistance px-0 bg-white" style="margin-top:90px;  margin-bottom:50px;">
    <section class="c-checkout-alert">
        <div class="c-checkout-alert__icon success"><i class="fa fa-check"></i></div>
        <div class="c-checkout-alert__title">
            <h4>شماره فاکتور <span class="c-checkout-alert__highlighted c-checkout-alert__highlighted--success">{{$factorNo}}</span>.</h4>
        </div>
    </section>
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card text-dark p-3">
                <h5>شماره فاکتور : {{$factorNo}}</h5>
                <h5 class="">سود شما از این خرید : {{number_format($profit)}}{{$currencyName}}</h5>

                <div class="c-checkout-details__row">
                    <div class="c-checkout-details__col--text">
                       <a  class="btn btn-info" href="{{url('/home')}}">  <i class="fa fa-back">  </i>  بازگشت به صفحه اصلی</a>
                    </div>
               </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام کالا </th>
                                <th>تعداد</th>
                                <th>قیمت واحد</th>
                                <th>مبلغ کل</th>
                            </tr>
                    </thead>
                    <tbody>
                    @foreach ($factorBYS as $buy)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$buy->GoodName}}</td>
                        <td>{{ ($buy->PackAmount/1).' '.$buy->secondUnit.' معادل '.($buy->Amount/1).' '.$buy->firstUnit}}</td>
                        <td>{{number_format($buy->Fi/$currency).' '.$currencyName}}</td>
                        <td>{{number_format($buy->Price/$currency).' '.$currencyName}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="container">
       <div class="row mb-4"> 
           <div class="col-lg-4 col-md-4 col-sm-4"> </div>
            <div class="col-lg-4 col-md-4 col-sm-4 about-img">
            <a referrerpolicy="origin" href="https://trustseal.enamad.ir/?id=220841&amp;code=dgsiolxgvdofskzzy34r">
                <img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=220841&amp;Code=dGSIolXgVdoFskzzY34R" style="cursor:pointer" id="dGSIolXgVdoFskzzY34R">
            </a>
            <img referrerpolicy='origin' id='nbqewlaosizpjzpefukzrgvj'
                 style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=249763&p=uiwkaodspfvljyoegvkaxlao",
        "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                 alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=249763&p=odrfshwlbsiyyndtwlbqqfti' />
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"> </div>
        </div> 
    </div>
@endsection



