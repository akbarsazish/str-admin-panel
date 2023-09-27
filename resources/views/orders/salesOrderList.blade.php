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
                    <button type="button" class="btn btn-success btn-sm" id="newOrderBtn" onclick="openNewOrderModal()">سفارش جدید &nbsp; <i class="fa fa-list"></i></button>
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 0)
                        <button type="button" class="btn btn-success btn-sm" id="openDashboard" onclick="openDashboard(this.value)"  disabled>داشبورد</button>
                        <button type="button" class="btn btn-success btn-sm" id="editOrderBtn" disabled>اصلاح &nbsp; <i class="fa fa-check"></i> </button>
                    @endif
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                        <button type="button" class="btn btn-danger btn-sm deletOrderButton" id="distroyOrderBtn" disabled  >باطل  &nbsp; <i class="fa fa-xmark"></i></button>
                    @endif
                    
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 0)
                        <form action="https://starfoods.ir/crmLogin" target="_blank"  method="get" style="display:inline;">
                            <input type="hidden" id="customerSn" name="psn" value="" />
                            <input type="hidden" name="otherName" value="{{Session::get('adminName')}}" />
                            <Button class="btn btn-success btn-sm mt-1 mb-1" disabled id="fakeLogin" type="submit"> ورود جعلی  <i class="fas fa-sign-in fa-lg"> </i> </Button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="row mainContent">
                <table class="table table-hover table-bordered table-sm">
                    <thead class="tableHeader" style="font-size:11px;">
                        <tr class="bg-success">
                            <th> ردیف </th>
                            <th class="forMobile" style="width:70px;"> شماره  </th>
                            <th class="forMobile"  style="width:77px;"> زمان ثبت</th>
                            <th style="width:180px; font-weight:bold;"> خریدار </th>
                            <th class="forMobile" > پشتیبان </th>
                            <th> مبلغ کل </th>
                            <th class="forMobile" > مبلغ مانده </th>
                            <th class="forMobile" > پرداختی </th>
                            <th class="forMobile" > شرح </th>
                            <th style="width:55px;">روز ارسال</th>
                            <th class="forMobile" > ارسال </th>
                        </tr>
                    </thead>
                    <tbody id="orderListBody" class="tableBody" style="height:233px !important;">
                        @foreach ($orders as $order)
                            <tr @if($order->isPayed==1) class="payedOnline" @endif onclick="getOrderDetail(this,{{$order->SnOrder}},{{$order->isPayed}},{{$order->CustomerSn}})">
                                <td>{{$loop->iteration}}</td>
                                <td class="forMobile"  style="width:70px;">{{$order->OrderNo}}</td>
                                <td class="forMobile"  style="width:77px;">{{$order->orderDateHijri}}</td>
                                <td style="width:180px; font-weight:bold;">{{$order->Name}}</td>
                                <td class="forMobile" >@if($order->adminName){{$order->adminName}} @else ندارد @endif</td>
                                <td  style="font-weight:bold;">{{number_format($order->allPrice/10)}}</td>
                                <td class="forMobile" style="color:red">{{number_format(($order->allPrice - $order->payedMoney)/10)}} ت</td>
                                <td class="forMobile" >{{number_format(($order->payedMoney)/10)}}</td>
                                <td class="forMobile" >{{$order->OrderDesc}}</td>
                                <td style="width:55px;">{{substr($order->OrderDate,5)}}</td>
                                <td class="forMobile" @if($order->OrderErsalTime==3) style="background-color:blue;color:white;" @endif>
                                    @if($order->OrderErsalTime==1) صبح 
                                    @elseif($order->OrderErsalTime==2) بعد از ظهر @elseif($order->OrderErsalTime==3) فوری @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <table id="footer">
                    <div class="grid-tableFooter">
                        <div class="tableFooter-item"> مجموع : <span class="textContent" id="sendTotalMoney"> {{number_format($allMoney/10)}} ت </span>  </div>
                        <div class="tableFooter-item"> مبلغ باقی مانده :  <span class="textContent text-danger" id="sendRemainedTotalMoney"> {{number_format(($allMoney-$allPayed)/10)}} ت </span>  </div>  
                        <div class="tableFooter-item"> پرداختی : <span class="textContent" id="sendAllPayedMoney"> {{number_format(($allPayed)/10)}} ت </span>  </div>
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
<!-- send to sales factors -->
<div class='modal fade dragAbleModal' id='sentTosalesFactor' data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class='modal-dialog modal-dialog-scrollable modal-fullscreen'>
        <div class='modal-content'>
            <div class='modal-header bg-success py-2'>
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h6 class='modal-title text-white' id='exampleModalLongTitle'>جزئیات سفارش در حال ارسال</h6>
            </div>
            <div class='modal-body'>
                <form action="{{url('/addToFactorHisabdari')}}" method="post" id="sendToFactorList">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <!-- <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title="گردش کالا" data-toggle="modal" data-target="#gardishKala">
                                    <i class="fa-solid fa-rotate fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title="گردش شخصی ">
                                    <i class="fa-solid fa-user fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title=" اصلاح کالا ">
                                    <i class="fa-solid fa-check fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title=" اصلاح شخص ">
                                    <i class="fa-solid fa-id-card fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title=" 10 خرید آخر ">
                                    <i class="fa-solid fa-circle-up fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title="10 فروش آخر">
                                    <i class="fa-solid fa-circle-down fa-2x"></i>
                            </span>
                            <span class="customeIcons" data-bs-toggle="tooltip" data-bs-placement="top" title=" سفارش تحویل نشده  ">
                                    <i class="fa-solid fa-shopping-cart fa-2x"></i>
                            </span> -->
                        </div>
                        <div class="col-lg-3 col-md-3 text-end">
                            <button type="button" class="btn btn-success btn-sm" id="sendSabtFactorBtn">  ثبت <i class="fa fa-save"></i> </button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss='modal'> انصراف <i class="fa fa-xmark"></i> </button>
                            <a class="btn btn-success btn-sm" id="phoneLink" href="#"> تماس <i class="fa fa-phone"></i> </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="row mb-1">
                                    <div class="col-lg-2 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > شماره فاکتور </span>
                                            <input type="text" class="form-control" id="sendFactorNo">
                                            <input type="hidden" class="form-control" name="orderHDS" id="sendFatorHDS">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="CustomerSn" id="sendCustomerSn">
                                        <select class="form-select form-select-sm" name="stockId" id="sendSelectedStockOrder">
                                            <option value="1">انبار اصلي</option>
                                            <option value="2">افشار</option>
                                            <option selected value="23">انبار سعيد اباد</option>
                                            <option value="4">ملک محمدي هيدج</option>
                                            <option value="5">بندر</option>
                                            <option value="6">انبار يزدان</option>
                                            <option value="7">انبار قدس تبريز</option>
                                            <option value="8">انبار شکر</option>
                                            <option value="9">انبار نازگل</option>
                                            <option value="10">سلام</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" >تاریخ </span>
                                            <input type="text" name="sendOrderDate" class="form-control" id="sendOrderDate">
                                        </div>
                                    </div>
                            </div>
                            <div class="row mb-1">
                                   <!-- <div class="col-lg-4 col-md-4">
                                    <div class="form-check">
                                             <input class="form-check-input float-start" type="checkbox" value="" id="flexCheckDefault" style="padding:6px">
                                            <label class="form-check-label ms-3" for="flexCheckDefault">
                                                    سفارشات به صورت اتوماتیک لیست شود
                                            </label> 
                                        </div>
                                </div>-->
                                <div class="col-lg-6 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > خریدار </span>
                                            <input type="number" class="form-control someInput" id="sendPCode" placeholder="">
                                            <input type="text" class="form-control" placeholder="مهدی محمدی" id="sendName">
                                            <!-- <button  class="btn btn-sm btn-success btn-sm"> گردش حساب </button> -->
                                        </div>
                                    </div>
                            </div>
                            <div class="row mb-1">
                                    <div class="col-lg-2 mx-0">
                                        <select class="form-select form-select-sm d-sm-inline-block" id="sendSelectedStockKala">                                               
                                            <option value="0">انبار اصلي</option>
                                            <option value="20">مغازه انبارنفت </option>
                                            <option selected value="23">انبار سعيد اباد</option>
                                            <option value="21">افشار</option>
                                            <option value="24">ملک محمدي هيدج </option>
                                            <option value="25">بندر</option>
                                            <option value="26">انبار يزدان </option>
                                            <option value="27">بنگاه سلام </option>
                                            <option value="28">انبار قدس تبريز </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" >شماره تماس</span>
                                        <input type="text" class="form-control" id="sentPhoneStr" placeholder="09100000000" >
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 mb-1">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text">مبلغ کل(تومان)</span>
                                            <input type="text" id="sentTotalAmount" class="form-control" placeholder="2344534" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" >مبلغ مانده(تومان)</span>
                                            <input type="text" id="sentRemainedAmount" class="form-control" placeholder="12457" >
                                        </div>
                                    </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-lg-9 col-md-9">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text"> توضیحات </span>
                                        <input type="text" class="form-control" id="sendDiscription" placeholder="مهدی   محمدی" >
                                        </div>
                                    </div>
                                     <!-- <div class="col-lg-3">
                                       <select class="form-select form-select-sm" id="">
                                            <option selected> نحوه تحویل کالا </option>
                                            <option value="1"> تحویل به مشتر </option>
                                            <option value="2"> ارسال به آدرس مشتری </option>
                                        </select> 
                                    </div>-->
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" > مبلغ تخیف کیف پول: <span id="takfifCaseTakenMoney"></span> </span>
                                        <span class="input-group-text" > جوایز لاتاری: <span id="lotteryTakenGood">  </span></span>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text"> زمان رسید </span>
                                            <select class="form-select form-select-sm" id="sendAmPm">
                                                <option value="1" id="sendAm"> صبح  </option>
                                                <option value="2" id="sendPm"> عصر </option>
                                                <option value="3" id="sendPm"> فوری </option>
                                            </select>
                                        </div>
                                    </div> 
                            </div>
                            <div class="row mb-1">
                                    <div class="col-lg-1 input-group-sm" style="padding-left:0px;">
										 <span class="input-group-text"> آدرس </span>
									</div>
									<div class="col-lg-10" style="padding-right:0px;">
                                        <select class="form-select form-select-sm" name="addressSn" id="sendAddress">
                                            <option selected> آدرس </option>
                                        </select>
                                    </div>
                            </div>
                        </div> 
						
                        <div class="col-lg-3 col-md-3">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mt-1">
                                    <div class="form-check">
                                            <!-- <input class="form-check-input float-start" type="checkbox" value="" id="flexCheckDefault" style="padding:6px">
                                            <label class="form-check-label ms-3" for="flexCheckDefault">
                                                کرایه دریافت شد
                                            </label> -->
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 shortExp">
                                    <div id="NotExistanceDiv">
                                        <!-- <p>این کالاها در انبار موجودی کافی ندارد.</p> -->
                                        <span class="description"> موجودی انبار : <b id="sendStockExistance">0 </b></span> <br>
                                        <span class="description">  قیمت فروش : <b id="sendPrice">ندارد </b></span> <br>
                                        <span class="description"> اخرین قیمت فروش به این مشتری : <b id="sendPriceCustomer">ندارد</b> </span> <br>
                                        <span class="description"> آخرین قیمت فروش :  <b id="sendLastPrice">ندارد</b> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="tableHeader">
                        <tr class="bg-success">
                                <th> ردیف</th>
                                <th class="forMobile"> کد کالا </th>
                                <th>  نام کالا </th>
                                <th class="forMobile">  تاریخ  </th>
                                <th class="forMobile"> واحد کالا </th>
                                <th>  نوع بسته بندی  </th>
                                <th class="forMobile">  مقدار کل    </th>
                                <th class="forMobile"> مقدار جز</th>
                                <th> مقدار سفارش </th>
                                <th class="forMobile">  فاکتور شده  </th>
                                <th class="forMobile">نرخ </th>
                                <th>مبلغ  </th>
                                <th class="forMobile">شرح  </th>
                            </tr>
                        </thead>
                        <tbody id="sendSalesOrdersItemsBody" class="tableBody">
                            <tr>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                            </tr>
                            <tr>
                                <td> 2 </td>
                                <td class="searchingKalaTd"> 234 </td>
                                <td class="searchingKalaTd"> واحد کالا </td>
                                <td class="searchingKalaTd">  نام کالا </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                            </tr>
                        </tbody>
                    </table> 

                    <div class="row mt-5 pb-5">
                        <!-- <div class="col-lg-4 col-md-4"> -->
                            <!-- <table class="table table-striped table-bordered">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>شرح </th>
                                        <th>  مبلغ </th>
                                        <th> وضعیت </th>
                                </thead>
                                <tbody class="tableBody">
                                    <tr>
                                        <td> 1 </td>
                                        <td> شرح شرح ینبتینم </td>
                                        <td> 34532432 </td>
                                        <td> یبیسب </td>
                                    </tr>
                                    <tr>
                                        <td> 1 </td>
                                        <td> شرح شرح ینبتینم </td>
                                        <td> 34532432 </td>
                                        <td> یبیسب </td>
                                    </tr>
                                </tbody>
                            </table> -->
                        <!-- </div>
                        <div class="col-lg-5 shortExp"> -->
                                <!-- <div class="row">
                                    <div class="col-lg-5">
                                            <span class="description"> جمع بسته ها: <b>20 </b></span>
                                            <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > وزن </span>
                                            <input type="number" class="form-control" aria-label="Sizing example input" placeholder="34kg" aria-describedby="inputGroup-sizing-sm" disabled>
                                            </div>
                                            <button type="button" class="btn btn-sm btGroup btn-success deletOrderButton"> حذف کالا <i class="fa fa-xmark"></i> </button>
                                            <button type="button" class="btn btn-sm btGroup btn-success" data-toggle="modal" data-target="#factorCostBtn"> هزینه ها  <i class="fa fa-list"></i> </button>
                                            <button type="button" class="btn btn-sm btGroup btn-success" data-toggle="modal" data-target="#payFactorAmount">پرداخت مبلغ فاکتور <i class="fa fa-pay"></i> </button>
                                            <button type="button" class="btn btn-sm btGroup btn-success deletOrderButton"> حذف مبالغ دریافتی  <i class="fa fa-dollar"></i> </button>
                                    </div>
                                    <div class="col-lg-7">
                                            <span class="sumRow"> جمع تار دیف جاری :  87988987</span> <hr>
                                            <span class="sumRow mb-3"> مجموع     :  87988980907</span> <br> <br>
                                            <span class="sumRow"> جمع هزینه ها  :  </span><br>
                                            <span class="sumRow"> مالیات بر ارزش افزوده : </span><br>
                                            <span class="sumRow"> جمع تخفیف درصدی: </span><br>
                                            <div class="input-group input-group-sm mb-1">
                                                <span class="input-group-text" > مبلغ تخفیف </span>
                                                <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" >
                                                <button  class="btn btn-sm btn-success btn-sm"> ...</button>
                                            </div> <hr>
                                            <span class="sumRow"> مبلغ قابل دریافت: </span><br>
                                            <span class="sumRow"> دریافتی : </span><br>
                                    </div>
                                </div> -->
                            
                            <!-- </div>
                        <div class="col-lg-3 col-md-3"> -->
                            <!-- <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>  نحوه پرداخت   </option>
                                <option value="0">  تسویه نقدی   </option>
                                <option value="1"> نقدی  </option>
                                <option value="2">پیک </option>
                                <option value="3"> حواله  </option>
                                <option value="4"> چک  </option>
                                <option value="5"> کارتخوان  </option>
                            </select> <hr>
                            <span class="sumRow"> مبلغ فاکتور قبل  : </span><br> -->
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مدال لاتری -->
<div class='modal fade dragAbleModal' id='wonLotteryModal' data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class='modal-dialog modal-dialog-scrollable'>
        <div class='modal-content'>
            <div class='modal-header bg-info py-2'>
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h6 class='modal-title text-white'> جوایز لاتاری </h6>
            </div>
            <div class='modal-body'>
                <table class="table table-stripped">
                    <thead class="bg-success">
                        <tr class="bg-success">
                            <th>ردیف</th> 
                            <th>جایزه</th> 
                        </tr>
                    </thead>
                    <tbody id="lotteryGiftsBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 

<!--- مودال آلارم سفارش فوری-->

<div class='modal fade dragAbleModal' id='imediatOrderModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' >
        <div class='modal-content'>
            <div class='modal-header py-2 text-white bg-success'>
                <h5 class='modal-title' id='exampleModalLongTitle'> آلارم سفارشات فوری </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <table class="table table-striped">
                    <thead class="tableHeader">
                        <tr>
                        <th scope="col"> ردیف </th>
						<th scope="col"> کد </th>
                        <th scope="col"> مشتری </th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach($imediatOrders as $order)
                        <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td> {{ $order->PCode }} </td>
						<td> {{ $order->Name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- آلیرت موجودی دذ زمان تبدیل به فاکتور -->

@include('../customer.modalDashboard')

<!-- Modal -->
<div class="modal fade" id="notExistGoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 text-white">
                <h5 class="modal-title" >کالاهای بدون موجودی</h5>
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>می خواهید این کالاها را با مقادیر زیر ثبت کنید؟</h3>
                <table class="table table-striped table-bordered">
                    <thead class="tableHeader">
                        <tr class="bg-success">
                            <th> ردیف</th>
                            <th>  نام کالا </th>
                            <th> کد کالا </th>
                            <th>موجودی</th>
                            <th>موجودی</th>
                        </tr>
                    </thead>
                    <tbody id="notExistGoodsBody" class="tableBody">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cancel" data-dismiss="modal">نخیر</button>
                <button type="submit" id="sendToFactor" class="btn btn-success">ثبت شوند</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal for gardish kala ba sorat bala vawayla -->
<div class="modal fade dragAbleModal" id="gardishKala" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="gardishKalaLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-5" id="gardishKalaLabel"> گردش کالا  </h5>
      </div>
      <div class="modal-body">
         <div class="row px-0 mx-0">
            <div class="col-lg-3 p-2" style="background-color:#63bea2">
                   <div class="row ">
                       <div class="col-lg-12 p-2">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected class="text-end"> سال مالی </option>
                                <?php
                                    for ($i = 1396; $i < 1450; $i++) {?>
                                        <option value="1" class="text-end"> <?php  echo $i ?> </option>
                                <?php  } ?>
                            </select>
                      </div>
                   </div>
                <fieldset class="border rounded">
                        <legend  class="float-none w-auto legendLabel mb-0"> شرایط گزارش  </legend>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > کد کالا </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" placeholder="587" aria-describedby="inputGroup-sizing-sm disabled">
                        </div>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <option selected> قند قله 40 کیلوی البرز </option>
                            <option value="0"> روغن  </option>
                            <option value="1"> برنج   </option>
                            <option value="2">لوبیا  </option>
                        </select>  
                        <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example">
                            <option selected> انبار اصلی  </option>
                            <option value="0"> انبار سعید اباد   </option>
                            <option value="1"> انبار کرج </option>
                        </select> 
                        <div class="input-group input-group-sm mb-1 mt-3">
                            <span class="input-group-text" >تاریخ </span>
                            <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > الی </span>
                            <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                      
                </fieldset>
            </div>
            <div class="col-lg-9">
            <table class="table table-striped table-bordered table-sm">
                    <thead class="tableHeader">
                        <tr>
                            <th>ردیف</th>
                            <th> تاریخ  </th>
                            <th> شرح </th>
                            <th> شماره </th>
                            <th> وارده  </th>
                            <th> صادره  </th>
                            <th> موجودی </th>
                            <th>  انبار </th>
                            <th> نام طرف حساب </th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                           
                        </tr>
                    </tbody>
                </table>
            </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
        <button type="button" class="btn btn-sm btn-success"> ذخیره <i class="fa fa-save"></i> </button>
      </div>
    </div>
  </div>
</div>





<!-- new order modal  -->
<div class='modal fade dragAbleModal' id='newOrder' data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <input type="hidden" id="rowTaker">
    <div class='modal-dialog modal-fullscreen'>
        <div class='modal-content'>
            <div class='modal-header bg-success text-white py-2'>
                <h5 class='modal-title text-white' id='exampleModalLongTitle'> سفارش فروش </h5>
            </div>
            <div class='modal-body'>
                <form action="{{url('/addSefarishToList')}}" method="post" id="addNewOrderForm"> 
                    @csrf
                <div class="row mb-3 mtn-3">
                    <div class="col-lg-9 col-md-9">
                    </div>
                    <div class="col-lg-3 col-md-3 text-end">
                        <button class="btn btn-success btn-sm" type="submit"> ثبت <i class="fa fa-save"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm"  onclick="closeNewOrderModal()"> انصراف <i class="fa fa-xmark"></i> </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" >تاریخ </span>
                                    <input type="text" class="form-control" autocomplete="off" name="orderDate" id="sendDateFromSefarishPage" required>
                                </div>
                            </div>
                            <div class="col-lg-8 mx-0">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" > کد مشتری </span>
                                    <input type="text" class="form-control form-control-sm" id="customerCodeInput" autocomplete="off" onkeyup="getCustomerByCode(this.value)">
                                    <span class="input-group-text" > نام مشتری </span>
                                    <input type="text" id="searchCustomerNameInput" class="form-control form-control-sm" autocomplete="off" aouto required>
                                    <select name="customerForSefarishId"  id="customerForSefarishId" class="form-select customerForSefarishId d-none">
                                    </select>
                                    <input type="text" class="form-control" id="inputInsteadOfSelect" style="display:none">
                                    <!-- <button  class="btn btn-sm btn-success btn-sm"> گردش حساب </button> -->
                                </div>
                            </div>
                        </div>
                        <div class="d-none">
                            <input type="text" id="hamlMoney" value="0" name="hamlMoney">
                            <input type="text" id="hamlDesc" name="hamlDesc">
                            <input type="text" id="nasbMoney" value="0"  name="nasbMoney">
                            <input type="text" id="nasbDesc"  name="nasbDesc">
                            <input type="text" id="motafariqaMoney" value="0"  name="motafariqaMoney">
                            <input type="text" id="motafariqaDesc"  name="motafariqaDesc">
                            <input type="text" id="bargiriMoney" value="0"  name="bargiriMoney">
                            <input type="text" id="bargiriDesc"  name="bargiriDesc">
                            <input type="text" id="tarabariMoney" value="0"  name="tarabariMoney">
                            <input type="text" id="tarabariDesc"  name="tarabariDesc">
                        </div>
                          <!-- <div class="row">
                              <div class="col-lg-4 mx-0">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" > خریدار متفرقه</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" placeholder="مهدی محمدی" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                </div>
                              <div class="col-lg-3">
                                   <div class="input-group input-group-sm mb-1">
                                      <span class="input-group-text" > بازاریاب </span>
                                      <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled">
                                    </div>
                                </div>
                                <div class="col-lg-4 mx-0">
                                      <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example">
                                        <option selected> انبار اصلی </option>
                                        <option value="1">مغازه انبار نفت</option>
                                        <option value="2">افشار</option>
                                        <option value="3">انبار پشتیبان</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 mt-1">
                                     <button class="d-sm-inline-block bg-success p-1">... </button>
                                </div>
                          </div> -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" > توضیحات </span>
                                    <input type="text" class="form-control" name="orderDescription">
                                </div>
                            </div>
                            <!-- <div class="col-lg-3">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" >  نحوه تحویل کالا </span>
                                    <select class="form-select form-select-sm">
                                        <option value="1"> تحویل به مشتر </option>
                                        <option value="0"> ارسال به آدرس مشتری </option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-lg-3">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" > زمان رسید </span>
                                    <select name="amOrPm" class="form-select form-select-sm">
                                        <option value="1"> صبح </option>
                                        <option value="2"> عصر </option>
                                        <option value="3"> فوری </option>
                                    </select>
                                </div>
                            </div>  -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" > آدرس</span>
                                    <select class="form-select form-select-sm" name="customerAddress" id="customerAddressForSefarish" required>
                                        <option selected> آدرس </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-3">
                       <!-- <div class="row">
                            <div class="col-lg-12 col-md-12 mt-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text" > نوع برگه </span>
                                    <select class="form-select form-select-sm">
                                        <option value="1"> سفارش فروش   </option>
                                        <option value="2"> پیش فاکتور </option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input float-start" type="checkbox" id="checkExitanceForAddToSefarish" style="padding:6px" checked>
                                    <label class="form-check-label ms-3" for="flexCheckDefault">
                                        موجودی کالا کنترل شود 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="background-color:#e0e0e0;">
                                <span class="description"> موجودی انبار : <b id="goodAmountInStock"> 0 </b></span> <br>
                                <span class="description">  قیمت فروش : <b id="goodPriceAddSefarish"> 0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="lastSalePriceToThisCustomerAddSefarish"></b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="lastSalePriceAddSefarish"> 0 </b> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <table class="table table-striped table-bordered table-sm" id="newSefarishTbl">
                    <thead>
                        <tr>
                            <th style="width:30px!important;" > ردیف </th>
                            <th style="width:40px!important;" > کد کلا </th>
                            <th style="width:130px!important;" > نام کلا </th>
                            <th style="width:50px!important;" > واحد کالا </th>
                            <th style="width:70px!important;" > بسته بندی </th>
                            <th style="width:70px!important;" > مقدار کل </th>
                            <th style="width:50px!important;" > مقدار جز </th>
                            <th style="width:70px!important;"> مقدار کالا </th>
                            <th style="width:70px!important;"> نرخ واحد </th>
                            <th style="width:70px!important;"> نرخ بسته </th>
                            <th style="width:70px!important;"> مبلغ </th>
                            <th style="width:70px!important;"> نوع ارسال </th>
                            <th style="width:60px!important;"> شرح </th>
                        </tr>
                    </thead>
                    <tbody class="tableBodyNewOrder" id="addsefarishtbl">
                        <tr>
                            <td style="width:30px!important;"> 1 </td>
                            <td style="width:40px!important;"  class="td-part-input"> <input type="text" class="td-input td-inputCode form-control" required> </td>
                            <td style="width:130px!important;" class="td-part-input"> <input type="text" class="td-input td-inputCodeName form-control" required> </td>
                            <td style="width:50px!important;"  class="td-part-input">  </td>
                            <td style="width:70px!important;"  class="td-part-input">  </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control" required> </td>
                            <td style="width:50px!important;"  class="td-part-input"> <input type="text" class="td-input form-control" required> </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control"> </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control"> </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control"> </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control"> </td>
                            <td style="width:70px!important;"  class="td-part-input"> <input type="text" class="td-input form-control"> </td>
                            <td style="width:45px!important;"  class="td-part-input"> <input type="text" class="td-input td-inputDescription form-control"> </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  col-sm-12"  style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                            <span class="sumRow mt-4"> آخرین وضعیت مشتری :   <b id="lastCustomerStatus"></b> </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4"></div>
                <div class="col-lg-4 col-md-4" style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                    <div class="row">
                        <div class="col-lg-5">
                            <button type="button" class="btn btn-sm btGroup btn-success deletOrderButton" id="deleteOrderItemBtn"> حذف کالا <i class="fa fa-xmark"></i> </button>
                            <button type="button" class="btn btn-sm btGroup btn-success mb-3" onclick="showAmelModal()"> هزینه ها  <i class="fa fa-list"></i> </button> <br>
                            <span class="sumRow mt-4"> وزن     :  </span> <br>
                            <span class="sumRow">  حجم  :  </span><br><br>
                        </div>
                        <div class="col-lg-7">
                            <span class="sumRow border-bottom"> جمع تار دیف جاری :  <b id="allMoneyTillThisRow"></b></span> <hr>
                            <span class="sumRow mb-3"> مجموع     :  <b id="allMoneyTillEndRow"></b> </span> <br>
                            <span class="sumRow"> جمع هزینه ها  :  <b id="allAmelMoney">0</b></span><br> <br>
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text" > مبلغ تخفیف </span>
                                <input type="number" class="form-control" name="takhfif"  id="newOrderTakhfifInput"/>
                            </div> <hr>
                            <span class="sumRow"> مجموع : <b id="sumAllRowMoneyAfterTakhfif"></b></span><br>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="addAmelModal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> افزودن هزینه به سفارش </h5>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTble">
                <thead class="tableHeader">
                    <tr>
                        <th> ردیف </th>
                        <th> هزینه </th>
                        <th> افزوده به سفارش </th>
                        <th> توضیح </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 1 </td>
                        <td> هزینه حمل </td>
                        <td><input type="text" name="hamlMoney" id="hamlMoneyModal" class="td-input form-control"></td>
                        <td><input type="text" name="hamlDesc" id="hamlDescModal"  class="td-input form-control"></td>
                    </tr>
                    <tr>
                        <td> 2 </td>
                        <td> هزینه های نصب </td>
                        <td><input type="text"  name="nasbMoney" id="nasbMoneyModal" class="td-input form-control"></td>
                        <td><input type="text"  name="nasbDesc" id="nasbDescModal" class="td-input form-control"></td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> هزینه های متفرقه </td>
                        <td><input type="text"  name="motafariqaMoney" id="motafariqaMoneyModal" class="td-input form-control"></td>
                        <td><input type="text"  name="motafariqaDesc" id="motafariqaDescModal" class="td-input form-control"></td>
                    </tr>
                    <tr>
                        <td> 4 </td>
                        <td> بارگیری </td>
                        <td><input type="text"  name="bargiriMoney" id="bargiriMoneyModal" class="td-input form-control"></td>
                        <td><input type="text"  name="bargiriDesc" id="bargiriDescModal" class="td-input form-control"></td>
                    </tr>
                    <tr>
                        <td> 5 </td>
                        <td> ترابری </td>
                        <td><input type="text"  name="tarabariMoney" id="tarabariMoneyModal" class="td-input form-control"></td>
                        <td><input type="text"  name="tarabariDesc" id="tarabariDescModal" class="td-input form-control"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" id="cancelAmelButton" class="btn btn-danger btn-sm" data-dismiss="modal"> انصراف </button>
            <button type="button" id="sabtAmelButton" class="btn btn-success btn-sm" onclick="addAmelToSefarish()"> ذخیره </button>
        </div>
    </div>
  </div>
</div>

<!-- order editing modal  -->
<div class='modal fade dragAbleModal' id='orderEditingModal' tabindex="-1">
    <div class='modal-dialog modal-dialog-scrollable modal-xl'>
        <div class='modal-content'>
            <form action="{{url('/editorderSendState')}}" method="get" id="editSendForm">
                <div class='modal-header bg-success text-white py-2'>
                    <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                    <h5 class='modal-title text-white' id='exampleModalLongTitle'> ویرایش سفارش فروش </h5>
                    <input type="hidden" id="editCustomerSn">
                    <input type="hidden" id="editInVoiceNumber">
                    <input type="hidden" id="EditHDSSn" name="EditHDSSn">
                </div>
                <div class='modal-body'>
                    <div class="row mb-3 mtn-3">
                        <div class="col-lg-6 col-md-6">
                        </div>
                        <div class="col-lg-6 col-md-6 text-end">
                            <button type="button" disabled id="editSabtBtn" onclick="addItemToOrder()"  class="btn btn-success btn-sm"> افزودن <i class="fa fa-plus"></i> </button>
                            <button type="button" disabled class="btn btn-warning btn-sm" id="editEditOrderItem">  ویرایش <i class="fa fa-edit"></i> </button>
                            <button type="button" class="btn btn-danger btn-sm ms-3" id="editDeleteOrderItem"> حذف <i class="fa fa-trash"></i> </button>
                            <button type="button" class="btn btn-success btn-sm ms-3" style="display:none" id="editedCustomerSn"> تایید تغیر مشتری <i class="fa fa-check"></i> </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="row">
                                   <div class="col-lg-3 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > شماره سفارش </span>
                                            <input type="text" id="editFactorNo" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" >تاریخ </span>
                                            <input type="text" class="form-control" id="editOrderDate">
                                            <input type="hidden" class="form-control" name="orderSn" id="editSentOrderSn">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > کد مشتری </span>
                                            <input type="number" class="form-control someInput" id="editPCode">
                                            <span class="input-group-text" > نام مشتری </span>
                                            <input type="text" id="CustomerNameEditInput" class="form-control form-control-sm" autocomplete="off" required>
                                            <select name="CustomerSn" class="form-select d-none" id="editName">
                                            </select>
                                            <!-- <button  class="btn btn-sm btn-success btn-sm"> گردش حساب </button> -->
                                        </div>
                                    </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-lg-6 mx-0">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > خریدار متفرقه</span>
                                            <input type="text" class="form-control"  placeholder="مهدی محمدی" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>
                                <div class="col-lg-6">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" > بازاریاب </span>
                                        <input type="number" class="form-control"  placeholder="762" >
                                        </div>
                                    </div>
                            </div> -->
                            <div class="row">
                                <div class="col-lg-7 col-md-7">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" > شرح </span>
                                        <input type="text" id="editDiscription" class="form-control" aria-label="Sizing example input" placeholder="مهدی   محمدی" >
                                        </div>
                                    </div>
								    <div class="col-lg-2">
                                        <select class="form-select form-select-sm">
                                            <option hidden> زمان ارسال </option>
                                            <option value="1" id="editAm"> صبح  </option>
                                            <option value="0" id="editPm"> عصر </option>
                                        </select>
                                    </div> 
								
                                    <div class="col-lg-3"  id="editSendState" style="display:none;">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" >وضعیت ارسال</span>
                                        <select class="form-select form-select-sm" name="orderState">
                                            <option value="1" id="editSentOption">ارسال شده</option>
                                            <option value="0" id="editUnSentOption">ارسال نشده</option>
                                            <option value="2" id="editDistroyOption">باطل</option>
                                        </select>
                                        </div>
                                    </div>
                                   
                            </div>
                            <div class="row">
								    <div class="col-lg-1 input-group-sm" style="padding-left:0px;">
										 <span class="input-group-text"> آدرس </span>
									</div>
                                    <div class="col-lg-11"  style="padding-right:0px;">
                                        <select class="form-select form-select-sm" id="editAddress" name="editAddress">
                                            <option selected> ادرس ارسال </option>
                                            <option value="1"> کرج  </option>
                                            <option value="1"> شهریار </option>
                                        </select>
                                    </div>
                            </div>
                        </div> 
                        <div class="col-lg-3 col-md-3">
                        <!-- <div class="row">
                                <div class="col-lg-12 col-md-12 mt-1">
                                    <select class="form-select form-select-sm" >
                                        <option selected> نوع برگه </option>
                                        <option value="1"> سفارش فروش   </option>
                                        <option value="1"> پیش فاکتور </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mt-1">
                                    <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" value="" id="flexCheckDefault" style="padding:6px">
                                            <label class="form-check-label ms-3" for="flexCheckDefault">
                                                موجودی کالا کنترل شود 
                                            </label>
                                        </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-lg-12" style="background-color:#e0e0e0;">
                                    <span class="description"> موجودی انبار : <b id="firstEditExistInStock">0</b></span> <br>
                                    <span class="description">  قیمت فروش : <b id="firstEditPrice">0</b></span> <br>
                                    <span class="description"> اخرین قیمت فروش به این مشتری : <b id="firstEditLastPriceCustomer">0</b></span> <br>
                                    <span class="description"> آخرین قیمت فروش :  <b id="firstEditLastPrice">0</b> </span>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="tableHeader">
                            <tr>
                                <th>ردیف</th>
                                <th class="forMobile"> کد کالا </th>
                                <th style="width:180px;"> نام کالا </th>
                                <th class="forMobile"> تاریخ </th>
                                <th class="forMobile"> واحد کالا </th>
                                <th class="forMobile"> بسته بندی </th>
                                <th> مقداری کل  </th>
                                <th class="forMobile"> مقدار جز </th>
                                <th class="forMobile"> مقدار کالا </th>
                                <th class="forMobile"> نرخ واحد </th>
                                <th class="forMobile"> نرخ بسته </th>
                                <th> مبلغ </th>
                                <th class="forMobile"> شرح </th>
                            </tr>
                        </thead>
                        <tbody  class="tableBody" style="height:233px !important;" id="editSalesOrdersItemsBody">
                        </tbody>
                    </table> 

                    <div class="row mt-5">
                        <div class="col-lg-5 col-md-5">
                            <!-- <div class="row mb-3 increasDecreas">
                                <i class="fa fa-plus-circle fa-2xl  mx-5" style="color:green;"></i> 
                                <i class="fa fa-minus-circle fa-2xl " aria-hidden="true" style="color:green;"></i>
                                
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th> آخرین وضعیت شخص </th>
                                        <th>   </th>
                                        <th> بی حساب </th>
                                </thead>
                                <tbody class="tableBody">
                                    <tr>
                                        <td> 1 </td>
                                        <td> شرح شرح ینبتینم </td>
                                        <td>  </td>
                                        <td> یبیسب </td>
                                    </tr>
                                    <tr>
                                        <td> 1 </td>
                                        <td> شرح شرح ینبتینم </td>
                                        <td>  </td>
                                        <td> یبیسب </td>
                                    </tr>
                                </tbody>
                            </table> -->
                        </div>
                        <div class="col-lg-2 col-md-2"> </div>
                        <div class="col-lg-5" style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <button type="button" class="btn btn-sm btGroup btn-success mb-3" onclick="showOnlinePaymentInfo()">جزءیات پرداخت آنلاین<i class="fa fa-list"></i></button><br>    
                                    </div>
                                    <div class="col-lg-7">
                                            <span class="sumRow mb-3">مجموع(تومان):<b id="editTotalMoney"></b></span> <br>
                                            <span class="sumRow"> جمع هزینه ها(تومان):<b id="editTotalCosts"></b></span><br> <br>
                                        
                                            <div class="input-group input-group-sm mb-1">
                                                <span class="input-group-text" >مبلغ تخفیف(تومان) </span>
                                                <input type="number" class="form-control" placeholder="762" id="editTakhfifTotal">
                                            </div> 
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class='modal fade dragAbleModal' id='customerForSefarishModal' data-backdrop="static" tabindex="-1" >
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-success text-white py-2'>
                <h5 class='modal-title text-white' > جستجوی مشتری </h5>
            </div>
            <div class='modal-body'>
                <div class="row mb-3 mtn-3">
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text"> نام شخص </span>
                            <input type="text" class="form-control form-control-sm" id="customerNameForOrder" autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text"> بر اساس شماره تماس جستجو شود.</span>
                            <input type="checkbox" class="form-input" name="searchByPhone" id="seachByPhoneNumberCheckBox">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button type="button" disabled id="searchCustomerSabtBtn" onclick="chooseCustomerForOrder(this.value)"  class="btn btn-success btn-sm"> انتخاب <i class="fa fa-check"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm ms-3" id="searchCustomerCancelBtn"> انصراف <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTble">
                    <thead class="tableHeader">
                        <tr>
                            <th> ردیف </th>
                            <th> کد   </th>
                            <th> نام  </th>
                            <th> خرید </th>
                            <th> فروش </th>
                            <th> تعداد چک برگشتی </th>
                            <th> مبلغ چک های برگشتی </th>
                        </tr>
                    </thead>
                    <tbody class="tableBody" id="foundCusotmerForOrderBody">
                    </tbody>
                </table> 
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- online payment modal info -->
<div class="modal" id="onlinePaymentModalInfo"   data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog-lg" role="document">
    <div class="modal-content">
        <div class="modal-header  bg-success text-white py-2">
            <h5 class="modal-title" id="exampleModalLabel">جزءیات پرداخت آنلاین</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th> ردیف </th>
                    <th> کد رهگیری </th>
                    <th> کد ارجاع </th>
                    <th> تاریخ تراکنش </th>
                    <th> شماره تراکنش </th>
                    <th> مبلغ </th>
                    <th> شماره کارت </th>
                    <th> موفقیت </th>
                    <th> پیام </th>
                </tr>
            </thead>
            <tbody class="tableBody" id="editOnlinePaymentBody">
            </tbody>
        </table> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
      </div>
    </div>
  </div>
</div>

<!-- ordrer report Modal -->
<div class="modal fade" id="orderReport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="orderReportLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h6 class="modal-title " id="ordeportLabel"> گزارش سفارش </h6>
      </div>
      <div class="modal-body" style="background-color:#8bcce3;">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label ms-4" for="flexCheckDefault">
                            سفارش های فاکتور نشده
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label ms-4" for="flexCheckDefault">
                            سفارش های فاکتور شده 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label ms-4" for="flexCheckDefault">
                            سفارش های باطل شده
                        </label>
                    </div>
                </div>
                <div class="col-lg-6 text-end">
                    <button type="button" class="btn btn-danger btn-sm"> خروج  <i class="fa fa-xmark"> </i> </button> 
                    <button type="button" class="btn btn-success btn-sm"> اجرا &nbsp;<i class="fa fa-save"> </i> </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text" >تاریخ </span>
                                <input type="date" class="form-control" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                             <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text" > الی </span>
                                <input type="date" class="form-control" >
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" > طرف حساب </span>
                        <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                         <select class="form-select form-select-sm" >
                            <option selected>   </option>
                            <option value="1">     </option>
                            <option value="1">   </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > بازاریاب  </span>
                            <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>   </option>
                                <option value="1">     </option>
                                <option value="1">   </option>
                            </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > کالا  </span>
                            <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>   </option>
                                <option value="1">   </option>
                                <option value="1">   </option>
                            </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > گروه بندی </span>
                            <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>   </option>
                                <option value="1">   </option>
                                <option value="1">   </option>
                            </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > سفارش داده شده به   </span>
                            <input type="number" class="form-control" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>   </option>
                                <option value="1">   </option>
                                <option value="1">   </option>
                            </select>
                    </div>
                </div>
            </div> <hr>
            <div class="row">
                 <div class="col-lg-6 ps-3">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                 سفارش های ارسال مستقیم
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                سفارش های غیر مستقیم ارسال 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                سفارش های ارسال از انبار
                            </label>
                        </div>
                    </div>
                    <div class="row" style="border:1px solid gray; border-radius:5px; padding:10px;">
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                سفارش های فاکتور نشده
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                سفارش های فاکتور شده 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" value="" id="flexCheckDefault">
                            <label class="form-check-label ms-4" for="flexCheckDefault">
                                سفارش های باطل شده
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                   <table class="table table-striped table-bordered table-sm" style="background-color:white">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th> شماره سفارش  </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                </tr>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                </tr>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>


<!-- factor cost  Modal -->
<div class="modal fade dragAbleModal" id="factorCostBtn" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="factorCostBtnLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-white py-2" style="background-color:#086e3f">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-6" id="factorCostBtnLabel">  هزینه های فاکتور ها  </h5>
      </div>
      <div class="modal-body">
            <div class="row mb-2">
                <div class="col-lg-12 text-end">
                      <button type="button" class="btn btn-sm btn-success text-start" data-toggle="modal" data-target="#addingResoan"> افزودن <i class="fa fa-plus"></i> </button>
                      <button type="button" class="btn btn-sm btn-success"> ثبت   <i class="fa fa-save"></i> </button>
                      <button type="button" class="btn btn-sm btn-danger"> انصراف <i class="fa fa-xmark"></i> </button>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered table-sm">
                    <thead class="tableHeader">
                        <tr>
                            <th>ردیف</th>
                            <th>هزینه </th>
                            <th> افزوده به فاکتور</th>
                            <th> توضیحات </th>
                        </tr>
                    </thead>
                    <tbody class="tableHeader">
                        <tr>
                            <td>1</td>
                            <td> 23000 </td>
                            <td> 234 </td>
                            <td> توضحیات وجود ندارد </td>
                        </tr>
                    </tbody>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
        <button type="button" class="btn btn-sm btn-success"> ذخیره  <i class="fa fa-save"></i> </button>
      </div>
    </div>
  </div>
</div>



<!-- factor cost  Modal -->
<div class="modal fade dragAbleModal" id="addingResoan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addingResoanLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-white py-2" style="background-color:#052c1a">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-6" id="addingResoanLabel"> بابت ها  </h5>
      </div>
      <div class="modal-body" style="background-color:#72a68e;">
             <div class="row mb-2">
                <div class="col-lg-12 text-end">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
                </div>
             </div> 
            <div class="row">
                 <div class="col-lg-2 p-2">
                      <button type="button" class="btn btn-sm sideButton d-block mb-3 btn-success text-start" data-toggle="modal" data-target="#insertingBabat"> افزودن <i class="fa fa-plus"></i> </button>
                      <button type="button" class="btn btn-sm sideButton d-block mb-3 btn-warning" data-toggle="modal" data-target="#editingResoan">اصلاح<i class="fa fa-edit"></i> </button>
                      <button type="button" class="btn btn-sm sideButton d-block mb-3 btn-danger deletOrderButton"> حذف <i class="fa fa-trash"></i> </button>
                 </div>             
                 <div class="col-lg-10 rounded-3" style="background-color:#fff;">

                 <div class="c-checkout container-fluid" style="background-image: linear-gradient(to right, #ffffff,#72a684,#72a68e); margin:0.2% 0; margin-bottom:0; padding:0.5% !important; border-radius:10px 10px 2px 2px;">
                    <div class="col-sm-12" style="margin: 0; padding:0;">
                        <ul class="header-list nav nav-tabs" data-tabs="tabs" style="margin: 0; padding:0;">
                            <li><a class="active" data-toggle="tab" style="color:black;"  href="#effectiveCostFactor"> هزینه های موثر در فاکتور </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#received"> دریافت  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#payMent"> پرداخت </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#minusFromAccount"> کسر از حساب بانکی </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#addToAccount"> افزوده به حساب بانکی  </a></li>
                        </ul>
                    </div>
                    <div class="c-checkout tab-content" style="background-color:#f5f5f5; margin:0;  padding:0.3%; border-radius:10px 10px 2px 2px;">
                        <div class="row c-checkout rounded-3 tab-pane active" id="effectiveCostFactor" style="width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                            <div class="col-sm-12">
                                <div class="row " style="width:98%; padding:0 1% 2% 0%">
                                     <table class="table table-bordered table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>بابت/هزینه </th>
                                                <th>کد</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody">
                                            <tr>
                                                <td>1</td>
                                                <td>بابت وجود ندارد </td>
                                                <td>12342</td>
                                            </tr>
                                            </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                        <div class="row c-checkout rounded-3 tab-pane" id="received" style="background-color:#f5f5f5; width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                            <div class="row " style="width:98%; padding:0 1% 2% 0%">
                                <table class="table table-bordered table-sm">
                                    <thead class="tableHeader">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>بابت/هزینه </th>
                                            <th>کد</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <tr>
                                            <td>1</td>
                                            <td>بابت وجود ندارد </td>
                                            <td>12342</td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>
                       </div>
                    <div class="row c-checkout rounded-3 tab-pane" id="payMent" style="background-color:#f5f5f5; width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                        <div class="row " style="width:98%; padding:0 1% 2% 0%">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>بابت/هزینه </th>
                                        <th>کد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>بابت وجود ندارد </td>
                                        <td>12342</td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="row c-checkout rounded-3 tab-pane" id="siteAdmin" style="background-color:#f5f5f5; width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                        <div class="row " style="width:98%; padding:0 1% 2% 0%">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>بابت/هزینه </th>
                                        <th>کد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>بابت وجود ندارد </td>
                                        <td>12342</td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="row c-checkout rounded-3 tab-pane" id="minusFromAccount" style="background-color:#f5f5f5; width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                        <div class="row " style="width:98%; padding:0 1% 2% 0%">
                               <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>بابت/هزینه </th>
                                            <th>کد</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>بابت وجود ندارد </td>
                                            <td>12342</td>
                                        </tr>
                                    </tbody>
                               </table>
                        </div>
                    </div>
                    <div class="row c-checkout rounded-3 tab-pane" id="addToAccount" style="background-color:#f5f5f5; width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                        <div class="row " style="width:98%; padding:0 1% 2% 0%">
                              <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>بابت/هزینه </th>
                                            <th>کد</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>بابت وجود ندارد </td>
                                            <td>12342</td>
                                        </tr>
                                    </tbody>
                               </table>
                        </div>
                    </div>
                </div>
            </div> 
         </div>             
       </div>
      </div>
      <div class="modal-footer">
        <p></p>
      </div>
    </div>
  </div>
</div>



<!-- adding resoan (babat)  Modal -->
<div class="modal fade dragAbleModal" id="insertingBabat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertingBabatLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
         <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-5" id="insertingBabatLabel">افزودن بابت </h5>
      </div>
      <div class="modal-body">
         <div class="input-group input-group-sm mb-3">
             <span class="input-group-text" > کد </span>
             <input type="text" class="form-control" >
        </div>
         <div class="input-group input-group-sm mb-3">
             <span class="input-group-text" > بابت  </span>
             <input type="text" class="form-control" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
        <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
      </div>
    </div>
  </div>
</div> 

<!-- editing resoan (babat)  Modal -->
<div class="modal fade dragAbleModal" id="editingResoan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editingResoanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-5" id="editingResoanLabel"> اصلاح بابت </h5>
      </div>
      <div class="modal-body">
         <div class="input-group input-group-sm mb-3">
             <span class="input-group-text" > کد </span>
             <input type="text" class="form-control" >
        </div>
         <div class="input-group input-group-sm mb-3">
             <span class="input-group-text" > بابت  </span>
             <input type="text" class="form-control" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
        <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
      </div>
    </div>
  </div>
</div>


<!-- paying Factor amount Modal -->
<div class="modal fade dragAbleModal" id="payFactorAmount" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="payFactorAmountLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-5" id="payFactorAmountLabel"> دریافت مبلغ فاکتور </h5>
      </div>
      <div class="modal-body" style="background-color: #72a68e">
                                        
         <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#rasgeriModal"> راس آیتمهای دریافتی  <i class="fa fa-get-pocket"></i></button>
                            <button type="button" class="btn btn-sm btn-success"> گردش حساب   <i class="fa fa-history"> </i></button>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-lg-6">
                            <div class="input-group input-group-sm mb-2 mt-3">
                                <span class="input-group-text" >  تاریخ صدور  </span>
                                <input type="date" class="form-control" >
                            </div>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9">
                             <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" > طرف حساب </span>
                                <input type="number" class="form-control inputWidth" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                                <input type="text" class="form-control" aria-label="Sizing example input" placeholder="مهدی محمدی" aria-describedby="inputGroup-sizing-sm">
                                <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                             </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9">
                             <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" > بابت   </span>
                                <input type="number" class="form-control inputWidth" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                                    <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example" disabled>
                                        <option selected>  </option>
                                        <option value="1">  </option>
                                        <option value="2"> </option>
                                        <option value="3">  </option>
                                    </select>
                                <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                             </div>
                        </div>
                        
                    </div>
                </div> 

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="row mb-3">
                        <div class="col-lg-12 text-end">
                            <button type="button" class="btn btn-sm btn-danger"> انصراف  <i class="fa fa-xmark"></i></button>
                            <button type="button" class="btn btn-sm btn-success">  ثبت   <i class="fa fa-save"> </i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <table class="table table-striped table-bordered bg-white table-sm">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>شرح </th>
                                    <th>  مبلغ </th>
                                    <th> وضعیت </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                    <td> 34532432 </td>
                                    <td> یبیسب </td>
                                </tr>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                    <td> 34532432 </td>
                                    <td> یبیسب </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>                      
         </div>
                 
         <div class="input-group input-group-sm mb-3">
             <span class="input-group-text" > توضحیات  </span>
             <input type="text" class="form-control" >
             <button  class="btn btn-sm btn-success btn-sm"> فاکتورهای مرتبط  </button>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
               <fieldset class="border rounded">
                 <legend  class="float-none w-auto legendLabel mb-0">  افزودن </legend>
                        <button type="button" class="btn btn-success btn-sm receiveBtn" data-toggle="modal" data-target="#naqdCashModal"> وجه نقد  <i class="fa fa-usd"></i> </button>
                        <button type="button" class="btn btn-success btn-sm receiveBtn" data-toggle="modal" data-target="#checkModal"> چک  <i class="fa fa-credit-card"></i> </button>
                        <button type="button" class="btn btn-success btn-sm receiveBtn" data-toggle="modal" data-target="#havalaModal"> حواله  <i class="fa fa-cc-diners-club"></i> </button>
                        <button type="button" class="btn btn-success btn-sm receiveBtn" data-toggle="modal" data-target="#dispensedCheckList">  چک خرچ شده <i class="fa fa-cc-visa"></i> </button>
                        <button type="button" class="btn btn-success btn-sm receiveBtn" data-toggle="modal" data-target="#discountModal"> تخفیف <i class="fa fa-usd"></i> </button>
                </fieldset>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <table class="table table-striped table-bordered bg-white table-sm">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th> ردیف چک </th>
                                    <th>شرح </th>
                                    <th>  مبلغ </th>
                                    <th> ردیف در دفتر چک </th>
                                    <th>شماره صیادی </th>
                                    <th> ثبت شده بنام </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                    <td> 34532432 </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                </tr>
                                <tr>
                                    <td> 1 </td>
                                    <td> شرح شرح ینبتینم </td>
                                    <td> 34532432 </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                    <td> یبیسب </td>
                                </tr>
                            </tbody>
                   </table>
            </div>
        </div> <hr>
        <div class="row mt-5">
            <div class="col-lg-2 col-md-2 col-sm-2">
                   <button type="button" class="btn btn-sm receiveBtn btn-danger deletOrderButton"> حذف  <i class="fa fa-trash"></i></button>
                   <button type="button" class="btn btn-sm receiveBtn btn-success">  ثبت   <i class="fa fa-save"> </i></button>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 ">
                <div class="row text-end">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                     <div class="form-check">
                        <label class="form-check-label ms-4 text-white float-end" for="flexCheckDefault">
                            این دریافت بابت چک دریافتی میباشد
                        </label>
                        <input class="form-check-input text-start" type="checkbox" value="" id="flexCheckDefault" style="padding:6px">
                    </div>
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col-lg-2 col-md-2"> </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <span class="ras">راس چک ها : </span>
                        </div>
                        <div class="row">
                          <span class="ras">راس همه آیتم ها : </span>
                        </div>
                  </div>
                  <div class="col-lg-6 col-md-6"> 
                        <span class="ammount border rounded-3 p-2 text-white">
                            مبلغ فاکتور: 85349857  &nbsp; &nbsp; &nbsp; مانده : 398479
                        </span>  &nbsp; 
                        <span class="ammount border rounded-3 p-2 text-white">
                           مجموع :    452345254325       
                        </span>

                  </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- modal for ras geri  -->
<div class="modal fade dragAbleModal" id="rasgeriModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="rasgeriModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-white py-2" style="background-color:#055226">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title fs-5" id="rasgeriModalLabel">  راس گیری  </h5>
      </div>
      <div class="modal-body rounded-3 shadow" style="background-color:#a2c9b9">
         <div class="row">
            <div class="col-lg-10 col-md-10">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text" >  طرف حساب   </span>
                    <input type="number" class="form-control inputWidth" aria-label="Sizing example input" placeholder="762" aria-describedby="inputGroup-sizing-sm disabled" style="width:20px;">
                            <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example">
                                <option selected>  علی </option>
                                <option value="1"> احمد  </option>
                                <option value="2"> محمود </option>
                            </select>
                        <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 text-end">
                     <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
                 </div>
            </div>
            <div class="row mb-3 text-white">
                <div class="col-lg-4 col-md-4">
                    <button class="btn btn-success btn-sm"> محاسبه راس بدهی شخصی  </button>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 fs-6"> راس بدهی :   0</div>
                        <div class="col-lg-6 col-md-6 fs-6"> روز : </div>          
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 fs-6"> راس بدهی تا تاریخ  :   03/10/1401  </div>          
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1 w-44">
                        <span class="input-group-text" > مبنای تاریخ راس گیری </span>
                        <input type="date" class="form-control" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 p-3">
                    <table class="table table-striped table-bordered bg-white table-sm">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th> تاریخ  </th>
                                <th>  بدهکار </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td> 1 </td>
                                <td> 12/02/1401 </td>
                                <td> 34532432 </td>
                            </tr>
                            <tr>
                                <td> 1 </td>
                                <td> 12/02/1401 </td>
                                <td> 34532432 </td>
                            </tr>
                            <tr>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
       
         <div class="row px-3">
                <div class="col-lg-3 col-md-3">
                    <button type="button" class="btn btn-sm btn-danger"> حذف   <i class="fa fa-trash"> </i></button>
                </div>
                    <div class="col-lg-9 col-md-9 text-black fs-6">
                            <div class="row">
                                <sapn class="text"> جمع کل :</sapn>
                            </div>
                            <div class="row">
                                <sapn class="text"> راس کل :</sapn>
                            </div>
                            <div class="row">
                                <sapn class="text">  جمع تا ردیف جاری  :</sapn>
                            </div>
                    </div>
              </div>
         </div>
      </div>
  </div>
</div>



<!-- reciveing cash  Modal -->
    <div class="modal fade dragAbleModal" id="naqdCashModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="naqdCashModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title fs-5" id="naqdCashModalLabel"> دریافت وجه نقد  </h5>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-lg-8 text-end">
                   <button type="button" class="btn btn-sm  btn-success">  تعیین نرخ روز   <i class="fa fa-check"> </i></button>
                </div>
                <div class="col-lg-4 text-end">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
                        <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" > نوع ارز   </span>
                                <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example" disabled>
                                    <option selected>  </option>
                                    <option value="1">  </option>
                                    <option value="2"> </option>
                                    <option value="3">  </option>
                                </select>
                            <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">مبلغ ارز    </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  نرخ ارز    </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  مبلغ ریال    </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> شرح   </span>
                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">

        </div>
        </div>
    </div>
    </div>


<!-- check  Modal -->
    <div class="modal fade dragAbleModal" id="checkModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title fs-5" id="checkModalLabel"> اطلاعات چک  </h5>
        </div> 
        <div class="modal-body">
            <div class="row mb-1">
                <div class="col-lg-4 text-end"></div>
                <div class="col-lg-8 text-end">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
                    <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
                </div>
            </div> <hr>
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">  شماره چک   </span>
                        <input type="text" class="form-control" >
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">  تاریخ سر رسید   </span>
                        <input type="date" class="form-control" >
                        <span class="mt-1">امروز : 3/10/1401 </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> تاریخ چک برای </span>
                        <input type="text" class="form-control" >
                        <span class="after"> بعد </span>
                    </div>
                </div>
                <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> نام بانک  </span>
                                <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example">
                                    <option selected> ملی  </option>
                                    <option value="1"> ایران زمین </option>
                                    <option value="2"> پاسارگاد </option>
                                </select>
                            <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                        </div>
                 </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> شعبه   </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> مبلغ    </span>
                            <input type="text" class="form-control" >
                            <span class="currency"> ریال </span>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">  نرخ ارز    </span>
                        <input type="text" class="form-control" >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">  مبلغ ریال    </span>
                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-1">
                            <label for="exampleFormControlTextarea1" class="form-label"> </label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" disabled> صفر ریال </textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                      <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> شماره حساب  </span>
                                <select class="form-select form-select-sm d-sm-inline-block" aria-label="form-select-sm example">
                                    <option selected>   </option>
                                  
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  مالک   </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  شماره صیادی   </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  ثبت شده بنام   </span>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <button class="btn btn-success btn-sm"> استفاده از بارکد خوان </button>
                </div>
                <div class="col-lg-8">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> شرح   </span>
                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div> <hr>
                      <fieldset class="border rounded">
                        <legend  class="float-none w-auto legendLabel mb-0"> تکرار اطلاعات چک </legend>
                         <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">  تعداد تکرار </span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>             
                                 </div>             
                             </div>   
                           <div class="row">          
                            <div class="col-lg-6">
                                     <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> فاصله سر رسید </span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="text mt-1"> ماهه / </span>
                                     </div>
                            </div>
                              <div class="col-lg-6">
                                  <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">   </span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="text mt-1"> روز  </span>
                                 </div>
                              </div>
                         </div>
                    </fieldset>
                </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Havalah   Modal -->
 <div class="modal fade dragAbleModal" id="havalaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="havalaModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title fs-5" id="havalaModalLabel"> اطلاعات حواله   </h5>
        </div> 
        <div class="modal-body">
            <div class="row mb-1">
                <div class="col-lg-4 text-end"></div>
                <div class="col-lg-8 text-end">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
                    <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
                </div>
            </div> <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">  شماره حواله   </span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" style="font-size:10px;"> تاریخ حواله قابل اصلاح نمی باشد  </span>
                        <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        <span class="text mt-1" style="font-size:10px;">   توجه: تاریخ حواله باید با تاریخ دریافت برابر باشد  </span>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-12">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">  حساب بانکی    </span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example">
                                        <option selected> ملی  </option>
                                        <option value="1"> ایران زمین </option>
                                        <option value="2"> پاسارگاد </option>
                                    </select>
                                <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                            </div>
                    </div>
                 </div>
             <div class="row">
                 <div class="col-lg-9">
                    <div class="input-group input-group-sm mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> شماره پایانه کارتخوان</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        <span class="after"> بعد </span>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> مبلغ    </span>
                            <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  شرح     </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
            </div>  
        </div>
        <div class="modal-footer">
        </div>
        </div>
     </div>
    </div>


<!-- despensed check list   Modal -->
 <div class="modal fade dragAbleModal" id="dispensedCheckList" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dispensedCheckListLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title fs-5" id="dispensedCheckListLabel"> لیست چک ها ی خرچ شده   </h5>
        </div> 
        <div class="modal-body">
            <div class="row mb-1">
                   <div class="col-lg-4">
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  شماره حواله   </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                  </div>
                  <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  خرج شده در سال    </span>
                            <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example">
                                <option selected> ملی  </option>
                                <option value="1"> ایران زمین </option>
                                <option value="2"> پاسارگاد </option>
                            </select>
                        </div>
                  </div>
                <div class="col-lg-2 text-end">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">  خروج   <i class="fa fa-back"></i></button>
                </div>
            </div>
            <div class="row">
                  <table class="table table-striped table-bordered bg-white table-sm">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th> سررسید   </th>
                                <th>  شماره  </th>
                                <th>  مبلغ  </th>
                                <th>  طرف حساب  </th>
                                <th>  شرح   </th>
                                <th>  شماره صیادی   </th>
                                <th>  ثبت شده بنام   </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td> 1 </td>
                                <td> 12/02/1401 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                            </tr>
                            <tr>
                                <td> 1 </td>
                                <td> 12/02/1401 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                                <td> 34532432 </td>
                            </tr>
                            <tr>
                                <td>  </td>
                                <td>  </td>
                                <td>  </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     <span class="text" style="float:left;">  جمع : 68768976879 &nbsp; &nbsp;  </span>
                     <button class="btn btn-success btn-sm float-start" style="display:flex; justify-content:flex-start"> انتخاب <i class="fa fa-history"> </i> </button>
                </div>
            </div>
        </div>
        </div>
     </div>
    </div>


    <!-- discount  Modal -->
    <div class="modal fade dragAbleModal" id="discountModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title fs-5" id="discountModalLabel"> تخفیف  </h5>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-lg-8 text-end">
                   <button type="button" class="btn btn-sm  btn-success">  تعیین نرخ روز   <i class="fa fa-check"> </i></button>
                </div>
                <div class="col-lg-4 text-end">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> انصراف  <i class="fa fa-xmark"></i></button>
                        <button type="button" class="btn btn-sm btn-success">ثبت  <i class="fa fa-save"> </i></button>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> نوع ارز   </span>
                                <select class="form-select form-select-sm d-sm-inline-block" aria-label=".form-select-sm example" disabled>
                                    <option selected>  </option>
                                    <option value="1">  </option>
                                    <option value="2"> </option>
                                    <option value="3">  </option>
                                </select>
                            <button  class="btn btn-sm btn-success btn-sm"> ... </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">مبلغ ارز    </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  نرخ ارز    </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">  مبلغ ریال    </span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm"> شرح   </span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
        </div>
     </div>
    </div>
</div>
 </div>
<!-- exported factor list modal -->
<div class='modal fade dragAbleModal' id='kalaDescription' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered modal-fullscreen' >
        <div class='modal-content'>
            <div class='modal-header bg-danger py-2'>
                <button type='button' class='close bg-danger' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <h6 class='modal-title text-white' id='exampleModalLongTitle'>لیست فاکتورهای صادر شده </h6>
            </div>
            <div class='modal-body'>
                <div class="row">
                    <p class="text mb-0">
                        لیست فاکتورهای صادر شده 217 از سفارش 44  به تاریخ 26/9/2050 
                    </p> 
                    <span> <b> کد کلا  :</b> 29 </span>
                    <span> <b> نام کلا  :</b> ظرف المینیومی 23 </span>
                    <span> <b> واحد کلا :</b> عدد  </span>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">شماره </th>
                            <th scope="col"> تاریخ </th>
                            <th scope="col"> مقدار فاکتور </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                            <td>  </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>


        <!-- Modal  -->
<div class="modal fade dragAbleModal" id="editOrderItem" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg py-2">
        <div class="modal-content">
            <div class="modal-header text-white py-2" style="background-color:#045630;">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="updatingOrderSalesLabel">ویرایش آیتم سفارش </h5>
            </div>
            <div class="modal-body shadow">
                <form action="{{url('/editOrderItem')}}" method="get" id="editOrderItemForm">
                    @csrf
                    <input type="hidden" name="orderSn" id="editOrderSn">
                    <input type="hidden" name="snHDS" id="editHdsSn">
                    <div class="row">
                        <div class="col-lg-4 rounded-3" style="background-color:#76bda1;">
                                <span class="description"> موجودی انبار : <b id="editEditExistance"> 0 </b></span> <br>
                                <span class="description"> قیمت فروش : <b id="editEditPrice"> 0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="editEditLastSalsePriceToCustomer">0</b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="editEditLastSalePrice">0</b> </span>              
                        </div>
                        <div class="col-lg-8 text-end">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
                            <button type="submit" id="editSaveBtn" class="btn btn-sm btn-success">ذخیره  <i class="fa fa-save"></i></button>                        
                        </div>
                    </div><hr>

                    <div class="row my-4">
                        <div class="col-lg-2">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel"> کد کالا</label>
                            <select class="form-select form-select-sm" id="editOrderKalaCode">
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel"> اسم کالا </label>
                            <select class="form-select form-select-sm" name="productId" id="editOrderKalaName">
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel">مقدار بسته بندی</label>
                            
                            <select class="form-select form-select-sm" name="amount" id="editOrderAmount">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



    <!-- Modal  -->
<div class="modal fade dragAbleModal" id="addOrderItem" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white py-2" style="background-color:#045630;">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="updatingOrderSalesLabel"> افزودن به سفارش </h5>
            </div>
            <div class="modal-body shadow">
                <form action="{{url('/addToOrderItems')}}" method="get" id="addToOrderForm">
                    @csrf
                    <input type="hidden" name="HdsSn" id="HdsSn">
                    <div class="row">
                        <div class="col-lg-4">
                            <input class="form-control form-control-sm" type="text" placeholder="جستجو" id="searchItemForAddOrder">
                        </div>
                        <div class="col-lg-5 rounded-3" style="background-color:#76bda1;">
                          
                                <span class="description"> موجودی انبار : <b id="editExistance">0 </b></span> <br>
                                <span class="description">  قیمت فروش : <b id="editPrice">0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="editLastSalsePriceToCustomer">0</b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="editLastSalePrice">0</b> </span>
                                                      
                        </div>
                        <div class="col-lg-3 text-end ">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
                            <button type="submit" id="addSaveBtn" class="btn btn-sm btn-success">ذخیره  <i class="fa fa-save"></i></button>                        
                        </div>
                    </div><hr>

                    <div class="row my-4">
                        <div class="col-lg-2">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel"> کد کالا</label>
                            <select class="form-select form-select-sm" id="addToOrderKalaCode">
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel"> اسم کالا </label>
                            <select class="form-select form-select-sm" name="goodSn" id="addToOrderKalaName" onchange="checkAddingOrderItemExistance()">
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="staticEmail" class="col-sm-2 col-form-label forLabel">مقدار بسته بندی</label>
                            <select class="form-select form-select-sm" name="amountUnit" id="addToOrderAmount">
                            </select>
                            <span style="color:red;display:none" id="noQualifiedErrorText"> این کالا به این مقدار موجودی ندارد. </span>
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
</div>
    <!-- Modal for new order  -->
<div class="modal fade dragAbleModal" id="addOrderItem1" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white py-2" style="background-color:#045630;">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="updatingOrderSalesLabel"> افزودن به سفارش </h5>
            </div>
            <div class="modal-body shadow">
                    <div class="row">
                        <div class="col-lg-4">
                             <!-- <button type="button" class="btn btn-sm btn-success"> افزودن کالا <i class="fa fa-plus"></i> </button> -->
                             <div class="form-check mt-1">
                                 <label class="form-check-label mx-2" for="flexCheckDefault">
                                     نمایش موجودی انبار، قیمت فروش و قیمت خرید 
                                    </label>
                                <input class="form-check-input float-start p-2 mx-2" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                   <span class="input-group-text" id="searchForAddItemLabel"> نام کالا : </span>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForAddToSefarishByName" autofocus>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForAddToSefarishByCode" autofocus>
                            </div>
                        </div>
                        <div class="col-lg-6 rounded-3" style="background-color:#76bda1;">
                                <span class="description"> موجودی انبار : <b id="AddStockExistance">0 </b></span> <br>
                                <span class="description">  قیمت فروش : <b id="AddSalePrice">0 </b></span> <br>
                                <span class="description">  آخرین قیمت خرید: <b id="AddPrice">0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="AddLastPriceCustomer">0</b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="AddLastPrice">0</b> </span>                      
                        </div>
                        <div class="col-lg-2 text-center ">
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success" id="selectKalaToSefarishBtn"> انتخاب  <i class="fa fa-history"></i> </button> 
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-danger" data-dismiss="modal"> انصراف <i class="fa fa-xmark"></i> </button>
                            <!-- <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success"> همه کالا ها   <i class="fa fa-save"></i></button>                         -->
                        </div>
                    </div><hr>

                    <div class="row my-4">
                    <table class="table table-striped table-bordered" id="kalaForAddToSefarishTble">
                            <thead class="tableHeader">
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col"> کد کالا  </th>
                                    <th scope="col"> نام کالا  </th>
                                    <th scope="col"> واحد کالا </th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" id="kalaForAddToSefarish">
                                
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script> 
	
$('.searchingKalaTd').on("click", (e)=> {
      $('.searchingKalaTd').addClass('trFocus');
    });



    $("#exportedFactors").on("click", ()=>{
        $("#kalaDescription").modal("show");
    })
	
	window.addEventListener('load', 
		  function showModal(){
			@if(count($imediatOrders)>0)
				$("#imediatOrderModal").modal("show");
			@endif
		}, false);


</script>



@endsection