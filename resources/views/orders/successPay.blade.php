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
<div class="container px-0 bg-white" style="margin-top:90px;  margin-bottom:50px;">
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
	<div class="row">
        <table class='crmDataTable table table-bordered table-striped' style="width:100%">
            <thead>
                <tr>
                    <th >ردیف</th>
                    <th >TraceNumber</th>
                    <th >ReferenceNumber</th>
                    <th >TransactionDate </th>
                    <th >TransactionReferenceID </th>
                    <th >InvoiceNumber</th>
                    <th>InvoiceDate</th>
                    <th >Amount</th>
                    <th > TrxMaskedCardNumber</th>
                    <th > IsSuccess</th>
                    <th > Message</th>
                </tr>
            </thead>
            <tbody class="select-highlight" id="customerListBody1">
                <tr>
                    <td> 1 </td>
                    <td>{{$payResults['TraceNumber']}}</td>
                    <td>{{$payResults['ReferenceNumber']}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($payResults['TransactionDate']))->format("Y/m/d")}}</td>
                    <td>{{$payResults['TransactionReferenceID']}}</td>
                    <td>{{$payResults['InvoiceNumber']}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($payResults['InvoiceDate']))->format("Y/m/d")}}</td>
                    <td >{{$payResults['Amount']}}</td>
                    <td>{{$payResults['TrxMaskedCardNumber']}}</td>
                    <td >{{$payResults['IsSuccess']}}</td>
                    <td >{{$payResults['Message']}}</td>
                </tr>
            </tbody>
        </table>
	</div>
</div>
@endsection