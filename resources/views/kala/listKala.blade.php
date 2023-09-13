
@extends('admin.layout')
@section('content')
<style>
    .requestedKalaStaff, .fastKalaStaff, .pishKaridStaff, .brandStaff, .alarmedKalaStaff, .kalaCategoryStaff{
        display:none;
    }
    #addKalaToBrand, #addKalaToGroup{
        display:none;
    }
.checkBoxStyle {
    background-color:#00895a;
    border:1px solid black;
    padding:10px;
    border-radius:100% !important;
}
.styleForLabel {
    font-size:12px;
}
.modalTitle{
    font-size: 12px;
}
</style>
   <div class="modalBackdrop">
        <div id='unitStuffContainer' class="alert alert-danger" style="max-width: 200px; background-color: #ffffff66; padding: 5px; width: 100%; max-height: 85vh; overflow: auto;">
        </div>
    </div>
 @php
    $allGroups=count($mainGroups);
@endphp

    <div class="container-fluid containerDiv">  
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> انتخاب </legend>
                       @if(hasPermission(Session::get("adminId"),"kalaListsN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="kalaListRadio" checked>
                            <label class="form-check-label me-4" for="assesPast"> لیست کالاها  </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"requestedKalaN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="customerRequestRadio">
                            <label class="form-check-label me-4" for="assesPast"> در خواست مشتریان </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"fastKalaN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="fastKalaRadio">
                            <label class="form-check-label me-4" for="assesPast"> فست کالا </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"pishKharidN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="pishKharidRadio">
                            <label class="form-check-label me-4" for="assesPast"> پیش خرید  </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"brandsN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="brandsRadio">
                            <label class="form-check-label me-4" for="assesPast"> برند ها  </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"alertedN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="alarmedKalaListRadio">
                            <label class="form-check-label me-4" for="assesPast"> لیست شامل هشدار </label>
                        </div>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"kalaGroupN") > -1)
                        <div class="form-check">
                            <input class="form-check-input p-2 float-start" type="radio" name="settings" id="categorykalaRadio">
                            <label class="form-check-label me-4" for="assesPast"> دسته بندی کالا </label>
                        </div>
                        @endif

                        <div class="col-sm-12 listkalarStaff">
                            <div class="form-group">
                                <div class="input-group  input-group-sm">
                                    <span class="input-group-text">اسم یا کد کالا</span>
                                    <input type="text" id="searchKalaNameCode"  class="form-control form-control-sm" autocomplete="off"  placeholder="اسم یا کد کالا" id="searchKalaNameCode">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="form-group">
                                <div class="input-group input-group-sm mt-1">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">گروه اصلی</span>
                                    <select name="original" class="form-select" id="superGroup"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="form-group">
                                <div class="input-group input-group-sm mt-1">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">گروه فرعی</span>
                                    <select name="subGroups" class="form-select" id="subGroup">
                                    <option value="">همه</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm">انبار</span>
                                <select class="form-select form-select-sm" id="searchKalaStock">
                                    <option value="0" selected>همه</option>
                                    @foreach ($stocks as $stock)
                                    <option value="{{$stock->SnStock}}">{{trim($stock->NameStock)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm">فعال</span>
                                <select class="form-select form-select-sm" id="searchKalaActiveOrNot">
                                    <option value="" > همه </option>
                                    <option value="0"> فعال </option>
                                    <option value="1"> غیر فعال </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm">موجودی</span>
                                <select class="form-select form-select-sm" id="searchKalaExistInStock">
                                    <option value="-1">همه</option>
                                    <option value="0"> موجودی صفر </option>
                                    <option value="1"> موجودی عدم صفر </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm"> از تاریخ خرید </span>
                                <input type="text" class="form-control" id="assesFirstDate">
                            </div>
                        </div>
                        <div class="col-sm-12 listkalarStaff">                        
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm"> تا تاریخ  خرید</span>
                                <input type="text" class="form-control" id="assesSecondDate">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 mb-1 listkalarStaff">
                            <button type="button" class="btn btn-success btn-sm topButton"  onclick="filterAllKala()" > بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                        </div>
                         <div class="col-sm-12 requestedKalaStaff">
                            <input type="text" onkeyup="searchRequestedKala(this)" class="form-control form-control-sm" id="allKalaFirst" placeholder="جستجو">
                        </div>

                         <div class="col-sm-12 brandStaff">
                             <input type="text" class="form-control form-control-sm" id="mainGroupSearch" autocomplete="off" name="search_mainPart" placeholder="جستجو">
                        </div>

                        <div class="col-sm-12 pishKaridStaff">
                             <span class="select-label"> وضعیت پیش خرید </span>
                             <select class="form-select form-select-sm" onchange="showPishKharidStates(this,this.value)" aria-label=".form-select-sm example">
                                <option value="1"> ارسال شده  </option>
                                <option value="2"> داخل سبد </option>
                            </select>
                        </div>
                    
                </fieldset>
            </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">
                    <div class="col-lg-12 text-end mt-1">
                        <span class="listkalarStaff">
                               @if(hasPermission(Session::get("adminId"),"kalasN") > -1)
                                 <button class="kala-btn btn btn-success btn-sm text-warning " disabled id="openEditKalaModal"> ویرایش <i class="fal fa-edit" aria-hidden="true"></i></button>
                               @endif
                            <input type="text" class="form-control" value="" id="kalaIdForEdit1" style="display:none;">
                            <form action="{{url('/editKala')}}" method="POST" style="display: inline;">
                                @csrf
                                <input type="text"  name="kalaId" class="form-control" value="" id="kalaIdForEdit" style="display:none;">
                                @if(hasPermission(Session::get( 'adminId'),'kalaListsN' ) > -1)
                                    <button type="button" id="openViewTenSalesModal" disabled class="kala-btn btn btn-success btn-sm text-warning">ده فروش آخر<i class="fal fa-history" aria-hidden="true"></i></button>
                                @endif
                                @if(hasPermission(Session::get( 'adminId'),'kalaListsN' ) > 1)
                                    <button type="button" data-toggle="modal"  onclick="openChangePriceModal()"  disabled class="kala-btn btn btn-success btn-sm text-warning"> تغییر قیمت <i class="fal fa-exchange-alt" aria-hidden="true"></i></button>
                                @endif
                            </form>
                             @if(hasPermission(Session::get( 'adminId'),'kalaListsN' ) > 0)
                                <button type="#" id="editKalaList" disabled class="kala-btn btn btn-success btn-sm text-warning"> ارسال به اکسل  <i class="fal fa-file-excel" aria-hidden="true"></i></button>
                                @endif
                            </span>
                             <!-- بتن های مربوط کلای پیش خرید -->
                            <span class="pishKaridStaff">
                                @if(hasPermission(Session::get("adminId"),"pishKharidN") > 0)
                                    <button disabled id="submitFactorToAppButton" name="action" value="sendToApp" class="btn btn-sm btn-success pishKaridStaff" type="submit" form="pishKharidFormId">ارسال به پشتیبان فروش</button>
                                @endif 
                                @if(hasPermission(Session::get("adminId"),"pishKharidN") > 1)
                                    <button disabled id="submitDeleteFactorButton" name="action" value="delete" class="btn btn-sm btn-danger pishKaridStaff" type="submit" form="pishKharidFormId">حذف </button>
                                @endif   
                            </span>
                            <!-- brand staff  -->
                            <span class="brandStaff">
                                @if(hasPermission(Session::get("adminId"),"brandsN") > 1)
                                    <button   class="btn btn-success btn-sm" id="newBrandBtn">جدید <i class="fa fa-plus" aria-hidden="true"></i></button>
                                @endif
                                @if(hasPermission(Session::get("adminId"),"brandsN") > 0)
                                    <button type="button" value="Reterive data" class="btn btn-success btn-sm text-white" id="editBrandBtn"> ویرایش  <i class="fa fa-edit" aria-hidden="true"></i></button>
                                @endif
                                <form action="{{ url('/deleteBrand') }}" id="deleteBrandForm" onsubmit="return confirm('میخوهید حذف کنید?');" method='post' style=" margin:0; padding:0; display: inline !important;">
                                    @csrf
                                    @if(hasPermission(Session::get("adminId"),"brandsN") > 1)
                                    <button type="submit" disabled id="deleteBrand" onclick="swal();" class="btn btn-danger btn-sm"> حذف <i class="fa fa-trash" aria-hidden="true"></i></button>
                                    @endif
                                    <input type="text" value="" id="deleteBrandId" name="brandId" style="display:none"/>
                                </form>
                                 @if(hasPermission(Session::get("adminId"),"brandsN") > 1)
                                  <button class='btn btn-success btn-sm brandStaff d-inline' id="brandChagesSaveBtn" form="brandChagesForm" type="submit" disabled>ذخیره <i class="fa fa-save"></i></button>
                                @endif 
                            </span>

                            <!-- بتن های مربوط به دسته بندی گروپ اصلی -->
                            <div class="row">
                             <span class="kalaCategoryStaff col-lg-6 text-center">
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 1)
                                        <button style="margint:0" class="btn btn-success btn-sm buttonHover" id="addNewMainGroupBtn"> جدید <i class="fa fa-plus " aria-hidden="true"></i></button> &nbsp;
                                    @endif
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 0)
                                        <button type="button" value="Reterive data" class="btn btn-success btn-sm text-white editButtonHover"
                                    onclick="getGroupId()" data-toggle="modal" id="editGroupList">ویرایش<i class="fa fa-edit " aria-hidden="true"></i></button> &nbsp;
                                    @endif

                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 1)
                                    <button type="submit" disabled id="deleteGroupList" form="deleteAMainGroup" class="btn btn-danger btn-sm buttonHoverDelete">حذف <i class="fa fa-trash " aria-hidden="true"></i></button> 
                                    @endif
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 0)
                                    <Button  id="topGroup"  type="button" value="top" onclick="changeMainGroupPriority(this)" style="background-color:transparent;" ><i class="fa-solid fa-circle-chevron-up fa-xl chevronHover"></i></Button>
                                    <Button  id="downGroup"  type="button" value="down" onclick="changeMainGroupPriority(this)" style="background-color:transparent;" ><i class="fa-solid fa-circle-chevron-down fa-xl chevronHover"></i></Button>
                                    @endif
                             </span>

                             <span class="kalaCategoryStaff col-lg-6  text-center">
                                    <!-- بتن های مربوط دسته بندی گروپ فرعی  -->
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 1)
                                        <button class="btn btn-success btn-sm buttonHover" onclick="addNewSubGroup()" disabled  id="addNewSubGroupButton" > جدید <i class="fa fa-plus " aria-hidden="true"></i></button> &nbsp;
                                    @endif
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 0)
                                        <button  class="btn btn-success btn-sm text-white editButtonHover" disabled id="editSubGroupButton" > ویرایش <i class="fa fa-edit " aria-hidden="true"></i></button> &nbsp;
                                    @endif
                                    <form action='{{ url('/deleteSubGroup') }}' id="deleteSubGroupForm" method='post'  onsubmit="return confirm('میخوهید حذف کنید?');" style=" margin:0; padding:0; display: inline;"> 
                                        @csrf
                                        @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 1)
                                            <button id="deleteSubGroup" disabled class="btn btn-danger btn-sm buttonHoverDelete"> حذف <i class="fa fa-trash " aria-hidden="true"></i></button>
                                        @endif
                                        <input type="text" value="" name="id" style="display: none" id="subGroupIdForDelete"/>
                                        @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 0)
                                        <button onclick="changeSubGroupPriority(this)" value="top"  type="button" style="background-color:transparent;" ><i class="fa-solid fa-circle-chevron-up fa-xl chevronHover"></i></button>
                                        <button onclick="changeSubGroupPriority(this)" value="down"  type="button" style="background-color:transparent;"><i class="fa-solid fa-circle-chevron-down fa-xl chevronHover"></i></button>
                                        <br/>
                                        @endif
                                    </form>
                                    @if(hasPermission(Session::get("adminId"),"kalaGroupN") > 0)
                                        <button class='btn btn-success btn-sm' form="subGroupofSubGroupForm" id="subGroupofSubGrouppBtn" type="submit" disabled> ذخیره  <i class="fa fa-save"></i> </button>
                                    @endif
                              </span>
                           </div>

                        </div>        
                 </div>
                <div class="row mainContent">
                    <table class="table table-bordered table-striped table-sm listkalarStaff" id="listKala">
                            <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th style="width: 222px">اسم</th>
                                        <th>کد</th>
                                        <th>گروه اصلی </th>
                                        <th>آخرین.فروش</th>
                                        <th>بروزرسانی</th>
                                        <th>غیرفعال</th>
                                        <th>قیمت1</th>
                                        <th>قیمت2</th>
                                        <th>موجودی </th>
                                        <th>انتخاب </th>
                                    </tr>
                            </thead>
                            <tbody id='kalaContainer' class="tableBody"> </tbody>
                        </table>

                        <table class="table table-bordered table-sm requestedKalaStaff">
                            <thead class="tableHeader">
                                <tr>
                                    <th class="for-mobil">ردیف</th>
                                    <th>نام کالا</th>
                                    <th width="120"> تعداد درخواست</th>
                                    <th style="width:111px;"> تاریخ </th>
                                    <th style="width:111px;">مشاهده</th>
                                    <th class="text-center">حذف</th>
                                </tr>
                            </thead>
                            <tbody id="requestedKalas" class="tableBody">
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product->GoodName}}</td>
									<td style="width:120px">{{$product->countRequest}}</td>
									<td style="width:111px;">{{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d H:i:s.u',$product->TimeStamp))->format('Y/m/d')}}</td>
                                    <td style="width:111px;"><button type="button" onclick="displayRequestedKala({{$product->GoodSn}})" style=" background-color: #ffffff;">  <i class="fa fa-eye" style="color:green;"> </i>  </button> </td>
                                    <td><button type="button" @if(hasPermission(Session::get( 'adminId'),'requestedKalaN' ) > 1) onclick="removeRequestedKala({{$product->GoodSn}})" @else disabled @endif  class="btn btn-sm"> <i class="fa fa-trash" style="color:red; font-size:18px;"></i> </button></td>
                               </tr>
                            @endforeach
                            </tbody>
                        </table>
                            @php
                              $allGroups=count($mainGroups);
                            @endphp

                        <div class="col-lg-6 px-0 mx-0 fastKalaStaff">
                                    <button type="button" value="Reterive data" class="btn btn-success btn-sm text-white" style="display: none"
                                        onclick="getGroupId()" data-toggle="modal" id="editGroupList" disabled data-target="#editGroup">ویرایش <i class="fa fa-edit " aria-hidden="true"></i></button>
                                    <form action='{{ url('#') }}' onsubmit="return confirm('میخوهید حذف کنید?');" method='post' style=" margin:0; padding:0; display: inline;">
                                        @csrf
                                        <button type="submit" style="display: none" disabled class="btn btn-danger btn-sm">حذف <i class="fa fa-trash " aria-hidden="true"></i></button>
                                        <Button  id="topGroup"  style="display: none"  type="button" value="top" onclick="changeMainGroupPriority(this)" style="background-color:rgb(255 255 255); padding:0;" ><i class="fa-solid fa-circle-chevron-up fa-2x" style=''></i></i></Button>
                                        <Button  id="downGroup"  style="display: none"  type="button" value="down" onclick="changeMainGroupPriority(this)" style="background-color:rgb(255 255 255); padding:0;" ><i class="fa-solid fa-circle-chevron-down fa-2x" style=''></i></i></Button>
                                        <input type="text" value="" id="mianGroupId" style="display: none"/>
                                     <input type="text" class="form-control form-control-sm col-lg-6" id="mainGroupSearchFast" autocomplete="off"  name="search_mainPart" placeholder="جستجو" style="margin: 5px 5px; 0px 0px">
                                    <table class="table table-bordered table-sm" id="tableGroupList">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th>فعال</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody"id="mainGroupListfast" style="height:calc(100vh - 255px) ! important">
                                            @foreach ($mainGroups as $group)
                                                <tr onclick="changePicture(this)">
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $group->title }}</td>
                                                    <td>
                                                        <input class="mainGroupId" type="radio" name="mainGroupId[]" value="{{ $group->id . '_' . $group->title }}" id="flexCheckChecked">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>

                         </div>
                        <div class="col-lg-6 px-0 mx-0 fastKalaStaff">
                                 @if(hasPermission(Session::get("adminId"),"kalasN") > 0)
                                    <button class="btn btn-success btn-sm" onclick="addNewSubGroup()"  style="display: none" disabled  id="addNewSubGroupButton"  data-toggle="modal" data-target="#newSubGroup"> جدید <i class="fa fa-plus " aria-hidden="true"></i></button>
                                    <button  class="btn btn-success btn-sm text-white" disabled id="editSubGroupButton"  style="display: none"  data-toggle="modal" data-target="#editSubGroup"> ویرایش <i class="fa fa-edit " aria-hidden="true"></i></button>
                                @endif
                                        <form action='{{ url('/deleteSubGroup') }}' method='post' onsubmit="return confirm('میخوهید حذف کنید?');" style=" margin:0; padding:0; display: inline;">
                                            @csrf
                                            <button id="deleteSubGroup"  style="display: none" disabled class="btn btn-danger btn-sm"> حذف <i class="fa fa-trash " aria-hidden="true"></i></button>
                                            <input type="text"  value="" name="id" style="display: none" id="subGroupIdForDelete"/>
                                            <button onclick="changeSubGroupPriority(this)"  style="display: none" value="top"  type="button" style="background-color:rgb(255 255 255); padding:0;" ><i class="fa-solid fa-circle-chevron-up fa-2x" style=''></i></i></button>
                                            <button onclick="changeSubGroupPriority(this)"  style="display: none" value="down"  type="button" style="background-color:rgb(255 255 255); padding:0;"><i class="fa-solid fa-circle-chevron-down fa-2x" style=''></i></button>
                                    
                                        </form>
                                    <table id="subGroupTable" class="table-bordered table-sm" style="margin-top:40px" id="tableGroupList">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th >ردیف</th>
                                                <th>گروه فرعی</th>
                                                <th>تصویر</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="subGroup2" style="height:calc(100vh - 255px) !important"></tbody>
                                    </table>
                         </div>

                    <!-- لیست کالا های پیش خرید -->
            <form action="{{url('/sendFactorToApp')}}" method="post" class="px-0 mx-0 pishKaridStaff" id="pishKharidFormId">
                    @csrf
                    <input type="hidden" value="" name="factorNumber" id="factorNumberAfter"/>
                    <input type="hidden" value="" name="csn" id="psn"/>
                   <table class="table table-bordered table-sm">
                            <thead class="tableHeader">
                            <tr>
                                <th>ردیف</th>
                                <th>شماره</th>
                                <th>تاریخ</th>
                                <th> خریدار</th>
                                <th> مبلغ کل</th>
                                <th>انتخاب</th>
                            </tr>
                            </thead>
                            <tbody class="tableBody" id="tablePishKharidFactor" style="height:200px !important;">
                                @foreach ($factors as $factor)
                                    <tr onclick="factorStuff(this)" >
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$factor->OrderNo}}</td>
                                        <td>{{$factor->OrderDate}}</th>
                                        <td>{{$factor->Name}}</td>
                                        <td>{{number_format($factor->allMoney/10)}}</td>
                                        <td>
                                          <input type="radio" value="{{$factor->SnOrderPishKharidAfter.'_'.$factor->CustomerSn}}" 
										  name="selectFactor" class="form-check-input"/>
                                        </td>
                                    </tr>
                               @endforeach
                            </tbody>
		                    <tbody class="tableBody" id="tablePishKharidOrder" style="height:200px !important;display:none !important;">
                                @foreach ($orderPishKharid as $order)
                                    <tr onclick="pishKharidOrderStuff(this)" >
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$order->OrderNo}}</td>
                                        <td>{{$order->OrderDate}}</th>
                                        <td>{{$order->Name}}</td>
                                        <td>{{number_format($order->allMoney/10)}}</td>
                                        <td>
                                          <input type="radio" value="{{$order->SnOrderPishKharid.'_'.$order->CustomerSn}}" name="selectFactor" class="form-check-input"/>
                                        </td>
                                    </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <!-- کالا های درخواستی پیش خرید -->
                         <table class="table table-bordered table-sm">
                                <thead class="tableHeader">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>کد کالا</th>
                                            <th>اسم کالا</th>
                                            <th>واحد کالا</th>
                                            <th>نوع بسته بندی</th>
                                            <th>مقدار سفارش</th>
                                            <th>نرخ</th>
                                            <th>مبلغ</th>
                                            <th>انتخاب</th>
                                        </tr>
                                </thead>
                                <tbody class="tableBody" id="ordersFactorAfter" style="height:190px !important;"></tbody>
                          </table>
                        </form>

                        <!-- جدول مربوط برند  -->
                        <table class="table table-bordered table table-sm brandStaff" id="tableGroupList">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>برند </th>
                                        <th>فعال</th>
                                    </tr>
                                </thead>
                        <tbody class="c-checkout tableBody" id="mainGroupList" style="height:190px !important;">
                            @foreach ($brands as $brand)
                                <tr onclick="setBrandStuff(this)">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$brand->name}}</td>
                                    <td>
                                        <input class="mainGroupId" type="radio" name="mainGroupId[]" value="{{$brand->id.'_'.$brand->name}}" id="flexCheckChecked">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <div class="row px-0 mx-0 " id="addKalaToBrand" style="border-top:1px dotted #43bfa3;">
                        <div class="col-sm-5 brandStaff">
                            <input type="text" class="form-control form-control-sm" id="serachKalaForBrand"  placeholder="جستجو"> 
                                <table class="table table-bordered table-sm">
                                    <thead class="tableHeader">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>اسم </th>
                                            <th>
                                               <input type="checkbox" name="" @if(hasPermission(Session::get("adminId"),"brandsN") < 2) disabled @endif  class="selectAllFromTop form-check-input"  >
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody" id="allKalaForBrand" style="height:200px !important;"> </tbody>
                                </table>
                        </div>

                        <div class="col-sm-2 brandStaff" style="">
                            <div class='modal-body' style="position:relative; right:29%; top: 30%;">
                                <div>
                                    <button @if(hasPermission(Session::get("adminId"),"brandsN") < 2) disabled @endif  id="addDataToBrand" style="background-color:transparent">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x chevronHover"></i></button>
                                    <br />
                                    <button @if(hasPermission(Session::get("adminId"),"brandsN") < 2) disabled @endif id="removeDataFromBrand" style="background-color:transparent">
                                        <i class="fa-regular fa-circle-chevron-right fa-3x chevronHover"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 brandStaff">
                                <form action="{{url('/addKalaToBrand')}}" method="get" style="display: inline" id="brandChagesForm">
                                    @csrf
                                    <input type="text" name="brandId" id="BrandToAddKala" style="display: none">
                                    <input type="text" class="form-control form-control-sm" id="serachKalaOfSubGroup"  placeholder="جستجو"> 
                                    <table class="table table-bordered table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th>
                                                    <input type="checkbox" @if(hasPermission(Session::get("adminId"),"brandsN") < 2) disabled @endif  name="" class="selectAllFromTop form-check-input"/>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="allKalaOfBrand" style="height:200px !important;">
                                        </tbody>
                                    </table>
                              </form>
                        </div>
                    </div>

                    <!-- لیست کالاهای شامل هشدار  -->
                    <table class="table table-bordered table-sm table-sm alarmedKalaStaff">
                        <thead class="tableHeader">
                            <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">اسم</th>
                            <th scope="col" style="width:100px">موجودی</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody">
                            @forelse($alarmedKalas as $kala)
                            <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$kala->GoodName}}</td>
                            <td style="width:100px">{{$kala->Amount/1}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="justify-content-center">
                                    <h6>داده ای وجود ندارد</h6>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                        <!-- دسته بندی  -->
                     <div class="row px-0 mx-0 mt-1 kalaCategoryStaff">
                           <div class="col-sm-6">
                                 <form action='{{ url('/deleteMainGroup') }}' onsubmit="return confirm('میخوهید حذف کنید?');" method='post' id="deleteAMainGroup" style=" margin:0; padding:0; display: inline;">
                                        @csrf
                                    <input type="text" value="" id="mianGroupId" style="display: none"/>
                                    <input type="text" class="form-control form-control-sm" id="mainGroupSearch" autocomplete="off" name="search_mainPart" placeholder="جستجو">
                                    <table class="table table-bordered table table-sm" id="tableGroupList">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه  1اصلی </th>
                                                <th>فعال</th>
                                            </tr>
                                        </thead>
                                        <tbody class="c-checkout tableBody" id="mainGroupList2" style="max-height: 200px;">
                                            @foreach ($mainGroups as $group)
                                                <tr  onclick="changeMainGroupStuff(this)">
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $group->title }}</td>
                                                    <td>
                                                        <input class="mainGroupId" type="radio" name="mainGroupId[]" value="{{ $group->id . '_' . $group->title }}" id="flexCheckChecked">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                          </div>
                          <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm"  id="serachSubGroupId"  placeholder="جستجو">
                                <table id="subGroupTable" class="table table-bordered table-sm">
                                    <thead class="tableHeader bg-success">
                                        <tr>
                                            <th >ردیف </th>
                                            <th> گروه فرعی </th>
                                            <th> فعال </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody" id="subGroup01" style="max-height: 200px;"> </tbody>
                                </table>
                            </div>
                        </div>

                    <!--جدول بعد از کلیک روی دسته بندی  -->

                    <div class="grid-subgroup" id="addKalaToGroup">
                          <div class="subgroup-item">
                             <input type="text" class="form-control form-control-sm"  id="serachKalaForSubGroup"  placeholder="جستجو"> 
                                <table class="table table-bordered table-sm">
                                    <thead class="tableHeader bg-successs">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>اسم </th>
                                            <th>
                                                <input type="checkbox" name="" @if(hasPermission(Session::get("adminId"),"kalaGroupN") < 1) disabled @endif  class="selectAllFromTop form-check-input"  >
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody"  id="allKalaForGroup" style="max-height: 200px;">
                                    </tbody>
                                </table>
                          </div>

                          <div class="subgroup-item">
                                     <button style="background-color:transparent; margin-top:66px;" @if(hasPermission(Session::get("adminId"),"kalaGroupN") < 1) disabled @endif  id="addDataToGroup">
                                        <i class="fa-regular fa-circle-chevron-left fa-2x chevronHover"></i>
                                    </button>
                                    <br />
                                    <button style="background-color:transparent;" @if(hasPermission(Session::get("adminId"),"kalaGroupN") < 1) disabled @endif id="removeDataFromGroup">
                                        <i class="fa-regular fa-circle-chevron-right fa-2x chevronHover"></i>
                                    </button>
                          </div>

                          <div class="subgroup-item">
                                <form action="{{url('/addKalaToGroup')}}" method="POST" id="subGroupofSubGroupForm" style="display: inline" >
                                    @csrf
                                    <input type="text" style="display: none" id="firstGroupId" name="firstGroupId"/>
                                    <input type="text" style="display: none" id="secondGroupId" name="secondGroupId"/>
                                    <input type="text" class="form-control form-control-sm" id="serachKalaOfSubGroup"  placeholder="جستجو">  
                                    <table class="table table-bordered table table-sm">
                                        <thead class="tableHeader bg-success">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th>
                                                    <input type="checkbox" @if(hasPermission(Session::get("adminId"),"kalaGroupN") < 1) disabled @endif  name="" class="selectAllFromTop form-check-input"/>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="allKalaOfGroup" style="max-height: 200px;"></tbody>
                                    </table>
                                </form>
                          </div>  
                    </div>
                 </div>
                <div class="row contentFooter"> </div>
            </div>
       </div>
     </div>
  </div>
</div>
 <!-- modal of new Brand -->
        <div class="modal fade dragableModal" id="newBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title" id="exampleModalLongTitle"> برند جدید </h5>
                    </div>
                    <div class="modal-body">
                            <form action="{{url('/addBrand')}}" method="POST" id="addNewBrandForm" enctype="multipart/form-data" class="form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label"> اسم برند </label>
                                    <input type="text" required class="form-control form-control-sm" autocomplete="off" name="brandName" id="mainGroupName" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> عکس </label>
                                    <input type="file" class="form-control form-control-sm" name="brandPic" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark "></i></button>
                                    <button type="submit" id="submitNewGroup" class="btn btn-sm btn-success">ذخیره <i class="fa fa-save " aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end modal new brand -->

         
        <!-- modal of editig brand -->
        <div class="modal fade" id="brandEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title" id="exampleModalLongTitle">ویرایش برند</h5>
                    </div>
                    <div class="modal-body">
                            <form action="{{ url('/editBrand') }}" class="form" enctype="multipart/form-data" id="editBrandForm" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">اسم برند</label>
                                    <input type="text" size="10px" required class="form-control form-control-sm" name="brandName" id="brandName"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control form-control-sm" style="" id="brandId" name="brandId"
                                         placeholder="">
                                </div>
                                <div class="form-group" style="margin-top:2%">
                                    <label for="brandPicture" id="groupPicturelabel" class='btn btn-success btn-sm' class="form-label"> انتخاب عکس <i class="fa-solid fa-image "></i></label>
                                    <input type="file" class="form-control form-control-sm" style="display:none;" name="brandPicture" id="brandPicture" placeholder="">
                                    
                                </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark "></i></button>
                        <button type="submit" id="submitNewGroup" onclick="addMantiqah()"  class="btn btn-sm btn-success">ذخیره <i class="fa fa-save " aria-hidden="true"></i></button>
                      </div>
                    </form>
                    </div>
                </div>
            </div>





<!-- modal of new group -->
<div class="modal fade dragAbleModal" id="newMainGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLongTitle"> دسته بندی جدید </h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/addMainGroup')}}" method="POST" id="addNewMainGroup" enctype="multipart/form-data" class="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label"> اسم دسته بندی </label>
                        <input type="text" required class="form-control" autocomplete="off" name="mainGroupName" id="mainGroupName"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="form-label"> اولویت </label>
                        <select class="form-select" name="priority">
                            @for ($i = 1; $i <= ($allGroups+1); $i++)
                                <option value="{{$i}}" >{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label"> عکس </label>
                        <input type="file" class="form-control" name="mainGroupPicture" placeholder="">
                    </div>
                    <div class="form-group" style="margin-top:4%">
                        <button type="button" class="btn btn-danger btn-sm buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                        <button type="submit" id="submitNewGroup" class="btn btn-success btn-sm buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal for showing customers of a product -->
<div class="modal fade dragAbleModal" id="requestModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title">درخواست دهنده های <span style="font-size:14px;color:blue;" id="GoodName"></span> </h5>
            </div>
            <div class="modal-body py-0 px-0">
                <table class="table table-bordered table-sm">
                    <thead class="tableHeader">
                    <tr>
                        <th class="for-mobil">ردیف</th>
                        <th>کد </th>
                        <th>مشتری</th>
                        <th>آدرس</th>
                        <th width="120px">تاریخ</th>
                        <th>شماره تماس</th>
                        <th> حذف </th>
                        <th style="width:111px"> نمایش </th>
                    </tr>
                    </thead >
                    <tbody id="modalContent" class="tableBody">
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>


<!-- modal for showing requested products of a customer -->
<div class="modal fade dragAbleModal" id="requestGoodsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title">درخواست های <span style="font-size:14px;color:blue;" id="CusomerNameOfProdutRequests"></span> </h5>
            </div>
            <div class="modal-body py-0 px-0">
                <table class="table table-bordered table-sm">
                    <thead class="tableHeader">
                    <tr>
                        <th class="for-mobil">ردیف</th>
                        <th> کد کالا </th>
                        <th> اسم کالا </th>
                        <th width="120px"> تاریخ </th>
                    </tr>
                    </thead >
                    <tbody id="customerRequestedProducts" class="tableBody">
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>



<!-- modal of new group -->
<div class="modal dragAbleModal" id="changePriceModal" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLongTitle">  تغییر قیمت <span id="changePriceTitle" class="modalTitle"></span> </h5>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/changePriceKala')}}" method="GET" id="changePriceForm" class="form">
                    <div class="form-group mt-2">
                        <label class="form-label" style="font-size: 14px; font-weight:bold; color:red">قیمت خط خورده (ریال) </label>
                        <input type="text" required class="form-control form-control-sm" style="color: red;" value="" autocomplete="off" name="firstPrice" id="firstPrice" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 14px; font-weight:bold; color:rgb(25, 0, 255)"> قیمت اصلی (ریال) </label>
                        <input type="text" required class="form-control form-control-sm"  style="font-weight: bold;" value="" autocomplete="off" name="secondPrice" id="secondPrice" placeholder="">
                    </div>
                        <input type="text" name="kalaId" style="display: none" id="kalaId">
                        <span style="display:none" id="moreAlert">قیمت خورده باید بیشتر از قیمت اصلی باشد.</span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" id="cancelChangePrice" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark "></i></button>
                        <button type="submit" id="submitChangePrice"  class="btn btn-sm btn-success">ذخیره <i class="fa fa-save " aria-hidden="true"></i></button>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>

<!-- modal of 10 last sales -->
<div class="modal fade dragAbleModal" id="viewTenSales" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title"> ده فروش آخر <span id="lasTenSaleName" class="modalTitle"></span></h5>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-sm">
                        <thead class="tableHeader bg-success">
                            <tr>
                                <th>ردیف</th>
                                <th>نام</th>
                                <th>تاریخ خ</th>
                                <th>فی</th>
                                <th>تعداد</th>
                                <th>کل مبلغ</th>
								 <th>کد</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody" id="lastTenSaleBody">
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>








<!-- modal for Editing Kala -->
      
<div class="modal fade dragAbleModal" id="editingListKala" data-backdrop="static"  data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header myModalHeader py-2">
                <button type="button" class="btn-close bg-danger" data-dismiss="modal" id="closeEditModal" aria-label="Close"></button>
                <h5 class="modal-title" id="editKalaTitle"> </h5>
            </div>
            <div class="modal-body p-0 m-0">
              <div class='container'>
                   <div class="row rounded border bg-success text-white mx-1" style="font-size:12px;">
                        <div class="col-sm-3">
                                گروه اصلی : <span id="original"> </span> 
                            </div>
                            <div class="col-sm-3">
                                گروه فرعی : <span id="subsidiary"> </span>
                            </div>
                            <div class="col-sm-3"> 
                                قیمت اصلی  : <span style="color:black" id="mainPrice">ریال</span>
                            </div>
                            <div class="col-sm-3"> 
                                قیمت خط خورده   : <span style="color:black;text-decoration: line-through;" id="overLinePrice">  ریال   </span> 
                            </div>
                     </div>
       
                 <div class='card mb-4' style="background-color:#63bea2;">
                  <div class="container">
                    <ul class="header-list nav nav-tabs" data-tabs="tabs">
                        <li><a class="active" data-toggle="tab" style="color:black;"  href="#parts">دسته بندی</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#yellow">تنظیمات اختصاصی</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#green"> ویژگی های کالا</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#pictures">تصاویر </a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#orange">گردش قیمت</a></li>
                    </ul>
                <div class="c-checkout tab-content" style="background-color:#f5f5f5; border-radius:10px 10px 2px 2px; display:block; height:444px; overflow-y:scroll; overflow-x:hidden ! important;">
                     <div class="tab-pane active" id="parts">
                        <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                            <div class="container">
                             <form action="{{url('/addOrDeleteKalaFromSubGroup')}}" style="display: inline" method="GET" id="groupSubgoupCategory">
                                     @csrf
                                    <input type="text" style="display: none;" name="kalaId" id="kalaIdEdit" value=""/>
                                <div class="row">
                                    <div class="col-sm-6">
                                            <div class="well" style="margin-top:1%;">
                                                <h6 style="">گروه های اصلی</h6>
                                            </div>
									
                                            <!-- <div class="alert">
                                                <input type="text" class="form-control" style="margin-top:10px;" name="search_mainPart" placeholder="جستجو">
                                            </div> -->
                                            <table class="table table-bordered table table-sm ">
                                                <thead class="tableHeader bg-success">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th>فعال</th>
                                                        <th>انتخاب</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" id="maingroupTableBody">
                                                </tbody>
                                            </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="well" style="margin-top:1%;">
                                            <div class="well">
                                                <h6 style="">گروه های فرعی</h6>
                                            </div>
<!---                                            <div class="alert">
                                                <input type="text" class="form-control" style="margin-top:10px;" name="search_mainPart" placeholder="جستجو">
                                            </div>
!-->
                                                <table class="table table-bordered table-sm">
                                                    <thead class="tableHeader bg-success">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه فرعی </th>
                                                            <th>انتخاب</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="subGroup1">
                                                    </tbody>
                                             </table>
                                        </div>
                                    </div>
                                </div>
                              </form> 
                            </div>
                        </div>
                    </div>
                    <div class="c-checkout tab-pane" id="orange" style="border-radius:10px 10px 2px 2px;">
                        <span class="row" style="padding: 1%">
                            <div class="col-sm-12">
                                    <input type="text" class="form-control form-control-sm" style="width:40%" name="search_mainPart" placeholder="جستجو">
                                   <table class="table table-bordered table-sm  text-center">
                                     <thead class="tableHeader bg-success">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>اسم کاربر </th>
                                            <th>برنامه</th>
                                            <th>تاریخ</th>
                                            <th>قیمت قبلی اول</th>
                                            <th>قیمت بعدی اول</th>
                                            <th>قیمت دوم قبلی</th>
                                            <th>قیمت دوم بعدی</th>
                                            <th>انتخاب</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody" id="priceCycle"> </tbody>
                                </table>
                            </div>
                        </span>
                    </div>

                    <div class="c-checkout tab-pane" id="pictures" style="border-radius:10px 10px 2px 2px;">
                        <div class="container">
                            <div class="row">
                                <div class='modal-body'style="display:flex;  justify-content: flex-end; float:right;">
                                    <div id='pslider' class=' swiper-container swiper-container-horizontal swiper-container-rtl'>
                                        <div class=' product-box swiper-wrapper'>
                                           <iframe name="votar" style="display:none;"></iframe>
                                            <form action="{{ url('/addpicture') }}" target="votar" id="kalaPicForm" enctype="multipart/form-data" method="POST">
                                                @csrf
                                                <input type="text" style="display: none;" name="kalaId" id="kalaIdChangePic" value="">
                                            <table class="table align-middle table-sm text-center">
                                                <thead class="bg-success">
                                                    <tr>
                                                        <th style="width:160px !important;">تصویر اصلی </th>
                                                        <th>تصویر اول</th>
                                                        <th>تصویر دوم</th>
                                                        <th> تصویر سوم</th>
                                                        <th style="width:160px !important;">تصویر چهارم </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="width:160px !important;">
                                                            
                                                                <img class="rounded-2" style="width:100%; height:122px;" id="mainPicEdit" src="" />
                                                            <div class="mt-1">
                                                                <label for="mainPic" class="btn btn-success btn-sm  kalaEditbtn"> ویرایش <i class="fa-light fa-image "></i></label>
                                                                <input type="file"  onchange='document.getElementById("mainPicEdit").src = window.URL.createObjectURL(this.files[0]);' style="display:none" class="form-control" name="firstPic" id="mainPic">
                                                                <button class="btn btn-danger btn-sm kalaEditbtn" id="deleteKalaPictureButton"> حذف <i class="fa-light fa-trash"></i></button>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            
                                                             <img id="secondPic" class="rounded-2" src="{{url('/resources/assets/images/kala/_2.jpg')}}" /> <br>
                                                            <div class="mt-1">
                                                                <label for="secondPic" class="btn btn-success editButtonHover kalaEditbtn">  ویرایش <i class="fa-light fa-image "></i></label>
                                                                <input type="file" onchange='document.getElementById("secondPic").src = window.URL.createObjectURL(this.files[1]);' style="display:none" class="form-control" name="secondPic" id="secondPic">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            
                                                                <img id="2PicEdit" src="{{url('/resources/assets/images/kala/_3.jpg')}}" />
                                                           
                                                            <div>
                                                                <label for="2Pic" class="btn btn-success editButtonHover kalaEditbtn"> ویرایش <i class="fa-light fa-image "></i></label>
                                                                <input type="file"    style="display: none" class="form-control" name="thirthPic" >
                                                            </div>
                                                        </td>
                                                        <td>
                                                            
                                                                <img id="3PicEdit" src="{{url('/resources/assets/images/kala/_4.jpg')}}" />
                                                           
                                                            <div>
                                                                <label for="3Pic" class="btn btn-success editButtonHover kalaEditbtn"> ویرایش <i class="fa-light fa-image "></i></label>
                                                                <input type="file"   style="display: none" class="form-control" name="fourthPic" >
                                                            </div>
                                                        </td>
                                                        <td style="width:160px !important;">
                                                            
                                                                <img id="4PicEdit" src="{{url('/resources/assets/images/kala/_5.jpg')}}" />
                                                           
                                                            <div>
                                                                <label for="4Pic" class="btn btn-success editButtonHover kalaEditbtn"> ویرایش <i class="fa-light fa-image "></i></label>
                                                                <input type="file"   style="display: none" class="form-control" name="fifthPic" >
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                          </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-checkout tab-pane" id="yellow" style="border-radius:10px 10px 2px 2px;">
                        <div class="container ">
                            <div class="row mt-1">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>
                                            <input class="form-check-input checkBoxStyle" disabled type="checkbox" value="" id="defaultCheck1">
                                            <label>علامت گذاری کالای جدید</label>
                                        </span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <span>
                                            <input class="form-check-input checkBoxStyle"  type="checkbox" value="" id="stockTakhsis">
                                            <label for="whereHouse">تخصیص انبار</label>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                            <button id="minimamSale" onclick="SetMinQty()" class="btn-add-to-cart">حد اقل فروش<i class="far fa-shopping-cart text-white ps-2"></i></button>
                                        <span id="minSaleValue"> </span>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                            <button id="maximamSale" onclick="SetMaxQty()" class="btn-add-to-cart">حد اکثر فروش<i class="far fa-shopping-cart text-white ps-2"></i></button>
                                        <span id="maxSaleValue"> </span>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <form action="{{url('/restrictKala')}}" id="restrictFormStuff" method="get">
                                          @csrf
                                        <input type="text" style="display: none" name="kalaId" id="kalaIdSpecialRest" value="">

                                        <div class="input-group input-group-sm mb-1">
                                             <span class="input-group-text" id="inputGroup-sizing-sm"> حد ایرور هزینه </span>
                                             <input type="number" onchange="activeSubmitButton(this)" value="" name="costLimit" class="form-control keyRestriction" id="costLimit">
                                        </div>

                                        <div class="input-group input-group-sm  mb-1">
                                        <label class="input-group-text" for="inputGroupSelect01">  نوع هزینه </label>
                                                <select id="costTypeInfo"  onchange="activeSubmitButton(this)" class="form-select form-select-sm keyRestriction" name="infors"> </select>
                                        </div>

                                         <div class="input-group input-group-sm mb-1">
                                             <span class="input-group-text" id="inputGroup-sizing-sm"> مقدار هزینه </span>
                                             <input type="number" onchange="activeSubmitButton(this)" value="" name="costAmount" class="form-control keyRestriction" id="costAmount">
                                        </div>

                                         <div class="input-group input-group-sm mb-1">
                                             <span class="input-group-text" id="inputGroup-sizing-sm">  نقطه هشدار کالا  </span>
                                              <input type="number" class="form-control keyRestriction" value="" required onclick="activeSubmitButton(this)" id="existanceAlarm" name='alarmAmount' style="width:50%">
                                        </div>


                                        <div class="input-group input-group-sm  mb-1">
                                           <label class="input-group-text" for="inputGroupSelect01">  متن ایرور هزینه </label>
                                           <textarea id="costContent"  class="form-control keyRestriction" onchange="activeSubmitButton(this)" name="costErrorContent" rows="2" cols="24"></textarea>
                                        </div>

                                       
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <span>
                                                <input class="form-check-input restriction checkBoxStyle" type="checkbox" onchange="activeSubmitButton(this)" value="" id="callOnSale" name="callOnSale[]"/>
                                                <label class="form-check-label">
                                                    تماس جهت خرید کالا
                                                </label>
                                            </span>
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <span>
                                                <input class="form-check-input restriction checkBoxStyle" type="checkbox"  onchange="activeSubmitButton(this)" value="" id="zeroExistance" name="zeroExistance[]"/>
                                                <label class="form-check-label">
                                                    صفر کردن موجودی کالا
                                                </label>
                                            </span>
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <span>
                                                <input class="form-check-input restriction checkBoxStyle" type="checkbox"  onchange="activeSubmitButton(this)" value="" id="showTakhfifPercent" name="activeTakhfifPercent[]" />
                                                <label class="form-check-label" for="showTakhfifPercent">
                                                    نمایش درصد تخفیف
                                                </label>
                                            </span>
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <span>
                                                <input class="form-check-input restriction checkBoxStyle" type="checkbox"  onchange="activeSubmitButton(this)" value="" id="showFirstPrice" name="overLine[]" />
                                                <label class="form-check-label" for="showFirstPrice">
                                                    نمایش قیمت خط خورده
                                                </label>
                                            </span>
                                        </div>
                                    <div class="form-group input-group-sm">
                                        <span>
                                            <input class="form-check-input restiction checkBoxStyle"  onchange="activeSubmitButton(this)" type="checkbox" value="" id="inactiveAll" name="hideKala[]">
                                            <label class="form-check-label"> غیر فعال </label>
                                        </span>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <span>
                                            <input class="form-check-input restriction checkBoxStyle"  onchange="activeSubmitButton(this)" type="checkbox" value="" name="freeExistance[]" id="freeExistance"  >
                                            <label class="form-check-label"> آزادگذاری فروش </label>
                                        </span>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <span>
                                            <input class="form-check-input restriction checkBoxStyle"  onchange="activeSubmitButton(this)" type="checkbox" value="" name="activePishKharid[]" id="activePreBuy"  >
                                            <label class="form-check-label"> فعالسازی پیش خرید </label>
                                        </span>
                                    </div>
                                </form>
                                </div>
                            </div>

                            <div class="grid-subgroup" id="displayTakhisAnbarTables" style="display:none;">
                                <div class="subgroup-item" id="allStock">
                                  <div class='modal-body'>
                                        <input type="text" class="form-control form-control-sm" id=""  placeholder="جستجو">
                                        <table class="table table-bordered table-sm">
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>اسم </th>
                                                    <th>انتخاب</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" id="allStockForList">
                                            </tbody>
                                        </table>
                                    </div>
                               </div>
                                <div class="subgroup-item" id="addAndDeleteStock"  style="margin-top:88px;">
                                    <a id="addStockToList">
                                        <i class="fa-regular fa-circle-chevron-left fa-2x chevronHover"></i>
                                    </a>
                                    <br />
                                    <a id="removeStockFromList">
                                        <i class="fa-regular fa-circle-chevron-right fa-2x chevronHover"></i>
                                    </a>
                                </div>

                                <div class="subgroup-item" id="addedStock" >
                                    <div class='modal-body'>
                                      <form action="{{url('/addStockToList')}}" method="POST" id="submitStockToList" style="display: inline" >
                                            <input type="text" name="kalaId" value="" style="display: none" id="kalaIdForAddStock">
                                            @csrf
                                            <input type="text" class="form-control form-control-sm" id="serachKalaOfSubGroup"  placeholder="جستجو"> 
                                                <table class="table table-bordered table-sm">
                                                    <thead class="tableHeader">
                                                        <tr >
                                                            <th>ردیف</th>
                                                            <th>انبار</th>
                                                            <th>انتخاب</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="allstockOfList">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="c-checkout tab-pane" id="green" style="border-radius:10px 10px 2px 2px;">
                        <div class="row mt-1">
                                <div class="col-sm-3 ">
                                    <input type="checkbox" class="form-check-input checkBoxStyle" style="padding:12px; margin:5px;"  id="sameKalaList" />
                                    <label  class="styleForLabel"  for="exampleFormControlTextarea1" style="margin-top:8px; font-size:14px">لیست کالاهای مشابه</label>
                                </div>
                               <div class="col-sm-6"> 
                                    <div class="input-group mb-1">
                                        <span class="input-group-text styleForLabel"> توضیحات مختصر </span>
                                        <textarea disabled class="form-control" id="shortExpain" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class=" col-sm-12 m-1">
									<form action="{{url('/addDescKala')}}" target="votar" id="completDescription" method="post">
										@csrf
										<input type="text" style="display:none" name="kalaId" id="kalaIdDescription" value=""/>
										<div class="input-group">
											<span class="input-group-text styleForLabel" for="description"> توضیحات کامل </span>
											<textarea class="form-control" name="discription" id="descriptionKala" rows="3"></textarea>
										</div>
										<div class="input-group input-group-sm mt-1">
											<span class="input-group-text styleForLabel"> تگ کالای مترادف </span>
											<textarea class="form-control" id="kalaTags" name="kalaTags" rows="2"></textarea>
										</div>
									</form>
                                </div>
                         </div>
                            <div class="grid-subgroup" id="displaySameKalaTables" style="display:none;">
                                <div class="subgroup-item" id="addKalaToList"> 
                                 <div>  <input type="text" class="form-control form-control-sm" id="serachKalaForAssameList" placeholder="جستجو"> 
                                  <table class="table table-bordered table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="allKalaForList">
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="subgroup-item" style="margin-top:80px;" id="addAndDelete"> 
                                      <a id="addDataToList">
                                            <i class="fa-regular fa-circle-chevron-left fa-2x chevronHover"></i>
                                        </a>
                                        <br />
                                        <a id="removeDataFromList">
                                            <i class="fa-regular fa-circle-chevron-right fa-2x chevronHover"></i>
                                        </a>
                                </div>
                                <div class="subgroup-item" id="addedList">
                                        <form action="{{url('/addKalaToList')}}" target="votar"  method="GET" style="display: inline" id="sameKalaForm">
                                        <input type="text" name="mainKalaId" value="" style="display: none" id="kalaIdSameKala">
                                         @csrf
                                        <input type="text" class="form-control form-control-sm" id="serachKalaOfSubGroup"  placeholder="جستجو">
                                        <table class="table table-bordered table table-sm">
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>کالای مشابه</th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" id="allKalaOfList">  </tbody>
                                         </table>
                                   </form>
                              </div>
                           </div>
                         </div>
                       </div>
                     </div> 
                  </div>
                <div class="modal-footer py-0">
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="submitSubGroup"           form="groupSubgoupCategory" disabled> ذخیره <i class="fa fa-save "></i> </Button>
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="stockSubmit"              form="submitStockToList" style="display:none"> ذخیره <i class="fa fa-save "></i> </button>
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="kalaRestictionbtn"        form="restrictFormStuff" style="display:none"> ذخیره <i class="fa fa-save "></i></button>
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="completDescriptionbtn"    form="completDescription" style="display:none">ذخیره <i class="fa fa-save "></i></button>
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="addToListSubmit"          form="sameKalaForm" style="display:none">ذخیره <i class="fa fa-save "></i> </button>
                    <button class="btn btn-sm btn-success buttonHover" type="submit" id="submitChangePic"          form="kalaPicForm" style="display:none"> ذخیره <i class="fa fa-save "></i></button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="cancelEditModal"> انصراف <i class="fa fa-xmark"></i></button>
              </div>
            </div>
          </div>
        </div>
     </div>
    </div>



        <!-- end modal editing -->
        <!-- modal of editig subgroups -->
        <div class="modal fade" id="editSubGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-success py-2">
                        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title" id="exampleModalLongTitle"> ویرایش دستبند ی فرعی</h5>
                    </div>
                    <div class="modal-body">
                            <form action="{{ url('/editSubgroup') }}" class="form" enctype="multipart/form-data" id="editSubGroupForm" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label"> اسم دستبندی </label>
                                    <input type="text" required class="form-control form-control-sm" name="subGroupNameEdit" id="subGroupNameEdit" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> اولویت </label>
                                      <select class="subGroupCount form-select form-select-sm" name="priority"> </select>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="fatherMainGroupId"
                                    id="fatherMainGroupIdEdit" style="display: none">
                                <input type="text" class="form-control form-control-sm" name="subGroupId" id="subGroupIdEdit"
                                    style="display: none">
                                <div class="form-group" style="margin-top:4%">
                                    <label for="subGroupPictureEdit" id="subGroupPictureEditlabel" class='btn btn-success btn-sm' class="form-label"> انتخاب عکس <i class="fa-solid fa-image"></i></label>
                                    <input type="file"  class="form-control form-control-sm" style="display:none" name="subGroupPictureEdit" id="subGroupPictureEdit" placeholder="">
                                        &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-success btn-sm"> ذخیره <i class="fa fa-save" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal editing -->
        <!-- modal of new subgroup -->
        <div class="modal fade" id="newSubGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-success py-2">
                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title" id="exampleModalLongTitle">دسته بندی فرعی جدید</h5>
                    </div>
                    <div class="modal-body" style="padding:5%; padding-right:0; padding-top:0; margin-right:10px">
                        <div class="c-checkout" style="padding:5%; padding-right:0; padding-top:0;">
                            <form action="{{ url('/addSubGroup') }}" class="form" enctype="multipart/form-data" id="addSubGroupForm" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">اسم دستبندی</label>
                                    <input type="text" required class="form-control" autocomplete="off" name="groupTitle" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> عکس </label>
                                    <input type="file" class="form-control" name="subGroupPicture" placeholder="">
                                </div>
                                <input type="text" value="" style="display: none" name="fatherMainGroupId" id="fatherMainGroupId">
                                <input type="text" value="" style="display: none" id="selfGroupId">
                                <div class="form-group">
                                    <label class="form-label"> اولویت </label>
                                    <select class="subGroupCount form-select" name="priority" >
                                    </select>
                                </div>
                                <div class="form-group" style="margin-top:4%">
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark"></i></button>
                                    <button type="submit" class="btn btn-sm btn-success">ذخیره <i class="fa fa-save" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>


        <!-- end modal editing -->
        <div class="modal fade dragAbleModal" id="editGroup"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <h5 class="modal-title" id="exampleModalLongTitle">ویرایش دسته بندی</h5>
                        <button type="button" class="close btn bg-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255); padding:0; padding-left:7px;"><i class="fa-solid fa-xmark fa-xl"></i>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/editMainGroup')}}" id="editMainGroupForm" class="form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">اسم دستبندی</label>
                                <input type="text" size="10px" required class="form-control" name="groupName" id="groupName" placeholder="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" style="display:none;" name="groupId" id="groupId" placeholder="">
                            </div>
                            <div class="form-group" style="margin-top:4%">
                                <label for="groupPicture" id="groupPicturelabel" class='btn btn-success btn-sm' class="form-label"> انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label>
                                <input type="file" class="form-control" style="display:none;" name="groupPicture" id="groupPicture" placeholder="">&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-success btn-sm buttonHover"> ذخیره  <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal of new subgroup -->
        <div class="modal fade dragAbleModal" id="newSubGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <h5 class="modal-title" id="exampleModalLongTitle">دسته بندی فرعی جدید</h5>
                        <button type="button" class="close btn bg-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255); padding:0; padding-left:7px;"><i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/addSubGroup') }}" class="form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label fs-6">اسم دستبندی</label>
                                <input type="text" required class="form-control" autocomplete="off" name="groupTitle" placeholder="">
                            </div>
                            <div class="form-group">
                                <label class="form-label fs-6"> عکس </label>
                                <input type="file" class="form-control" name="subGroupPicture" placeholder="">
                            </div>
                            <input type="text" value="" style="display: none" name="fatherMainGroupId" id="fatherMainGroupId">
                            <input type="text" value="" style="display: none" id="selfGroupId">
                            <div class="form-group">
                                <label class="form-label fs-6"> اولویت</label>
                                <select class="subGroupCount form-select" name="priority">
                                </select>
                            </div>
                            <div class="form-group" style="margin-top:4%">
                                <button type="button" class="btn btn-danger btn-sm buttonHover" data-dismiss="modal">انصراف<i class="fa-solid fa-xmark fa-lg"></i></button>
                                <button type="submit" class="btn btn-success btn-sm buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
    <script src="{{ url('/resources/assets/js/KalaScript.js')}}">  </script>
    <script type="text/javascript">
   $("#newBrandBtn").on("click", ()=>{
	      if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 0
                });
              }
              $('#newBrandModal').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
   		$("#newBrandModal").modal("show")
   })

   $("#editBrandBtn").on("click", ()=>{
	      if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 0
                });
              }
              $('#brandEditModal').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
   		$("#brandEditModal").modal("show")
   })
	


	 $("#editGroupList").on("click", ()=>{
	      if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 0
                });
              }
              $('#editGroup').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
   		$("#editGroup").modal("show")
   })

        function getGroupId() {
            var checkedValue = document.querySelector('.mainGroupId:checked').value;
            var groupProperties = checkedValue.split("_");
            document.querySelector('#groupName').value = groupProperties[1].trim();
            document.querySelector('#groupId').value = groupProperties[0];
        }
        function addNewSubGroup() {
            document.querySelector('#fatherMainGroupId').value = document.querySelector('.mainGroupId:checked').value.split(
                '_')[0];
                document.querySelector(".countGroups").append("<option>good</option>");
        }
        window.onload = function() {
        $(document).on('change', '#groupPicture', (function() {
            $('#groupPicturelabel').css('background-color','#6c757d');
        }));

        $(document).on('change', '#subGroupPictureEdit', (function() {
            $('#subGroupPictureEditlabel').css('background-color','#6c757d');
        }));
        }
		
	$("#addNewMainGroupBtn").on("click", ()=>{
	     if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 350
                });
              }
              $('#newMainGroup').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
	    	$("#newMainGroup").modal("show");
	});

	// $("#editGroupList").on("click", ()=>{
	//      if (!($('.modal.in').length)) {
    //             $('.modal-dialog').css({
    //               top: 0,
    //               left: 350
    //             });
    //           }
    //           $('#editGroup').modal({
    //             backdrop: false,
    //             show: true
    //           });
              
    //           $('.modal-dialog').draggable({
    //               handle: ".modal-header"
    //             });
	//     	$("#editGroup").modal("show");
	// })
		
	$("#addNewSubGroupButton").on("click", ()=>{

	     if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 300
                });
              }
              $('#newSubGroup').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
	    	$("#newSubGroup").modal("show");
	})
	
    $("#editSubGroupButton").on("click", ()=>{
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 300
            });
            }
            $('#editSubGroup').modal({
            backdrop: false,
            show: true
            });
            $('.modal-dialog').draggable({
                handle: ".modal-header"
            });
        $("#editSubGroup").modal("show");
	})

    $(document).ready(function() {
       $("#submitFactorToAppButton, #submitDeleteFactorButton").click(function() {
           $("#pishKharidFormId").submit();
       });
});
		
	function showPishKharidStates(element,orderState){
		if(orderState==1){
			$("#tablePishKharidFactor").fadeIn();
			$("#tablePishKharidOrder").fadeOut();
		}else{
			$("#tablePishKharidOrder").fadeIn();
			$("#tablePishKharidFactor").fadeOut();
		}
	}
		    
</script>
@endsection

