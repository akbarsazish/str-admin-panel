@extends('layout.layout')
@section('content')
    <div class="container topDistance">
        <div class="row fw-bold"> <span>گیرنده :{{Session::get('username')}}</span> </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
            <form method="post" action="{{url('/addOrder')}}" onSubmit="chekForm(event)">
                  @csrf
                   <div class="row">
                        <div class="col-lg-6 col-md-6">
                              <div class="grid-container-shipping">
                                <div class="grid-item-shipping">
                                        @if ($setting->firstDayMoorningActive==1 or $setting->firstDayAfternoonActive==1)
                                            <div class="p-3 rounded-2">
                                                <label class="c-checkou fw-bold" style="font-size:16px;">{{$date1}}</label>
                                            </div>
                                        @endif
                                </div> 
                                <div class="grid-item-shipping">
                                  @if ($setting->firstDayMoorningActive!=0)
                                        <label id="ns2" class="w-100 mt-1">
                                            <span class="c-ui-radio" >
                                                <input class="d-inline-flex shipp-radio" type="radio" id="DAY1M" onchange="clearFaveDate();enableHozoori();" name="recivedTime"  value="{{'1,'.$tomorrowDate}}">
                                                <span id="Radio1" name="Radio1 " class="c-ui-radio__check d-inline-flex"></span>
                                            </span>
                                            <span class="c-checkout-paymethod__source-title fw-bold d-inline-flex " style="font-size: 14px; margin-right:10px;">{{$setting->moorningTimeContent}}</span> &nbsp; &nbsp;
                                            <i class="fas fa-sun fa-xl" style="color:#eb9221"> </i>
                                        </label>
                                    @endif
                                     @if ($setting->firstDayAfternoonActive!=0)
                                        <label id="na1" class="is-selected w-100">
                                            <div class=" mt-0 pt-0" @if ($setting->firstDayAfternoonActive==0) style="display: none" @endif>
                                                <span class="c-ui-radio d-inline-flex ">
                                                    <input class="d-inline-flex shipp-radio" type="radio" id="DAY1A" onchange="clearFaveDate();enableHozoori()" name="recivedTime" value="{{'2,'.$tomorrowDate}}">
                                                    <span id="Radio2" name="Radio1" class="c-ui-radio__check d-inline-flex"> </span>
                                                </span>
                                                <span class="c-checkout-paymethod__source-title fw-bold d-inline-flex" style="font-size: 14px; margin-right:6px;"> {{$setting->afternoonTimeContent}} </span> &nbsp; &nbsp;
                                                &nbsp;<i class="fas fa-moon fa-xl" style="color:green"> </i>
                                            </div>
                                        </label>
                                 @endif
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-6 col-md-6">
                       <div class="grid-container-shipping">
                            <div class="grid-item-shipping">
								@if ($setting->secondDayMoorningActive==1 or $setting->secondDayAfternoonActive==1)
									<div class="p-3 rounded-2">
										<label class=" c-checkou fw-bold" style="font-size:16px;">{{$date2}}</label>
									</div>
								@endif
                            </div>
                            <div class="grid-item-shipping">
                                @if ($setting->secondDayMoorningActive!=0)
									<label id="ns2" class="w-100 mt-2">
										<span class="c-ui-radio" >
											<input id="DAY2M"  onchange="clearFaveDate();enableHozoori();" class="d-inline-flex shipp-radio" type="radio" name="recivedTime"  value="{{'1,'.$afterTomorrowDate}}">
											<span id="Radio1" name="Radio1 " class="c-ui-radio__check d-inline-flex "></span>
										</span>
										<span class="c-checkout-paymethod__source-title fw-bold d-inline-flex " style="font-size: 14px; margin-right:10px;">{{$setting->moorningTimeContent}}</span> &nbsp; &nbsp;
										<i class="fas fa-sun fa-xl" style="color:#eb9221;"></i>
									</label>
                                @endif
                                @if ($setting->secondDayAfternoonActive!=0)
                                    <label id="ns2" class="is-selected w-100">
                                        <div class=" mt-0 pt-0" >
                                            <span class="c-ui-radio d-inline-flex ">
                                                <input class="d-inline-flex shipp-radio" id="DAY2A"  onchange="clearFaveDate();enableHozoori()" type="radio" name="recivedTime"  value="{{'2,'.$afterTomorrowDate}}">
                                                <span id="Radio2" name="Radio1" class="c-ui-radio__check d-inline-flex"> </span>
                                            </span>
                                            <span class="c-checkout-paymethod__source-title fw-bold d-inline-flex" style="font-size: 14px; margin-right:6px;">{{$setting->afternoonTimeContent}} </span> &nbsp; &nbsp;
                                            <i class="fas fa-moon fa-xl" style="color:green;"> </i>
                                        </div>
                                    </label>
                                @endif
                            </div>
                        </div>
                     </div>
                    </div>
              
                  <div class="row">
                        <div class="col-lg-6 col-md-6">
                              <div class="select-address">
                                 @if ($setting->FavoriteDateMoorningActive!=0 or $setting->FavoriteDateAfternoonActive!=0)
                                    <div class="p-1 select-add1">
                                        <label class="rounded-2 c-checkou fw-bold" style="font-size:14px;">تاریخ دلخواه </label>
                                    </div>
                                     <div class="select-add2">
                                        <input type="text" class="form-control" autocomplete="off" name="delkhahDate" id="favDate"/>
                                        <span style="display:none;"> <input class="d-inline-flex" id="delkhah" type="radio" name="recivedTime"  value=""></span>
                                     </div>
                                 @endif
                               </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="select-address">
                                    <div class="p-1 select-add1">
                                        <label class="rounded-2 c-checkou fw-bold" style="font-size:14px;"> انتخاب آدرس </label>
                                    </div>
                                    <div class="select-add2">
                                        @if(count($addresses)>0)
                                                <select name="customerAddress" class="form-select" >
                                                    <option value="{{$customer->peopeladdress.'_0'}}" style="font-size:12px">{{$customer->peopeladdress}}</option>
                                                    @foreach($addresses as $address)
                                                        <option value="{{$address->AddressPeopel.'_'.$address->SnPeopelAddress}}" style="font-size:12px">{{$address->AddressPeopel}}</option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <select name="customerAddress" class="form-select">
                                                    <option value="{{$customer->peopeladdress.'_0'}}" style="font-size:12px">{{$customer->peopeladdress}}</option>
                                                </select>
                                            @endif
                                    </div>
                                </div>
                        </div>
                   </div>
				@if(date('H:i:s', strtotime(date('Y-m-d H:i:s'))) < $setting->endTimeImediatOrder and date('H:i:s', strtotime(date('Y-m-d H:i:s'))) > $setting->startTimeImediatOrder)
				   <div class="row">
					   <div class="col-lg-6 col-md-6">
                          <div class="select-address">
							<div class="p-1 select-add1">
                               <label class="c-checkou fw-bold" style="font-size:16px;"> ارسال سریع <i class="fas fa-shipping-fast fa-xl text-danger"></i> </label>
						   </div> 
                           <div id="ns2"  class="p-1 select-add2">
								<input class="d-inline" id="imediatRequest" onchange="clearFaveDate();disableHozoori()" type="radio" name="recivedTime" value="{{'3,'.date('Y-m-d H:i:s')}}">
                                <span class="hazinaHaml" id="hazinaHaml" style="color:green;"> هزینه حمل در زمان هماهنگی اعلام می شود  </span>
						  </div>
					   </div>
                   </div>
				 </div>
				@endif
				
				@if(canUseCheque(Session::get("psn"))==1)
				<p></p>
				@endif
                   <div class="row">
                        <div class="col-lg-12 col-md-12">
                         <div class="grid-container-shipping">
                                <div class="grid-item-shipping">
                                    <div class="p-3 rounded-2">
                                        <label class=" fw-bold" style="font-size:16px;"> انتخاب پرداخت</label>
                                    </div>
                                </div>
                            <div class="grid-item-shipping mt-3">
                                    @if($pardakhtLive!=0)
                                        <input id="hozoori" type="radio" class="form-check-input" name="pardakhtType" onchange="chekForm(event)"  style="font-size:18px;">
                                        <label for="hozoori" style="font-size: 16px;">  حضوری 
                                        <i class="fas fa-truck fa-xl pe-1 text-danger"> </i>  </label> 
                                    @endif
                            </div>
                            <div class="grid-item-shipping mt-3">
                                   <input id="bankPayment" type="radio"  onchange="chekForm(event)" class="form-check-input" name="pardakhtType" style="font-size:18px;"> 
                                    <label for="bankPayment" style="font-size: 16px;">
                                      اینترنتی 
                                        <i class="fas fa-credit-card fa-xl pe-1 text-danger"></i>
                                   </label>
                            </div>
                           </div>
                           </div>
                        </div>
                   </div>
                   <div class="row" style="margin: 0 auto; text-align:center; justify-content:center;">
                        <div class="col-lg-12 col-md-12 px-0" >
                         <div class="grid-container-shipping1"> 
                            <div class="grid-item-shipping text-center">
                                <ul class="c-checkout-summary__summary mb-0">
                                    <li>
                                        <span> قیمت کالاها </span>
                                        <span> {{number_format($allMoney+$profit)}} {{$currencyName}} </span>
                                    </li>
                                    <input type="text" name="takhfif" id="takhfif" value="0" style="display: none;">
                                    <input type="text" name="takhfifCodeMoneyAmount" value="0" id="takhfifCodeMoneyAmount" style="display: none;">
                                    @if($takhfifCase >0 )
                                        <li class="c-checkout-summary__discount">
                                            <span> کیف تخفیف </span>

                                            <span class="form-check form-switch">
                                                <input class="form-check-input" style="width:38px; height:18px;"  type="checkbox" value="{{$takhfifCase/10}}" role="switch" onchange="changePayMoneyAndTakhfif()" id="discountWallet"/>
                                                <label class="form-check-label fw-bold text-danger" for="switchCheckChecked">&nbsp;  {{number_format($takhfifCase/10)}} {{$currencyName}}</label>
                                            </span>
                                        </li>
                                    @endif
                                    <li class="c-checkout-summary__discount">
                                        <span> تخفیف کالاها </span>
                                        <span class="discount-price">{{number_format($profit)}} {{$currencyName}}</span>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="checkTakhfifCodeState(document.querySelector('#takhfifInput'),document.querySelector('#takhfifInput').value)" data-toggle="modal" data-target="#discountCode"> کد تخفیف </button class="btn btn-danger">
                                        <div>
                                            <span class="discount-price" id="takhfifCodeMoney">0</span>
										    <span class="fw-bold text-danger"> {{$currencyName}}</span>
										</div>
                                    </li>
                                    <li>
                                    <span> مبلغ قابل پرداخت </span>
                                    <div> 
                                        <span class="fw-bold text-danger" style="font-size:16px;"  id="payableMoney"> {{number_format($allMoney)}} </span> 
                                        <span class="fw-bold text-danger" style="font-size:16px;"> {{$currencyName}}</span> 
                                    </div>
                                    </li>
									<li class="c-checkout-summary__discount">
									    <div class="free-dlivery rounded"> 
											<p class="dliver-text">هزینه‌ای بسته بندی و حمل: <strong class="text-info">رایگان</strong></p>
										</div>
									</li>
                                </ul>
                          </div>
                          <div class="grid-item-shipping">
                            <input type="text" value="{{$allMoney}}" id="allMoneyToSend" name="allMoney" style="display:none;"/>
                            <input type="text" value="{{$allMoney}}" id="netAllMoney" style="display:none;"/>
							<input type="hidden" id="takhfifCodeToSend" name="takhfifCode"/>
                            <button type="submit"  class="btn buttonContinue" style="float:left;" id="sendFactorSumbit">  
								<i class="fa fa-check" aria-hidden="true"></i>ارسال فاکتور
							</button>
	
                            <a href="{{url('/starfoodFrom')}}"><button type="button" onclick="chekForm(event)" class="btn buttonContinue" style="float:left;display:none" id="showPaymentForm">  <i class="fa fa-check" aria-hidden="true"></i>پرداخت و ارسال فاکتور</button></a>
                            </div>
                         </div>
                     </div>
                  </div>
                </div>
            </form>
        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="discountCode" tabindex="-1" aria-labelledby="discountCodeLabel" aria-hidden="true" style="overflow: hidden; max-height: 100vh;">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header py-2 px-4 bg-danger text-white">
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="discountCodeLabel"> کد تخفیف </h5>
      </div>
      <div class="modal-body p-4">

        <div class="row p-4">
             <div class="col-lg-4 col-12 text-end">
             </div>
             <div class="col-lg-4 col-12 text-center pt-2">
                 <h2> <i class="fa fa-percent text-danger"></i> کد تخفیف  <i class="fa fa-percent text-danger"></i>  </h2>
             </div>
             <div class="col-lg-4 col-12 text-start">
             </div>
        </div>
         <div class="row">
              <div class="col-lg-12"> 
                   <h6> آیا کد تخفیفی برای استفاده در این خرید دارید؟ </h6>
                   <p>  لطفاً کد تخفیف خود را وارد کنید تا بتوانیم آن را روی مجموعه خرید شما اعمال کنیم. </p>
                    <span class="fw-bold">
                   <div class="discount-input px-1">
                       <input id="takhfifInput" type="text" name="takhfifCode"
						onchange="checkTakhfifCodeState(this,this.value,Session::get('psn'))"
						class="form-control form-control-sm dis-input p-3"
						placeholder="کد تخفیف">
                       <label for="stuff" class="fa fa-percent input-icon"></label>
                   </div>
                    <span id="takhfifCodeStateAlert" style="font-size:16px;"> </span>
              </div>
         </div>
      </div>
      <div class="modal-footer px-4 py-2">
         <div class="row">
             <div class="col-lg-12"> 
				 <button type="button" id="emalTakhfifCodeBtn" onclick="tasviyehTakhfifCode(this,this.value)" class="btn btn-secondary btn-sm d-block w-100"> اعمال <i class="fa fa-check"></i> </button>
			 </div>
         </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
document.querySelector("#delkhah").style.display = "none";
window.onload=()=>{document.querySelector("#takhfifInput").value=localStorage.getItem("discountCode");}
</script>
@endsection
