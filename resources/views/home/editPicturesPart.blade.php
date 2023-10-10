@extends('admin.layout')
@section('content')
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                    <!-- <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="elseSettingsRadio">
                        <label class="form-check-label me-4" for="assesPast">  سطح دسترسی  </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="settingAndTargetRadio">
                        <label class="form-check-label me-4" for="assesPast"> تارگت ها و امتیازات </label>
                    </div> -->
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader" style="height:2%"> </div>

                <div class="row mainContent">
                    @foreach ($parts as $part)
                        <form class="p-1" action="{{ url('/doEditGroupPart') }}" method="POST" enctype="multipart/form-data" class='form'>
                            @csrf
                                  <div class="row ">
                                        <div class="col-sm-3">
                                            <div class='form-group'>
                                                <label class='form-label'>اسم سطر</label>
                                                <input type='text' id='partTitle'   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif value="{{  trim($part->partTitle) }}" class='form-control form-control-sm' name='partTitle' placeholder='' />
                                                <input type='text' id='partId' style="display: none" value="{{ $part->partId }}" class='form-control' name='partId' placeholder='' />
                                            </div>
                                        </div>   

                                        <div class="col-sm-3">
                                            <div class='form-group'>
                                                <label class='form-label'>نوعیت دسته بندی</label>
                                                <select name='partType' @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif onchange='showDiv(this)' class='form-control form-control-sm' id='partType'>
                                                    <option value="{{ $part->partType }}">{{ $part->name }}</option>
                                                </select>
                                            </div>
                                        </div>  

                                        <div class="col-sm-2"> 
                                            <div class='form-group'>
                                                <label class='form-label'>اولویت</label>
                                                <select type='text' id="PicturePriority" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif value="{{ $part->priority }}"
                                                    class='form-select form-select-sm' name='partPriority' placeholder='' >
                                                     @for ($i =3; $i <= (int)$countHomeParts; $i++)
                                                        <option @if((int)$part->priority==$i) selected @endif value="{{$i}}">{{$i-2}}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>  
                                        <div class="col-sm-1 d-flex align-items-stretch">
                                            <div class="form-group d-flex text-nowrap align-items-center pt-3">
                                                <input class="form-control d-flex form-check-input align-items-end" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name="activeOrNot" id="activeOrNot" @if ($part->activeOrNot==1)checked @else @endif>
                                                <label class="form-check-label align-items-end" style="font-weight: bold" for="activeOrNot">نمایش</label>
                                            </div>
                                        </div>
                                         <div class="col-sm-3 text-end"> 
                                              <button type="submit"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif class="btn btn-success btn-sm text-warning mt-1"> ذخیره <i class="fa-light fa-save"></i></button>
                                         </div>
                                    </div>
                           
                                
                                        <div class="row p-0 m-0" id="addTakhsisKala">
                                            <div class='modal-body p-0'style="display:flex;  justify-content:center;">
                                                <div id='pslider' class='swiper-container swiper-container-horizontal swiper-container-rtl' style="width:100%">
                                                    <div class='product-box swiper-wrapper rounded border border-success' id="addBrandItem">
                                                        @if($part->partType!=12)
                                                            @foreach ($pictures as $pic)
                                                            <div class='product-item swiper-slide'>
                                                                <div class="p-0 justify-content-start">
                                                                        @if($part->partType==6)
                                                                        <img class="p-0" src="{{url('/resources/assets/images/onePic/'.$part->partId.'.jpg')}}" id="PicId{{$loop->iteration}}" />
                                                                        @elseif($part->partType==7)
                                                                        <img class="p-0" src="{{url('/resources/assets/images/twoPics/'.$part->partId.'_'.($loop->iteration).'.jpg')}}" id="PicId{{$loop->iteration}}" />
                                                                        @elseif($part->partType==8)
                                                                        <img class="p-0" src="{{url('/resources/assets/images/threePics/'.$part->partId.'_'.($loop->iteration).'.jpg')}}" id="PicId{{$loop->iteration}}" />
                                                                        @elseif($part->partType==9)
                                                                        <img class="p-0" src="{{url('/resources/assets/images/fourPics/'.$part->partId.'_'.($loop->iteration).'.jpg')}}" id="PicId{{$loop->iteration}}" />
                                                                        @elseif($part->partType==10)
                                                                        <img class="p-0" src="{{url('/resources/assets/images/fivePics/'.$part->partId.'_'.($loop->iteration).'.jpg')}}" id="PicId{{$loop->iteration}}" />
                                                                        
                                                                        @endif
                                                                        <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->picId}}"/>
                                                                        <input style="display:none" name="pic{{$loop->iteration}}" value="{{$pic->picId}}"/>
                                                                </div> <br>
                                                                <div class="p-0 pt-1">
                                                                    <button type="button"    @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 ) onclick="changePicBrandKalaEdit(this)" @endif value="{{$loop->iteration}}" style="display: inline; padding:0; border:none; background:none" class="editKalaPic1_5Pic">
                                                                        <i class="fa-light fa-pen-to-square fa-lg text-success p-1 inheritHover" style="font-size: 25px"></i>
                                                                    </button>
                                                                    <input type="file" style="display:none;" onchange='document.getElementById("PicId{{$loop->iteration}}").src = window.URL.createObjectURL(this.files[0])' id="file{{$loop->iteration}}" name="editPic{{$loop->iteration}}"/>
                                                                    <button type="button" id="assignToType{{$part->partType}}Pic{{ $loop->iteration }}" class="takhsisKala1_5Pic" value="{{$pic->picId}}" type="button" onclick="this.querySelector('i.inheritHover').style.setProperty('color', 'red', 'important');" style="display: inline; padding:0; border:none; background:none">
                                                                         <i class="fa-light fa-circle-plus fa-lg text-success p-0 inheritHover" style="font-size: 27px; padding:0;"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                           @endforeach
                                                    </div>
                                                </div>
                                             </div>
                                           </div>
                                        </div>
                                        @else 
                                    
                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-hover table-sm">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>اسم برند&nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0">  </div> </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="brandAllKalaContainer" >
                                                        @foreach ($brands as $brand)
                                                            <tr  onclick="checkCheckBox(this,event)">
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$brand->name}}</td>
                                                                <td>
                                                                <input class="form-check-input" name="brandAllKala[]" type="checkbox" value="{{$brand->id.'_'.$brand->name}}" id="kalaId">
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item text-center mt-5">
                                                <button type="button"  style="background-color:transparent;" type="button" id="addBrandKalaList" onclick="addAllKalaToBrand(this)" value=""
                                                                class="brandBetweenButton"  style="display: inline; padding:0; border:none; background:none">
                                                    <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i></button>
                                                        <br/>
                                                        <button type="button"  style="background-color:transparent;"  type="button" id="removeBrandKalaList" onclick="removeAddedKalaFromBrand(this)" value=""
                                                                class="brandBetweenButton"style="display: inline; padding:0; border:none; background:none">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i></button>
                                            </div>

                                            <div class="subgroup-item">
                                                <table class="t table table-bordered table table-hover table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>اسم برند
                                                            <button  class='brandPriority' id="down" type="button" value="down" ><i class="fa-solid fa-circle-chevron-down fa-sm" style=''></i></button>
                                                            <button class='brandPriority' id="top"  type="button" value="up" >  <i class="fa-solid fa-circle-chevron-up fa-sm" style=''></i></button> 
                                                        </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="brandAddedKalaContainer">
                                                        @foreach ($addedBrands as $brand)
                                                        <tr  onclick="checkCheckBox(this,event)">
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$brand->name}}</td>
                                                                <td>
                                                                <input class="form-check-input" name="brandAddedKala[]" type="checkbox" value="{{$brand->id}}" id="kalaId">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                     @endif      
                                        {{-- برای نشان دادن کالاهای مربوط به تک تصویر  --}}
                                 <div class='c-checkout mt-2' id="picturesKalaContainer" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                         <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit1Pic1">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit1Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit1Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-sm">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="onePic1AllKala"> </tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item mt-5">
                                                <button type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="addOnePicKalaList1" style="display: inline; padding:0; border:none; background:none">
                                                <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i> </button>
                                                <br />
                                                <button type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="removeOnePicKalaList1" style="display: inline; padding:0; border:none; background:none">
                                                 <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i> </button>
                                            </div>
                                            <div class="subgroup-item">
                                                    <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="onePic1AddedKala1"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        {{-- آخر تک عکسی --}}
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر اول دو تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer2Pic1" style="display:none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                         <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit2Pic1">
                                                </div>
                                                </div>

                                                <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit2Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit2Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                 <table class="table table-bordered  table-sm">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 1 </div></th>
                                                            <th>
                                                                <input type="checkbox" name=""  class="selectAllFromTop form-check-input"  >
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;" id="twoPicAllKala1"></tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item mt-5">
                                                <button type="button"  style="background-color:transparent;" id="add2PicKalaList1" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif>
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                    </button>
                                                    <br />
                                                <button type="button"  style="background-color:transparent;" id="remove2PicKalaList1"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif>
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                            </div>
                                            <div class="subgroup-item">
                                                 <table class="table table-bordered table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;"  id="twoPicAddedKala1"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر دوم دو تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer2Pic2" style="display:none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                         <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit2Pic2">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit2Pic2">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit2Pic2">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 2 </div></th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;"  id="twoPicAllKala2"></tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item mt-5">
                                                <button type="button"   style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add2PicKalaList2">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                     </button>
                                                        <br />
                                                <button type="button"   style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove2PicKalaList2">
                                                <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                </button>
                                            </div>
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;" id="twoPicAddedKala2"> </tbody>
                                                </table>
                                            </div>
                                     </div>   
                                </div>  
                            </div>  
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر اول سه تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer3Pic1" style="display: none; none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                         <div class="row">
                                               <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit3Pic1">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit3Pic1">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit3Pic1">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                      <table class="tableSection table table-bordered table table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 1 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="threePicAllKala1"> </tbody>
                                                    </table>
                                                </div>
                                                <div class="subgroup-item mt-5">
                                                    <button type="button"  style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add3PicKalaList1">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                        </button>
                                                        <br />
                                                    <button type="button"  style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove3PicKalaList1">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                        </button>
                                                </div>
                                                <div class="subgroup-item">
                                                    <table class="tableSection table table-bordered table-sm">
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th>گروه اصلی </th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;" id="threePicAddedKala1"> </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر دوم سه تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer3Pic2" style="display: none; none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit3Pic2">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit3Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit3Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 2 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="threePicAllKala2"> </tbody>
                                                    </table>
                                                </div>

                                                <div class="subgroup-item mt-5">
                                                    <button type="button"   style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add3PicKalaList2">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                    </button>
                                                        <br />
                                                        <button type="button"  style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove3PicKalaList2">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                                </div>
                                                <div class="subgroup-item">
                                                     <table class="tableSection table table-bordered table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>گروه اصلی </th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="threePicAddedKala2"> </tbody>
                                                    </table>
                                                </div>
                                         </div>
                                   </div>
                            </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر سوم سه تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer3Pic3" style="display: none; none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit3Pic3">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit3Pic3">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit3Pic3">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                     <table class="table table-bordered table-hover table-sm">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 3 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="threePicAllKala3"></tbody>
                                                    </table>
                                                </div>
                                                <div class="subgroup-item mt-5">
                                                    <button type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add3PicKalaList3">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                        </button>
                                                        <br />
                                                        <button type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove3PicKalaList3">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                                </div>
                                                <div class="subgroup-item">
                                                     <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>گروه اصلی </th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="threePicAddedKala3"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر اول 4 تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer4Pic1" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                           <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit4Pic1">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit4Pic1">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit4Pic1">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-subgroup">
                                                    <div class="subgroup-item">
                                                        <table class="table table-bordered table-hover table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                        class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 1 </div></th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;"  id="fourPicAllKala1"> </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="subgroup-item mt-5">
                                                            <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add4PicKalaList1">
                                                            <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                            </button>
                                                            <br />
                                                            <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove4PicKalaList1">
                                                            <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                            </button>
                                                    </div>
                                                    <div class="subgroup-item">
                                                        <table class="table table-bordered table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th>گروه اصلی </th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;"  id="fourPicAddedKala1"> </tbody>
                                                        </table>
                                                    </div>
                                             </div>
                                      </div>
                                  </div>

                                        {{-- برای نشان دادن کالاهای مربوط به تصویر دوم 4 تصویره --}}
                                 <div class='c-checkout mt-2'  id="picturesKalaContainer4Pic2" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                     <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit4Pic2">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit4Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit4Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid-subgroup">
                                                    <div class="subgroup-item">
                                                        <table class="table table-bordered table-hover table-sm">
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th> اسم کالا </th>
                                                                    <th> <input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"> </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;" id="fourPicAllKala2"> </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="subgroup-item mt-5">
                                                        <button  style="background-color:transparent;" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add4PicKalaList2">
                                                            <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                            </button>
                                                            <br />
                                                            <button  style="background-color:transparent;" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove4PicKalaList2">
                                                            <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                        </button>
                                                    </div>
                                                    <div class="subgroup-item">
                                                        <table class="table table-bordered table-hover table-sm">
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th>گروه اصلی </th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;" id="fourPicAddedKala2"> </tbody>
                                                        </table>
                                                    </div>
                                             </div>
                                       </div>
                                   </div>

                                        {{-- برای نشان دادن کالاهای مربوط به تصویر سوم 4 تصویره --}}
                                <div class='c-checkout mt-2'  id="picturesKalaContainer4Pic3" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                             <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">جستجو</label>
                                                            <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit4Pic3">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label"> جستجوی گروه اصلی</label>
                                                            <select class="form-control form-control-sm" id="searchMainGroupEdit4Pic3">
                                                                <option value="0">همه کالا ها</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label"> جستجوی گروه فرعی</label>
                                                            <select class="form-control form-control-sm" id="searchSubGroupEdit4Pic3">
                                                                <option value="0">همه کالا ها</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="grid-subgroup">
                                                    <div class="subgroup-item">
                                                        <table class="table table-bordered  table-hover table-sm ">
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                        class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 3 </div></th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;"  id="fourPicAllKala3"> </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="subgroup-item mt-5">
                                                           <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add4PicKalaList3">
                                                          <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                            </button>
                                                                <br />
                                                                <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove4PicKalaList3">
                                                                <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                            </button>
                                                    </div>
                                                    <div class="subgroup-item">
                                                         <table class="table table-bordered table table-hover table-sm ">
                                                            <thead class="tableHeader">
                                                                <tr>
                                                                    <th>ردیف</th>
                                                                    <th>گروه اصلی </th>
                                                                    <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tableBody" style="height:300px !important;"  id="fourPicAddedKala3"> </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر چهارم 4 تصویره --}}
                                 <div class='c-checkout mt-2'  id="picturesKalaContainer4Pic4" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                     <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit4Pic4">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit4Pic4">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit4Pic4">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                    <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 4 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="fourPicAllKala4"> </tbody>
                                                    </table>
                                                </div>
                                                <div class="subgroup-item mt-5">
                                                    <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add4PicKalaList4">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                    </button>
                                                        <br />
                                                        <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove4PicKalaList4">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                                </div>
                                                <div class="subgroup-item">
                                                     <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>گروه اصلی </th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="fourPicAddedKala4"> </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                                 {{-- برای نشان دادن کالاهای مربوط به تصویر اول 5 تصویره --}}
                                <div class='c-checkout mt-2'   id="picturesKalaContainer5Pic1" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit5Pic1">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit5Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit5Pic1">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                 <table class="table table-bordered table table-hover table-sm">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 1 </div></th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;"  id="fivePicAllKala1"> </tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item mt-5">
                                                <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add5PicKalaList1">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                </button>
                                                    <br />
                                                    <button  type="button"  style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove5PicKalaList1">
                                                    <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                </button>
                                            </div>
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;" id="fivePicAddedKala1"> </tbody>
                                                </table>
                                            </div>
                                     </div>
                                </div>
                            </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر دوم 5 تصویره --}}
                                <div class='c-checkout mt-2'   id="picturesKalaContainer5Pic2" style="display:none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit5Pic2">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit5Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit5Pic2">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                    <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 2 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;" id="fivePicAllKala2"> </tbody>
                                                    </table>
                                                </div>
                                                <div class="subgroup-item mt-5">
                                                    <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add5PicKalaList2">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                    </button>
                                                        <br />
                                                        <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove5PicKalaList2">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                                </div>
                                                <div class="subgroup-item">
                                                    <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>گروه اصلی </th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;" id="fivePicAddedKala2"> </tbody>
                                                    </table>
                                                </div>
                                         </div>
                                     </div>
                                </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر سوم 5 تصویره --}}
                                <div class='c-checkout mt-2'    id="picturesKalaContainer5Pic3" style="display:none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit5Pic3">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-control form-control-sm" id="searchMainGroupEdit5Pic3">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-control form-control-sm" id="searchSubGroupEdit5Pic3">
                                                            <option value="0">همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-subgroup">
                                                <div class="subgroup-item">
                                                    <table class="tableSection table table-bordered table table-hover table-sm " style='td:hover{ cursor:move;}'>
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th> اسم کالا &nbsp;&nbsp;<div style="background-color:black;color:white!important; height:inherit; width:20px;"
                                                                    class="rounded-circle d-inline-flex justify-content-center m-0 p-0"> 3 </div></th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="fivePicAllKala3"> </tbody>
                                                    </table>
                                                </div>

                                                <div class="subgroup-item mt-5">
                                                     <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add5PicKalaList3">
                                                        <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                        </button>
                                                        <br />
                                                        <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove5PicKalaList3">
                                                        <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                                </div>
                                                <div class="subgroup-item">
                                                    <table class="table table-bordered table table-hover table-sm ">
                                                        <thead class="tableHeader">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>گروه اصلی </th>
                                                                <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody" style="height:300px !important;"  id="fivePicAddedKala3"> </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر چهارم 5 تصویره --}}
                                <div class='c-checkout mt-2'    id="picturesKalaContainer5Pic4" style="display:none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit5Pic4">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit5Pic4">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit5Pic4">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                 <table class="table table-bordered table table-hover table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;"  id="fivePicAllKala4"> </tbody>
                                                </table>
                                            </div>
                                            <div class="subgroup-item mt-5">
                                                 <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add5PicKalaList4">
                                                    <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                    </button>
                                                    <br />
                                                    <button  type="button" style="background-color:transparent;" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove5PicKalaList4">
                                                    <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                    </button>
                                            </div>
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-hover table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height:300px !important;"  id="fivePicAddedKala4"> </tbody>
                                                </table>
                                            </div>
                                        </div>
                                  </div>
                              </div>
                                        {{-- برای نشان دادن کالاهای مربوط به تصویر پنجم 5 تصویره --}}
                                <div class='c-checkout mt-2'    id="picturesKalaContainer5Pic5" style="display: none; margin:0 auto; width:100%; padding-right:0; border-radius:10px 10px 2px 2px; padding:0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" size="20" class="form-control form-control-sm" id="searchKalaEdit5Pic5">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroupEdit5Pic5">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-control form-control-sm" id="searchSubGroupEdit5Pic5">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-subgroup">
                                            <div class="subgroup-item">
                                                <table class="table table-bordered table table-hover table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th> اسم کالا </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" id="fivePicAllKala5"> </tbody>
                                                </table>
                                            </div>

                                            <div class="subgroup-item mt-5">
                                                 <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="add5PicKalaList5">
                                                <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                                </button>
                                                <br />
                                                <button  type="button" style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif id="remove5PicKalaList5">
                                                <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                                </button>
                                            </div>

                                            <div class="subgroup-item">
                                                  <table class="table table-bordered table table-hover table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  disabled @endif type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableHeader" id="fivePicAddedKala5">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                               </div>
                            </div>
                        </form>
                    @endforeach
                </div>
              <div class="row contentFooter"> </div>
            </div>
        </div>
   </div>

    <script>
        window.onload = function() {
            //used for dispalying kala TO pic 1(1pic edit)
            let assignToType6Pic1=0;
            $(document).on('click', '#assignToType6Pic1', (function() {
                assignToType6Pic1++;
                if(assignToType6Pic1==1){
                $('#picturesKalaContainer').css("display","block");
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic1').val()},
                    success: function(arrayed_result) {
						console.log(arrayed_result);
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#onePic1AllKala').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="onePicAddedKalaListIds1[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
                        //used for displaying kala to the left side of one pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#onePic1AddedKala1').append(`
                            <tr class="addedTr1"  onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="onePicAddedKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit1Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }else{
                
            }
            }));
//used for removing data from left side(1 pic 1)
        $(document).on('click', '#removeOnePicKalaList1', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split("_")[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic1').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#onePic1AddedKala1').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#onePic1AddedKala1').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(1 pic 1)
        $(document).on('click', '#addOnePicKalaList1', (function() {
            var kalaListID = [];
            $('input[name="onePicAddedKalaListIds1[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="onePicAddedKalaListIds1[]"]:checked').parents('tr').css('color','red');
            $('input[name="onePicAddedKalaListIds1[]"]:checked').prop("disabled", true);
            $('input[name="onePicAddedKalaListIds1[]"]:checked').prop("checked", false);
        $.ajax({
                method: 'get',
                url: "{{ url('/addKalatoPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID,
                    partId:$('#pic1').val(),
                    partType:'picture',
                },
                success: function(arrayed_result) {
                    $('#onePic1AddedKala1').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#onePic1AddedKala1').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });  
        }));

//برا دو تصویره
let assignToType7Pic1=0;
            //used for dispalying kala TO pic 1(2pic edit)
            $(document).on('click', '#assignToType7Pic1', (function() {
                $('#picturesKalaContainer2Pic1').fadeIn();
                $('#picturesKalaContainer2Pic2').fadeOut();
                assignToType7Pic1++;
                if(assignToType7Pic1==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic1').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#twoPicAllKala1').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="twoPicAddedKalaListIds1[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
                        //used for displaying kala to the left side of 2 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#twoPicAddedKala1').append(`
                            <tr class="addedTr1"  onclick="checkCheckBox(this,event)">
                                <td>` +(i+1)+ `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="twoPicAddedKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn+ `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit2Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(2 pic 1)
        $(document).on('click', '#remove2PicKalaList1', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val());
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic1').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    alert('good');
                    $('#twoPicAddedKala1').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#twoPicAddedKala1').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
        }));

//used for adding kala to the left side(2 pic 1)
        $(document).on('click', '#add2PicKalaList1', (function() {
            var kalaListID = [];
            let partPic=$('#pic1').val()
            $('input[name="twoPicAddedKalaListIds1[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="twoPicAddedKalaListIds1[]"]:checked').parents('tr').css('color','red');
            $('input[name="twoPicAddedKalaListIds1[]"]:checked').prop("disabled", true);
            $('input[name="twoPicAddedKalaListIds1[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:partPic,
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#twoPicAddedKala1').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#twoPicAddedKala1').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            ));

//used for dispalying kala TO pic 2(2pic edit)
        let assignToType7Pic2=0;
           $(document).on('click', '#assignToType7Pic2', (function() {
                $('#picturesKalaContainer2Pic2').fadeIn();
                $('#picturesKalaContainer2Pic1').fadeOut();
                assignToType7Pic2++;
                if(assignToType7Pic2==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic2').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#twoPicAllKala2').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="twoPicAddedKalaListIds2[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
                        //used for displaying kala to the left side of 2 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#twoPicAddedKala2').append(`
                            <tr class="addedTr2" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="twoPicAddedKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit2Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(2 pic 2)
        $(document).on('click', '#remove2PicKalaList2', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val());
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic2').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    alert('good');
                    $('#twoPicAddedKala2').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#twoPicAddedKala2').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(2 pic 2)
        $(document).on('click', '#add2PicKalaList2', (function() {
            var kalaListID = [];
            $('input[name="twoPicAddedKalaListIds2[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="twoPicAddedKalaListIds2[]"]:checked').parents('tr').css('color','red');
            $('input[name="twoPicAddedKalaListIds2[]"]:checked').prop("disabled", true);
            $('input[name="twoPicAddedKalaListIds2[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic2').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#twoPicAddedKala2').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#twoPicAddedKala2').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });   
            }));

            //برا 3 تصویره

            //used for dispalying kala TO pic 1(3pic edit)
            let assignToType8Pic1=0;
            $(document).on('click', '#assignToType8Pic1', (function() {
                $('#picturesKalaContainer3Pic1').fadeIn();
                $('#picturesKalaContainer3Pic2').fadeOut();
                $('#picturesKalaContainer3Pic3').fadeOut();
                $('#threePicAddedKala1').empty();
                assignToType8Pic1++;
                if(assignToType8Pic1==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic1').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#threePicAllKala1').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="threePicAddedKalaListIds1[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i].GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
                        //used for displaying kala to the left side of 3 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#threePicAddedKala1').append(`
                            <tr class="addedTr1" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="threePicAddedKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit3Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(3 pic 1)
        $(document).on('click', '#remove3PicKalaList1', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic1').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#threePicAddedKala2').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#threePicAddedKala2').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(3 pic 1)
        $(document).on('click', '#add3PicKalaList1', (function() {
            var kalaListID = [];
            $('input[name="threePicAddedKalaListIds1[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="threePicAddedKalaListIds1[]"]:checked').parents('tr').css('color','red');
            $('input[name="threePicAddedKalaListIds1[]"]:checked').prop("disabled", true);
            $('input[name="threePicAddedKalaListIds1[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic1').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#threePicAddedKala1').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#threePicAddedKala1').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });  
            }));

//used for dispalying kala TO pic 3(3pic edit)
let assignToType8Pic2=0;
           $(document).on('click', '#assignToType8Pic2', (function() {
                $('#picturesKalaContainer3Pic2').fadeIn();
                $('#picturesKalaContainer3Pic3').fadeOut();
                $('#picturesKalaContainer3Pic1').fadeOut();
                assignToType8Pic2++;
                if(assignToType8Pic2==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic2').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#threePicAllKala2').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="threePicAddedKalaListIds2[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 3 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#threePicAddedKala2').append(`
                            <tr class="addedTr2" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="threePicAddedKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn +`" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit3Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(3 pic 2)
        $(document).on('click', '#remove3PicKalaList2', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic2').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#threePicAddedKala2').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#threePicAddedKala2').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(3 pic 2)
        $(document).on('click', '#add3PicKalaList2', (function() {
            var kalaListID = [];
            $('input[name="threePicAddedKalaListIds2[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="threePicAddedKalaListIds2[]"]:checked').parents('tr').css('color','red');
            $('input[name="threePicAddedKalaListIds2[]"]:checked').prop("disabled", true);
            $('input[name="threePicAddedKalaListIds2[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic2').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#threePicAddedKala2').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#threePicAddedKala2').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));
//used for dispalying kala TO pic 3(3pic edit)
let assignToType8Pic3=0;
$(document).on('click', '#assignToType8Pic3', (function() {
                $('#picturesKalaContainer3Pic3').fadeIn();
                $('#picturesKalaContainer3Pic2').fadeOut();
                $('#picturesKalaContainer3Pic1').fadeOut();
                assignToType8Pic3++;
                if(assignToType8Pic3==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic3').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                        $('#threePicAllKala3').append(`
                        <tr  onclick="checkCheckBox(this,event)">
                            <td>` + (i+1) + `</td>
                            <td>` + arrayed_result.allKala[i].GoodName + `</td>
                            <td>
                            <input class="form-check-input" name="threePicAddedKalaListIds3[]" type="checkbox" value="` +
                            arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                        .GoodName + `" id="kalaId">
                            </td>
                        </tr>
                        `);
                        }
 //used for displaying kala to the left side of 3 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#threePicAddedKala3').append(`
                            <tr class="addedTr3" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="threePicAddedKalaListIds3[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn +`" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit3Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(3 pic 3)
        $(document).on('click', '#remove3PicKalaList3', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic3').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#threePicAddedKala3').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#threePicAddedKala3').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="addedKala1[]" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(3 pic 3)
        $(document).on('click', '#add3PicKalaList3', (function() {
            var kalaListID = [];
            $('input[name="threePicAddedKalaListIds3[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="threePicAddedKalaListIds3[]"]:checked').parents('tr').css('color','red');
            $('input[name="threePicAddedKalaListIds3[]"]:checked').prop("disabled", true);
            $('input[name="threePicAddedKalaListIds3[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic3').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#threePicAddedKala3').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#threePicAddedKala3').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));


            //برا 4 تصویره
            assignToType9Pic1=0;
            //used for dispalying kala TO pic 1(4pic edit)
            $(document).on('click', '#assignToType9Pic1', (function() {
                $('#picturesKalaContainer4Pic1').fadeIn();
                $('#picturesKalaContainer4Pic2').fadeOut();
                $('#picturesKalaContainer4Pic3').fadeOut();
                $('#picturesKalaContainer4Pic4').fadeOut();
                assignToType9Pic1++;
                if(assignToType9Pic1==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic1').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                    $('#fourPicAllKala1').append(`
                    <tr  onclick="checkCheckBox(this,event)">
                        <td>` + (i+1) + `</td>
                        <td>` + arrayed_result.allKala[i].GoodName + `</td>
                        <td>
                        <input class="form-check-input" name="fourPicAddedKalaListIds1[]" type="checkbox" value="` +
                        arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                    .GoodName + `" id="kalaId">
                        </td>
                    </tr>
                    `);
                        }
                        //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fourPicAddedKala1').append(`
                            <tr class="addedTr1" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fourPicAddedKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit4Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(4 pic 1)
        $(document).on('click', '#remove4PicKalaList1', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic1').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fourPicAddedKala1').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#fourPicAddedKala1').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(4 pic 1)
        $(document).on('click', '#add4PicKalaList1', (function() {
            var kalaListID = [];
            $('input[name="fourPicAddedKalaListIds1[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fourPicAddedKalaListIds1[]"]:checked').parents('tr').css('color','red');
            $('input[name="fourPicAddedKalaListIds1[]"]:checked').prop("disabled", true);
            $('input[name="fourPicAddedKalaListIds1[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic1').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fourPicAddedKala1').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fourPicAddedKala1').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));

//used for dispalying kala TO pic 2(4pic edit)
        let assignToType9Pic2=0;
           $(document).on('click', '#assignToType9Pic2', (function() {
                $('#picturesKalaContainer4Pic2').fadeIn();
                $('#picturesKalaContainer4Pic1').fadeOut();
                $('#picturesKalaContainer4Pic3').fadeOut();
                $('#picturesKalaContainer4Pic4').fadeOut();
                
                assignToType9Pic2++;
                if(assignToType9Pic2==1){
                    
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic2').val()},
                    success: function(arrayed_result) {
                        
                    for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {
                        $('#fourPicAllKala2').append(`
                        <tr  onclick="checkCheckBox(this,event)">
                            <td>` + (i+1) + `</td>
                            <td>` + arrayed_result.allKala[i].GoodName + `</td>
                            <td>
                            <input class="form-check-input" name="fourPicAddedKalaListIds2[]" type="checkbox" value="` +
                            arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i].GoodName + `" id="kalaId">
                            </td>
                        </tr>`); 
                    }
                    
 //used for displaying kala to the left side of 3 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fourPicAddedKala2').append(`
                            <tr class="addedTr2" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fourPicAddedKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                                    
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit4Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                }
                                
            }));
            
//used for removing data from left side(4 pic 2)
        $(document).on('click', '#remove4PicKalaList2', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic2').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fourPicAddedKala2').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#fourPicAddedKala2').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(4 pic 2)
        $(document).on('click', '#add4PicKalaList2', (function() {
            var kalaListID = [];
            $('input[name="fourPicAddedKalaListIds2[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fourPicAddedKalaListIds2[]"]:checked').parents('tr').css('color','red');
            $('input[name="fourPicAddedKalaListIds2[]"]:checked').prop("disabled", true);
            $('input[name="fourPicAddedKalaListIds2[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic2').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fourPicAddedKala2').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            $('#fourPicAddedKala2').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });     
            }));
//used for dispalying kala TO pic 3(4pic edit)
let assignToType9Pic3=0;
$(document).on('click', '#assignToType9Pic3', (function() {
                $('#picturesKalaContainer4Pic3').fadeIn();
                $('#picturesKalaContainer4Pic1').fadeOut();
                $('#picturesKalaContainer4Pic2').fadeOut();
                $('#picturesKalaContainer4Pic4').fadeOut();
                assignToType9Pic3++;
                if(assignToType9Pic3==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic3').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fourPicAllKala3').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fourPicAddedKalaListIds3[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fourPicAddedKala3').append(`
                            <tr class="addedTr3" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fourPicAddedKalaListIds3[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit4Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(4 pic 3)
        $(document).on('click', '#remove4PicKalaList3', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic3').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fourPicAddedKala3').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        
                        $('#fourPicAddedKala3').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(4 pic 3)
        $(document).on('click', '#add4PicKalaList3', (function() {
            var kalaListID = [];
            $('input[name="fourPicAddedKalaListIds3[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fourPicAddedKalaListIds3[]"]:checked').parents('tr').css('color','red');
            $('input[name="fourPicAddedKalaListIds3[]"]:checked').prop("disabled", true);
            $('input[name="fourPicAddedKalaListIds3[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic3').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fourPicAddedKala3').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fourPicAddedKala3').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));
            //used for dispalying kala TO pic 4(4pic edit)
            let assignToType9Pic4=0;
$(document).on('click', '#assignToType9Pic4', (function() {
                $('#picturesKalaContainer4Pic4').fadeIn();
                $('#picturesKalaContainer4Pic1').fadeOut();
                $('#picturesKalaContainer4Pic2').fadeOut();
                $('#picturesKalaContainer4Pic3').fadeOut();
                assignToType9Pic4++;
                if(assignToType9Pic4==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic4').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fourPicAllKala4').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fourPicAddedKalaListIds4[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fourPicAddedKala4').append(`
                            <tr class="addedTr4" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fourPicAddedKalaListIds4[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit4Pic4').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
            }));
//used for removing data from left side(4 pic 4)
        $(document).on('click', '#remove4PicKalaList4', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic4').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fourPicAddedKala4').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fourPicAddedKala4').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(4 pic 4)
        $(document).on('click', '#add4PicKalaList4', (function() {
            var kalaListID = [];
            $('input[name="fourPicAddedKalaListIds4[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fourPicAddedKalaListIds4[]"]:checked').parents('tr').css('color','red');
            $('input[name="fourPicAddedKalaListIds4[]"]:checked').prop("disabled", true);
            $('input[name="fourPicAddedKalaListIds4[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic4').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fourPicAddedKala4').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fourPicAddedKala4').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });     
            }));



                       //برا 5 تصویره

            //used for dispalying kala TO pic 1(5pic edit)
            let assignToType10Pic1=0;
            $(document).on('click', '#assignToType10Pic1', (function() {
                $('#picturesKalaContainer5Pic1').fadeIn();
                $('#picturesKalaContainer5Pic2').fadeOut();
                $('#picturesKalaContainer5Pic3').fadeOut();
                $('#picturesKalaContainer5Pic4').fadeOut();
                $('#picturesKalaContainer5Pic4').fadeOut();
                assignToType10Pic1++;
                if(assignToType10Pic1==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic1').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fivePicAllKala1').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAddedKalaListIds1[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
                        //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fivePicAddedKala1').append(`
                            <tr class="addedTr1" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fivePicAddedKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit5Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(5 pic 1)
        $(document).on('click', '#remove5PicKalaList1', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic1').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fivePicAddedKala1').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fivePicAddedKala1').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(5 pic 1)
        $(document).on('click', '#add5PicKalaList1', (function() {
            var kalaListID = [];
            $('input[name="fivePicAddedKalaListIds1[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fivePicAddedKalaListIds1[]"]:checked').parents('tr').css('color','red');
            $('input[name="fivePicAddedKalaListIds1[]"]:checked').prop("disabled", true);
            $('input[name="fivePicAddedKalaListIds1[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic1').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fivePicAddedKala1').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fivePicAddedKala1').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));

//used for dispalying kala TO pic 2(5pic edit)
let assignToType10Pic2=0;
           $(document).on('click', '#assignToType10Pic2', (function() {
                $('#picturesKalaContainer5Pic2').fadeIn();
                $('#picturesKalaContainer5Pic1').fadeOut();
                $('#picturesKalaContainer5Pic3').fadeOut();
                $('#picturesKalaContainer5Pic4').fadeOut();
                $('#picturesKalaContainer5Pic5').fadeOut();
                assignToType10Pic2++;
                if(assignToType10Pic2==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic2').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fivePicAllKala2').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAddedKalaListIds2[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 5 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fivePicAddedKala2').append(`
                            <tr class="addedTr2" onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fivePicAddedKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit5Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(5 pic 2)
        $(document).on('click', '#remove5PicKalaList2', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic2').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fivePicAddedKala2').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fivePicAddedKala2').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(5 pic 2)
        $(document).on('click', '#add5PicKalaList2', (function() {
            var kalaListID = [];
            $('input[name="fivePicAddedKalaListIds2[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fivePicAddedKalaListIds2[]"]:checked').parents('tr').css('color','red');
            $('input[name="fivePicAddedKalaListIds2[]"]:checked').prop("disabled", true);
            $('input[name="fivePicAddedKalaListIds2[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic2').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fivePicAddedKala2').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fivePicAddedKala2').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });   
            }));
//used for dispalying kala TO pic 3(5pic edit)
let assignToType10Pic3=0;
$(document).on('click', '#assignToType10Pic3', (function() {
                $('#picturesKalaContainer5Pic3').fadeIn();
                $('#picturesKalaContainer5Pic1').fadeOut();
                $('#picturesKalaContainer5Pic2').fadeOut();
                $('#picturesKalaContainer5Pic4').fadeOut();
                $('#picturesKalaContainer5Pic5').fadeOut();
                assignToType10Pic3++;
                if(assignToType10Pic3==1){
                $.ajax({ 
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic3').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fivePicAllKala3').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAddedKalaListIds3[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 5 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fivePicAddedKala3').append(`
                            <tr class="addedTr3"  onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fivePicAddedKalaListIds3[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit5Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(5 pic 3)
        $(document).on('click', '#remove5PicKalaList3', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic3').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fivePicAddedKala3').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fivePicAddedKala3').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(5 pic 3)
        $(document).on('click', '#add5PicKalaList3', (function() {
            var kalaListID = [];
            $('input[name="fivePicAddedKalaListIds3[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fivePicAddedKalaListIds3[]"]:checked').parents('tr').css('color','red');
            $('input[name="fivePicAddedKalaListIds3[]"]:checked').prop("disabled", true);
            $('input[name="fivePicAddedKalaListIds3[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic3').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fivePicAddedKala3').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fivePicAddedKala3').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));
            //used for dispalying kala TO pic 4(5pic edit)
            let assignToType10Pic4=0;
$(document).on('click', '#assignToType10Pic4', (function() {
                $('#picturesKalaContainer5Pic4').fadeIn();
                $('#picturesKalaContainer5Pic1').fadeOut();
                $('#picturesKalaContainer5Pic2').fadeOut();
                $('#picturesKalaContainer5Pic3').fadeOut();
                $('#picturesKalaContainer5Pic5').fadeOut();
                assignToType10Pic4++;
                if(assignToType10Pic4==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic4').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {

                $('#fivePicAllKala4').append(`
                <tr  onclick="checkCheckBox(this,event)">
                    <td>` + (i+1) + `</td>
                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAddedKalaListIds4[]" type="checkbox" value="` +
                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                        }
 //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fivePicAddedKala4').append(`
                            <tr class="addedTr4"  onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fivePicAddedKalaListIds4[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroupEdit5Pic4').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
//used for removing data from left side(4 pic 4)
        $(document).on('click', '#remove5PicKalaList4', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic4').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fivePicAddedKala4').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fivePicAddedKala4').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(5 pic 4)
        $(document).on('click', '#add5PicKalaList4', (function() {
            var kalaListID = [];
            $('input[name="fivePicAddedKalaListIds4[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fivePicAddedKalaListIds4[]"]:checked').parents('tr').css('color','red');
            $('input[name="fivePicAddedKalaListIds4[]"]:checked').prop("disabled", true);
            $('input[name="fivePicAddedKalaListIds4[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic4').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fivePicAddedKala4').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fivePicAddedKala4').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));
//used for dispalying kala TO pic 5(5pic edit)
let assignToType10Pic5=0;
           $(document).on('click', '#assignToType10Pic5', (function() {
                $('#picturesKalaContainer5Pic5').fadeIn();
                $('#picturesKalaContainer5Pic1').fadeOut();
                $('#picturesKalaContainer5Pic2').fadeOut();
                $('#picturesKalaContainer5Pic3').fadeOut();
                $('#picturesKalaContainer5Pic4').fadeOut();
                assignToType10Pic5++;
                if(assignToType10Pic5==1){
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKalaOnePic') }}',
                    async: true,
                    data:{_token: "{{ csrf_token() }}",partPic:$('#pic5').val()},
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.allKala.length - 1; i++) {
                                $('#fivePicAllKala5').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.allKala[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds5[]" type="checkbox" value="` +
                                    arrayed_result.allKala[i].GoodSn + `_` + arrayed_result.allKala[i]
                                                .GoodName + `" id="kalaId">
                                    </td>
                                </tr>
                                `);
                        }
 //used for displaying kala to the left side of 4 pic
                        for (var i = 0; i <= arrayed_result.addedKala.length - 1; i++) {
                            $('#fivePicAddedKala5').append(`
                            <tr class="addedTr5"  onclick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result.addedKala[i].GoodName + `</td>
                                <td>
                                <input class="form-check-input" name="fivePicAddedKalaListIds5[]" type="checkbox" value="` +
                                arrayed_result.addedKala[i].GoodSn + `_` + arrayed_result.addedKala[i]
                                            .GoodName + `" id="kalaId">
                                </td>
                            </tr>
                            `);
                                    }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            $('#searchMainGroupEdit5Pic5').append(`<option value="` + arrayed_result[i].id + `">` + arrayed_result[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
                
            }));
            
//used for removing data from left side(5 pic 5)
        $(document).on('click', '#remove5PicKalaList5', (function() {
            let inp=$('tr').find('input:checkbox:checked');
            $('tr').has('input:checkbox:checked').hide();
            var kalaListID = [];
            $(inp).map(function() {
                kalaListID.push($(this).val().split('_')[0]);
            });
            $.ajax({
                method: 'get',
                url: "{{ url('/deleteKalaFromPart') }}",
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    kalaList:kalaListID ,
                    partId:$('#pic5').val(),
                    partType:'pictures',
                },
                success: function(arrayed_result) {
                    $('#fivePicAddedKala5').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#fivePicAddedKala5').append(
                            `<tr  onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].GoodName+`</td>
                                <td>
                                    <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(data) {
                    alert("not good");
                }

            });
            }));

//used for adding kala to the left side(5 pic 5)
        $(document).on('click', '#add5PicKalaList5', (function() {
            var kalaListID = [];
            $('input[name="fivePicAddedKalaListIds5[]"]:checked').map(function() {
                kalaListID.push($(this).val());
            });
            $('input[name="fivePicAddedKalaListIds5[]"]:checked').parents('tr').css('color','red');
            $('input[name="fivePicAddedKalaListIds5[]"]:checked').prop("disabled", true);
            $('input[name="fivePicAddedKalaListIds5[]"]:checked').prop("checked", false);
            $.ajax({
                    method: 'get',
                    url: "{{ url('/addKalatoPart') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kalaList:kalaListID,
                        partId:$('#pic5').val(),
                        partType:'picture',
                    },
                    success: function(arrayed_result) {
                        $('#fivePicAddedKala5').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            
                            $('#fivePicAddedKala5').append(
                                `<tr  onClick="checkCheckBox(this,event)">
                                    <td>`+(i+1)+`</td>
                                    <td>`+arrayed_result[i].GoodName+`</td>
                                    <td>
                                        <input class="form-check-input" name="" type="checkBox"  value="`+arrayed_result[i].GoodSn+`" id="flexCheckChecked">
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });    
            }));

           //برای تعیین اولویت برای کالاهای تصویر تک تصویره
           $(document).on('click', '.1Pic1', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="onePicAddedKalaListIds1[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

           //برای تعیین اولویت برای کالاهای تصویر اول دو تصویره
           $(document).on('click', '.2Pic1', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="twoPicAddedKalaListIds1[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

        //برای تعیین اولویت برای کالاهای تصویر دوم دو تصویره
           $(document).on('click', '.2Pic2', (function() {
               var picId=$('#pic2').val();
               var kalaId=$('input[name="twoPicAddedKalaListIds2[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

         //برای تعیین اولویت برای کالاهای تصویر اول سه تصویره
           $(document).on('click', '.3Pic1', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="threePicAddedKalaListIds1[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

 //برای تعیین اولویت برای کالاهای تصویر دوم سه تصویره
           $(document).on('click', '.3Pic2', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="threePicAddedKalaListIds2[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
 //برای تعیین اولویت برای کالاهای تصویر سوم سه تصویره
 $(document).on('click', '.3Pic3', (function() {
               var picId=$('#pic3').val();
               var kalaId=$('input[name="threePicAddedKalaListIds3[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

//برای تعیین اولویت برای کالاهای تصویر اول چهار تصویره
 $(document).on('click', '.4Pic1', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="fourPicAddedKalaListIds1[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

//برای تعیین اولویت برای کالاهای تصویر دوم چهار تصویره
$(document).on('click', '.4Pic2', (function() {
               var picId=$('#pic2').val();
               var kalaId=$('input[name="fourPicAddedKalaListIds2[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

//برای تعیین اولویت برای کالاهای تصویر  سوم چهار تصویره
$(document).on('click', '.4Pic3', (function() {
               var picId=$('#pic3').val();
               var kalaId=$('input[name="fourPicAddedKalaListIds3[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

//برای تعیین اولویت برای کالاهای تصویر  چهارم چهار تصویره
$(document).on('click', '.4Pic4', (function() {
               var picId=$('#pic4').val();
               var kalaId=$('input[name="fourPicAddedKalaListIds4[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

//برای تعیین اولویت برای کالاهای تصویر  اول پنج تصویره
$(document).on('click', '.5Pic1', (function() {
               var picId=$('#pic1').val();
               var kalaId=$('input[name="fivePicAddedKalaListIds1[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

 //برای تعیین اولویت برای کالاهای تصویر  دوم پنج تصویره
$(document).on('click', '.5Pic2', (function() {
               var picId=$('#pic2').val();
               var kalaId=$('input[name="fivePicAddedKalaListIds2[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

 //برای تعیین اولویت برای کالاهای تصویر  سوم پنج تصویره
 $(document).on('click', '.5Pic3', (function() {
               var picId=$('#pic3').val();
               var kalaId=$('input[name="fivePicAddedKalaListIds3[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));

 //برای تعیین اولویت برای کالاهای تصویر  چهارم پنج تصویره
 $(document).on('click', '.5Pic4', (function() {
               var picId=$('#pic4').val();
               var kalaId=$('input[name="fivePicAddedKalaListIds4[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }

                });
            }));
 //برای تعیین اولویت برای کالاهای تصویر  پنجم پنج تصویره
 $(document).on('click', '.5Pic5', (function() {
               var picId=$('#pic5').val();
               var kalaId=$('input[name="fivePicAddedKalaListIds5[]"]:checked').val().split('_')[0];
               var priorityState=$(this).val();
            //    alert(picId+`  `+kalaId+` `+priorityState);
                $.ajax({
                    method: 'get',
                    url: "{{ url('/changePicturesKalaPriority') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        picId:picId,
                        kalaId:kalaId,
                        priorityState:priorityState
                    },
                    success: function(arrayed_result) {
                        window.location.reload();
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
            }));


// برای جستجوی کالاهای بخش ها


//جستجوی کالا برای تصویر 1 تک تصویره
$(document).on('change', '#searchMainGroupEdit1Pic1', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#onePic1AllKala').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#onePic1AllKala').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit1Pic1').empty();
                        $('#searchSubGroupEdit1Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit1Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit1Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 1 تک تصویره
        $(document).on('change', '#searchSubGroupEdit1Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#onePic1AllKala').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#onePic1AllKala').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        $(document).on('keyup', '#searchKalaEdit1Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit1Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#onePic1AllKala').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#onePic1AllKala').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

//2 PICS SEARCH


//جستجوی کالا برای تصویر 2 2 تصویره
$(document).on('change', '#searchMainGroupEdit2Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicAllKala1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#twoPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit2Pic1').empty();
                        $('#searchSubGroupEdit2Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit1Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit2Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 2 1 تصویره
        $(document).on('change', '#searchSubGroupEdit2Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 2 1 تصویره
        $(document).on('keyup', '#searchKalaEdit2Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit2Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#twoPicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                    }

                });
            }));

            //جستجوی کالا برای تصویر 2 2 تصویره
$(document).on('change', '#searchMainGroupEdit2Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicAllKala2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#twoPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit2Pic2').empty();
                        $('#searchSubGroupEdit2Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit2Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit2Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 2 2 تصویره
        $(document).on('change', '#searchSubGroupEdit2Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 2 2 تصویره
        $(document).on('keyup', '#searchKalaEdit2Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit2Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#twoPicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));


// FOUR PICS SEARCHING FOR

            //جستجوی کالا برای تصویر 4 1 تصویره
            $(document).on('change', '#searchMainGroupEdit4Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit4Pic1').empty();
                        $('#searchSubGroupEdit4Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit4Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit4Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 1 تصویره
        $(document).on('change', '#searchSubGroupEdit4Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 1 تصویره
        $(document).on('keyup', '#searchKalaEdit4Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit4Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                    }

                });
            }));

            //جستجوی کالا برای تصویر 4 2 تصویره
            $(document).on('change', '#searchMainGroup4Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit4Pic2').empty();
                        $('#searchSubGroupEdit4Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit4Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit4Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 2 تصویره
        $(document).on('change', '#searchSubGroupEdit4Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 2 تصویره
        $(document).on('keyup', '#searchKalaEdit4Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit4Pic2').val()
                    },
                    success: function(arrayed_result) {
                        $('#fourPicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));
            //جستجوی کالا برای تصویر 4 3 تصویره
            $(document).on('change', '#searchMainGroup4Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit4Pic3').empty();
                        $('#searchSubGroupEdit4Pic3').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit4Pic3').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit4Pic3').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 3 تصویره
        $(document).on('change', '#searchSubGroupEdit4Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 3 تصویره
        $(document).on('keyup', '#searchKalaEdit4Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit4Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

                        //جستجوی کالا برای تصویر 4 4 تصویره
                        $(document).on('change', '#searchMainGroup4Pic4', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala4').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicAllKala4').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit4Pic4').empty();
                        $('#searchSubGroupEdit4Pic4').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit4Pic4').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit4Pic4').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 4 تصویره
        $(document).on('change', '#searchSubGroupEdit4Pic4', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicAllKala4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala4').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 4 تصویره
        $(document).on('keyup', '#searchKala4Pic4', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala4Pic4').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicAllKala4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicAllKala4').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

            // THREE PICS SEARCHING FOR

            //جستجوی کالا برای تصویر 3 1 تصویره
            $(document).on('change', '#searchMainGroup3Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit3Pic1').empty();
                        $('#searchSubGroupEdit3Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit3Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit3Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 1 تصویره
        $(document).on('change', '#searchSubGroupEdit3Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 3 1 تصویره
        $(document).on('keyup', '#searchKalaEdit3Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit3Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

            //جستجوی کالا برای تصویر 3 2 تصویره
            $(document).on('change', '#searchMainGroupEdit3Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit3Pic2').empty();
                        $('#searchSubGroupEdit3Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit3Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit3Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 2 تصویره
        $(document).on('change', '#searchSubGroupEdit3Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 3 2 تصویره
        $(document).on('keyup', '#searchKalaEdit3Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit3Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));
            //جستجوی کالا برای تصویر 3 3 تصویره
            $(document).on('change', '#searchMainGroupEdit3Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup3Pic3').empty();
                        $('#searchSubGroup3Pic3').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup3Pic3').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup3Pic3').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 3 تصویره
        $(document).on('change', '#searchSubGroup3Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 3 3 تصویره
        $(document).on('keyup', '#searchKalaEdit3Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit3Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));


//////////////////////////////////////////
// FIVE PICS SEARCHING FOR

            //جستجوی کالا برای تصویر 5 1 تصویره
            $(document).on('change', '#searchMainGroupEdit5Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit5Pic1').empty();
                        $('#searchSubGroupEdit5Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit5Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit5Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 1 تصویره
        $(document).on('change', '#searchSubGroupEdit5Pic1', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 1 تصویره
        $(document).on('keyup', '#searchKalaEdit5Pic1', (function() {
            alert($('#searchKalaEdit5Pic1').val());
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit5Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicAllKala1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala1').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                    }

                });
            }));

            //جستجوی کالا برای تصویر 5 2 تصویره
            $(document).on('change', '#searchMainGroupEdit5Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit5Pic2').empty();
                        $('#searchSubGroupEdit5Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit5Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit5Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 2 تصویره
        $(document).on('change', '#searchSubGroupEdit5Pic2', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 2 تصویره
        $(document).on('keyup', '#searchKalaEdit5Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit5Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicAllKala2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala2').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));
            //جستجوی کالا برای تصویر 5 3 تصویره
            $(document).on('change', '#searchMainGroupEdit5Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit5Pic3').empty();
                        $('#searchSubGroupEdit5Pic3').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit5Pic3').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit5Pic3').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 3 تصویره
        $(document).on('change', '#searchSubGroupEdit5Pic3', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 3 تصویره
        $(document).on('keyup', '#searchKalaEdit5Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit5Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicAllKala3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala3').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

            //جستجوی کالا برای تصویر 5 4 تصویره
             $(document).on('change', '#searchMainGroupEdit5Pic4', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala4').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicAllKala4').append(`
                                <tr>
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit5Pic4').empty();
                        $('#searchSubGroupEdit5Pic4').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit5Pic4').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit5Pic4').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 4 تصویره
        $(document).on('change', '#searchSubGroupEdit5Pic4', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala4').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 4 تصویره
        $(document).on('keyup', '#searchKalaEdit5Pic4', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit5Pic4').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicAllKala4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala4').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));

            
            //جستجوی کالا برای تصویر 5 5 تصویره
            $(document).on('change', '#searchMainGroupEdit5Pic5', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala5').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicAllKala5').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds5[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroupEdit5Pic5').empty();
                        $('#searchSubGroupEdit5Pic5').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroupEdit5Pic5').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroupEdit5Pic5').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 5 تصویره
        $(document).on('change', '#searchSubGroupEdit5Pic5', (function() {
            // alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicAllKala5').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala5').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds5[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 5 تصویره
        $(document).on('keyup', '#searchKalaEdit5Pic5', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKalaEdit5Pic5').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicAllKala5').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicAllKala5').append(`
                                <tr  onclick="checkCheckBox(this,event)">
                                    <td>` + (i+1) + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAddedKalaListIds5[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            }));
        }
    </script>
@endsection