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

th, td{
    white-space: nowrap;
    width:111px;
}


</style>
<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                    <button type="button" class="btn btn-success btn-sm topButton text-warning" onclick="openBargiriModal()">بارگیری فاکتور ها<i class="fa fa-send"></i> </button>
                    <input type="hidden" id="selectedGoodSn"/>
                    @endif
                    <span class="situation">
                        <fieldset class="border rounded">
                            <form action="{{url("/filterFactors")}}" method="get" id="filterBuyFactorsForm">
                                @csrf
                                <input type="hidden" name="factType" value="1"/>
                            <legend  class="float-none w-auto legendLabel mb-0">وضعیت</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <input class="form-check-input float-start d-none" type="checkbox" name="bargiryYes" id="sefNewOrderRadio" checked>
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="tasviyehYes" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio"> تسویه شده </label>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">

                                            <input class="form-check-input float-start d-none" type="checkbox" name="bargiryNo" id="sefNewOrderRadio" checked>
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="tasviyehNo" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio"> تسویه نشده </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">تاریخ </span>
                                    <input type="text" name="factDate1" class="form-control form-control-sm" id="sefFirstDate">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="factDate2" class="form-control form-control-sm" id="sefSecondDate">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">ساعت ثبت  </span>
                                    <input type="time" name="factTime1" class="form-control form-control-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="time" name="factTime2" class="form-control form-control-sm">
                                </div>

                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">شماره فاکتور  </span>
                                    <input type="text" name="factNo1" class="form-control form-control-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="factNo2" class="form-control form-control-sm" >
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  فروشنده </span>
                                    <input  class="form-control form-control-sm" id="customerCode"  placeholder="کد ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  فروشنده </span>
                                    <input type="text" name="customerName" id="customerName" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group d-none input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> فروشنده متفرقه </span>
                                    <input type="text" name="" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group d-none input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  نحوه پرداخت </span>
                                    <select name="" id="" class="form-select">
                                        <option>  </option>
                                        <option> حضوری </option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> تنظیمات کننده </span>
                                    <select name="setterName" id="setterName" class="form-select">
                                        <option>  </option>
                                        @foreach($users as $user)
                                            <option> {{$user->NameUser}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  توضحیات </span>
                                    <input type="text" name="factDesc" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group d-none input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  شرح کالا </span>
                                    <input type="text" name="" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group d-none input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> بازاریاب </span>
                                    <input type="text" name="bazaryabName" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group d-none input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> مشتری </span>
                                    <select name="" id="" class="form-select">
                                        <option></option>
                                        <option>سعیدآباد</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> انبار </span>
                                    <select name="stockName" id="stockName" class="form-select">
                                        <option></option>
                                        @foreach($stocks as $stock)
                                        <option>{{$stock->NameStock}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <button type="submit" class="btn btn-success btn-sm  text-warning mb-2"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                        </form>
                        <div class="row">
                            <div>
                                <button class="btn btn-sm text-warning btn-success mb-2" id="addFactorBtn"  style="width: 100px;"> افزودن <i class="fa fa-add"></i></button>
                                <button class="btn btn-sm text-warning btn-info mb-2" disabled onclick="openEditFactorModal(this.value)" id="editFactorButton"  style="width: 100px;"> ویرایش <i class="fa fa-edit"></i> </button>
                                <button class="btn btn-sm text-warning btn-danger mb-2" disabled id="deleteFactorBtn" style="width: 100px;"> حذف <i class="fa fa-delete"></i> </button>
                            </div>
                            <div class="text-end">
                            </div>
                            <div class="text-end">
                            </div>
                        </div>
                        </fieldset>
                    </span>
            </fieldset>
        </div>

        <div class="col-sm-10 col-md-10 col-sm-10 contentDiv">
            <div class="row contentHeader"> 
                <div class="col-lg-12 text-end mt-1 actionButton">
                </div>
            </div>
            <div class="row mainContent">
 
                <table class="resizableTable table table-hover table-bordered table-sm" id="factorTable" style="height:calc(100vh - 400px); overflow-x: scroll; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                            <th id="returnFactorTd-1"> ردیف </th>
                            <th id="returnFactorTd-2"> شماره  </th>
                            <th id="returnFactorTd-3"> تاریخ </th>
                            <th id="returnFactorTd-4"> توضحیات </th>
                            <th id="returnFactorTd-5"> کد مشتری </th>
                            <th id="returnFactorTd-6"> نام مشتری </th>
                            <th id="returnFactorTd-7" > مبلغ فاکتور </th>
                            <th id="returnFactorTd-8"> مبلغ دریافتی </th>
                            <th id="returnFactorTd-9"> تنظیم کننده </th>
                            <th id="returnFactorTd-10" > نحوه پرداخت </th>
                            <th id="returnFactorTd-11"> بازاریاب </th>
                            <th id="returnFactorTd-12"> از انبار  </th>
                            <th id="returnFactorTd-13"> تعداد چاپ </th>
                            <th id="returnFactorTd-14"> پورسانت بازاریاب </th>
                            <th id="returnFactorTd-15"> بارگیری </th>
                            <th id="returnFactorTd-16"> مبلغ تخفیف </th>
                            <th id="returnFactorTd-17"> واحد فروش  </th>
                            <th id="returnFactorTd-18"> تاریخ اعلام به انبار </th>
                            <th id="returnFactorTd-19"> ساعت اعلام به انبار  </th>
                            <th id="returnFactorTd-20"> تاریخ بارگیری  </th>
                            <th id="returnFactorTd-21"> ساعت بارگیری  </th>
                            <th id="returnFactorTd-22"> شماره بار نامه  </th>
                            <th id="returnFactorTd-23"> ساعت ثبت  </th>
                            <th id="returnFactorTd-24"> از سفارش  </th>
                            <th id="returnFactorTd-25"> شماره بارگیری </th>
                            <th id="returnFactorTd-26"> تحویل به راننده </th>
                            <th id="returnFactorTd-27"> نام راننده </th>
                        </tr>
                    </thead>
                    <tbody id="factorBListBody">
                        @foreach($factors as $factor)
                            <tr ondblclick="openFactorViewModal({{$factor->SerialNoHDS}})" class="factorTablRow" @if(($factor->NetPriceHDS!=$factor->payedAmount)and($factor->NetPriceHDS>$factor->payedAmount)) style="background-color:rgb(232, 22, 144)" @endif onclick="getFactorOrders(this,{{$factor->SerialNoHDS}})">
                                <td class="returnFactorTd-1"> {{$loop->iteration}}  <input type="radio" value="{{$factor->SerialNoHDS}}" class="d-none"/></td>
                                <td class="returnFactorTd-2"> {{$factor->FactNo}} </td>
                                <td class="returnFactorTd-3"> {{$factor->FactDate}} </td>
                                <td class="returnFactorTd-4"> {{$factor->FactDesc}} </td>
                                <td class="returnFactorTd-5"> {{$factor->PCode}} </td>
                                <td class="returnFactorTd-6"> {{$factor->Name}} </td>
                                <td class="returnFactorTd-7"> {{number_format($factor->NetPriceHDS)}} </td>
                                <td class="returnFactorTd-8"> {{number_format($factor->payedAmount)}} </td>
                                <td class="returnFactorTd-9"> {{$factor->setterName}} </td>
                                <td class="returnFactorTd-10"> حضوری </td>
                                <td class="returnFactorTd-11">  </td>
                                <td class="returnFactorTd-12"> {{$factor->stockName}} </td>
                                <td class="returnFactorTd-13"> {{$factor->CountPrint}} </td>
                                <td class="returnFactorTd-14"> {{number_format($factor->TotalPricePorsant)}} </td>
                                <td class="returnFactorTd-15"> @if($factor->bargiriNo) شده @else نشده @endif  </td>
                                <td class="returnFactorTd-16"> {{$factor->takhfif}} </td>
                                <td class="returnFactorTd-17"> @if($factor->SnUnitSales>0) {{$factor->SnUnitSales}} @else  @endif </td>
                                <td class="returnFactorTd-18"> {{$factor->DateEelamBeAnbar}} </td>
                                <td class="returnFactorTd-19"> {{$factor->TimeEelamBeAnbar}} </td>
                                <td class="returnFactorTd-20"> {{$factor->DateBargiri}} </td>
                                <td class="returnFactorTd-21"> {{$factor->TimeBargiri}} </td>
                                <td class="returnFactorTd-22"> {{$factor->BarNameNo}} </td>
                                <td class="returnFactorTd-23"> {{$factor->FactTime}} </td>
                                <td class="returnFactorTd-24"> خیر </td>
                                <td class="returnFactorTd-25"> {{$factor->bargiriNo}} </td>
                                <td class="returnFactorTd-26"> {{$factor->driverTahvilDate}} </td>
                                <td class="returnFactorTd-27"> {{$factor->driverName}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
                <table class="resizableTable table table-hover table-bordered table-sm" id="factorDetailsTbl" style="height:188px ! important; overflow-y: scroll;">
                    <thead class="tableHeader">
                        <tr>
                         <th id="factorDetailTh-1"> ردیف </th>
                         <th id="factorDetailTh-2"> کد کالا </th>
                         <th id="factorDetailTh-3"> نام کالا </th>
                         <th id="factorDetailTh-4"> واحد کالا </th>
                         <th id="factorDetailTh-5"> بسته بندی </th>
                         <th id="factorDetailTh-6"> مقدار بسته  </th>
                         <th id="factorDetailTh-7"> مقدار کالا </th>
                         <th id="factorDetailTh-8">  تخفیف %  </th>
                         <th id="factorDetailTh-9"> نرخ </th>
                         <th id="factorDetailTh-10"> نرخ بسته </th>
                         <th id="factorDetailTh-11"> مبلغ  </th>
                         <th id="factorDetailTh-12"> مبلغ تخفیف  </th>
                         <th id="factorDetailTh-13"> شرح کالا </th>
                         <th id="factorDetailTh-14"> وضعیت بارگیری </th>
                         <th id="factorDetailTh-15"> بار میکروبی </th>
                        </tr>
                    </thead>
                    <tbody id="FactorDetailBody">
                    </tbody>
                </table>
            </div>
            <div class="row contentFooter">
                <div class="col-sm-12 mt-2 text-end"> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistoryBuy('YESTERDAY')" value="YESTERDAY"> دیروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistoryBuy('TODAY')" value="TODAY"> امروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistoryBuy('TOMORROW')" value="TOMORROW"> فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistoryBuy('AFTERTOMORROW')" value="AFTERTOMORROW"> پس فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistoryBuy('HUNDRED')" value="HUNDRED"> صد تای آخر </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editFactorModal" tabindex="1" data-backdrop="static">
    <input type="hidden" id="rowTaker">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-success py-2" >
                <h5 class="modal-title text-white"> اصلاح فاکتور </h5>
            </div>
            <div class="modal-body">
                <form action="{{url("/doEditFactor")}}" method="POST" id="editFactorForm">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > شماره فاکتور </span>
                                    <input type="text"  name="FactNoEdit" id="FactNoEdit" class="form-control form-control-sm">
                                </div>
                                <input type="text"  name="SerialNoHDSEdit" id="SerialNoHDSEdit" class="d-none">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > انبار </span>
                                    <select name="stockEdit" id="stockEdit" class="form-select">
                                        <option></option>
                                        @foreach($stocks as $stock)
                                        <option>{{$stock->NameStock}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> تاریخ </span>
                                    <input type="text" class="form-control" name="FactDateEdit" id="FactDateEdit">
                                    <select name="customerForFactorEdit" id="customerForFactorEdit" style="display: none;">
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> فروشنده </span>
                                    <input type="text" class="form-control" name="pCodeEdit" id="pCodeEdit">
                                    <input type="text" class="form-control" name="NameEdit" id="NameEdit">
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorEdit').value)" class="btn btn-info text-warning">گردش حساب</button>
                                </div>
                                <div class="input-group input-group-sm d-none mb-1 filterItems">
                                    <span class="input-group-text" > بازاریاب </span>
                                    <input type="text" class="form-control" name="bazaryabCodeEdit" id="bazaryabCodeEdit">
                                    <input type="text" class="form-control" name="bazaryabNameEdit" id="bazaryabNameEdit">
                                    <button  type="button" class="btn btn-info text-warning"> ... </button>
                                </div>
                                <div class="input-group input-group-sm mb-1 d-none filterItems">
                                    <span class="input-group-text" > فروشنده متفرقه </span>
                                    <input type="text" class="form-control" name="MotafariqahNameEdit" id="MotafariqahNameEdit">
                                </div>
                                <div  id="mobileNumberDivEdit" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" >  موبایل </span>
                                        <input type="text" id="MotafariqahMobileEdit" class="form-control">
                                    </div>
                                </div>
                                <div  id="motafariqahAddressDivEdit" style="display: none">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > آدرس </span>
                                    <input type="text" name="MotafariqahAddressEdit"  id="MotafariqahAddressEdit" class="form-control">
                                </div>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > توضحیات </span>
                                    <input type="text" class="form-control" name="FactDescEdit" id="FactDescEdit">
                                </div>

                                <div class="input-group input-group-sm d-none mb-1 filterItems">
                                    <span class="input-group-text" > نحوه تحویل </span>
                                    <select name="TahvilTypeEdit" id="TahvilTypeEdit" class="form-select">
                                        <option value="tahvil"> تحویل به مشتری </option>
                                        <option value="ersal"> ارسال به آدرس </option>
                                    </select>
                                </div>

                                <div id="sendTimeDivEdit" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" >  زمان ارسال </span>
                                        <select name="SendTimeEdit" id="SendTimeEdit" class="form-select">
                                            <option > صبح </option>
                                            <option > عصر </option>
                                        </select>
                                    </div>
                                </div>
                                <div  id="factorAddressDivEdit" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" > آدرس </span>
                                        <select name="factorAddressEdit" id="factorAddressEdit" class="form-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <button type="button" class="btn btn-sm btn-success mb-2 text-warning" onclick="openKalaGardish()"> گردش کالا </button>
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorEdit').value)" class="btn btn-sm btn-success mb-2 text-warning"> گردش شخص </button>
                                    {{-- <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح کالا </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح شخص </button> --}}
                                    <button type="button" onclick="openLastTenBuysModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده خرید آخر </button>
                                    <button type="button" onclick="openLastTenSalesModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده فروش آخر </button>
                                    <button type="button" onclick="openNotSentOrdersModal()" class="btn btn-sm btn-success mb-2 text-warning"> سفارشات ارسال نشده </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-end">
                                    <label class="form-label"> کرایه دریافت شد </label>
                                    <input type="checkbox" class="form-check-input" name="ّtakeKerayahEdit" id="ّtakeKerayahEdit">
                                    <button type="submit" class="btn btn-sm btn-success text-warning mb-2"> ثبت </button>
                                    <button type="button" onclick="cancelEditFactor()" class="btn btn-sm btn-danger  mb-2"> انصراف </button>
                                </div>
                                <div>
                                    <div class="col-lg-12 border-2" style="background-color:#e0e0e0;">
                                        <span class="description"> موجودی انبار : <b id="firstEditExistInStock">0</b></span> <br>
                                        <span class="description">  قیمت فروش : <b id="firstEditPrice">0</b></span> <br>
                                        <span class="description"> اخرین قیمت فروش به این مشتری : <b id="firstEditLastPriceCustomer">0</b></span> <br>
                                        <span class="description"> آخرین قیمت فروش :  <b id="firstEditLastPrice">0</b> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none">
                                <input type="text" id="hamlMoneyFEdit" value="0" name="hamlMoneyFEdit">
                                <input type="text" id="hamlDescFEdit" name="hamlDescFEdit">
                                <input type="text" id="nasbMoneyFEdit" value="0"  name="nasbMoneyFEdit">
                                <input type="text" id="nasbDescFEdit"  name="nasbDescFEdit">
                                <input type="text" id="motafariqaMoneyFEdit" value="0"  name="motafariqaMoneyFEdit">
                                <input type="text" id="motafariqaDescFEdit"  name="motafariqaDescFEdit">
                                <input type="text" id="bargiriMoneyFEdit" value="0"  name="bargiriMoneyFEdit">
                                <input type="text" id="bargiriDescFEdit"  name="bargiriDescFEdit">
                                <input type="text" id="tarabariMoneyFEdit" value="0"  name="tarabariMoneyFEdit">
                                <input type="text" id="tarabariDescFEdit"  name="tarabariDescFEdit">
                            </div>
                        </div>
                        <div class="row">
                            <table class="resizableTable table table-striped table-bordered table-sm" id="editFactorTbl">
                                <thead class="tableHeader">
                                    <tr>
                                        <th id="editFactorTh-1"> ردیف </th>
                                        <th id="editFactorTh-2"> کد کالا </th>
                                        <th id="editFactorTh-3"> نام کالا </th>
                                        <th id="editFactorTh-4"> واحد کالا </th>
                                        <th id="editFactorTh-5"> بسته بندی </th>
                                        <th id="editFactorTh-6"> مقدار کل </th>
                                        <th id="editFactorTh-7"> مقدار جز </th>
                                        <th id="editFactorTh-8"> مقدار اولیه </th>
                                        <th id="editFactorTh-9"> مقدار برگشتی </th>
                                        <th id="editFactorTh-10"> مقدار کالا </th>
                                        <th id="editFactorTh-11"> نرخ واحد </th>
                                        <th id="editFactorTh-12"> نرخ بسته </th>
                                        <th id="editFactorTh-13"> مبلغ </th>
                                        <th id="editFactorTh-14"> مبلغ بعد از تخفیف </th>
                                        <th id="editFactorTh-15"> شماره سفارش </th>
                                        <th id="editFactorTh-16"> تاریخ سفارش </th>
                                        <th id="editFactorTh-17"> شرح کالا </th>
                                        <th id="editFactorTh-18"> انبار </th>
                                        <th id="editFactorTh-19"> مالیات بر ارزش افزوده </th>
                                        <th id="editFactorTh-20"> وزن واحد </th>
                                        <th id="editFactorTh-21"> وزن کل </th>
                                        <th id="editFactorTh-22"> In Srvice </th>
                                        <th id="editFactorTh-23"> درصد مالیات </th>
                                    </tr>
                                </thead>
                                <tbody id="factorEditListBody">
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12  col-sm-12"  style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                                        <span class="sumRow mt-4"> آخرین وضعیت مشتری :   <b id="lastCustomerStatusFEdit"></b> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"></div>
                            <div class="col-lg-4 col-md-4" style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <button type="button" class="btn btn-sm btGroup btn-success deletOrderButton" id="deleteFactorItemBtnFEdit"> حذف کالا <i class="fa fa-xmark"></i> </button>
                                        <button type="button" class="btn btn-sm btGroup btn-success mb-3" onclick="showAmelModalFEdit()"> هزینه ها  <i class="fa fa-list"></i> </button> <br>
                                        <span class="sumRow mt-4"> وزن :  </span> <br>
                                        <span class="sumRow">  حجم :  </span><br><br>
                                    </div>
                                    <div class="col-lg-7">
                                        <span class="sumRow border-bottom"> جمع تار دیف جاری :  <b id="allMoneyTillThisRowFEdit"></b></span> <hr>
                                        <span class="sumRow mb-3"> مجموع : <b id="allMoneyTillEndRowFEdit"></b> </span> <br>
                                        <span class="sumRow"> جمع هزینه ها : <b id="allAmelMoneyFEdit">0</b></span><br> <br>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > مبلغ تخفیف </span>
                                            <input type="text" class="form-control" value="0" name="takhfif"  id="newOrderTakhfifInputFEdit" required />
                                        </div> <hr>
                                        <span class="sumRow"> مجموع : <b id="sumAllRowMoneyAfterTakhfifFEdit"></b></span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addFactorModal" tabindex="1" data-backdrop="static">
    <input type="hidden" id="factorRowTaker">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header py-2" style="background-color:#1ca469">
                <h5 class="modal-title text-end text-white"> افزودن فاکتور </h5>
            </div>
            <div class="modal-body">
                <form action="{{url("/addFactor")}}" method="POST" id="addFactorForm">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > انبار </span>
                                    <input type="hidden" name="factType" value="1">
                                    <select name="stockAdd" id="stockAdd" class="form-select">
                                        <option></option>
                                        @foreach($stocks as $stock)
                                        @if($stock->SnStock!=23)
                                            <option value="{{$stock->SnStock}}">{{$stock->NameStock}}</option>
                                        @else
                                            <option value="{{$stock->SnStock}}" selected>{{$stock->NameStock}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > تاریخ </span>
                                    <input type="text" class="form-control" name="FactDateAdd" id="FactDateAdd" required>
                                    <select name="customerForFactorAdd" id="customerForFactorAdd" style="display: none;">
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > فروشنده </span>
                                    <input type="text" class="form-control" name="pCodeAdd" id="pCodeAdd">
                                    <input type="text" class="form-control" name="NameAdd" id="NameAdd">
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorAdd').value)" class="btn btn-info text-warning">گردش حساب</button>
                                </div>
                                <div class="input-group input-group-sm mb-1 d-none filterItems">
                                    <span class="input-group-text" > بازاریاب </span>
                                    <input type="text" class="form-control" name="bazaryabCodeAdd" id="bazaryabCodeAdd">
                                    <input type="text" class="form-control" name="bazaryabNameAdd" id="bazaryabNameAdd">
                                    <button  type="button" class="btn btn-info text-warning"> ... </button>
                                </div>
                                <div class="input-group input-group-sm mb-1 d-none filterItems">
                                    <span class="input-group-text" > خریدار متفرقه </span>
                                    <input type="text" class="form-control" name="MotafariqahNameAdd" id="MotafariqahNameAdd">
                                </div>
                                <div  id="mobileNumberDivAdd" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" >  موبایل </span>
                                        <input type="text" id="MotafariqahMobileAdd" class="form-control">
                                    </div>
                                </div>
                                <div  id="motafariqahfactorAddressDivAdd" style="display: none">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > آدرس </span>
                                    <input type="text" name="MotafariqahAddressAdd"  id="MotafariqahAddressAdd" class="form-control">
                                </div>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > توضحیات </span>
                                    <input type="text" class="form-control" name="ّFactDescAdd" id="ّFactDescAdd">
                                </div>
                                <div class="input-group input-group-sm mb-1 d-none filterItems">
                                    <span class="input-group-text" > نحوه تحویل </span>
                                    <select name="TahvilTypeAdd" id="TahvilTypeAdd" class="form-select">
                                        <option value="tahvil"> تحویل به فروشنده </option>
                                        <option value="ersal"> ارسال به آدرس </option>
                                    </select>
                                </div>
                                <div  id="sendTimeDivAdd" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" >  زمان ارسال </span>
                                        <select name="SendTimeAdd" id="SendTimeAdd" class="form-select">
                                            <option > صبح </option>
                                            <option > عصر </option>
                                        </select>
                                    </div>
                                </div>
                                <div  id="factorAddressDivAdd" style="display: none">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text" > آدرس </span>
                                        <select name="factorAddressAdd" id="factorAddressAdd" class="form-select">
                                        </select>
                                    </div>
                                </div>
                                <div class="d-none">
                                    <input type="text" id="hamlMoneyFAdd" value="0" name="hamlMoneyFAdd">
                                    <input type="text" id="hamlDescFAdd" value="" name="hamlDescFAdd">
                                    <input type="text" id="nasbMoneyFAdd" value="0"  name="nasbMoneyFAdd">
                                    <input type="text" id="nasbDescFAdd" value=""  name="nasbDescFAdd">
                                    <input type="text" id="motafariqaMoneyFAdd" value="0"  name="motafariqaMoneyFAdd">
                                    <input type="text" id="motafariqaDescFAdd" value=""  name="motafariqaDescFAdd">
                                    <input type="text" id="bargiriMoneyFAdd" value="0"  name="bargiriMoneyFAdd">
                                    <input type="text" id="bargiriDescFAdd" value=""  name="bargiriDescFAdd">
                                    <input type="text" id="tarabariMoneyFAdd" value="0"  name="tarabariMoneyFAdd">
                                    <input type="text" id="tarabariDescFAdd" value=""  name="tarabariDescFAdd">
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <button type="button" class="btn btn-sm btn-success mb-2 text-warning" id="openKalaGardishButton"> گردش کالا </button>
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorAdd').value)" class="btn btn-sm btn-success mb-2 text-warning"> گردش شخص </button>
                                    {{-- <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح کالا </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح شخص </button> --}}
                                    <button type="button" onclick="openLastTenBuysModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده خرید آخر </button>
                                    <button type="button" onclick="openLastTenSalesModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده فروش آخر </button>
                                    <button type="button" onclick="openNotSentOrdersModal()" class="btn btn-sm btn-success mb-2 text-warning"> سفارشات ارسال نشده </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-end">
                                    <label class="form-label"> کرایه دریافت شد </label>
                                    <input type="checkbox" class="form-check-input" name="ّtakeKerayahAdd" id="ّtakeKerayahAdd">
                                    <button type="submit" class="btn btn-sm btn-success text-warning mb-2"> ثبت </button>
                                    <button type="button" onclick="cancelAddFactor()" class="btn btn-sm btn-danger  mb-2"> انصراف </button>
                                </div>
                                <div>
                                    <div class="col-lg-12 border-2" style="background-color:#e0e0e0;">
                                        <span class="description"> موجودی انبار : <b id="AddedToFactorExistInStock">0</b></span> <br>
                                        <span class="description">  قیمت فروش : <b id="AddedToFactorPrice">0</b></span> <br>
                                        <span class="description"> اخرین قیمت فروش به این مشتری : <b id="AddedToFactorLastPriceCustomer">0</b></span> <br>
                                        <span class="description"> آخرین قیمت فروش :  <b id="AddedToFactorLastPrice">0</b> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="resizableTable table table-striped table-bordered table-sm" id="addFactorListTbl">
                                <thead class="tableHeader">
                                    <tr>
                                        <th id="addBargeriFactorTh-1"> ردیف </th>
                                        <th id="addBargeriFactorTh-2"> کد کالا </th>
                                        <th id="addBargeriFactorTh-3"> نام کالا </th>
                                        <th id="addBargeriFactorTh-4"> واحد کالا </th>
                                        <th id="addBargeriFactorTh-5"> بسته بندی </th>
                                        <th id="addBargeriFactorTh-6"> مقدار کل </th>
                                        <th id="addBargeriFactorTh-7"> مقدار جز </th>
                                        <th id="addBargeriFactorTh-8"> مقدار اولیه </th>
                                        <th id="addBargeriFactorTh-9"> مقدار برگشتی </th>
                                        <th id="addBargeriFactorTh-10"> مقدار کالا </th>
                                        <th id="addBargeriFactorTh-11"> نرخ واحد </th>
                                        <th id="addBargeriFactorTh-12"> نرخ بسته </th>
                                        <th id="addBargeriFactorTh-13"> مبلغ </th>
                                        <th id="addBargeriFactorTh-14"> مبلغ بعد از تخفیف </th>
                                        <th id="addBargeriFactorTh-15"> شماره سفارش </th>
                                        <th id="addBargeriFactorTh-16"> تاریخ سفارش </th>
                                        <th id="addBargeriFactorTh-17"> شرح کالا </th>
                                        <th id="addBargeriFactorTh-18"> انبار </th>
                                        <th id="addBargeriFactorTh-19"> مالیات بر ارزش افزوده </th>
                                        <th id="addBargeriFactorTh-20"> وزن واحد </th>
                                        <th id="addBargeriFactorTh-21"> وزن کل </th>
                                        <th id="addBargeriFactorTh-22"> In Srvice </th>
                                        <th id="addBargeriFactorTh-23"> درصد مالیات </th>
                                    </tr>
                                </thead>
                                <tbody id="factorAddListBody">
                                    <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                                        <td class="addBargeriFactorTh-1"> </td>
                                        <td class="addBargeriFactorTh-2"> <input type="text" value="" class="td-input td-inputCodeAdd"> <input type="radio" style="display:none" value=""/> </td>
                                        <td class="addBargeriFactorTh-3"> <input type="text" value="" class="td-input td-inputCodeNameAdd"> </td>
                                        <td class="addBargeriFactorTh-4"> <input type="text" value="" class="td-input td-inputFirstUnitAdd"> </td>
                                        <td class="addBargeriFactorTh-5"> <input type="text" value="" class="td-input td-inputSecondUnitAdd"> </td>
                                        <td class="addBargeriFactorTh-6"> <input type="text" value="" class="td-input  td-inputSecondUnitAmountAdd"> </td>
                                        <td class="addBargeriFactorTh-7"> <input type="text" value="" class="td-input td-inputJozeAmountAdd"> </td>
                                        <td class="addBargeriFactorTh-8"> <input type="text" value="" class="td-input td-inputFirstAmountAdd"> </td>
                                        <td class="addBargeriFactorTh-9"> <input type="text" value="" class="td-input td-inputReAmountAdd"> </td>
                                        <td class="addBargeriFactorTh-10"> <input type="text" value="" class="td-input  td-AllAmountAdd"> </td>
                                        <td class="addBargeriFactorTh-11"> <input type="text" value="" class="td-input td-inputFirstUnitPriceAdd"> </td>
                                        <td class="addBargeriFactorTh-12"> <input type="text" value="" class="td-input td-inputSecondUnitPriceAdd"> </td>
                                        <td class="addBargeriFactorTh-13"> <input type="text" value="" class="td-input td-inputAllPriceAdd"> </td>
                                        <td class="addBargeriFactorTh-14"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifAdd "> </td>
                                        <td class="addBargeriFactorTh-15"> <input type="text" value="" class="td-input td-inputSefarishNumAdd"> </td>
                                        <td class="addBargeriFactorTh-16"> <input type="text" value="" class="td-input td-inputSefarishDateAdd"> </td>
                                        <td class="addBargeriFactorTh-17"> <input type="text" value="" class="td-input td-inputSefarishDescAdd"> </td>
                                        <td class="addBargeriFactorTh-18"> <input type="text" value="" class="td-input td-inputStockAdd"> </td>
                                        <td class="addBargeriFactorTh-19"> <input type="text" value="" class="td-input td-inputMaliatAdd"> </td>
                                        <td class="addBargeriFactorTh-20"> <input type="text" value="" class="td-input td-inputWeightUnitAdd"> </td>
                                        <td class="addBargeriFactorTh-21"> <input type="text" value="" class="td-input td-inputAllWeightAdd"> </td>
                                        <td class="addBargeriFactorTh-22"> <input type="text" value="" class="td-input  td-inputInserviceAdd"> </td>
                                        <td class="addBargeriFactorTh-23"> <input type="text" value="" class="td-input  td-inputPercentMaliatAdd"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12  col-sm-12"  style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                                        <span class="sumRow mt-4"> آخرین وضعیت مشتری :   <b id="lastCustomerStatusAdd"></b> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"></div>
                            <div class="col-lg-4 col-md-4" style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <button type="button" class="btn btn-sm btGroup btn-success deletOrderButton" id="deleteFactorItemBtnAdd"> حذف کالا <i class="fa fa-xmark"></i> </button>
                                        <button type="button" class="btn btn-sm btGroup btn-success mb-3" onclick="showAmelModalFAdd()"> هزینه ها  <i class="fa fa-list"></i> </button> <br>
                                        <span class="sumRow mt-4"> وزن     :  </span> <br>
                                        <span class="sumRow">  حجم  :  </span><br><br>
                                    </div>
                                    <div class="col-lg-7">
                                        <span class="sumRow border-bottom"> جمع تار دیف جاری :  <b id="allMoneyTillThisRowAdd"></b></span> <hr>
                                        <span class="sumRow mb-3"> مجموع     :  <b id="allMoneyTillEndRowAdd"></b> </span> <br>
                                        <span class="sumRow"> جمع هزینه ها  :  <b id="allAmelMoneyAdd">0</b></span><br> <br>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text" > مبلغ تخفیف </span>
                                            <input type="text" class="form-control" value="0" name="takhfif"  id="newOrderTakhfifInputAdd" required />
                                        </div> <hr>
                                        <span class="sumRow"> مجموع : <b id="sumAllRowMoneyAfterTakhfifAdd"></b></span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class='modal fade dragAbleModal' id='customerForFactorModalEdit' data-backdrop="static" tabindex="-1" >
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
                            <input type="text" class="form-control form-control-sm" id="customerNameForFactorEdit" autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text"> بر اساس شماره تماس جستجو شود.</span>
                            <input type="checkbox" class="form-input" name="searchByPhone" id="searchByPhoneNumberCheckBoxEdit">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button type="button" disabled id="searchCustomerSabtBtnEdit" onclick="chooseCustomerForFactorEdit(this.value)"  class="btn btn-success btn-sm"> انتخاب <i class="fa fa-check"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm ms-3" id="searchCustomerCancelFBtn"> انصراف <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-sm" id="foundCusotmerForFactorTbleEdit">
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
                    <tbody class="tableBody" id="foundCusotmerForFactorBodyEdit">
                    </tbody>
                </table> 
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<div class='modal fade dragAbleModal' id='customerForFactorModal' data-backdrop="static" tabindex="-1" >
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
                            <input type="text" class="form-control form-control-sm" id="customerNameForFactor" autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text"> بر اساس شماره تماس جستجو شود.</span>
                            <input type="checkbox" class="form-input" name="searchByPhone" id="searchByPhoneNumberCheckBox">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button type="button" disabled id="addCustomerFactSabtBtn" onclick="chooseCustomerForFactorAdd(this.value)"  class="btn btn-success btn-sm"> انتخاب <i class="fa fa-check"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm ms-3" id="searchCustomerCancelBtn"> انصراف <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-sm" id="foundCusotmerForFactorTble">
                    <thead class="tableHeader">
                        <tr>
                            <th> ردیف </th>
                            <th> کد   </th>
                            <th> نام  </th>
                            <th> شماره تماس  </th>
                            <th> خرید </th>
                            <th> فروش </th>
                            <th> تعداد چک برگشتی </th>
                            <th> مبلغ چک های برگشتی </th>
                        </tr>
                    </thead>
                    <tbody class="tableBody" id="foundCusotmerForFactorBody">
                    </tbody>
                </table> 
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<div class='modal fade dragAbleModal' id='customerForBazaryabFactEdit' data-backdrop="static" tabindex="-1" >
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
                            <input type="text" class="form-control form-control-sm" id="customerNameForBazaryabFactEdit" autocomplete="off" autofocus/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text"> بر اساس شماره تماس جستجو شود.</span>
                            <input type="checkbox" class="form-input" name="searchByPhone" id="seachByPhoneNumberCheckBoxBazaryab">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button type="button" disabled id="searchCustomerForBazaryabFactEditSabtBtn" onclick="chooseBazaryabForFactEdit(this.value)"  class="btn btn-success btn-sm"> انتخاب <i class="fa fa-check"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm ms-3" id="searchCustomerCancelBtnBazaryab"> انصراف <i class="fa fa-trash"></i> </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTbleBazaryab">
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
                    <tbody class="tableBody" id="foundCusotmerForOrderBodyBazarya">
                    </tbody>
                </table> 
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade dragAbleModal" id="searchGoodsModalEditFactor" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white py-2" style="background-color:#045630;">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="updatingOrderSalesLabel"> افزودن به سفارش </h5>
            </div>
            <div class="modal-body shadow">
                    <div class="row">
                        <div class="col-lg-4">
                             <!-- <button type="button" class="btn btn-sm btn-success text-warning"> افزودن کالا <i class="fa fa-plus"></i> </button> -->
                             <div class="form-check mt-1">
                                 <label class="form-check-label mx-2" for="flexCheckDefault">
                                     نمایش موجودی انبار، قیمت فروش و قیمت خرید 
                                    </label>
                                <input class="form-check-input float-start p-2 mx-2" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                   <span class="input-group-text" id="searchForEditItemLabel"> نام کالا : </span>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForEditToFactorByName" autofocus>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForEditToFactorByCode" autofocus>
                            </div>
                        </div>
                        <div class="col-lg-6 rounded-3" style="background-color:#76bda1;">
                                <span class="description"> موجودی انبار : <b id="StockExistanceFactorEdit">0 </b></span> <br>
                                <span class="description">  قیمت فروش : <b id="SalePriceFactorEdit">0 </b></span> <br>
                                <span class="description">  آخرین قیمت خرید: <b id="PriceFactorEdit">0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="LastPriceCustomerFactorEdit">0</b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="LastPriceFactorEdit">0</b> </span>                      
                        </div>
                        <div class="col-lg-2 text-center ">
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success text-warning" id="selectKalaToFactorBtn"> انتخاب  <i class="fa fa-history"></i> </button> 
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-danger" data-dismiss="modal"> انصراف <i class="fa fa-xmark"></i> </button>
                            <!-- <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success text-warning"> همه کالا ها   <i class="fa fa-save"></i></button>                         -->
                        </div>
                    </div><hr>

                    <div class="row my-4">
                    <table class="table table-striped table-bordered" id="kalaForEditToSefarishTble">
                            <thead class="tableHeader">
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col"> کد کالا  </th>
                                    <th scope="col"> نام کالا  </th>
                                    <th scope="col"> واحد کالا </th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" id="kalaForEditToFactorEditBody">
                                
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade dragAbleModal" id="searchGoodsModalAddFactor" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white py-2" style="background-color:#045630;">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="updatingOrderSalesLabel"> افزودن به فاکتور </h5>
            </div>
            <div class="modal-body shadow">
                    <div class="row">
                        <div class="col-lg-4">
                             <!-- <button type="button" class="btn btn-sm btn-success text-warning"> افزودن کالا <i class="fa fa-plus"></i> </button> -->
                             <div class="form-check mt-1">
                                 <label class="form-check-label mx-2" for="flexCheckDefault">
                                     نمایش موجودی انبار، قیمت فروش و قیمت خرید 
                                    </label>
                                <input class="form-check-input float-start p-2 mx-2" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                   <span class="input-group-text" id="searchForAddToFactorItemLabel"> نام کالا : </span>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForAddToFactorByName" autofocus>
                                  <input type="text" class="form-control" autocomplete="off" id="searchKalaForAddToFactorByCode" autofocus>
                            </div>
                        </div>
                        <div class="col-lg-6 rounded-3" style="background-color:#76bda1;">
                                <span class="description"> موجودی انبار : <b id="StockExistanceAddFactor">0 </b></span> <br>
                                <span class="description">  قیمت فروش : <b id="SalePriceAddFactor">0 </b></span> <br>
                                <span class="description">  آخرین قیمت خرید: <b id="PriceAddFactor">0 </b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="LastPriceCustomerAddFactor">0</b> </span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="LastPriceAddFactor">0</b> </span>                      
                        </div>
                        <div class="col-lg-2 text-center ">
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success text-warning" id="selectKalaToAddFactorBtn"> انتخاب  <i class="fa fa-history"></i> </button> 
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-danger" data-dismiss="modal"> انصراف <i class="fa fa-xmark"></i> </button>
                            <!-- <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success text-warning"> همه کالا ها   <i class="fa fa-save"></i></button>                         -->
                        </div>
                    </div><hr>

                    <div class="row my-4">
                    <table class="table table-striped table-bordered" id="kalaForAddToFactorTble">
                            <thead class="tableHeader">
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col"> کد کالا  </th>
                                    <th scope="col"> نام کالا  </th>
                                    <th scope="col"> واحد کالا </th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" id="kalaForAddToFactor">
                                
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="addAmelModalFAdd" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title"> افزودن هزینه به فاکتور </h5>
          </div>
          <div class="modal-body">
              <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTbleFAdd">
                  <thead class="tableHeader">
                      <tr>
                          <th> ردیف </th>
                          <th> هزینه </th>
                          <th> افزوده به فاکتور </th>
                          <th> توضیح </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td> 1 </td>
                          <td> هزینه حمل </td>
                          <td><input type="text" name="hamlMoney" id="hamlMoneyModalFAdd" class="td-input form-control"></td>
                          <td><input type="text" name="hamlDesc" id="hamlDescModalFAdd"  class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 2 </td>
                          <td> هزینه های نصب </td>
                          <td><input type="text"  name="nasbMoney" id="nasbMoneyModalFAdd" class="td-input form-control"></td>
                          <td><input type="text"  name="nasbDesc" id="nasbDescModalFAdd" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 3 </td>
                          <td> هزینه های متفرقه </td>
                          <td><input type="text"  name="motafariqaMoney" id="motafariqaMoneyModalFAdd" class="td-input form-control"></td>
                          <td><input type="text"  name="motafariqaDesc" id="motafariqaDescModalFAdd" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 4 </td>
                          <td> بارگیری </td>
                          <td><input type="text"  name="bargiriMoney" id="bargiriMoneyModalFAdd" class="td-input form-control"></td>
                          <td><input type="text"  name="bargiriDesc" id="bargiriDescModalFAdd" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 5 </td>
                          <td> ترابری </td>
                          <td><input type="text"  name="tarabariMoney" id="tarabariMoneyModalFAdd" class="td-input form-control"></td>
                          <td><input type="text"  name="tarabariDesc" id="tarabariDescModalFAdd" class="td-input form-control"></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" id="cancelAmelButtonFAdd" class="btn btn-danger btn-sm" data-dismiss="modal"> انصراف </button>
              <button type="button" id="sabtAmelButtonFAdd" class="btn btn-success btn-sm" onclick="addAmelToFactorFAdd()"> ذخیره </button>
          </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="addAmelModalFEdit" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title"> افزودن هزینه به فاکتور </h5>
          </div>
          <div class="modal-body">
              <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTbleFEdit">
                  <thead class="tableHeader">
                      <tr>
                          <th> ردیف </th>
                          <th> هزینه </th>
                          <th> افزوده به فاکتور </th>
                          <th> توضیح </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td> 1 </td>
                          <td> هزینه حمل </td>
                          <td><input type="text" name="hamlMoney" id="hamlMoneyModalFEdit" class="td-input form-control"></td>
                          <td><input type="text" name="hamlDesc" id="hamlDescModalFEdit"  class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 2 </td>
                          <td> هزینه های نصب </td>
                          <td><input type="text"  name="nasbMoney" id="nasbMoneyModalFEdit" class="td-input form-control"></td>
                          <td><input type="text"  name="nasbDesc" id="nasbDescModalFEdit" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 3 </td>
                          <td> هزینه های متفرقه </td>
                          <td><input type="text"  name="motafariqaMoney" id="motafariqaMoneyModalFEdit" class="td-input form-control"></td>
                          <td><input type="text"  name="motafariqaDesc" id="motafariqaDescModalFEdit" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 4 </td>
                          <td> بارگیری </td>
                          <td><input type="text"  name="bargiriMoney" id="bargiriMoneyModalFEdit" class="td-input form-control"></td>
                          <td><input type="text"  name="bargiriDesc" id="bargiriDescModalFEdit" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 5 </td>
                          <td> ترابری </td>
                          <td><input type="text"  name="tarabariMoney" id="tarabariMoneyModalFEdit text-warning" class="td-input form-control"></td>
                          <td><input type="text"  name="tarabariDesc" id="tarabariDescModalFEdit text-warning" class="td-input form-control"></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" id="cancelAmelButtonFEdit" class="btn btn-danger btn-sm  text-warning" data-dismiss="modal"> انصراف </button>
              <button type="button" id="sabtAmelButtonFEdit" class="btn btn-success btn-sm  text-warning" onclick="addAmelToFactorFEdit()"> ذخیره </button>
          </div>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" id="factorViewModal">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header py-2">
            <button class="btn btn-sm btn-danger text-warning" onclick="closeFactoViewModal()"> <i class="fa fa-times"></i> </button>
            <h5 class="modal-title"> فاکتور فروش </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > شماره فاکتور </span>
                            <input type="text"  name="FactNoView" id="FactNoView" class="form-control form-control-sm">
                        </div>
                        <input type="text"  name="SerialNoHDSView" id="SerialNoHDSView" class="d-none">
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > انبار </span>
                            <select name="stockView" id="stockView" class="form-select">
                                <option></option>
                                @foreach($stocks as $stock)
                                <option>{{$stock->NameStock}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text"> تاریخ </span>
                            <input type="text" class="form-control" name="FactDateView" id="FactDateView">
                            <select name="customerForFactorView" id="customerForFactorView" style="display: none;">
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text"> خریدار </span>
                            <input type="text" class="form-control" name="pCodeView" id="pCodeView">
                            <input type="text" class="form-control" name="NameView" id="NameView">
                            <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorView').value)" class="btn btn-info text-warning">گردش حساب</button>
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > بازاریاب </span>
                            <input type="text" class="form-control" name="bazaryabCodeView" id="bazaryabCodeView">
                            <input type="text" class="form-control" name="bazaryabNameView" id="bazaryabNameView">
                            <button  type="button" class="btn btn-info text-warning"> ... </button>
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > خریدار متفرقه </span>
                            <input type="text" class="form-control" name="MotafariqahNameView" id="MotafariqahNameView">
                        </div>
                        <div  id="mobileNumberDivView" style="display: none">
                            <div class="input-group input-group-sm mb-1 filterItems">
                                <span class="input-group-text" >  موبایل </span>
                                <input type="text" id="MotafariqahMobileView" class="form-control">
                            </div>
                        </div>
                        <div  id="motafariqahAddressDivView" style="display: none">
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > آدرس </span>
                            <input type="text" name="MotafariqahAddressView"  id="MotafariqahAddressView" class="form-control">
                        </div>
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > توضحیات </span>
                            <input type="text" class="form-control" name="FactDescView" id="FactDescView">
                        </div>
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text" > نحوه تحویل </span>
                            <select name="TahvilTypeView" id="TahvilTypeView" class="form-select">
                                <option value="tahvil"> تحویل به مشتری </option>
                                <option value="ersal"> ارسال به آدرس </option>
                            </select>
                        </div>
                        <div  id="sendTimeDivView" style="display: none">
                            <div class="input-group input-group-sm mb-1 filterItems">
                                <span class="input-group-text" >  زمان ارسال </span>
                                <select name="SendTimeView" id="SendTimeView" class="form-select">
                                    <option > صبح </option>
                                    <option > عصر </option>
                                </select>
                            </div>
                        </div>
                        <div  id="factorAddressDivView" style="display: none">
                            <div class="input-group input-group-sm mb-1 filterItems">
                                <span class="input-group-text" > آدرس </span>
                                <select name="factorAddressView" id="factorAddressView" class="form-select">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div>
                            <button type="button" class="btn btn-sm btn-success mb-2 text-warning" onclick="openKalaGardish()"> گردش کالا </button>
                            <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorView').value)" class="btn btn-sm btn-success mb-2 text-warning"> گردش شخص </button>
                            {{-- <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح کالا </button>
                            <button type="button" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح شخص </button> --}}
                            <button type="button" onclick="openLastTenBuysModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده خرید آخر </button>
                            <button type="button" onclick="openLastTenSalesModal()" class="btn btn-sm btn-success mb-2 text-warning"> ده فروش آخر </button>
                            <button type="button" onclick="openNotSentOrdersModal()" class="btn btn-sm btn-success mb-2 text-warning"> سفارشات ارسال نشده </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div>
                            <div class="col-lg-12 border-2" style="background-color:#e0e0e0;">
                                <span class="description"> موجودی انبار : <b id="firstViewExistInStock">0</b></span> <br>
                                <span class="description">  قیمت فروش : <b id="firstViewPrice">0</b></span> <br>
                                <span class="description"> اخرین قیمت فروش به این مشتری : <b id="firstViewLastPriceCustomer">0</b></span> <br>
                                <span class="description"> آخرین قیمت فروش :  <b id="firstViewLastPrice">0</b> </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-none">
                        <input type="text" id="hamlMoneyFView" value="0" name="hamlMoneyFView">
                        <input type="text" id="hamlDescFView" name="hamlDescFView">
                        <input type="text" id="nasbMoneyFView" value="0"  name="nasbMoneyFView">
                        <input type="text" id="nasbDescFView"  name="nasbDescFView">
                        <input type="text" id="motafariqaMoneyFView" value="0"  name="motafariqaMoneyFView">
                        <input type="text" id="motafariqaDescFView"  name="motafariqaDescFView">
                        <input type="text" id="bargiriMoneyFView" value="0"  name="bargiriMoneyFView">
                        <input type="text" id="bargiriDescFView"  name="bargiriDescFView">
                        <input type="text" id="tarabariMoneyFView" value="0"  name="tarabariMoneyFView">
                        <input type="text" id="tarabariDescFView"  name="tarabariDescFView">
                    </div>
                </div>
                <div class="row">
            <table class="table table-striped table-bordered table-sm factorTable">
                <thead class="bg-success">
                    <tr class="bg-success factorTableHeadTr">
                        <th> ردیف </th>
                        <th> کد کالا </th>
                        <th> نام کالا </th>
                        <th> واحد کالا </th>
                        <th> بسته بندی </th>
                        <th> مقدار کل </th>
                        <th> مقدار جز </th>
                        <th> مقدار اولیه </th>
                        <th> مقدار برگشتی </th>
                        <th> مقدار کالا </th>
                        <th> نرخ واحد </th>
                        <th> نرخ بسته </th>
                        <th> مبلغ </th>
                        <th> مبلغ بعد از تخفیف </th>
                        <th> شماره سفارش </th>
                        <th> تاریخ سفارش </th>
                        <th> شرح کالا </th>
                        <th> انبار </th>
                        <th> مالیات بر ارزش افزوده </th>
                        <th> وزن واحد </th>
                        <th> وزن کل </th>
                        <th> In Srvice </th>
                        <th> درصد مالیات </th>
                    </tr>
                </thead>
                <tbody id="factorViewListBody">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="col-lg-12 col-sm-12  col-sm-12"  style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                        <span class="sumRow mt-4"> آخرین وضعیت مشتری :   <b id="lastCustomerStatusFView"></b> </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4"></div>
            <div class="col-lg-4 col-md-4" style="background-color:#e0e0e0; boarder-radius:6px; padding:15px;">
                <div class="row">
                    <div class="col-lg-5">
                        <button type="button" class="btn btn-sm btGroup btn-success mb-3" onclick="showAmelModalFView()"> هزینه ها  <i class="fa fa-list"></i> </button> <br>
                        <span class="sumRow mt-4"> وزن :  </span> <br>
                        <span class="sumRow">  حجم :  </span><br><br>
                    </div>
                    <div class="col-lg-7">
                        <span class="sumRow border-bottom"> جمع تار دیف جاری :  <b id="allMoneyTillThisRowFView"></b></span> <hr>
                        <span class="sumRow mb-3"> مجموع : <b id="allMoneyTillEndRowFView"></b> </span> <br>
                        <span class="sumRow"> جمع هزینه ها : <b id="allAmelMoneyFView">0</b></span><br> <br>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" > مبلغ تخفیف </span>
                            <input type="text" class="form-control" value="0" name="takhfif"  id="newOrderTakhfifInputFView" required />
                        </div> <hr>
                        <span class="sumRow"> مجموع : <b id="sumAllRowMoneyAfterTakhfifFView"></b></span><br>
                    </div>
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

  <div class="modal" tabindex="-1" id="addAmelModalFView" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="sabtAmelButtonFView" class="btn btn-success btn-sm text-warning" onclick="closeAmelView()"> بستن <i class="fa fa-cross"></i></button>
              <h5 class="modal-title"> افزودن هزینه به فاکتور </h5>
          </div>
          <div class="modal-body">
              <table class="table table-striped table-bordered table-sm" id="foundCusotmerForOrderTbleFView">
                  <thead class="tableHeader">
                      <tr>
                          <th> ردیف </th>
                          <th> هزینه </th>
                          <th> افزوده به فاکتور </th>
                          <th> توضیح </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td> 1 </td>
                          <td> هزینه حمل </td>
                          <td><input type="text" name="hamlMoney" id="hamlMoneyModalFView" class="td-input form-control"></td>
                          <td><input type="text" name="hamlDesc" id="hamlDescModalFView"  class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 2 </td>
                          <td> هزینه های نصب </td>
                          <td><input type="text"  name="nasbMoney" id="nasbMoneyModalFView" class="td-input form-control"></td>
                          <td><input type="text"  name="nasbDesc" id="nasbDescModalFView" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 3 </td>
                          <td> هزینه های متفرقه </td>
                          <td><input type="text"  name="motafariqaMoney" id="motafariqaMoneyModalFView" class="td-input form-control"></td>
                          <td><input type="text"  name="motafariqaDesc" id="motafariqaDescModalFView" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 4 </td>
                          <td> بارگیری </td>
                          <td><input type="text"  name="bargiriMoney" id="bargiriMoneyModalFView" class="td-input form-control"></td>
                          <td><input type="text"  name="bargiriDesc" id="bargiriDescModalFView" class="td-input form-control"></td>
                      </tr>
                      <tr>
                          <td> 5 </td>
                          <td> ترابری </td>
                          <td><input type="text"  name="tarabariMoney" id="tarabariMoneyModalFView" class="td-input form-control"></td>
                          <td><input type="text"  name="tarabariDesc" id="tarabariDescModalFView" class="td-input form-control"></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
          </div>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" id="customerGardishModal" data-backdrop="static">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header py-2 bg-success">
                <button class="btn btn-sm btn-danger" id="closeCustomerGardishModalBtn"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title text-white"> گردش مشتری </h5>
            </div>
            <div class="modal-body">
                <div class="text-end"></div>
                <table class="resizableTable table table-striped table-bordered table-sm" id="customerCirculationTbl" style="height:calc(100vh - 222px); overflow-y:scroll;">
                    <thead class="tableHeader">
                        <tr>
                            <th id="customerCircute-1"> تاریخ </th>
                            <th id="customerCircute-2"> شرح عملیات </th>
                            <th id="customerCircute-3"> تسویه با </th>
                            <th id="customerCircute-4"> بستانکار </th>
                            <th id="customerCircute-5"> بدهکار </th>
                            <th id="customerCircute-6"> وضعیت </th>
                            <th id="customerCircute-7"> مانده </th>
                        </tr>
                    </thead>
                    <tbody id="customerGardishListBody"> </tbody>
                </table>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" id="kalaGardishModal" data-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-sm btn-danger " onclick="closeGardishKalaModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title text-white"> گردش کالا </h5>
            </div>
            <div class="modal-body">
                <table class="resizableTable table table-striped table-bordered table-sm factorTable" id="kalaCircuiteTble" style="height:calc(100vh - 222px); overflow-y:scroll; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                            <th id="circuitKala-1"> ردیف </th>
                            <th id="circuitKala-2"> تاریخ </th>
                            <th id="circuitKala-3"> شرح </th>
                            <th id="circuitKala-4"> شماره </th>
                            <th id="circuitKala-5"> صادره </th>
                            <th id="circuitKala-6"> وارده </th>
                            <th id="circuitKala-7"> موجودی </th>
                            <th id="circuitKala-8"> انبار </th>
                            <th id="circuitKala-9"> نام طرف حساب </th>
                            <th id="circuitKala-10"> بسته بندی </th>
                            <th id="circuitKala-11"> نرخ خرید/فروش </th>
                            <th id="circuitKala-12"> کاربر </th>
                            <th id="circuitKala-13"> زمان ثبت </th>
                            <th id="circuitKala-14"> SerialNoBYS </th>
                            <th id="circuitKala-15"> SerialNoHDS </th>
                        </tr>
                    </thead>
                    <tbody id="kalaGardishListBody">
                    </tbody>
                </table>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="lastTenBuysModal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header py-2 bg-success">
            <button class="btn btn-sm btn-danger"  onclick="closeLastTenBuyModal()"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title text-white"> ده خرید آخر </h5>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="resizableTable table table-striped table-bordered table-sm" id="lastTenBoughtTbl" style="height:calc(100vh - 222px); overflow-y:scroll; width: 100%;">
                        <thead class="tableHeader">
                            <tr>
                                <th id="lastBought-1"> ردیف </th>
                                <th id="lastBought-2"> تاریخ </th>
                                <th id="lastBought-3"> شماره فاکتور </th>
                                <th id="lastBought-4"> فروشنده </th>
                                <th id="lastBought-5"> مقدار کالا </th>
                                <th id="lastBought-6"> نرخ (ریال) </th>
                                <th id="lastBought-7"> % </th>
                                <th id="lastBought-8"> توضحیات </th>
                            </tr>
                        </thead>
                        <tbody id="lastTenBuysListBody"> </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<div class="modal" tabindex="-1" id="lastTenSalesModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-2 bg-successs">
                <button class="btn btn-sm btn-danger m-2" onclick="closeLastTenSalesModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title text-white"> ده فروش آخر </h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="resizableTable table table-striped table-bordered table-sm factorTable" id="lastTenSellTbl">
                                <thead class="tableHeader">
                                    <tr>
                                        <th id="lastTenSell-1"> ردیف </th>
                                        <th id="lastTenSell-2"> تاریخ </th>
                                        <th id="lastTenSell-3"> شماره فاکتور </th>
                                        <th id="lastTenSell-4"> مشتری </th>
                                        <th id="lastTenSell-5"> مقدار کالا </th>
                                        <th id="lastTenSell-6"> نرخ (ریال) </th>
                                        <th id="lastTenSell-7"> % </th>
                                        <th id="lastTenSell-8"> توضحیات </th>
                                    </tr>
                                </thead>
                                <tbody id="lastTenSalesListBody"> </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" id="unSentOrdersModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-2 bg-success">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeUnsentOrderModal()"> <i class="fa fa-times"></i> </button>
                <h5 class="modal-title text-white"> سفارش ارسال نشده </h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-sm factorTable">
                                <thead>
                                    <tr class="bg-success factorTableHeadTr">
                                        <th> ردیف </th>
                                        <th> شماره </th>
                                        <th> تاریخ  </th>
                                        <th> کد مشتری </th>
                                        <th>  نام مشتری </th>
                                        <th> کد کالا </th>
                                        <th> نام کالا </th>
                                        <th> واحد کالا </th>
                                        <th> مقدار سفارش </th>
                                    </tr>
                                </thead>
                                <tbody id="unSentOrdersListBody">
                                    <tr class="factorTablRow">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = ()=>{
      makeTableColumnsResizable("factorTable");
    }
</script>
@endsection