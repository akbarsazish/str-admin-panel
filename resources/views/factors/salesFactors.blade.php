@extends('admin.layout')
@section('content')
<style>
    .trFocus:focus {
         background-color: lightblue !important;
    }
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


<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                    <button type="button" class="btn btn-success btn-sm topButton" id="saleToFactorSaleBtn">ارسال به فاکتور فروش <i class="fa fa-send"></i> </button>
                    {{-- <button type="button" class="btn btn-success btn-sm topButton" disabled data-toggle="modal" data-target="#orderReport">  گزارش سفارش   &nbsp; <i class="fa fa-list"></i> </button> --}}
                @endif
                    <span class="situation">
                        <fieldset class="border rounded">
                            <legend  class="float-none w-auto legendLabel mb-0">وضعیت</legend>
                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                            <div class="form-check">
                                <input class="form-check-input float-start" type="radio" name="sefRadio" id="sefNewOrderRadio" checked>
                                <label class="form-check-label ms-3" for="sefNewOrderRadio"> ارسال نشده </label>
                            </div>
                            @endif
                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                            <div class="form-check">
                                <input class="form-check-input float-start" type="radio" name="sefRadio" id="sefRemainOrderRadio">
                                <label class="form-check-label ms-3" for="sefRemainOrderRadio">  باطل </label>
                            </div>
                            @endif
                            <div class="form-check">
                                <input class="form-check-input float-start" type="radio" name="sefRadio" id="sefSentOrderRadio">
                                <label class="form-check-label ms-3" for="sefSentOrderRadio"> فاکتور شده </label>
                            </div>
                                    <!-- <div class="form-check">
                                        <input class="form-check-input float-start" type="radio" name="sefRadio" id="sefTodayOrderRadio">
                                            <label class="form-check-label ms-3" for="sefTodayOrderRadio">  امروزی  </label>
                                    </div> -->
                        </fieldset>
                    </span>

                    <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text" id="inputGroup-sizing-sm">تاریخ </span>
                        <input type="text" class="form-control form-control-sm" id="sefFirstDate">
                    </div>
                    <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                        <input type="text" class="form-control form-control-sm" id="sefSecondDate">
                    </div>
                    <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text" > طرف حساب </span>
                        <input type="text" id="sefTarafHisabCode" class="form-control form-control-sm"  placeholder="کد ">
                    </div>
                    <div class="mb-1 filterItems">
                        <input type="text" id="sefTarafHisabName" placeholder="نام " class="form-control form-control-sm form-control-sm">
                    </div>
                    <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> پشتیبان  </span>
                        <input type="text" class="form-control form-control-sm" placeholder="نام" id="sefPoshtibanName">
                    </div>
                    <button type="button" class="btn btn-success btn-sm topButton"  onclick="filterAllSefarishat()" > بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
            </fieldset>
        </div>
        <div class="col-sm-10 col-md-10 col-sm-10 contentDiv">
            <div class="row contentHeader"> 
                <div class="col-lg-12 text-end mt-1 actionButton">
                    
                </div>
            </div>
            <div class="row mainContent">
                <table class="table table-hover table-bordered table-sm">
                    <thead class="tableHeader" style="font-size:11px;">
                        <tr class="bg-success">
                            <th> ردیف </th>
                            <th class="forMobile" style="width:70px;"> شماره  </th>
                            <th class="forMobile"  style="width:77px;"> تاریخ </th>
                            <th class="forMobile"  style="width:77px;"> توضحیات </th>
                            <th class="forMobile"  style="width:77px;"> کد مشتری </th>
                            <th style="width:180px; font-weight:bold;"> نام مشتری </th>
                            <th class="forMobile" > مبلغ فاکتور </th>
                            <th> مبلغ دریافتی </th>
                            <th class="forMobile" > تنظیم کننده </th>
                            <th class="forMobile" > نحوه پرداخت </th>
                            <th class="forMobile" > شرح </th>
                            <th style="width:55px;">روز ارسال</th>
                            <th class="forMobile" > ارسال </th>
                        </tr>
                    </thead>
                    <tbody id="orderListBody" class="tableBody" style="height:233px !important;">
                        
                    </tbody>
                    <table id="footer">
                    <div class="grid-tableFooter">

                        </div>
                    </table>
                </table> <hr>
            
                <table class="table table-hover table-bordered table-sm">
                    <thead class="tableHeader" style="font-size:11px;">
                        <tr>
                            <th> ردیف </th>
                            <th style="width:160px;"> نام کالا </th>
                            <th class="forMobile"> تاریخ </th>
                            <th class="forMobile"> نوع بسته بندی </th>
                            <th> مقدار کل </th>
                            <th class="forMobile"> مقدار جز </th>
                            <th> مقدار سفارش </th>
                            <th  class="forMobile"> فاکتور شده </th>
                            <th class="forMobile"> نرخ </th>
                            <th> مبلغ </th>
                            <th class="forMobile"> شرح </th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailBody" class="tableBody" style="height:188px ! important; overflow-y: scroll;">
                    </tbody>
                </table>
            </div>
            <div class="row contentFooter">
                <div class="col-sm-12 mt-2 text-center"> 
                    <button class="sefOrderBtn btn btn-sm btn-success" value="TODAY">امروز</button> 
                    <button class="sefOrderBtn btn btn-sm btn-success" value="YESTERDAY">دیروز</button> 
                    <button class="sefOrderBtn btn btn-sm btn-success" value="HUNDRED">صد تای آخر</button>
                    <button class="sefOrderBtn btn btn-sm btn-success" value="ALL">همه</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection