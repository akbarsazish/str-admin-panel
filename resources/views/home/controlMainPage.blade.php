@extends('admin.layout')
@section('content')

<style>
.targetCheck{
    width:22px;
  height:22px;
  border-radius:50%;
}
.targetLabel {
   margin-top:5px;
}
.selectBg {
	background-color:red;
}

#takhfifCodeStuff, #askIdea, #nazarSanjiSettingBtn {
  display:none;
}

</style>

<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="mainPageSettings" checked>
                        <label class="form-check-label me-4" for="assesPast"> تنظیمات صفحه اصلی  </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="specialSettings">
                        <label class="form-check-label me-4" for="assesPast"> تنظیمات اختصاصی </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="emteyazSettings">
                        <label class="form-check-label me-4" for="assesPast"> جوایز و امتیازات </label>
                    </div>
					<div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="takhfifCodeSettings">
                        <label class="form-check-label me-4" for="takhfifCodeSettings"> کد تخفیف </label>
                    </div>
					<div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="nazarSanjiSettings">
                        <label class="form-check-label me-4" for="takhfifCodeSettings"> نظرسنجی </label>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader"> 
                    <div class='col-lg-12 text-end mt-1'>
                        <button class="btn btn-sm btn-success specialSettingsBtn float-end"  id="webSpecialSettingBtn" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  > ذخیره <i class="fa fa-save"> </i> </button>
                         <form action="{{ url('/editParts') }}" style="display: inline;" method="POST" class="mainPageStuff">
                            @if(hasPermission(Session::get("adminId"),"mainPageSetting") >1)
                                <a href="{{ url('/addNewGroup') }}" class='btn btn-sm btn-success'> بخش جدید <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif
                                @csrf
                                <input type="text" id="partType" style="display: none" name="partType" value="" />
                                <input type="text" id="partId" style="display: none" name="partId" value="" />
                                <input type="text" id="partTitle" style="display: none" name="title" value="" />
                            @if(hasPermission(Session::get("adminId"),"mainPageSetting") > -0)
                                <button class='btn btn-success btn-sm text-white' disabled  type="submit" id='editPart'> ویرایش  <i class="fa fa-edit" aria-hidden="true"></i></button>
                            @endif
                        </form>
                        @if(hasPermission(Session::get("adminId"),"mainPageSetting") > 1)
                              <button class='btn btn-danger btn-sm disabled mainPageStuff' id='deletePart'>  حذف  <i class="fa fa-trash" aria-hidden="true"></i></button>
                        @endif
                        @if(hasPermission(Session::get("adminId"),"mainPageSetting") > 0)
                        <form action="{{url('/changePriority')}}" style="display:inline;" method="GET" id="changeMainPriorityFormDown">
                          <input type="hidden" name="changePriority" value="down">
                          <button class="mainPageStuff" id="downArrow" disabled type="submit"style="background-color:#43bfa3; padding:0;">
                            <i class="fa-solid fa-circle-chevron-down fa-2x chevronHover"></i>
                          </button>
                          <input type="hidden" id="partIdForPriorityDown" name="partId">
                        </form>
                        <form action="{{url('/changePriority')}}" style="display:inline;" method="GET" id="changeMainPriorityFormUp">
                          <input type="hidden" name="changePriority" value="up">
                          <button class="mainPageStuff" id="upArrow" disabled type="submit" style="background-color:#43bfa3; padding:0;">
                            <i class="fa-solid fa-circle-chevron-up fa-2x chevronHover"></i>
                          </button>
                          <input type="hidden" id="partIdForPriorityUp" name="partId">
                        </form>
                        @endif
                        <span id="nazarSanjiSettingBtn">
                          @if(hasPermission(Session::get("adminId"),"emptyazSettingN") > 1)
                            <button type="button" class="btn btn-sm btn-success" id="insetQuestionBtn"> افزودن  <i class="fa fa-plus"></i> </button>
                            <button type="button" class="btn btn-sm btn-success" id="editQuestionBtn" disabled> ویرایش  <i class="fa fa-edit" style="color:yellow"></i> </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="startAgainNazar()" id="startAgainNazarBtn" disabled> از سرگیری نظر خواهی <i class="fa fa-history" style="color:white"></i> </button>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="row mainContent">
                  <table class='table table-hover table-bordered table-sm table-light' id='myTable'>
                    <thead class="table bg-success text-white tableHeader">
                      <tr>
                        <th>ردیف</th>
                        <th>سطر</th>
                        <th>اولویت</th>
                        <th>فعال</th>
                        <th>انتخاب</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody" id="ctlMainPBody" style="height: calc(100vh - 200px);">
                      @foreach ($parts as $part)
                        <tr onclick="setMainPartStuff(this,{{$part->id}})" class="selected">
                          <td  style="">{{ $loop->index+1 }}</td>
                          <td >{{ $part->title }}</td>
                          <td>@if($part->partType==3 or $part->partType==4)@else {{ $part->priority-2 }} @endif</td>
                          <td>@if($part->partType==3)@else <input class='form-check-input' type='checkbox' disabled value='' id='flexCheck' @if($part->activeOrNot == 1 ) checked @endif /> @endif</td>
                          <td><input type="radio" value="{{ $part->id . '_' . $part->priority . '_' . $part->partType. '_' . $part->title }}" class="mainGroups form-check-input" name="partId"></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                <!-- تنظیمات اختصاصی  -->
            <div class='mb-2 specialSettings tab-design'>
               <div class="container-fluid px-1">
                    <ul class="header-list nav nav-tabs" data-tabs="tabs">
                        <li><a class="active" data-toggle="tab" style="color:black;" href="#webSettings"> تنظیمات عمومی</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#cost">تنظیمات ارسال</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#kala">تنظیمات کالا</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#introduction">تنظیمات معرف</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#game">تنظیمات بازی</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#social"> شبکه های اجتماعی</a></li>
                        <li><a data-toggle="tab" style="color:black;"  href="#customerAddress"> مسیر دهی مشتری</a></li>
                    </ul>
                   <form action="{{url('/doUpdatewebSpecialSettings')}}" method="post" enctype="multipart/form-data" id="webSpecialSettingForm">
                     @csrf
                  <div class="c-checkout tab-content p-1" style="overflow-x:hidden; height: calc(100vh - 211px);">
                     <div class="tab-pane active" id="webSettings">
                        <fieldset class="border rounded">
                            <legend  class="float-none w-auto legendLabel m-0">  تنظیمات نمایش   </legend>
                         <div class="row bg-white m-1">
                            <div class="col-sm-4">
                               <input type="checkbox" @if($settings->buyFromHome==1) checked @endif value="" name="buyFromHome[]" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start"/>
                                <label class="tanzimat-label ms-2" for="flexCheckDefault">
                                    امکان خرید از صفحه اصلی 
                                </label> <br>
                                <input type="checkbox" @if($settings->enamad==1) checked @endif value="" name="enamad[]" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start"> 
                                  <label class="tanzimat-label ms-2" for="flexCheckDefault">
                                    نمایش E-Namad در Home
                                </label> <br/>
								               <input type="checkbox" @if($settings->enamadOther==1) checked @endif value="" name="enamadOther[]" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start"> 
                                <label class="tanzimat-label ms-2" for="flexCheckDefault">
                                   نمایش E-Namad در بقیه صفحات
                                </label> <br>
                                <input type="checkbox" name="useTakhfifCodeOnline[]" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start"/>
                                <label class="tanzimat-label ms-2" for="flexCheckDefault">
                                    امکان استفاده از کد تخفیف در پرداخت آنلاین 
                                </label> <br>
                                <input type="checkbox" @if($settings->showDeleteNotification==1) checked @endif name="showNotificationMSG[]" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start"/>
                                <label class="tanzimat-label ms-2" for="flexCheckDefault">
                                    امکان حذف تاریخچه نوتیفیکیشن 
                                </label > <br>
                                 <label class="tanzimat-label ms-2" for="flexCheckDefault"> نمایش لوگو  </label > 
                                  <div class="form-check">
                                    <input type="radio" @if($settings->logoPosition==0)  checked @endif value="0" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start" name="logoPosition">
                                    <label class="tanzimat-label ms-4" for="flexRadioDefault1"> چب </label> <br>

                                    <input type="radio" @if($settings->logoPosition==1) checked @endif value="1"  @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-check-input float-start" name="logoPosition">
                                    <label class="tanzimat-label ms-4" for="flexRadioDefault1"> راست </label>
                                  </div>
                            </div>
                           
                            <div class="col-sm-3">
                                <label class="tanzimat-label ms-2" for="flexCheckDefault"> نمایش صفحه اصلی  </label>
                                <select name="selectHome" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  type="text" class="form-select form-select-sm">
                                    <option @if($settings->homePage==1) selected @endif value="1">با جزئیات</option>
                                    <option @if($settings->homePage==2) selected @endif value="2">دسته بندی</option>
                                </select>
                           
                                <label class="tanzimat-label ms-2" for="flexCheckDefault">تعیین سال مالی</label>
                                <select name="fiscallYear" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif   type="text" class="form-select form-select-sm">
                                    @for ($i=1398; $i<=1440;$i++)
                                      <option @if( $settings -> FiscallYear==$i ) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                          </div>
                          </fieldset>
                        </div>
                    <div class="tab-pane" id="kala">
                     <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                        <div class="row"> <br>
                        <div class="col-sm-3">
                          <div class="input-group input-group-sm mb-3">
                              <span class="input-group-text" id="inputGroup-sizing-sm"> تعداد انتخاب کالاها </span>
                              <input type="text" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-control form-control-sm" name="maxSale" @if ($settings) value="{{$settings->maxSale}}" @endif>
                          </div>
                        </div>
                      <div class="col-sm-3">
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm"> کف مبلغ ثبت فاکتور (تومان) </span>
                            <input type="text" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-control form-control-sm" id="minSalePriceFactor" name="minSalePriceFactor" placeholder="تومان" value="{{ number_format($settings->minSalePriceFactor) }}" size="20" id="allKalaFirst">
                        </div>
                      </div>
							
                    <div class="col-sm-3">
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">  درصد تخفیف (%) </span>
                          <input type="text" required @if($settings->percentTakhfif) value="{{rtrim((string)number_format($settings->percentTakhfif,4, '/', ''),"0")}}" @endif name="percentTakhfif" class="form-control">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <select type="text" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  class="form-select form-select-sm" id="" name="currency">
                         <option @if($settings->currency==1) selected @endif  value="1"> ریال </option>
                         <option @if($settings->currency==10) selected @endif value="10"> تومان </option>
                      </select>
                    </div>
             </div>
             <div class="grid-subgroup">
                    <div class="subgroup-item">
                        <input type="text" class="form-control form-control-sm" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif  id="serachKalaForSubGroup"  placeholder="جستجو">
                        <table class="table table-bordered table table-hover table-sm">
                            <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th>اسم </th>
                                    <th>
                                      <input type="checkbox" name="" @if(hasPermission(Session::get("adminId"),"specialSettingN") < 1) disabled @endif   class="selectAllFromTop form-check-input"  >
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" id="allstocks" style="height:calc(100vh - 355px)">
                                @foreach ($stocks as $stock)
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$stock->NameStock}} </td>
                                    <td>
                                      <input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  value="{{$stock->SnStock.'_'.$stock->NameStock}}" name="allStocks[]" class="form-check-input" >
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>

                      <div class="subgroup-item">
                          <div class='modal-body' style="position:relative; right: 15%; top: 30%;">
                              <div style="">
                                  <a id="addStockToWeb">
                                      <i class="fa-regular fa-circle-chevron-left fa-2x chevronHover"></i>
                                  </a>
                                  <br />
                                  <a id="removeStocksFromWeb">
                                      <i class="fa-regular fa-circle-chevron-right fa-2x chevronHover"></i>
                                  </a>
                              </div>
                          </div>
                      </div>

                        <div class="subgroup-item">
                            <input type="text" @if(hasPermission(Session::get( 'adminId'),'specialSettingN') < 1)disabled @endif class="form-control form-control-sm" id="serachKalaOfSubGroup"  placeholder="جستجو">
                                <table class="table table-bordered table table-hover table-sm">
                                    <thead class="tableHeader">
                                      <tr>
                                        <th>ردیف</th>
                                        <th>اسم</th>
                                        <th>
                                          <input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN') < 1) disabled @endif   name="" class="selectAllFromTop form-check-input"/>
                                      </th>
                                  </tr>
                                </thead>
                                <tbody class="tableBody" id="addedStocks" style="height:calc(100vh - 355px)">
                                    @foreach ($addedStocks as $stock)
                                    <tr onclick="checkCheckBox(this,event)">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$stock->NameStock}} </td>
                                        <td>
                                           <input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN') < 1) disabled @endif  value="{{$stock->SnStock.'_'.$stock->NameStock}}" name="allStocks[]"  class="form-check-input"  >
                                         </td>
                                    </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
              </div>
                        <div class="tab-pane" id="cost">
                           <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                              <div class="row" style="padding:1% 2% 0% 1%;">
                                <div class="col-sm-4"> 
                                  <div class="input-group input-group-sm mb-3">
                                      <span class="input-group-text" id="inputGroup-sizing-default">متن قبل از ظهر </span>
                                      <input type="text" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  class="form-control form-control-sm" @if ($settings) value="{{$settings->moorningTimeContent}}" @endif name="moorningTimeContent">
                                  </div>
                                  
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">متن بعد از ظهر </span>
                                        <input type="text" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  class="form-control form-control-sm" @if ($settings) value="{{$settings->afternoonTimeContent}}" @endif name="afternoonTimeContent">
                                    </div>
                                  
									                      <input class="form-check-input" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  type="checkbox"  name="firstDayMoorningActive" @if($settings) @if($settings->firstDayMoorningActive==1) checked @else  @endif @endif id="third-price">
                                        <label class="tanzimat-label"  for="userName">قبل از ظهر روز اول</label>  <br>
                                        <input class="form-check-input" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  type="checkbox"  name="firstDayAfternoonActive" @if($settings) @if($settings->firstDayAfternoonActive==1) checked @else  @endif @endif   id="third-price">
                                        <label class="tanzimat-label"  for="userName" >بعد از ظهر روز اول</label>  <br>
                                       
                                         <input class="form-check-input" type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  name="secondDayMoorningActive" @if($settings) @if($settings->secondDayMoorningActive==1) checked @else @endif @endif id="third-price">
                                        <label class="tanzimat-label"  for="userName">قبل از ظهر روز دوم</label> <br>
                                         <input class="form-check-input" type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  name="secondDayAfternoonActive" @if($settings) @if($settings->secondDayAfternoonActive==1) checked @else @endif @endif id="third-price">
                                        <label class="tanzimat-label"  for="userName">بعد از ظهر روز دوم</label> <br>
                                   
                                         <input class="form-check-input" type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif   name="favoriteDateMoorningActive" @if($settings) @if($settings->FavoriteDateMoorningActive==1) checked @else @endif @endif id="third-price">
                                        <label class="tanzimat-label"  for="idealBeforNoon"> قبل از ظهر روز دلخواه </label> <br>
                                         <input class="form-check-input" type="checkbox" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  name="favoriteDateAfternoonActive" @if($settings) @if($settings->FavoriteDateAfternoonActive==1) checked @else @endif @endif id="third-price">
                                        <label class="tanzimat-label"  for="idealAfterNoon"> بعد از ظهر روز دلخواه </label>
                                    </div>
                                
                                  <div class="col-sm-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> ساعت شروع نمایش سفارش فوری </span>
                                        <input type="time" class="form-control form-control-sm"
											   value="{{explode(".",$settings->startTimeImediatOrder)[0]}}" 
										name="startImediatTime">
                                    </div>
                                  
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default"> ساعت ختم نمایش فوری </span>
                                        <input type="time" class="form-control form-control-sm"
											    value="{{explode(".",$settings->endTimeImediatOrder)[0]}}" 
											   name="endImediatTime">
                                    </div>
                                  </div>
                                </div>
                            </div>
                    </div>

                    <div class="tab-pane" id="game">
                      <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                        <div class="row p-3">
                          <div class="col-sm-2">
                              <label class="tanzimat-label">جایزه مقام اول</label>
                              <input class="form-control form-control-sm mb-2" id="firstPrize" value="{{number_format($settings->firstPrize)}}" name="firstPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label">جایزه مقام دوم</label>
                              <input class="form-control form-control-sm mb-2" id="secondPrize" value="{{number_format($settings->secondPrize)}}" name="secondPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label">جایزه مقام سوم</label>
                              <input class="form-control form-control-sm mb-2" id="thirdPrize" value="{{number_format($settings->thirdPrize)}}" name="thirdPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label"> جایزه مقام چهارم </label>
                              <input class="form-control form-control-sm mb-2" id="fourthPrize" value="{{number_format($settings->fourthPrize)}}" name="fourthPrize">
                              </div>
                              <div class="col-sm-2"> 
                          
                              <label class="tanzimat-label"> جایزه مقام پنجم </label>
                              <input class="form-control form-control-sm mb-2" id="fifthPrize" value="{{number_format($settings->fifthPrize)}}" name="fifthPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label"> جایزه مقام ششم </label>
                              <input class="form-control form-control-sm mb-2" id="sixthPrize" value="{{number_format($settings->sixthPrize)}}" name="sixthPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label"> جایزه مقام هفتم </label>
                              <input class="form-control form-control-sm mb-2" id="seventhPrize" value="{{number_format($settings->seventhPrize)}}" name="seventhPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label"> جایزه مقام هشتم </label>
                              <input class="form-control form-control-sm mb-2" id="eightthPrize" value="{{number_format($settings->eightPrize)}}" name="eightthPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label">جایزه مقام نهم</label>
                              <input class="form-control form-control-sm mb-2" id="ninthPrize" value="{{number_format($settings->ninthPrize)}}" name="ninthPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label">جایزه مقام دهم</label>
                              <input class="form-control form-control-sm mb-2" id="teenthPrize" value="{{number_format($settings->teenthPrize)}}" name="teenthPrize">
                              </div>
                              <div class="col-sm-2"> 
                              <label class="tanzimat-label">جایزه مقام دهم</label>
                              <input class="form-control form-control-sm mb-2" id="teenthPrize" value="{{number_format($settings->teenthPrize)}}" name="teenthPrize">
                          </div>
                          <div class="col-sm-2 mt-4 text-end">
                              <a href="{{url('/emptyGame')}}" onclick="if (confirm('می خواهید نتایج بازی را تخلیه کنید؟?')){return true;}else{event.stopPropagation(); event.preventDefault();};">
                              <button type="button" class="btn btn-success btn-sm btn-md btn-lg">تخلیه بازی  <i class="fa fa-icon-remove"></i> </button></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="introduction">
                      <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                        <div class="row p-3">
                          <div class="col-sm-4">
                            <label class="tanzimat-label">مبلغ معرفی هر مشتری (تومان)</label><br/>
                            <input type="text" value="{{number_format($settings->useIntroMoney)}}" name="useIntroMoney" class="form-control form-control-sm d-inline mb-2"> 
                            <br/>
                            <label class="tanzimat-label">درصدی معرف از خرید مشتری جدید (%)</label>
                            <br/>
                            <input type="text" value="{{rtrim((string)number_format($settings->useIntroPercent,4, '/', ''),'0')}}" name="useIntroPercent" class="form-control form-control-sm d-inline mb-2">
                            <br/>
                            <label class="tanzimat-label">مدت زمان استفاده از امتیازات معرفی  (به اساس ماه) </label><br/>
                            <input type="text" value="{{number_format($settings->useIntroMonth)}}" name="useIntroMonth" class="form-control form-control-sm d-inline mb-2">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane" id="social">
                        <div class="row ps-3">
                          <div class="col-sm-3">
                              <i class="fab fa-instagram" style="color:#e94a66; font-size:20px;"></i>
                              <label class="tanzimat-label" for="userName"> انستاگرام</label>
                              <input type="text" class="form-control form-control-sm mb-2" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  @if ($settings) value="{{$settings->telegramId}}" @endif name="telegramId">
                          
                              <i class="fab fa-telegram" style="color:#269cd9; font-size:20px;"></i>
                              <label class="tanzimat-label" for="userName">  تلگرام</label>
                              <input type="text" class="form-control form-control-sm mb-2" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  @if ($settings) value="{{$settings->instagramId}}" @endif name="instagramId">
                      
                              <i class="fab fa-whatsapp-square" style="color:#57ed68; font-size:20px;"></i>
                              <label class="tanzimat-label" for="userName">  واتساپ </label>
                              <input type="text" class="form-control form-control-sm mb-2" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  @if ($settings) value="{{$settings->whatsappNumber}}" @endif  name="whatsappNumber">
                          
                              <label class="tanzimat-label" for="userName"> پوسته اندروید</label>
                              <input type="file" class="form-control form-control-sm" accept=".apk" name="uploadAPK">
                          </div>
                      </div>
                    </div>

                        <div class="tab-pane" id="customerAddress">
                          <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                                  <div class="row"> <div class="col-sm-6 mt-3">
						          	<div class="row"> 
                          <div class="col-sm-4"> 
                            <h5 style="font-style:bold; margin-right:10px;">شهر ها </h5>
                          </div>
                          <div class="col-sm-8 text-end"> 
                            @if(hasPermission(Session::get("adminId"),"specialSettingN") > 0)
                                <button type="button" style="margint:0" class="btn btn-success btn-sm" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  id="addNewCity"> جدید <i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type="button" value="Reterive data" class="btn btn-info btn-sm text-white" data-toggle="modal" id="editCityButton" disabled>ویرایش <i class="fa fa-edit" aria-hidden="true"></i></button>
                              @endif
                                @if(hasPermission(Session::get("adminId"),"specialSettingN") > 1)
                                <button type="button" disabled id="deleteCityButton" class="btn btn-danger btn-sm">حذف <i class="fa fa-trash" aria-hidden="true"></i></button>
                                @endif
                                <input type="text" style="display:none" value="" id="CityId" style=""/>
                          </div>
                        </div>
                             <div class="well" style="margin-top:2%;">
                                <table class="table table-bordered table table-hover table-sm" id="tableGroupList">
                                    <thead class="tableHeader">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>شهر</th>
                                            <th>فعال</th>
                                        </tr>
                                    </thead>
                                    <tbody class="c-checkout tableBody" id="cityList" style="height:222px !important;">
                                        @foreach ($cities as $city)
                                            <tr  @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) > 1) onclick="changeCityStuff(this)" @endif  >
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $city->NameRec }}</td>
                                                <td>
                                                    <input class="mainGroupId" @if(hasPermission(Session::get( 'adminId'),'specialSettingN' ) < 1) disabled @endif  type="radio" name="mainGroupId[]" value="{{ $city->SnMNM . '_' . $city->NameRec}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </form>
                            </div>
                        </div>
                        <div class="col-sm-6">
						          	<div class="row mt-3"> 
                          <div class="col-sm-4"> 
                             <h5 style="font-style:bold; margin-right:10px;"> منطقه ها  </h5>
                          </div>
                          <div class="col-sm-8 text-end"> 
                             @if(hasPermission(Session::get("adminId"),"specialSettingN") > 0)
                                <button class="btn btn-success btn-sm buttonHover" type="button" disabled  id="addNewMantiqah"> جدید <i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button  class="btn btn-info btn-sm text-white editButtonHover" type="button" disabled id="editMantiqah"  > ویرایش <i class="fa fa-edit" aria-hidden="true"></i></button>
                             @endif
                             @if(hasPermission(Session::get("adminId"),"specialSettingN") > 1)
                                <button id="deleteMantagheh" type="button" disabled class="btn btn-danger btn-sm buttonHoverDelete"> حذف <i class="fa fa-trash" aria-hidden="true"></i></button>
                              @endif
                            </div>
                        </div>
                            <div class="well" style="margin-top:2%;">
                              <div class=" c-checkout">
                                  <table id="subGroupTable" class="table table-bordered table table-hover table-sm" id="tableGroupList">
                                      <thead class="tableHeader">
                                        <tr>
                                           <th >ردیف </th>
                                           <th>منطقه </th>
                                           <th> فعال </th>
                                        </tr>
                                      </thead>
                                      <tbody class="tableBody" id="mantiqaBody" style="height:222px !important;"> </tbody>
                                  </table>
                               </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid-subgroup" id="customersList" style="display: none">
                          <div class="subgroup-item">
                              <input type="text" class="form-control form-control-sm" style="margin-top:10px;" id="searchNameMNM"  placeholder="نام">
                              <input type="text" class="form-control form-control-sm" style="margin-top:10px;" id="searchAddressMNM"  placeholder="آدرس">
                                  <table class="table table-bordered table-hover table-sm">
                                      <thead class="forMaser tableHeader">
                                          <tr>
                                              <th>ردی2ف</th>
                                              <th>نام</th>
                                              <th> آدرس</th>
                                              <th>
                                                  <input type="checkbox" name=""  class="selectAllFromTop form-check-input">
                                              </th>
                                          </tr>
                                      </thead>
                                        <tbody class="forMaser tableBody" id="cutomerBody">
                                      </tbody>
                                  </table>
                            </div>
                           <div class="subgroup-item">
                               <div class='modal-body' style="position:relative; right: 15%; top: 30%;">
                                  <a id="addDataToMantiqah">
                                      <i class="fa-regular fa-circle-chevron-left fa-2x chevronHover"></i>
                                  </a>
                                  <br/>
                                  <a id="removeDataFromMantiqah">
                                      <i class="fa-regular fa-circle-chevron-right fa-2x chevronHover"></i>
                                  </a>
                              </div>
                         </div>
                        <div class="subgroup-item">
                          <input type="text" class="form-control form-control-sm" style="margin-top:10px;" id="searchAddedNameMNM"  placeholder="نام">
                            <input type="text" class="form-control form-control-sm" style="margin-top:10px;" id="searchAddedAddressMNM"  placeholder="آدرس">
                              <input type="hidden" id="mantiqahIdForSearch"/>   
                                <table class="table table-bordered table-sm">
                                  <thead class="tableHeader">
                                        <tr>
                                            <th>ردیف</th>
                                            <th>نام</th>
                                            <th >آدرس</th>
                                            <th> <input type="checkbox" name="" class="selectAllFromTop form-check-input"/> </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody" id="addedCutomerBody"> </tbody>
                                </table>
                          </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
<!-- ختم تنظیمات اختصاصی  -->

      <!-- شروع تنظیمات امتیاز ها  -->
      <div class="c-checkout container-fluid emteyazSettingsPart tab-design">
                <div class="col-sm-6" style="margin: 0; padding:0;">
                  <ul class="header-list nav nav-tabs" data-tabs="tabs" style="margin: 0; padding:0;">
                      <li><a class="active"  data-toggle="tab" style="color:black;"  href="#prizeSettings">تنظیمات جوایز لاتری</a></li>
                  </ul>
                </div>
                <div class="c-checkout tab-content tableBody" style="overflow-x:hidden">
                  <!-- کالاهای لاتری -->
                  <div class="row c-checkout rounded-2 tab-pane active" id="prizeSettings" style="width:100%; margin:0 auto; padding:1% 0% 0% 0%">
                      <div class="row">
                          <div class="col-lg-12 text-end">
                              <span class="prizeName float-start"> <i class="fa fa-bullseye 4x" style="color:green; font-size:22px;"></i>  حد اقل امتیاز لاتری : {{number_format($lotteryMinBonus)}} </span> 
                         @if(hasPermission(Session::get("adminId"),"emptyazSettingN") > 1)
                              <button  data-toggle="modal" type="button"  class="btn btn-sm btn-success text-warning" id="editLotteryPrizeBtn" > ویرایش لاتاری  <i class="fa fa-edit"> </i> </button>
                          @endif
                            </div>
                      </div>
                      <div class="row p-3">
                        <div class="prizeSettingTab">
                          <div> <span class="prizeName"> جایزه اول :</span>   {{$prizes[0]->firstPrize}} </div>
                          <div> <span class="prizeName"> جایزه دوم:  </span> {{$prizes[0]->secondPrize}}</div>
                          <div> <span class="prizeName"> جایزه سوم: </span> {{$prizes[0]->thirdPrize}} </div>  
                          <div> <span class="prizeName"> جایزه چهارم : </span> {{$prizes[0]->fourthPrize}} </div>
                          <div> <span class="prizeName"> جایزه پنجم : </span> {{$prizes[0]->fifthPrize}} </div>
                          <div> <span class="prizeName"> جایزه ششم : </span> {{$prizes[0]->sixthPrize}} </div>
                          <div> <span class="prizeName"> جایزه هفتم : </span> {{$prizes[0]->seventhPrize}} </div>
                          <div> <span class="prizeName"> جایزه هشتم : </span>  {{$prizes[0]->eightthPrize}} </div>
                          <div> <span class="prizeName"> جایزه نهم :</span> {{$prizes[0]->ninethPrize}}  </div>
                          <div> <span class="prizeName"> جایزه دهم: </span>   {{$prizes[0]->teenthPrize}} </div>
                          <div> <span class="prizeName"> جایزه یازدهم :</span>  {{$prizes[0]->eleventhPrize}}  </div>
                          <div> <span class="prizeName"> جایزه دوازدهم :</span> {{$prizes[0]->twelvthPrize}}  </div>
                          <div> <span class="prizeName"> جایزه سیزدهم :</span> {{$prizes[0]->therteenthPrize}}  </div>
                          <div> <span class="prizeName"> جایزه چهاردهم: </span> {{$prizes[0]->fourteenthPrize}}  </div>
                          <div> <span class="prizeName"> جایزه پانزدهم: </span> {{$prizes[0]->fifteenthPrize}}  </div>
                          <div> <span class="prizeName"> جایزه شانزدهم: </span> {{$prizes[0]->sixteenthPrize}}  </div>
                        </div>
                      </div> <hr>
              
                  <div class="row text-center me-2">
                      <input type="hidden" name="" id="selectTargetId">
                      <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 mb-1">
                            <select class="form-select  form-select-sm" aria-label="Default select example" id="selectTarget">
                              @foreach($targets as $target)
                                <option value="{{$target->id}}">{{$target->baseName}}</option>
                              @endforeach
                            </select>
                        </div>
                          <div class="col-lg-1 col-md-1 col-sm-1 mt-3">
                            <!-- <span data-toggle="modal" data-target="#addingTargetModal"><i class="fa fa-plus-circle fa-lg" style="color:#1684db; font-size:33px"></i></span> -->
                          </div>
                          <div class="col-lg-8 col-md-8 col-sm-8 text-end">
                             @if(hasPermission(Session::get("adminId"),"emptyazSettingN") > 1)
                               <button class='btn btn-sm btn-success text-warning' id="targetEditBtn" type="button" disabled  data-toggle="modal" style="margin-top:-3px;">ویرایش تارگت<i class="fa fa-edit fa-lg"></i></button> 
                              @endif 
                            <!-- <button class='btn btn-danger text-warning' disabled style="margin-top:-3px;" id="deleteTargetBtn"> حذف <i class="fa fa-trash fa-lg"></i></button>  -->
                          </div>
                      </div>

                      <div class="row">
                        <table class="table table-bordered border-secondary table-sm">
                          <thead>
                            <tr class="targetTableTr">
                            <th> ردیف </th>
                              <th> اسم تارگت </th>
                              <th>تارگیت 1</th>
                              <th> امتیاز 1</th>
                              <th>تارگیت 2</th>
                              <th> امتیاز 2</th>
                              <th>تارگیت 3</th>
                              <th> امتیاز 3</th>
                              <th> انتخاب  </th>
                            </tr>
                          </thead>
                          <tbody id="targetList">
                            @foreach($targets as $target)
                            <tr class="targetTableTr" onclick="setTargetStuff(this)">
                            <td>{{$loop->iteration}}</td>
                                <td>{{$target->baseName}}</td>
                                <td> {{number_format($target->firstTarget)}}</td>
                                <td> {{$target->firstTargetBonus}} </td>
                                <td> {{number_format($target->secondTarget)}}</td>
                                <td> {{$target->secondTargetBonus}} </td>
                                <td> {{number_format($target->thirdTarget)}}</td>
                                <td> {{$target->thirdTargetBonus}} </td>
                                <td> <input class="form-check-input" name="targetId" type="radio" value="{{$target->id}}"></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
                   </div>
                </div>
		<!--- شروع کد تخفیف -->
                      <div class="row" id="takhfifCodeStuff">
                            <div class="col-lg-12 px-0">
                              <table class="table table-striped table-bordered table-sm">
                                  <thead class="tableHeader">
                                    <tr>
                                        <th> ردیف </th>
                                        <th> کد تخفیف </th>
                                        <th> مهلت استفاده </th>
                                        <th> مبلغ (ریال)    </th>
                                        <th> انتخاب </th>
                                    </tr>
                                  </thead>
                                  <tbody class="tableBody" id="smsModelBody" style="height:calc(100vh - 222px)">
                                     @foreach($smsModels as $model)
									  	                  <tr onclick="setModelStuff(this,{{$model->Id}})">
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{$model->ModelName}} </td>
                                            <td> {{$model->UseDays}} </td>
                                            <td> {{number_format($model->Money)}} </td>
                                            <td> <input type="radio"  name="modelSelect"> </td>
                                        </tr>
									                    @endforeach
                                  </tbody>
                                </table>
			                      </div>
			                </div>
<!--- شروع نظر سنجی -->
	                     <div class="row" id="askIdea">
                            <div class="col-lg-12" id="nazaranjicontainer">
                              @foreach($nazars as $nazar)
                                <fieldset class="fieldsetBorder rounded mb-2">
                                  <legend  class="float-none w-auto forLegend" style="font-size:14px; margin-bottom:2px;"> {{$nazar->Name}} </legend>	
                                      <div class="idea-container">
                                          <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},1)"> 1- {{trim($nazar->question1)}} </button>
                                          <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},2)"> 2- {{trim($nazar->question2)}} </button>
                                          <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},3)"> 3- {{trim($nazar->question3)}} </button>
                                          <div class="form-check mt-1">
                                             <input class="form-check-input nazarIdRadio p-2" onclick="editNazar(this)" type="radio" name="nazarNameRadio" value="{{$nazar->nazarId}}" id="">
                                          </div>
                                      </div>
                                </fieldset>
                              @endforeach
                              <hr>
                              <table class="table table-striped table-bordered table-sm">
                                <thead class="tableHeader">
                                    <tr>
                                      <th> دریف </th>
                                      <th> نام مشتری </th>
                                      <th> تاریخ </th>
                                      <th> نظر سنجی </th>
                                      <th>جوابات </th>
                                      <th> <input type="checkbox"  name="" class="selectAllFromTop form-check-input"/>  </th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody" style="height:calc(100vh - 433px) !important;">
                                    <tr>
                                      <th scope="row">1</th>
                                      <td> محمود الیاسی  </td>
                                      <td>12/12/1401 </td>
                                      <td> نظر سنجی 1401  </td>
                                      <td id="viewQuestion"><i class="fa fa-eye"></td>
                                      <td id="checkToStartAgainNazar">  <input class="form-check-input" name="" type="checkbox" value=""> </td>
                                    </tr>
                                </tbody>
                              </table>
			                      </div>
			                  </div>
		                </div>
            <!-- ختم تنظیمات امتیاز ها  -->
            <div class="row contentFooter"> </div>
         </div>
    </div>
</div>

<!-- takhfif code modal -->
          <div class="modal fade" id="addTakhfifCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl dragableModal modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h5 class="modal-title"> افزودن کد تخفیفی </h5>
                    <button type="button" class="close btn text-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255);"><i class="fa-solid fa-xmark fa-xl"></i></button>
                </div>
                  <div class="modal-body">
                    <fieldset class="border rounded">
                      <legend  class="float-none w-auto legendLabel m-0">   مدل پیامک   </legend>
                      <form action="{{url('/addSMSModel')}}" id="addSMSModelForm" method="get">
                        <div class="row">
                        <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> نام مدل  </label>
                                  <input type="text" min="0"   class="form-control form-control-sm" name="modelName">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
								<label for="exampleFormControlInput1" class="form-label-code"> کد </label>
								<input type="text" class="form-control form-control-sm" name="code" id="generatedCode">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> مبلغ (ریال) </label>
                              <input type="number" min="0" class="form-control form-control-sm" name="money" id="MoneyModel">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> مهلت استفاده (روز) </label>
                              <input type="number" min="0"  class="form-control form-control-sm" name="useDays" id="useDaysValues">
                            </div>
                          </div>
                          
                        </div>
                        </fieldset>
                        <fieldset class="border rounded">
                      <legend  class="float-none w-auto legendLabel m-0">  ساختار متن پیامک  </legend>
                        <div class="row ">
                            <div class="col-lg-3"> 
                                 <p class='mb-0'>  متن عمومی  </p>
                            </div>
                        </div>
 
                          <div class="row">
                                  <div class="col-lg-7">
                                     <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" class="form-control form-control-sm" name="firstText" id="firstContent" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="firstSelect"  type="text" class="form-select form-select-sm" id="selectOption">
                                                <option value=""></option>
                                                <option value="Name"> نام و نام خانوادگی </option>
                                                <option value="Code">  کد تخفیف   </option>
                                                <option value="Money"> مبلغ </option>
                                                <option value="UseDays"> مهلت </option>
                                                <option value="FromDate"> از تاریخ </option>
                                                <option value="ToDate"> تا تاریخ </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                            <span> <input class="form-check-input" name="firstCurrency" type="checkbox" id="reyal1"> ریال </span>
                                        </div> 
                                        <div class="col-lg-3"> <div class="mb-2">
                                            <span>
													                      <input class="form-check-input" name="firstNLine" type="checkbox"  id="firstLine">
												                      	خط بعدی 
												                    </span>
                                       </div>
                                   </div>
                                  </div>
                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="secondText" class="form-control form-control-sm" id="secondContent" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="secondSelect"  type="text" class="form-select form-select-sm" id="secondOption">
                                                <option value="">  </option>
                                                <option value="Name"> نام و نام خانوادگی </option>
                                                <option value="Code">  کد تخفیف   </option>
                                                <option value="Money"> مبلغ </option>
                                                <option value="UseDays"> مهلت </option>
                                                <option value="FromDate"> از تاریخ </option>
                                                <option value="ToDate"> تا تاریخ </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                           <span >
												<input class="form-check-input" name="secondCurrency" type="checkbox" id="reyal2"> ریال 
                                           </span>
                                       </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span >
													<input class="form-check-input" name="secondNLine" type="checkbox"  id="secondLine">  خط بعدی 
												</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="thirdText" class="form-control form-control-sm" id="thirthContent">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="thirdSelect"  type="text" class="form-select form-select-sm" id="thirthOption">
                                              <option value=""></option>
                                              <option value="Name"> نام و نام خانوادگی </option>
                                              <option value="Code">  کد تخفیف   </option>
                                              <option value="Money"> مبلغ </option>
                                              <option value="UseDays"> مهلت </option>
                                              <option value="FromDate"> از تاریخ </option>
                                              <option value="ToDate"> تا تاریخ </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                              <span >
												  <input class="form-check-input" name="Currency" type="checkbox" id="reyal3">
												  ریال 
                          </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span>
													<input class="form-check-input" name="thirdNLine" type="checkbox" id="thirthLine">
													خط بعدی 
												</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="fourthText" class="form-control form-control-sm" id="fourthContent">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="fourthSelect"  type="text" class="form-select form-select-sm" id="fourthOption">
                                              <option value=""></option>
                                              <option value="Name"> نام و نام خانوادگی </option>
                                              <option value="Code">  کد تخفیف   </option>
                                              <option value="Money"> مبلغ </option>
                                              <option value="UseDays"> مهلت </option>
                                              <option value="FromDate"> از تاریخ </option>
                                              <option value="ToDate"> تا تاریخ </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                              <span >
												  <input class="form-check-input" name="fourthCurrency" type="checkbox" id="reyal4">
												  ریال 
                          </span></div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span >
													<input class="form-check-input" type="checkbox" name="fourthNLine" id="fourthLine">
													خط بعدی 
												</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="fifthText" class="form-control form-control-sm" id="fifthContent">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="fifthSelect"  type="date" class="form-select form-select-sm" id="fifthOption">
                                              <option value=""></option>
                                              <option value="Name"> نام و نام خانوادگی </option>
                                              <option value="Code">  کد تخفیف   </option>
                                              <option value="Money"> مبلغ </option>
                                              <option value="UseDays"> مهلت </option>
                                              <option value="FromDate"> از تاریخ </option>
                                              <option value="ToDate"> تا تاریخ </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                          <span>
                                            <input class="form-check-input" name="fifthCurrency" type="checkbox" id="reyal5">
                                            ریال 
                                          </span>
                                        </div>
                                    <div class="col-lg-3"> 
                                      <div class="mb-2">
                                        <span>
                                          <input class="form-check-input" type="checkbox" name="fifthNLine" id="fifthLine"> 
                                          خط بعدی 
                                        </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4"> 
                                          <div class="mb-2">
                                                <input type="text" name="sixthText" class="form-control form-control-sm" id="sixthContent">
                                          </div>
                                      </div>
                                      <div class="col-lg-4 px-0">
                                        <select name="sixthSelect" type="date" class="form-select form-select-sm" id="sixthOption">
                                          <option value=""></option>
                                          <option value="Name"> نام و نام خانوادگی </option>
                                          <option value="Code">  کد تخفیف </option>
                                          <option value="Money"> مبلغ </option>
                                          <option value="UseDays"> مهلت </option>
                                          <option value="FromDate"> از تاریخ </option>
                                          <option value="ToDate"> تا تاریخ </option>
                                        </select> 
                                      </div>
                                      <div class="col-lg-1 px-1"> 
                                        <span>
                                          <input class="form-check-input" name="sixthCurrency" type="checkbox" id="reyal6">
                                          ریال 
                                        </span>
                                      </div>
                                      <div class="col-lg-3"> 
                                        <div class="mb-2">
                                          <span>
                                            <input class="form-check-input" type="checkbox" name="sixthNLine" id="sixthLine">
                                            خط بعدی
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  <div class="row">
                                      <div class="col-lg-4"> 
                                          <div class="mb-2">
                                            <input type="text" name="seventhText" class="form-control form-control-sm" id="seventhContent">
                                          </div>
                                      </div>
                                      <div class="col-lg-4"> 
                                      </div>
                                  </div>
                                 </div>
                                  <div class="col-lg-5 "> 
                                    <fieldset class="border rounded" style="min-height:222px;">
                                      <legend  class="float-none w-auto legendLabel m-0"> متن پیامک </legend>
                                      <textarea cols="76" rows="10" id="messageContent" readonly> </textarea>
                                    </fieldset>
                                </div>
                            </div>
                      </fieldset>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal"> انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                      <button type="submit" id="submitNewGroup" class="btn btn-sm btn-success buttonHover"> ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                </div>
                </form>
              </div>
            </div>
          </div>
          </div>
          

        <!-- Edit takhfif code modal -->
          <div class="modal fade" id="editTakhfifCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl dragableModal modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h5 class="modal-title" id="exampleModalLongTitle"> ویرایش کد تخفیفی </h5>
                    <button type="button" class="close btn text-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255);"><i class="fa-solid fa-xmark fa-xl"></i></button>
                </div>
                  <div class="modal-body">
                    <fieldset class="border rounded">
                      <legend  class="float-none w-auto legendLabel m-0">   مدل پیامک   </legend>
                      <form action="{{url('/EditSMSModel')}}" id="EditSMSModelForm" method="get">
						  <input type="text" name="modelId" id="modelIdEd"/>
                        <div class="row">
                        <div class="col-md-2">

                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> نام مدل  </label>
                                 <input type="text" min="0" class="form-control form-control-sm" id="modelNameEd" name="modelName" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> کد </label>
                              <input type="text" class="form-control form-control-sm" name="code" id="generatedCodeEd" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> مبلغ (ریال) </label>
                              <input type="number" min="0" class="form-control form-control-sm" name="money" id="moblaghEd" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="mb-2">
                              <label for="exampleFormControlInput1" class="form-label-code"> مهلت استفاده (روز) </label>
                              <input type="number" min="0"  class="form-control form-control-sm" name="useDays" id="mohlatEd" placeholder="">
                            </div>
                          </div>
                          
                        </div>
                        </fieldset>
                        <fieldset class="border rounded">
                      <legend  class="float-none w-auto legendLabel m-0">  ساختار متن پیامک  </legend>
                        <div class="row ">
                            <div class="col-lg-3"> 
                                 <p class='mb-0'>  متن عمومی  </p>
                            </div>
                        </div>
                          <div class="row">
                                  <div class="col-lg-7">
                                     <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" class="form-control form-control-sm" name="firstText" id="firstContentEd" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="firstSelect" type="text" class="form-select form-select-sm" id="selectOptionEd">
                                                <option value="">    </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                             <span> <input class="form-check-input" name="firstCurrency" type="checkbox" id="reyalEd1"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span> <input class="form-check-input" name="firstNLine" type="checkbox" id="firstLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="secondText" class="form-control form-control-sm" id="secondContentEd" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="secondSelect"  type="text" class="form-select form-select-sm" id="secondOptionEd">
                                                <option value="">  </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                             <span> <input class="form-check-input" name="secondCurrency" type="checkbox" id="reyalEd2"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span ><input class="form-check-input" name="secondNLine" type="checkbox" id="secondLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="thirdText" class="form-control form-control-sm" id="thirthContentEd">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="thirdSelect"  type="text" class="form-select form-select-sm" id="thirthOptionEd">
                                                <option value="">    </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                              <span ><input class="form-check-input" name="thirdCurrency" type="checkbox"id="reyalEd3"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span>  <input class="form-check-input" name="thirdNLine" type="checkbox" id="thirthLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="fourthText" class="form-control form-control-sm" id="fourthContentEd" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 px-0"> 
                                            <select name="fourthSelect" type="text" class="form-select form-select-sm" id="fourthOptionEd">
                                                <option value=""></option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                             <span> <input class="form-check-input" name="fourthCurrency" type="checkbox" id="reyalEd4"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span ><input class="form-check-input" type="checkbox" name="fourthNLine" id="fourthLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="mb-2">
                                              <input type="text" name="fifthText" class="form-control form-control-sm" id="fifthContentEd" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 px-0"> 
                                            <select name="fifthSelect"  type="date" class="form-select form-select-sm" id="fifthOptionEd">
                                                <option value=""> </option>
                                            </select> 
                                        </div>
                                        <div class="col-lg-1 px-1"> 
                                             <span> <input class="form-check-input" name="fifthCurrency" type="checkbox" id="reyalEd5"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span ><input class="form-check-input" type="checkbox" name="fifthNLine" id="fifthLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-4"> 
                                          <div class="mb-2">
                                                <input type="text" name="sixthText" class="form-control form-control-sm" id="sixthContentEd">
                                          </div>
                                      </div>
                                      <div class="col-lg-4 px-0"> 
                                          <select name="sixthSelect" type="date" class="form-select form-select-sm" id="sixthOptionEd">
                                              <option value=""> </option>
                                          </select> 
                                      </div>
                                      <div class="col-lg-1 px-1"> 
                                             <span> <input class="form-check-input" name="sixthCurrency" type="checkbox" id="reyalEd6"> ریال </span>
                                        </div>
                                        <div class="col-lg-3"> 
                                            <div class="mb-2">
                                                <span ><input class="form-check-input" type="checkbox" name="sixthNLine" id="sixthLineEd"> خط بعدی </span>
                                            </div>
                                        </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-lg-4 px-1"> 
                                          <div class="mb-2">
                                                <input type="text" name="seventhText" class="form-control form-control-sm" id="seventhContentEd">
                                          </div>
                                      </div>
                                      <div class="col-lg-4"> 
                                      </div>
                                  </div>
                                 </div>
                                  <div class="col-lg-5 "> 
                                    <fieldset class="border rounded" style="min-height:222px;">
                                        <legend  class="float-none w-auto legendLabel m-0">   متن پیامک  </legend>
                                            <textarea cols="76" rows="10" id="messageContentEd"readonly> </textarea>
                                      </fieldset>
                                </div>
                            </div>
                      </fieldset>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                      <button type="submit" class="btn btn-sm btn-success buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                </div>
                </form>
              </div>
            </div>
          </div>


        <div class="modal fade" id="editCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered dragableModal" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <h5 class="modal-title" id="exampleModalLongTitle">ویرایش شهر</h5>
                        <button type="button" class="close btn text-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255);"><i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:5%; padding-right:0; padding-top:0; margin-right:10px">
                        <div class="c-checkout" style="padding:5%; padding-right:0; padding-top:0;">
                            <form action="{{ url('/editCity') }}" class="form" id="editCityForm" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label fs-6">شهر</label>
                                    <input type="text" size="10px" class="form-control" value="" name="cityName" id="cityNameEdit">
                                    <input type="hidden" size="10px" class="" name="cityIdEdit" id="cityIdEdit">
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                        <button type="submit" id="submitNewGroup" class="btn btn-sm btn-success buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade dragableModal" id="newCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <h5 class="modal-title" id="exampleModalLongTitle"> شهر جدید</h5>
                        <button type="button" class="close btn text-danger" data-dismiss="modal" aria-label="Close" style="background-color:#fff;">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                     <div class="modal-body" style="padding:5%; padding-right:0; padding-top:0; margin-right:10px">
                        <div class="c-checkout" style="padding:5%; padding-right:0; padding-top:0;">
                            <form action="{{url('/addNewCity')}}" method="GET" id="addCityForm" class="form">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label"> شهر</label>
                                    <input type="text" required class="form-control" autocomplete="off" name="cityName" id="cityName" placeholder="شهر">
                                </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                        <button type="submit" id="submitNewGroup" class="btn btn-sm btn-success buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
    </form>
    <div class="modal fade dragableModal" id="editMantagheh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white py-2">
                        <h5 class="modal-title" id="exampleModalLongTitle">ویرایش منطقه</h5>
                        <button type="button" class="close btn text-danger" data-dismiss="modal" aria-label="Close" style="background-color:rgb(255 255 255);"><i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:5%; padding-right:0; padding-top:0; margin-right:10px">
                        <div class="c-checkout" style="padding:5%; padding-right:0; padding-top:0;">
                            <form action="{{ url('/editMantagheh') }}" class="form" id="editMantaghehForm" method="GET">
                                @csrf
                            <div class="form-group">
                                <label class="form-label fs-6">منطقه</label>
                                <input type="text" size="10px" class="form-control" value="" name="Name" id="MantaghehNameEdit">
                                <input type="hidden" size="10px" class="" name="mantaghehIdEdit" id="mantaghehIdEdit">
                                <input type="hidden" size="10px" class="" name="cityId" id="mantiqahCity">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                        <button type="submit" id="submitNewGroup" class="btn btn-sm btn-success buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade dragableModal" id="addMontiqah" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="background-color:red;"></button>
                  <h5 class="modal-title" id="staticBackdropLabel">افزودن منطقه</h5>
                </div>
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-2 col-form-label fs-6">شهر  </label>
                    <select class="form-select" aria-label="Default select example" id="city">
                        @foreach($cities as $city)
                        <option value="{{$city->SnMNM}}">{{$city->NameRec}}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control" placeholder="شهر" id="city" style="display: none;">
                    <label for="staticEmail" class="col-sm-2 col-form-label fs-6">منطقه   <i class="fa fa-plus-circle"  onclick="showInputMantiqah()" style="color:green; font-size:24px;"></i> </label>
                    <select class="form-select" aria-label="Default select example" id="mantiqahForAdd"></select>
                    <div  id="mantiqah" style="display: none;">
                       <input type="text" class="form-control" id='inputMantiqah'  placeholder="منطقه"  >
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger buttonHover" data-dismiss="modal">انصراف <i class="fa-solid fa-xmark fa-lg"></i></button>
                        <button type="submit" id="submitNewGroup" onclick="addMantiqah()"  class="btn btn-sm btn-success buttonHover">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>



<!-- مودلهای مربوط به تنظیمات معیار ها و امتیاز ها  -->


<!-- edit target modal -->
<div class="modal fade dragableModal" id="editingTargetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close text-danger bg-danger" data-dismiss="modal" aria-label="Close" style="color:red"></button>
        <h5 class="modal-title" id="staticBackdropLabel"> ویرایش تارگت </h5>
      </div>
      <form action="{{url('/editTarget')}}" method="GET" id="editTarget">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> اساس تارگت </label>
                <input type="text" class="form-control" disabled placeholder="خرید اولیه"  name="baseName" id="baseName" aria-describedby="emailHelp">
                <input type="hidden" name="targetId" id="targetIdForEdit">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 1 </label>
                <input type="text" class="form-control" placeholder="تارگت 1" name="firstTarget" id="firstTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگیت 1  </label>
                <input type="text" class="form-control" placeholder="" name="firstTargetBonus" id="firstTargetBonus">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 2 </label>
                <input type="text" class="form-control" placeholder="تارگت 2" name="secondTarget" id="secondTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 2   </label>
                <input type="text" class="form-control" placeholder="20" name="secondTargetBonus" id="secondTargetBonus">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگیت 3   </label>
                <input type="text" class="form-control" placeholder="23" name="thirdTarget" id="thirdTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 3   </label>
                <input type="text" class="form-control" placeholder="20" name="thirdTargetBonus" id="thirdTargetBonus">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
          <button type="submit" class="btn btn-success btn-sm">ذخیره <i class="fa fa-save"></i> </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Bazaryab Modal -->
<div class="modal fade dragableModal" id="editLotteryPrizes" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close" style="color:red"></button>
        <h5 class="modal-title" id="staticBackdropLabel">  ویرایش لاتری  </h5>
      </div>
      <form action="{{url('/editLotteryPrize')}}" method="GET" id="addTarget">
        <div class="modal-body">
          <div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> اول  </span>
					       <input type="text" class="form-control" name="firstPrize" id="LotfirstPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showfirstPrize[]" id="showfirstPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دوم   </span>
					       <input type="text" class="form-control" name="secondPrize" id="LotsecondPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showsecondPrize[]" id="showsecondPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> سوم  </span>
					       <input type="text" class="form-control" name="thirdPrize" id="LotthirdPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showthirdPrize[]" id="showthirdPrize">
					</div>
			  </div>
			 </div>
			
			 <div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> چهارم  </span>
					       <input type="text" class="form-control" name="fourthPrize" id="LotfourthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showfourthPrize[]" id="showfourthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> پنجم   </span>
					       <input type="text" class="form-control" name="fifthPrize" id="LotfifthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showfifthPrize[]" id="showfifthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> ششم  </span>
					       <input type="text" class="form-control" name="sixthPrize" id="LotsixthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showsixthPrize[]" id="showsixthPrize">
					</div>
			  </div>
			 </div>
			
			<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> هفتم   </span>
					       <input type="text" class="form-control" name="seventhPrize" id="LotseventhPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showseventhPrize[]" id="showseventhPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> هشتم    </span>
					       <input type="text" class="form-control" name="eightthPrize" id="LoteightthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showeightthPrize[]" id="showeightthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> نهم  </span>
					       <input type="text" class="form-control"  name="ninethPrize" id="LotninethPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showninethPrize[]" id="showninethPrize">
					</div>
			  </div>
			 </div>
			
			
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دهم    </span>
					       <input type="text" class="form-control" name="teenthPrize" id="LotteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showteenthPrize[]" id="showteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> یازده هم     </span>
					       <input type="text" class="form-control"  name="eleventhPrize" id="LoteleventhPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	   <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showeleventhPrize[]" id="showeleventhPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دوازده هم  </span>
					       <input type="text" class="form-control" name="twelvthPrize" id="LottwelvthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showtwelvthPrize[]" id="showtwelvthPrize">
					</div>
			  </div>
			 </div>
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> سیزدهم     </span>
					       <input type="text" class="form-control" name="thirteenthPrize" id="LotthirteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showthirteenthPrize[]" id="showthirteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm">چهاردهم      </span>
					       <input type="text" class="form-control" name="fourteenthPrize" id="LotfourteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showfourteenthPrize[]" id="showfourteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm">  پانزدهم   </span>
					       <input type="text" class="form-control" name="fiftheenthPrize" id="LotfiftheenthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox m-1" name="showfiftheenthPrize[]" id="showfiftheenthPrize">
					</div>
			  </div>
			 </div>
			
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
				     <span class="input-group-text" id="inputGroup-sizing-sm">  شانزدهم    </span>
				    <input type="text" class="form-control" name="sixteenthPrize" id="LotsixteenthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
				  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showsixteenthPrize[]" id="showsixteenthPrize">
				  </div>
			</div>
			 <div class="col-lg-4 col-md-4 col-sm-4"> 

			</div>
		</div>
		
		 </div>
        <div class="modal-footer">
          <div class="container">
          <div class="row">
            <div class="col-sm-3">
              <div class="input-group input-group-sm mb-2">
                <span class="input-group-text" id="inputGroup-sizing-sm"> حد اقل امتیاز لاتری  </span>
                <input type="text" class="form-control form-control-sm" @if(hasPermission(Session::get( 'adminId'),'specialSettingN') < 1) disabled @endif value="{{number_format($lotteryMinBonus)}}" name="lotteryMinBonus">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group input-group-sm mb-2">
                <span class="input-group-text" id="inputGroup-sizing-sm">امتیاز معرف</span>
                <input type="text" class="form-control form-control-sm" @if(hasPermission(Session::get( 'adminId'),'specialSettingN') < 1) disabled @endif value="{{$settings->useIntroBonus}}" name="introductionBonus">
              </div>
            </div>
            <div class="col-sm-6 text-end">
                <button type="button" class="btn btn-danger btn-sm d-end" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button> 
                <button type="submit" class="btn btn-success btn-sm">ذخیره <i class="fa fa-save"></i> </button>
            </div>
          </div>  
        </div>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- question Modal  -->
<div class="modal fade" id="listQuestionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="listQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="listQuestionModalLabel"> کیفیت کالا  چگونه بود ؟</h5>
      </div>
      <div class="modal-body">
      <div class="card mb-4">
            <div class="card-body">
                <div class="row">
					<div class="col-lg-12">
                      <div class="well">
                        <table class="table table-bordered" id="tableGroupList" >
                            <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام  مشتری</th>
                                    <th> جواب </th>
                                    <th> تاریخ </th>
                                    <th> حذف  </th>
                                </tr>
                            </thead>
                            <tbody  id="nazarListBody" style="height:calc(100vh - 333px); display:block; overflow-y:scroll">
                                
                            </tbody>
                        </table>
                      </div>
                    </div>
              </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">بستن <i class="fa fa-xmark"></i> </button>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>



<!-- question Modal  -->
<div class="modal fade" id="insetQuestion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insetQuestionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{url('/addNazarSanji')}}" method="get" id="addNazarSanjiForm">
        @csrf
      <div class="modal-header bg-success text-white py-2">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="insetQuestionLabel"> نظر سنجی جدید </h5>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-2">
                  <label for="exampleFormControlTextarea1" class="form-label fs-6">اسم نظر سنجی</label>
                  <input class="form-control" id="nazarSanjiName" name="nazarSanjiName">
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea2" class="form-label fs-6"> سوال اول </label>
                  <textarea class="form-control" id="content1" name="content1" rows="3"></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea3" class="form-label fs-6"> سوال دوم  </label>
                  <textarea class="form-control" id="content2" name="content2" rows="3"></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea4" class="form-label fs-6"> سوال سوم  </label>
                  <textarea class="form-control" id="content3" name="content3" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">بستن <i class="fa fa-xmark"></i> </button>
        <button type="submit" class="btn btn-success btn-sm"> ذخیره  <i class="fa fa-save"></i></button>
      </div>
    </form>
  </div>
</div>
</div>


<!-- Button trigger modal -->


<!-- Modal edit nazarSanji -->
<div class="modal fade" id="editNazarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editNazarModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
		   <h5 class="modal-title" id="editNazarModal"> ویرایش نظر سنجی  </h5>
      </div>
	 <form action="{{url('/updateQuestion')}}" method="get" id="updateQuestion">
        @csrf
		  <input type="hidden" name="nazarId" id="nazarId" value="">
        <div class="modal-body">
          <div class="card mb-4">
            <div class="card-body">
             <div class="row">
              <div class="col-lg-12">
                <div class="mb-2">
                  <label for="exampleFormControlTextarea1" class="form-label fs-6">اسم نظر سنجی</label>
                  <input class="form-control" id="nazarName1" name="nazarSanjiName" value="">
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea2" class="form-label fs-6"> سوال اول </label>
                  <textarea class="form-control" id="cont1" name="content1" rows="2" value=""></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea3" class="form-label fs-6"> سوال دوم  </label>
                  <textarea class="form-control" id="cont2" name="content2" rows="2" value=""></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea4" class="form-label fs-6"> سوال سوم  </label>
                  <textarea class="form-control" id="cont3" name="content3" rows="2" value=""></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
           <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"> بستن <i class="fa fa-xmark"> </i> </button>
		  <button type="submit" class="btn btn-sm btn-success"> ذخیره <i class="fa fa-save"> </i> </button>
      </div>
	 </form>
    </div>
  </div>
</div>



<script type="text/javascript">

     var usedStrings = ['ali'];
        function generateRandomString(length) {
            var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var result = '';
            do {
                result = '';
                for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
                }
            } while (usedStrings.includes(result));
                usedStrings.push(result);
                return result;
            }

           var randomString = generateRandomString(10);
          document.getElementById('generatedCode').value = randomString;

        // geting values of input, option and checkbox show at the bottom.
          const firstInput = document.getElementById('firstContent');
          const firstOption = document.getElementById('selectOption');
          const firstLine = document.getElementById('firstLine');
          const reyal = document.getElementById('reyal1');
          let messageContent = document.getElementById('messageContent');

          const secondInput = document.getElementById('secondContent');
          const secondOption = document.getElementById('secondOption');
          const secondLine = document.getElementById('secondLine');
          const reyalOne = document.getElementById('reyal2');

          const thirthInput = document.getElementById('thirthContent');
          const thirthOption = document.getElementById('thirthOption');
          const thirthLine = document.getElementById('thirthLine');
          const reyalTwo = document.getElementById('reyal3');

          const fourthInput = document.getElementById('fourthContent');
          const fourthOption = document.getElementById('fourthOption');
          const fourthLine = document.getElementById('fourthLine');
          const reyalThree = document.getElementById('reyal4');

          const fifthInput = document.getElementById('fifthContent');
          const fifthOption = document.getElementById('fifthOption');
          const fifthLine = document.getElementById('fifthLine');
          const reyalFour = document.getElementById('reyal5');


          const sixthOption = document.getElementById('sixthOption');
          const sixthInput = document.getElementById('sixthContent');
          const seventhContent = document.getElementById('seventhContent');
          const reyalFive = document.getElementById('reyal6');


          firstInput.addEventListener('input', displayInputValue);
          firstOption.addEventListener('change', displayInputValue);
          firstLine.addEventListener('change', displayInputValue);
          reyal.addEventListener('change', displayInputValue);

          secondInput.addEventListener('input', displayInputValue);
          secondOption.addEventListener('change', displayInputValue);
          secondLine.addEventListener('change', displayInputValue);
          reyal1.addEventListener('change', displayInputValue);

          thirthInput.addEventListener('input', displayInputValue);
          thirthOption.addEventListener('change', displayInputValue);
          thirthLine.addEventListener('change', displayInputValue);
          reyal2.addEventListener('change', displayInputValue);
         

          fourthInput.addEventListener('input', displayInputValue);
          fourthOption.addEventListener('change', displayInputValue);
          fourthLine.addEventListener('change', displayInputValue);
          reyal3.addEventListener('change', displayInputValue);

          fifthInput.addEventListener('input', displayInputValue);
          fifthOption.addEventListener('change', displayInputValue);
          fifthLine.addEventListener('change', displayInputValue);
          reyal4.addEventListener('change', displayInputValue);


          sixthOption.addEventListener('change', displayInputValue);
          sixthInput.addEventListener('change', displayInputValue);
          seventhContent.addEventListener('change', displayInputValue);
          reyal5.addEventListener('change', displayInputValue);

          function displayInputValue() {
              const firstValue = firstInput.value;
              const firstOptionvalue = firstOption.value;
              let firstReyal = "";
              if (document.getElementById('reyal1').checked) {
                  firstReyal = "ریال";
              } else {
                  firstReyal = "";
              }

              const secondValue = secondInput.value;
              const secondOptionvalue = secondOption.value;
              let secondReyal = "";
              if (document.getElementById('reyal2').checked) {
                  secondReyal = "ریال";
              } else {
                  secondReyal = "";
              }

              const thirthValue = thirthInput.value;
              const thirthOptionvalue = thirthOption.value;
              let thirdReyal = "";
              if (document.getElementById('reyal3').checked) {
                  thirdReyal = "ریال";
              } else {
                  thirdReyal = "";
              }
             
              const fourthValue = fourthInput.value;
              const fourthOptionvalue = fourthOption.value;
              let fourthReyal = "";
              if (document.getElementById('reyal4').checked) {
                  fourthReyal = "ریال";
              } else {
                  fourthReyal = "";
              }

              const fifthValue = fifthInput.value;
              const fifthOptionvalue = fifthOption.value;
              let fifthReyal = "";
              if (document.getElementById('reyal5').checked) {
                  fifthReyal = "ریال";
              } else {
                  fifthReyal = "";
              }

              const sixthOptionValue = sixthOption.value;
              const sixthInputValue = sixthInput.value;
              let sixthReyal = "";
              if (document.getElementById('reyal5').checked) {
                  sixthReyal = "ریال";
              } else {
                  sixthReyal = "";
              }

              const sevenOptionValue = seventhContent.value;

              let firstLineValue="";
              let secondLineValue="";
              let thirthLineValue="";
              let fourthLineValue="";
              let fifthLineValue="";
              let sixthLineValue="";


              if (firstLine.checked==true) {
                  firstLineValue = "\n";
              }

              if (secondLine.checked==true) {
                secondLineValue = "\n";
              }

              if (thirthLine.checked==true) {
                thirthLineValue = "\n";
              }

              if (fourthLine.checked==true) {
                fourthLineValue = "\n";
              }
          
              if (fifthLine.checked==true) {
                fifthLineValue = "\n";
              }

              if (fifthLine.checked==true) {
                sixthLineValue = "\n";
              }

              // Clear the existing content
              messageContent.value = "";
              // Append each value to the messageContent paragraph
              messageContent.value += firstValue+` `+firstOptionvalue+` `+firstReyal+` `+firstLineValue+` `+secondValue+`
                                      `+secondOptionvalue+` `+secondReyal+` `+secondLineValue+` `+thirthValue+` `+thirthOptionvalue+`
                                      `+thirdReyal+` `+thirthLineValue+` `+fourthValue+` `+fourthOptionvalue+` `+fourthReyal+` 
                                      `+fourthLineValue+` `+fifthValue+` `+fifthOptionvalue+` `+fifthReyal+` `+fifthLineValue+`
                                      `+sixthInputValue+` `+sixthOptionValue+` `+sixthReyal+` `+sixthLineValue+` `+sevenOptionValue;

          }

         

//used for editing sms models.
          const firstInputEd = document.getElementById('firstContentEd');
          const firstOptionEd = document.getElementById('selectOptionEd');
          const firstLineEd = document.getElementById('firstLineEd');
          const reyalEd = document.getElementById('reyalEd1');
          let messageContentEd = document.getElementById('messageContentEd');

          const secondInputEd = document.getElementById('secondContentEd');
          const secondOptionEd = document.getElementById('secondOptionEd');
          const secondLineEd = document.getElementById('secondLineEd');
          const reyalOneEd = document.getElementById('reyalEd2');

          const thirthInputEd = document.getElementById('thirthContentEd');
          const thirthOptionEd = document.getElementById('thirthOptionEd');
          const thirthLineEd = document.getElementById('thirthLineEd');
          const reyalTwoEd = document.getElementById('reyalEd3');

          const fourthInputEd = document.getElementById('fourthContentEd');
          const fourthOptionEd = document.getElementById('fourthOptionEd');
          const fourthLineEd = document.getElementById('fourthLineEd');
          const reyalThreeEd = document.getElementById('reyalEd4');

          const fifthInputEd = document.getElementById('fifthContentEd');
          const fifthOptionEd = document.getElementById('fifthOptionEd');
          const fifthLineEd = document.getElementById('fifthLineEd');
          const reyalFourEd = document.getElementById('reyalEd5');


          const sixthOptionEd = document.getElementById('sixthOptionEd');
          const sixthInputEd = document.getElementById('sixthContentEd');
          const seventhContentEd = document.getElementById('seventhContentEd');
          const reyalFiveEd = document.getElementById('reyalEd6');


          firstInputEd.addEventListener('input', 	displayInputValueEd);
          firstOptionEd.addEventListener('change', 	displayInputValueEd);
          firstLineEd.addEventListener('change', 	displayInputValueEd);
          reyalEd.addEventListener('change', 		displayInputValueEd);

          secondInputEd.addEventListener('input', 	displayInputValueEd);
          secondOptionEd.addEventListener('change', displayInputValueEd);
          secondLineEd.addEventListener('change', 	displayInputValueEd);
          reyalOneEd.addEventListener('change', 	displayInputValueEd);

          thirthInputEd.addEventListener('input',   displayInputValueEd);
          thirthOptionEd.addEventListener('change', displayInputValueEd);
          thirthLineEd.addEventListener('change',   displayInputValueEd);
          reyalTwoEd.addEventListener('change', 	displayInputValueEd);
         

          fourthInputEd.addEventListener('input', 	displayInputValueEd);
          fourthOptionEd.addEventListener('change', displayInputValueEd);
          fourthLineEd.addEventListener('change', 	displayInputValueEd);
          reyalThreeEd.addEventListener('change', 	displayInputValueEd);

          fifthInputEd.addEventListener('input', 	displayInputValueEd);
          fifthOptionEd.addEventListener('change', 	displayInputValueEd);
          fifthLineEd.addEventListener('change', 	displayInputValueEd);
          reyalFourEd.addEventListener('change', 	displayInputValueEd);


          sixthOptionEd.addEventListener('change', 	displayInputValueEd);
          sixthInputEd.addEventListener('change', 	displayInputValueEd);
          seventhContentEd.addEventListener('change', displayInputValueEd);
          reyalFiveEd.addEventListener('change', 	displayInputValueEd);

          function displayInputValueEd() {
              const firstValue = firstInputEd.value;
              const firstOptionvalue = firstOptionEd.value;
              let firstReyal = "";
              if (document.getElementById('reyalEd1').checked) {
                  firstReyal = "ریال";
              } else {
                  firstReyal = "";
              }

              const secondValue = secondInputEd.value;
              const secondOptionvalue = secondOptionEd.value;
              let secondReyal = "";
              if (document.getElementById('reyalEd2').checked) {
                  secondReyal = "ریال";
              } else {
                  secondReyal = "";
              }

              const thirthValue = thirthInputEd.value;
              const thirthOptionvalue = thirthOptionEd.value;
              let thirdReyal = "";
              if (document.getElementById('reyalEd3').checked) {
                  thirdReyal = "ریال";
              } else {
                  thirdReyal = "";
              }
             
              const fourthValue = fourthInputEd.value;
              const fourthOptionvalue = fourthOptionEd.value;
              let fourthReyal = "";
              if (document.getElementById('reyalEd4').checked) {
                  fourthReyal = "ریال";
              } else {
                  fourthReyal = "";
              }

              const fifthValue = fifthInputEd.value;
              const fifthOptionvalue = fifthOptionEd.value;
              let fifthReyal = "";
              if (document.getElementById('reyalEd5').checked) {
                  fifthReyal = "ریال";
              } else {
                  fifthReyal = "";
              }

              const sixthOptionValue = sixthOptionEd.value;
              const sixthInputValue = sixthInputEd.value;
              let sixthReyal = "";
              if (document.getElementById('reyalEd5').checked) {
                  sixthReyal = "ریال";
              } else {
                  sixthReyal = "";
              }

              const sevenOptionValue = seventhContentEd.value;

              let firstLineValueEd="";
              let secondLineValueEd="";
              let thirthLineValueEd="";
              let fourthLineValueEd="";
              let fifthLineValueEd="";
              let sixthLineValueEd="";


              if (firstLineEd.checked==true) {
                  	firstLineValueEd = "\n";
              }else{
			  		firstLineValueEd = "";
			  }

              if (secondLineEd.checked==true) {
                	secondLineValueEd = "\n";
              }else{
                	secondLineValueEd = "";
			  }

              if (thirthLineEd.checked==true) {
                thirthLineValueEd = "\n";
              }else{
                thirthLineValueEd = "";
			  }

              if (fourthLineEd.checked==true) {
                fourthLineValueEd = "\n";
              }else{
                fourthLineValueEd = "";
			  }
          
              if (fifthLineEd.checked==true) {
                fifthLineValueEd = "\n";
              }else{
                fifthLineValueEd = "";
			  }

              if (fifthLineEd.checked==true) {
                sixthLineValueEd = "\n";
              }else{
                sixthLineValueEd = "";
			  }
              // Clear the existing content
              messageContentEd.value = "";
              // Append each value to the messageContent paragraph
              messageContentEd.value= firstValue+` `+firstOptionvalue+` `+firstReyal+` `+firstLineValueEd+` `+secondValue+`
                                      `+secondOptionvalue+` `+secondReyal+` `+secondLineValueEd+` `+thirthValue+` `+thirthOptionvalue+`
                                      `+thirdReyal+` `+thirthLineValueEd+` `+fourthValue+` `+fourthOptionvalue+` `+fourthReyal+` 
                                      `+fourthLineValueEd+` `+fifthValue+` `+fifthOptionvalue+` `+fifthReyal+` `+fifthLineValueEd+`
                                      `+sixthInputValue+` `+sixthOptionValue+` `+sixthReyal+` `+sixthLineValueEd+` `+sevenOptionValue;

          }
          

    $(document).ready(function() {
       $("#webSpecialSettingBtn").click(function() {
           $("#webSpecialSettingForm").submit();
       });
    });


    function startAgainNazar(){
	swal({
		  title: "آیا مطمئین هستید؟",
		  text: "یک بار نظر خواهی را از سر شروع کردید دوباره بر نمیگردد.",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			swal("شما نظر خواهی را از سر شروع کردید، موفق باشید!", {
			  icon: "success",
			});
		  } else {
			swal("نظر خواهی شروع نگردید");
		  }
		})
}
	
$("#secondOption").on("change",()=>{
	alert(document.getElementById("generatedCode").value);
	document.getElementsById("secondOption")[1].value=document.getElementById("generatedCode").value;
});
	
	$("#editLotteryPrizeBtn").on("click", ()=>{
		    if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 0
                });
              }
              $('#sentTosalesFactor').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
		
	     	$("#editLotteryPrizes").modal("show");
	});
  </script>



  
@endsection
