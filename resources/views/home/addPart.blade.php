@extends('admin.layout')
@section('content')
 <style>
    .grid-picture {
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        padding: 5px;
        }
    .pic-item {
        padding: 8px;
        font-size: 14px;
        text-align: center;
        border:1px solid green; 
        border-radius:5px;
        margin:5px;
        }
 </style>
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
                <div class="row contentHeader" style="height:10px;"> </div>
                <div class="row mainContent">
                            <form action="{{ url('/addPart') }}" method="POST" class='form' enctype="multipart/form-data" method="GET" autocomplete="off">
                                    @csrf
                                    <div class="row mt-2">
                                    <div class="col-sm-3">
                                        <div class='form-group'>
                                            <input class="form-control form-control-sm" id='partTitle' type='text' required class='form-control' name='partTitle' placeholder='اسم سطر'/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class='form-group'>
                                            <select class='form-select form-select-sm'  id='partType' name='partType' onchange='showDiv(this)' placeholder=' دسته بندی'>
                                               <option selected value="1">دسته بندی</option>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class='form-group'>
                                            <select class='form-select form-select-sm' type='text' required id="priority" name='priority' placeholder='اولویت'>
                                                <option selected value=""> اولویت</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                         <div class='form-group' style="float:left">
                                            <button class="btn btn-success btn-sm text-warning" type="submit" id="addParts" value="addGroupToPart" name="addGroupToPart">ذخیره <i class="fa-light fa-save fa-lg"></i></button>
                                        </div>
                                     </div>
                                </div>

                                <div class='c-checkout p-0 mx-auto' style='border-radius:10px 10px 2px 2px;'>
                                    <div class="form-group p-0" id='newGroup'>
                                        <div class='col-sm-4 m-1'>
                                            <input type='search' class='form-control form-control-sm' id="search_mainGroup2" name='search_mainPart' placeholder='جستجو'/>
                                        </div>
                                        <div class="row ">
                                            <div class="col-sm-5">
                                                <table class="table table-bordered  table-sm" id='myTable'>
                                                    <thead class="bg-success tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>اسم کالا</th>
                                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody  id="groupPart" style="height: 360px !important;" class="tableBody"> </tbody>
                                                </table>                                  
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <div class='modal-body'>
                                                    <div>
                                                        <a id="addDataGroupList">
                                                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                                        </a> <br>
                                                        <a id="removeDataGroupList">
                                                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <table class="table table-bordered table-sm t" id='myTable'>
                                                    <thead class="bg-success tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody  id="addedGroupPartAdd" class="tableBody" style="height: 360px !important;"></tbody>
                                                </table>                                 
                                            </div>                            
                                         </div>
                                    </div>
                                </div>
                            </form>
                     </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>

    <!-- end  Adding -->
    <script type='text/javascript'>
        function showDiv(select) {
            var groupsPart = `
                    <div class='well  p-0'>
                        <div class='col-sm-4 m-1'>
                            <input type='search' class='form-control form-control-sm' id="search_mainGroup3" name='search_mainPart' placeholder='جستجو'/>
                        </div>
                    </div>                   
                    <div class="row p-0">
                        <div class="col-sm-5">
                            <table class="table table-bordered table  table-sm ">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>گروه اصلی </th>
                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody" id="groupPart" style="height: 300px !important;"></tbody>
                            </table>
                        </div>

                        <div class="col-sm-2 text-center">
                            <a id="addDataGroupList">
                                <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                            </a> <br>
                            <a id="removeDataGroupList">
                                <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                            </a>
                        </div>

                        <div class="col-sm-5">  
                            <table class="table table-bordered table  table-sm">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>گروه اصلی </th>
                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                    </tr>
                                </thead>
                                <tbody  id="addedGroupPartAdd" style="height: 300px !important;"></tbody>
                            </table> 
                     </div> 
                    `;
            var kalaList = `

            <div class="row modal-body pb-0">
                <div class='row col-sm-12 border rounded-2 m-1 mx-1 py-1 mb-2'>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <input class="form-control d-flex form-check-input align-items-end mx-2" type="checkbox" name="showAll" id="activeAllSelection" >
                        <label class="form-check-label align-items-end" style="font-weight:bold" for="activeAllSelection">فعالسازی انتخاب همه</label>
                    </div>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <input class="form-control d-flex form-check-input align-items-end mx-2" type="checkbox" name="showOverLine" id="showOverLine" >
                        <label class="form-check-label align-items-end font-weight-bold" style="font-weight:bold" for="showOverLine">نمایش قیمت قبلی کالا</label>
                    </div>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <label class="col-sm-8 form-label pt-2" style="font-weight: bold" for="showKalaNum"> نمایش تعداد کالا </label>
                        <input class="col-sm-4 form-control form-control-sm" type="number" name="showTedad" id="showKalaNum">
                    </div>
                </div>
            </div>

            <div class="row p-0 mt-0 modal-boady">
                <div class='col-sm-12 d-flex'>
                    <input type="search" class='col-sm-3 form-control form-control-sm mx-3' id="searchKala" name="search_mainPart" placeholder="جستجو"/>
                </div>
                <div class="col-sm-5" >
                    <table class="table table-bordered table  table-sm" id="kalaTableRight">
                        <thead class="tableHeader">
                            <tr>
                                <th>ردیف</th>
                                <th>گروه اصلی </th>
                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                            </tr>
                        </thead>
                        <tbody style="height: 300px !important;" class="tableBody" id="kalaList"> </tbody>
                    </table>
                </div>

                <div class="col-sm-2 text-center mt-5">
                        <a id="addDataKalaList">
                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                        </a> <br>
                        <a  id="removeDataKalaList">
                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                        </a>
                </div>

                <div class="col-sm-5">
                    <table id="tblLocations" class="table table-bordered table  table-sm "'>
                        <thead class="tableHeader">
                            <tr>
                                <th> ردیف </th>
                                <th> گروه اصلی </th>
                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                            </tr>
                        </thead>
                        <tbody class="tableBody" style="height: 300px !important;" id="addedKalaPartAdd"> </tbody>
                    </table>
                 </div>
            </div>
            `;
            var pishKharid = `
            <div class="row modal-body pb-0">
                <div class='row col-sm-12 border rounded-2 m-1 py-1'>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <input class="form-control d-flex form-check-input align-items-end mx-2" type="checkbox" name="showAll" id="activeAllSelection" >
                        <label class="form-check-label align-items-end" style="font-weight:bold" for="activeAllSelection">فعالسازی انتخاب همه</label>
                    </div>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <input class="form-control d-flex form-check-input align-items-end mx-2" type="checkbox" name="showOverLine" id="showOverLine" >
                        <label class="form-check-label align-items-end font-weight-bold" style="font-weight:bold" for="showOverLine">نمایش قیمت قبلی کالا</label>
                    </div>
                    <div class="col-sm-4 form-group d-flex text-nowrap align-items-center">
                        <label class="col-sm-8 form-label pt-2" style="font-weight: bold" for="showKalaNum"> نمایش تعداد کالا </label>
                        <input class="col-sm-4 form-control form-control-sm" type="number" name="showTedad" id="showKalaNum">
                    </div>
                </div>
            </div>
            <div class="row p-0 mt-0 modal-boady">
                <div class='col-sm-12 d-flex'>
                    <input type="search" class='col-sm-3 form-control form-control-sm mx-2' id="searchKala" name="search_mainPart" placeholder="جستجو"/>
                </div>
                <div class="col-sm-5" >
                        <table class="table table-bordered table-sm" id="kalaTableRight">
                            <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th>گروه اصلی</th>
                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" style="height: 300px !important;" id="kalaList">
                            </tbody>
                        </table>
                </div>
                <div class="col-sm-2 text-center">
                        <a id="addDataKalaList">
                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                        </a> <br>
                        <a  id="removeDataKalaList">
                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                        </a>
                </div>
                <div class="col-sm-5">
                        <table id="tblLocations" class="table table-bordered table  table-sm ">
                            <thead class="tableHeader">
                                <tr>
                                    <th> ردیف </th>
                                    <th> گروه اصلی </th>
                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" style="height: 300px !important;" id="addedKalaPartAdd">
                            </tbody>
                        </table>
                 </div>
            </div>`;

            var shegeftAngiz = `
                <div class="row border rounded-2 m-1 py-1">
                    <div id='' class='row p-0'>
                        <div class="col-sm-2 d-flex align-items-stretch">
                            <div class="form-group d-flex text-nowrap align-items-center">
                                <input class="form-control d-flex form-check-input align-items-end" type="checkbox" name="showAll" id="activeAllSelection">
                                <label class="form-check-label align-items-end mx-2" style="font-weight: bold" for="activeAllSelection">فعالسازی انتخاب همه</label>
                            </div>
                        </div>
                        <div class="col-sm-2 d-flex align-items-stretch">
                            <div class="form-group d-flex text-nowrap align-items-center">
                                <input class="form-control d-flex form-check-input align-items-end" type="checkbox" name="showOverLine" id="showFirstPrice">
                                <label class="form-check-label align-items-end mx-2" style="font-weight: bold" for="showFirstPrice">نمایش قیمت قبلی کالا</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group d-flex text-nowrap align-items-center">
                                <label class="col-sm-8 form-check-label pt-2" style="font-weight: bold" for="showKalaNum">نمایش تعداد کالا</label>
                                <input type="number" name="showTedad" class="col-sm-4 form-control form-control-sm" id="showKalaNum" value="">
                            </div>
                        </div>
                        <div id="cp9" class="col-sm-2 ">
                            <label class="form-check-label" for="colorPicker" style="font-weight: bold; display:inline-block !important;">انتخاب رنگ </label>
                            <input type="color" style="display:inline-block !important; width:55px !important;" onchange="document.getElementById('colorDiv').style.backgroundColor=this.value;" class="form-control form-control-sm rounded border-danger" id="colorPicker" name="shegeftColor" value="#ff0000">
                        </div>
                        <div id="cp9" class="col-sm-2">
                            <label class="form-label btn btn-success btn-sm" for="photoPicker" id="photoPickerID" style="font-weight: bold;"> انتخاب عکس <i class="fa-light fa-image fa-lg"></i></label>
                            <input type="file" onchange='document.getElementById("shegeftPicture").src = window.URL.createObjectURL(this.files[0]); '
                                class="form-control d-none" id="photoPicker" name="shegeftPicture" value="">
                        </div>
                        <div id="colorDiv" class="col-sm-2">
                            <div class="form-group">
                                <img class="p-0 m-0" style="width: 80px; height:100%; background-color:white !important;" id="shegeftPicture" src="{{url('/resources/assets/images/shegeftAngesPicture/.jpg')}}" alt="عکس انتخاب کنید">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row p-0">
                <div class='col-sm-12 row'>
                    <div class="col-sm-5 px-5 pr-0">     
                        <input type="search" name="search_mainPart" class="form-control form-control-sm" id="basic-url" aria-describedby="basic-addon3" placeholder="جستجو">
                    </div>
                    <div class="col-sm-2"></div>  
                    <div class="col-sm-5 px-5">    
                        <select name="cars" class="form-select form-select-sm" id="cars">
                            <option value="volvo">جستجوی گروهی</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class='modal-body'>
                        <div class='c-checkout' style='padding-right:0;'>
                            <table class="table table-bordered table  table-sm">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>اسم </th>
                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody" style="height: 300px !important;" id="kalaList">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 d-flex align-items-center">
                <div class='modal-body'>
                        <div>
                            <a id="addDataToShegeftAngiz">
                                <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                            </a>
                            <a id="removeDataFromShegeftAngiz">
                                <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class='modal-body'>
                        <div class='c-checkout' style='padding-right:0;'>
                            <table class="table table-bordered table  table-sm">
                                <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>گروه اصلی </th>
                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody" style="height: 300px !important;" id="addedShegeftAdd">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>`;

            var brands = `
            <div class="row p-0" >
                <div class="col-sm-12" id="addTakhsisKala">
                        <div class="takhsisContainerDisplay row rounded border m-1" id="takhsisContainer1">
                            <div class="col-sm-2 d-flex align-items-stretch align-items-center">
                                <div class="form-group d-flex text-nowrap align-items-center justify-content-center">
                                    <input class="form-control d-flex form-check-input align-items-end mx-2" type="checkbox" name="showAll" id="activeAllSelection">
                                    <label class="form-check-label align-items-end pt-1" style="font-weight: bold" for="activeAllSelection">فعالسازی انتخاب همه</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-stretch align-items-cent" style="width:20%">
                                <div class="form-group d-flex text-nowrap align-items-center justify-content-center">
                                    <label class="form-check-label pt-2" style="font-weight: bold" for="showKalaNum">نمایش تعداد کالا</label>
                                    <input type="number" name="showTedad" class="col-sm-4 form-control form-control-sm m-1" id="showKalaNum" value="">
                                </div>
                            </div>
                         </div>

                        <div class="row mt-1 text-center">
                          <div class="col-sm-5">
                                <input class="col-sm-10 form-control form-control-sm" type="text" name="search_mainPart" id="basic-url" aria-describedby="basic-addon3" placeholder="جستجو">
                                    <table class="table table-bordered table  table-sm "'>
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم  </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;"  id="kalaListBrand1"> </tbody>
                                    </table>
                           </div>
                            <div class="col-sm-2 text-center mt-5">
                                    <button type="button" id="addDataToBrandItem1" value="1" onclick="addKalaToBrandItem(this)"
                                        style=" border:none; background:none">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                    </button> <br>
                                    <button type="button" id="removeDataFromBrandItem1" value="1"  onclick="removeKalaFromBrandItem(this)" 
                                    style=" border:none; background:none">
                                        <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                    </button>
                            </div>
                          <div class="col-sm-5">
                                    <select class="col-sm-10 form-select form-select-sm" name="cars" id="cars">
                                        <option value="volvo">جستجوی گروهی</option>
                                    </select>
                                    <table class="table table-bordered table  table-sm">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="addedKalaOfBrand1">
                                        </tbody>
                                    </table>
                          </div>
                     </div>
                </div>
            </div> `;

            var onePic = `<div class="container">
                            <div class='row d-flex justify-content-center m-auto p-1'>
                                <div class='col-lg-2 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                    <img id="imageSrc1" class="p-0" style="width:100%; height:14vh"  onerror='' src="">
                                    <div class="d-flex justify-content-center m-1 p-0">
                                        <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('onePicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                        <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="firstPicOfOnePic"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                    </div>
                                    <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="onePic" id="onePicId" style="display: none"/>
                                </div>
                            </div>
                            <div class='c-checkout m-0' id="editingBodyGroup" style='padding-right:0;'>
                                   <div class="row" id="firstListOfOnePic" style="display:none;">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="search" name="" class="form-control form-control-sm" id="searchKala1Pic1">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-select form-select-sm" id="searchMainGroup1Pic1">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-select form-select-sm" id="searchSubGroup1Pic1">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                     <div class="col-sm-5">
                                        <div class='modal-body'>
                                            <div class='c-checkout' style='padding-right:0;'>
                                                <table class="table table-bordered table  table-sm ">
                                                    <thead tableHeader>
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>اسم </th>
                                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height: 288px !important;" id="onePicKalaPart1">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                        <div class='modal-body'>
                                            <div style="">
                                                <a id="addDataOnePic1">
                                                    <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                                </a>
                                                <a id="removeDataOnePic1">
                                                    <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class='modal-body'>
                                            <div class='c-checkout' style='padding-right:0;'>
                                                <table class="table table-bordered table  table-sm ">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>گروه اصلی </th>
                                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody" style="height: 288px !important;" id="onePicAddedKalaPart1">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;


   var twoPic = `<div class="container">
                    <div class='row d-flex justify-content-center m-auto p-1'>
                        <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                            <img id="imageSrc1" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                            <div class="d-flex justify-content-center m-1 p-0">
                                <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('firstPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="firstPicOfTwoPic"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                            </div>
                            <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="firstPic" id="firstPicId" style="display: none"/>
                        </div>
                        <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                            <img id="imageSrc2" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                            <div class="d-flex justify-content-center m-1 p-0">
                                <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('secondPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="secondPicOfTwoPic"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                            </div>
                            <input type="file"  onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])'  name="secondPic" id="secondPicId" style="display: none"/>
                        </div>
                    </div>
                    <div class='c-checkout rounded-top p-0' id="firstListOfTwoPic" style="display:none;"> 
                        <div class="container p-0">
                            <div class="row m-0 p-0">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">جستجو</label>
                                                <input class="form-control form-control-sm" type="search" name="" id="searchKala2Pic1">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه اصلی</label>
                                                <select class="form-select form-select-sm" id="searchMainGroup2Pic1">
                                                    <option value="" selected disabled hidden>همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه فرعی</label>
                                                <select class="form-select form-select-sm" id="searchSubGroup2Pic1">
                                                    <option value="" selected disabled hidden>همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>

                                    <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm "'>
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>اسم </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" style="height:300px !important;" id="twoPicKalaPart1"> </tbody>
                                        </table>
                                    </div>

                                <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                    <div class='modal-body'>
                                        <div style="">
                                            <a id="addDataTwoPic1">
                                                <i class="fa-regular fa-circle-chevron-left fa-2x text-success"></i>
                                            </a>
                                            <a id="removeDataTwoPic1">
                                                <i class="fa-regular fa-circle-chevron-right fa-2x text-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm "'>
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height:300px !important;" id="towPicAddedKalaPart1"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='c-checkout rounded-top p-0' id="secondListOfTwoPic" style="display:none;"> 
                        <div class="container p-0">
                            <div class="row m-0 p-0">
                                <div class='modal-body'>
                                    <div class='c-checkout rounded p-0'>
                                        <div class="container" style="padding:15px;">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">جستجو</label>
                                                        <input class="form-control form-control-sm" type="search" name="" size="20" id="searchKala2Pic2">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                                        <select class="form-select form-select-sm" id="searchMainGroup2Pic2">
                                                            <option value="" selected disabled hidden>همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                                        <select class="form-select form-select-sm" id="searchSubGroup2Pic2">
                                                            <option value="" selected disabled hidden>همه کالا ها</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class='modal-body'>
                                        <div class='c-checkout' style='padding-right:0;'>
                                            <table class="table table-bordered table  table-sm "'>
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>اسم </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height: 300px !important;" id="twoPicKalaPart2">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2 text-center">
                                    <a id="addDataTwoPic2">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                    </a>
                                    <a id="removeDataTwoPic2">
                                        <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                    </a>
                                </div>
                                <div class="col-sm-5">
                                    <div class='modal-body'>
                                        <div class='c-checkout' style='padding-right:0;'>
                                            <table class="table table-bordered table  table-sm "'>
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height: 300px !important;" id="towPicAddedKalaPart2">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

    var threePic = `<div class="container">
                        <div class='row d-flex justify-content-center m-auto p-1'>
                            <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                <img id="imageSrc1" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                <div class="d-flex justify-content-center m-1 p-0">
                                    <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('firstPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                    <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="threePicAddKala1"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                </div>
                                <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="firstPic" id="firstPicId" style="display: none"/>
                            </div>

                            <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                <img id="imageSrc2" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                <div class="d-flex justify-content-center m-1 p-0">
                                    <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('secondPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                    <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="threePicAddKala2"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                </div>
                                <input type="file"  onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])'  name="secondPic" id="secondPicId" style="display: none"/>
                            </div>

                            <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                <img id="imageSrc3" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                <div class="d-flex justify-content-center m-1 p-0">
                                    <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('thirdPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                    <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="threePicAddKala3"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                </div>
                                <input type="file"  onchange='document.getElementById("imageSrc3").src = window.URL.createObjectURL(this.files[0])'  name="thirdPic" id="thirdPicId" style="display: none"/>
                            </div>
                        </div>
                        <div class='c-checkout rounded-top p-0' id="firstListOf3Pic" style="display:none;">
                            <div class="container m-0 p-0">
                                <div class="row m-0 p-0" >
                                    <div class='modal-body'>
                                        <div class='c-checkout' style='padding-right:0;'>
                                            <div class="container" style="padding:15px;">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">جستجو</label>
                                                            <input class="form-control form-control-sm" type="search" name="" id="searchKala3Pic1">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label"> جستجوی گروه اصلی</label>
                                                            <select class="form-select form-select-sm" id="searchMainGroup3Pic1">
                                                                <option value="" selected disabled hidden>همه کالا ها</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label"> جستجوی گروه فرعی</label>
                                                            <select class="form-select form-select-sm" id="searchSubGroup3Pic1">
                                                                <option value="" selected disabled hidden>همه کالا ها</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm "'>
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>اسم </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" style="height: 300px !important;" id="threePicKalaPart1"></tbody>
                                        </table>
                                    </div>

                                    <div class="col-sm-2 text-center">
                                        <a id="addData3Pic1">
                                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                        </a>
                                        <a id="removeData3Pic1">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm "'>
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>گروه اصلی </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody style="height: 300px !important;" id="threePicAddedKalaPart1">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='c-checkout rounded-top p-0' id="secondListOf3Pic"  style="display:none;">
                            <div class="container m-0 p-0">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input class="form-control form-control-sm" type="search" name="" id="searchKala3Pic2">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-select form-select-sm" id="searchMainGroup3Pic2">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-select form-select-sm" id="searchSubGroup3Pic2">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm "'>
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>اسم </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" style="height: 300px !important;" id="threePicKalaPart2"> </tbody>
                                        </table>
                                    </div>

                                    <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                        <a id="addData3Pic2">
                                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                        </a>
                                        <br />
                                        <a id="removeData3Pic2">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                        </a>
                                    </div>

                                    <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm "'>
                                            <thead class="tableHeader">
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>گروه اصلی </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" style="height: 300px !important;" id="threePicAddedKalaPart2"> </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                
                        <div class='c-checkout rounded-top p-0' id="thirdListOf3Pic"  style="display:none;">
                            <div class="container m-0 p-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">جستجو</label>
                                                <input class="form-control form-control-sm" type="search" name="" id="searchKala3Pic3">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه اصلی</label>
                                                <select class="form-select form-select-sm" id="searchMainGroup3Pic3">
                                                    <option value="" selected disabled hidden>همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه فرعی</label>
                                                <select class="form-select form-select-sm" id="searchSubGroup3Pic3">
                                                    <option value="" selected disabled hidden>همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-5">
                                            <table class="table table-bordered table  table-sm "'>
                                                <thead>
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>اسم </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="height: 300px !important;" id="threePicKalaPart3">
                                                    
                                                </tbody>
                                            </table>
                                      </div>

                                    <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                        <a id="addData3Pic3">
                                            <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                        </a>
                                        <br />
                                        <a id="removeData3Pic3">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                        </a>
                                    </div>

                                    <div class="col-sm-5">
                                        <table class="table table-bordered table  table-sm">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>گروه اصلی </th>
                                                    <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody style="height: 300px !important;" id="threePicAddedKalaPart3">
                                            
                                            </tbody>
                                        </table>
                                  </div> 
                         </div>
                    </div>`;

            var fourPic = `<div class="container">
                            <div class='row d-flex justify-content-center m-auto p-1'>
                                <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                    <img id="imageSrc1" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                    <div class="d-flex justify-content-center m-1 p-0">
                                        <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('firstPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                        <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="fourPicAddKala1"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                    </div>
                                    <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="firstPic" id="firstPicId" style="display: none"/>
                                </div>
                                <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                    <img id="imageSrc2" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                    <div class="d-flex justify-content-center m-1 p-0">
                                        <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('secondPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                        <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="fourPicAddKala2"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                    </div>
                                    <input type="file"  onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])'  name="secondPic" id="secondPicId" style="display: none"/>
                                </div>
                                <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                    <img id="imageSrc3" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                    <div class="d-flex justify-content-center m-1 p-0">
                                        <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('thirdPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                        <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="fourPicAddKala3"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                    </div>
                                    <input type="file"  onchange='document.getElementById("imageSrc3").src = window.URL.createObjectURL(this.files[0])'  name="thirdPic" id="thirdPicId" style="display: none"/>
                                </div>
                                <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:15vh !important;'>
                                    <img id="imageSrc4" class="p-0" style="width:100%; height:13vh"  onerror='' src="">
                                    <div class="d-flex justify-content-center m-1 p-0">
                                        <button class="btn btn-success btn-sm mx-1 text-warning" onclick="document.getElementById('fourthPicId').click();" type="button" style="display: inline;margin-right: 2%;"><i class="fa-light fa-image fa-lg"></i></button>
                                        <button class='btn btn-success btn-sm mx-1 text-warning' type="button" id="fourPicAddKala4"><i class="fa-light fa-cart-plus fa-lg"></i></button>
                                    </div>
                                    <input type="file"  onchange='document.getElementById("imageSrc4").src = window.URL.createObjectURL(this.files[0])'  name="fourthPic" id="fourthPicId" style="display: none"/>
                                </div>
                            </div>

                            <div class='c-checkout rounded-top p-0' id="firstListOf4Pic" style="display:none;">
                                <div class="container m-0 p-0">
                                    <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input class="form-control form-control-sm" type="search" name="" id="searchKala4Pic1">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-select form-select-sm" id="searchMainGroup4Pic1">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-select form-select-sm" id="searchSubGroup4Pic1">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                         <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm ">
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>اسم </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height: 300px !important;" id="fourPicKalaPart1"> </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-2 text-center">
                                            <a id="addData4Pic1">
                                                <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                            </a>
                                            <a id="removeData4Pic1">
                                                <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-5">
                                            <table class="table table-bordered table  table-sm "'>
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="height: 300px !important;" class="tableBody" id="fourPicAddedKalaPart1">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='c-checkout rounded-top p-0' id="secondListOf4Pic" style="display:none;">
                                <div class="container m-0 p-0">
                                   <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input class="form-control form-control-sm" type="search" name="" id="searchKala4Pic2">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-select form-select-sm" id="searchMainGroup4Pic2">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-select form-select-sm" id="searchSubGroup4Pic2">
                                                        <option value="" selected disabled hidden>همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                     <div class="row">
                                        <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm ">
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>اسم </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height:300px;" id="fourPicKalaPart2">
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-2 text-center mt-5">
                                             <a id="addData4Pic2">
                                                    <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                                </a>
                                                <a id="removeData4Pic2">
                                                    <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                                </a>
                                        </div>

                                        <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm ">
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height:300px !important;" id="fourPicAddedKalaPart2">
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='c-checkout rounded-top p-0' id="thirdListOf4Pic" style="display:none;">
                                <div class="container m-0 p-0">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                                    <select class="form-control form-control-sm" id="searchMainGroup4Pic3">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                                    <select class="form-select form-select-sm" id="searchSubGroup4Pic3">
                                                        <option value="0">همه کالا ها</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">جستجو</label>
                                                    <input type="text" name="" class="form-control form-control-sm" id="searchKala4Pic3">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <table class="table table-bordered table  table-sm "'>
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>اسم </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tableBody" style="height: 300px; !important" id="fourPicKalaPart3">
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-2 text-center mt-5">
                                            <a id="addData4Pic3">
                                                <i class="fa-regular fa-circle-chevron-left fa-3x text-success"></i>
                                            </a>
                                            <a id="removeData4Pic3">
                                                <i class="fa-regular fa-circle-chevron-right fa-3x text-success"></i>
                                            </a>
                                        </div>
                                                
                                        <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm "'>
                                                <thead>
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="height: 300px !important;" id="fourPicAddedKalaPart3"> </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='c-checkout rounded-top p-0' id="fourthListOf4Pic"  style="display:none;">
                                <div class="container m-0 p-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه اصلی</label>
                                                <select class="form-control form-control-sm" id="searchMainGroup4Pic4">
                                                    <option value="0">همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label"> جستجوی گروه فرعی</label>
                                                <select class="form-control form-control-sm" id="searchSubGroup4Pic4">
                                                    <option value="0">همه کالا ها</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">جستجو</label>
                                                <input type="text" name=""  class="form-control form-control-sm" id="searchKala4Pic4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm">
                                                    <thead class="tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>اسم </th>
                                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="height: 300px !important;" class="tableBody" id="fourPicKalaPart4"> </tbody>
                                                </table>
                                        </div>

                                        <div class="col-sm-2 text-center mt-5">
                                           <a id="addData4Pic4">
                                                <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                            </a>
                                            <a id="removeData4Pic4">
                                                <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                            </a>
                                        </div>

                                        <div class="col-sm-5">
                                             <table class="table table-bordered table  table-sm "'>
                                                <thead class="tableHeader">
                                                    <tr>
                                                        <th>ردیف</th>
                                                        <th>گروه اصلی </th>
                                                        <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="height: 300px !important;" class="tableBody" id="fourPicAddedKalaPart4">
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

            var fivePic = `<div class="container">
                           <div class="row" style="padding:5px; padding-right:0px;">
                                    <span> تخصیص کالا به عکس </span>
                                <div class="grid-picture" id='myTable'>
                                        <div class="pic-item">
                                            <label for="firstPic" class="form-label d-block">تصویر اول</label> 
                                            <input type="file" id="fivePicAllocation1" class="form-control" style=" display:none;" name="firstPic" >
                                            <label for="fivePicAllocation1" id="fivePicLabel1" class='btn btn-success btn-sm' class="form-label">انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label> 
                                           <button class='btn btn-success btn-sm text-white mt-1' type="button" data-toggle='modal' id="fivePicAddKala1"> تخصیص <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                                        </div>
                                        <div class="pic-item">
                                           <label for="firstPic" class="form-label d-block">تصویر دوم</label>
                                            <input type="file" class="form-control" name="secondPic" style=" display:none;" id="fivePicAllocation2">
                                            <label for="fivePicAllocation2" id="fivePicLabel2"class='btn btn-success btn-sm' class="form-label">انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label>
                                            <button class='btn btn-success btn-sm text-white mt-1' type="button" id="fivePicAddKala2"> تخصیص <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                                        </div>
                                    
                                        <div class="pic-item">
                                            <label for="firstPic" class="form-label d-block">تصویر سوم</label>
                                            <input type="file" class="form-control" name="thirdPic" style=" display:none;" id="fivePicAllocation3"> 
                                            <label for="fivePicAllocation3" id="fivePicLabel3"class='btn btn-success btn-sm' class="form-label">انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label>
                                            <button class='btn btn-success btn-sm text-white mt-1'  type="button" id="fivePicAddKala3"> تخصیص <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                                        </div>
                                       
                                        <div class="pic-item">
                                            <label for="firstPic" class="form-label d-block">تصویر چهارم</label>
                                            <input type="file" class="form-control" name="fourthPic" style=" display:none;" id="fivePicAllocation4"> 
                                            <label for="fivePicAllocation4" id="fivePicLabel4"class='btn btn-success btn-sm' class="form-label">انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label>
                                           <button class='btn btn-success btn-sm text-white mt-1'  type="button" id="fivePicAddKala4"> تخصیص <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                                        </div>
                                    
                                        <div class="pic-item">
                                            <label for="firstPic" class="form-label d-block">تصویر پنجم</label>
                                            <input type="file" class="form-control" name="fifthPic" style=" display:none;" id="fivePicAllocation5"> 
                                            <label for="fivePicAllocation5" id="fivePicLabel5"class='btn btn-success btn-sm' class="form-label">انتخاب عکس <i class="fa-solid fa-image fa-lg"></i></label>
                                           <button class='btn btn-success btn-sm text-white mt-1'  type="button" id="fivePicAddKala5"> تخصیص <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                                        </div>
                                </div>
                            <div style='direction:ltr; margin-left:0'>
                                <button type="submit" class="btn btn-success btn-sm" name="" id="onePicForm"> <i class="fa fa-save fa-lg" aria-hidden="true"></i> ذخیره </button>
                            </div>
                        </div>

                    <div class='c-checkout' id="firstListOf5Pic" style="display:none;">
                        <div class="container">
                             <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                        <select class="form-select form-select-sm" id="searchMainGroup5Pic1">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                        <select class="form-select form-select-sm" id="searchSubGroup5Pic1">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">جستجو</label>
                                        <input type="text" name=""  class="form-control form-control-sm" id="searchKala5Pic1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-5">
                                 <table class="table table-bordered table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>اسم </th>
                                            <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody" style="height: 300px !important;" id="fivePicKalaPart1">
                                        
                                    </tbody>
                                </table>
                            </div>

                                <div class="col-sm-2 text-center">
                                    <a id="addData5Pic1">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                    </a>
                                    <br />
                                    <a id="removeData5Pic1">
                                        <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                    </a>
                                </div>
                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicAddedKalaPart1"> </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='c-checkout' id="secondListOf5Pic"  style="display:none;">
                        <div class="container">
                             <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> جستجوی گروه اصلی</label>
                                        <select class="form-control" id="searchMainGroup5Pic2">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label"> جستجوی گروه فرعی</label>
                                        <select class="form-control" id="searchSubGroup5Pic2">
                                            <option value="0">همه کالا ها</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">جستجو</label>
                                        <input type="text" name="" size="20" class="form-control" id="searchKala5Pic2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                     <table class="table table-bordered table  table-sm "'>
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicKalaPart2">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <a id="addData5Pic2">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                    </a>
                                    <br />
                                    <a id="removeData5Pic2">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                    </a>
                                </div>
                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm "'>
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicAddedKalaPart2">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                  <div class='c-checkout' id="thirdListOf5Pic"  style="display:none;">
                        <div class="container">
                          <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                    <select class="form-control" id="searchMainGroup5Pic3">
                                        <option value="0">همه کالا ها</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                    <select class="form-control" id="searchSubGroup5Pic3">
                                        <option value="0">همه کالا ها</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">جستجو</label>
                                    <input type="text" name="" size="20" class="form-control" id="searchKala5Pic3">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-5">
                                      <table class="table table-bordered table  table-sm "'>
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody style="height: 400px;" id="fivePicKalaPart3">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 text-center">
                                   <a id="addData5Pic3">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                    </a>
                                    <br />
                                    <a id="removeData5Pic3">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                    </a>
                                </div>

                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm ">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicAddedKalaPart3">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                       
                        <div class='c-checkout' id="fourthListOf5Pic" style="display:none;">
                        <div class="container">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label"> جستجوی گروه اصلی</label>
                                            <select class="form-select form-select-sm" id="searchMainGroup5Pic4">
                                                <option value="0">همه کالا ها</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label"> جستجوی گروه فرعی</label>
                                            <select class="form-select form-select-sm" id="searchSubGroup5Pic4">
                                                <option value="0">همه کالا ها</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">جستجو</label>
                                            <input type="text" name="" class="form-control form-control-sm" id="searchKala5Pic4">
                                        </div>
                                    </div>
                                </div>
                             <div class="row">
                                <div class="col-sm-5">
                                     <table class="table table-bordered table  table-sm ">
                                        <thead class="tableHeader">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;"  id="fivePicKalaPart4">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 text-center">
                                    <a id="addData5Pic4">
                                        <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                    </a>
                                    <br />
                                    <a id="removeData5Pic4">
                                        <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                    </a>
                                </div>

                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm ">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicAddedKalaPart4">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class='c-checkout' id="fifthListOf5Pic"  style="display:none;">
                        <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label"> جستجوی گروه اصلی</label>
                                    <select class="form-select form-select-sm" id="searchMainGroup5Pic5">
                                        <option value="0">همه کالا ها</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label"> جستجوی گروه فرعی</label>
                                    <select class="form-select form-select-sm" id="searchSubGroup5Pic5">
                                        <option value="0">همه کالا ها</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">جستجو</label>
                                    <input type="text" name=""  class="form-control form-control-sm" id="searchKala5Pic5">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-5">
                                   <table class="table table-bordered table  table-sm "'>
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>اسم </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"  ></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;" id="fivePicKalaPart5">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 text-center">
                                     <a id="addData5Pic5">
                                            <i class="fa-regular fa-circle-chevron-left fa-3x"></i>
                                        </a>
                                        <br />
                                        <a id="removeData5Pic5">
                                            <i class="fa-regular fa-circle-chevron-right fa-3x"></i>
                                        </a>
                                </div>

                                <div class="col-sm-5">
                                    <table class="table table-bordered table  table-sm ">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>گروه اصلی </th>
                                                <th><input type="checkbox" name=""  class="selectAllFromTop form-check-input"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody" style="height: 300px !important;"  id="fivePicAddedKalaPart5">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                </div>`;

            var mainSlider = `<div class="container p-0 m-auto">
                                <div class='row d-flex justify-content-center m-auto p-1'>
                                    <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>

                                        <img id="imageSrc1" class="p-0" style="width:100%; height:18vh"  onerror='' src="">
                                        <div class="d-flex justify-content-center m-1 p-0">
                                            <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('firstPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                        </div>
                                        <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="firstPic" id="firstPic" style="display: none"/>
                                    </div>
                                    <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                        <img id="imageSrc2" class="p-0" style="width:100%; height:18vh" src="">
                                        <div class="d-flex justify-content-center m-1 p-0">
                                            <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('secondPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                        </div>
                                        <input type="file"  onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])'  name="secondPic" id="secondPic" style="display: none"/>
                                    </div>

                                    <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                        <img id="imageSrc3" class="p-0" style="width:100%; height:18vh" src="">
                                        <div class="d-flex justify-content-center m-1 p-0">
                                            <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('thirdPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                        </div>
                                        <input type="file"  onchange='document.getElementById("imageSrc3").src = window.URL.createObjectURL(this.files[0])'  name="thirdPic" id="thirdPic" style="display: none"/>
                                    </div>
                                    <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                        <img id="imageSrc4" class="p-0" style="width:100%; height:18vh" src="">
                                        <div class="d-flex justify-content-center m-1 p-0">
                                            <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('fourthPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                        </div>
                                        <input type="file"  onchange='document.getElementById("imageSrc4").src = window.URL.createObjectURL(this.files[0])'  name="fourthPic" id="fourthPic" style="display: none"/>
                                    </div>
                                    <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                        <img id="imageSrc5" class="p-0" style="width:100%; height:18vh" src="">
                                        <div class="d-flex justify-content-center m-1 p-0">
                                            <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('fifthPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                        </div>
                                        <input type="file"  onchange='document.getElementById("imageSrc5").src = window.URL.createObjectURL(this.files[0])'  name="fifthPic" id="fifthPic" style="display: none"/>
                                    </div>
                                </div> 
                            </div>`;

            var firstSmallSlider = `<div class="container">
                                        <div class='row d-flex justify-content-center m-auto p-1'>
                                            <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                                <img id="imageSrc1" class="p-0" style="width:100%; height:18vh"  onerror='' src="">
                                                <div class="d-flex justify-content-center m-1 p-0">
                                                    <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('firstPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                                </div>
                                                <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="firstPic" id="firstPic" style="display: none"/>
                                            </div>
                                            <div class='col-lg-2 col-md-3 col-sm-4 p-1 mx-2 align-items-center c-checkout' style='height:25vh !important;'>
                                                <img id="imageSrc2" class="p-0" style="width:100%; height:18vh" src="">
                                                <div class="d-flex justify-content-center m-1 p-0">
                                                    <button class="btn btn-success btn-sm text-warning" onclick="document.getElementById('secondPic').click();" type="button" style="display: inline;margin-right: 2%;">انتخاب عکس</button>
                                                </div>
                                                <input type="file"  onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])'  name="secondPic" id="secondPic" style="display: none"/>
                                            </div>
                                        </div> 
                                    </div>`;
            var secondSmallSlider = `<div class="container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="firstPic" class="form-label">تصویر اول</label>
                                    <input type="file" class="form-control" name="" id="">
                                </div>
                                <div class="col-sm-3">
                                    <label for="firstPic" class="form-label">تصویر دوم</label>
                                    <input type="file" class="form-control" name="" id="">
                                </div>
                                <div class="col-sm-3">
                                    <label for="firstPic" class="form-label">تصویر سوم</label>
                                    <input type="file" class="form-control" name="" id="">
                                </div>
                                <div class="col-sm-3">
                                    <label for="firstPic" class="form-label">تصویر چهارم</label>
                                    <input type="file" class="form-control" name="" id="">
                                </div>
                            </div>
                        </div>`;


            switch (select.value) {
                case "1":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = groupsPart;
                    break;
                case "2":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = kalaList;
                    break;
                case "3":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = mainSlider;
                    break;
                case "4":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = firstSmallSlider;
                    break;
                case "5":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = secondSmallSlider;
                    break;
                case "6":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = onePic;
                    break;
                case "7":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = twoPic;
                    break;
                case "8":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = threePic;
                    break;
                case "9":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = fourPic;
                    break;
                case "10":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = fivePic;
                    break;
                case "11":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = shegeftAngiz;
                    break;
                case "12":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = brands;
                    break;
                case "13":
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = pishKharid;
                    break;
                default:
                    document.getElementById('newGroup').innerHTML = "";
                    document.getElementById('newGroup').innerHTML = groupsPart;
                    break;
            }
        $.ajax({
        method: 'get',
        url: baseUrl + '/getListBrand',
        async: true,
        success: function(arrayed_result) {
            for (var i = 0; i <= arrayed_result.length - 1; i++) {
                $(`#kalaListBrand1`).append(` <tr  onclick="checkCheckBox(this,event)">
                <td> ` + arrayed_result[i].id + ` </td> <td> ` + arrayed_result[i].name + `</td> 
                <td>
                    <input class = "form-check-input" name="kalaListBrand1[]" type="checkbox" value="` +arrayed_result[i].id + `_` + arrayed_result[i].name + `" id="kalaId">
                </td>
                </tr>`);
            }
        },
        error: function(data) {
            console.log("not good");
        }
    });
    }

        function changeEditModal() {
            const btn = document.querySelector('#editPart');
            const radioButtons = document.querySelectorAll('input[name="part"]');
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    document.querySelector('#last').style.display = "none";
                    break;
                }
            }
        }
    </script>
    <script>
        window.onload = function() {
            //used for setting priority to add new part
            $.ajax({
                method: 'get',
                url: '{{ url('/getPriorityList') }}',
                async: true,
                success: function(arrayed_result) {
                    for (var i = 1; i <= parseInt(arrayed_result[0].size)-1; i++) {
                        $('#priority').append(`<option value="` + (i+2) + `" >` +
                            i+ `</option>`);
                    }
                },
                error: function(data) {
                    console.log("not good");
                }

            });
            //used for displaying groupPart types
            $.ajax({
                method: 'get',
                url: '{{ url('/getPartType') }}',
                async: true,
                success: function(arrayed_result) {
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#partType').append(`<option value="` + arrayed_result[i].id + `" >` +
                            arrayed_result[i].name + `</option>`);
                    }
                },
                error: function(data) {
                    console.log("not good");
                }

            });

            //used for adding groups to group part default page
            $.ajax({
                        method: 'get',
                        url: '{{ url('/getListGroup') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#groupPart').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].id + `</td>
                                    <td>` + arrayed_result[i].title + `</td>
                                    <td>
                                    <input class="form-check-input" name="groupListIds[]" type="checkbox" value="` +
                                    arrayed_result[i].id + `_` + arrayed_result[i].title + `" id="kalaId">
                                    </td>
                                </tr>
                                `);

                            }
                        },
                        error: function(data) {
                            console.log("not good");
                        }

                    });

            //used for change content of bottom part of adding form of parts
            $('#partType').on('change', function() {
              
                var selectedVal = $(this).find(":selected").val();
                if (selectedVal == 2) {
                      //در صورتیکه کالا ها انتخاب شوند
                    $.ajax({
                        method: 'get',
                        url: '{{ url('/getListKala') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#kalaList').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="kalaListIds[]" type="checkbox" value="` +
                                    arrayed_result[i].GoodSn + '_' + arrayed_result[i]
                                    .GoodName + `" id="kalaId">
                                    </td>
                                </tr>
                                `);

                            }
                        },
                        error: function(data) {
                            console.log("not good");
                        }

                    });
                }
                if (selectedVal == 13) {
                //در صورتیکه پیشخرید انتخاب شوند
                    $.ajax({
                        method: 'get',
                        url: '{{ url('/getPrebuyAbles') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#kalaList').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="kalaListIds[]" type="checkbox" value="` +
                                    arrayed_result[i].GoodSn + '_' + arrayed_result[i]
                                    .GoodName + `" id="kalaId">
                                    </td>
                                </tr>
                                `);

                            }
                        },
                        error: function(data) {
                            console.log("not good");
                        }

                    });
                }
                if (selectedVal == 3 || selectedVal == 4) {
                //در صورتیکه انتخاب شوند
                    document.querySelector("#addParts").disabled = true;
                }else{
                    document.querySelector("#addParts").disabled = false;
                }

                if (selectedVal == 11) {
                      //در صورتیکه پیشنهاد شگفت انگیز انتخاب شوند
                    $.ajax({
                        method: 'get',
                        url: '{{ url('/getListKala') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#kalaList').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="shegeftAngizIds[]" type="checkbox" value="` +
                                    arrayed_result[i].GoodSn + '_' + arrayed_result[i]
                                    .GoodName + `" id="shegeftAngizIds">
                                    </td>
                                </tr>
                                `);
                            }
                        },
                        error: function(data) {
                            console.log("not good");
                        }
                    });
                }

                if (selectedVal == 1) {
                    //در صورتیکه بخش ها انتخاب شوند
                    $.ajax({
                        method: 'get',
                        url: '{{ url('/getListGroup') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#groupPart').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].id + `</td>
                                    <td>` + arrayed_result[i].title + `</td>
                                    <td>
                                    <input class="form-check-input" name="groupListIds[]" type="checkbox" value="` +
                                    arrayed_result[i].id + `_` + arrayed_result[i].title + `" id="kalaId">
                                    </td>
                                </tr>
                                `);
                            }
                        },
                        error: function(data) {
                            console.log("not good");
                        }

                    });

                }

                if (selectedVal == 6) {
                    $.ajax({
                        method: 'get',
                        url: '{{ url('/getListKala') }}',
                        async: true,
                        success: function(arrayed_result) {
                            for (var i = 0; i <= arrayed_result.length - 1; i++) {

                                $('#onePicKala').append(`
                <tr>
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>` + arrayed_result[i].price + `</td>
                    <td>
                    <input class="form-check-input" name="onePicKalaListIds[]" type="checkbox" value="` +
                                    arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                    .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                }
                },
                error: function(data) {
                    console.log("not good");
                }
            });
        }


            });
            //used for displaying kalas of first pic تخصیص به عکس
            $(document).on('click', '#firstPicOfTwoPic', (function() {
                $('#secondListOfTwoPic').fadeOut()
                $('#firstListOfTwoPic').fadeIn();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#twoPicKalaPart1').append(`
                <tr onclick="checkCheckBox(this,event)" >
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="twoPicAllKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                 }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup2Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));
            //used for displaying kalas of second pic تخصیص به عکس(2pic)
            $(document).on('click', '#secondPicOfTwoPic', (function() {
                $('#secondListOfTwoPic').fadeIn()
                $('#firstListOfTwoPic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#twoPicKalaPart2').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="twoPicAllKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup2Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);
                 }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for adding first pic data to the left side (2pic)
            $(document).on('click', '#addDataTwoPic1', (function() {
                var kalaListID = [];
                $('input[name="twoPicAllKalaListIds1[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="twoPicAllKalaListIds1[]"]:checked').parents('tr').css('color','red');
                $('input[name="twoPicAllKalaListIds1[]"]:checked').prop("disabled", true);
                 $('input[name="twoPicAllKalaListIds1[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#towPicAddedKalaPart1').append(`<tr class="addedTr" onclick="checkCheckBox(this,event)">
                                                    <td>` + kalaListID[i].split('_')[0] + `</td>
                                                    <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                                    <td>
                                                    <input class="form-check-input" name="twoPicKalaListIds1[]" type="checkbox" value="` +
                        kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));

            //used for adding second pic data to the left side (2pic)
            $(document).on('click', '#addDataTwoPic2', (function() {

                var kalaListID = [];
                $('input[name="twoPicAllKalaListIds2[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="twoPicAllKalaListIds2[]"]:checked').parents('tr').css('color','red');
                $('input[name="twoPicAllKalaListIds2[]"]:checked').prop("disabled", true);
                 $('input[name="twoPicAllKalaListIds2[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#towPicAddedKalaPart2').append(`<tr class="addedTr" onclick="checkCheckBox(this,event)">
                                                    <td>` + kalaListID[i].split('_')[0] + `</td>
                                                    <td>` + kalaListID[i].split('_')[1] +
                                                    `</td>
                                                    <td>
                                                    <input class="form-check-input" name="twoPicKalaListIds2[]" type="checkbox" value="` +
                        kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));

            //used for displaying kalas of first pic تخصیص به عکس(3pic)
            $(document).on('click', '#threePicAddKala1', (function() {
                $('#firstListOf3Pic').fadeIn();
                $('#secondListOf3Pic').fadeOut();
                $('#thirdListOf3Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            $('#threePicKalaPart1').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="threePicAllKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup3Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of second pic تخصیص به عکس(3pic)
            $(document).on('click', '#threePicAddKala2', (function() {
                $('#firstListOf3Pic').fadeOut();
                $('#secondListOf3Pic').fadeIn();
                $('#thirdListOf3Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#threePicKalaPart2').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="threePicAllKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup3Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of third pic تخصیص به عکس(3pic)
            $(document).on('click', '#threePicAddKala3', (function() {
                $('#firstListOf3Pic').fadeOut();
                $('#secondListOf3Pic').fadeOut();
                $('#thirdListOf3Pic').fadeIn();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#threePicKalaPart3').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="threePicAllKalaListIds3[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup3Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of first pic تخصیص به عکس(4pic)
            $(document).on('click', '#fourPicAddKala1', (function() {
                $('#firstListOf4Pic').fadeIn();
                $('#secondListOf4Pic').fadeOut();
                $('#fourthListOf4Pic').fadeOut();
                $('#thirdListOf4Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fourPicKalaPart1').append(`
                                    <tr onclick="checkCheckBox(this,event)">
                                        <td>` + arrayed_result[i].GoodSn + `</td>
                                        <td>` + arrayed_result[i].GoodName + `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicAllKalaListIds1[]" type="checkbox" value="` +
                                                    arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                                    .GoodName + `" id="kalaId">
                                        </td>
                                    </tr>
                             `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup4Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));


            //used for displaying kalas of second pic تخصیص به عکس(4pic)
            $(document).on('click', '#fourPicAddKala2', (function() {
                $('#firstListOf4Pic').fadeOut();
                $('#secondListOf4Pic').fadeIn();
                $('#fourthListOf4Pic').fadeOut();
                $('#thirdListOf4Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fourPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds2[]" type="checkbox" value="` +
                                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                                .GoodName + `" id="kalaId">
                                    </td>
                                </tr>
                              `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup4Pic2').append(`
                                      <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of third pic تخصیص به عکس(4pic)
            $(document).on('click', '#fourPicAddKala3', (function() {
                $('#firstListOf4Pic').fadeOut();
                $('#secondListOf4Pic').fadeOut();
                $('#fourthListOf4Pic').fadeOut();
                $('#thirdListOf4Pic').fadeIn();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fourPicKalaPart3').append(`
                                    <tr onclick="checkCheckBox(this,event)">
                                        <td>` + arrayed_result[i].GoodSn + `</td>
                                        <td>` + arrayed_result[i].GoodName + `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicAllKalaListIds3[]" type="checkbox" value="` +
                                                    arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                                    .GoodName + `" id="kalaId">
                                        </td>
                                    </tr>
                                 `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup4Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of fourth pic تخصیص به عکس(4pic)
            $(document).on('click', '#fourPicAddKala4', (function() {
                $('#firstListOf4Pic').fadeOut();
                $('#secondListOf4Pic').fadeOut();
                $('#fourthListOf4Pic').fadeIn();
                $('#thirdListOf4Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fourPicKalaPart4').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fourPicAllKalaListIds4[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup4Pic4').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of first pic تخصیص به عکس(5pic)
            $(document).on('click', '#fivePicAddKala1', (function() {
                $('#firstListOf5Pic').fadeIn();
                $('#secondListOf5Pic').fadeOut();
                $('#fourthListOf5Pic').fadeOut();
                $('#thirdListOf5Pic').fadeOut();
                $('#fifthListOf5Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fivePicKalaPart1').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAllKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup5Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of second pic تخصیص به عکس(5pic)
            $(document).on('click', '#fivePicAddKala2', (function() {
                $('#firstListOf5Pic').fadeOut();
                $('#secondListOf5Pic').fadeIn();
                $('#fourthListOf5Pic').fadeOut();
                $('#thirdListOf5Pic').fadeOut();
                $('#fifthListOf5Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fivePicKalaPart2').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAllKalaListIds2[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup5Pic2').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of third pic تخصیص به عکس(5pic)
            $(document).on('click', '#fivePicAddKala3', (function() {
                $('#firstListOf5Pic').fadeOut();
                $('#secondListOf5Pic').fadeOut();
                $('#fourthListOf5Pic').fadeOut();
                $('#thirdListOf5Pic').fadeIn();
                $('#fifthListOf5Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fivePicKalaPart3').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAllKalaListIds3[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup5Pic3').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of fourth pic تخصیص به عکس(5pic)
            $(document).on('click', '#fivePicAddKala4', (function() {
                $('#firstListOf5Pic').fadeOut();
                $('#secondListOf5Pic').fadeOut();
                $('#fourthListOf5Pic').fadeIn();
                $('#thirdListOf5Pic').fadeOut();
                $('#fifthListOf5Pic').fadeOut();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fivePicKalaPart4').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="fivePicAllKalaListIds4[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup5Pic4').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));

            //used for displaying kalas of fifth pic تخصیص به عکس(5pic)
            $(document).on('click', '#fivePicAddKala5', (function() {
                $('#firstListOf5Pic').fadeOut();
                $('#secondListOf5Pic').fadeOut();
                $('#fourthListOf5Pic').fadeOut();
                $('#thirdListOf5Pic').fadeOut();
                $('#fifthListOf5Pic').fadeIn();

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#fivePicKalaPart5').append(`
                                    <tr onclick="checkCheckBox(this,event)">
                                        <td>` + arrayed_result[i].GoodSn + `</td>
                                        <td>` + arrayed_result[i].GoodName + `</td>
                                        <td>
                                        <input class="form-check-input" name="fivePicAllKalaListIds5[]" type="checkbox" value="` +
                                                    arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                                    .GoodName + `" id="kalaId">
                                        </td>
                                    </tr>
                                    `);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));
            //used for displaying kalas of one pic تخصیص به عکس(1pic)
            $(document).on('click', '#firstPicOfOnePic', (function() {
                $('#firstListOfOnePic').fadeIn();
                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListKala') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#onePicKalaPart1').append(`
                <tr onclick="checkCheckBox(this,event)">
                    <td>` + arrayed_result[i].GoodSn + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="onePicKalaListIds1[]" type="checkbox" value="` +
                                arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });

                $.ajax({
                    method: 'get',
                    url: '{{ url('/getListGroup') }}',
                    async: true,
                    success: function(arrayed_result) {
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {

                            $('#searchMainGroup1Pic1').append(`
                <option value=` + arrayed_result[i].id + `>` + arrayed_result[i].title + `</option>
                `);

                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }

                });
            }));


            //used for adding data to the left side(kalaList)
            $(document).on('click', '#addDataKalaList', (function() {
                var kalaListID = [];
                $('input[name="kalaListIds[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="kalaListIds[]"]:checked').parents('tr').css('color','red');
                $('input[name="kalaListIds[]"]:checked').prop("disabled", true);
                 $('input[name="kalaListIds[]"]:checked').prop("checked", false);
                 
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#addedKalaPartAdd').prepend(`<tr class="addedTr" onclick="checkCheckBox(this,event)" draggable="true" ondragstart="start()"  ondragover="dragover()">
                                                    <td>` + kalaListID[i].split('_')[0] + `</td>
                                                    <td>` + kalaListID[i].split('_')[1] +
                                                    `</td>
                                                    <td>
                                                    <input class="form-check-input" name="addedKala[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));



            //used for removing data from left side(kalaList)
            $(document).on('click', '#removeDataKalaList', (function() {
                $('.addedTr').find('input:checkbox:checked').attr("name", "removable[]");
                $('.addedTr').has('input:checkbox:checked').hide();
            }));

            //used for adding data to the left side(شگفت انگیز)
                $(document).on('click', '#addDataToShegeftAngiz', (function() {
                var kalaListID = [];
                $('input[name="shegeftAngizIds[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="shegeftAngizIds[]"]:checked').parents('tr').css('color','red');
                $('input[name="shegeftAngizIds[]"]:checked').prop("disabled", true);
                $('input[name="shegeftAngizIds[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#addedShegeftAdd').prepend(`<tr class="addedTr" onclick="checkCheckBox(this,event)">
                                                    <td>` + kalaListID[i].split('_')[0] + `</td>
                                                    <td>` + kalaListID[i].split('_')[1] +`</td>
                                                    <td>
                                                    <input class="form-check-input" name="addedKala[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));


            //used for removing data from left side(شگفت انگیز)
            $(document).on('click', '#removeDataFromShegeftAngiz', (function() {
                $('.addedTr').find('input:checkbox:checked').attr("name", "removable[]");
                $('.addedTr').has('input:checkbox:checked').hide();
            }));

            //used for adding group to the left side(groupList)
            $(document).on('click', '#addDataGroupList', (function() {
                var groupListID = [];
                $('input[name="groupListIds[]"]:checked').map(function() {
                    groupListID.push($(this).val());
                });
                $('input[name="groupListIds[]"]:checked').parents('tr').css('color','red');
                $('input[name="groupListIds[]"]:checked').prop("disabled", true);
                $('input[name="groupListIds[]"]:checked').prop("checked", false);
                for (let i = 0; i < groupListID.length; i++) {
                    $('#addedGroupPartAdd').prepend(`<tr class="addedTr" onclick="checkCheckBox(this,event)">
                                                    <td>` + groupListID[i].split('_')[0] + `</td>
                                                    <td>` + groupListID[i].split('_')[1] +
                                                    `</td>
                                                    <td>
                                                    <input class="form-check-input" name="addedGroup[]" type="checkbox" value="` + groupListID[i].split('_')[0] + '_'+groupListID[i].split('_')[1]+`" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));
            //used for removing data from (GroupList)
            $(document).on('click', '#removeDataGroupList', (function() {
                $('.addedTr').find('input:checkbox:checked').attr("name", "removable[]");
                $('.addedTr').has('input:checkbox:checked').hide();
            }));
            //used for adding kala to onePic left side (1pic)

            $(document).on('click', '#addDataOnePic1', (function() {

                var kalaListID = [];
                $('input[name="onePicKalaListIds1[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="onePicKalaListIds1[]"]:checked').parents('tr').css('color','red');
                $('input[name="onePicKalaListIds1[]"]:checked').prop("disabled", true);
                $('input[name="onePicKalaListIds1[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#onePicAddedKalaPart1').prepend(`<tr class="addedTr">
                                                    <td>` + kalaListID[i].split('_')[0] + `</td>
                                                    <td>` + kalaListID[i].split('_')[1] +
                                                    `</td>
                                                    <td>
                                                    <input class="form-check-input" name="onePicKalaListIds2[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                                    </td>
                                                </tr>`);

                }
            }));
            
            //used for removing data from (pic1)
            $(document).on('click', '#removeDataOnePic1', (function() {
                $('.addedTr').find('input:checkbox:checked').attr("name", "removable[]");
                $('.addedTr').has('input:checkbox:checked').hide();
            }));
            //برای افزودن کالا به تصویر 1 سمت چپ(3 تصویر)

            $(document).on('click', '#addData3Pic1', (function() {

                var kalaListID = [];
                $('input[name="threePicAllKalaListIds1[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="threePicAllKalaListIds1[]"]:checked').parents('tr').css('color','red');
                $('input[name="threePicAllKalaListIds1[]"]:checked').prop("disabled", true);
                $('input[name="threePicAllKalaListIds1[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#threePicAddedKalaPart1').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="threePicKalaListIds1[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر 2 سمت چپ(3 تصویر)

            $(document).on('click', '#addData3Pic2', (function() {

                var kalaListID = [];
                $('input[name="threePicAllKalaListIds2[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="threePicAllKalaListIds2[]"]:checked').parents('tr').css('color','red');
                $('input[name="threePicAllKalaListIds2[]"]:checked').prop("disabled", true);
                $('input[name="threePicAllKalaListIds2[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#threePicAddedKalaPart2').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="threePicKalaListIds2[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر 3 سمت چپ(3 تصویر)

            $(document).on('click', '#addData3Pic3', (function() {

                var kalaListID = [];
                $('input[name="threePicAllKalaListIds3[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="threePicAllKalaListIds3[]"]:checked').parents('tr').css('color','red');
                $('input[name="threePicAllKalaListIds3[]"]:checked').prop("disabled", true);
                $('input[name="threePicAllKalaListIds3[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#threePicAddedKalaPart3').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="threePicKalaListIds3[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر 1 سمت چپ(4 تصویر)

            $(document).on('click', '#addData4Pic1', (function() {

                var kalaListID = [];
                $('input[name="fourPicAllKalaListIds1[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fourPicAllKalaListIds1[]"]:checked').parents('tr').css('color','red');
                $('input[name="fourPicAllKalaListIds1[]"]:checked').prop("disabled", true);
                $('input[name="fourPicAllKalaListIds1[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fourPicAddedKalaPart1').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicKalaListIds1[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر2 سمت چپ(4 تصویر)

            $(document).on('click', '#addData4Pic2', (function() {

                var kalaListID = [];
                $('input[name="fourPicAllKalaListIds2[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fourPicAllKalaListIds2[]"]:checked').parents('tr').css('color','red');
                $('input[name="fourPicAllKalaListIds2[]"]:checked').prop("disabled", true);
                $('input[name="fourPicAllKalaListIds2[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fourPicAddedKalaPart2').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicKalaListIds2[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر3 سمت چپ(4 تصویر)

            $(document).on('click', '#addData4Pic3', (function() {

                var kalaListID = [];
                $('input[name="fourPicAllKalaListIds3[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fourPicAllKalaListIds3[]"]:checked').parents('tr').css('color','red');
                $('input[name="fourPicAllKalaListIds3[]"]:checked').prop("disabled", true);
                $('input[name="fourPicAllKalaListIds3[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fourPicAddedKalaPart3').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicKalaListIds3[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر4 سمت چپ(4 تصویر)

            $(document).on('click', '#addData4Pic4', (function() {

                var kalaListID = [];
                $('input[name="fourPicAllKalaListIds4[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fourPicAllKalaListIds4[]"]:checked').parents('tr').css('color','red');
                $('input[name="fourPicAllKalaListIds4[]"]:checked').prop("disabled", true);
                $('input[name="fourPicAllKalaListIds4[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fourPicAddedKalaPart4').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fourPicKalaListIds4[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر1 سمت چپ(5 تصویر)

            $(document).on('click', '#addData5Pic1', (function() {

                var kalaListID = [];
                $('input[name="fivePicAllKalaListIds1[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fivePicAllKalaListIds1[]"]:checked').parents('tr').css('color','red');
                $('input[name="fivePicAllKalaListIds1[]"]:checked').prop("disabled", true);
                $('input[name="fivePicAllKalaListIds1[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fivePicAddedKalaPart1').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fivePicKalaListIds1[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر2 سمت چپ(5 تصویر)

            $(document).on('click', '#addData5Pic2', (function() {

                var kalaListID = [];
                $('input[name="fivePicAllKalaListIds2[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fivePicAllKalaListIds2[]"]:checked').parents('tr').css('color','red');
                $('input[name="fivePicAllKalaListIds2[]"]:checked').prop("disabled", true);
                $('input[name="fivePicAllKalaListIds2[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fivePicAddedKalaPart2').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fivePicKalaListIds2[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر3 سمت چپ(5 تصویر)

            $(document).on('click', '#addData5Pic3', (function() {

                var kalaListID = [];
                $('input[name="fivePicAllKalaListIds3[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fivePicAllKalaListIds3[]"]:checked').parents('tr').css('color','red');
                $('input[name="fivePicAllKalaListIds3[]"]:checked').prop("disabled", true);
                $('input[name="fivePicAllKalaListIds3[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fivePicAddedKalaPart3').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fivePicKalaListIds3[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));


            //برای افزودن  کالا به تصویر4 سمت چپ(5 تصویر)

            $(document).on('click', '#addData5Pic4', (function() {

                var kalaListID = [];
                $('input[name="fivePicAllKalaListIds4[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fivePicAllKalaListIds4[]"]:checked').parents('tr').css('color','red');
                $('input[name="fivePicAllKalaListIds4[]"]:checked').prop("disabled", true);
                $('input[name="fivePicAllKalaListIds4[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fivePicAddedKalaPart4').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] +
                        `</td>
                                        <td>
                                        <input class="form-check-input" name="fivePicKalaListIds4[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

            //برای افزودن  کالا به تصویر5 سمت چپ(5 تصویر)

            $(document).on('click', '#addData5Pic5', (function() {

                var kalaListID = [];
                $('input[name="fivePicAllKalaListIds5[]"]:checked').map(function() {
                    kalaListID.push($(this).val());
                });
                $('input[name="fivePicAllKalaListIds5[]"]:checked').parents('tr').css('color','red');
                $('input[name="fivePicAllKalaListIds5[]"]:checked').prop("disabled", true);
                $('input[name="fivePicAllKalaListIds5[]"]:checked').prop("checked", false);
                for (let i = 0; i < kalaListID.length; i++) {
                    $('#fivePicAddedKalaPart5').prepend(`<tr class="addedTr">
                                        <td>` + kalaListID[i].split('_')[0] + `</td>
                                        <td>` + kalaListID[i].split('_')[1] + `</td>
                                        <td>
                                            <input class="form-check-input" name="fivePicKalaListIds5[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `" id="kalaIds" checked>
                                        </td>
                                    </tr>`);

                }
            }));

//جستجوی کالا برای تصویر 1 تک تصویره
        $(document).on('change', '#searchMainGroup1Pic1', (function() {
            document.getElementById('searchKala1Pic1').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#onePicKalaPart1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#onePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup1Pic1').empty();
                        $('#searchSubGroup1Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup1Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup1Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 1 تک تصویره
        $(document).on('change', '#searchSubGroup1Pic1', (function() {
            document.getElementById('searchKala1Pic1').value = '';
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#onePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#onePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        $(document).on('keyup', '#searchKala1Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala1Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#onePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#onePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="onePicKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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


//جستجوی کالا برای تصویر 2 1 تصویره
$(document).on('change', '#searchMainGroup2Pic1', (function() {
            document.getElementById('searchKala2Pic1').value = '';
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
                        $('#twoPicKalaPart1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#twoPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup2Pic1').empty();
                        $('#searchSubGroup2Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup1Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup2Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 2 1 تصویره
        $(document).on('change', '#searchSubGroup2Pic1', (function() {
            document.getElementById('searchKala2Pic1').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 2 1 تصویره
        $(document).on('keyup', '#searchKala2Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala2Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#twoPicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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

            //جستجوی کالا برای تصویر 2 2 تصویره
$(document).on('change', '#searchMainGroup2Pic2', (function() {
            document.getElementById('searchKala2Pic2').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicKalaPart2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#twoPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup2Pic2').empty();
                        $('#searchSubGroup2Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup2Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup2Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 2 2 تصویره
        $(document).on('change', '#searchSubGroup2Pic2', (function() {
            document.getElementById('searchKala2Pic2').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#twoPicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 2 2 تصویره
        $(document).on('keyup', '#searchKala2Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala2Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#twoPicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#twoPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="twoPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            $(document).on('change', '#searchMainGroup4Pic1', (function() {

            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup4Pic1').empty();
                        $('#searchSubGroup4Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup4Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup4Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 1 تصویره
        $(document).on('change', '#searchSubGroup4Pic1', (function() {
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 1 تصویره
        $(document).on('keyup', '#searchKala4Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala4Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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

            //جستجوی کالا برای تصویر 4 2 تصویره
            $(document).on('change', '#searchMainGroup4Pic2', (function() {
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
                        $('#fourPicKalaPart2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup4Pic2').empty();
                        $('#searchSubGroup4Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup4Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup4Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 2 تصویره
        $(document).on('change', '#searchSubGroup4Pic2', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 2 تصویره
        $(document).on('keyup', '#searchKala4Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala4Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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

            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup4Pic3').empty();
                        $('#searchSubGroup4Pic3').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup4Pic3').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup4Pic3').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 3 تصویره
        $(document).on('change', '#searchSubGroup4Pic3', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 4 3 تصویره
        $(document).on('keyup', '#searchKala4Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala4Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fourPicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
                        $('#fourPicKalaPart4').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fourPicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup4Pic4').empty();
                        $('#searchSubGroup4Pic4').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup4Pic4').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup4Pic4').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 4 4 تصویره
        $(document).on('change', '#searchSubGroup4Pic4', (function() {

            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fourPicKalaPart4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
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
                        
                        $('#fourPicKalaPart4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fourPicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fourPicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            document.getElementById('searchKala3Pic1').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup3Pic1').empty();
                        $('#searchSubGroup3Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup3Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup3Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 1 تصویره
        $(document).on('change', '#searchSubGroup3Pic1', (function() {
            document.getElementById('searchKala3Pic1').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 3 1 تصویره
        $(document).on('keyup', '#searchKala3Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala3Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            $(document).on('change', '#searchMainGroup3Pic2', (function() {
                document.getElementById('searchKala3Pic2').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup3Pic2').empty();
                        $('#searchSubGroup3Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup3Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup3Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 2 تصویره
        $(document).on('change', '#searchSubGroup3Pic2', (function() {
            document.getElementById('searchKala3Pic2').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
        //برای جستجو بر اساس ورودی تصویر 3 2 تصویره
        $(document).on('keyup', '#searchKala3Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala3Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            $(document).on('change', '#searchMainGroup3Pic3', (function() {
            document.getElementById('searchKala3Pic3').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearch') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#threePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
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
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 3 3 تصویره
        $(document).on('change', '#searchSubGroup3Pic3', (function() {
            document.getElementById('searchKala3Pic3').value = '';
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#threePicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
        //برای جستجو بر اساس ورودی تصویر 3 3 تصویره
        $(document).on('keyup', '#searchKala3Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala3Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#threePicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#threePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="threePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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

            // FIVE PICS SEARCHING FOR

            //جستجوی کالا برای تصویر 5 1 تصویره
            $(document).on('change', '#searchMainGroup5Pic1', (function() {
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
                        $('#fivePicKalaPart1').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup5Pic1').empty();
                        $('#searchSubGroup5Pic1').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup5Pic1').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup5Pic1').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 1 تصویره
        $(document).on('change', '#searchSubGroup5Pic1', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 1 تصویره
        $(document).on('keyup', '#searchKala5Pic1', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala5Pic1').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicKalaPart1').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart1').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds1[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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

            //جستجوی کالا برای تصویر 5 2 تصویره
            $(document).on('change', '#searchMainGroup5Pic2', (function() {
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
                        $('#fivePicKalaPart2').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup5Pic2').empty();
                        $('#searchSubGroup5Pic2').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup5Pic2').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup5Pic2').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 2 تصویره
        $(document).on('change', '#searchSubGroup5Pic2', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 2 تصویره
        $(document).on('keyup', '#searchKala5Pic2', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala5Pic2').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicKalaPart2').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart2').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds2[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            $(document).on('change', '#searchMainGroup5Pic3', (function() {
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
                        $('#fivePicKalaPart3').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup5Pic3').empty();
                        $('#searchSubGroup5Pic3').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup5Pic3').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup5Pic3').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 3 تصویره
        $(document).on('change', '#searchSubGroup5Pic3', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 3 تصویره
        $(document).on('keyup', '#searchKala5Pic3', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala5Pic3').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicKalaPart3').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart3').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds3[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
        $(document).on('change', '#searchMainGroup5Pic4', (function() {
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
                        $('#fivePicKalaPart4').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup5Pic4').empty();
                        $('#searchSubGroup5Pic4').append(`<option value="0">همه گروه ها </option>`);
                        }
                        $('#searchSubGroup5Pic4').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup5Pic4').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 4 تصویره
        $(document).on('change', '#searchSubGroup5Pic4', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicKalaPart4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 4 تصویره
        $(document).on('keyup', '#searchKala5Pic4', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala5Pic4').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicKalaPart4').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart4').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds4[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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
            $(document).on('change', '#searchMainGroup5Pic5', (function() {
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
                        $('#fivePicKalaPart5').empty();
                        if(arrayed_result.flag.length<2){
                            for (let i = 0; i < arrayed_result.kalas.length; i++) {
                            $('#fivePicKalaPart5').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result.kalas[i].GoodSn + `</td>
                                    <td>` + arrayed_result.kalas[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds5[]" type="checkbox" value="` +arrayed_result.kalas[i].GoodSn + `_` + arrayed_result.kalas[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                        $('#searchSubGroup5Pic5').empty();
                        $('#searchSubGroup5Pic5').append(`<option value="0">همه گروه ها </option>`);
                        }

                        $('#searchSubGroup5Pic5').empty();
                            for (let i = 0; i < arrayed_result.subGroups.length; i++) {
                            $('#searchSubGroup5Pic5').append(` <option value=` + arrayed_result.subGroups[i].id + `>` + arrayed_result.subGroups[i].title + `</option>`);
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));

        //جستجوی کالا بر اساس گروه های فرعی برای تصویر 5 5 تصویره
        $(document).on('change', '#searchSubGroup5Pic5', (function() {
            alert($(this).val());
            $.ajax({
                    method: 'get',
                    url: '{{ url('/getKalasSearchSubGroup') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId:$(this).val()
                    },
                    async: true,
                    success: function(arrayed_result) {
                        $('#fivePicKalaPart5').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart5').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds5[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
                                    </td>
                                </tr>`
                            );
                        }
                    },
                    error: function(data) {
                        console.log("not good");
                    }
                });
        }));
//برای جستجو بر اساس ورودی تصویر 5 5 تصویره
        $(document).on('keyup', '#searchKala5Pic5', (function() {
                    $.ajax({
                    method: 'get',
                    url: "{{ url('/searchKalas') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchKala5Pic5').val()
                    },
                    success: function(arrayed_result) {
                        
                        $('#fivePicKalaPart5').empty();
                            for (let i = 0; i < arrayed_result.length; i++) {
                            $('#fivePicKalaPart5').append(`
                                <tr onclick="checkCheckBox(this,event)">
                                    <td>` + arrayed_result[i].GoodSn + `</td>
                                    <td>` + arrayed_result[i].GoodName + `</td>
                                    <td>
                                    <input class="form-check-input" name="fivePicAllKalaListIds5[]" type="checkbox" value="` +arrayed_result[i].GoodSn + `_` + arrayed_result[i].GoodName + `" id="kalaId">
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



//-------------------------used for changing color after changing value of an image picker--------------------------------------
        $(document).on('change', '#firstPicAllocation', (function() {

            $('#firstPicAllocation1_2').css('background-color','#3c5772a6');
            
        }));

        $(document).on('click', '#firstPicOfTwoPic', (function() {

            $('#firstPicOfTwoPic').css('background-color','#3c5772a6');
            
        }));

            $(document).on('change', '#secondPicAllocation', (function() {

            $('#secondPicAllocation2_2').css('background-color','#3c5772a6');
            
        }));

             $(document).on('click', '#secondPicOfTwoPic', (function() {
                
             $('#secondPicOfTwoPic').css('background-color','#3c5772a6');
            
        }));

// ----------------------------------------three pic--------------------------------------------------------------------

        $(document).on('change', '#threePicAllocation1', (function() {

             $('#threePicLabel1').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#threePicAddKala1', (function() {

            $('#threePicAddKala1').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#threePicAllocation2', (function() {

             $('#threePicLabel2').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#threePicAddKala2', (function() {

            $('#threePicAddKala2').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#threePicAllocation3', (function() {

             $('#threePicLabel3').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#threePicAddKala3', (function() {

            $('#threePicAddKala3').css('background-color','#3c5772a6');

        }));

// ----------------------------------------------four pic-----------------------------------------------------------------

$(document).on('change', '#fourPicAllocation1', (function() {

             $('#fourPicLabel1').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fourPicAddKala1', (function() {

            $('#fourPicAddKala1').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------

$(document).on('change', '#fourPicAllocation2', (function() {

             $('#fourPicLabel2').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fourPicAddKala2', (function() {

            $('#fourPicAddKala2').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#fourPicAllocation3', (function() {

             $('#fourPicLabel3').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fourPicAddKala3', (function() {

            $('#fourPicAddKala3').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
$(document).on('change', '#fourPicAllocation4', (function() {

             $('#fourPicLabel4').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fourPicAddKala4', (function() {

            $('#fourPicAddKala4').css('background-color','#3c5772a6');

        }));
//----------------------------------------------------------five pic-----------------------------------------------------
$(document).on('change', '#fivePicAllocation1', (function() {

             $('#fivePicLabel1').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fivePicAddKala1', (function() {

            $('#fivePicAddKala1').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------

$(document).on('change', '#fivePicAllocation2', (function() {

             $('#fivePicLabel2').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fivePicAddKala2', (function() {

            $('#fivePicAddKala2').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#fivePicAllocation3', (function() {

             $('#fivePicLabel3').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fivePicAddKala3', (function() {

            $('#fivePicAddKala3').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#fivePicAllocation4', (function() {

             $('#fivePicLabel4').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fivePicAddKala4', (function() {

            $('#fivePicAddKala4').css('background-color','#3c5772a6');

        }));
// -----------------------------------------------------------------------------------------
        $(document).on('change', '#fivePicAllocation5', (function() {

             $('#fivePicLabel5').css('background-color','#3c5772a6');

        }));

        $(document).on('click', '#fivePicAddKala5', (function() {

            $('#fivePicAddKala5').css('background-color','#3c5772a6');

        }));
        // $('.).attr("class", ");
    }

</script>
@endsection