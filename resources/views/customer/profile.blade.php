@extends('layout.layout')
@section('content')

<script>
    function goBack() {
        window.history.back();
    }
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

<style>
 .tableHeader {
    position:sticky !important;
    top:0 !important;
	background-color:#198754 ! important;
  }
 
.tableBody {
      height:333px !important; 
      overflow-y:scroll !important;
      display:block !important;
  }
  
.tableHeader .tableBbody, tr {
    display: table !important;
    table-layout: fixed !important;
    width: 100% !important;
	text-align:center;
      
  }
  .tableHeader .tableBbody, tr>th:first-child {
    width: 52px !important;
}
.tableHeader .tableBbody, tr>td:first-child {
    width: 52px !important;
}

.tableHeader .tableBbody, tr>th:last-child {
    width: 60px;
}
.tableHeader .tableBbody, tr>td:last-child {
    width: 60px;
}

.payment {
  animation: 2s anim-popoutin ease infinite;
}

@keyframes anim-popoutin {
  0% {
    color: black;
    transform: scale(0);
    opacity: 0;
    text-shadow: 0 0 0 rgba(0, 0, 0, 0);
  }
  25% {
    color: green;
    transform: scale(2);
    opacity: 1;
    text-shadow: 3px 10px 5px rgba(0, 0, 0, 0.5);
  }
  50% {
    color: black;
    transform: scale(1);
    opacity: 1;
    text-shadow: 1px 0 0 rgba(0, 0, 0, 0);
  }
  100% {
    /* animate nothing to add pause at the end of animation */
    transform: scale(1);
    opacity: 1;
    text-shadow: 1px 0 0 rgba(0, 0, 0, 0);
  }
}

.invite-code {
  text-align:center;
  display:flex;
  justify-content: center;
  align-items:center;
  background-color: 
}

.invit-link {
  text-decoration:none;
  color: #000;
  font-size:16px;
  margin: 0 auto;
}

</style>

<section class="profile-page container topDistance px-0" style="font-size:16px; ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 rounded">
                <div class="o-page__aside">
                    <div class="c-profile-aside">
                        <div class="c-profile-box">
                            <div class="c-profile-box__header" style="background-color: #ef3d52">
                                <div class="c-profile-box__avatar" style="background-image: url('/resources/assets/images/girl.png')"></div>
                            </div>
                            <?php
                             $user = auth()->user();
                            if($user=1){?>
                             <div class="c-profile-box__username" style="font-size:16px;">{{Session::get('username')}}</div>
                            <?php }else{ ?>
                                <div class="c-profile-box__username"> @if($exactCustomer) {{$exactCustomer->customerName}} {{$exactCustomer->familyName}} @endif </div>
                            <?php } ?>
                            <span class="invite-code my-1">
                               <a class="btn btn-danger btn-sm" href="{{url('inviteCode')}}" class="invit-link" style="font-family: sans-serif;"> 
                                  کد دعوت: {{$profile->selfIntroCode}} 
                               </a>
                            </span>
                        </div>
                        <div class="c-profile-menu">
                            <ul class="c-profile-menu__items p-0" style="margin-bottom:0px">
                                <table class="table table-hover">
                                    <tbody>
                                      <tr>
                                        <td class="pe-2 w-50">@if($exacHaqiqi) شماره همراه: {{$exacHaqiqi->phoneNo}}@endif </td>
                                        <td class="pe-2 w-50">@if($exacHaqiqi) تلفن ثابت: {{$exacHaqiqi->sabetPhoneNo}}@endif</td>
                                      </tr>
                                      <tr>
                                        <td class="pe-2">@if($exacHaqiqi) شناس نامه: {{$exacHaqiqi->shenasNamahNo}}@endif</td>
                                        <td class="pe-2 w-50"> 
                                        @if($officialstate=1)
                                            <a href=" {{ URL::to('/customerAdd/'.Session::get('psn').'')}}" style="floating:left; padding:5px; margin-left:10px; color:#0dcaf0; font-size:14px;"> ویرایش پروفایل:  &nbsp;  <i class='fas fa-edit' style='font-size:22px;color:#00bfd6'></i> </a>
                                        @else
                                            <a href=" {{ URL::to('/customerAdd')}}" style="floating:left;padding:5px; margin-left:10px; color:#0dcaf0"> <i class="fa fa-plus-circle fa-3x warning"></i> </a>
                                        @endif 
                                      </td>
                                      </tr>
                                      <tr>
                                        <td class="pe-1 w-50" style="font-size: 10px; background-color:#ef3d52;"> <a href="{{url('/listFactors')}}" class="text-decoration-none text-dark"><i class="fas fa-box-open me-1"></i> فاکتورهای برگشتی</a></td>
                                        <td class="pe-1 w-50" style="font-size: 10px; background-color:#ef3d52;"> <a href="{{url('/listFavorits')}}" class="text-decoration-none text-dark"><i class="fab fa-gratipay me-1"></i> لیست علاقه مندی ها </a></td>
                                      </tr>
                                      <!-- <tr>
                                        <td class="pe-1 w-75 text-white" style="font-size: 10px; background-color:#ef3d52; font-weight:bold;">  <span class="payment"> شما مبلغ 9,500,000 تومان باقی هستید!  </span> </td>
                                        <td class="pe-1 w-25" style="background-color:#ef3d52;"> <button class="btn btn-sm btn-success"> پرداخت </button> </td>
                                      </tr> -->
                                      <tr>
                                    </tbody>
                                  </table>

                                {{-- <li><a href="{{url('/viewOreders')}}" class="c-profile-menu__url"><i class="fas fa-box-open me-3" style="font-size: 20px"></i>فاکتورهای در انتظار ارسال</a></li> --}}
                                <li style="font-size:12px;"></li>
                                <li style="font-size:12px;"></li>
                                 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="row">
                            <h5 class="border-bottom border-danger mt-2">فاکتور های ثبت شده</h5>
                            <table class="table table-bordered table table-hover table-sm table-light" id="tableGroupList">
                                <thead class="tableHeader">
                                  <tr class="tableHead">
                                    <th class="mobile-status">ردیف</th>
                                    <th>شماره </th>
                                    <th> تاریخ ثبت </th>
                                    <th class="mobile-status"> تاریخ تحویل کالا</th>
                                    <th>مبلغ</th>
                                    <th class="mobile-status">عملیات پرداخت</th>
                                    <th>جزییات</th>
                                </tr>
                            </thead>
                            <tbody class="tableBody">
                                    @foreach ($factors as $factor)
                                       <tr class="tableRow">
                                            <td class="mobile-status">{{number_format($loop->index+1)}}</td>
                                            <td>{{number_format($factor->FactNo)}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($factor->timestamp))->format('Y/m/d H:i:s')}}</td>
                                            <td class="mobile-status">{{$factor->FactDate}}</td>
                                            <td>{{number_format($factor->TotalPriceHDS/$currency)}}  {{$currencyName}}</td>
                                            <td class="mobile-status">پرداخت در محل</td>
                                              <form method="post" action="{{url('/factorView')}}" method="POST">
                                                @csrf
                                               <input name="factorSn" type="hidden" value="{{$factor->SerialNoHDS}}">
                                            <td style="text-align: center;"><button class="btn btn-sm" type="submit"><i class="fa fa-eye fa-lg"></i> </button></td>
                                                </form>
                                        </tr>
                                    @endforeach
                            </tbody>
                          </table>
                        </div>
                       <div class="row">
                          <h5  class="border-bottom border-danger">فاکتور های در انتظار ارسال</h5>
                            <table class="tableSection table table-bordered table table-hover table-sm table-light">
                                <thead class="tableHeader">
                                    <tr>
                                        <th class="mobile-status">ردیف</th>
                                        <th>شماره </th>
                                        <th>تاریخ ثبت </th>
                                        <th class="mobile-status">تاریخ تحویل کالا</th>
                                        <th> قابل پرداخت</th>
                                        <th class="mobile-status">عملیات پرداخت</th>
                                        <th>جزئیات</th>
                                    </tr>
                                 </thead>
                                <tbody class="tableBody">
                                @foreach ($orders as $order)
                                   <tr>
                                        <td class="mobile-status">{{number_format($loop->index+1)}}</td>
                                        <td>{{number_format($order->OrderNo)}}</td>
                                        <td>{{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($order->TimeStamp))->format('Y/m/d H:i:s')}}</td>
                                        <td class="mobile-status">{{$order->OrderDate}}</td>
                                        <td>{{number_format(($order->Price-$order->payedMoney)/$currency)}} {{$currencyName}}</td>
                                        <td class="mobile-status">@if($order->payedMoney==0)<span class="c-table-orders__payment-status--ok">پرداخت در محل</span>@else
                                        <span class="c-table-orders__payment-status--ok">{{number_format($order->payedMoney/10)}} تومان پرداخت شد</span>
                                    @endif</td>
                                        <form method="post" action="{{url('/listOrders')}}" method="POST">
                                            @csrf
                                            <input name="factorSn" type="hidden" value="{{$order->SnOrder}}">
                                            <td><button  class="btn btn-sm" type="submit"><i class="fa fa-eye fa-2x"></i></button></td>
                                        </form>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
<script src="{{ url('/resources/assets/js/script.js')}}"></script>
@endsection
