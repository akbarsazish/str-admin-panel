@extends('admin.layout')
@section('content')

<style>
    #customerEdit, #allKalaFirst1, #takhfifBag{
        display:none;
    }
</style>

<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0" style="font-size:12px;"> </legend>
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
                <!-- <div class="row contentHeader"> 
                     <div class="col-sm-6 mt-2">
                           <p>  ویرایش ({{$customer->Name}})  </p>
                      </div>
                     <div class="col-sm-6 text-end mt-2">
                            <button class="btn btn-success btn-sm text-warning"    style=" float:left; margin-left:2%;">ذخیره <i class="fa fa-save"></i> </button>
                      </div>
                </div> -->
                <div class="row mainContent">
                    <div class="col-lg-12 p-2">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">کد </span>
                                    <input type="text"   class="form-control form-control-sm"  name="" value="{{$customer->PCode}}" placeholder="red" size="20" id="allKalaFirst">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">نام و نام خانوادگی </span>
                                    <input type="text"   class="form-control form-control-sm"  name="" size="20"  value="{{trim($customer->Name)}}" id="allKalaFirst">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> تاریخ </span>
                                    <input type="text" class="form-control form-control-sm"     name=""  value="{{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($customer->TimeStamp))->format('Y/m/d')}}" placeholder="red" size="20" class="form-control" id="allKalaFirst">
                                
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> مانده حساب  </span>
                                    <input type="text"   class="form-control form-control-sm"  name="" size="20" class="form-control" id="allKalaFirst">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"> گروه   </span>
                                    <input type="text"   class="form-control form-control-sm" name="" placeholder="" size="20" id="allKalaFirst">
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                        <div class="col-sm-8">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm"> آدرس  </span>
                                <input type="text"   class="form-control form-control-sm" name=""   value="{{trim($customer->peopeladdress)}}" size="20" class="form-control" id="allKalaFirst">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm"> مشتری   </span>
                                <input   class="form-control form-control-sm pr-0 mr-0" type="text"  name="" id="allKalaFirst">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">   تلفن  </span>
                                <input   class="form-control form-control-sm pr-0 mr-0" type="text" name="" id="allKalaFirst">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">  اسم 1  </span>
                                <input   class="form-control form-control-sm pr-0 mr-0"  type="text"  name="" id="allKalaFirst">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">   همراه 1  </span>
                                <input   class="form-control form-control-sm pr-0 mr-0" type="text" name="" id="allKalaFirst">
                            </div>
                        </div>
                        <div class="col-sm-2">
                                <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">  اسم 2   </span>
                                <input class="form-control form-control-sm pr-0 mr-0"    type="text"  name="" id="allKalaFirst">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">  همراه 2  </span>
                                <input   class="form-control form-control-sm pr-0 mr-0" type="text" name="" id="allKalaFirst">
                            </div>
                        </div>
                            <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm"> اسم 3  </span>
                                <input   class="form-control form-control-sm pr-0 mr-0" type="text"  name="" id="allKalaFirst">
                            </div>
                            </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-sm">   همراه 3   </span>
                                <input  class="form-control form-control-sm pr-0 mr-0" type="text" name="" id="allKalaFirst">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="c-checkout container" style="background-color:#81d3a4; border-radius:10px 10px 2px 2px; width:100%; hiegt">
                <div class="col-sm-12" style="margin: 0; padding:0;">
                    <ul class="header-list nav nav-tabs" data-tabs="tabs" style="margin: 0; padding:0;">
                        <li><a class="active" data-toggle="tab" style="color:black;" id="customerAddress"  href="#custAddress"> آدرس مشتری </a></li>
                        <li><a data-toggle="tab" style="color:black;" id="moyRagiInfo"  href="#moRagiInfo">  اطلاعات مویرگی </a></li>
                        <li><a data-toggle="tab" style="color:black;" id="customerInfo"  href="#userLoginInfo"> اطلاعات دسترسی </a></li>
                        <li><a data-toggle="tab" style="color:black;" id="manageDiscountBag" href="#takhfifCalc"> مدیریت کیف تخفیفی</a></li>
                        <li><a data-toggle="tab" style="color:black;" id="discountBagHistory" href="#takhfifCaseHistory"> تاریخچه کیف تخفیفی</a></li>
                    </ul>
                </div>

                <div class="c-checkout tab-content" style="background-color:#f5f5f5; margin:0; padding:0.2%; border-radius:10px 10px 2px 2px;">
                     <div class="row c-checkout rounded-3 tab-pane active" id="custAddress">
                        <div class="col-sm-12 tableBody" style=" height: calc(100vh - 400px);"> 
                            <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                <thead class="table bg-success text-warning">
                                <tr>
                                    <th>استان</th>
                                    <th>شهر</th>
                                    <th>آدرس </th>
                                    <th>کد پستی</th>
                                    <th>انتخاب </th>
                                </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($customers as $customer) --}}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input class="form-check-input" name="customerId" type="radio" value="" id="flexCheckChecked" checked>
                                    </td>
                                </tr>
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row c-checkout rounded-3 tab-pane" id="moRagiInfo">
                        <div class="col-lg-12 tableBody" style=" height: calc(100vh - 400px);">
                           <div class="row mt-2">
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> بازاریاب  </span>
                                        <input class="form-control form-control-sm"   type="text"  name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> کشور   </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"   type="text" name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> استان  </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"    type="text"  name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> شهر </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"   type="text" name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> منطقه </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"    type="text"  name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> تحویلدار </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"   type="text"  name="" id="allKalaFirst">
                                    </div>
                                </div>
                    
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> صنف  </span>
                                        <input class="form-control form-control-sm pr-0 mr-0"   type="text" name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> کد مویرگی  </span>
                                        <input class="form-control form-control-sm pr-0 mr-0" type="text"  name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> انتخاب مسیر  </span>
                                        <input class="form-control form-control-sm pr-0 mr-0" type="text" name="" id="allKalaFirst">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <button class="btn btn-success text-warning" type="button" name="" id="allKalaFirst">ثبت مکان</button>
                                    </div>
                                </div>
                         </div>
                            <div class="col-sm-12" style="display:none;">
                                <button class="btn btn-success btn-sm text-warning" style=" float:left; margin-top:-2%">ذخیره</button>
                            </div>
                    </div>
                    </div>
                    <div class="row c-checkout rounded-3 tab-pane" id="userLoginInfo" style="width:100%; margin:0 auto; padding:1% 0% 0% 0%">
                        <div class="row px-1">
                            <div class="col-lg-12 mx-0 tableBody" style=" height: calc(100vh - 400px);">
                               <div class="row">
                                    <div class="col-sm-2">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">نام کاربری  </span>
                                            <input type="text" class="form-control form-control-sm accessInfo"      value="{{trim($customer->userName)}}" name="userName" size="20" id="userName">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"> رمز عبور  </span>
                                            <input type="text" class="form-control form-control-sm accessInfo"  name=""    value="{{$customer->customerPss}}" size="20" id="EqtisadiCode">
                                        </div>
                                    </div>
                                    <input type="text" name="" value="{{$customer->PSN}}" id="CustomerSn" style="display: none;">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"> حد اقل مبلغ فاکتور (تومان)  </span>
                                            <input type="text" class="form-control form-control-sm accessInfo"    name=""  value="{{number_format($customer->minimumFactorPrice)}}" size="20" id="FactorMinPrice">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">اجازه چندین موبایل  </span>
                                            <input type="number" class="form-control form-control-sm accessInfo"   value="{{$customer->manyMobile}}" class="form-check-input" id="ManyMobile">
                                        </div>
                                    </div>
                            </div>

                            <div class="row mt-1">
                                    <div class="form-check col-sm-2">
                                        <span> <input type="checkbox" name=""   class="form-check-input float-start p-1 accessInfo" @if($customer->manyMobile>0) checked @else @endif id="ForceExit"></span>
                                        <label class="form-check-label ms-4" for="flexCheckDefault">
                                            فعالسازی 
                                        </label>
                                    </div>
                              
                                    <div class="form-check col-sm-2">
                                        <span><input type="checkbox" name=""     class="form-check-input float-start p-1 accessInfo"  @if($customer->exitButtonAllowance==1) checked @else @endif class="form-check-input" id="ExitButtonShow"></span>
                                        <label class="form-check-label ms-4" for="flexCheckDefault">
                                        اجازه دکمه خروج
                                        </label>
                                    </div>
                               
                                    <div class="form-check col-sm-2">
                                        <span> <input type="checkbox" name=""   class="form-check-input float-start p-1 accessInfo"  @if($customer->countLogin>0) checked @else @endif class="form-check-input" id="OnlineStatus" ></span>
                                        <label class="form-check-label ms-4" for="flexCheckDefault">
                                            وضعیت آنلاین 
                                        </label>
                                    </div>
                                
                                    <div class="form-check col-sm-3">
                                    <span><input type="checkbox"  class="form-check-input float-start p-1 accessInfo"  name="" @if($customer->pardakhtLive==1) checked @else @endif  class="form-check-input" id="PardakhtLive"></span>
                                        <label class="form-check-label ms-4" for="flexCheckDefault">
                                        فعالسازی پرداخت حضوری 
                                        </label>
                                    </div>
                               
                                    <div class="form-check col-sm-3">
                                        <span><input type="checkbox" class="form-check-input float-start p-1 accessInfo"   name="officialInfo" @if($customer->officialInfo==1) checked @else  @endif class="form-check-input" id="officialInfo"></span>
                                        <label class="form-check-label ms-4" for="flexCheckDefault">
                                            ویرایش معلومات رسمی 
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                    <div class="c-checkout tab-pane" id="takhfifCalc" style="margin:0; border-radius:10px 10px 2px 2px;">
                        <form action="{{url('/assignTakhfif')}}" id="kefTakhfifForm" target="_blank" method="post" class="tableBody" style=" height: calc(100vh - 400px);">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-label fs-6"> درصد تخفیف </label>
                                    <input type="text" class="form-control takhfifbagdesc" @if($customer->percentTakhfif) value="{{rtrim((string)number_format($customer->percentTakhfif,4, '/', ''),"0")}}" @else value="{{rtrim((string)number_format($defaultPercent,4, '/', ''),"0")}}" @endif name="percentTakhfif">
                                    <input type="text" name="CustomerSn" value="{{$customer->PSN}}" style="display:none;">
                                </div>
                                <div class="col-sm-9">
                                    <label class="form-label fs-6"> توضیح </label>
                                    <textarea class="form-control takhfifbagdesc" name="discription"> @if($customer->discription) {{trim($customer->discription)}} @else از تخفیف عمومی سایت مستفید است. @endif</textarea>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="c-checkout tab-pane" id="takhfifCaseHistory" style="margin:0; border-radius:10px 10px 2px 2px;">
                        <div class="row">
                            <div class="col-sm-12 tableBody" style=" height: calc(100vh - 400px);">
                                <table class="table table-bordered table-striped table-sm" style="text-align:center;">
                                    <thead class="bg-success">
                                    <tr>
                                        <th> ردیف </th><th> درصدی تخفیف </th><th> وضعیت استفاده </th><th> مبلغ (ت) </th><th> توضیح </th><th> تاریخ </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($takhfifHistory as $history)
                                        <tr>
                                            <td>{{$loop->iteration}}</td><td>{{number_format($history->lastPercent,4, '/', '')}}</td><td>@if($history->isUsed==0) استفاده نشده @else استفاده شده @endif </td><td>{{number_format($history->money)}}</td><td>{{trim($history->discription)}}</td><td>{{$history->changeDate}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align:left;">
                        <span style="float:left">
                            <button class="btn btn-success btn-sm text-warning" id="customerEdit" > ذخیره <i class="fa fa-save"> </i> </button>
                            <button class="btn btn-success btn-sm text-warning" id="allKalaFirst1" type="button" name="" > ذخیره <i class="fa fa-save"> </i> </button>
                            <button class="btn btn-success btn-sm text-warning" id="takhfifBag" form="kefTakhfifForm" type="submit"> ذخیره <i class="fa fa-save"> </i> </button>
                        </span> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row contentFooter"> </div>
        </div>
    </div>
</div>

    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <script>
        window.onload = function() {
            //used for displaying subgroups
            $(".mainGroupId").change(function() {
                $.ajax({
                    type: 'get',
                    async: true,
                    dataType: 'text',
                    url: "{{ url('/subGroupsEdit') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $('.mainGroupId:checked').val().split('_')[0],
                        kalaId: $('.mainGroupId:checked').val().split('_')[1]
                    },
                    success: function(answer) {
                        data = $.parseJSON(answer);
                        $('#subGroup1').empty();
                        for (var i = 0; i <= data.length - 1; i++) {
                            $('#subGroup1').append(
                                `<tr>
                                    <td>` + (i + 1) + `</td>
                                    <td>` + data[i].title + `</td>
                                    <td><input class="subGroupId" name="subGroupId" value="`+data[i].id+`" type="checkBox"></td>
                                    <td><input type="checkBox" id="flexCheckChecked`+i+`"/></td>`);
                            if (data[i].exist == 'ok') {
                                $('#flexCheckChecked' + i).prop('checked', true);
                            } else {
                                $('#flexCheckChecked' + i).prop('checked', false);
                            }
                        }
                    }
                });
            });
            $("#addKala").click(function() {
                var subGroupID = [];
                $('input[name=subGroupId]:checked').map(function() {
                    subGroupID.push($(this).val());
                });
                $.ajax({
                    type: 'get',
                    async: true,
                    dataType: 'text',
                    url: "{{ url('/addKalaToSubGroups') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mainGrId: $('.mainGroupId:checked').val().split('_')[0],
                        subGrId: subGroupID,
                        kalaId: $('.mainGroupId:checked').val().split('_')[1]
                    },
                    success: function(answer) {
                        data = $.parseJSON(answer);
                        $('#subGroup1').empty();
                        alert('اضافه شد');
                    }
                });
            });

            $("#deleteKala").click(function() {
                var subGroupID = [];
                $('input[name=subGroupId]:checked').map(function() {
                    subGroupID.push($(this).val());
                });
                $.ajax({
                    type: 'get',
                    async: true,
                    dataType: 'text',
                    url: "{{ url('/deleteKalaFromSubGroups') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mainGrId: $('.mainGroupId:checked').val().split('_')[0],
                        subGrId: subGroupID,
                        kalaId: $('.mainGroupId:checked').val().split('_')[1]
                    },
                    success: function(answer) {
                        data = $.parseJSON(answer);
                        $('#subGroup1').empty();
                        alert('حذف شد');
                    }
                });
            });
        }

        $("#takhfifBag").on("click", ()=>{
            $("#kefTakhfifForm").submit();
        })
        

        $("#customerAddress").on("click", ()=>{
            $("#customerEdit").hide();
            $("#allKalaFirst1").hide();
            $("#takhfifBag").hide();
        });

        $("#discountBagHistory").on("click", ()=>{
            $("#customerEdit").hide();
            $("#allKalaFirst1").hide();
            $("#takhfifBag").hide();
        });

        $("#customerInfo").on("click", ()=>{
            $("#customerEdit").show();
            $("#allKalaFirst1").hide();
            $("#takhfifBag").hide();
        });

        $("#moyRagiInfo").on("click", ()=>{
            $("#customerEdit").hide();
            $("#allKalaFirst1").show();
            $("#takhfifBag").hide();
        });

        if($("#moRagiInfo").hasClass("active")){
            $("#customerEdit").hide();
            $("#allKalaFirst1").hide();
            $("#takhfifBag").hide();
        }
      $("#manageDiscountBag").on("click", ()=>{
            $("#customerEdit").hide();
            $("#allKalaFirst1").hide();
            $("#takhfifBag").show();
      })

    </script>
@endsection
