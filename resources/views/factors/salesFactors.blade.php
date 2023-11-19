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

.thNowrap th {
  max-width:100%;
  white-space:nowrap;
}

</style>
<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    @if(hasPermission(Session::get("adminId"),"bargiriN") > 1)
                    <button type="button" class="btn btn-success btn-sm text-warning" onclick="openBargiriModal()">بارگیری فاکتور ها<i class="fa fa-send"></i> </button>
                    <input type="hidden" id="selectedGoodSn"/>
                    @endif
                    @if(hasPermission(Session::get("adminId"),"factorN") > -1)
                    <span class="situation">
                        <fieldset class="border rounded">
                            <form action="{{url("/filterFactors")}}" method="get" id="filterFactorsForm">
                                @csrf
                            <legend  class="float-none w-auto legendLabel mb-0">وضعیت</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check px-1">
                                            <input class="form-check-input float-start" type="checkbox" name="bargiryYes" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-4" for="sefNewOrderRadio"> بارگیری  شده </label>
                                        </div>
                                        <div class="form-check px-1">
                                            <input class="form-check-input float-start" type="checkbox" name="tasviyehYes" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-4" for="sefNewOrderRadio"> تسویه شده </label>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check px-1">
                                            <input class="form-check-input float-start" type="checkbox" name="bargiryNo" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-4" for="sefNewOrderRadio">بارگیری نشده</label>
                                        </div> 

                                        <div class="form-check px-1">
                                            <input class="form-check-input float-start" type="checkbox" name="tasviyehNo" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-4" for="sefNewOrderRadio"> تسویه نشده </label>
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
                                    <span class="input-group-text">  خریدار </span>
                                    <input  class="form-control form-control-sm" id="customerCode"  placeholder="کد ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  خریدار </span>
                                    <input type="text" name="customerName" id="customerName" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> خریدار متفرقه </span>
                                    <input type="text" name="" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
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
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  شرح کالا </span>
                                    <input type="text" name="" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> بازاریاب </span>
                                    <input type="text" name="bazaryabName" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
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
                            <div class="text-start">
                                <button type="submit" class="btn btn-success btn-sm topButton text-warning mb-2 w-75"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                            </div>
                        </form>
                        <div class="row">
                            <div> 
                            @if(hasPermission(Session::get("adminId"),"factorN") > 1)
                                <button class="btn btn-sm text-warning btn-success mb-2" id="addFactorBtn"  style="width: 100px;"> افزودن <i class="fa fa-add"></i></button>
                            @endif
                            @if(hasPermission(Session::get("adminId"),"factorN") > 0)
                                <button class="btn btn-sm text-warning btn-info mb-2" disabled onclick="openEditFactorModal(this.value)" id="editFactorButton"  style="width: 100px;"> ویرایش <i class="fa fa-edit"></i> </button>
                            @endif
                            @if(hasPermission(Session::get("adminId"),"factorN") > 1)    
                                <button class="btn btn-sm text-warning btn-danger mb-2" disabled id="deleteFactorBtn" style="width: 100px;"> حذف <i class="fa fa-delete"></i> </button>
                            @endif
                            </div>
                            <div class="text-end">
                            </div>
                            <div class="text-end">
                            </div>
                        </div>
                        </fieldset>
                    </span>
                    @endif
            </fieldset>
        </div>
        <div class="col-sm-10 col-md-10 col-sm-10 contentDiv">
            <div class="row contentHeader"> 
                <div class="col-lg-12 text-end mt-1 actionButton">
                </div>
            </div>
            <div class="row mainContent">
                <table class="resizableTable table table-hover table-bordered table-sm px-0 mb-0 thNowrap" id="factorTable"  style="height:calc(100vh - 400px); overflow-y:scroll; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                            <th style="width:111px;" id="factorTbl-1"> ردیف </th>
                            <th style="width:111px;" id="factorTbl-2"> شماره  </th>
                            <th style="width:111px;" id="factorTbl-3"> تاریخ </th>
                            <th style="width:111px;" id="factorTbl-4"> توضحیات </th>
                            <th style="width:111px;" id="factorTbl-5"> کد مشتری </th>
                            <th style="width:111px;" id="factorTbl-6"> نام مشتری </th>
                            <th style="width:111px;" id="factorTbl-7" > مبلغ فاکتور </th>
                            <th style="width:111px;" id="factorTbl-8"> مبلغ دریافتی </th>
                            <th style="width:111px;" id="factorTbl-9"> تنظیم کننده </th>
                            <th style="width:111px;" id="factorTbl-10" > نحوه پرداخت </th>
                            <th style="width:111px;" id="factorTbl-11"> بازاریاب </th>
                            <th style="width:111px;" id="factorTbl-12"> از انبار  </th>
                            <th style="width:111px;" id="factorTbl-13"> تعداد چاپ </th>
                            <th style="width:111px;" id="factorTbl-14"> پورسانت بازاریاب </th>
                            <th style="width:111px;" id="factorTbl-15"> بارگیری </th>
                            <th style="width:111px;" id="factorTbl-16"> مبلغ تخفیف </th>
                            <th style="width:111px;" id="factorTbl-17"> واحد فروش  </th>
                            <th style="width:111px;" id="factorTbl-18"> تاریخ اعلام به انبار </th>
                            <th style="width:111px;" id="factorTbl-19"> ساعت اعلام به انبار  </th>
                            <th style="width:111px;" id="factorTbl-20"> تاریخ بارگیری  </th>
                            <th style="width:111px;" id="factorTbl-21"> ساعت بارگیری  </th>
                            <th style="width:111px;" id="factorTbl-22"> شماره بار نامه  </th>
                            <th style="width:111px;" id="factorTbl-23"> ساعت ثبت  </th>
                            <th style="width:111px;" id="factorTbl-24"> از سفارش  </th>
                            <th style="width:111px;" id="factorTbl-25"> شماره بارگیری </th>
                            <th style="width:111px;" id="factorTbl-26"> تحویل به راننده </th>
                            <th style="width:111px;" id="factorTbl-27"> نام راننده </th>
                        </tr>
                    </thead>
                    <tbody id="factorListBody">
                        @foreach($factors as $factor)
                            <tr ondblclick="openFactorViewModal({{$factor->SerialNoHDS}})" @if(($factor->NetPriceHDS!=$factor->payedAmount)and($factor->NetPriceHDS>$factor->payedAmount)) style="background-color:rgb(232, 22, 144)" @endif onclick="getFactorOrders(this,{{$factor->SerialNoHDS}})">
                                <td class="factorTbl-1"> {{$loop->iteration}} <input type="radio" value="{{$factor->SerialNoHDS}}" class="d-none"/></td>
                                <td class="factorTbl-2"> {{$factor->FactNo}} </td>
                                <td class="factorTbl-3"> {{$factor->FactDate}} </td>
                                <td class="factorTbl-4"> {{$factor->FactDesc}} </td>
                                <td class="factorTbl-5"> {{$factor->PCode}} </td>
                                <td class="factorTbl-6"> {{$factor->Name}} </td>
                                <td class="factorTbl-7"> {{number_format($factor->NetPriceHDS)}} </td>
                                <td class="factorTbl-8"> {{number_format($factor->payedAmount)}} </td>
                                <td class="factorTbl-9"> {{$factor->setterName}} </td>
                                <td class="factorTbl-10"> حضوری </td>
                                <td class="factorTbl-11">  </td>
                                <td class="factorTbl-12"> {{$factor->stockName}} </td>
                                <td class="factorTbl-13"> {{$factor->CountPrint}} </td>
                                <td class="factorTbl-14"> {{number_format($factor->TotalPricePorsant)}} </td>
                                <td class="factorTbl-15"> @if($factor->bargiriNo) شده @else نشده @endif  </td>
                                <td class="factorTbl-16"> {{$factor->takhfif}} </td>
                                <td class="factorTbl-17"> @if($factor->SnUnitSales>0) {{$factor->SnUnitSales}} @else  @endif </td>
                                <td class="factorTbl-18"> {{$factor->DateEelamBeAnbar}} </td>
                                <td class="factorTbl-19"> {{$factor->TimeEelamBeAnbar}} </td>
                                <td class="factorTbl-20"> {{$factor->DateBargiri}} </td>
                                <td class="factorTbl-21"> {{$factor->TimeBargiri}} </td>
                                <td class="factorTbl-22"> {{$factor->BarNameNo}} </td>
                                <td class="factorTbl-23"> {{$factor->FactTime}} </td>
                                <td class="factorTbl-24"> خیر </td>
                                <td class="factorTbl-25"> {{$factor->bargiriNo}} </td>
                                <td class="factorTbl-26"> {{$factor->driverTahvilDate}} </td>
                                <td class="factorTbl-27"> {{$factor->driverName}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bargeri-total-container">
                    <div class="bargeri-total-item" > تعداد فاکتور : <span id="noOfFactor"> {{count($factors)}} </span> </div>
                    <div class="bargeri-total-item"> مجموع مبلغ :  <span id="totalFactor"> {{number_format($factors[0]->allMoneyHDS)}} </span> </div>
                    <div class="bargeri-total-item">  مبلغ دریافتی :  <span id="factorMoneyRecieved"> {{number_format($factors[0]->allPayed)}} </span> </div>
                    <div class="bargeri-total-item">  مبلغ باقی مانده  : <span id="factorMoneyRemained"> {{number_format($factors[0]->allMoneyHDS - $factors[0]->allPayed)}} </span>  </div>
                </div>
                <table class="resizableTable table table-hover table-bordered table-sm thNowrap" id="factorTableDetails" style="height:200px">
                    <thead class="tableHeader">
                        <tr>
                         <th id="facTbleDetails-1"> ردیف </th>
                         <th id="facTbleDetails-2"> کد کالا </th>
                         <th id="facTbleDetails-3"> نام کالا </th>
                         <th id="facTbleDetails-4"> واحد کالا </th>
                         <th id="facTbleDetails-5"> بسته بندی </th>
                         <th id="facTbleDetails-6"> مقدار بسته  </th>
                         <th id="facTbleDetails-7"> مقدار کالا </th>
                         <th id="facTbleDetails-8">  تخفیف %  </th>
                         <th id="facTbleDetails-9"> نرخ </th>
                         <th id="facTbleDetails-10"> نرخ بسته </th>
                         <th id="facTbleDetails-11"> مبلغ  </th>
                         <th id="facTbleDetails-12"> مبلغ تخفیف  </th>
                         <th id="facTbleDetails-13"> شرح کالا </th>
                         <th id="facTbleDetails-14"> وضعیت بارگیری </th>
                         <th id="facTbleDetails-15"> بار میکروبی </th>
                        </tr>
                    </thead>
                    <tbody id="FactorDetailBody">  </tbody>
                </table>
            </div>
            <div class="row contentFooter">
                <div class="col-sm-12 mt-2 text-center"> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistory('YESTERDAY')" value="YESTERDAY"> دیروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistory('TODAY')" value="TODAY"> امروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistory('TOMORROW')" value="TOMORROW"> فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistory('AFTERTOMORROW')" value="AFTERTOMORROW"> پس فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="factorHistory('HUNDRED')" value="HUNDRED"> صد تای آخر </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" id="bargiriModal">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header py-2" style="background-color:#1a533f">
            <button type="button" class="btn-close btn-danger text-white bg-danger" data-dismiss="modal" aria-label="Close"> </button>
            <h5 class="modal-title text-white"> بارگیری فاکتورها </h5>
        </div>
        <div class="modal-body" id="bargiriModalBody">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 rounded p-1 factorModal-sideBar notPrint" style="background-color:#43bfa3">
                    <fieldset class="border rounded mt-2 sidefieldSet">
                        <legend  class="float-none w-auto legendLabel mb-0">  بار گیری فاکتور ها  </legend>
                        <button class="btn btn-sm btn-success text-warning mb-4"> نمایش کالاهای برگشتی </button>
                        <button onclick="addFactorToBargiri()" class="btn btn-sm btn-success mb-2 text-warning"> افزودن <i class="fa fa-add"></i></button>
                        <button disabled onclick="editFactorsOfBargiri(this.value)" id="editDriverFactorBtn" class="btn btn-sm btn-success mb-2 text-warning"> اصلاح <i class="fa fa-edit"></i></button>
                        <button disabled onclick="deleteFactorsOfBargiri(this.value)" class="btn btn-sm btn-success mb-2 text-warning" id="deletDriverFactorBtn"> حذف <i class="fa fa-trash"></i></button>
                        <button class="btn btn-sm btn-success mb-2 text-warning" id="factorListPrint"> چاپ لیست فاکتورها <i class="fa fa-print"></i></button>
                        <button class="btn btn-sm btn-success mb-2 text-warning" id="kalaListPrint"> چاپ لیست کالاها <i class="fa fa-print"></i></a>
                        <button class="btn btn-sm btn-success mb-2 text-warning" id="printIndividualFactor"> چاپ تکی فاکتورها <i class="fa fa-print"></i></button>
                        <button class="btn btn-sm btn-success mb-2 text-warning" id="factorAndKalaList"> چاپ هرسه مورد بالا <i class="fa fa-print"></i></button>
                  </fieldset>
                </div>

                <div class="col-md-10">
                    <div class="row border p-2 notPrint" id="driversDiv">
                        <table class="resizableTable table table-hover table-bordered table-sm" id="bargiriDriverTable" style="height:190px">
                            <thead class="tableHeader">
                                <tr>
                                    <th id="bargeriTbl-1"> ردیف </th>
                                    <th id="bargeriTbl-2"> شماره </th>
                                    <th id="bargeriTbl-3"> تاریخ </th>
                                    <th id="bargeriTbl-4"> نام راننده </th>
                                    <th id="bargeriTbl-5"> شماره ماشین </th>
                                    <th id="bargeriTbl-6"> توضحیات  </th>
                                </tr>
                            </thead>
                            <tbody id="bargiriDriverListBody">
                                @foreach($todayDrivers as $driver)
                                <tr onclick="getDriverFactors(this,{{$driver->SnMasterBar}})">
                                    <td class="bargeriTbl-1"> {{$loop->iteration}} </td>
                                    <td class="bargeriTbl-2"> {{$driver->NoPaper}} </td>
                                    <td class="bargeriTbl-3"> {{$driver->DatePeaper}} </td>
                                    <td class="bargeriTbl-4"> {{$driver->driverName}} </td>
                                    <td class="bargeriTbl-5"> {{$driver->MashinNo}} </td>
                                    <td class="bargeriTbl-6"> {{$driver->DescPeaper}} <input type="radio" style="display:none" value="{{$driver->SnMasterBar}}"/>  </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row border p-2" id="factorsDiv" style="height:200px; display:block; overflow:auto">
                        <div class="print-header" id="factorHeader">
                            <div class="header-item"> 
                                <div class="dataaLble"> شماره : <span class="text-bold" id="factorNo"> </span> </div> 
                                <div class="dataLable"> تاریخ :  <span class="text-bold" id="factorDate"> </span> </div>
                                <div class="dataLable"> راننده  :  <span class="text-bold" id="factorDriver"> </span>   </div>
                                <div class="dataLable"> شماره ماشین :  <span class="text-bold" id="machinePalet"> </span>  </div>
                            </div>

                            <div class="header-item">
                                 <h5> لیست فاکتور های استار فود </h5>
                                 <div class="dataLable"> توضحیات :  <span id="description"> </span>  </div>
                            </div>

                            <div class="header-item" style="text-align:left;">
                               <div class="dataLable" style="margin-top:22px;"> تاریخ چاپ :  <span class="text-bold" id="printDate"> </span>  </div>
                                <div class="dataLable"> کاربر :  <span class="text-bold" id="userName"> </span>  </div>
                            </div>
                        </div>
                        <table class="resizableTable table table-hover table-bordered table-sm" id="bargeriFactorTable">
                            <thead class="tableHeader">
                                <tr>
                                    <th id="bargeri-details-1"> ردیف </th>
                                    <th id="bargeri-details-2"> شماره فاکتور  </th>
                                    <th class="notPrint"  id="bargeri-details-3"> تاریخ فاکتور </th>
                                    <th class="notPrint" id="bargeri-details-4"> کد مشتری  </th>
                                    <th id="bargeri-details-5"> نام مشتری </th>
                                    <th id="bargeri-details-6"> مبلغ  </th>
                                    <th class="notPrint" id="bargeri-details-7"> توضحیات  </th>
                                    <th class="notPrint" id="bargeri-details-8"> نقد  </th>
                                    <th class="notPrint" id="bargeri-details-9"> کارت </th>
                                    <th class="notPrint" id="bargeri-details-10"> واریز به حساب </th>
                                    <th class="notPrint" id="bargeri-details-11"> تخفیف </th>
                                    <th class="notPrint" id="bargeri-details-12"> تفاوت  </th>
                                    <th id="bargeri-details-13"> آدرس </th>
                                    <th id="bargeri-details-14"> تلفن </th>
                                </tr>
                            </thead>
                            <tbody id="bargiriFactorLisBody"> </tbody>
                            <tfoot id="factorFooter">
                              <tr>
                                 <td style="width:166px !important;"> امضای اقای منصور ذکی </td>
                                 <td> امضاً اقای حمید داو طلب </td>
                                 <td> امضاً راننده </td>
                                 <td> جمع مبلغ فاکتور ها </td>
                                 <td class="KalaFactorTotal">  </td>
                              </tr>
                            </tfoot> 
                        </table>
                        
                    </div> <br>

                    <div class="row border p-2" id="goodsDiv" style="height:200px; display:block; overflow-y:scroll; z-index:999">
                        <div class="print-header">
                            <div class="header-item"> 
                                <div class="dataaLble"> شماره : <span class="text-bold" id="kalaFactorNo"> </span> </div> 
                                <div class="dataLable"> تاریخ :  <span class="text-bold" id="kalaFactorDate"> </span> </div>
                                <div class="dataLable"> راننده  :  <span class="text-bold" id="kalaFactorDriver"> </span>   </div>
                                <div class="dataLable"> شماره ماشین :  <span class="text-bold" id="kalaMachinePalet"> </span>  </div>
                            </div>
                            <div class="header-item">
                                 <h5> لیست کالا های بار گیری </h5>
                                 <div class="dataLable"> توضحیات :  <span id="kalaDescription"> </span>  </div>
                            </div>
                            <div class="header-item" style="text-align:left;">
                            <div class="dataLable" style="margin-top:22px;"> تاریخ چاپ :  <span class="text-bold" id="kalaPrintDate"> </span>  </div>
                            <div class="dataLable"> کاربر :  <span class="text-bold" id="kalaUserName"> </span>  </div>
                            </div>
                        </div>
                            <table class="resizableTable table table-hover table-bordered" id="bargiriKalaLisTable">
                                <thead class="tableHeader">
                                    <tr>
                                        <th id="bargerikalaTh-1"> ردیف </th>
                                        <th id="bargerikalaTh-2"> کد کالا   </th>
                                        <th id="bargerikalaTh-3"> نام کالا  </th>
                                        <th id="bargerikalaTh-4"> مقدار کل  </th>
                                        <th class="notPrint" id="bargerikalaTh-5">   نام واحد کل </th>
                                        <th id="bargerikalaTh-6">  مقدار جزء </th>
                                        <th class="notPrint" id="bargerikalaTh-7"> واحد جزء  </th>
                                        <th id="bargerikalaTh-8"> مقدار کالا  </th>
                                        <th class="notPrint" id="bargerikalaTh-9"> وزن </th>
                                        <th id="bargerikalaTh-10"> تعداد فاکتور </th>
                                    </tr>
                                </thead>
                                <tbody id="bargiriKalaLisBody"> </tbody>
                                <tfoot>
                                    <tr>
                                      <td style="width:166px !important;"> امضای اقای منصور ذکی  </td>
                                      <td> امضاً اقای حمید داو طلب </td>
                                      <td> امضاً راننده </td>
                                      <td> جمع مبلغ فاکتور ها </td>
                                      <td class="KalaFactorTotal">  </td>
                                    </tr>
                                </tfoot> 
                            </table>
                     </div>    
                 </div>
             </div>
           </div>
         </div>
        <div class="modal-footer"> </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="1" id="addFactorToBargiriModal">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header py-2" style="background-color: #15573f">
          <button type="button" class="btn-close btn-danger bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title text-white"> افزودن بارگیری </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form action="{{url("/addFactorsToBargiri")}}" method="get" id="addFactorsBargiriForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                @csrf
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" >  تاریخ برگه </span>
                                    <input type="text" id="bargiriPaperDate" name="DatePaper" class="form-control form-control-sm mb-1" required placeholder="تایخ برگه ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" >  نام راننده </span>
                                    <select name="factorDriver" id="factorDriver" required class="form-select">
                                        <option value=""></option>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div><button type="button" class="btn btn-success btn-sm mb-1 text-warning" onclick="searchFactorForAddToBargiri()">انتخاب فاکتور <i class="fa fa-check"></i> </button></div>
                                {{-- <div><button class="btn btn-sm btn-success text-warning" type="button" id="addModalEditFactorBtn" onclick="openEditFactorModal(this.value)"> اصلاح فاکتور <i class="fa fa-edit"></i></button></div> --}}
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  شماره ماشین </span>
                                    <input type="text" name="MashinNo" class="form-control form-control-sm"  placeholder="شماره ماشین ">
                                </div>
                            </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> توضیحات </span>
                                    <input type="text" name="DescPeaper" class="form-control form-control-sm"  placeholder=" توضیحات ">
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm mb-1 text-warning"> ثبت <i class="fa fa-save"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm mb-1 text-warning" onclick="cancelAddingFactorToBargiri()"> انصراف <i class="fa fa-cancel"></i></button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> حساب بانکی واریز به حساب </span>
                                    <input type="text" name="Bargiri_VarizSnAccBank" class="form-control form-control-sm">
                                    <select name="" id="allVarizBeHisabBanks" class="form-select">
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> حساب بانکی کارت خوان </span>
                                    <input type="text" name="Bargiri_SnAccBank" class="form-control form-control-sm">
                                    <select name="" id="allKartKhanBanks" class="form-select">
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> شماره پایانه </span>
                                    <input type="text" name="Bargiri_NoPayaneh" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="resizableTable table table-striped table-bordered table-sm" id="addBargeriFactorTbl" style="height:calc(100vh - 280px)">
                        <thead class="tableHeader">
                            <tr class="factorTableHeadTr">
                                <th id="addBargerTr-1"> ردیف </th>
                                <th id="addBargerTr-2"> شماره فاکتور </th>
                                <th id="addBargerTr-3"> تاریخ فاکتور </th>
                                <th id="addBargerTr-4"> کد مشتری </th>
                                <th id="addBargerTr-5"> نام مشتری </th>
                                <th id="addBargerTr-6"> مبلغ </th>
                                <th id="addBargerTr-7"> نقد </th>
                                <th id="addBargerTr-8"> کارت خوان </th>
                                <th id="addBargerTr-9"> واریز به حساب </th>
                                <th id="addBargerTr-10"> تخفیف </th>
                                <th id="addBargerTr-11"> تفاوت دریافتی </th>
                                <th id="addBargerTr-12"> توضحیات </th>
                                <th id="addBargerTr-13"> آدرس </th>
                                <th id="addBargerTr-14"> تلفن </th>
                            </tr>
                        </thead>
                        <tbody id="factorsToAddToBargiriBody">
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
</div>

<div class="modal" tabindex="1" id="editFactorsOfBargiriModal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header py-2" style="background-color:#055438">
                <h5 class="modal-title text-white"> اصلاح بارگیری </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{url('doEditBargiriFactors')}}" method="get" id="doEditBargiriFactorsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text">  شماره برگه </span>
                                            <input type="text"  name="NoPaper" id="bargiriPaperNoEdit" class="form-control form-control-sm mb-1"  placeholder="تایخ برگه ">
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text">  تاریخ برگه </span>
                                            <input type="text"  name="DatePaper" id="bargiriPaperDateEdit" class="form-control form-control-sm mb-1"  placeholder="تایخ برگه ">
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <input type="hidden" name="SnMasterBar" id="SnMasterBarEdit">
                                            <span class="input-group-text">  نام راننده </span>
                                            <select  name="factorDriver" id="factorDriverEdit" class="form-select">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text"> شماره ماشین </span>
                                            <input type="text" name="MashinNo" class="form-control form-control-sm" id="mashinNoEdit" placeholder="شماره ماشین ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <button class="btn btn-success btn-sm mb-1 mt-1 text-warning" type="button" onclick="searchFactorForAddToBargiriEdit()">انتخاب فاکتور <i class="fa fa-check"></i> </button>
                                            <button class="btn btn-sm btn-success mb-1 mt-1 text-warning" disabled type="button" id="editModalEditFactorBtn" onclick="openEditFactorModal(this.value)"> اصلاح فاکتور <i class="fa fa-edit"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text"> توضیحات </span>
                                        <input type="text"  name="DescPeaper" class="form-control form-control-sm" id="paperdescEdit"  placeholder=" توضیحات ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        
                                    </div>
                                    <div class="col-6">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="text-end">
                                            <button disabled type="submit" id="bargiriFactorsEditBtn" class="btn btn-success btn-sm mb-1 text-warning"> ثبت <i class="fa fa-save"></i></button>
                                            <button onclick="cancelBargiriFactorEdit()" type="button" class="btn btn-danger btn-sm mb-1 text-warning"> انصراف <i class="fa fa-cancel"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text"> حساب بانکی واریز به حساب </span>
                                            <input type="text"  name="Bargiri_VarizSnAccBank"  class="form-control form-control-sm">
                                            <select name="" id="allVarizBeHisabBanksEdit" class="form-select">
                                            </select>
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text"> حساب بانکی کارت خوان </span>
                                            <input type="text"  name="Bargiri_SnAccBank" class="form-control form-control-sm">
                                            <select name="" id="allKartKhanBanksEdit" class="form-select">
                                            </select>
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text"> شماره پایانه </span>
                                            <input type="text" name="Bargiri_NoPayaneh" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="resizableTable table table-striped table-bordered table-sm factorTable" id="factorEditbargeriTbl">
                                <thead class="bg-success">
                                    <tr class="bg-success factorTableHeadTr">
                                        <th id="editBargeri-1"> ردیف </th>
                                        <th id="editBargeri-2"> شماره فاکتور </th>
                                        <th id="editBargeri-3"> تاریخ فاکتور </th>
                                        <th id="editBargeri-4"> کد مشتری </th>
                                        <th id="editBargeri-5"> نام مشتری </th>
                                        <th id="editBargeri-6"> مبلغ </th>
                                        <th id="editBargeri-7"> نقد </th>
                                        <th id="editBargeri-8"> کارت خوان </th>
                                        <th id="editBargeri-9"> واریز به حساب </th>
                                        <th id="editBargeri-10"> تخفیف </th>
                                        <th id="editBargeri-11"> تفاوت دریافتی </th>
                                        <th id="editBargeri-12"> توضحیات </th>
                                        <th id="editBargeri-13"> آدرس </th>
                                        <th id="editBargeri-14"> تلفن </th>
                                    </tr>
                                </thead>
                                <tbody id="factorsToAddToBargiriBodyEdit">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="1" id="searchFoactorForAddToBargiriModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header py-2 bg-success">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
            <h5 class="modal-title text-white"> جستجوی فاکتور </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                    <span class="form-label"> انتخاب همه فاکتورها </span>
                                    <input type="checkbox" id="selectAllFactorsForBarigiCheckbox" class="form-check-input">
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <button class="btn btn-sm btn-success mb-1 text-warning" onclick="addSelectFactorsToBargiri()"> انتخاب <i class="fa fa-select"></i> </button>
                                    <button class="btn btn-sm btn-danger mb-1 text-warning" onclick="cancelAddingSearchedFactorToBargiri()"> انصراف <i class="fa fa-cancel"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 border p-1">
                        <table class="table table-hover table-bordered table-sm factorBargiriTable" id="factorsMantiqaTable">
                            <thead class="tab">
                                <tr>
                                    <th>شماره</th>
                                    <th>منطقه</th>
                                    <th>تعداد فاکتور</th>
                                </tr>
                            </thead>
                            <tbody id="factorsMantiqasBodyList">
                                <tr class="factorTablRow">  </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-9 border p-1">
                        <table class="resizableTable table table-hover table-bordered table-sm" id="searchbBargerFactorTbl" style="height:calc(100vh - 300px)">
                            <thead class="tableHeader">
                                <tr>
                                  <th id="searchFactor-1"> ردیف </th>
                                  <th id="searchFactor-2"> شماره </th>
                                  <th id="searchFactor-3"> تاریخ </th>
                                  <th id="searchFactor-4"> کد مشتری </th>
                                  <th id="searchFactor-5"> نام مشتری </th>
                                  <th id="searchFactor-6"> مبلغ فاکتور </th>
                                  <th id="searchFactor-7"> آدرس </th>
                                  <th id="searchFactor-8"> تلفن </th>
                                  <th id="searchFactor-9"> lat pers </th>
                                  <th id="searchFactor-10"> lon pers </th>
                                  <th id="searchFactor-11"> نام مسیر </th>
                                </tr>
                            </thead>
                            <tbody id='mantiqasFactorForBargiriBody'>
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
  
  <div class="modal" tabindex="1" id="searchFoactorForAddToBargiriModalEdit" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title"> جستجوی فاکتور </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                        <span class="form-label"> انتخاب همه فاکتورها </span>
                                        <input type="checkbox" id="selectAllFactorsForBarigiCheckboxEdit" class="form-check-input">
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <button class="btn btn-sm btn-success mb-1 text-warning" onclick="addSelectFactorsToBargiriEdit()"> انتخاب <i class="fa fa-select"></i> </button>
                                        <button class="btn btn-sm btn-danger mb-1 text-warning" onclick="cancelAddingSearchedFactorToBargiriEdit()"> انصراف <i class="fa fa-cancel"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table table-hover table-bordered table-sm factorBargiriTable" id="factorsMantiqaTableEdit">
                                <thead>
                                    <tr class="bg-success factorTableHeadTr">
                                        <th>شماره</th>
                                        <th>منطقه</th>
                                        <th>تعداد فاکتور</th>
                                    </tr>
                                </thead>
                                <tbody id="factorsMantiqasBodyListEdit">
                                    <tr class="factorTablRow">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-bordered table-sm factorBargiriTable">
                                <thead >
                                    <tr class="bg-success factorTableHeadTr">
                                        <th> ردیف </th>
                                        <th> شماره </th>
                                        <th> تاریخ </th>
                                        <th> کد مشتری </th>
                                        <th> نام مشتری </th>
                                        <th> مبلغ فاکتور </th>
                                        <th> آدرس </th>
                                        <th> تلفن </th>
                                        <th> lat pers </th>
                                        <th> lon pers </th>
                                        <th> نام مسیر </th>
                                    </tr>
                                </thead>
                                <tbody id='mantiqasFactorForBargiriBodyEdit'>
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
<div class="modal" id="editFactorModal" tabindex="1" data-backdrop="static">
    <input type="hidden" id="rowTaker">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-info" >
                <h5 class="modal-title text-end"> اصلاح فاکتور </h5>
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
                                    <span class="input-group-text"> خریدار </span>
                                    <input type="text" class="form-control" name="pCodeEdit" id="pCodeEdit">
                                    <input type="text" class="form-control" name="NameEdit" id="NameEdit">
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorEdit').value)" class="btn btn-info text-warning">گردش حساب</button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > بازاریاب </span>
                                    <input type="text" class="form-control" name="bazaryabCodeEdit" id="bazaryabCodeEdit">
                                    <input type="text" class="form-control" name="bazaryabNameEdit" id="bazaryabNameEdit">
                                    <button  type="button" class="btn btn-info text-warning"> ... </button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > خریدار متفرقه </span>
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
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > نحوه تحویل </span>
                                    <select name="TahvilTypeEdit" id="TahvilTypeEdit" class="form-select">
                                        <option value="tahvil"> تحویل به مشتری </option>
                                        <option value="ersal"> ارسال به آدرس </option>
                                    </select>
                                </div>
                                <div  id="sendTimeDivEdit" style="display: none">
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
            <div class="modal-header bg-info" >
                <h5 class="modal-title text-end"> افزودن فاکتور </h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/addFactor')}}" method="get" id="addFactorForm">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > انبار </span>
                                    <input type="hidden" name="factType" value="3">
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
                                    <span class="input-group-text" > خریدار </span>
                                    <input type="text" class="form-control" name="pCodeAdd" id="pCodeAdd">
                                    <input type="text" class="form-control" name="NameAdd" id="NameAdd">
                                    <button type="button" onclick="openCustomerGardishModal(document.querySelector('#customerForFactorAdd').value)" class="btn btn-info text-warning">گردش حساب</button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > بازاریاب </span>
                                    <input type="text" class="form-control" name="bazaryabCodeAdd" id="bazaryabCodeAdd">
                                    <input type="text" class="form-control" name="bazaryabNameAdd" id="bazaryabNameAdd">
                                    <button  type="button" class="btn btn-info text-warning"> ... </button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
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
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > نحوه تحویل </span>
                                    <select name="TahvilTypeAdd" id="TahvilTypeAdd" class="form-select">
                                        <option value="tahvil"> تحویل به مشتری </option>
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
                                <button type="button" class="btn btn-sm btn-success mb-2 text-warning" onclick="openKalaGardish()"> گردش کالا </button>
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
                                <tbody id="factorAddListBody">
                                    <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                                        <td class="td-part-input"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeAdd form-control"> <input type="radio" style="display:none" value=""/> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeNameAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputSecondUnitAmountAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputJozeAmountAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstAmountAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputReAmountAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input  td-AllAmountAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitPriceAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitPriceAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifAdd  form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishNumAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishDateAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishDescAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputStockAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputMaliatAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputWeightUnitAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllWeightAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputInserviceAdd form-control"> </td>
                                        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputPercentMaliatAdd form-control"> </td>
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
                          <td><input type="text"  name="tarabariMoney" id="tarabariMoneyModalFEdit" class="td-input form-control"></td>
                          <td><input type="text"  name="tarabariDesc" id="tarabariDescModalFEdit" class="td-input form-control"></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" id="cancelAmelButtonFEdit" class="btn btn-danger btn-sm" data-dismiss="modal"> انصراف </button>
              <button type="button" id="sabtAmelButtonFEdit" class="btn btn-success btn-sm" onclick="addAmelToFactorFEdit()"> ذخیره </button>
          </div>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" id="factorViewModal">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
            <button class="btn btn-sm btn-success text-warning" onclick="closeFactoViewModal()"> <i class="fa fa-times"></i> </button>
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
            <div class="modal-header bg-info">
                <button class="btn btn-sm btn-danger m-2" id="closeCustomerGardishModalBtn"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> گردش مشتری </h5>
            </div>
            <div class="modal-body">
                <div class="text-end"></div>
                <table class="table table-striped table-bordered table-sm factorTable">
                    <thead>
                        <tr  class="bg-success factorTableHeadTr">
                            <th> تاریخ </th>
                            <th> شرح عملیات </th>
                            <th> تسویه با </th>
                            <th> بستانکار </th>
                            <th> بدهکار </th>
                            <th> وضعیت </th>
                            <th> مانده </th>
                        </tr>
                    </thead>
                    <tbody id="customerGardishListBody">
                        <tr>
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
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="kalaGardishModal" data-backdrop="static">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button class="btn btn-sm btn-danger m-2" onclick="closeGardishKalaModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> گردش کالا </h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-sm factorTable">
                    <thead>
                        <tr  class="bg-success factorTableHeadTr">
                            <th> ردیف </th>
                            <th> تاریخ </th>
                            <th> شرح </th>
                            <th> شماره </th>
                            <th> صادره </th>
                            <th> وارده </th>
                            <th> موجودی </th>
                            <th> انبار </th>
                            <th> نام طرف حساب </th>
                            <th> بسته بندی </th>
                            <th> نرخ خرید/فروش </th>
                            <th> کاربر </th>
                            <th> زمان ثبت </th>
                            <th> SerialNoBYS </th>
                            <th> SerialNoHDS </th>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button class="btn btn-sm btn-danger m-2"  onclick="closeLastTenBuyModal()"> <i class="fa fa-times"></i></button>
          <h5 class="modal-title"> ده خرید آخر </h5>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-sm factorTable">
                        <thead>
                            <tr class="bg-success factorTableHeadTr">
                                <th> ردیف </th>
                                <th> تاریخ </th>
                                <th> شماره فاکتور </th>
                                <th> فروشنده </th>
                                <th> مقدار کالا </th>
                                <th> نرخ (ریال) </th>
                                <th> % </th>
                                <th> توضحیات </th>
                            </tr>
                        </thead>
                        <tbody id="lastTenBuysListBody">
                            <tr class="factorTablRow">
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
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<div class="modal" tabindex="-1" id="lastTenSalesModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-sm btn-danger m-2" onclick="closeLastTenSalesModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> ده فروش آخر </h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-sm factorTable">
                                <thead>
                                    <tr class="bg-success factorTableHeadTr">
                                        <th> ردیف </th>
                                        <th> تاریخ </th>
                                        <th> شماره فاکتور </th>
                                        <th> مشتری </th>
                                        <th> مقدار کالا </th>
                                        <th> نرخ (ریال) </th>
                                        <th> % </th>
                                        <th> توضحیات </th>
                                    </tr>
                                </thead>
                                <tbody id="lastTenSalesListBody">
                                    <tr class="factorTablRow">
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
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="unSentOrdersModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeUnsentOrderModal()"> <i class="fa fa-times"></i> </button>
                <h5 class="modal-title"> سفارش ارسال نشده </h5>
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
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function () {
    // چاپ لیست فاکتورها
    $('#factorListPrint').on("click", function () {
        $("#factorsDiv").css({
            "max-height": "none",
            "overflow": "visible"
        });

        $('#factorsDiv').printThis({
            debug: false,
            importCSS: true,
            // loadCSS: "../../assets/css/print.css",
        });

        setTimeout(function() {
        $("#factorsDiv").css({
                "max-height": "",
                "overflow-y": "scroll"
            });
        }, 2000);
    });

    // چاپ لیست کالا ها
    $('#kalaListPrint').on("click", function () {
        $("#goodsDiv").css({
            "max-height": "none",
            "overflow": "visible"
        });

        $('#goodsDiv').printThis({
          debug: false,
          importCSS: true,
        }).css({
            "max-height": "",
            "overflow": ""
        })

        setTimeout(function() {
           $("#factorsDiv").css({
                "max-height": "",
                "overflow-y": "scroll"
            });
        }, 2000);
    });

    // چاپ فاکتور ها و لیست کالا ها
    $('#factorAndKalaList').on("click", function () {
        $("#factorsDiv, #goodsDiv").css({
            "overflow": "visible",
        });

        $('#factorsDiv').printThis({
            importCSS: false,
            debug: false,
            importCSS: true,
        });

        setTimeout(() => {
            $('#goodsDiv').printThis({
                importCSS: false,
                debug: false,
                importCSS: true,
        }, 2000);
      });
    });
    
});

    window.onload = function() {
        makeTableColumnsResizable("factorTable");
    }
</script>

@endsection
