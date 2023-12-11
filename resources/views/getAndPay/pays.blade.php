@extends('admin.layout')
@section('content')

<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                    <span class="situation">
                        <button class="btn btn-success btn-sm pardakht-btn" data-toggle="modal" data-target="#payRasModal"> تست راس آیتم های پرداختی </button>
                        <form action="{{url("/filterGetPays")}}" method="get" id="filterPaysForm">
                            @csrf
                            <div class="row">
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="darAmad" id="sefNewOrderRadio" checked>
                                    <label class="form-check-label ms-4" for="sefNewOrderRadio"> پرداخت به شخص </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="sefNewOrderRadio" checked>
                                    <label class="form-check-label ms-4" for="sefNewOrderRadio"> هزینه  </label>
                                </div>
                               
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">تاریخ </span>
                                    <input type="text" name="firstDate" class="form-control form-control-sm" id="sefFirstDate">
                                </div>
                                <input type="text" name="getOrPay" value="2" class="d-none">
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
                                    <input  class="form-control form-control-sm" name="pCode" id="customerCode">
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <input type="text" name="name" id="customerName" class="form-control form-control-sm" >
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text">  توضحیات </span>
                                    <input type="text" name="description" class="form-control form-control-sm"  placeholder="نام ">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> گروه اشخاص </span>
                                    <select name="groupId" id="groupId" class="form-select">
                                        <option></option>
                                        <option>سعیدآباد</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> تنظیم کننده </span>
                                    <select name="setterSn" id="setterSn" class="form-select">
                                        <option>  </option>
                                    </select>
                                </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-sm topButton text-warning mb-2"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                            </div>
                        </form>
                        <div class="btn-group" role="group" aria-label="Basic mixed">
                            <button type="button" class="btn btn-sm ms-1 rounded btn-success" onclick="openPaysModal()"> افزودن  </button>
                            <button type="button" class="btn btn-sm ms-1 rounded btn-warning" id="EditPayInput" onclick="openEditPayModal(this.value)"> ویرایش  </button>
                            <button type="button" class="btn btn-sm ms-1 rounded btn-danger"> حذف </button>
                        </div>
                     </div>
                </span>
            </fieldset>
        </div>
        <div class="col-sm-10 col-md-10 col-sm-10 contentDiv">
            <div class="row contentHeader"> 
                <div class="col-lg-12 text-end mt-1 actionButton">
                </div>
            </div>
            <div class="row mainContent table-responsive">
                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentTable"  style="height:222px">
                    <thead class="tableHeader">
                        <tr>
                            <th id="pardakhtTd-1"> ردیف </th>
                            <th id="pardakhtTd-2"> شماره  </th>
                            <th id="pardakhtTd-3"> تاریخ </th>
                            <th id="pardakhtTd-4"> دریافت کننده </th>
                            <th id="pardakhtTd-5"> بابت </th>
                            <th id="pardakhtTd-6" > مبلغ  </th>
                            <th id="pardakhtTd-7"> زمان ثبت </th>
                            <th id="pardakhtTd-8"> کاربر  </th>
                            <th id="pardakhtTd-9" > صندوق </th>
                            <th id="pardakhtTd-10"> توضحیات </th>
                        </tr>
                    </thead>
                    <tbody id="paysListBody">
                        @foreach($pays as $pay)
                            <tr onclick="getGetAndPayBYS(this,'paysDetailsBody',{{$pay->SerialNoHDS}})" ondblclick="paysModal();">
                                <td class="pardakhtTd-1"> {{$loop->iteration}} </td>
                                <td class="pardakhtTd-2"> {{$pay->DocNoHDS}}  </td>
                                <td class="pardakhtTd-3"> {{$pay->DocDate}} </td>
                                <td class="pardakhtTd-4"> {{$pay->Name}}</td>
                                <td class="pardakhtTd-5"> {{$pay->DocDescHDS}} </td>
                                <td class="pardakhtTd-6"> {{number_format($pay->NetPriceHDS)}}  </td>
                                <td class="pardakhtTd-7"> {{$pay->SaveTime}}</td>
                                <td class="pardakhtTd-8"> {{$pay->userName}}  </td>
                                <td class="pardakhtTd-9"> {{$pay->cashName}} </td>
                                <td class="pardakhtTd-10"> {{$pay->DocDescHDS}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentDetailsTable"  style="height:calc(100vh - 422px)">
                    <thead class="tableHeader">
                        <tr>
                         <th id="payDetailsTd-1"> ردیف </th>
                         <th id="payDetailsTd-2"> نوع سند </th>
                         <th id="payDetailsTd-3"> ردیف چک </th>
                        </tr>
                    </thead>
                    <tbody id="paysDetailsBody">
                
                    </tbody>
                </table>
            </div>
            <div class="row contentFooter">
               <div class="col-lg-3 mt-2">
                    <button class="btn btn-sm btn-success rounded ms-1" value="AFTERTOMORROW"> راس چک  </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" value="HUNDRED"> چاپ چک  </button>
              </div>
              <div class="col-lg-4 mt-2">
                <div class="d-flex">
                    <div class="p-2 flex-fill rasGeriTotal">  مجموع : </div> 
                    <div class="p-2 flex-fill rasGeriTotal">  جمع آیتم های انتخابی : </div> 
                    <div class="p-2 flex-fill rasGeriTotal">  تعداد : </div> 
                    <div class="p-2 flex-fill rasGeriTotal">  مبلغ  : </div> 
                </div>
              </div>
                
              <div class="col-lg-5 text-end">
                <div class="btn-group mt-2" role="group"> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="getAndPayHistory('YESTERDAY','paysListBody','paysDetailsBody',2)" value="YESTERDAY"> دیروز </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="getAndPayHistory('TODAY','paysListBody','paysDetailsBody',2)" value="TODAY"> امروز </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="getAndPayHistory('TOMORROW','paysListBody','paysDetailsBody',2)" value="TOMORROW"> فردا </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="getAndPayHistory('AFTERTOMORROW','paysListBody','paysDetailsBody',2)" value="AFTERTOMORROW"> پس فردا </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="getAndPayHistory('HUNDRED','paysListBody','paysDetailsBody',2)" value="HUNDRED"> صد تای آخر </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="payRasModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> راًس گیری  </h5>
      </div>
      <div class="modal-body">
       <span class="card border my-1" >
            <div class="d-flex bg-light">
                <div class="p-2 flex-fill ">
                    <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text">  طرف حساب </span>
                        <input  class="form-control form-control-sm" name="pCode" id="customerCode">
                    </div>
                </div>
                <div class="p-2 flex-fill">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="p-2 flex-fill align-self-start"><button class="btn btn-sm btn-danger"> انصراف <i class="fa fa-xmark"> </i> </button> </div>
            </div>

            <div class="d-flex align-items-center bg-light rounded">
                <div class="p-2 flex-fill">  <button type="button" class="btn btn-success btn-sm align-self-end"> محاسبه راس بدهی شخصی  </button> </div>
                <div class="p-2 flex-fill">راس بدهی </div>
                <div class="p-2 flex-fill">روز </div>
                <div class="p-2 flex-fill"> : راً بدهی تا تاریخ </div>
                <div class="p-2 flex-fill"> 
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"> مبنای تاریخ راًس گیر  </span>
                        <input type="text" name="" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
     </span>
     
        <table class="resizableTable table table-hover table-bordered table-sm" id=""  style="height: 222px">
            <thead class="tableHeader">
                <tr>
                    <th> ردیف </th>
                    <th>  تاریخ  </th>
                    <th>  بدهکاری </th>
                </tr>
            </thead>
            <tbody>
        
            </tbody>
        </table>
      <div class="modal-footer py-0">
           <div class="flex-fill justify-content-start">
               <button type="button" class="btn btn-danger btn-sm align-self-end" data-dismiss="modal"> حذف  <i class="fa fa-xmark"></i> </button>
            </div>
            <div class="flex-fill justify-content-start">
                <span class="ras-result"> جمع کل: </span>
                <span class="ras-result"> جمع کل: </span>
                <span class="ras-result"> جمع کل: </span>
            </div>
      </div>
    </div>
  </div>
</div>
</div>



<!-- pay modal -->
<div class="modal fade" id="payModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="paymodal" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-success py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title text-white" id="paymodal">  پرداخت   </h5>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-lg-7">
               <div class="d-flex">
                    <div class="p-1 flex-fill ">
                        <div class="input-group input-group-sm mb-1 filterItems">
                            <span class="input-group-text"> شماره فاکتور خرید  </span>
                            <input  class="form-control form-control-sm" name="pCode" id="customerCode">
                        </div>
                    </div>
                    <div class="p-1 flex-fill"> 
                        <div class="input-group input-group-sm ">
                            <span class="input-group-text d-inline"> تاریخ صدور </span>
                            <input type="text" name="" id="sadirDatePaysInput" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="p-1 flex-fill">
                        <div class="form-check form-check-inline d-flex">
                            <label class="form-check-label ms-1" for="inlineRadio1" > شخص  </label>
                            <input class="form-check-input" type="radio" name="payType" name="person" id="personalPaysRadio" checked value="1">
                        </div>
                    </div>
                    <div class="p-1 flex-fill">
                        <div class="form-check form-check-inline d-flex">
                            <label class="form-check-label ms-1" for="inlineRadio2"> هزینه  </label>
                        <input class="form-check-input" type="radio" name="payType" id="hazinahPaysRadio" value="0">
                        </div>
                    </div>
            </div>

            <div class="d-flex">
                <div class="p-1 flex-fill"> 
                    <div class="input-group input-group-sm ">
                        <span class="input-group-text d-inline"> طرف حساب  </span>
                        <input type="text" name="customerCode" id="customerCodePayInput" class="form-control form-control-sm">
                        <input type="text" name="customerName" id="customerNamePayInput" class="form-control form-control-sm"> <span class="border px-2 pe-auto"> ... </span>
                        <input type="text" name="customerId" id="customerIdPayInput" class="form-control form-control-sm d-none">
                    </div>
                </div>
                <div class="p-1 flex-fill"> 
                    <div class="input-group input-group-sm ">
                        <span class="input-group-text d-inline"> بابت </span>
                        <input type="text" name="babatCodePay" id="babatCodePay" class="form-control form-control-sm">
                        <input type="text" id="babatIdPayInput" class="d-none">
                        <select class="form-select form-select-sm" id="babatPayInput" aria-label=".form-select-sm example">
                            @foreach ($infors as $infor)
                                <option value="{{$infor->SnInfor}}">{{$infor->InforName}}</option>
                            @endforeach
                        </select>
                        <span class="border px-2 pe-auto"> ... </span>
                    </div>
                </div>
              </div>
              <div class="d-flex">
                <div class="p-1 flex-fill"> 
                    <div class="input-group input-group-sm ">
                        <span class="input-group-text d-inline"> توضیحات </span>
                        <input type="text" name="" class="form-control form-control-sm">
                        <button class="btn btn-sm btn-success"> فاکتورهای مربوطه </button>
                    </div>
                 </div>
              </div>
         </div>

        <div class="col-lg-5 text-end">
            <div class="d-flex justify-content-start">
                <div class="btn-group mt-2" role="group"> 
                    <button class="btn btn-sm btn-success rounded ms-1"> راس آیتم های پرداختی </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="openCustomerGardishModal(document.querySelector('#customerIdPayInput').value)"> گردش حساب </button> 
                    <button class="btn btn-sm btn-success rounded ms-1"> ثبت  </button> 
                    <button class="btn btn-sm btn-danger rounded ms-1"> انصراف  </button> 
                </div>
            </div>
            <table class="resizableTable table table-hover table-bordered table-sm mt-1" id=""  style="height: 111px">
                <thead class="tableHeader">
                    <tr>
                        <th> ردیف  </th>
                        <th> شرح  </th>
                        <th> وضعیت </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> شرح  </td>
                        <td> مبلغ  </td>
                        <td> وضعیت </td>
                    </tr>
                </tbody>
           </table>
        </div>
     </div>
     <div class="row">
     <div class="col-lg-2 col-md-2 col-sm-2 text-center">
          <fieldset class="border rounded">
            <legend  class="float-none w-auto legendLabel"> افزودن </legend>
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddPayVajhNaghdAddModal()"> وجه نقد  </button> 
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddPayChequeInfoAddModal()">  چک   </button> 
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddPayHawalaFromBoxAddModal()"> حواله از صندوق  </button> 
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openaddSpentChequeAddModal()"> خرج چک  </button> 
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddPayTakhfifAddModal()">   تخفیف  </button> 
                <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddPayHawalaFromBankAddModal()">  حواله از بانک  </button> 
                
                <div class="flex-fill justify-content-start">
                    <button class="btn btn-sm btn-success mt-1">  اصلاح  </button> 
                    <button class="btn btn-sm btn-danger mt-1"> حذف  </button> 
                </div>
          </fieldset>
        </div>
        <div class="col-lg-10 col-md-2 col-sm-2">
           <fieldset class="border rounded">
             <legend  class="float-none w-auto legendLabel"> </legend>
                <table class="resizableTable table table-hover table-bordered table-sm" id=""  style="height: 222px">
                    <thead class="tableHeader">
                        <tr>
                            <th> ردیف  </th>
                            <th> شرح  </th>
                            <th> مبلغ </th>
                            <th> ردیف در دفتر چک </th>
                            <th> شماره صیادی </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </fieldset>
        </div>
     </div>
       
      <div class="modal-footer py-1">

            <div class="p-1 flex-fill ">
                <div class="input-group input-group-sm mb-1 filterItems">
                    <span class="input-group-text"> مالیات بر ارزش افزوده </span>
                    <input  class="form-control form-control-sm" name="pCode" id="customerCode">
                </div>
            </div>
            
            <div class="flex-fill justify-content-start">
                <span class="ras-result"> راس چک ها : </span>
                <span class="ras-result"> راس همه آیتم ها : </span>
                <span class="ras-result"> جمع کل: </span>
            </div>
            <div class="flex-fill justify-content-start">
                <span class="bordered">  0 مبلغ فاکتور </span>
                <span class="bordered"> مانده (50000) </span>
            </div>
            <div class="flex-fill justify-content-start">
                <span class="bordered">  5000 مجموع  </span>
            </div>
            <div class="flex-fill justify-content-start">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    این پرداخت بابت چک پرداختی میباشد!
                </label>
            </div>
            </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="searchCustomerForPayModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button class="btn-sm btn btn-danger text-warning" onclick="closeSearchCustomerPaysModal()"> <i class="fa-times fa"></i> </button>
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
                                <input type="text" class="form-control" id="customerNameSearchPay">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> فراخوانی همه اشخاص <i class="fa-history fa"></i> </button>
                            </div>
                            
                            <div class="text-start mb-2">
                                <input type="checkbox" name="" id="byPhoneSearchPay" class="form-check-input">
                                <label for="" class="form-label"> جستجو بر اساس شماره تلفن های فرد انجام شود. </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end mb-2">
                                <button class="btn-sm btn btn-success text-warning" onclick="chooseCustomerForPay(this.value)" id="selectCustomerForPaysBtn"> انتخاب </button>
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
                            <tbody id="customerForPaysListBody">
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
<div class="modal" id="addPayVajhNaghdAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success py-2">
            <button class="btn-danger btn-sm btn" onclick="closeAddPayVajhNaghdAddModal()"> <i class="fa fa-times"></i></button>
            <h5 class="modal-title"> دریافت وجه نقد </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text"> نوع ارز: </span>
                        <input type="text" disabled id="arzTypeNaghdPayAddInputAdd" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ارز: </span>
                        <input type="text" id="arzMoneyNaghdPayAddInputAdd" disabled class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> مبلغ ریال: </span>
                        <input type="text" id="rialNaghdPayAddInputAdd" class="form-control">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"> شرح: </span>
                        <input type="text" id="descNaghdPayAddInputAdd" class="form-control">
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
                        <button class="btn btn-sm btn-success" onclick="addNaghdMoneyPayAdd()"> ذخیره  <i class="fa-save fa"></i></button>
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

<div class="modal" id="addPayChequeInfoAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closAddPayChequeInfoAddModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="chequeNoCheqeInputAddPayAdd" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="checkSarRasidDateInputAddPayAdd" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="bankNameSelectAddPayAdd" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="moneyChequeInputAddPayAdd" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="addChequeBtnAddPayAdd()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="daysAfterChequeDateInputAddPayAdd" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="shobeBankChequeInputAddPayAdd" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="moneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="hisabNoChequeInputAddPayAdd" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="sayyadiNoChequeInputAddPayAdd" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="sabtBeNameChequeInputAddPayAdd" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="malikChequeInputAddPayAdd" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="descChequeInputAddPayAdd" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="repeateChequeInputAddPayAdd" class="form-control">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="distanceMonthChequeInputAddPayAdd" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="distanceChequeInputAddPayAdd" class="form-control">
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

<div class="modal" id="addSpentChequeAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeAddSpentChequeAddModal()"><i class="fa-times fa"></i></button>
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
<div class="modal" id="AddPayTakhfifAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayTakhfifAddModal()"> <i class="fa fa-times"></i></button>
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
                                <input type="text" id="takhfifMoneyInputAddPayAdd" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifInputAddPayAdd" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="addTakhfifBtnAddPayAdd()"> ثبت <i class="fa-save fa"></i></button>
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
<div class="modal" id="AddPayHawalaFromBoxAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayHawalaFromBoxAddModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از صندوق </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله: </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="addHawalaFromBoxBtnAddPayAdd()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>تاریخ حواله (حواله قابل اصلاح نمی باشد) </span>
                            <input type="text" id="pay_hawala_from_box_add_modal_input_box_id" class="form-control">
                            <span>توجه : تاریخ حواله می بایست حتما با تاریخ پرداخت برابر باشد.</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مبلغ : </span>
                                    <input type="text" id="" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> کارمزد: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    </div>
</div>
<div class="modal" id="AddPayHawalaFromBankAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayHawalaFromBankAddModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از بانک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> از شماره حساب : </span>
                                <input type="text" id="" class="form-control">
                                <select name="" id="" class="form-select">
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله </span>
                                <input type="text" class="form-control">
                                <span class="input-gorup-text"> مانده </span>
                                <span class="">1234</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> ثبت </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span > تاریخ حواله (قابل اصلاح نمی باشد) </span>
                            <input type="text" class="form-control">
                            <span> توجه: تاریخ حواله حتما می بایست با تاریخ پرداخت برابر باشد. </span>

                        </div>
                    </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="editPayModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="paymodal" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title text-white" id="paymodal">  پرداخت   </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="d-flex">
                            <div class="p-1 flex-fill ">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text"> شماره فاکتور خرید  </span>
                                    <input  class="form-control form-control-sm" name="editPayDocNoHDS" id="editPayDocNoHDS">
                                </div>
                            </div>
                            <div class="p-1 flex-fill"> 
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text d-inline"> تاریخ صدور </span>
                                    <input type="text" name="editPayDocDate" id="editPayDocDate" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="p-1 flex-fill">
                                <div class="form-check form-check-inline d-flex">
                                    <label class="form-check-label ms-1" for="inlineRadio1" > شخص  </label>
                                    <input class="form-check-input" type="radio" name="payType" name="person" id="personalEditPaysRadio" checked value="1">
                                </div>
                            </div>
                            <div class="p-1 flex-fill">
                                <div class="form-check form-check-inline d-flex">
                                    <label class="form-check-label ms-1" for="inlineRadio2"> هزینه  </label>
                                <input class="form-check-input" type="radio" name="payType" id="hazinahEditPaysRadio" value="0">
                                </div>
                            </div>
                        </div>
    
                        <div class="d-flex">
                            <div class="p-1 flex-fill"> 
                                <div class="input-group input-group-sm ">
                                    <span class="input-group-text d-inline"> طرف حساب  </span>
                                    <input type="text" name="editPayCode" id="editPayCode" class="form-control form-control-sm">
                                    <input type="text" name="editPayName" id="editPayName" class="form-control form-control-sm"> <span class="border px-2 pe-auto"> ... </span>
                                    <input type="text" name="editPayPSN" id="editPayPSN" class="form-control form-control-sm d-none">
                                </div>
                            </div>
                            <div class="p-1 flex-fill"> 
                                <div class="input-group input-group-sm ">
                                    <span class="input-group-text d-inline"> بابت </span>
                                    <input type="text" name="editBabatCodePay" id="editBabatCodePay" class="form-control form-control-sm">
                                    <input type="text" id="editBabatIdPay" class="d-none">
                                    <select class="form-select form-select-sm" id="editBabatIdPaySelect" name="editBabatIdPaySelect" aria-label=".form-select-sm example">
                                        <option value="0"> </option>
                                        @foreach ($infors as $infor)
                                            <option value="{{$infor->SnInfor}}">{{$infor->InforName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="border px-2 pe-auto"> ... </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="p-1 flex-fill"> 
                                <div class="input-group input-group-sm ">
                                    <span class="input-group-text d-inline"> توضیحات </span>
                                    <input type="text" name="editPayDocDescHDS" id="editPayDocDescHDS" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-success"> فاکتورهای مربوطه </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-end">
                        <div class="d-flex justify-content-start">
                            <div class="btn-group mt-2" role="group"> 
                            <button class="btn btn-sm btn-success rounded ms-1"> راس آیتم های پرداختی </button> 
                            <button class="btn btn-sm btn-success rounded ms-1" onclick="openCustomerGardishModal(document.querySelector('#editPayPSN').value)"> گردش حساب </button> 
                            <button class="btn btn-sm btn-success rounded ms-1"> ثبت  </button> 
                            <button class="btn btn-sm btn-danger rounded ms-1"> انصراف  </button> 
                            </div>
                        </div>
                        <table class="resizableTable table table-hover table-bordered table-sm mt-1" id=""  style="height: 111px">
                            <thead class="tableHeader">
                                <tr>
                                    <th> ردیف  </th>
                                    <th> شرح  </th>
                                    <th> وضعیت </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> شرح  </td>
                                    <td> مبلغ  </td>
                                    <td> وضعیت </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 text-center">
                        <fieldset class="border rounded">
                            <legend  class="float-none w-auto legendLabel"> افزودن </legend>
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditPayVajhNaghdEditModal()"> وجه نقد  </button> 
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditPayChequeInfoEditModal()">  چک   </button> 
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditPayHawalaFromBoxEditModal()"> حواله از صندوق  </button> 
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditSpentChequeEditModal()"> خرج چک  </button> 
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditPayTakhfifEditModal()">   تخفیف  </button> 
                            <button class="btn btn-sm btn-success w-75 mt-1" onclick="openAddEditPayHawalaFromBankEditModal()">  حواله از بانک  </button> 
                            
                            <div class="flex-fill justify-content-start">
                                <button class="btn btn-sm btn-success mt-1" id="openEditEditPayEditBtn" onclick="openEditEditPayEditModal(this.value)">  اصلاح  </button> 
                                <button class="btn btn-sm btn-danger mt-1"> حذف  </button> 
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-10 col-md-2 col-sm-2">
                        <fieldset class="border rounded">
                            <legend  class="float-none w-auto legendLabel"> </legend>
                            <table class="resizableTable table table-hover table-bordered table-sm" id=""  style="height: 222px">
                                <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف  </th>
                                        <th> شرح  </th>
                                        <th> مبلغ </th>
                                        <th> ردیف در دفتر چک </th>
                                        <th> شماره صیادی </th>
                                    </tr>
                                </thead>
                                <tbody id="payEditTableBodyBys">
                                    <tr>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
            
                <div class="modal-footer py-1">
    
                    <div class="p-1 flex-fill ">
                        <div class="input-group input-group-sm mb-1 filterItems">
                        <span class="input-group-text"> مالیات بر ارزش افزوده </span>
                        <input  class="form-control form-control-sm" name="pCode" id="customerCode">
                        </div>
                    </div>
                
                    <div class="flex-fill justify-content-start">
                        <span class="ras-result"> راس چک ها : </span>
                        <span class="ras-result"> راس همه آیتم ها : </span>
                        <span class="ras-result"> جمع کل: </span>
                    </div>
                    <div class="flex-fill justify-content-start">
                        <span class="bordered">  0 مبلغ فاکتور </span>
                        <span class="bordered"> مانده (50000) </span>
                    </div>
                    <div class="flex-fill justify-content-start">
                    <span class="bordered">  5000 مجموع  </span>
                    </div>
                    <div class="flex-fill justify-content-start">
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            این پرداخت بابت چک پرداختی میباشد!
                        </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="searchCustomerForPayEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button class="btn-sm btn btn-danger text-warning" onclick="closeSearchCustomerForPayEditModal()"> <i class="fa-times fa"></i> </button>
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
                                <input type="text" class="form-control" id="customerNameSearchPayEdit">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-start mb-2">
                                <button class="btn-sm btn-success btn text-warning"> فراخوانی همه اشخاص <i class="fa-history fa"></i> </button>
                            </div>
                            
                            <div class="text-start mb-2">
                                <input type="checkbox" name="" id="byPhoneSearchPayEdit" class="form-check-input">
                                <label for="" class="form-label"> جستجو بر اساس شماره تلفن های فرد انجام شود. </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end mb-2">
                                <button class="btn-sm btn btn-success text-warning" onclick="chooseCustomerForPayEdit(this.value)" id="selectCustomerForPaysEditBtn"> انتخاب </button>
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
                            <tbody id="customerForPaysEditListBody">
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

{{-- edit edit pays modal --}}
<div class="modal" id="addPayVajhNaghdEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayVajhNaghdEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت وجه نقد </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled id="arzTypeNaghdPayAddInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" id="arzMoneyNaghdPayAddInputEdit" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="rialNaghdPayAddInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="descNaghdPayAddInputEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="addNaghdMoneyPayEdit()"> ذخیره  <i class="fa-save fa"></i></button>
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

<div class="modal" id="addPayChequeInfoEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closAddPayChequeInfoEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="chequeNoCheqeInputAddPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="checkSarRasidDateInputAddPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="bankNameSelectAddPayEdit" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="moneyChequeInputAddPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="addChequeBtnAddPayEdit()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="daysAfterChequeDateInputAddPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="shobeBankChequeInputAddPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="moneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="hisabNoChequeInputAddPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="sayyadiNoChequeInputAddPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="sabtBeNameChequeInputAddPayEdit" class="form-control">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="malikChequeInputAddPayEdit" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="descChequeInputAddPayEdit" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="repeateChequeInputAddPayEdit" class="form-control">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="distanceMonthChequeInputAddPayEdit" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="distanceChequeInputAddPayEdit" class="form-control">
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

<div class="modal" id="addSpentChequeEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeAddSpentChequeEditModal()"><i class="fa-times fa"></i></button>
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
<div class="modal" id="AddPayTakhfifEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayTakhfifEditModal()"> <i class="fa fa-times"></i></button>
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
                                <input type="text" id="takhfifMoneyInputAddPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifInputAddPayEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="addTakhfifBtnAddPayEdit()"> ثبت <i class="fa-save fa"></i></button>
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
<div class="modal" id="AddPayHawalaFromBoxEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayHawalaFromBoxEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از صندوق </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله: </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="addHawalaFromBoxBtnAddPayEdit()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>تاریخ حواله (حواله قابل اصلاح نمی باشد) </span>
                            <input type="text" id="pay_hawala_from_box_add_modal_input_box_id" class="form-control">
                            <span>توجه : تاریخ حواله می بایست حتما با تاریخ پرداخت برابر باشد.</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مبلغ : </span>
                                    <input type="text" id="" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> کارمزد: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    </div>
</div>
<div class="modal" id="AddPayHawalaFromBankEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddPayHawalaFromBankEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از بانک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> از شماره حساب : </span>
                                <input type="text" id="" class="form-control">
                                <select name="" id="" class="form-select">
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله </span>
                                <input type="text" class="form-control">
                                <span class="input-gorup-text"> مانده </span>
                                <span class="">1234</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> ثبت </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span > تاریخ حواله (قابل اصلاح نمی باشد) </span>
                            <input type="text" class="form-control">
                            <span> توجه: تاریخ حواله حتما می بایست با تاریخ پرداخت برابر باشد. </span>

                        </div>
                    </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>
{{-- add edit edit modal --}}
<div class="modal" id="addEditPayVajhNaghdEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn-danger btn-sm btn" onclick="closeAddEditPayVajhNaghdEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت وجه نقد </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled id="arzTypeNaghdPayAddEditInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" id="arzMoneyNaghdPayAddEditInputEdit" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="rialNaghdPayAddEditInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="descNaghdPayAddEditInputEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="addEditNaghdMoneyPayEdit()"> ذخیره  <i class="fa-save fa"></i></button>
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

<div class="modal" id="addEditPayChequeInfoEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closAddEditPayChequeInfoEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="chequeNoCheqeInputAddEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="checkSarRasidDateInputAddEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="bankNameSelectAddEditPayEdit" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="moneyChequeInputAddEditPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="addChequeBtnAddEditPayEdit()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="daysAfterChequeDateInputAddEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="shobeBankChequeInputAddEditPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="moneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="hisabNoChequeInputAddEditPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="sayyadiNoChequeInputAddEditPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="sabtBeNameChequeInputAddEditPayEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="malikChequeInputAddEditPayEdit" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="descChequeInputAddEditPayEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="repeateChequeInputAddEditPayEdit" class="form-control">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="distanceMonthChequeInputAddEditPayEdit" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="distanceChequeInputAddEditPayEdit" class="form-control">
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

<div class="modal" id="addEditSpentChequeEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeAddEditSpentChequeEditModal()"><i class="fa-times fa"></i></button>
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
<div class="modal" id="addEditPayTakhfifEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddEditPayTakhfifEditModal()"> <i class="fa fa-times"></i></button>
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
                                <input type="text" id="takhfifMoneyInputAddEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifInputAddEditPayEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="addTakhfifBtnAddEditPayEdit()"> ثبت <i class="fa-save fa"></i></button>
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
<div class="modal" id="addEditPayHawalaFromBoxEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddEditPayHawalaFromBoxEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از صندوق </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله: </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="addHawalaFromBoxBtnAddEditPayEdit()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>تاریخ حواله (حواله قابل اصلاح نمی باشد) </span>
                            <input type="text" id="pay_hawala_from_box_add_modal_input_box_id" class="form-control">
                            <span>توجه : تاریخ حواله می بایست حتما با تاریخ پرداخت برابر باشد.</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مبلغ : </span>
                                    <input type="text" id="" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> کارمزد: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal" id="addEditPayHawalaFromBankEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeAddEditPayHawalaFromBankEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از بانک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> از شماره حساب : </span>
                                <input type="text" id="" class="form-control">
                                <select name="" id="" class="form-select">
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله </span>
                                <input type="text" class="form-control">
                                <span class="input-gorup-text"> مانده </span>
                                <span class="">1234</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> ثبت </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span > تاریخ حواله (قابل اصلاح نمی باشد) </span>
                            <input type="text" class="form-control">
                            <span> توجه: تاریخ حواله حتما می بایست با تاریخ پرداخت برابر باشد. </span>

                        </div>
                    </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>
{{-- edit edit edit modals --}}
<div class="modal" id="editEditPayVajhNaghdEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn-danger btn-sm btn" onclick="closeEditEditPayVajhNaghdEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> دریافت وجه نقد </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> نوع ارز: </span>
                                <input type="text" disabled id="arzTypeNaghdPayEditEditInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ارز: </span>
                                <input type="text" id="arzMoneyNaghdPayEditEditInputEdit" disabled class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> مبلغ ریال: </span>
                                <input type="text" id="rialNaghdPayEditEditInputEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="descNaghdPayEditEditInputEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="editEditNaghdMoneyPayEdit()"> ذخیره  <i class="fa-save fa"></i></button>
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

<div class="modal" id="editEditPayChequeInfoEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-2">
                <button class="btn btn-danger btn-sm text-warning" onclick="closEditEditPayChequeInfoEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> اطلاعات چک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره چک </span>
                                <input type="text" id="chequeNoCheqeInputEditEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> تاریخ سر رسید </span>
                                <input type="text" id="checkSarRasidDateInputEditEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text">  نام بانک </span>
                                <select name="" id="bankNameSelectEditEditPayEdit" class="form-select">
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->SerialNoBSN}}">{{$bank->NameBsn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group  mb-2">
                                <span class="input-group-text"> مبلغ به ریال </span>
                                <input type="text" id="moneyChequeInputEditEditPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn-sm btn-success btn" onclick="editChequeBtnAddEditPayEdit()" > ذخیره <i class="fa-save fa"></i> </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> تاریخ چک برای بعد </span>
                                <input type="text" id="daysAfterChequeDateInputEditEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شعبه </span>
                                <input type="text" id="shobeBankChequeInputEditEditPayEdit" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <span> مبلغ به حروف : <span id="moneyInLetters"></span> </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب </span>
                                    <input type="text" id="hisabNoChequeInputEditEditPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره صیادی </span>
                                    <input type="text" id="sayyadiNoChequeInputEditEditPayEdit" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> ثبت شده به نام </span>
                                    <input type="text" id="sabtBeNameChequeInputEditEditPayEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مالک  </span>
                                    <input type="text" id="malikChequeInputEditEditPayEdit" class="form-control">
                                </div>
                                <div><button class="btn-success btn-sm btn text-warning">استفاده از بارکد خوان</button></div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    شرح
                                </span>
                                <input type="text" id="descChequeInputEditEditPayEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="border border-2 border-secondary p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> تعداد تکرار </span>
                                        <input type="text" id="repeateChequeInputEditEditPayEdit" class="form-control">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> فاصله سررسید </span>
                                        <input type="text" id="distanceMonthChequeInputEditEditPayEdit" class="form-control">

                                        <span class="input-group-text"> ماهه </span>
                                        <input type="text" id="distanceChequeInputEditEditPayEdit" class="form-control">
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

<div class="modal" id="editEditSpentChequeEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success py-1">
                <button class="btn btn-sm btn-danger text-warning" onclick="closeEditEditSpentChequeEditModal()"><i class="fa-times fa"></i></button>
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
<div class="modal" id="editEditPayTakhfifEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeEditEditPayTakhfifEditModal()"> <i class="fa fa-times"></i></button>
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
                                <input type="text" id="takhfifMoneyInputEditEditPayEdit" class="form-control">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شرح: </span>
                                <input type="text" id="discriptionTakhfifInputEditEditPayEdit" class="form-control">
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
                                <button class="btn btn-sm btn-success" onclick="editTakhfifBtnEditEditPayEdit()"> ثبت <i class="fa-save fa"></i></button>
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
<div class="modal" id="editEditPayHawalaFromBoxEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeEditEditPayHawalaFromBoxEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از صندوق </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله: </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success" onclick="editHawalaFromBoxBtnEditEditPayEdit()"> ثبت <i class="fa-save fa"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>تاریخ حواله (حواله قابل اصلاح نمی باشد) </span>
                            <input type="text" id="pay_hawala_from_box_add_modal_input_box_id" class="form-control">
                            <span>توجه : تاریخ حواله می بایست حتما با تاریخ پرداخت برابر باشد.</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> مبلغ : </span>
                                    <input type="text" id="" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> کارمزد: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal" id="editEditPayHawalaFromBankEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-warning py-1">
                <button class="btn-danger btn-sm btn" onclick="closeEditEditPayHawalaFromBankEditModal()"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> افزودن حواله از بانک </h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text"> از شماره حساب : </span>
                                <input type="text" id="" class="form-control">
                                <select name="" id="" class="form-select">
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"> شماره حواله </span>
                                <input type="text" class="form-control">
                                <span class="input-gorup-text"> مانده </span>
                                <span class="">1234</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> ثبت </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span > تاریخ حواله (قابل اصلاح نمی باشد) </span>
                            <input type="text" class="form-control">
                            <span> توجه: تاریخ حواله حتما می بایست با تاریخ پرداخت برابر باشد. </span>

                        </div>
                    </div>
                    <fieldset class="border rounded mt-4">
                        <legend class="float-none w-auto legendLabel mb-0">  حواله به </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شماره حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام بانک: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> نام دارنده حساب: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">  شعبه: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"> شرح: </span>
                                    <input type="text" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@include('repititiveparts/customerGardishModal')
@endsection
