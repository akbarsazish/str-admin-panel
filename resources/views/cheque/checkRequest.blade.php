@extends('layout.layout')
@section('content')

<style>
    .check-request-label {
        font-size:14px;
        font-weight:bold;
    }
    #endOfContract, #returnedCheck {
        display:none;
    }
    label {
        margin-bottom: 0px !important;
    }
</style>

<div class="container topDistance">

<div class="row">
	@if($checkRequestOrNot==0)
    <div class="col-lg-12">

    <fieldset class="border rounded" style="border:1px dashed red !important;">
    <legend  class="float-none w-auto legendLabel p-3 m-1 fw-bold"> در خواست خرید چکی  </legend>
        <form action="{{url('/addRequestCheck')}}" method="post" id="addRequestCheckForm" class="p-3">
		   @csrf
         <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="roleNo" class="form-label check-request-label"  data-toggle="tooltip" data-placement="bottom"> نام و نام خانوادگی :</label>
                    <input type="text"  min=0 class="form-control form-control-sm"  name="name" required>
					<input type="hidden" name="customerId" value="{{Session::get('psn')}}">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="postalCode"  class="form-label check-request-label"  data-toggle="tooltip" data-placement="bottom" >کد ملی :</label>
                    <input  type="number" min=0 class="form-control form-control-sm" id="postalCode" oninput="limitInputLength()"  name="milliCode" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> شماره تماس   :</label>
                    <input  type="number"  min=0 class="form-control form-control-sm" name="phone" required>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="address " class="form-label check-request-label" > وضعیت ملک :</label>
                     <select class="form-select form-select-sm" id="ownershipStatus" name="milkState" onchange="showHiddenDiv()">
                        <option value="sarqufli"> سر قفلی </option>
                        <option value="malik"> صاحب ملک </option>
                        <option value="mostager"> مستاجر </option>
                    </select>
                </div>
            </div>
        </div>

        <fieldset class="border rounded p-1" style="border:1px dashed red !important;" id="endOfContract">
           <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:red"> جزئیات قرار داد </legend>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom">  تاریخ اتمام :</label>
                        <input  type="text" class="form-control form-control-sm" id="contractEndDate" >
                        <input  type="hidden" id="contractEnEnd" name="contractDate">
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> صاحب ملک  :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm" name="malikName">
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> مبلغ ودیعه (ریال) :</label>
                        <input  type="text"  oninput="requestAmountShowValue(this,'checkDepositAmountContainer',this.value)"  min=0 class="form-control form-control-sm" name="depositAmount">
                    </div>
					<span id="checkDepositAmountContainer"> </span>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> شماره تماس  :</label>
                        <input  type="number"  min=0 class="form-control form-control-sm" name="malikPhone">
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> آدرس منزل :</label>
                    <input  type="text"  min=0 class="form-control form-control-sm" name="homeAddress" required>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="address" class="form-label check-request-label">  جواز  :</label>
                     <select class="form-select form-select-sm" name="jawazState" aria-label="form-select-sm example" id="">
                        <option value="yes"> دارم </option>
                        <option value="no" > ندارم </option>
                        <option value="underWork"> در دست اقدام </option>
                    </select>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> چند سال است که در این حوزه فعال هستید؟ </label>
				<select class="form-select form-select-sm" name="workExperience" required>
					<option value="یک تا سه سال "> یک تا سه سال </option>
					<option value="سه تا شش سال "> سه تا شش سال  </option>
					<option value="پنج تا ده سال "> پنج تا ده سال  </option>
					<option value="ده سال به بالا "> ده سال به بالا  </option>
				</select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> مکان قبلی فعالیت :</label>
                    <input  type="text"  min=0 class="form-control form-control-sm"  name="lastAddress">
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom">
						مبلغ در خواستی اعتبار (ریال) :
					</label>
                    <input type="text" min=0 class="form-control form-control-sm" name="reliablityMony" id="requestedAmount" oninput="requestAmountShowValue(this,'checkAmountContainer',this.value)" required>
                </div>
				<span id="checkAmountContainer"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="address" class="form-label check-request-label"> آیا هنوز تجربه چک برگشتی داشته‌اید؟ </label>
                    <select class="form-select form-select-sm" name="returnedCheckState" onchange="showHiddenDiv()" id="returnCheckSelect">
						<option value="no"> خیر </option>
						<option value="yes"> بله </option>
					</select>
                </div>
            </div>
        </div> 
        <div class="row" id="showRequestedAmount">
            <p id="amountOutput"></p>
        </div>

        <fieldset class="border rounded p-1" id="returnedCheck" style="border:1px dashed red !important;">
           <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:red"> چک برگشتی </legend>
             <div class="row" >
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> مبلغ (ریال)  :</label>
                        <input  type="text" oninput="requestAmountShowValue(this,'checkRetAmountContainer',this.value)"  min=0 class="form-control form-control-sm" name="returnedCheckMoney">
                    </div>
					<span id="checkRetAmountContainer"></span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="mb-1 mt-1">
                        <label for="address" class="form-label check-request-label"> علت برگشت :</label>
                        <textarea class="form-control" name="returnedCheckCause" id="exampleFormControlTextarea1" rows="1"></textarea>
                    </div>
                </div>
            </div> 
        </fieldset>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> اسم بانک :</label>
                    <!-- <input  type="text"  min=0 class="form-control form-control-sm" name="bankName" required> -->
                    <select class="form-select form-select-sm" name="bankName" onchange="showHiddenDiv()" id="returnCheckSelect">
						<option value="بانک ملی">بانک ملی </option>
						<option value="بانک تجارت"> بانک تجارت </option>
						<option value=" بانک کشاورزی">  بانک کشاورزی </option>
						<option value="بانک ملیت"> بانک ملت </option>
						<option value="بانک سپه"> بانک سپه </option>
						<option value="بانک مسکن"> بانک مسکن </option>
						<option value="بانک رفاه"> بانک رفاه </option>
						<option value="بانک انصار"> بانک انصار </option>
						<option value="بانک پارسیان"> بانک پارسیان </option>
						<option value="پست بانک"> پست بانک </option>
						<option value="بانک آینده "> بانک آینده </option>
						<option value=" بانک پاسارگاد  "> بانک پاسارگاد </option>
						<option value=" بانک توسعه صادرات ">  بانک توسعه صادرات </option>
						<option value=" بانک دی">  بانک دی</option>
						<option value=" بانک سپه ">  بانک سپه </option>
						<option value=" بانک شهر ">  بانک شهر </option>
						<option value=" بانک قرض‌الحسنه رسالت ">  بانک قرض‌الحسنه رسالت </option>
						<option value="  بانک کارآفرین  ">  بانک کارآفرین </option>
						<option value=" بانک مرکزی">  بانک مرکزی</option>
						<option value=" بانک اقتصاد نوین  ">  بانک اقتصاد نوین </option>
						<option value=" بانک ایران و ونزوئلا ">  بانک ایران و ونزوئلا </option>
						<option value=" بانک حکمت ایرانیان ">  بانک حکمت ایرانیان </option>
						<option value="  بانک رفاه کارگران  ">  بانک رفاه کارگران </option>
						<option value=" بانک سرمایه ">  بانک سرمایه </option>
						<option value=" بانک قرض‌الحسنه مهر ایران ">  بانک قرض‌الحسنه مهر ایران </option>
						<option value=" بانک مسکن ">  بانک مسکن </option>
						<option value=" بانک مهر اقتصاد ">  بانک مهر اقتصاد </option>
						<option value=" بانک انصار ">  بانک انصار </option>
						<option value=" بانک پارسیان ">  بانک پارسیان </option>
						<option value=" بانک توسعه تعاون ">  بانک توسعه تعاون </option>
						<option value=" بانک خاورمیانه ">  بانک خاورمیانه </option>
						<option value=" بانک سامان ">  بانک سامان </option>
						<option value=" بانک سینا ">  بانک سینا </option>
						<option value=" بانک صنعت و معدن ">  بانک صنعت و معدن </option>
						<option value=" بانک قوامین ">  بانک قوامین </option>
						<option value=" بانک گردشگری ">  بانک گردشگری </option>
					</select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="address" class="form-label check-request-label"> اسم شعبه - کد:</label>
                    <input  type="text" class="form-control form-control-sm" name="branchName" required>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="mb-1 mt-1">
                    <label for="address" class="form-label check-request-label"> شماره حساب: </label>
                    <input  type="number" oninput="limitInputLength()"  id="accountNo" class="form-control form-control-sm" name="accountNo" required>
                </div>
            </div>
        </div>

        <fieldset class="border rounded p-1" style="border:1px dashed red !important;">
         <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:red"> مشخصات ضامن </legend>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> نام   :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm"  name="zaminName" required>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> آدرس   :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm"   name="zaminAddress" required>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> تلفن  :</label>
                        <input  type="number" id="zaminPhone" min=0 class="form-control form-control-sm phoneNoLimit"  oninput="limitInputLength()"  name="zaminPhone" required>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> شغل :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm"  name="zaminJob" required>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="border rounded p-1" style="border:1px dashed red !important;">
         <legend  class="float-none w-auto legendLabel p-0 mb-0" style="font-size:14px; font-weight:bold; color:red"> تامین کننده قبلی، کالاهای مورد نیاز خویش  را نام ببرید  </legend>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> نام   :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm"  name="lastSuppName" >
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> تلفن    :</label>
                        <input  type="text" id="taminPhone"  min=0 class="form-control form-control-sm phoneNoLimit" oninput="limitInputLength()"  name="lastSuppPhone" >
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="mb-1 mt-1">
                        <label for="shenasahmilli" class="form-label check-request-label" data-toggle="tooltip" data-placement="bottom"> آدرس  :</label>
                        <input  type="text"  min=0 class="form-control form-control-sm"  name="lastSuppAddress" >
                    </div>
                </div>
            </div>
        </fieldset>
            <button type="submit" class="btn btn-sm btn-danger m-2"> ثبت <i class="fa fa-check"></i> </button>
        </form>     
    </fieldset>
    </div>
	@elseif($checkReqState=="New")
		<p> درخواست خرید چکی از سوی شما دریافت شده است. پس از بررسی اسناد ارسالی، به شما اعلام خواهد شد. </p>
	@elseif($checkReqState=="Accepted")
		<p> درخواست خرید چکی شما بعد از بررسی تأیید شد و از این پس مجاز به خریدهای چکی می‌باشید. </p>
	@elseif($checkReqState=="Rejected")
		<p> متاسفانه ما نتوانستیم تقاضای خرید چکی شما را قبول کنیم، امیدواریم که این امر شما را از همکاری با ما در آینده منصرف نسازد. ما به دنبال ارائه خدمات با کیفیت و ایجاد رابطه ای بر پایه اعتماد و محترمانه با همه مشتریان خود هستیم. </p>
	@endif
</div>
</div>

<script>


function showHiddenDiv() {
  var selectElement = document.getElementById("ownershipStatus");
  var selectedOption = selectElement.value;
  
  var hiddenDiv = document.getElementById("endOfContract");
  
  if (selectedOption === "mostager") {
    hiddenDiv.style.display = "block";
  } else {
    hiddenDiv.style.display = "none";
  }

  var selectElement = document.getElementById("returnCheckSelect");
  var selectedOption = selectElement.value;
  
  var hiddenDiv = document.getElementById("returnedCheck");
  
  if (selectedOption === "yes") {
    hiddenDiv.style.display = "block";
  } else {
    hiddenDiv.style.display = "none";
  }
}

function limitInputLength() {
  var postalCode = document.getElementById("postalCode");
  var accountNo = document.getElementById("accountNo");
  var phoneLimit = document.getElementsByClassName("phoneNoLimit");
 
  var maxLength = 10;
  let accLength = 16;
  let phoneNo = 12;

  if (postalCode.value.length > maxLength) {
    postalCode.value = postalCode.value.slice(0, maxLength);
  }

  if (accountNo.value.length > accLength) {
    accountNo.value = accountNo.value.slice(0, accLength);
  }

  if (phoneLimit.value.length > phoneNo) {
    phoneLimit.value = phoneLimit.value.slice(0, phoneNo);
  }
}

</script>

@endsection