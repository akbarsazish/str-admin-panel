@extends('admin.layout')
@section('content')
<style>
    .sideButton{
        width:100px;
    }
    .forLabel{
        font-size:14px;
        display:inline;
    }
	
.grid-tableFooter {
  display: grid;
  grid-template-columns: auto auto auto;
 color:#000; 
}
.tableFooter-item {
  padding: 3px;
  font-size: 14px;
  text-align: center;
  border-radius:3px;
  margin:3px;
  background-color:#9ad5be;
}
.textContent {
	font-size:13px;
}
	
.input-group>input.someInput {flex: 0 1 100px;}
	
</style>
<div class="container-fluid my-4" id="salesOrderCont">
    <div class="row px-0 mx-0">
        <div class="col-lg-3 sideDive">
                <fieldset class="border rounded">
                    <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    <form action="{{url('/getPayedOnlines')}}" method="get" id="getPayedOnlineForm">
                        <span class="situation">
                            <fieldset class="border rounded">
                                <legend  class="float-none w-auto legendLabel mb-0"> مشخصات واریزی ها </legend>
                                <div class="form-check">
                                <input class="form-check-input float-start" type="radio" name="sefRadio" id="allPays" checked>
                                    <label class="form-check-label ms-3" for="sefRemainPayRadio" > همه </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input float-start" type="radio" name="sefRadio" id="notSentPays">
                                    <label class="form-check-label ms-3" for="sefRemainPayRadio"> ارسال نشده</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input float-start" type="radio" name="sefRadio" id="sentPays">
                                    <label class="form-check-label ms-3" for="sefSentPayRadio"> ارسال شده </label>
                                </div>
                            </fieldset>
                        </span>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">تاریخ </span>
                            <input type="text" class="form-control" id="payFirstDate">
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                            <input type="text" class="form-control" id="paySecondDate">
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text"> طرف حساب </span>
                            <input type="text" id="payTarafHisabCodeName" class="form-control"  placeholder="کد یا نام ">
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <button type="button" class="btn btn-success btn-sm topButton" id="submitpayForm"> بازخوانی &nbsp; <i class="fa fa-check"></i> </button>
                        </div>
                    </form>
                </fieldset>
                <button type="button" class="btn btn-success btn-sm topButton" id="sendPayToHisabdariBtn" disabled>تایید ارسال به دفتر حساب &nbsp; <i class="fa fa-check"></i> </button>
                <button type="button" class="btn btn-success btn-sm topButton" id="cancelPayFromHisabdariBtn" disabled> برگشت از دفتر حساب &nbsp; <i class="fa fa-check"></i> </button>
        </div>

        <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">
                     <div class="col-sm-4">
                        <div class="form-group mt-2">
                        </div>
                     </div>
                 </div>
                <div class="row mainContent">
                <table class="table table-hover table-bordered">
                    <thead class="tableHeader">
                        <tr class="bg-success">
                            <th> ردیف </th>
                            <th> شماره فاکتور</th>
                            <th>  تاریخ  </th>
                            <th style="width:180px;">واریز کننده</th>
                            <th> مبلغ </th>
                            <th> زمان ثبت</th>
                            <th>ارسال</th>
                        </tr>
                    </thead>
                    <tbody id="paymentListBody" class="tableBody">
                        @foreach ($pays as $pay) 
                            <tr @if($pay->isSent==1) class="payedOnline" @endif onclick="getPayDetail(this,{{$pay->id}},{{$pay->PSN}})">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pay->FactNo}}</td>
                                <td>{{$pay->payedDate}}</td>
                                <td style="width:180px; font-weight:bold;">{{$pay->Name}}</td>
                                <td  style="font-weight:bold;">{{number_format($pay->payedMoney/10)}} ت</td>
                                <td>{{$pay->TimeStamp}}</td>
                                <td> @if($pay->isSent==0)خیر  @else بله @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
					<table id="footer">
                    <div class="grid-tableFooter"> </div>
              </table>
         </div>
    </div>
    <div class="row contentFooter">
        <div class="text-end p-2"> 
            <button class="sefOrderBtn btn btn-sm btn-success" onclick="getOnlinePayHistory('TODAY')">  امروز </button> 
            <button class="sefOrderBtn btn btn-sm btn-success" onclick="getOnlinePayHistory('YESTERDAY')"> دیروز </button> 
            <button class="sefOrderBtn btn btn-sm btn-success" onclick="getOnlinePayHistory('LASTHUNDRED')"> صد تای آخر </button>
            <button class="sefOrderBtn btn btn-sm btn-success" onclick="getOnlinePayHistory('ALL')"> همه </button>
        </div>
    </div>
</div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection