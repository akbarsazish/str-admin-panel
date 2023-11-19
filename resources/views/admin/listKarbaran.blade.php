@extends('admin.layout')
@section('content')
<style>


.firstLevel{
         color:#00512a !important;
        font-size:16px !important;
        font-weight:bold !important; 
    }

 .first input{
        border: 1px solid #ec2947 !important;
        border-radius:50% !important;
        padding:11px;
    }
    
 .firstLevel input{
        border: 1px solid #ffbf35 !important;
        border-radius:50% !important;
        padding:10px;
    }

.secondLevel input{
    border: 1px solid #00a4b6 !important;
    border-radius:50% !important;
    padding:8px;
}

 .secondLevel{
        color:#008857 !important;
         font-size:14px !important;
        font-weight:bold !important;
    }
.searchInputTopC{
    width: 300px;
    color: black;
}
</style>
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                    <!-- <div class="form-check">
                        <input class="form-check-input p-2 float-end" type="radio" name="settings" id="elseSettingsRadio">
                        <label class="form-check-label me-4" for="assesPast">  سطح دسترسی  </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-end" type="radio" name="settings" id="settingAndTargetRadio">
                        <label class="form-check-label me-4" for="assesPast"> تارگت ها و امتیازات </label>
                    </div> -->
                    
                </fieldset>
            </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader"> 
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-1">
						   <input type="text" name="search_mainPart" class="form-control form-control-sm searchInputTopC" id="basic-url" aria-describedby="basic-addon3" placeholder="جستجو ">
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 text-end mt-1">
						 @if(hasPermission(Session::get("adminId"),"karbaranN") > 0)
                            <button class="btn btn-success btn-sm" id="addingNewKarbar"> کاربر جدید <i class="fa fa-plus" aria-hidden="true"></i></button>
                        @endif  
                        @if(hasPermission(Session::get("adminId"),"karbaranN") > 0)  
                            <button  type="button" class="btn btn-success btn-sm text-white" onclick="openEditDashboard()"> ویرایش <i class="fa fa-edit" aria-hidden="true"></i></button>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"karbaranN") > 1)
                            <button  type="button" class="btn btn-danger btn-sm text-white" onclsuper ick="deleteConfirm()"> حذف <i class="fa fa-trash" aria-hidden="true"></i></button>
                        @endif
					</div>
                </div>
                <div class="row mainContent">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="tableHeader">
                            <tr>
                                <th>ردیف</th>
                                <th>اسم</th>
                                <th>فامیلی </th>
                                <th>فعال </th>
                                <th>انتخاب </th>
                            </tr>
                        </thead>
                        <tbody class="tableBody">
                            @foreach($admins as $admin)
                                <tr onclick="editAdmins(this)">
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->lastName}}</td>
                                    <td><input class="form-check-input" name="activeState" type="checkbox" disabled value="" @if ($admin->activeState==1) checked @else @endif id="flexCheckChecked" />
                                    </td>
                                    <td>
                                    <input class="admins form-check-input" name="admin" type="radio" value="{{$admin->id}}" id="flexCheckChecked" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>






<!-- modal for editing karbar and new roles for karbar -->
<div class="modal fade dragAbleModal" id="editUserRoles" data-backdrop="static"  data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header myModalHeader py-2">
                <h5 class="modal-title" id="editKalaTitle"> ویرایش کاربر  </h5>
               <span style="display: flex; float:left;"> <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button> </span>
            </div>
            <div class="modal-body p-1"> 
                        <form style="display:inline" action="{{url('/doEditAdmin')}}" method="post" id="editingKarbarForm">
                        <input type="text" style="display:none" id="editAdminId" name="adminId"/>
                             @csrf
                        <div class='container descForall'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text">نوع کاربر</span>
                                            <select class="form-select form-select-sm" name="adminType"  style="display:inline;" id="adminTypeED">
                                                <option value="admin">ادمین</option>
                                                <option value="poshtiban">پشتیبان</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> اسم </span>
                                        <input type="text" class="form-control" placeholder="اسم" id="name" name="name">
                                     </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">  فامیلی </span>
                                         <input type="text" class="form-control" id="lastName" name="lastName" placeholder="فامیلی">
                                     </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> نام کاربری </span>
                                        <input type="text" class="form-control" placeholder="نام کاربری" id="userName" name="userName">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> رمز </span>
                                        <input type="password" class="form-control" placeholder="رمز" id="password" name="password">
                                     </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3"> 
                                        <input type="file" class="form-control" name="userPic" placeholder="تصویر">
                                     </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check d-flex flex-end mt-1">
                                        <input class="form-check-input p-2" type="radio" value="male" name="gender" id="manGender"> &nbsp;
                                        <label class="form-check-label mx-4 karbar-label fs-6" >مرد </label> &nbsp; &nbsp;
                                        <input class="form-check-input p-2" type="radio" value="female" name="gender" id="womanGender"> &nbsp;
                                        <label class="form-check-label mx-4 karbar-label fs-6">زن</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check d-flex flex-end mt-1">
                                        <input class="form-check-input p-2" type="checkbox" name="activeState" id="activeState"> &nbsp;
                                        <label class="form-check-label mx-4 karbar-label fs-6">فعال</label> &nbsp; &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
          
                 <div class="container" style="background-color:#43bfa3; border-radius:5px 5px 2px 2px;">
                        <ul class="header-list nav nav-tabs" data-tabs="tabs">
                            <li><a class="active" data-toggle="tab" style="color:black;" href="#webManagementED"> اطلاعات پایه  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#peoplesED"> تعریف عناصر  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#kalasTabED">  عملیات  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#messagesED">  گزارشات   </a></li>
                        </ul>
                        <div class="c-checkout tab-content tableBody" style="background-color:#f5f5f5; margin:0; margin-bottom:1%; padding:1%; border-radius:5px 5px 2px 2px;">
                            <div class="c-checkout tab-pane active" id="webManagementED" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto forLegend first"> <input type="checkbox" name="baseInfoED" id="baseInfoED" class="form-check-input"/>  اطلاعات پایه   </legend>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto forLegend firstLevel"> <input type="checkbox" name="settingsED" id="settingsED" class="form-check-input"/>  تظیمات  </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" name="mainPageSetting" id="mainPageSetting" class="allSettingsED webED form-check-input"/> تنظیمات صفحه اصلی </legend>
                                                        
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxED form-check-input box-check" id="deletMainPageSettingED" type="checkbox" name="deletMainPageSettingED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxED form-check-input box-check" id="editManiPageSettingED" type="checkbox" name="editManiPageSettingED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxED form-check-input box-check" id="seeMainPageSettingED" type="checkbox" name="seeMainPageSettingED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto secondLevel fs-6"> <input type="checkbox" name="specialSettingED" id="specialSettingED" class="allSettingsED form-check-input"/> تنظیمات اختصاصی  &nbsp;</legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxED form-check-input box-check" id="deleteSpecialSettingED" type="checkbox" name="deleteSpecialSettingED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxED form-check-input box-check" id="editSpecialSettingED" type="checkbox" name="editSpecialSettingED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxED form-check-input box-check" id="seeSpecialSettingED" type="checkbox"  name="seeSpecialSettingED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto secondLevel fs-6"> <input type="checkbox" id="emptyazSettingED" class="allSettingsED form-check-input" name="emptyazSettingED" /> تنظمیات امتیاز </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" id="deleteEmtyazSettingED" type="checkbox" name="deleteEmtyazSettingED"> 
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" type="checkbox" id="editEmptyazSettingED" name="editEmptyazSettingED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" id="seeEmtyazSettingED" type="checkbox" name="seeEmtyazSettingED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="c-checkout tab-pane" id="peoplesED" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3">
                                            <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="personsED form-check-input" id="defineElementED" name="defineElementED"/> تعریف عناصر  </legend>
                                            <fieldset class="border rounded-3">
                                                <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="personsED form-check-input" id="karbaranED" name="karbaranED"/>کاربران </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="personED form-check-input" id="customersED" name="customersED"/>  مشتریان  </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superED form-check-input box-check" id="deleteCustomersED" type="checkbox" name="deleteCustomersED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminED form-check-input box-check" type="checkbox" id="editCustomerED" name="editCustomerED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeCustomersED" name="seeCustomersED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="c-checkout tab-pane" id="kalasTabED" style="border-radius:10px 10px 2px 2px;">
                                <div class="row">
                                    <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                        <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="operationED form-check-input" id="operationED" name="operationED"/>   عملیات   </legend>
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="kalasED form-check-input" id="kalasED" name="kalasED"/> کالا ها </legend>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="kalaListsED" name="kalaListsED"/> لیست کالاها </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteKalaListED" type="checkbox" name="deleteKalaListED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editKalaListED" name="editKalaListED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeKalaListED" name="seeKalaListED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="requestedKalaED" name="requestedKalaED"/> درخواستی ها </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteRequestedKalaED" type="checkbox" name="deleteRequestedKalaED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check " type="checkbox" id="editRequestedKalaED" name="editRequestedKalaED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                <input class="poshtibanED form-check-input box-check " type="checkbox" id="seeRequestedKalaED" name="seeRequestedKalaED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="fastKalaED" name="fastKalaED"/> فست کالا </legend>
                                                <div class="form-check admin-accesss-level">
                                                <input class="superED form-check-input box-check" id="deleteFastKalaED" type="checkbox" name="deleteFastKalaED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                <input class="adminED form-check-input box-check" type="checkbox" id="editFastKalaED" name="editFastKalaED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeFastKalaED" name="seeFastKalaED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="pishKharidED" name="pishKharidED" /> پیش خرید </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deletePishKharidED" type="checkbox" name="deletePishKharidED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editPishkharidED" name="editPishkharidED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox"  id="seePishKharidED" name="seePishKharidED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="brandsED" name="brandsED"/> برند ها </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteBrandsED" type="checkbox" name="deleteBrandsED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editBrandED" name="editBrandED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeBrandsED" name="seeBrandsED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="alertedED" name="alertedED"/> کالاهای شامل هشدار </legend>
                                                <div class="form-check admin-accesss-level">
                                                <input class="superED form-check-input box-check" id="deleteAlertedED" type="checkbox" name="deleteAlertedED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editAlertedED" name="editAlertedED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeAlertedED" name="seeAlertedED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="kalaGroupED" name="kalaGroupED" /> دسته بندی کالاها </legend>
                                                
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deletKalaGroupED" type="checkbox" name="deletKalaGroupED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editKalaGroupED" name="editKalaGroupED" >
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeKalaGroupED" name="seeKalaGroupED" >
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>

                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="orderSalesED" name="orderSalesED" /> سفارشات فروش  </legend>
                                                
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteOrderSalesED" type="checkbox" name="deleteOrderSalesED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editOrderSalesED" name="editOrderSalesED" >
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeSalesOrderED" name="seeSalesOrderED" >
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="messageED" name="messageED" /> پیام ها </legend>
                                                
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteMessageED" type="checkbox" name="deleteMessageED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editMessageED" name="editMessageED" >
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeMessageED" name="seeMessageED" >
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="factorED" name="factorED" /> فاکتور  </legend>
                                                
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteFactorED" type="checkbox" name="deleteFactorED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editFactorED" name="editFactorED" >
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeFactorED" name="seeFactorED" >
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>

                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElementED form-check-input" id="bargiriED" name="bargiriED" /> بارگیری فاکتور  </legend>
                                                
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteBargiriED" type="checkbox" name="deleteBargiriED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editBargiriED" name="editBargiriED" >
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeBargiriED" name="seeBargiriED" >
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                    </fieldset>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="c-checkout tab-pane" id="messagesED" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="kalasED form-check-input" id="reportED" name="reportED"/>  گزارشات  </legend>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="reportElementED form-check-input" id="reportCustomerED" name="reportCustomerED"/>  مشتریان </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="cutomerListED form-check-input" id="cutomerListED" name="cutomerListED"/> لیست مشتریان </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superED form-check-input box-check" id="deletCustomerListED" type="checkbox" name="deletCustomerListED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminED form-check-input box-check" type="checkbox" id="editCustomerListED" name="editCustomerListED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeCustomerListED" name="seeCustomerListED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="cutomerListED form-check-input" id="officialCustomerED" name="officialCustomerED"/> اشخاص رسمی </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superED form-check-input box-check" id="deleteOfficialCustomerED" type="checkbox" name="deleteOfficialCustomerED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminED form-check-input box-check " type="checkbox" id="editOfficialCustomerED" name="editOfficialCustomerED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check " type="checkbox" id="seeOfficialCustomerED" name="seeOfficialCustomerED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto forLegend firstLevel"><input type="checkbox" class="reportElementED form-check-input" id="gameAndLotteryED" name="gameAndLotteryED"/>  بازیها و لاتری </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="gameAndLotteryElement form-check-input" id="lotteryResultED" name="lotteryResultED"/> نتیجه لاتری  </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superED form-check-input box-check" id="deletLotteryResultED" type="checkbox" name="deletLotteryResultED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminED form-check-input box-check" type="checkbox" id="editLotteryResultED" name="editLotteryResultED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeLotteryResultED" name="seeLotteryResultED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="gameAndLotteryElement form-check-input" id="gamerListED" name="gamerListED"/> گیمر لیست </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superED form-check-input box-check" id="deletGamerListED" type="checkbox" name="deletGamerListED">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminED form-check-input box-check " type="checkbox" id="editGamerListED" name="editGamerListED">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check " type="checkbox" id="seeGamerListED" name="seeGamerListED">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 firstLevel"> <input type="checkbox" class="reportElementED form-check-input" id="onlinePaymentED" name="onlinePaymentED"/> پرداخت آنلاین  </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superED form-check-input box-check" id="deleteOnlinePaymentED" type="checkbox" name="deleteOnlinePaymentED">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminED form-check-input box-check" type="checkbox" id="editOnlinePaymentED" name="editOnlinePaymentED">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanED form-check-input box-check" type="checkbox" id="seeOnlinePaymentED" name="seeOnlinePaymentED">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-success btn-sm" form="editingKarbarForm">ذخیره <i class="fa fa-save"></i></button>
                     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">انصراف <i class="fa fa-xmark"></i> </button> 
                </div>
            </div>
        </form>
    </div>
 </div>
</div>
















<!-- modal for adding new karbar and new roles for karbar -->
     
<div class="modal fade dragAbleModal" id="addingKarbar" data-backdrop="static"  data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header myModalHeader py-2">
                <h5 class="modal-title" id="editKalaTitle"> افزودن کاربر  </h5>
               <span style="display: flex; float:left;"> <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button> </span>
            </div>
            <div class="modal-body p-1"> 
              <form action="{{url('/doAddAdmin')}}" method="post" enctype="multipart/form-data" id="addingKarbarForm" style="display:inline;">
                         @csrf
                  <div class='container descForall'>
                        <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text">نوع کاربر</span>
                                            <select class="form-select form-select-sm"  style="display:inline;" name="AdminTypeN" id="adminTypeN">
                                                <option value="admin">ادمین</option>
                                                <option value="poshtiban">پشتیبان</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> اسم </span>
                                        <input type="text" class="form-control" placeholder="اسم" name="name">
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">  فامیلی </span>
                                        <input type="text" class="form-control" name="lastName" placeholder="فامیلی">
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> نام کاربری </span>
                                        <input type="text" class="form-control" placeholder="نام کاربری" name="userName">
                                     </div>
                                 </div>
                                 
                          </div>
                          <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> رمز </span>
                                        <input type="password" class="form-control" placeholder="رمز" name="password">
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="input-group input-group-sm mb-3"> 
                                        <input type="file" class="form-control" id="userPic" placeholder="تصویر">
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-check d-flex flex-end mt-1">
                                        <input class="form-check-input p-2" type="radio" value="male" name="gender" id="manGender" checked> &nbsp;
                                        <label class="form-check-label mx-4 karbar-label fs-6" for="flexRadioDefault1">مرد </label> &nbsp; &nbsp;
                                        <input class="form-check-input p-2" type="radio" value="female" name="gender" id="womanGender"> &nbsp;
                                        <label class="form-check-label mx-4 karbar-label fs-6" for="flexRadioDefault2">زن</label>
                                    </div>
                                 </div>
                          </div>
                      </div>
                    <div class="container" style="background-color:#43bfa3; border-radius:5px 5px 2px 2px;">
                        <ul class="header-list nav nav-tabs" data-tabs="tabs">
                            <li><a class="active" data-toggle="tab" style="color:black;" href="#webManagementN"> اطلاعات پایه  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#peoplesN"> تعریف عناصر </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#kalasTabN">  عملیات  </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#messagesN"> گزارشات  </a></li>
                        </ul>
                        <div class="c-checkout tab-content" style="background-color:#f5f5f5; min-height:222px; padding:1%; border-radius:5px 5px 2px 2px;">
                            <div class="c-checkout tab-pane active" id="webManagementN" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto forLegend first"> <input type="checkbox" name="baseInfoN" id="baseInfoN" class="form-check-input"/>  اطلاعات پایه   </legend>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto forLegend firstLevel"> <input type="checkbox" name="settingsN" id="settingsN" class="form-check-input"/>  تظیمات  </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" name="mainPageSetting" id="mainPageSetting" class="allSettingsN webN form-check-input"/> تنظیمات صفحه اصلی </legend>
                                                        
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxN form-check-input box-check" id="deletMainPageSettingN" type="checkbox" name="deletMainPageSettingN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxN form-check-input box-check" id="editManiPageSettingN" type="checkbox" name="editManiPageSettingN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="mainPageSettingBoxN form-check-input box-check" id="seeMainPageSettingN" type="checkbox" name="seeMainPageSettingN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto secondLevel fs-6"> <input type="checkbox" name="specialSettingN" id="specialSettingN" class="allSettingsN form-check-input"/> تنظیمات اختصاصی  &nbsp;</legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxN form-check-input box-check" id="deleteSpecialSettingN" type="checkbox" name="deleteSpecialSettingN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxN form-check-input box-check" id="editSpecialSettingN" type="checkbox" name="editSpecialSettingN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="specialSettingBoxN form-check-input box-check" id="seeSpecialSettingN" type="checkbox"  name="seeSpecialSettingN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto secondLevel fs-6"> <input type="checkbox" id="emptyazSettingN" class="allSettingsN form-check-input" name="emptyazSettingN" /> تنظمیات امتیاز </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" id="deleteEmtyazSettingN" type="checkbox" name="deleteEmtyazSettingN"> 
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" type="checkbox" id="editEmptyazSettingN" name="editEmptyazSettingN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="emtyazSettingBox form-check-input" id="seeEmtyazSettingN" type="checkbox" name="seeEmtyazSettingN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="c-checkout tab-pane" id="peoplesN" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3">
                                            <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="personsN form-check-input" id="defineElementN" name="defineElementN"/> تعریف عناصر  </legend>
                                            <fieldset class="border rounded-3">
                                                <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="personsN form-check-input" id="karbaranN" name="karbaranN"/>کاربران </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="personN form-check-input" id="customersN" name="customersN"/>  کاربران  </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteCustomersN" type="checkbox" name="deleteCustomersN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editCustomerN" name="editCustomerN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeCustomersN" name="seeCustomersN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="c-checkout tab-pane" id="kalasTabN" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="operationN form-check-input" id="operationN" name="operationN"/>   عملیات   </legend>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="kalasN form-check-input" id="kalasN" name="kalasN"/> کالا ها </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="kalaListsN" name="kalaListsN"/> لیست کالاها </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteKalaListN" type="checkbox" name="deleteKalaListN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editKalaListN" name="editKalaListN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeKalaListN" name="seeKalaListN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="requestedKalaN" name="requestedKalaN"/> درخواستی ها </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteRequestedKalaN" type="checkbox" name="deleteRequestedKalaN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check " type="checkbox" id="editRequestedKalaN" name="editRequestedKalaN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check " type="checkbox" id="seeRequestedKalaN" name="seeRequestedKalaN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="fastKalaN" name="fastKalaN"/> فست کالا </legend>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="superN form-check-input box-check" id="deleteFastKalaN" type="checkbox" name="deleteFastKalaN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="adminN form-check-input box-check" type="checkbox" id="editFastKalaN" name="editFastKalaN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeFastKalaN" name="seeFastKalaN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="pishKharidN" name="pishKharidN" /> پیش خرید </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deletePishKharidN" type="checkbox" name="deletePishKharidN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editPishkharidN" name="editPishkharidN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox"  id="seePishKharidN" name="seePishKharidN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="brandsN" name="brandsN"/> برند ها </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteBrandsN" type="checkbox" name="deleteBrandsN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editBrandN" name="editBrandN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeBrandsN" name="seeBrandsN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="alertedN" name="alertedN"/> کالاهای شامل هشدار </legend>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="superN form-check-input box-check" id="deleteAlertedN" type="checkbox" name="deleteAlertedN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editAlertedN" name="editAlertedN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeAlertedN" name="seeAlertedN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="kalaGroupN" name="kalaGroupN" /> دسته بندی کالاها </legend>
                                                    
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deletKalaGroupN" type="checkbox" name="deletKalaGroupN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editKalaGroupN" name="editKalaGroupN" >
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeKalaGroupN" name="seeKalaGroupN" >
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="orderSalesN" name="orderSalesN" /> سفارشات فروش  </legend>
                                                    
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteOrderSalesN" type="checkbox" name="deleteOrderSalesN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editOrderSalesN" name="editOrderSalesN" >
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeSalesOrderN" name="seeSalesOrderN" >
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="messageN" name="messageN" /> پیام ها  </legend>
                                                    
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteMessageN" type="checkbox" name="deleteMessageN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editMessageN" name="editMessageN" >
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeMessageN" name="seeMessageN" >
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="factorN" name="factorN" /> فاکتور  </legend>
                                                    
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteFactorN" type="checkbox" name="deleteFactorN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editFactorN" name="editFactorN" >
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeFactorN" name="seeFactorN" >
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="kalaElement form-check-input" id="bargiriN" name="bargiriN" /> بارگیری فاکتور  </legend>
                                                    
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteBargiriN" type="checkbox" name="deleteBargiriN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editBargiriN" name="editBargiriN" >
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeBargiriN" name="seeBargiriN" >
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                        </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>


                            <div class="c-checkout tab-pane" id="messagesN" style="border-radius:10px 10px 2px 2px;">
                                <div class="container">
                                    <div class="row">
                                        <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                            <legend  class="float-none w-auto forLegend first"><input type="checkbox" class="kalasN form-check-input" id="reportN" name="reportN"/>  گزارشات  </legend>
                                                
                                                
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto firstLevel"><input type="checkbox" class="reportElementN form-check-input" id="reportCustomerN" name="reportCustomerN"/>  مشتریان </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="cutomerListN form-check-input" id="cutomerListN" name="customerListN"/> لیست مشتریان </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deletCustomerListN" type="checkbox" name="deletCustomerListN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editCustomerListN" name="editCustomerListN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeCustomerListN" name="seeCustomerListN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="cutomerListN form-check-input" id="officialCustomerN" name="officialCustomerN"/> اشخاص رسمی </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deleteOfficialCustomerN" type="checkbox" name="deleteOfficialCustomerN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check " type="checkbox" id="editOfficialCustomerN" name="editOfficialCustomerN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check " type="checkbox" id="seeOfficialCustomerN" name="seeOfficialCustomerN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto forLegend firstLevel"><input type="checkbox" class="reportElementN form-check-input" id="gameAndLotteryN" name="gameAndLotteryN"/>  بازیها و لاتری </legend>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="gameAndLotteryElement form-check-input" id="lotteryResultN" name="lotteryResultN"/> نتیجه لاتری  </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deletLotteryResultN" type="checkbox" name="deletLotteryResultN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check" type="checkbox" id="editLotteryResultN" name="editLotteryResultN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeLotteryResultN" name="seeLotteryResultN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                    <legend  class="float-none w-auto fs-6 secondLevel"> <input type="checkbox" class="gameAndLotteryElement form-check-input" id="gamerListN" name="gamerListN"/> گیمر لیست </legend>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="superN form-check-input box-check" id="deletGamerListN" type="checkbox" name="deletGamerListN">
                                                        <label class="form-check-label">حذف</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                        <input class="adminN form-check-input box-check " type="checkbox" id="editGamerListN" name="editGamerListN">
                                                        <label class="form-check-label">تغییر</label>
                                                    </div>
                                                    <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check " type="checkbox" id="seeGamerListN" name="seeGamerListN">
                                                        <label class="form-check-label">مشاهده</label>
                                                    </div>
                                                </fieldset>
                                            </fieldset>
                                            <fieldset class="border rounded-3" style="display: justify-content:flex-start; float: right;">
                                                <legend  class="float-none w-auto fs-6 firstLevel"> <input type="checkbox" class="reportElementN form-check-input" id="onlinePaymentN" name="onlinePaymentN"/> پرداخت آنلاین  </legend>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="superN form-check-input box-check" id="deleteOnlinePaymentN" type="checkbox" name="deleteOnlinePaymentN">
                                                    <label class="form-check-label">حذف</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="adminN form-check-input box-check" type="checkbox" id="editOnlinePaymentN" name="editOnlinePaymentN">
                                                    <label class="form-check-label">تغییر</label>
                                                </div>
                                                <div class="form-check admin-accesss-level">
                                                    <input class="poshtibanN form-check-input box-check" type="checkbox" id="seeOnlinePaymentN" name="seeOnlinePaymentN">
                                                    <label class="form-check-label">مشاهده</label>
                                                </div>
                                            </fieldset>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-success btn-sm" form="addingKarbarForm">ذخیره <i class="fa fa-save"></i></button>
                     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">انصراف <i class="fa fa-xmark"></i> </button>  
                </div>
               </div>
            </form>
          </div>
    </div>
</main>

<script>
$("#addingNewKarbar").on("click", ()=>{
	  if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 111
                });
              }
              $('#addingKarbar').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
  $("#addingKarbar").modal("show");
});

$('label:contains("حذف")').css('color', '#ec2947');
$('label:contains("تغییر")').css('color', '#ffbf35');
$('label:contains("مشاهده")').css('color', '#00a4b6');
</script>
@endsection
