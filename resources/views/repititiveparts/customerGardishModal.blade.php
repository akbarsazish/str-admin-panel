<div class="modal" tabindex="-1" id="customerGardishModal" data-backdrop="static">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info py-2">
                <button class="btn btn-sm btn-danger" id="closeCustomerGardishModalBtn"> <i class="fa fa-times"></i></button>
                <h5 class="modal-title"> گردش مشتری </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <fieldset class="border rounded">
                            <legend class="float-none w-auto legendLabel mb-0"> شرایط گزارش </legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> طرف حساب </span>
                                        <input type="text" id="customerCodeGardish" class="form-control">
                                        <input type="text" id="customerNameGardish" class="form-control">
                                        <input type="text" id="customerIdGardish" class="form-control d-none">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"> سال مالی </span>
                                        <select name="fiscalYear" id="fiscalYearCustomerGardish" class="form-select"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"> تاریخ </span>
                                            <input type="text" id="firstDateCustomerGardish" class="form-control">
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"> الی: </span>
                                            <input type="text" id="secondDateCustomerGardish" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-2 text-start">
                                                <input type="checkbox" name="" id="rizAsnadKharidCheckBox" class="form-check-input" checked> &nbsp; &nbsp;
                                                <span> ریز اسناد خرید </span>&nbsp;
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-2 text-start">
                                                <input type="checkbox" name="" id="rizAsnadFroshCheckBox" class="form-check-input" checked> &nbsp; &nbsp;
                                                <span> ریز اسناد فروش </span>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-2 text-start">
                                                <input type="checkbox" name="" id="rizAsnadDaryaftCheckBox" class="form-check-input" checked> &nbsp; &nbsp;
                                                <span> ریز اسناد دریافت </span>&nbsp;
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-2 text-start">
                                                <input type="checkbox" name="" id="rizAsnadPardakhtCheckBox" class="form-check-input" checked> &nbsp; &nbsp;
                                                <span> ریز اسناد پرداخت </span>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="border rounded p-2 text-start">
                                        <div class="mb-2">
                                            <input type="radio" onchange="showCustomerGardish(this,this.id)" name="customerGardishRadio" class="form-check-input" id="showCompeleteReportRadio" checked> &nbsp;
                                            <span> نمایش کامل گزارش </span>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" onchange="showCustomerGardish(this,this.id)" name="customerGardishRadio" id="showFromLastZeroRemainReportRadio" class="form-check-input"> &nbsp;
                                            <span> نمایش گزارش از آخرین مانده صفر به بعد </span>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" onchange="showCustomerGardish(this,this.id)" name="customerGardishRadio" id="showFromLastControlledReportRadio" class="form-check-input"> &nbsp;
                                            <span>نمایش گزارش از آخرین رکورد کنترل شده به بعد</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-end">
                                        <button onclick="renewCustomerGardish()" class="btn-sm btn btn-success text-warning"> اجرا <i class="fa-history fa"></i> </button>
                                        <button class="btn-sm btn btn-success text-warning"><i class="fa-print fa"></i></button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-2">
                        <div class="text-end">
                            <button class="btn-sm btn btn-danger text-warning"> حذف تمامی کنترل های انجام شده <i class="fa-trash fa"></i> </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="resizableTable table table-striped table-bordered table-sm" style="height:calc(100vh - 266px)" id="customerCirculationTable">
                        <thead class="tableHeader">
                            <tr>
                                <th id="customerCirculation-1"> تاریخ </th>
                                <th id="customerCirculation-2" class=" RizAsnad"> کد کالا </th>
                                <th id="customerCirculation-3"> شرح عملیات </th>
                                <th id="customerCirculation-4" class=" RizAsnad"> واحد کالا </th>
                                <th id="customerCirculation-5" class=" RizAsnad">  تعداد </th>
                                <th id="customerCirculation-6" class=" RizAsnad">  نرخ </th>
                                <th id="customerCirculation-7" class=" RizAsnad">  % </th>
                                <th id="customerCirculation-8">  مبلغ </th>
                                <th id="customerCirculation-9"> تسویه با </th>
                                <th id="customerCirculation-10"> بستانکار </th>
                                <th id="customerCirculation-11"> بدهکار </th>
                                <th id="customerCirculation-12"> وضعیت </th>
                                <th id="customerCirculation-13" class=" d-none"> وضعیت </th>
                                <th id="customerCirculation-14"> مانده </th>
                            </tr>
                        </thead>
                        <tbody id="customerGardishListBody" class="">
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
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>