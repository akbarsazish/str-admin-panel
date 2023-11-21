@extends('admin.layout')
@section('content')

<div class="container-fluid containerDiv">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
            <fieldset class="border rounded mt-4 sidefieldSet">
                <legend  class="float-none w-auto legendLabel mb-0">انتخاب</legend>
                  <span class="situation">
                        <button class="btn btn-success btn-sm pardakht-btn"> تست راس آیتم های پرداختی </button>
                         <form action="{{url("/filterGetPays")}}" method="get" id="filterReceivesForm">
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
                            <button type="button" class="btn btn-sm ms-1 rounded btn-success"> افزودن  </button>
                            <button type="button" class="btn btn-sm ms-1 rounded btn-warning"> ویرایش  </button>
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
                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentTable"  style="height:200px">
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
                    <tbody id="pamentTableBody">
                        @foreach($pays as $pay)
                            <tr class="factorTablRow" onclick="getGetAndPayBYS(this,'paysDetailsBody',{{$pay->SerialNoHDS}})"  class="factorTablRow">
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
            
                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentDetailsTable"  style="height:calc(100vh - 500px)">
                    <thead class="tableHeader">
                        <tr>
                         <th id="payDetailsTd-1"> ردیف </th>
                         <th id="payDetailsTd-2"> نوع سند </th>
                         <th id="payDetailsTd-3"> ردیف چک </th>
                        </tr>
                    </thead>
                    <tbody id="paysDetailsBody">
                       <tr>
                         <td class="payDetailsTd-1"> ردیف </td>
                         <td class="payDetailsTd-2"> نوع سند </td>
                         <td class="payDetailsTd-3"> شرح </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row contentFooter">
              <div class="col-lg-12 text-end">
                  <div class="btn-group mt-2" role="group"> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="factorHistory('YESTERDAY')" value="YESTERDAY"> دیروز </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="factorHistory('TODAY')" value="TODAY"> امروز </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="factorHistory('TOMORROW')" value="TOMORROW"> فردا </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="factorHistory('AFTERTOMORROW')" value="AFTERTOMORROW"> پس فردا </button> 
                    <button class="btn btn-sm btn-success rounded ms-1" onclick="factorHistory('HUNDRED')" value="HUNDRED"> صد تای آخر </button>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
