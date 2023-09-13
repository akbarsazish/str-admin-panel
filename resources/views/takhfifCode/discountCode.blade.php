@extends('admin.layout')
@section('content')
<style>
    .send-discound-code {
        bottom:10%;
        position:relative;
    }
</style>
<div class="container-fluid containerDiv">
	
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> کد تخفیف  </legend>
                    <div class="col-sm-12">
                        <div class="input-group input-group-sm mt-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> از تاریخ  </span>
                            <input type="text" class="form-control" id="disCountFirstDate">
                        </div>
                    </div>
                    <div class="col-sm-12">                        
                        <div class="input-group input-group-sm mt-1">
							<span class="input-group-text" id="inputGroup-sizing-sm"> تا تاریخ  </span>
							<input type="text" class="form-control" id="disCountSecondDate">
                        </div>
                    </div>
                    <div class="col-sm-12"> 
                         <button class="btn btn-sm btn-success" id="searchSMSByDateBtn"> بازخوانی <i class="fa fa-history"></i> </button>
                    </div>

                    <div class="col-sm-12  mt-5"> 
                        <button class="btn btn-sm btn-success send-discound-code" id="sendDiscountCodeBtn" >  ارسال کد تخفیف <i class="fa fa-send"></i> </button>
                    </div>
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">

                </div>
                <div class="row mainContent">
                   <div class="col-lg-12 mx-0 px-0" id="notificationReport">
                        <table class="table table-bordered table-sm">
                            <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>  تاریخ </th>
                                        <th> کد تخفیف </th>
                                        <th>  تعداد ارسال  </th>
										<th>  تعداد استفاده  </th>
                                        <th> مشاهده  </th>
                                        <th>انتخاب</th>
                                    </tr>
                            </thead>
                            <tbody class="tableBodyTwo" style="height:233px !important;" id="sendDiscountCodeList">
								@foreach($smsHistory as $sms)
									 <tr onclick="getSMSCustomers(this,{{$sms->ModelSn.",'".$sms->sabtDate."'"}})">
										<td> {{$loop->iteration}} </td>
										<td> {{$sms->sabtDate}} </td>
										<td> {{$sms->ModelName}} </td>
										<td> {{$sms->countSent}} </td>
										<td> {{$sms->countUsed}} </td>
										<td> 
											<a href="{{url('/discountCodeReceiver/'.$sms->ModelSn.'/'.$sms->sabtDate)}}" class="viewReceiver"> 
												<i class="fa fa-eye text-dark"></i>
											</a>
										 </td>
										<td> <input type="radio" name="selectModel"> </td>
									 </tr>
								@endforeach
                            </tbody>
                        </table>
					    <table class="table table-bordered table-sm">
                            <thead class="tableHeader">
								<tr>
									<th> ردیف </th>
									<th> تاریخ </th>
									<th> مشتری </th>
									<th> کد تخفیف </th>
									<th> وضعیت دریافت </th>
									<th> وضعیت استفاده </th>
								</tr>
                            </thead>
                            <tbody class="tableBodyTwo" style="height:188px ! important; overflow-y: scroll;" id="sentMessageCustomers">

                            </tbody>
                        </table>
                   </div>
                </div>
                <div class="row contentFooter"> 
                    <div class="button-container">
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success"> امروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success">  دیروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success">  صدتای آخر  </button>
                            </div>
                            <div class="button-item">
                                 <button type="button" class="btn btn-sm btn-success"> همه   </button>
                            </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- Modal for sendign notification individually -->
<div class="modal fade" id="sendDiscountCodeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-fullscreen" style=" overflow-x: hidden !important; overflow-y:visiable">
    <div class="modal-content">
      <div class="modal-header py-2 bg-success text-white">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> کد تخفیف جدید </h5>
        </div>
      <div class="modal-body p-1"> 
           <div class="row mb-1 rounded">
           </div>
            <div class="notificationTable">
                <div class="firstFr">  
                        <label  class="form-label mb-0"> شهر </label>                          
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" id="searchCityNotification">
                                <option value="0">همه</option>
                                @foreach($cities as $city)
                                <option value="{{$city->SnMNM}}"> {{$city->NameRec}} </option>
                                @endforeach
                            </select>
                        </div>
                        <label  class="form-label mb-0"> منطقه </label>                          
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" id="selectMantiqahNotification"> </select>
                        </div>
					<!--
                        <label  class="form-label mb-0"> خرید </label>                          
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" id="selectBuyState"> 
                                <option value="-1">همه</option>
								<option value="1"> دارد </option>
								<option value="0"> ندارد </option>
							</select>
                        </div>
					-->
                        <label  class="form-label mb-0"> وضعیت سبد </label>                          
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" id="selectBasketState"> 
                                <option value="">همه</option>
								<option value="1"> پر </option>
								<option value="0"> خالی </option>
							</select>
                        </div>

                        <label  class="form-label mb-0"> وضعیت مشتری </label>                          
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" id="selectCustomerState"> 
                                <option value="0">همه</option>
                                @foreach($customerStates as $state)
								    <option style="background-color:{{$state->color}}" value="{{$state->id}}"> {{$state->name}} </option>
                                @endforeach
							</select>
                        </div>
                        <label  class="form-label mb-0"> جستجو </label>    
                        <input type="text" class="form-control form-control-sm" id="bynameCodePhoneSearch">

                        <label  class="form-label mb-0">  از تاریخ خرید </label>    
                        <input type="text" name="secondDateBuy" class="form-control form-control-sm" id="firstDateNotify">
                        <label  class="form-label mb-0"> تا تاریخ خرید </label>    
                        <input type="text" class="form-control form-control-sm" id="secondDateNotify">
					
					    <label  class="form-label mb-0"> عدم خرید از تاریخ </label>    
                        <input type="text" name="firstDateNoBuy" class="form-control form-control-sm" id="firstDateNoBuy">
                        <label  class="form-label mb-0"> تا تاریخ </label>    
                        <input type="text" name="secondDateNoBuy" class="form-control form-control-sm" id="secondDateNoBuy">
                        <button class="btn btn-sm btn-success m-2" onclick="searchCustomerForSMS()"> بازخوانی </button>
                </div>
                <div class="secondFr">
                    <table class="table table-bordered table-sm">
                        <thead class="tableHeader">
                                <tr>
                                    <th>  ردیف  </th>
                                    <th>  مشتری  </th>
                                    <th>  شماره تماس </th>
                                    <th>  آخرین خرید </th>
                                    <th>  <input type="checkbox"  name="" class="selectAllFromTop form-check-input"/>  </th>

                                </tr>
                        </thead>
                        <tbody class="tableBody" id="customerList">
                        </tbody>
                    </table>
                </div>
                <div class="thirdFr">
                    <select class="form-select form-select-sm bg-success text-warning" id="selectedSMSModel">
						<option value="" selected> مدل پیام </option>
                        @foreach($smsModels as $model)
						<option value="{{$model->Id}}" >{{$model->ModelName}}</option>
						@endforeach
                    </select>
                   <div class='modal-body' style="position:relative; right: 15%; top: 5%;">
                            <a id="addToNotify">
                                <i class="fa-regular fa-circle-chevron-left fa-4x chevronHover"></i>
                            </a>
                            <br />
                            <a id="removeFromNotify">
                                <i class="fa-regular fa-circle-chevron-right fa-4x chevronHover"></i>
                            </a>
                    </div>
                </div>
                <div class="fourthFr"> 
                    <table class="table table-bordered table-sm">
                        <thead class="tableHeader">
                            <tr>
                                <th> ردیف </th>
                                <th> مشتری </th>
                                <th> انتخاب </th>
                            </tr>
                        </thead>
                        <tbody class="tableBody" id="addedCustomes">
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">  بستن  </button>
		  <button type="button" class="btn btn-success btn-sm" id="sendIdividuallyBtn" data-target="#sendDiscounModal" data-toggle="modal"> 				ارسال کد تخفیف 
		  </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal for sendign notification  -->
<div class="modal fade" id="sendDiscounModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header py-2 text-white" style="background-color:#0b4e2f">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> ارسال کد تخفیف    </h5>
        </div>
      <div class="modal-body">
         <div class="mb-0">
			 <label for="exampleFormControlTextarea1" class="form-label fs-6"> ارسال از طریق </label>
			 <select class="form-select form-select-sm">
				 <option value="sms" > پیامک </option>
				 <option value="whatsapp" > واتساپ </option>
				 <option value="tellegram" > تلیگرام </option>
				 <option value="bale" > بله </option>
				 <option value="eta" > ایتا </option>
				 <option value="rubika" > روبیکا </option>
			 </select>
         </div>
         <input type="text" id="modelSn" name="modelSn">
         <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label fs-6"> متن   </label>
            <textarea class="form-control" id="smsText" rows="5" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">  بستن  </button>
        <button type="button" id="sendSMSBtn" class="btn btn-success btn-sm"> ارسال </button>
      </div>
    </div>
  </div>
</div>
<script>
	$("#sendIdividuallyBtn").on("click",()=>{
		$.get("https://starfoods.ir/getSMSModel",{modelSn:$("#selectedSMSModel").val()},(data,status)=>{
			let firstNLine="";
			let secondNLine="";
			let thirdNLine="";
			let fourthNLine="";
			let fivethNLine="";
			let sixthNLine="";
			let thirdCurrency="";
			let firstCurrency="";
			let secondCurrency="";
			let fourthCurrency="";
			let fifthCurrency="";
			let sixthCurrency="";

			if(data[0].FstNLine=="on"){
				 firstNLine="\n";
			}

			if(data[0].SecNLine=="on"){
				 secondNLine="\n";
			}
            
			if(data[0].ThirdNLine=="on"){
				 thirdNLine="\n";
			}
			if(data[0].FourNLine=="on"){
				 fourthNLine="\n";
			}
			if(data[0].FiveNLine=="on"){
				 fivethNLine="\n";
			}
			if(data[0].SixNLine=="on"){
				 sixthNLine="\n";
			}
			if(data[0].ThirdCurrency=="on"){
				thirdCurrency=" ریال ";
			}
			if(data[0].FstCurrency=="on"){
				firstCurrency=" ریال ";
			}
			if(data[0].SecCurrency=="on"){
				secondCurrency="ریال";
			}
			if(data[0].FourCurrency=="on"){
				fourthCurrency=" ریال ";
			}
			if(data[0].FiveCurrency=="on"){
				fifthCurrency=" ریال ";
			}
			if(data[0].SixCurrency=="on"){
				sixthCurrency=" ریال ";
			}
			textContent=data[0].FstText+" "+data[0].FstSelect+" "+firstCurrency+" "+firstNLine+" "+
				data[0].SecText+" "+data[0].SecSelect+" "+secondCurrency+" "+secondNLine+" "+
				data[0].ThirdText+" "+data[0].ThirdSelect+" "+thirdCurrency+" "+thirdNLine+" "+
				data[0].FourText+" "+data[0].FourSelect+" "+fourthCurrency+" "+fourthNLine+" "+
				data[0].FiveText+" "+data[0].FiveSelect+" "+fifthCurrency+" "+fivethNLine+" "+
				data[0].SixText+" "+data[0].SixSelect+" "+sixthCurrency+" "+sixthNLine+" "+
				data[0].SevenText;
			$("#modelSn").val($("#selectedSMSModel").val());
			$("#smsText").val(textContent);
			  });
	});
	var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $("#sendSMSBtn").on("click",function(){
        var customerListID = [];
		let modelSn=$("#modelSn").val();
        var textContent="";
        $('input[name="addCustomerToNotify[]"]:checked').map(function () {
            customerListID.push($(this).val());
        });
		
		$.get("https://starfoods.ir/getSMSModel",{modelSn:$("#selectedSMSModel").val()},(data,status)=>{
			let firstNLine="\n";
			let secondNLine="\n";
			let thirdNLine="\n";
			let fourthNLine="\n";
			let fivethNLine="\n";
			let sixthNLine="\n";
			let thirdCurrency="";
			let firstCurrency="";
			let secondCurrency="";
			let fourthCurrency="";
			let fifthCurrency="";
			let sixthCurrency="";
			if(data[0].FstNLine=="on"){
				 firstNLine="\n";
			}
			if(data[0].SecNLine=="on"){
				 secondNLine="\n";
			}
			if(data[0].ThirdNLine=="on"){
				 thirdNLine="\n";
			}
			if(data[0].FourNLine=="on"){
				 fourthNLine="\n";
			}
			if(data[0].FiveNLine=="on"){
				 fivethNLine="\n";
			}
			if(data[0].SixNLine=="on"){
				 sixthNLine="\n";
			}
			if(data[0].ThirdCurrency=="on"){
				thirdCurrency=" ریال ";
			}
			if(data[0].FstCurrency=="on"){
				firstCurrency=" ریال ";
			}
			if(data[0].SecCurrency=="on"){
				secondCurrency="ریال";
			}
			if(data[0].FourCurrency=="on"){
				fourthCurrency=" ریال ";
			}
			if(data[0].FiveCurrency=="on"){
				fifthCurrency=" ریال ";
			}
			if(data[0].SixCurrency=="on"){
				sixthCurrency="ریال";
			}
			textContent=data[0].FstText+" "+data[0].FstSelect+" "+firstCurrency+" "+firstNLine+" "+
				data[0].SecText+" "+data[0].SecSelect+" "+secondCurrency+" "+secondNLine+" "+
				data[0].ThirdText+" "+data[0].ThirdSelect+" "+thirdCurrency+" "+thirdNLine+" "+
				data[0].FourText+" "+data[0].FourSelect+" "+fourthCurrency+" "+fourthNLine+" "+
				data[0].FiveText+" "+data[0].FiveSelect+" "+fifthCurrency+" "+fivethNLine+" "+
				data[0].SixText+" "+data[0].SixSelect+" "+sixthCurrency+" "+sixthNLine+" "+
				data[0].SevenText;
		});
        $.get("https://starfoods.ir/sendSMSModel",
			  {_token: csrf,customerIDs:customerListID,modelSn:$("#selectedSMSModel").val()},
			  (response,status)=>{
            	if(response=="done"){
					$("#sendDiscounModal").modal("hide");
					$("#addedCustomes").empty();
					$("#customerList").empty();
					swal("Oke!", "ارسال پیام با موفقیت انجام شد!.", "success");
				}
        	});
		});
	
	function getSMSCustomers(element,modelSn,sabtDate){
		$("tr").removeClass("selected");
    	$(element).addClass("selected");
		$.get("https://starfoods.ir/getCustomerSMS",{modelSn:modelSn,sabtDate:''+sabtDate+''},(respond,status)=>{
			$("#sentMessageCustomers").empty();
			let i=1;
		for(let element of respond){
			
			$("#sentMessageCustomers").append(`<tr>
													<td> `+(i++)+` </td>
													<td> `+element.hijriDate+` </td>
													<td> `+element.Name+` </td>
													<td> ${element.Code} </td>
													<td> ${((element.ResponseCode).length>14 ? 'موفق' : 'ناموفق')} </td>
													 <td> ${(element.isUsed==1 ? 'استفاده کرده' : 'استفاده نکرده')} </td>
												 </tr>`);
		console.log(element.Name);
		}
		});
	}
</script>
@endsection