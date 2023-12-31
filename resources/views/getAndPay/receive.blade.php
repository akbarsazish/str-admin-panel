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

.textContent {font-size:13px;}

.input-group>input.someInput {flex: 0 1 100px;}

</style>
<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    @if(hasPermission(Session::get("adminId"),"orderSalesN") > 1)
                    <button type="button" class="btn btn-success btn-sm topButton text-warning" onclick="openBargiriModal()"> تست راس آیتم های دریافتی  </button>
                    <input type="hidden" id="selectedGoodSn"/>
                    @endif
                    <span class="situation">
                        <fieldset class="border rounded">
                            <form action="{{url("/filterGetPays")}}" method="get" id="filterReceivesForm">
                                @csrf
                                <input type="hidden" name="getOrPay" value="1"/>
                            <legend  class="float-none w-auto legendLabel mb-0">وضعیت</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="darAmad" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio"> در آمد </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="daryaft" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio">  دریافت از شخص </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">تاریخ </span>
                                    <input type="text" name="firstDate" class="form-control form-control-sm" id="sefFirstDate">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="secondDate" class="form-control form-control-sm" id="sefSecondDate">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">شماره   </span>
                                    <input type="text" name="firstNum" class="form-control form-control-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="secondNum" class="form-control form-control-sm" >
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  طرف حساب </span>
                                    <input  class="form-control form-control-sm" name="pCode" id="customerCode"  placeholder="کد ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  طرف حساب </span>
                                    <input type="text" name="name" id="customerName" class="form-control form-control-sm"  placeholder="نام ">
                                </div>

                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> تنظیم کننده </span>
                                    <select name="setterSn" id="setterSn" class="form-select">
                                        <option>  </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->SnUser}}"> {{$user->NameUser}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  توضحیات </span>
                                    <input type="text" name="description" class="form-control form-control-sm"  placeholder="نام ">
                                </div>

                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> گروه مشتری </span>
                                    <select name="groupId" id="groupId" class="form-select">
                                        <option></option>
                                        <option>سعیدآباد</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm text-warning mb-2" style="width: 100px;"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                        </form>
                        <div class="row">
                            <div>
                                <button class="btn btn-sm text-warning btn-success mb-2" onclick="openSandoghModalDar()"  style="width: 100px;"> افزودن <i class="fa fa-add"></i></button>
                                <button class="btn btn-sm text-warning btn-info mb-2"  disabled type="button" onclick="openDaryaftEditModal(this.value)" id="editGetAndPayBYSBtn" style="width: 100px;"> ویرایش <i class="fa fa-edit"></i> </button>
                                <button class="btn btn-sm text-warning btn-danger mb-2"  disabled type="button" id="deleteGetAndPayBYSBtn" style="width: 100px;"> حذف <i class="fa fa-delete"></i> </button>
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
                <table class="resizableTable table table-hover table-bordered table-sm" id="receiveTable" style="height:222px; overflow-y:scroll; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                            <th id="receiveTd-1"> ردیف </th>
                            <th id="receiveTd-2"> شماره  </th>
                            <th id="receiveTd-3"> تاریخ </th>
                            <th id="receiveTd-4"> پرداخت کننده </th>
                            <th id="receiveTd-5"> بابت </th>
                            <th id="receiveTd-6" > مبلغ  </th>
                            <th id="receiveTd-7"> زمان ثبت </th>
                            <th id="receiveTd-8"> کاربر  </th>
                            <th id="receiveTd-9" > صندوق </th>
                            <th id="receiveTd-10"> توضحیات </th>
                        </tr>
                    </thead>
                    <tbody id="receiveListBody">
                        @foreach($receives as $receive)
                            <tr onclick="getGetAndPayBYS(this,'receiveListBodyBYS', {{$receive->SerialNoHDS}})"  class="factorTablRow">
                              <td class="receiveTd-1"> {{$loop->iteration}} </td>
                              <td class="receiveTd-2"> {{$receive->DocNoHDS}}  </td>
                              <td class="receiveTd-3"> {{$receive->DocDate}} </td>
                              <td class="receiveTd-4"> {{$receive->Name}}</td>
                              <td class="receiveTd-5"> {{$receive->DocDescHDS}} </td>
                              <td class="receiveTd-6"> {{number_format($receive->NetPriceHDS)}}  </td>
                              <td class="receiveTd-7"> {{$receive->SaveTime}}</td>
                              <td class="receiveTd-8"> {{$receive->userName}}  </td>
                              <td class="receiveTd-9"> {{$receive->cashName}} </td>
                              <td class="receiveTd-10"> {{$receive->DocDescHDS}} </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            
                <table class="resizableTable table table-hover table-bordered table-sm" id="receiveDetialsTable" style="height:calc(100vh - 388px); overflow:auto; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                         <th id="receiveDetailsTd-1" style="width:122px"> ردیف </th>
                         <th id="receiveDetailsTd-2" style="width:122px"> نوع سند </th>
                         <th id="receiveDetailsTd-3" style="width:122px"> ردیف چک </th>
                         <th id="receiveDetailsTd-4" style="width:122px"> شرح </th>
                         <th id="receiveDetailsTd-5" style="width:122px"> مبلغ </th>
                         <th id="receiveDetailsTd-6" style="width:122px"> شماره چک </th>
                         <th id="receiveDetailsTd-7" style="width:122px"> تاریخ چک </th>
                         <th id="receiveDetailsTd-8" style="width:122px">  بانک  </th>
                         <th id="receiveDetailsTd-9" style="width:122px"> شعبه </th>
                         <th id="receiveDetailsTd-10" style="width:122px">  شماره حساب </th>
                         <th id="receiveDetailsTd-11" style="width:122px"> مالک اصلی  </th>
                         <th id="receiveDetailsTd-12" style="width:122px"> شرح آیتم </th>
                         <th id="receiveDetailsTd-13" style="width:122px"> شماره صیادی  </th>
                         <th id="receiveDetailsTd-14" style="width:122px"> ثبت شده به نام  </th>
                        </tr>
                    </thead>
                    <tbody id="receiveListBodyBYS">
                    </tbody>
                </table>
            </div>
            <div class="row contentFooter">
                <div class="col-sm-12 mt-2 text-center"> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="getAndPayHistory('YESTERDAY','receiveListBody','receiveListBodyBYS',1)" value="YESTERDAY"> دیروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="getAndPayHistory('TODAY','receiveListBody','receiveListBodyBYS',1)" value="TODAY"> امروز </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="getAndPayHistory('TOMORROW','receiveListBody','receiveListBodyBYS',1)" value="TOMORROW"> فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="getAndPayHistory('AFTERTOMORROW','receiveListBody','receiveListBodyBYS',1)" value="AFTERTOMORROW"> پس فردا </button> 
                    <button class="sefOrderBtn btn btn-sm btn-success text-warning" onclick="getAndPayHistory('HUNDRED','receiveListBody','receiveListBodyBYS',1)" value="HUNDRED"> صد تای آخر </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addDaryaftModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button onclick="closeReceiveModals('addDaryaftModal')" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i></button> 
                <h5 class="modal-title text-white"> دریافت </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{url('/addDaryaft')}}" method="POST" id="addDaryaftForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-7">  
                                  <button class="btn btn-sm btn-success text-warning font-size-16" type="button" onclick="openRasDaryaftItemModal()"> راس آیتم های دریافتی</button>
                                  <button class="btn btn-sm btn-success text-warning font-size-16" type="button" onclick="openCustomerGardishModal()"> گردش حساب مشتری </button>
                                <div class="row pt-2">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"> تاریخ </span>
                                            <input type="text" name="addDaryaftDate" id="addDaryaftDate" class="form-control form-control-sm" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 border">
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <label class="form-check-label" for=""> شخص </label>
                                                <input name="daryaftType" id="DocTypeCustomerHDSStateDar" type="radio" value="0" class="form-check-input" checked>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-check-label" for=""> درآمد </label>
                                                <input name="daryaftType" id="DocTypeDarAmadHDSStateDar" type="radio" value="1" class="form-check-input">
                                            </div>
                                        </div>       
                                    </div>
                                </div>

                                <div class="input-group input-group-sm pt-2">
                                    <span class="input-group-text"> مشتری </span>
                                    <input type="text" name="pCode" id="customerCodeDaryaft" class="form-control form-control-sm" required>
                                    <input type="text" name="name" id="customerNameDaryaft" class="form-control form-control-sm" required>
                                    <input type="text" name="customerId" id="customerIdDaryaft" class="d-none">
                                    <input type="text" name="sandoghIdDar" id="sandoghIdDar" class="d-none">
                                   
                                </div>

                                <div class="input-group input-group-sm pt-2">
                                    <span class="input-group-text"> بابت </span>
                                    <input type="text" id="inforTypeCodeDar" class="form-control">
                                    <select name="inforTypeDaryaft" id="inforTypeDaryaft" class="form-control form-control-sm">
                                        <option value=""> </option>
                                        @foreach($infors as $infor)
                                            <option value="{{$infor->SnInfor}}"> {{$infor->InforName}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mt-2">
                                  <span class="input-group-text">  توضحیات </span>
                                  <input type="text" name="daryaftHdsDesc" class="form-control form-control-sm" required>
                                  <button class="btn btn-sm btn-success text-warning" type="button" onclick="openRelatedFactorsModal()"> فاکتورهای مرتبط </button>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="row text-end">
                                    <div>
                                        <button class="btn btn-success btn-sm" type="submit"> ذخیره <i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                                <div class="row border border-1 border-secondary mt-2 rounded">
                                    <table class="table table-sm table-bordered table-striped rounded" style="height:122px">
                                        <thead class="bg-success text-warning">
                                            <tr>
                                                <th> شرح </th>
                                                <th> مبلغ </th>
                                                <th> وضعیت </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> </td>
                                                <td> <span id="lastStatusOfPersonMoney"> </span> </td>
                                                <td> <span id="lastStatusOfPerson"> </span> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <fieldset class="border border-sm rounded">
                                    <legend class="float-none w-auto legendLabel mb-0"> افزودن </legend>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning w-100" type="button" onclick="openReceiveModals('addDaryaftVajhNaghdModal')"> وجه نقد <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('daryafAddChequeInfo')"> چک <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openHawalaInfoModal()"> حواله <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('addSpentChequeModal')"> چک خرج شده <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('daryaftAddTakhfifModal')"> تخفیف <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('daryaftAddVarizToOthersHisbModal')"> واریز به حساب دیگری <i class="fa fa-plus"></i> </button>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-10 border border-1 border-secondary px-0 rounded">
                                <table class="resizableTable table table-bordered table-striped" style="height:calc(100vh - 333px); overflow-y:scroll; width: 100%;" id="addHawalaTable">
                                    <thead class="tableHeader">
                                        <tr>
                                            <th id="dayaftAddTd-1">  ردیف  </th>
                                            <th id="dayaftAddTd-2">  دریف چک  </th>
                                            <th id="dayaftAddTd-3">  شرح  </th>
                                            <th id="dayaftAddTd-4">  مبلغ  </th>
                                            <th id="dayaftAddTd-5">  ردیف در دفتر چک  </th>
                                            <th id="dayaftAddTd-6">  شماره صیادی  </th>
                                            <th id="dayaftAddTd-7">  ثبت شده به نام   </th>
                                        </tr>
                                    </thead>
                                    <tbody id="addedDaryaftListBody">
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="m-2">
                                    <button type="button" class="btn-sm btn-info text-warning w-100" disabled id="editDaryaftItemBtn" onclick="editDaryaftItemType(this.value)"> ویرایش <i class="fa fa-edit"></i></button>
                                </div>
                                <div class="m-2">
                                    <button type="button" class="btn-sm btn-danger text-white w-100" disabled id="deleteDaryaftItemBtn" onclick="deleteRow(this.value)"> حذف <i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="border border-1 border-secondary mt-2 rounded">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <span class="input-text"> مبلغ فاکتور:  </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <span class="input-text"> مبلغ مانده: <span id="remaindMoblagh"> </span> </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="border border-1 border-secondary mt-2 rounded">
                                                    <div class="input-group">
                                                        <span class="input-text"> مجموع : <span name="netPriceDar" id="netPriceDar">  </span> </span>
                                                        <input type="text" name="netPriceHDS" id="totalNetPriceHDSDar" class="d-none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end mt-2 px-0">
                                        <label for="label" class="for-label"> این دریافتی بابت چک برگشتی می باشد </label>
                                        <input type="checkbox" name="becauseReturnCheque" class="from-check-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">  </div>
        </div>
    </div>
</div>


<div class="modal" id="daryaftEditModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button onclick="closeReceiveModals('daryaftEditModal')" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i></button> 
                <h5 class="modal-title text-white"> ویرایش دریافت </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{url('/editGetAndPay')}}" method="POST" id="editDaryaftForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 border-1 rounded"> 
                                <button class="btn btn-sm btn-success text-warning font-size-16" type="button" onclick="openRasDaryaftItemModal()"> راس آیتم های دریافتی</button>
                                <button class="btn btn-sm btn-success text-warning font-size-16" type="button" onclick="openCustomerGardishModal()"> گردش حساب مشتری </button>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"> تاریخ </span>
                                            <input type="text" name="addDaryaftDate" id="editDaryaftDate" class="form-control" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 border">
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <label class="form-check-label" for="person"> شخص </label>
                                                <input name="daryaftType" id="DocTypeCustomerHDSStateDarEdit" type="radio" value="0" class="form-check-input" checked>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-check-label" for="income"> درآمد </label>
                                                <input name="daryaftType" id="DocTypeDarAmadHDSStateDarEdit" type="radio" value="1" class="form-check-input">
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group pt-2">
                                        <span class="input-group-text"> مشتری </span>
                                        <input type="text" name="pCode" id="customerCodeDaryaftEdit" class="form-control" required>
                                        <input type="text" name="name" id="customerNameDaryaftEdit" class="form-control" required>
                                        <input type="text" name="customerId" id="customerIdDaryaftEdit">
                                        <input type="text" name="SerialNoHDS" id="SerialNoHDSDaryaftEdit">
                                        <input type="text" name="sandoghIdDar" id="sandoghIdDarEdit">
                                    </div>
                                    <div class="input-group pt-2">
                                        <span class="input-group-text"> بابت </span>
                                        <input type="text" id="inforTypeCodeDarEdit" class="form-control">
                                        <select name="inforTypeDaryaft" id="inforTypeDaryaftEdit" class="form-select">
                                            <option value=""> </option>
                                            @foreach($infors as $infor)
                                                <option value="{{$infor->SnInfor}}"> {{$infor->InforName}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text"> توضحیات </span>
                                        <input type="text" name="daryaftHdsDesc" id="daryaftHdsDescEdit" class="form-control" required>
                                        <button class="btn btn-sm btn-success text-warning" type="button" onclick="openRelatedFactorsModal()"> فاکتورهای مرتبط </button>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-lg-4 border-1 rounded">
                                <button class="btn btn-success btn-sm" type="submit"> ذخیره <i class="fa fa-save"></i></button>
                                <table class="table table-bordered table-striped mt-2" style="height:122px">
                                    <thead class="bg-success text-warning">
                                        <tr>
                                            <th> شرح </th>
                                            <th> مبلغ </th>
                                            <th> وضعیت </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <fieldset class="border border-sm rounded">
                                    <legend class="float-none w-auto legendLabel mb-0"> افزودن </legend>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning w-100" type="button" onclick="openeditAddEditVagheNaghdmodal()"> وجه نقد <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openEditAddDaryafAddChequeInfo()"> چک <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('editAddEditHawalaModal')"> حواله <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openSpentChequeModal()"> چک خرج شده <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('editAddTakhfifModal')"> تخفیف <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn-sm btn btn-success text-warning  w-100" type="button" onclick="openReceiveModals('editAddVarizeBeHesabDegaran')"> واریز به حساب دیگری <i class="fa fa-plus"></i> </button>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-10 border border-1 rounded border-secondary px-0">
                                <table class="resizableTable table table-bordered table-striped" id="addedEditDaryaftable" style="height:333px">
                                    <thead class="tableHeader">
                                        <tr>
                                            <th id="addEditVagheNaqd-1">  ردیف  </th>
                                            <th id="addEditVagheNaqd-2">  دریف چک  </th>
                                            <th id="addEditVagheNaqd-3">  شرح  </th>
                                            <th id="addEditVagheNaqd-4">  مبلغ  </th>
                                            <th id="addEditVagheNaqd-5">  ردیف در دفتر چک  </th>
                                            <th id="addEditVagheNaqd-6">  شماره صیادی  </th>
                                            <th id="addEditVagheNaqd-7">  ثبت شده به نام   </th>
                                        </tr>
                                    </thead>
                                    <tbody id="addedDaryaftListBodyEdit"> </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="m-2">
                                    <button class="btn-sm btn-info text-warning w-100" type="button" onclick="openEditAddedGetAndPay(this.value)" id="editaddedGetAndPayBtn" > ویرایش <i class="fa fa-edit"></i></button>
                                </div>
                                <div class="m-2">
                                    <button class="btn-sm btn-danger text-white w-100" type="button" onclick="deleteEditAddedGetAndPay(this.value)" id="deleteReceiveItemBtn" disabled> حذف <i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row border border-1 rounded border-secondary mt-2">
                                    <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-text"> راس چک ها:   <span id="">  </span></span>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-text"> راس همه آیتم ها:   <span id=""> 1 روز </span></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-text"> فاکتور:   <span id="editAddEditDaryafMoblagh">  </span></span>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-text">  مبلغ مانده:   <span id="editAddAmountRemained">  </span></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-text">  مجموع : <span name="netPriceDar" id="editAddEditDaryafTotal">  </span> </span>
                                                </div>
                                                <input type="text" name="netPriceHDS" id="totalNetPriceHDSDarEdit" class="d-none">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 text-end mt-2">
                                            <label for="" class="form-label"> این دریافتی بابت چک برگشتی می باشد </label>
                                            <input type="checkbox" name="becauseReturnCheque" class="from-check-input">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer"> </div>
        </div>
    </div>
</div>

<div class="modal" id="addDaryaftVajhNaghdModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-2">
            <button class="btn-danger btn-sm btn" onclick="closeDaryaftVajhNaghdModal()"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title"> دریافت وجه  1نقد </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="arzTypeNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="arzMoneyNaghdDar" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="rialNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="descNaghdDar" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نرخ ارز </span>
                        <input type="text" disabled class="form-control">
                    </div>
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" onclick="addNaghdMoneyDar()"> ذخیره  <i class="fa-save fa"></i></button>
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

<!-- modal for edit daryaft vajhe naghd  -->

<div class="modal" id="addDaryaftVajhNaghdEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
            <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('addDaryaftVajhNaghdEditModal')"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title text-warning "> ویرایش دریافت وجه نقد  </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="arzTypeNaghdDarEd" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="arzMoneyNaghdDarEd" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="rialNaghdDarEd" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="descNaghdDarEd" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نرخ ارز </span>
                        <input type="text" disabled class="form-control">
                    </div>
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" onclick="addEditVagheNaghd()"> ذخیره  <i class="fa fa-save "></i> </button>
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


<!-- modal for edit add edit vahe nagh -->
<div class="modal" id="editAddEditVagheNaghdmodal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-2">
            <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('editAddEditVagheNaghdmodal')"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title"> دریافت وجه نقد </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="editAddArzTypeNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="editAddArzMoneyNaghdDar" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="editAddRialNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="editAddDescNaghdDar" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نرخ ارز </span>
                        <input type="text" disabled class="form-control">
                    </div>
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" onclick="EditaddNaghdMoneyDar()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>

                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>
</div>


<div class="modal" id="addDaryaftVajhNaghdEidtModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success text-warning">
            <button class="btn-danger btn-sm btn" onclick=""> <i class="fa fa-times"></i></button>
          <h5 class="modal-title"> دریافت وجه نقد </h5>
          
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="arzTypeNaghdEiditDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="arzMoneyNaghdEditDar" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="rialNaghdEditDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="descNaghdEditDar" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نرخ ارز </span>
                        <input type="text" disabled class="form-control">
                    </div>
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" onclick=""><i class="fa-save fa"></i></button>
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

<div class="modal" id="daryaftVajhNaghdModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning">
                <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('daryaftVajhNaghdModalEdit')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت وجه نقد </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled id="arzTypeNaghdDarEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" id="arzMoneyNaghdDarEdit" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="rialNaghdDarEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="descNaghdDarEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نرخ ارز </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" onclick="addNaghdMoneyDarEdit()"><i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> </div>
        </div>
    </div>
</div>



<div class="modal" id="daryafAddChequeInfo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closeReceiveModals('daryafAddChequeInfo')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title">  اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="chequeNoCheqeDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="checkSarRasidDateDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="bankNameDar" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="moneyChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="addChequeDar()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="daysAfterChequeDateDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="shobeBankChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="moneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="hisabNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="sayyadiNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="sabtBeNameChequeDar" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="malikChequeDar" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="descChequeDar" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="repeateChequeDar" class="form-control">
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="distanceMonthChequeDar" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="distanceDarChequeDar" class="form-control">
                                        <span class="diplay-4"> روز </span>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
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

  <div class="modal" id="editDaryafAddChequeInfo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closeReceiveModals('editDaryafAddChequeInfo')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> ویرایش اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="editChequeNoCheqeDar" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="editCheckSarRasidDateDar" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="editBankNameDar" class="form-select">
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="editMoneyChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="addEditAddChequeDar()"> ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="editDaysAfterChequeDateDar" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="editShobeBankChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="editMoneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="editHisabNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="editSayyadiNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="editSabtBeNameChequeDar" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="editMalikChequeDar" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">  شرح </span>
                                <input type="text" id="editDescChequeDar" class="form-control">
                            </div>
                        </div>

                    </div>
                    <!-- <div class="row">
                        <div class="border border-2 border-secondary p-2 rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="editRepeateChequeDar" class="form-control">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="editDistanceMonthChequeDar" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="editDistanceDarChequeDar" class="form-control">
                                        <span class="diplay-4"> روز </span>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>



  <div class="modal" id="chequeInfoModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
            <button class="btn btn-danger btn-sm text-warning" onclick="closeReceiveModals('chequeInfoModalEdit')"> <i class="fa fa-times"></i></button>
          <h5 class="modal-title"> اطلاعات چک </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> شماره چک </span>
                            <input type="text" id="chequeNoCheqeDarEdit" class="form-control">
                        </div>
                        <div class="input-group  mb-2">
                            <span class="input-group-text"> تاریخ سر رسید </span>
                            <input type="text" id="checkSarRasidDateDarEdit" class="form-control">
                        </div>
                        <div class="input-group  mb-2">
                            <span class="input-group-text">  نام بانک </span>
                            <select name="" id="bankNameDarEdit" class="form-select">
                                @foreach($banks as $bank)
                                    <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group  mb-2">
                            <span class="input-group-text"> مبلغ به ریال </span>
                            <input type="text" id="moneyChequeDarEdit" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-end">
                            <button class="btn-sm btn-success btn" onclick="addChequeDarEdit()" > ذخیره <i class="fa-save fa"></i> </button>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text"> تاریخ چک برای بعد </span>
                            <input type="text" id="daysAfterChequeDateDarEdit" class="form-control">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text"> شعبه </span>
                            <input type="text" id="shobeBankChequeDarEdit" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <span> مبلغ به حروف : <span id="moneyInLettersEdit"></span> </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حساب </span>
                                <input type="text" id="hisabNoChequeDarEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره صیادی </span>
                                <input type="text" id="sayyadiNoChequeDarEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> ثبت شده به نام </span>
                                <input type="text" id="sabtBeNameChequeDarEdit" class="form-control">
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مالک  </span>
                                <input type="text" id="malikChequeDarEdit" class="form-control">
                            </div>
                            <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                شرح
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="border border-2 border-secondary p-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> تعداد تکرار </span>
                                    <input type="text" id="repeateChequeDarEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> فاصله سررسید </span>
                                    <input type="text" id="distanceMonthChequeDarEdit" class="form-control">

                                    <span class="input-group-text"> ماهه </span>
                                    <input type="text" id="distanceDarChequeDarEdit" class="form-control">
                                    <span class="diplay-4"> روز </span>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
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


  <div class="modal" id="daryafAddHawalaInfoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
          <button class="btn btn-sm btn-danger" onclick="closeReceiveModals('daryafAddHawalaInfoModal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title text-white"> اطلاعات حواله </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                     <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره حواله </span>
                        <input type="text" id="hawalaNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-7 px-0">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> حساب بانکی </span>
                        <input type="text" id="bankJustAccNoHawalaDar" class="form-control">
                        <select name="" id="bankAccNoHawalaDar" class="form-select"> </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-sm btn-success text-warning" onclick="addHawalaDar()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره پایانه کارت خوان </span>
                        <input type="text" id="payanehKartKhanNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> مبلغ </span>
                        <input type="text" id="monyAmountHawalaDar" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> تاریخ حواله (تاریخ حواله قابل اصلاح نمی باشد و باید با تاریخ دریافت یکسان باشد.) </span>
                    <input type="text" id="hawalaDateHawalaDar" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> شرح </span>
                    <input type="text" id="discriptionHawalaDar" class="form-control">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


<!-- edit Etelaat hawalahe -->

<div class="modal" id="daryaftHawalaInfoModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
          <button class="btn btn-sm btn-danger" onclick="closeReceiveModals('daryaftHawalaInfoModalEdit')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title text-white"> ویرایش اطلاعات حواله  </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                     <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره حواله </span>
                        <input type="text" id="hawalaNoHawalaDarEd" class="form-control">
                    </div>
                </div>
                <div class="col-lg-7 px-0">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> حساب بانکی </span>
                        <input type="text" id="bankJustAccNoHawalaDarEd" class="form-control">
                        <select name="" id="bankAccNoHawalaDarEd" class="form-select"> </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-sm btn-success text-warning" onclick="addEditHawalaDar()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره پایانه کارت خوان </span>
                        <input type="text" id="payanehKartKhanNoHawalaDarEd" class="form-control">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> مبلغ </span>
                        <input type="text" id="monyAmountHawalaDarEd" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> تاریخ حواله (تاریخ حواله قابل اصلاح نمی باشد و باید با تاریخ دریافت یکسان باشد.) </span>
                    <input type="text" id="hawalaDateHawalaDarEd" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> شرح </span>
                    <input type="text" id="discriptionHawalaDarEd" class="form-control">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>
  </div>


<div class="modal" id="addSpentChequeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('addSpentChequeModal')"><i class="fa-times fa"></i></button>
                <h5 class="modal-title text-white"> اطلاعات چک خرج شده </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> خرج شده در سال </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead class="bg-success">
                                <tr>
                                    <th>  ردیف  </th>
                                    <th>  سررسید  </th>
                                    <th>  شماره  </th>
                                    <th>  مبلغ  </th>
                                    <th>  طرف حساب  </th>
                                    <th>  شرح  </th>
                                    <th>  شماره صیادی  </th>
                                    <th>  خرج شده به نام  </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <button class="btn btn-sm btn-success text-warning"> انتخاب </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class=""> مجموع : </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal" id="spentChequeModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('spentChequeModalEdit')"><i class="fa-times fa"></i></button>
                <h5 class="modal-title"> اطلاعات چک خرج شده </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> خرج شده در سال </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead class="bg-success">
                                <tr>
                                    <th>  ردیف  </th>
                                    <th>  سررسید  </th>
                                    <th>  شماره  </th>
                                    <th>  مبلغ  </th>
                                    <th>  طرف حساب  </th>
                                    <th>  شرح  </th>
                                    <th>  شماره صیادی  </th>
                                    <th>  خرج شده به نام  </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <button class="btn btn-sm btn-success text-warning"> انتخاب </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class=""> مجموع : </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal" id="daryaftAddTakhfifModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('daryaftAddTakhfifModal')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت  تخفیف</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="takhfifMoneyDar" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نرخ ارز </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="text-end m-2">
                                <button disabled class="btn btn-sm btn-success"> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" onclick="addTakhfifDar()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">  </div>
        </div>
    </div>
</div>



<div class="modal" id="takhfifModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('takhfifModalEdit')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> ویرایش دریافت تخفیف  </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="takhfifMoneyDarEdit" value="" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifDarEdit" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نرخ ارز </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="text-end m-2">
                                <button disabled class="btn btn-sm btn-success"> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" onclick="addTakhfifDarEdit()"> ذخیره  <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">  </div>
        </div>
    </div>
</div>

<!-- Varize b hesab degaran -->

<div class="modal" id="daryaftAddVarizToOthersHisbModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('daryaftAddVarizToOthersHisbModal')"><i class="fa-times fa"></i></button>
                <h5 class="modal-title"> واریز به حساب دیگران </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-1">
                        <div class="text-end">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="addVarizToOtherHisab()"> ثبت <i class="fa-save fa"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ (ریال) </span>
                                <input type="text" id="moneyVarizToOtherHisabDar" class="form-control">
                            </div>    
                        </div>    

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره کارت/ شبا/ حساب </span>
                                <input type="text" id="cartNoVarizToOtherDar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span> ریال: <span id="moneyVarizToOtherHisabLetterDar"></span> </span>
                    </div>
                    <div class="row">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> طرف حساب </span>
                            <input type="text" id="varizBehisabDigariCustomerCodeDar" class="form-control">
                            <input type="text" id="varizBehisabDigariCustomerNameDar" class="form-control">
                            <input type="hidden" id="varizBehisabDigariCustomerPSNDar">
                            <button class="btn btn-sm btn-info">...</button>
                            <button class="btn btn-sm btn-success text-warning"> گردش حساب مشتری </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> به نام </span>
                                <input type="text" id="benamOtherHisabDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره پیگیری </span>
                                <input type="text" id="paygiriOtherHisabDar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-text"> شرح </span>
                            <input type="text" id="discriptionOtherHisabDar" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<div class="modal" id="varizToOthersHisbModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('varizToOthersHisbModalEdit')"><i class="fa-times fa"></i></button>
            <h5 class="modal-title"> ویرایش واریز به حساب دیگران </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-1">
                        <div class="text-end">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="addVarizToOtherHisabEdit()"> ذخیره  <i class="fa-save fa"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ (ریال) </span>
                                <input type="text" id="moneyVarizToOtherHisabDarEdit" class="form-control">
                            </div>    
                        </div>
                            
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره کارت/ شبا/ حساب </span>
                                <input type="text" id="cartNoVarizToOtherDarEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span> ریال: <span id="moneyVarizToOtherHisabLetterDarEdit"></span> </span>
                    </div>
                    <div class="row">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> طرف حساب </span>
                            <input type="text" id="varizBehisabDigariCustomerCodeDarEdit" class="form-control">
                            <input type="text" id="varizBehisabDigariCustomerNameDarEdit" class="form-control">
                            <input type="hidden" id="varizBehisabDigariCustomerPSNDarEdit">
                            <button class="btn btn-sm btn-info">...</button>
                            <button class="btn btn-sm btn-success text-warning"> گردش حساب مشتری </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> به نام </span>
                                <input type="text" id="benamOtherHisabDarEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره پیگیری </span>
                                <input type="text" id="paygiriOtherHisabDarEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-text"> شرح </span>
                            <input type="text" id="discriptionOtherHisabDarEdit" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal" id="relatedFactorsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('relatedFactorsModal')"><i class="fa-times fa"></i></button>
            <h5 class="modal-title"> فاکتور های مرتبط </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="text-start">
                            <button class="btn-sm btn btn-success" onclick="openSearchFactorModal()"> افزودن به لیست فاکتورها </button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <table class="table">
                            <thead class="bg-success">
                                <tr>
                                    <th>  ردیف  </th>
                                    <th>  نوع فاکتور  </th>
                                    <th>  شماره  </th>
                                    <th>  تاریخ  </th>
                                    <th>  مبلغ  </th>
                                    <th>  توضیحات  </th>
                                </tr>
                            </thead>
                            <tbody id="addedFactorsToDarListBoday">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-start">
                            <button class="btn-sm btn-danger btn text-warning" id="deleteAddedFactorForDarBtn" onclick="deleteAddedFactorForDar(this.value)"> حذف از لیست فاکتورهای مرتبط <i class="fa-trash fa"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>

  <div class="modal" id="searchFactorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
            <button class="btn-sm btn-danger btn text-warning" onclick="closeReceiveModals('searchFactorModal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title"> لیست فاکتورها </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> سال مالی </span>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                                @foreach($fiscallYears as $fiscallYear)
                                    @if($fiscallYear->IsActive==0)
                                        <option value="{{$fiscallYear->FiscalYear}}"> {{$fiscallYear->FiscalYear}} </option>
                                    @else
                                        <option value="{{$fiscallYear->FiscalYear}}" selected> {{$fiscallYear->FiscalYear}} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text"> شماره فاکتور </span>
                            <input type="text" id="searchFactorToDaryaft" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-end">
                            <button class="btn btn-sm btn-success" id="selectFactorForAddToDarBtn" onclick="chooseFactorForAddToDar(this.value)"> انتخاب </button>
                        </div>
                    </div>
                </div>
             
                <table class="table">
                    <thead>
                        <tr>
                            <th> ردیف </th>
                            <th> نوع فاکتور </th>
                            <th> شماره فاکتور </th>
                            <th> تاریخ </th>
                            <th> مبلغ </th>
                            <th> توضیحات </th>
                        </tr>
                    </thead>
                    <tbody id="searchedFactorForDarListBody">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

@include('repititiveparts/customerGardishModal')

<div class="modal" tabindex="-1" id="rasDaryaftItemModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-success">
            <button class="btn-sm btn-sm btn-danger text-warning" onclick="closeReceiveModals('rasDaryaftItemModal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title"> راس گیری </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> طرف حساب:  </span>
                            <input type="text" class="form-control">
                            <select name="" id="" class="form-select"></select>
                        </div>
                        <div class="input-group mb-2">
                            <div class="text-start">
                                <button class="btn-sm btn btn-success"> محاسبه راس بدهی شخص </button>
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="text-start"> مبنای تاریخ راس گیری </span>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div> راس بدهی 4545 روز</div>
                        <div> راس بدهی تا تاریخ 1402/05/05</div>
                    </div>
                </div>
                <div class="row">
                    <table class="table">
                        <thead class="bg-success">
                            <tr>
                                <th> ردیف </th>
                                <th> تاریخ </th>
                                <th> بدهکار </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-start">
                            <button class="btn-sm btn btn-danger"> حذف <i class="fa-trash fa"></i> </button>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="text-start">
                            <span>جمع کل: </span>
                            <span>راس کل:</span>
                            <span>جمع تا ردیف جاری</span>
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

<div class="modal" id="searchCustomerDaryaftModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button class="btn-sm btn btn-danger text-warning" onclick="closeReceiveModals('searchCustomerDaryaftModal')"> <i class="fa-times fa"></i> </button>
                <h5 class="modal-title"> جستجوی طرف حساب </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> افزودن مشتری جدید <i class="fa-plus fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نام شخص </span>
                                <input type="text" class="form-control" id="customerNameSearchDar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> فراخوانی همه اشخاص <i class="fa-history fa"></i> </button>
                            </div>
                            
                            <div class="text-start mb-2">
                                <input type="checkbox" name="" id="byPhoneSearchDar" class="form-check-input">
                                <label for="" class="form-label"> جستجو بر اساس شماره تلفن های فرد انجام شود. </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end mb-2">
                                <button class="btn-sm btn btn-success text-warning" onclick="chooseCustomerForDaryaft(this.value)" id="selectCustomerForDaryaftBtn"> انتخاب </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead class="bg-success">
                                <tr>
                                    <th>  کد  </th>
                                    <th>  نام  </th>
                                    <th>  خرید  </th>
                                    <th>  فروش  </th>
                                    <th> تعداد چک برگشتی </th>
                                    <th>  مبلغ چک برگشتی  </th>
                                </tr>
                            </thead>
                            <tbody id="customerForDaryaftListBody">
                                <tr>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<div class="modal" id="searchCustomerOtherHisabDaryaftModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn-sm btn btn-danger text-warning" onclick="closeReceiveModals('searchCustomerOtherHisabDaryaftModal')"> <i class="fa-times fa"></i> </button>
                <h5 class="modal-title"> جستجوی طرف حساب </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> افزودن مشتری جدید <i class="fa-plus fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نام شخص </span>
                                <input type="text" class="form-control" id="customerNameOtherHisabSearchDar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> فراخوانی همه اشخاص <i class="fa-history fa"></i> </button>
                            </div>
                            
                            <div class="text-start mb-2">
                                <input type="checkbox" name="" id="byPhoneSearchOtherHisabDar" class="form-check-input">
                                <label for="" class="form-label"> جستجو بر اساس شماره تلفن های فرد انجام شود. </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end mb-2">
                                <button class="btn-sm btn btn-success text-warning" onclick="chooseCustomerForOtherHisabDaryaft(this.value)" id="selectCustomerForDaryaftOtherHisabBtn"> انتخاب </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead class="bg-success">
                                <tr>
                                    <th>  کد  </th>
                                    <th>  نام  </th>
                                    <th>  خرید  </th>
                                    <th>  فروش  </th>
                                    <th> تعداد چک برگشتی </th>
                                    <th>  مبلغ چک برگشتی  </th>
                                </tr>
                            </thead>
                            <tbody id="customerForDaryaftOtherHisabVarizListBody">
                                <tr>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                    <td>    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal" id="selectSandoghModal" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
            <button class="btn-sm btn-danger btn text-warning" onclick="closeSandoghModalDar()"> <i class="fa-times fa"></i> </button>
          <h5 class="modal-title text-white"> انتخاب صندوق </h5>
        </div>
        <div class="modal-body" style="height:111px;">
          <div class="container">
            <div class="row">
                <div class="col-lg-10">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> صندوق </span>
                            <select name="" id="sandoghSelectInputDar" class="form-select">
                                <option value="0"> انتخاب کنید </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 text-end">
                        <button class="btn-sm btn btn-success text-warning" id="selectSandoghId" onclick="openDaryaftModal(this.value)"> انتخاب </button>
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


<div class="modal" id="editAddDaryafAddChequeInfo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closeReceiveModals('editAddDaryafAddChequeInfo')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title">  اطلاعات چک 2  </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="editAddChequeNoCheqeDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="editAddCheckSarRasidDateDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="editAddBankNameDar" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="editAddMoneyChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="editAddChequeDar()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="editAddDaysAfterChequeDateDar" class="form-control">
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="editAddShobeBankChequeDar" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="editAddMoneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="editAddHisabNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="editAddSayyadiNoChequeDar" class="form-control">
                                </div>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="editAddSabtBeNameChequeDar" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="editAddMalikChequeDar" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="editAddDescChequeDar" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="editAddRepeateChequeDar" class="form-control">
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="editAddDistanceMonthChequeDar" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="editAddDistanceDarChequeDar" class="form-control">
                                        <span class="diplay-4"> روز </span>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> </div>
        </div>
    </div>
  </div>

  <div class="modal" id="shobeBankChequeDarMadal" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-success py-2">
            <button class="btn-sm btn-danger btn text-warning"  onclick="closeReceiveModals('shobeBankChequeDarMadal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title"> شعبه بانک </h5>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نام شعبه </span>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-end mb-2">
                        <button class="btn-sm btn btn-success text-warning"> افزودن <i class="fa-plus fa"></i> </button>
                    </div>
                </div>
            </div>

                <table class="resizableTable table table-hover table-bordered table-sm" style="height:333px; overflow-y:scroll; width: 100%;">
                    <thead class="tableHeader">
                        <tr>
                            <th> ردیف </th>
                            <th> شعبه </th>
                        </tr>
                    </thead>
                    <tbody id="shobeBankChequeDarBody">
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  
  <div class="modal" id="editAddHawalaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
          <button class="btn btn-sm btn-danger" onclick="closeReceiveModals('editAddHawalaModal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title text-white"> 2 اطلاعات حواله </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                     <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره حواله </span>
                        <input type="text" id="eidtAddHawalaNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-7 px-0">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> حساب بانکی </span>
                        <input type="text" id="editAddBankJustAccNoHawalaDar" class="form-control">
                        <select name="" id="editAddBankAccNoHawalaDar" class="form-select"> </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-sm btn-success text-warning" onclick="editAddHawalaDar()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره پایانه کارت خوان </span>
                        <input type="text" id="editAddPayanehKartKhanNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> مبلغ </span>
                        <input type="text" id="editAddMonyAmountHawalaDar" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> تاریخ حواله (تاریخ حواله قابل اصلاح نمی باشد و باید با تاریخ دریافت یکسان باشد.) </span>
                    <input type="text" id="editAddHawalaDateHawalaDar" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> شرح </span>
                    <input type="text" id="editAddDiscriptionHawalaDar" class="form-control">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <div class="modal" id="editAddTakhfifModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('editAddTakhfifModal')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت  تخفیف</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="editAddtakhfifMoneyDar" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="edtiAdddiscriptionTakhfifDar" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نرخ ارز </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="text-end m-2">
                                <button disabled class="btn btn-sm btn-success"> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" onclick="editAddTakhfifDar()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">  </div>
        </div>
    </div>
</div>


<!-- modal for add variz to others hisab from edit part -->
<div class="modal" id="editAddVarizeBeHesabDegaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('editAddVarizeBeHesabDegaran')"><i class="fa-times fa"></i></button>
                <h5 class="modal-title"> واریز به حساب دیگران </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-1">
                        <div class="text-end">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="editAddVarizeBeHesab()"> ثبت <i class="fa-save fa"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ (ریال) </span>
                                <input type="text" id="editAddVarizeBeHesabMoney" class="form-control">
                            </div>    
                        </div>    

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره کارت/ شبا/ حساب </span>
                                <input type="text" id="editAddVarizeBeHesabAccount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span> ریال: <span id="editAddVarizBeHesabReyal"></span> </span>
                    </div>
                    <div class="row">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> طرف حساب </span>
                            <input type="text" id="editAddVarizBehisabDigariCustomerCode" class="form-control">
                            <input type="text" id="editAddVarizBehisabDigariCustomerName" class="form-control">
                            <input type="hidden" id="editAddVarizBehisabDigariCustomerPSN">
                            <button class="btn btn-sm btn-info">...</button>
                            <button class="btn btn-sm btn-success text-warning" onclick="openCustomerGardishModal(document.querySelector('#customerIdDaryaftEdit').value)"> گردش حساب مشتری </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> به نام </span>
                                <input type="text" id="editAddBenamOtherHisab" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره پیگیری </span>
                                <input type="text" id="editAddPaygiriOtherHisab" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-text"> شرح </span>
                            <input type="text" id="editAddDiscriptionOtherHisab" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>




<!-- modal for edit add edit vahe nagh -->
<div class="modal" id="editAddEditEditVagheNaghdmodal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-2">
            <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('editAddEditEditVagheNaghdmodal')"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title"> working دریافت وجه نقد </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="editAddEditArzTypeNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="editAddEditArzMoneyNaghdDar" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="editAddEditRialNaghdDar" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="editAddEditDescNaghdDar" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نرخ ارز </span>
                        <input type="text" disabled class="form-control">
                    </div>
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" disabled> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-end m-2">
                        <button class="btn btn-sm btn-success" onclick="editaddEditNaghdMoneyDar()">1 ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>
</div>


<div class="modal" id="editAddEditDaryafAddChequeInfo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closeReceiveModals('editAddEditDaryafAddChequeInfo')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> ویرایش اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="editAddEditChequeNoCheqe" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="editAddEditCheckSarRasidDate" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="editAddEditBankName" class="form-select">
                                  <option id="editAddEditBankOption" value=""> </option>
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="editAddEditMoneyCheque" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="editAddEditCheque()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="editAddEditDaysAfterChequeDate" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="editAddEditShobeBankCheque" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="editAddEditMoneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="editAddEditHisabNoCheque" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="editAddEditSayyadiNoCheque" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="editAddEditSabtBeNameCheque" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="editAddEditMalikCheque" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">  شرح </span>
                                <input type="text" id="editAddEditDescCheque" class="form-control">
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



  <div class="modal" id="editAddEditHawalaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
          <button class="btn btn-sm btn-danger" onclick="closeReceiveModals('editAddEditHawalaModal')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title text-white"> اطلاعات حواله </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                     <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره حواله </span>
                        <input type="text" id="eidtAddEditHawalaNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-7 px-0">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> حساب بانکی </span>
                        <input type="text" id="editAddEditBankJustAccNoHawalaDar" class="form-control">
                        <select name="" id="editAddEditBankAccNoHawalaDar" class="form-select"> </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-sm btn-success text-warning" onclick="editAddEditHawalaDar()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره پایانه کارت خوان </span>
                        <input type="text" id="editAddEditPayanehKartKhanNoHawalaDar" class="form-control">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> مبلغ </span>
                        <input type="text" id="editAddEditMonyAmountHawalaDar" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> تاریخ حواله (تاریخ حواله قابل اصلاح نمی باشد و باید با تاریخ دریافت یکسان باشد.) </span>
                    <input type="text" id="editAddEditHawalaDateHawalaDar" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> شرح </span>
                    <input type="text" id="editAddEditDiscriptionHawalaDar" class="form-control">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <div class="modal" id="editAddEditHawalaModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-1">
          <button class="btn btn-sm btn-danger" onclick="closeReceiveModals('editAddEditHawalaModalEdit')"><i class="fa-times fa"></i></button>
          <h5 class="modal-title text-white"> اطلاعات حواله </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                     <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره حواله </span>
                        <input type="text" id="eidtAddEditHawalaNoHawalaEdit" class="form-control">
                    </div>
                </div>
                <div class="col-lg-7 px-0">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> حساب بانکی </span>
                        <input type="text" id="editAddEditBankJustAccNoHawalaEdit" class="form-control">
                        <select name="" id="editAddEditBankAccNoHawalaEdit" class="form-select"> </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-sm btn-success text-warning" onclick="editAddEditHawalaEdit()"> ذخیره  <i class="fa-save fa"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> شماره پایانه کارت خوان </span>
                        <input type="text" id="editAddEditPayanehKartKhanNoHawalaEdit" class="form-control">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text"> مبلغ </span>
                        <input type="text" id="editAddEditMonyAmountHawalaEdit" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> تاریخ حواله (تاریخ حواله قابل اصلاح نمی باشد و باید با تاریخ دریافت یکسان باشد.) </span>
                    <input type="text" id="editAddEditHawalaDateHawalaEdit" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"> شرح </span>
                    <input type="text" id="editAddEditDiscriptionHawalaEdit" class="form-control">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <div class="modal" id="editAddEditTakhfifModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeReceiveModals('editAddEditTakhfifModal')"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> ویرایش دریافت تخفیف  </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="takhfifMoneyEdit" value="" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifEdit" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نرخ ارز </span>
                                <input type="text" disabled class="form-control">
                            </div>
                            <div class="text-end m-2">
                                <button disabled class="btn btn-sm btn-success"> تعیین نرخ ارز روز <i class="fa-edit fa"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-end m-2">
                                <button class="btn btn-sm btn-success" onclick="editAddEditTakhfif()"> ذخیره  <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">  </div>
        </div>
    </div>
</div>


<div class="modal" id="editAddEditVarizeBehesab" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeReceiveModals('editAddEditVarizeBehesab')"><i class="fa-times fa"></i></button>
                <h5 class="modal-title"> واریز به حساب دیگران </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-1">
                        <div class="text-end">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="editAddEditVarizBehesabSave()"> ثبت <i class="fa-save fa"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ (ریال) </span>
                                <input type="text" id="moneyVarizToOtherHisabEdit" class="form-control">
                            </div>    
                        </div>    

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره کارت/ شبا/ حساب </span>
                                <input type="text" id="cartNoVarizToOtherEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span> ریال: <span id="moneyVarizToOtherHisabLetterEdit"></span> </span>
                    </div>
                    <div class="row">
                        <div class="input-group mb-2">
                            <span class="input-group-text"> طرف حساب </span>
                            <input type="text" id="varizBehisabDigariCustomerCodeEdit" class="form-control">
                            <input type="text" id="varizBehisabDigariCustomerNameEdit" class="form-control">
                            <input type="hidden" id="varizBehisabDigariCustomerPSNEdit">
                            <button class="btn btn-sm btn-info">...</button>
                            <button class="btn btn-sm btn-success text-warning"> گردش حساب مشتری </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> به نام </span>
                                <input type="text" id="benamOtherHisabEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره پیگیری </span>
                                <input type="text" id="paygiriOtherHisabEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-text"> شرح </span>
                            <input type="text" id="discriptionOtherHisabEdit" class="form-control">
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
  window.onload = ()=> {
     makeTableColumnsResizable("receiveTable")
     makeTableColumnsResizable("addedEditDaryaftable")
  }
</script>
@endsection