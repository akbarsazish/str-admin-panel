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
                    <button type="button" class="btn btn-success btn-sm topButton" onclick="openBargiriModal()">بارگیری فاکتور ها<i class="fa fa-send"></i> </button>
                    {{-- <button type="button" class="btn btn-success btn-sm topButton" disabled data-toggle="modal" data-target="#orderReport">  گزارش سفارش   &nbsp; <i class="fa fa-list"></i> </button> --}}
                    @endif
                    <span class="situation">
                        <fieldset class="border rounded">
                            <form action="{{url("/filterFactors")}}" method="get" id="filterFactorsForm">
                                @csrf
                            <legend  class="float-none w-auto legendLabel mb-0">وضعیت</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="bargiryYes" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio"> بارگیری  شده </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="tasviyehYes" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio"> تسویه شده </label>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-check">
                                            <input class="form-check-input float-start" type="checkbox" name="bargiryNo" id="sefNewOrderRadio" checked>
                                            <label class="form-check-label ms-3" for="sefNewOrderRadio">بارگیری نشده</label>
                                        </div> 

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
                            <button type="submit" class="btn btn-success btn-sm topButton"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                        </form>
                        </fieldset>
                    </span>
            </fieldset>
        </div>
        <div class="col-sm-10 col-md-10 col-sm-10 contentDiv">
            <div class="row contentHeader"> 
                <div class="col-lg-12 text-end mt-1 actionButton">
                </div>
            </div>
            <div class="row mainContent table-responsive">
                <table class="table table-hover table-bordered table-sm factorTable" id="factorTable">
                    <thead style="width:100%;">
                        <tr class="bg-success factorTableHeadTr">
                            <th> ردیف </th>
                            <th> شماره  </th>
                            <th> تاریخ </th>
                            <th> توضحیات </th>
                            <th> کد مشتری </th>
                            <th> نام مشتری </th>
                            <th > مبلغ فاکتور </th>
                            <th> مبلغ دریافتی </th>
                            <th> تنظیم کننده </th>
                            <th > نحوه پرداخت </th>
                            <th> بازاریاب </th>
                            <th> از انبار  </th>
                            <th> تعداد چاپ </th>
                            <th> پورسانت بازاریاب </th>
                            <th> بارگیری </th>
                            <th> مبلغ تخفیف </th>
                            <th> واحد فروش  </th>
                            <th> تاریخ اعلام به انبار </th>
                            <th> ساعت اعلام به انبار  </th>
                            <th> تاریخ بارگیری  </th>
                            <th> ساعت بارگیری  </th>
                            <th> شماره بار نامه  </th>
                            <th> ساعت ثبت  </th>
                            <th> از سفارش  </th>
                            <th> شماره بارگیری </th>
                            <th> تحویل به راننده </th>
                            <th> نام راننده </th>
                          
                        </tr>
                    </thead>
                    <tbody id="factorListBody" class="factorTableBody">
                        @foreach($factors as $factor)
                            <tr class="factorTablRow" @if(($factor->NetPriceHDS!=$factor->payedAmount)and($factor->NetPriceHDS>$factor->payedAmount)) style="background-color:rgb(232, 22, 144)" @endif onclick="getFactorOrders(this,{{$factor->SerialNoHDS}})">
                                <td> {{$loop->iteration}} </td>
                                <td> {{$factor->FactNo}} </td>
                                <td> {{$factor->FactDate}} </td>
                                <td> {{$factor->FactDesc}} </td>
                                <td> {{$factor->PCode}} </td>
                                <td> {{$factor->Name}} </td>
                                <td> {{number_format($factor->NetPriceHDS)}} </td>
                                <td> {{number_format($factor->payedAmount)}} </td>
                                <td> {{$factor->setterName}} </td>
                                <td> حضوری </td>
                                <td>  </td>
                                <td> {{$factor->stockName}} </td>
                                <td> {{$factor->CountPrint}} </td>
                                <td> {{number_format($factor->TotalPricePorsant)}} </td>
                                <td> @if($factor->bargiriNo) شده @else نشده @endif  </td>
                                <td> {{$factor->takhfif}} </td>
                                <td> @if($factor->SnUnitSales>0) {{$factor->SnUnitSales}} @else  @endif </td>
                                <td> {{$factor->DateEelamBeAnbar}} </td>
                                <td> {{$factor->TimeEelamBeAnbar}} </td>
                                <td> {{$factor->DateBargiri}} </td>
                                <td> {{$factor->TimeBargiri}} </td>
                                <td> {{$factor->BarNameNo}} </td>
                                <td> {{$factor->FactTime}} </td>
                                <td> خیر </td>
                                <td> {{$factor->bargiriNo}} </td>
                                <td> {{$factor->driverTahvilDate}} </td>
                                <td> {{$factor->driverName}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> <hr>
            
                <table class="table table-hover table-bordered table-sm">
                    <thead style="font-size:11px;">
                        <tr>
                         <th> ردیف </th>
                         <th> کد کالا </th>
                         <th style="width:160px;"> نام کالا </th>
                         <th> واحد کالا </th>
                         <th> بسته بندی </th>
                         <th> مقدار بسته  </th>
                         <th> مقدار کالا </th>
                         <th>  تخفیف %  </th>
                         <th> نرخ </th>
                         <th> نرخ بسته </th>
                         <th> مبلغ  </th>
                         <th> مبلغ تخفیف  </th>
                         <th> شرح کالا </th>
                         <th> وضعیت بارگیری </th>
                         <th> بار میکروبی </th>
                        </tr>
                    </thead>
                    <tbody id="FactorDetailBody" class="tableBody" style="height:188px ! important; overflow-y: scroll;">
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

<div class="modal" tabindex="-1" id="bargiriModal">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header bg-info">
            <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close"> </button>
            <h5 class="modal-title"> بارگیری فاکتورها </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <div class="row" style="height: 40vh">
                        <div>
                        <button class="btn btn-sm btn-success"> نمایش کالاهای برگشتی </button>
                        </div>
                    </div>
                    <div class="row" style="height: 40vh">
                        <div>
                        <button onclick="addFactorToBargiri()" class="btn btn-sm btn-success mb-2"> افزودن <i class="fa fa-add"></i></button>
                        <button disabled onclick="editFactorsOfBargiri(this.value)" id="editDriverFactorBtn" class="btn btn-sm btn-success mb-2"> اصلاح <i class="fa fa-edit"></i></button>
                        <button disabled onclick="deleteFactorsOfBargiri(this.value)" class="btn btn-sm btn-success mb-2" id="deletDriverFactorBtn"> حذف <i class="fa fa-trash"></i></button>
                        <button class="btn btn-sm btn-success mb-2" style="width:200px;"> چاپ لیست فاکتورها <i class="fa fa-print"></i></button>
                        <button class="btn btn-sm btn-success mb-2" style="width:200px;"> چاپ لیست کالاها <i class="fa fa-print"></i></button>
                        <button class="btn btn-sm btn-success mb-2" style="width:200px;"> چاپ تکی فاکتورها <i class="fa fa-print"></i></button>
                        <button class="btn btn-sm btn-success mb-2" style="width:200px;"> چاپ هرسه مورد بالا <i class="fa fa-print"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row border p-2" id="driversDiv">
                        <table class="table table-hover table-bordered table-sm factorBargiriTable" id="bargiriDriverTable">
                            <thead style="width:100%;">
                                <tr>
                                <th> ردیف </th>
                                <th> شماره </th>
                                <th> تاریخ </th>
                                <th> نام راننده </th>
                                <th> شماره ماشین </th>
                                <th> توضحیات  </th>
                                </tr>
                            </thead>
                            <tbody id="bargiriDriverListBody">
                                @foreach($todayDrivers as $driver)
                                <tr onclick="getDriverFactors(this,{{$driver->SnMasterBar}})">
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$driver->NoPaper}} </td>
                                    <td> {{$driver->DatePeaper}} </td>
                                    <td> {{$driver->driverName}} </td>
                                    <td> {{$driver->MashinNo}} </td>
                                    <td> {{$driver->DescPeaper}} <input type="radio" style="display:none" value="{{$driver->SnMasterBar}}"/>  </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                    <div class="row border p-2" id="factorsDiv">
                        <table class="table  table-hover table-bordered table-sm factorBargiriTable">
                            <thead  style="width:100%;">
                                <tr  class="bg-success factorTableHeadTr">
                                <th> ردیف </th>
                                <th> شماره فاکتور  </th>
                                <th> تاریخ فاکتور </th>
                                <th> کد مشتری  </th>
                                <th> نام مشتری </th>
                                <th> مبلغ  </th>
                                <th> توضحیات  </th>
                                <th> نقد  </th>
                                <th> کارت </th>
                                <th> واریز به حساب </th>
                                <th> تخفیف </th>
                                <th> تفاوت  </th>
                                <th> آدرس </th>
                                <th> تلفن </th>
                                </tr>
                            </thead>
                            <tbody id="bargiriFactorLisBody">
                            </tbody>
                        </table>                
                    </div>
                    <hr/>
                    <div class="row border p-2" id="goodsDiv">
                        <table class="table  table-hover table-bordered table-sm factorBargiriTable">
                            <thead  style="width:100%;">
                                <tr  class="bg-success factorTableHeadTr">
                                <th> ردیف </th>
                                <th> کد کالا   </th>
                                <th> نام کالا  </th>
                                <th> مقدار کل  </th>
                                <th>   نام واحد کل </th>
                                <th>  مقدار جزء </th>
                                <th> واحد جزء  </th>
                                <th> مقدار کالا  </th>
                                <th> وزن </th>
                                <th> تعداد فاکتور </th>
                                </tr>
                            </thead>
                            <tbody id="bargiriKalaLisBody">
                            </tbody>
                        </table>                
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
  <div class="modal" tabindex="1" id="addFactorToBargiriModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title">بارگیری</h5>
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
                                <div><button type="button" class="btn btn-success btn-sm mb-1" onclick="searchFactorForAddToBargiri()">انتخاب فاکتور <i class="fa fa-check"></i> </button></div>
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
                                <div><button class="btn btn-sm btn-success" type="button" id="addModalEditFactorBtn" onclick="openEditFactorModal(this.value)"> اصلاح فاکتور </button></div>
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
                                    <button type="submit" class="btn btn-success btn-sm mb-1"> ثبت <i class="fa fa-save"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm mb-1" onclick="cancelAddingFactorToBargiri()"> انصراف <i class="fa fa-cancel"></i></button>
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
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-success">
                            <tr class="bg-success factorTableHeadTr">
                                <th > ردیف </th>
                                <th > شماره فاکتور </th>
                                <th > تاریخ فاکتور </th>
                                <th > کد مشتری </th>
                                <th > نام مشتری </th>
                                <th > مبلغ </th>
                                <th > نقد </th>
                                <th > کارت خوان </th>
                                <th > واریز به حساب </th>
                                <th > تخفیف </th>
                                <th > تفاوت دریافتی </th>
                                <th > توضحیات </th>
                                <th > آدرس </th>
                                <th > تلفن </th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">بارگیری</h5>
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
                                            <span class="input-group-text" >  شماره برگه </span>
                                            <input type="text"  name="NoPaper" id="bargiriPaperNoEdit" class="form-control form-control-sm mb-1"  placeholder="تایخ برگه ">
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text" >  تاریخ برگه </span>
                                            <input type="text"  name="DatePaper" id="bargiriPaperDateEdit" class="form-control form-control-sm mb-1"  placeholder="تایخ برگه ">
                                        </div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <input type="text" name="SnMasterBar" id="SnMasterBarEdit">
                                            <span class="input-group-text" >  نام راننده </span>
                                            <select  name="factorDriver" id="factorDriverEdit" class="form-select">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div><button class="btn btn-success btn-sm mb-1" type="button" onclick="searchFactorForAddToBargiriEdit()">انتخاب فاکتور <i class="fa fa-check"></i> </button></div>
                                        <div class="input-group input-group-sm mb-1 filterItems">
                                            <span class="input-group-text">  شماره ماشین </span>
                                            <input type="text" name="MashinNo" class="form-control form-control-sm" id="mashinNoEdit" placeholder="شماره ماشین ">
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-1 filterItems">
                                        <span class="input-group-text"> توضیحات </span>
                                        <input type="text"  name="DescPeaper" class="form-control form-control-sm" id="paperdescEdit"  placeholder=" توضیحات ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div><button class="btn btn-sm btn-success" type="button" id="editModalEditFactorBtn" onclick="openEditFactorModal(this.value)"> اصلاح فاکتور </button></div>
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
                                            <button disabled type="submit" id="bargiriFactorsEditBtn" class="btn btn-success btn-sm mb-1"> ثبت <i class="fa fa-save"></i></button>
                                            <button onclick="cancelBargiriFactorEdit()" type="button" class="btn btn-danger btn-sm mb-1"> انصراف <i class="fa fa-cancel"></i></button>
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
                            <table class="table table-striped table-bordered table-sm">
                                <thead class="bg-success">
                                    <tr class="bg-success factorTableHeadTr">
                                        <th > ردیف </th>
                                        <th > شماره فاکتور </th>
                                        <th > تاریخ فاکتور </th>
                                        <th > کد مشتری </th>
                                        <th > نام مشتری </th>
                                        <th > مبلغ </th>
                                        <th > نقد </th>
                                        <th > کارت خوان </th>
                                        <th > واریز به حساب </th>
                                        <th > تخفیف </th>
                                        <th > تفاوت دریافتی </th>
                                        <th > توضحیات </th>
                                        <th > آدرس </th>
                                        <th > تلفن </th>
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
        <div class="modal-header bg-info">
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                                    <input type="checkbox" id="selectAllFactorsForBarigiCheckbox" class="form-check-input">
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <button class="btn btn-sm btn-success mb-1" onclick="addSelectFactorsToBargiri()"> انتخاب <i class="fa fa-select"></i> </button>
                                    <button class="btn btn-sm btn-danger mb-1" onclick="cancelAddingSearchedFactorToBargiri()"> انصراف <i class="fa fa-cancel"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <table class="table table-hover table-bordered table-sm factorBargiriTable" id="factorsMantiqaTable">
                            <thead>
                                <tr class="bg-success factorTableHeadTr">
                                    <th>شماره</th>
                                    <th>منطقه</th>
                                    <th>تعداد فاکتور</th>
                                </tr>
                            </thead>
                            <tbody id="factorsMantiqasBodyList">
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
  
<div class="modal" tabindex="1" id="searchFoactorForAddToBargiriModalEdit">
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
                                        <button class="btn btn-sm btn-success mb-1" onclick="addSelectFactorsToBargiriEdit()"> انتخاب <i class="fa fa-select"></i> </button>
                                        <button class="btn btn-sm btn-danger mb-1" onclick="cancelAddingSearchedFactorToBargiriEdit()"> انصراف <i class="fa fa-cancel"></i> </button>
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
<div class="modal" id="editFactorModal" tabindex="1">
    <input type="hiden" id="rowTaker">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info" >
                <h5 class="modal-title"> اصلاح فاکتور </h5>
            </div>
            <div class="modal-body">
                <form action="{{url("/doEditFactor")}}" method="post" id="editFactorForm">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > شماره فاکتور </span>
                                    <input type="text"  name="FactNoEdit" id="FactNoEdit" class="form-control form-control-sm mb-1">
                                </div>
                                <input type="hidden" id="customerForSefarishId">
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
                                    <span class="input-group-text" > تاریخ </span>
                                    <input type="text" class="form-control" name="FactDateEdit" id="FactDateEdit">
                                    <select name="" id="customerForFactorEdit">

                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > خریدار </span>
                                    <input type="text" class="form-control" name="pCodeEdit" id="pCodeEdit">
                                    <input type="text" class="form-control" name="NameEdit" id="NameEdit">
                                    <button type="button" class="btn btn-info">گردش حساب</button>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > بازاریاب </span>
                                    <input type="text" class="form-control" name="bazaryabCodeEdit" id="bazaryabCodeEdit">
                                    <input type="text" class="form-control" name="bazaryabNameEdit" id="bazaryabNameEdit">
                                    <button  type="button" class="btn btn-info"> ... </button>
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
                                <div  id="factorAddressDivEdit" style="display: none">
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > آدرس </span>
                                    <input type="text"  id="MotafariqahAddressEdit" class="form-control">
                                </div>
                                </div>
                                <div class="input-group input-group-sm mb-1 filterItems">
                                    <span class="input-group-text" > توضحیات </span>
                                    <input type="text" class="form-control" name="ّFactDescEdit" id="ّFactDescEdit">
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
                                            <option >  </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> گردش کالا </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> گردش شخص </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> اصلاح کالا </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> اصلاح شخص </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> ده خرید آخر </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> ده فروش آخر </button>
                                    <button type="button" class="btn btn-sm btn-success mb-2"> سفارشات ارسال نشده </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <label class="form-label"> کرایه دریافت شد </label>
                                    <input type="checkbox" class="form-check-input" name="ّtakeKerayahEdit" id="ّtakeKerayahEdit">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-success"> ثبت </button>
                                    <button type="button" onclick="cancelEditFactor()" class="btn btn-sm btn-danger"> انصراف </button>
                                </div>
                                <div>
                                    <div class="col-lg-12" style="background-color:#e0e0e0;">
                                        <span class="description"> موجودی انبار : <b id="firstEditExistInStock">0</b></span> <br>
                                        <span class="description">  قیمت فروش : <b id="firstEditPrice">0</b></span> <br>
                                        <span class="description"> اخرین قیمت فروش به این مشتری : <b id="firstEditLastPriceCustomer">0</b></span> <br>
                                        <span class="description"> آخرین قیمت فروش :  <b id="firstEditLastPrice">0</b> </span>
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
                                        <th>  نرخ واحد </th>
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
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
                        <button type="button" disabled id="searchCustomerSabtBtn" onclick="chooseCustomerForّFactorEdit(this.value)"  class="btn btn-success btn-sm"> انتخاب <i class="fa fa-check"></i> </button>
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

<div class="modal fade dragAbleModal" id="searchGoodsModalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1">
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
                            <button type="button" class="btn d-block w-100 mt-1 btn-sm btn-success" id="selectKalaToFactorBtn"> انتخاب  <i class="fa fa-history"></i> </button> 
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
@endsection
