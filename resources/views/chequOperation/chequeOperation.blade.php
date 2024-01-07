@extends('admin.layout')
@section('content')
    <div class="container-fluid containerDiv">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 sideBar">
                <fieldset class="border rounded mt-4 sidefieldSet">
                    <legend class="float-none w-auto legendLabel mb-0"> وضعیت چک </legend>
                        <div class="btn-group" role="group" aria-label="Basic mixed">
                            <button type="button" class="btn btn-sm ms-1 rounded btn-success chequBtn" > چکهای پرداختی </button>
                            <button type="button" class="btn btn-sm ms-1 rounded btn-success chequBtn"> چکهای دریافتی  </button>
                        </div>
                
                    <span class="situation">
                        <form action="{{ url('/filterGetPays') }}" method="get" id="filterPaysForm">
                            @csrf
                            <div class="row">
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="darAmad" id="allCheque" checked>
                                    <label class="form-check-label ms-4" for="allCheque"> همه  </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="existCheque" checked>
                                    <label class="form-check-label ms-4" for="existCheque"> موجود </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="chequeInProcess" checked>
                                    <label class="form-check-label ms-4" for="chequeInProcess"> در جریان وصول </label>
                                </div>

                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="passedToAccount" checked>
                                    <label class="form-check-label ms-4" for="passedToAccount">  پاس شده به حساب  </label>
                                </div>

                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="recievCash" checked>
                                    <label class="form-check-label ms-4" for="recievCash"> دریافت نقدی  </label>
                                </div>

                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="returnedCheque" checked>
                                    <label class="form-check-label ms-4" for="returnedCheque">  برگشتی   </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="spentCheque" checked>
                                    <label class="form-check-label ms-4" for="spentCheque">  خرج شده    </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="returnedToCustomer" checked>
                                    <label class="form-check-label ms-4" for="returnedToCustomer">  برگشت به مشتری     </label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input float-start d-inline" type="checkbox" name="daryaft" id="directPaymentToAccunt" checked>
                                    <label class="form-check-label ms-4" for="directPaymentToAccunt"> وصول مستقیم به حساب   </label>
                                </div>

                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm mt-2">تاریخ </span>
                                    <input type="text" name="firstDate" class="form-control form-control-sm" id="sefFirstDate">
                                </div>
                                <input type="text" name="getOrPay" value="2" class="d-none">
                                <div class="input-group input-group-sm mb-1 filterItems mt-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="secondDate" class="form-control form-control-sm"
                                        id="sefSecondDate">
                                </div>
                                {{-- <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">شماره </span>
                                    <input type="text" name="firstNum" class="form-control form-control-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> الی </span>
                                    <input type="text" name="secondNum" class="form-control form-control-sm">
                                </div> --}}
                                <div class="input-group input-group-sm mb-1 filterItems mt-2">
                                    <span class="input-group-text"> طرف حساب </span>
                                    <input class="form-control form-control-sm" name="pCode" id="customerCode">
                                    <div class="input-group input-group-sm mb-1 filterItems mt-2">
                                        <input type="text" name="name" id="customerName"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                                {{-- <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> توضحیات </span>
                                    <input type="text" name="description" class="form-control form-control-sm"
                                        placeholder="نام ">
                                </div> --}}
                                {{-- <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> گروه اشخاص </span>
                                    <select name="groupId" id="groupId" class="form-select">
                                        <option></option>
                                        <option>سعیدآباد</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                        <option>آنلاین</option>
                                        <option>حضوری</option>
                                    </select>
                                </div> --}}
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text"> تنظیم کننده </span>
                                    <select name="setterSn" id="setterSn" class="form-select">
                                        <option>  </option>
                                        <option value=""> </option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm topButton text-warning mb-2">
                                        بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                                </div>
                        </form>
                        <div class="btn-group" role="group" aria-label="Basic mixed">
                            <button type="button" class="btn btn-sm ms-1 rounded btn-success"> افزودن </button>
                            <button type="button" class="btn btn-sm ms-1 rounded btn-warning" id="EditPayInput"> ویرایش </button>
                            <button type="button" id="deletePaysHDSBtn" class="btn btn-sm ms-1 rounded btn-danger"> حذف </button>
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
                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentTable"
                    style="height:222px">
                    <thead class="tableHeader">
                        <tr>
                            <th id="pardakhtTd-1"> ردیف </th>
                            <th id="pardakhtTd-2"> شماره </th>
                            <th id="pardakhtTd-3"> تاریخ </th>
                            <th id="pardakhtTd-4"> دریافت کننده </th>
                            <th id="pardakhtTd-5"> بابت </th>
                            <th id="pardakhtTd-6"> مبلغ </th>
                            <th id="pardakhtTd-7"> زمان ثبت </th>
                            <th id="pardakhtTd-8"> کاربر </th>
                            <th id="pardakhtTd-9"> صندوق </th>
                            <th id="pardakhtTd-10"> توضحیات </th>
                        </tr>
                    </thead>
                    <tbody id="paysListBody">
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                    </tbody>
                </table>

                <table class="resizableTable table table-hover table-bordered table-sm" id="paymentDetailsTable"
                    style="height:calc(100vh - 422px)">
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
                    <button class="btn btn-sm btn-success rounded ms-1" value="AFTERTOMORROW"> راس چک </button>
                    <button class="btn btn-sm btn-success rounded ms-1" value="HUNDRED"> چاپ چک </button>
                </div>
                <div class="col-lg-4 mt-2">
                    <div class="d-flex">
                        <div class="p-2 flex-fill rasGeriTotal"> مجموع : </div>
                        <div class="p-2 flex-fill rasGeriTotal"> جمع آیتم های انتخابی : </div>
                        <div class="p-2 flex-fill rasGeriTotal"> تعداد : </div>
                        <div class="p-2 flex-fill rasGeriTotal"> مبلغ : </div>
                    </div>
                </div>

                <div class="col-lg-5 text-end">
                    <div class="btn-group mt-2" role="group">
                        <button class="btn btn-sm btn-success rounded ms-1"
                            onclick="getAndPayHistory('YESTERDAY','paysListBody','paysDetailsBody',2)" value="YESTERDAY">
                            دیروز </button>
                        <button class="btn btn-sm btn-success rounded ms-1"
                            onclick="getAndPayHistory('TODAY','paysListBody','paysDetailsBody',2)" value="TODAY"> امروز
                        </button>
                        <button class="btn btn-sm btn-success rounded ms-1"
                            onclick="getAndPayHistory('TOMORROW','paysListBody','paysDetailsBody',2)" value="TOMORROW">
                            فردا </button>
                        <button class="btn btn-sm btn-success rounded ms-1"
                            onclick="getAndPayHistory('AFTERTOMORROW','paysListBody','paysDetailsBody',2)"
                            value="AFTERTOMORROW"> پس فردا </button>
                        <button class="btn btn-sm btn-success rounded ms-1"
                            onclick="getAndPayHistory('HUNDRED','paysListBody','paysDetailsBody',2)" value="HUNDRED"> صد
                            تای آخر </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




