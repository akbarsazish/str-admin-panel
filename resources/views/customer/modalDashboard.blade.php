<style>
   
    .headerList a.active { 
        background-color: #efbf35 !important;
        color: #198754 !important;
        font-weight:bold;
        border: 1px solid #fffffc;
    }

    .headerList a { 
        background-color: #056a43!important;
        color: #fff !important;
        font-size:12px;
    }


    .modal-backdrop {
      /* bug fix - no overlay */    
      display: none;    
}

.modal{
    /* bug fix - custom overlay */   
    background-color: rgba(10,10,10,0.45);
}


.inputGroupText {
    border: 1px solid #11c741;
    border-radius: 3px !important;
}

input[readonly] {
    background-color: #fff !important;
    box-shadow: #41824c 1px 1px 1px 1px;
}

</style>

<div class="modal fade notScroll" style="height:100vh !important;" id="customerDashboard" tabindex="1"  data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-success py-1 text-white">
            <h5 class="modal-title" id="customerName">   </h5>
            <button type="button" class="btn-close btn-danger m-1" style="background-color:red;" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="height:90vh !important; ">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text inputGroupText px-2" id="inputGroup-sizing-sm"> کاربری </span>
                                </div> &nbsp;
                                <input type="text" class="form-control form-control-sm inputfield text-danger" id="customerCode" value="" readonly>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 px-1">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text inputGroupText px-2" id="inputGroup-sizing-sm">  شماره تماس  </span>
                                </div> &nbsp;
                                <input class="form-control form-control-sm inputfield" type="text" id="mobile1" readonly>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text inputGroupText px-2" id="inputGroup-sizing-sm"> آدرس   </span>
                                </div> &nbsp; 
                                <input type="text" class="form-control form-control-sm inputfield" id="customerAddress" value="" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 px-1">
                            <div class="input-group input-group-sm mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text inputGroupText px-2" id="inputGroup-sizing-sm"> تعداد ف </span>
                                </div>&nbsp;
                                <input type="text" class="form-control form-control-sm inputfield text-center p-1 text-danger" id="countFactor" readonly>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <fieldset class="border rounded" style="margin-top:-15px; padding:2px; border:2px solid #41824c !important;">
                        <legend  class="float-none w-auto legendLabel m-0 p-0"> یاداشت</legend>
                        <textarea class="form-control m-0 p-0" id="customerProperty" onblur="saveCustomerCommentProperty(this)" rows="4" style="background-color:blanchedalmond"></textarea>
                    </fieldset>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 mx-0 px-1">
                    <span class="fw-bold fs-4"  id="dashboardTitle" style="display:none;"></span>
                    <form action="https://starfoods.ir/crmLogin" target="_blank"  method="get">
                        <input type="text" class="customerSnLogin" style="display:none" name="psn" />
                        <button class="btn btn-sm btn-success" type="submit"> ورود جعلی  </button>
                        <input type="text"  style="display: none" name="otherName" value="{{trim(Session::get('username'))}}" />
                    </form>
                </div>
            </div>
            <div class="c-checkout p-1 mt-1" style="background-color: #43bfa3; border-radius:10px 10px 5px 5px; padding-bottom:1px">
                <div class="col-sm-12 px-0 mx-0">
                    <ul class="header-list headerList nav nav-tabs px-0 mx-0" data-tabs="tabs">
                        <li class="dashboard-tab">
                            <a class="active" data-toggle="tab"  href="#sentFactors"> فاکتور های ارسال شده </a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#buyedKala">  کالاهای خریداری شده </a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#userLoginInfo1"> کالاهای سبد خرید</a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#customerLoginInfo">ورود به سیستم</a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#returnedFactors1"> فاکتور های برگشت داده </a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#comments"> کامنت ها </a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#assesments"> نظرسنجی ها</a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#lotteryAndTakhfifCase"> جوایز و تخفیف ها</a>
                        </li>
                        <li class="dashboard-tab">
                            <a data-toggle="tab"  href="#awareMe"> خبرم کنید </a>
                        </li>
                    </ul>
                </div>
                <div class="c-checkout tab-content" style="margin-bottom:-15px !important">
                        <div class="row c-checkout rounded-3 tab-pane active" id="sentFactors" >
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th> نام راننده</th>
                                        <th>مبلغ </th>
                                        <th> جزئیات </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="factorTable" style="height: calc(100vh - 275px) !important;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                
                        <div class="row c-checkout rounded-3 tab-pane" id="buyedKala">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th> نام کالا</th>
                                        <th> تعداد فاکتور </th>
                                        <th> رویت فاکتور </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="goodDetail" style="height: calc(100vh - 275px) !important;"> </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <div class="row c-checkout rounded-3 tab-pane" id="userLoginInfo1">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th> نام کالا</th>
                                        <th>تعداد </th>
                                        <th>فی</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="basketOrders" style="height: calc(100vh - 275px) !important;"> </tbody>
                                </table>
                            </div>
                        </div>

                    
                        <div class="row c-checkout rounded-3 tab-pane"  id="customerLoginInfo">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th>نوع پلتفورم</th>
                                        <th>مرورگر</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="customerLoginInfoBody" style="height: calc(100vh - 275px) !important;"> </tbody>
                                </table>
                            </div>
                        </div>

                    
                       <div class="row c-checkout rounded-3 tab-pane" id="returnedFactors1">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th> نام راننده</th>
                                        <th>مبلغ </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="returnedFactorsBody" style="height: calc(100vh - 275px) !important;">
                            
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row c-checkout rounded-3 tab-pane" id="comments">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
										<th> کامنت دهنده </th>
                                        <th  style="width:111px">تاریخ</th>
                                        <th> کامنت</th>
                                        <th> کامنت بعدی</th>
                                        <th style="width:111px"> تاریخ بعدی </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="customerComments" style="height: calc(100vh - 275px) !important;">

                                    </tbody>
                                </table>
                            </div>
                       </div>
                    
                        <div class="row c-checkout rounded-3 tab-pane" id="assesments">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th > ردیف</th>
                                        <th style="width:120px;">تاریخ</th>
                                        <th> کامنت</th>
                                        <th style="width:120px;"> برخورد راننده</th>
                                        <th style="width:120px;"> مشکل در بارگیری</th>
                                        <th style="width:120px;"> کالاهای برگشتی</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tableBody" id="customerAssesments" style="height: calc(100vh - 275px) !important;"> </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <div class="row c-checkout rounded-3 tab-pane" id="lotteryAndTakhfifCase">
                            <div class="col-sm-12 px-0">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف</th>
                                        <th>تاریخ</th>
                                        <th> جایزه یا تخفیف </th>
                                    </tr>
                                    </thead>
                                    <tbody id="lotteryTakhfifList" class="tableBody" style="height: calc(100vh - 275px) !important;">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                      <div class="row c-checkout rounded-3 tab-pane" id="awareMe" >
                        <div class="col-sm-12 px-0">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="tableHeader">
                                <tr>
                                    <th> ردیف </th>
                                    <th> تاریخ </th>
                                    <th> اسم کالا </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="tableBody" id="requestedProductBody" style="height: calc(100vh - 275px) !important;">
                                </tbody>
                            </table>
                        </div>
                     </div>
              </div>
            </div>
        </div>
     </div>
</div>



<!-- Modal -->
<div class="modal fade" id="numberOfFactor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="nuberofFactorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success py-2 text-white">
          <button type="button" class="btn-close text-danger"  id="nuberofFactorLabel" aria-label="Close"></button>
          <h5 class="modal-title"> جزءیات در فاکتورها </h5>
      </div>
      <div class="modal-body p-1">
          <table class="table table-bordered table-striped table-sm">
            <thead class="tableHeader">
                <tr>
                    <th> ردیف </th>
                    <th> تاریخ </th>
                    <th> مقدار/ تعداد </th>
                    <th>فی (تومان ) </th>
                    <th> مبلغ (تومان)  </th>
                </tr>
                </thead>
                <tbody class="tableBody1" id="productFacotrsInfo">
                    
                </tbody>
            </table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

 <!-- Modal for reading comments-->
<div class="modal fade" id="viewComment" tabindex="1"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" class="btn-close bg-danger" id="closeCommentModal" aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLabel">کامنت ها</h5>
            </div>
            <div class="modal-body" >
                <h3 id="readCustomerComment1"></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" >بستن</button>
            </div>
        </div>
    </div>
</div>

<!-- factor details modal -->
<div class="modal fade dragableModal" id="viewFactorDetail"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" id="factorDetailsCloseBtn" class="btn-close bg-danger"  aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLabel">جزئیات فاکتور</h5>
            </div>
            <div class="modal-body" id="readCustomerComment">
                <div class="container">
                    <div class="row" style=" border:1px solid #dee2e6; padding:5px">
                            <h4 style="padding:5px; border-bottom: 1px solid #dee2e6; text-align:center;">فاکتور فروش </h4>
                            <div class="factorDetails">
                                <div class="factorDetailsItem"> تاریخ فاکتور : <span id="factorDate"> </span> </div>
                                <div class="factorDetailsItem">  مشتری :  <span id="customerNameFactor"> </span> </div>
                                <div class="factorDetailsItem"> آدرس : <span id="customerAddressFactor">  </span> </div>  
                                <div class="factorDetailsItem"> تلفن : <span id="customerPhoneFactor">  </span> </div>
                                <div class="factorDetailsItem"> کاربر : <span id="Admin">  </span> </div>
                                <div class="factorDetailsItem"> شماره فاکتور : <span id="factorSnFactor">  </span> </div>   
                            </div>
                        </div>
                        <div class="row">
                            <table id="strCusDataTable"  class='table table-bordered homeTables px-0'>
                                <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام کالا </th>
                                    <th>تعداد/مقدار</th>
                                    <th>واحد کالا</th>
                                    <th>فی (تومان)</th>
                                    <th>مبلغ (تومان)</th>
                                    <th> </th>
                                    
                                </tr>
                                </thead>
                                <tbody class="tableBody" id="productList">
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


