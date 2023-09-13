@extends('admin.layout')
@section('content')
<style>
#officialCustomerStaff{
    display: none;
}
.checkRequestStuff{
    display: none;
}

.check-details {
    display:grid;
    grid-template-columns: auto auto auto auto;
    gap: 10px;
}

.check-details-item {
    background-color:#d5eee2;
}
.check-request-label{
    font-size:16px;
    margin-bottom:0px;
}

input[readonly] {
    background-color: #fff !important;
    box-shadow: #fff 1px 1px 1px 1px;
}

.check-container {
  display: flex;
  background-color: #3aa575;
  border-radius: 5px;
  padding:2px;
}

.check-item {
  background-color: #fff;
  color: #000;
  margin: 2px;
  padding:5px;
  text-align: right;
  width:24%;
  font-size: 14px;
  border-radius:2px;
  font-weight:bold;
}

.cehck-value {
    font-size:12px;
}
</style>
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="customerListRadioBtn" checked>
                        <label class="form-check-label me-4" for="assesPast"> لیست مشتریان </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="officialCustomerListRadioBtn">
                        <label class="form-check-label me-4" for="assesPast"> اشخاص رسمی </label>
                    </div>
					<div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="checkRequestRadioBtn">
                        <label class="form-check-label me-4" for="assesPast"> درخواست خرید چکی </label>
                    </div>
                     <div class="form-group customerListStaff">
                        <div class="input-group input-group-sm mt-1">
                            <span class="input-group-text"> جستجو  </span>
                            <input type="text" class="form-control form-control-sm" placeholder="کد, شماره تماس, اسم" id="searchCustomerByName">
                        </div>
                    </div>
                    <div class="form-group input-group-sm customerListStaff mt-1">
                        <div class="input-group input-group-sm">
                        
                            <span class="input-group-text">شهر</span>
                            <select class="form-select form-select-sm" id='searchCityId'>
                                <option value="">همه</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->SnMNM}}">{{$city->NameRec}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					<div class="form-group input-group-sm customerListStaff mt-1">
						<div class="input-group input-group-sm">
							<span  class="input-group-text">منطقه</span>
							<select class="form-select form-select-sm" id="searchSelectMantiqah">
								<option value="">همه</option>
							</select>
						</div>
					</div>
					<div class="form-group input-group-sm customerListStaff mt-1">
						<div class="input-group input-group-sm">
							<span class="input-group-text">فعال</span>
							<select  class="form-select form-select-sm" id="searchActiveOrNot">
								<option  value="-1" hidden> همه </option>
								<option value="0"> فعال </option>
								<option value="1"> غیر فعال </option>
							</select>
						</div>
					</div>
					<div class="form-group input-group-sm customerListStaff mt-1">
						<div class="input-group input-group-sm">
							<span class="input-group-text">موقعیت</span>
							<select  class="form-select input-group-smm-select form-select-sm" id="searchLocationOrNot">
								<option value="-1"> همه </option>
								<option value="1">موقعیت دار </option>
								<option value="0"> بدون موقعیت </option>
							</select>
						</div>
					</div>
					<div class="form-group input-group-sm customerListStaff mt-1">
						<div class="input-group input-group-sm">
							<span class="input-group-text">مرتب سازی</span>
							<select class="form-select form-select-sm" id="orderCustomers">
								<option value="Name">اسم</option>
								<option value="PCode">کد</option>
							</select>
						</div>
					</div>
					<div class="form-group  customerListStaff mt-2">
						<button type="button" class="btn btn-success btn-sm topButton" id="filterCustomerBtn"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
					</div>


                    <div class="form-group input-group-sm checkRequestStuff mt-1">
						<div class="input-group input-group-sm">
							<span class="input-group-text"> در خواست چک </span>
							<select class="form-select form-select-sm" id="chequeReqStates">
								<option value=""> همه </option>
								<option value="New"> جدید </option>
								<option value="Accepted"> تأیید شده </option>
								<option value="Rejected"> رد شده </option>
							</select>
						</div>
					</div>
                    <div class="col-lg-12 m-2 checkRequestStuff text-center">
						<button type="button" class="btn btn-success btn-sm topButton" id="filterReqChequeBtn"> بازخوانی &nbsp; <i class="fa fa-refresh"></i> </button>
                    </div>
                </fieldset>
                </div>
                <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                    <div class="row contentHeader">
                        <div class="col-sm-12 text-end mt-1 customerListStaff">
                            <button class='enableBtn btn btn-success btn-sm text-warning' type="button" id="openDashboard" onclick="openDashboard(this.value)"  disabled> داشبورد <i class="fal fa-money-bill-alt"></i></button>
                            <form action="{{ url('/editCustomer') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="text" id="customerSn" style="display: none" name="customerSn" value="" />
                                <input type="text" id="customerGroup" style="display: none" name="customerGRP" value="" />
                                @if(hasPermission(Session::get( 'adminId'),'customerListN') > 0) 
                                    <button class='enableBtn btn btn-success btn-sm text-warning' data-toggle='modal' type="submit" id='editPart' disabled style="color:#9ed5b6 "> ویرایش <i class="fal fa-edit"></i></button>
                                @endif
                                @if(hasPermission(Session::get( 'adminId'),'customerListN') > 0) 
                                <button class='enableBtn btn btn-success btn-sm text-warning' data-toggle='modal' type="submit" id='editPart'disabled> ارسال به اکسل <i class="fal fa-file-excel" aria-hidden="true"></i></button>
                                <button class="enableBtn btn btn-success btn-sm text-warning" id="defineRoute" type="button" disabled>تعیین مسیر <i class="fal fa-address-card"></i></button>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="row mainContent">
                        <table id="strCusDataTable" class='table table-bordered table-sm customerListStaff px-0'>
                            <thead class="tableHeader">
                                <tr>
                                    <th> ردیف </th>
                                    <th> کد </th>
                                    <th> اسم </th>
                                    <th style="width:390px">آدرس </th>
                                    <th> همراه </th>
                                    <th> منطقه </th>
                                    <th> درج  </th>
                                    <th> انتخاب </th>
                                </tr>
                                </thead>
                                <tbody id="customerList" class="select-highlight tableBody">
                                </tbody>
                            </table>
							<!-- لیست درخواستی های چکی -->
						  	<table id="" class='table table-bordered table-sm checkRequestStuff px-0'>
								<thead class="tableHeader">
									<tr>
										<th> ردیف </th>
										<th> کد </th>
										<th> اسم </th>
										<th> همراه </th>
										<th> منطقه </th>
										<th> نمایش جزئیات </th>
										<th> انتخاب </th>
									</tr>
								</thead>
                                <tbody id="checkReqList" class="select-highlight tableBody">
									@foreach($chekRequests as $checkReq)
										<tr onclick="selectCustomerStuff(this)">
											<td> {{$loop->index+1}} </td>
											<td> {{$checkReq->PCode}} </td>
											<td> {{$checkReq->Name}} </td>
											<td> {{$checkReq->PhoneStr}} </td>
											<td> {{$checkReq->NameRec}} </td>
											<td onclick="customerCheckDetails({{$checkReq->PSN}})"> <i class="fa fa-eye"></i>  </td>
											<td> <input type="radio" name="checkReqRadio"/> </td>
										</tr>
									@endforeach
                                </tbody>
                            </table>

                            <!-- لیست اشخاص حقیقی -->
                            <form action="{{url('/customer')}}" method="POST" enctype="multipart/form-data" id="officialCustomerStaff" class="px-0 mx-0">
                            @csrf
                            <div class="c-checkout" style="background: linear-gradient(#3ccc7a, #034620); border-radius:5px 5px 2px 2px;">
                                <div class="col-sm-6">
                                    <ul class="header-list nav nav-tabs" data-tabs="tabs" style="margin: 0; padding:0;">
                                        <li><a class="active" data-toggle="tab" style="color:black;"  href="#custAddress"> اشخاص حقیقی  </a></li>
                                        <li><a data-toggle="tab" style="color:black;"  href="#moRagiInfo"> اشخاص حقوقی </a></li>
                                    </ul>
                                </div>
                                <div class="c-checkout tab-content" style="background-color:#f5f5f5; border-radius:5px 5px 2px 2px;">
                                        <div class="row c-checkout rounded-2 tab-pane active" id="custAddress">
                                                <table class="table table-responsive table-bordered table-sm" id="myTable" style="text-align:center">
                                                    <thead class="table bg-success tableHeader">
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>نام</th>
                                                            <th>نام خانودگی</th>
                                                            <th>شماره ملی</th>
                                                            <th>کد نقش</th>
                                                            <th>کد پستی</th>
                                                            <th> آدرس</th>
                                                            <th>ارسال به دفتر حساب </th>
                                                            <th>ویرایش </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tableBody">
                                                    <?php if(!empty($haqiqiCustomers)){ ?>
                                                        @foreach ($haqiqiCustomers as $haqiqiCustomer)
                                                        <tr>
                                                            <td> {{$loop->index+1}} </td>
                                                            <td> {{$haqiqiCustomer->customerName}}</td>
                                                            <td> {{$haqiqiCustomer->familyName}}</td>
                                                            <td> {{$haqiqiCustomer->codeMilli}} </td>
                                                            <td> {{$haqiqiCustomer->codeNaqsh}}</td>
                                                            <td> {{$haqiqiCustomer->codePosti}}</td>
                                                            <td> {{$haqiqiCustomer->address}}</td>
                                                        <td> <i class="fa fa-paper-plane" style="color:#198754"> </td>
                                                        @if(hasPermission(Session::get( 'adminId'),'officialCustomerN' ) > 1)
                                                            <td> <a  @if(hasPermission(Session::get( 'adminId'),'officialCustomerN' ) >0 ) href="{{url('haqiqiCustomerAdmin', $haqiqiCustomer->customerShopSn)}}" @else href="#" @endif> <i class="fal fa-edit fa-md" style="color:#ffc107"></i> </a></td>
                                                        @endif
                                                        </tr>
                                                    @endforeach
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                        </div>

                                        <div class="row c-checkout rounded-2 tab-pane" id="moRagiInfo">
                                                    <table class="table table-hover table-bordered table-sm" id="myTable" style="text-align:center">
                                                        <thead class="table bg-success tableHeader">
                                                            <tr>
                                                                <th> ردیف </th> 
                                                                <th>نام شرکت</th>
                                                                <th>شناسه ملی </th>
                                                                <th>کد نقش </th>
                                                                <th>کد پستی </th>
                                                                <th> آدرس </th>
                                                                <th>ارسال به دفتر حساب </th>
                                                                <th>ویرایش </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableBody">
                                                            <?php if(!empty($hohoqiCustomers)){  ?>
                                                            @foreach ($hohoqiCustomers as $hohoqiCustomer)
                                                            <tr>
                                                                <td> {{$loop->index+1}} </td>
                                                                <td> {{$hohoqiCustomer->companyName}}</td>
                                                                <td> {{$hohoqiCustomer->shenasahMilli}}</td>
                                                                <td> {{$hohoqiCustomer->codeNaqsh}}</td>
                                                                <td> {{$hohoqiCustomer->codePosti}}</td>
                                                                <td> {{$hohoqiCustomer->address}}</td>
                                                                <td> <i class="fa fa-paper-plane" style="color:#198754"> </td>
                                                                <td>
                                                                    @if(hasPermission(Session::get( 'adminId'),'officialCustomerN' ) > 1)
                                                                    <a @if(hasPermission(Session::get( 'adminId'),'officialCustomerN' ) > 0 ) href="{{url('haqiqiCustomerAdmin', $hohoqiCustomer->customerShopSn)}}" @else href="#" @endif> <i class="fal fa-edit" style="color:#ffc107"></i> </a>
                                                                    @endif
                                                                </td>
                                                                </tr>
                                                            @endforeach
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <div class="row contentFooter"> </div>
                        </div>
                    </div>
                </div>
 @include('customer.modalDashboard')
  <div class="modal fade dragableModal" id="personRoute" data-backdrop="static" data--keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
            <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close" style="background-color:red;"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> تعین مسیر اشخاص </h5>
        </div>
        <div class="modal-body">
        
            <select class="form-select" id='cityId' name="city">
            <option value="0" hidden>شهر</option>
                @foreach($cities as $city)
                <option value="{{$city->SnMNM}}">{{$city->NameRec}}</option>
                @endforeach
            </select>
            <select class="form-select mt-4" id="selectMantiqah">
            <option value="0" hidden>منطقه</option>
            </select>
            <input type="hidden" id="customerId">
        </div>
        <div class="modal-footer">
          <button type="button" onclick="takhsisMsir()" class="btn btn-success starfoodbntHover">ذخیره <i class="fa fa-save"></i> </button>
        </div>
      </div>
    </div>
  </div>
  <!-- customer chekc details -->
<div class="modal fade" id="checkDetailsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="checkDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-success py-2 text-white">
          <button type="button" class="btn-close text-danger" data-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="checkDetailsModalLabel"> جزئیات چک  </h5>
      </div>
      <div class="modal-body py-1">
<div class="row">
    <div class="col-lg-12">
    <fieldset class="border rounded" style="border:1px dashed red !important;">
    <legend  class="float-none w-auto legendLabel p-3 m-1 fw-bold"> جزئیات درخواست چک  <button class="btn-sm btn-success btn" onclick="sendToWord()"> پرینت کردن <i class="fa fa-print"></i> </button> </legend>
        <div class="row m-1">
            <div class="check-container">
                <div class="check-item">  نام و نام خانوادگی : <span class="cehck-value" id="fullName">  </span> </div>
                <div class="check-item">  کد ملی : <span class="cehck-value" id="miliCode">  </span> </div>
                <div class="check-item"> شماره تماس :  <span class="cehck-value" id="userPhone">  </span> </div>
                <div class="check-item">  آدرس منزل : <span class="cehck-value" id="homeAddress">  </span> </div>
                <div class="check-item">  وضعیت ملک : <span class="cehck-value" id="melkSituation">  </span> </div>
            </div>
        </div>

        <div class="row m-1">
            <div class="check-container">
                <div class="check-item">  تاریخ ختم قرارداد : <span class="cehck-value" id="endContract">  </span> </div>
                <div class="check-item">  صاحب ملک : <span class="cehck-value" id="milkOwner">  </span> </div>
                <div class="check-item"> مبلغ ودیع (ریال) :  <span class="cehck-value" id="vadeahAmaount">  </span> </div>
                <div class="check-item">  شماره تماس : <span class="cehck-value" id="mostagerPhone">  </span> </div>
            </div>
        </div>
        <div class="row m-1">
            <div class="check-container">
                <div class="check-item">  جواز: <span class="cehck-value" id="license">  </span> </div>
                <div class="check-item"> تعداد سال فعالیت  : <span class="cehck-value" id="workExp">  </span> </div>
                <div class="check-item"> مکان قبلی فعالیت :  <span class="cehck-value" id="formerPlace">  </span> </div>
            </div>
        </div>
        <div class="row m-1">
            <div class="check-container">
                <div class="check-item">  مبلغ در خواستی اعتبار(ریال) :  <span class="cehck-value" id="requestedAmount">  </span> </div>
                <div class="check-item"> چک برگشتی  : <span class="cehck-value" id="returnedCheck">  </span> </div>
                <div class="check-item"> مبلغ به ریال :  <span class="cehck-value" id="returnedCheckAmount">  </span> </div>
                <div class="check-item"> علت برگشت  :  <span class="cehck-value" id="returnReason">  </span> </div>
            </div>
        </div>

        <div class="row m-1">
            <div class="check-container">
                <div class="check-item">  اسم بانک :  <span class="cehck-value" id="bankName">  </span> </div>
                <div class="check-item"> اسم /کد شعبه : <span class="cehck-value" id="branchName">  </span> </div>
                <div class="check-item"> شماره حساب :  <span class="cehck-value" id="accountNo">  </span> </div>
            </div>
        </div>
       

        <fieldset class="border rounded p-1" style="border:1px dashed #f53838 !important;">
         <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:#f53838"> مشخصات ضامن </legend>
            <div class="row m-1">
                <div class="check-container">
                    <div class="check-item">نام : <span class="cehck-value" id="zaminName">  </span> </div>
                    <div class="check-item"> آدرس : <span class="cehck-value" id="zaminAdress">  </span> </div>
                    <div class="check-item">تلفن :  <span class="cehck-value" id="zaminPhone">  </span> </div>
                    <div class="check-item"> شغل :  <span class="cehck-value" id="zaminOccupation">  </span> </div>
                </div>
            </div>  
        </fieldset>

        <fieldset class="border rounded p-1 mt-2" style="border:1px dashed #f53838 !important;">
         <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:#f53838"> تامین کننده  </legend>

         <div class="row m-1">
                <div class="check-container">
                    <div class="check-item">نام : <span class="cehck-value" id="taminName">  </span> </div>
                    <div class="check-item"> آدرس : <span class="cehck-value" id="taminAddress">  </span> </div>
                    <div class="check-item">تلفن :  <span class="cehck-value" id="taminPhone">  </span> </div>
                </div>
            </div> 
        </fieldset>  
    </fieldset>
    </div>
      </div>
      <div class="modal-footer">
		  <input type="hidden" id="checkReqId"/>
		  <button type="button" onclick="changeCheckReqState('reject',document.querySelector('#checkReqId').value)" class="btn btn-sm btn-danger"> رد </button>
		  <button type="button" onclick="changeCheckReqState('delete',document.querySelector('#checkReqId').value)" class="btn btn-sm btn-danger"> حذف </button>
		  <button type="button" onclick="changeCheckReqState('accept',document.querySelector('#checkReqId').value)" class="btn btn-sm btn-success"> تایید </button>
      </div>
    </div>
  </div>
</div>



<script> 

$("#defineRoute").on("click", ()=>{
	    if(!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 444
            });
        }
              $('#personRoute').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
	$("#personRoute").modal("show");
})

$("#confirmCheck").on("click", ()=>{
        swal({
            title: "آیا شما مطمئین هستید؟",
            text: "اگر تایید شد، دیگر قابل بازگشت نیست!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("چک موفقانه تائید شد! ", {
                icon: "success",
                });
            } else {
                swal("تایید شد!");
            }
            });
    });


$("#cancelCheck").on("click", ()=>{
        swal({
            title: "آیا شما مطمئین هستید؟",
            text: "اگر رد کردید، دیگر قابل بازگشت نیست!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("چک موفقانه رد شد! ", {
                icon: "success",
                });
            } else {
                swal("رد شد!");
            }
            });
    });

$("#deleteCheck").on("click", ()=>{
        swal({
            title: "آیا شما مطمئین هستید؟",
            text: "اگر حذف کردید، دیگر قابل بازگشت نیست!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("چک موفقانه حذف شد! ", {
                icon: "success",
                });
            } else {
                swal("حذف شد!");
            }
            });
    });

</script>
@endsection
