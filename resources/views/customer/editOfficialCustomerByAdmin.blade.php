@extends('admin.layout')
@section('content')

<style>
   ::placeholder {
        color: rgb(235, 218, 218) !important;
        opacity: 1;
        }
:-ms-input-placeholder {
    color: rgb(235, 218, 218) !important;
    }
::-ms-input-placeholder {
    color: rgb(235, 218, 218) !important;
    }
    .required .form-label:after {
        content:"*";
        color:red;
        padding-right: 0px;
        }
     input.haqiqi{
        background-color: #eeeeee !important;
        opacity: 1;
    }
</style>

<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> پروفایل </legend>
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
                    <div class="c-checkout container tab-design" id="haqiqi">
                        <div class="col-sm-6 p-2">
                            <ul class="header-list nav nav-tabs" data-tabs="tabs">
                                <li><a class="active" data-toggle="tab" style="color:black;"  href="#custAddress"> اشخاص حقیقی </a></li>
                                <li><a data-toggle="tab" style="color:black;"  href="#moRagiInfo"> اشخاص حقوقی </a></li>
                            </ul>
                        </div>

                         <div class="c-checkout tab-content">
                            <div class="row c-checkout rounded-3 tab-pane active" id="custAddress">
                                <div class="col-sm-12">
                                    <div class="row" style="width:98%; padding:0 1% 2% 0%; height: calc(100vh - 200px);">
                                        <form action="{{url('/storeHaqiqiCustomerAdmin') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="haqiqi" name="customerType" value="haqiqi">
                                            <input type="hidden" name="id" value="{{$id}}">
                                            <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="name" class="form-label">نام:</label>
                                                    <input onKeyPress="if(this.value.length==10) return false;" type="text" class="form-control haqiqi" value="@if($exacHaqiqi){{trim($exacHaqiqi->customerName)}}@endif"  id="name" placeholder="نام  " name="customerName">
                                                </div>
                                            </div>
                                            {{-- <input type="text" name="customerShopSn" value="{{Session::get('psn')}}@endif"> --}}
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="familyName" class="form-label"> نام خانوادگی  :</label>
                                                    <input type="text"  onKeyPress="if(this.value.length==10) return false;" class="form-control haqiqi" id="familyName" value="@if($exacHaqiqi){{trim($exacHaqiqi->familyName)}}@endif" placeholder=" نام خانوادگی  " name="familyName">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="shenasahmilli" class="form-label" data-toggle="tooltip" data-placement="bottom" title="معلومات !"> شماره ملی   :</label>
                                                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="codeMilli"  value="@if($exacHaqiqi){{trim($exacHaqiqi->codeMilli)}}@endif" placeholder=" شماره ملی " name="codeMilli">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="roleNo" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !"> کد نقش :</label>
                                                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="roleNo" value="@if($exacHaqiqi){{trim($exacHaqiqi->codeNaqsh)}}@endif" placeholder="کد نقش"  name="codeNaqsh">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="postalCode"  class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !">کد پستی :</label>
                                                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="postalCode" placeholder="کد پستی" value="@if($exacHaqiqi){{trim($exacHaqiqi->codePosti)}}@endif"  name="codePosti">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-1 mt-2">
                                                    <label for="address" class="form-label"> آدرس :</label>
                                                    <input onKeyPress="if(this.value.length==26) return false;" type="text" class="form-control haqiqi" id="address" value="@if($exacHaqiqi){{trim($exacHaqiqi->address)}}@endif" placeholder="آدرس " name="address">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="mb-1 mt-2">
                                                <input type="submit" class="btn btn-success btn-sm" value="ذخیره ">
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row c-checkout rounded-2 tab-pane" id="moRagiInfo">
                                <div class="row" style="height: calc(100vh - 200px);">
                                    <form action="{{url('/storeHoqoqiCustomerAdmin') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="hoqoqi" name="customerType" value="hoqoqi">
                                        <input type="hidden" name="id" value="{{$id}}">
                                        <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="companyName" class="form-label">نام شرکت :</label>
                                                <input onKeyPress="if(this.value.length==10) return false;" type="text" class="form-control haqiqi" value="@if($exactHoqoqi){{trim($exactHoqoqi->companyName)}}@endif"  id="name" placeholder="نام  " name="companyName">
                                            </div>
                                        </div>
                                        {{-- <input type="text" name="customerShopSn" value="{{Session::get('psn')}}"> --}}
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="registerNo" class="form-label"> شماره ثبت :</label>
                                                <input type="number"  onKeyPress="if(this.value.length==11) return false;" class="form-control haqiqi" id="registerNo" value="@if($exactHoqoqi){{trim($exactHoqoqi->registerNo)}}@endif" placeholder=" نام خانوادگی  " name="registerNo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="shenasahmilli" class="form-label" data-toggle="tooltip" data-placement="bottom" title="معلومات !"> شناسه ملی  :</label>
                                                <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="shenasahMilli"  value="@if($exactHoqoqi){{trim($exactHoqoqi->shenasahMilli)}}@endif" placeholder=" شناسه ملی " name="shenasahMilli">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="codeEqisadi" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !"> کد اقتصادی :</label>
                                                <input  onKeyPress="if(this.value.length==10) return false;" type="number" min=0 class="form-control haqiqi" id="economicCode" value="@if($exactHoqoqi){{trim($exactHoqoqi->codeEqtisadi)}}@endif" placeholder="کد اقتصادی" name="codeEqtisadi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="roleNo" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !"> کد نقش :</label>
                                                <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="roleNo" value="@if($exactHoqoqi){{trim($exactHoqoqi->codeNaqsh)}}@endif" placeholder="کد نقش"  name="codeNaqsh">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="address" class="form-label"> آدرس :</label>
                                                <input onKeyPress="if(this.value.length==26) return false;" type="text" class="form-control haqiqi" id="address" value="@if($exactHoqoqi){{trim($exactHoqoqi->address)}}@endif" placeholder="آدرس " name="address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="postalCode"  class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !">کد پستی :</label>
                                                <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="postalCode" placeholder="کد پستی" value="@if($exactHoqoqi){{trim($exactHoqoqi->codePosti)}}@endif"  name="codePosti">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2 required">
                                                <label for="email" class="form-label">ایمیل آدرس :</label>
                                                <input  onKeyPress="if(this.value.length==22) return false;" type="email" class="form-control haqiqi" id="email" placeholder="ایمیل آدرس" value="@if($exactHoqoqi){{$exactHoqoqi->email}}@endif" name="email">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="phoneNo" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !">شماره همراه :</label>
                                                <input  onKeyPress="if(this.value.length==14) return false;" type="number"  min=0 class="form-control haqiqi" id="phoneNo" value="@if($exactHoqoqi){{trim($exactHoqoqi->phoneNo)}}@endif" placeholder="شماره تلفن"  name="phoneNo">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-1 mt-2">
                                                <label for="sabetPhoneNo" class="form-label">شماره ثابت:</label>
                                                <input onKeyPress="if(this.value.length==14) return false;" type="text" class="form-control haqiqi" id="sabetPhoneNo" value="@if($exactHoqoqi){{trim($exactHoqoqi->sabetPhoneNo)}}@endif" placeholder="شماره ثابت" name="sabetPhoneNo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 mt-2">
                                            <input type="submit" class="btn btn-success btn-sm" value="ذخیره ">
                                        </div>
                                    </div>
                                    </form>

                            </div>
                        </div>
                  </div>
               </div>
               <div class="row contentFooter"> </div>
            </div>
         </div>
     </div>
@endsection