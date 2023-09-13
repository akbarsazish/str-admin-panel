@extends('admin.layout')
@section('content')

<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                 </fieldset>
             </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader" style="height:3%"> </div>
                   <div class="row mainContent">
                         @foreach ($parts as $part)
                          <form class="p-1" action="{{ url('/doEditGroupPart') }}" onsubmit="docmument.getElementById('showFirstPrice').disabled = false;" method="POST" enctype="multipart/form-data" class='form'>
                               @csrf
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class='form-group'>
                                                <label class='form-label'>اسم سطر</label>
                                                <input type='text' id='partTitle' 
													   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif value="{{trim($part->partTitle)}}" class='form-control form-control-sm' name='partTitle'/>
                                                <input type='text' id='partId' @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif style="display: none" value="{{ $part->partId }}"class='form-control form-control-sm' name='partId'/>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class='form-group'>
                                                <label class='form-label'>نوعیت دسته بندی</label>
                                                <select name='partType' @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif onchange='showDiv(this)' class='form-control form-control-sm' id='partType'>
                                                    <option value="{{$part->partType}}">{{ $part->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class='form-group'>
                                                <label class='form-label'>اولویت</label>
                                                <select  type='text' id="priority" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif  class='form-select form-select-sm' name='partPriority' placeholder=''>
                                                    @for ($i =3; $i <= (int)$countHomeParts; $i++)
                                                        <option @if((int)$part->priority==$i) selected @endif value="{{$i}}">{{$i-2}}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 d-flex align-items-stretch">
                                            <div class="form-group d-flex text-nowrap align-items-center pt-3">
                                                <input class="form-control d-flex form-check-input align-items-end" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif type="checkbox" name="activeOrNot" id="activeOrNot" @if ($part->activeOrNot==1)checked @else @endif> &nbsp;  &nbsp;
                                                 <label class="form-check-label align-items-end" style="font-weight: bold" for="activeOrNot">نمایش</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 text-end">
                                             <button type="submit" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="btn btn-success btn-sm text-warning">ذخیره <i class="fa-light fa-save"></i></button>
                                        </div>
                                 </div>
                        

                                <div class="row bg-light rounded border m-1">
                                    <div class="col-sm-2 d-flex align-items-stretch">
                                        <div class="form-group d-flex text-nowrap align-items-center">
                                            <input class="form-control d-flex form-check-input align-items-end" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif type="checkbox" name="showAll" id="activeAllSelection" @if($part->showAll==1) checked @else @endif>  &nbsp;  &nbsp;
                                            <label class="form-check-label align-items-end" style="font-weight: bold" for="activeAllSelection">فعالسازی انتخاب همه</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-stretch">
                                        <div class="form-group d-flex text-nowrap align-items-center">
                                            <input class="form-control d-flex form-check-input align-items-end" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif type="checkbox" name="showPercentTakhfif" id="showTakhfifPercent" @if($part->showPercentTakhfif==1) checked @else @endif>  &nbsp;  &nbsp;
                                            <label class="form-check-label align-items-end" style="font-weight: bold" for="showTakhfifPercent">نمایش در صد تخفیف</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-stretch">
                                        <div class="form-group d-flex text-nowrap align-items-center">
                                            <input class="form-control d-flex form-check-input align-items-end" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif type="checkbox" name="showOverLine" id="showFirstPrice"  @if($part->showOverLine==1) checked @else @endif> &nbsp;  &nbsp;
                                            <label class="form-check-label align-items-end" style="font-weight: bold" for="showFirstPrice">نمایش قیمت قبلی کالا</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-stretch">
                                        <div class="form-group d-flex text-nowrap align-items-center">
                                            <label class="col-sm-8 form-check-label pt-2" style="font-weight: bold" for="showKalaNum">نمایش تعداد کالا</label>
                                            <input type="number" name="showTedad" class="col-sm-4 form-control form-control-sm" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif id="showKalaNum" value="{{$part->showTedad}}">
                                        </div>
                                    </div>
                                
                                    @if($part->partType==11)
                                    <div class="col-sm-2" id="cp9">
                                        <label class="form-label form-label col-sm-8 pt-2" style="font-weight: bold">انتخاب رنگ</label>
                                        <input type="color" color="red"
											   	onchange="document.getElementById('colorDiv').style.backgroundColor=this.value;"
                                            	class="form-control form-control-sm col-sm-4 rounded border-danger p-1 m-0" id="colorPicker"
											   	name="shegeftColor" value="#ff0000">
                                    </div>
                                    <div class="col-sm-2" id="cp9">
                                        <label class="form-label btn btn-success btn-sm text-warning mt-3" for="photoPicker" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 )  @endif id="photoPickerID" style="font-weight: bold"> انتخاب عکس <i class="fa-light fa-image fa-lg"></i> </label>
<input type="file" onchange='document.getElementById("shegeftPicture").src = window.URL.createObjectURL(this.files[0]);'
	   class="form-control d-none" id="photoPicker" name="shegeftPicture">
                                    </div>
<div class="col-sm-2" id="cp9">
	<label>متن بجای عکس</label>
	<input type="text" onchange="document.getElementById('textLogoId').innerHTML=this.value;" class="form-control form-control-sm" value="{{$part->textLogo}}" name="shegeftText"/>
</div>
<div class="col-sm-2" id="cp9">
	<label> سایز فونت </label>
	<input type="number" onchange="document.getElementById('textLogoId').style.fontSize=this.value+'px';" class="form-control form-control-sm" value="{{$part->textFontSize}}" name="shegeftTextFontSize"/>
</div>
<div class="col-sm-2" id="cp9">
	<label>رنگ متن</label>
	<input type="color" onchange="document.getElementById('textLogoId').style.color=this.value;" class="form-control-sm" color="{{$part->textColor}}" name="shegeftTextColor">
</div>
<div class="col-sm-2" id="cp9">
	<button type="button" onclick="removeShegeftAngesLogo({{$part->partId}});" class="btn btn-sm btn-success">حذف عکس</button>
</div>
                                <div id="colorDiv" class="col-sm-12 rounded mx-auto mt-2" style=" background-color:{{$part->partColor}};">
                                    <div class="form-group text-center">
										<p id="textLogoId" style="color:{{$part->textColor}};font-size:{{$part->textFontSize}}px;">{{$part->textLogo}}</p>
                                        <img class="p-0 m-0" style="width: 20%; height:100px;" id="shegeftPicture" src="{{url('/resources/assets/images/shegeftAngesPicture/'.$part->partId.'.jpg')}}" alt="">
                                    </div>
                                </div>
                                @endif
                 
                            <div class="row rounded m-1">
                                <div class="form-group col-sm-4">
                                    <label class="form-label">جستجو</label>
                                    <input type="text" name="" class="form-control form-control-sm" @if($part->partType==13) id="pishKharidFirst" @else id="allKalaFirst" @endif autocomplete="off">
                                </div>
                                @if($part->partType != 13)
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">  گروه اصلی</label>
                                        <select class="form-select form-select-sm" id="searchGroup">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form-label">  گروه فرعی</label>
                                        <select class="form-control form-control-sm" id="searchSubGroup">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="grid-subgroup">
                                <div class="subgroup-item">
                                    <table class="table table-bordered table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th>
                                                    <input type="checkbox" name=""  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif   class="selectAllFromTop form-check-input">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="kalaList">
                                            @foreach ($kalas as $kala)
                                                <tr @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) onclick="checkCheckBox(this,event)" @endif>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $kala->GoodName }}</td>
                                                    <td>
                                                        <input class="form-check-input" type="checkBox" name="kalaListIds" value="{{ $kala->GoodSn.'_'.$kala->GoodName }}"id="flexCheckChecked">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>                     
                                </div>

                                <div class="subgroup-item mt-5">
                                    <button style="background-color:transparent;" id="addData" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif> <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i></button>
                                    <button style="background-color:transparent;" id="removeData" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif> <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i></button>
                                </div>
                                <div class="subgroup-item">
                                      <table class="table table-bordered table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th class="position-relative"> اسم </th>
                                                <th>
                                                    <button style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class='priority' id="down" type="button" value="down" ><i class="fa-solid fa-circle-chevron-down fa-sm" style=''></i></button> &nbsp;
                                                    <button style="background-color:transparent;"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class='priority' id="top"  type="button" value="up" >  <i class="fa-solid fa-circle-chevron-up fa-sm" style=''></i></button>
                                                </th>
                                                <th>
                                                    <input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif name=""  class="selectAllFromTop form-check-input"  >
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" id="addedKalaPart">
                                            @foreach ($addKalas as $kala)
                                                <tr @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) onClick="checkCheckBox(this,event)" @endif>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $kala->GoodName }}</td>
                                                    <td>
                                                        <input class="form-check-input" name="addedKala[]" type="checkBox" value="{{ $kala->GoodSn }}" id="flexCheckChecked">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>  
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>

@endsection
