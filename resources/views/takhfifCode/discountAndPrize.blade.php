@extends('layout.layout')
@section('content')

<style>
.discount-container{
    display:flex;
    background-color: #ff3154;
    flex-direction: row;
    border-radius: 11px 11px 0px 0px;
    justify-content: space-around;
    margin-bottom:0px;
}

.discount-item {
    max-width: 33%;
    flex:33%;
    cursor:pointer;
}

.discount-text > i {
    font-size:26px;
    color:#fff;
}

.discount-text{
    font-size:14px;
    color:#fff;
    font-weight:bold;
}

.discount-container li.active {
   border-bottom: 2px solid #fff;
}

.dicountAndprizeDiv {
    min-height:66vh;
    border: 1px solid red;
    border-radius: 0px 0px 10px 10px;
}

.prize-top-div {
    display:flex;
    background-color: #fff;
    width:98%;
    margin: 0 auto;
    border-radius: 5px;
}

.prize-top-div > .first {
    width: 6%;
}

.prize-top-div > .second {
   width: 90%;
   padding:5px;
   margin-top: 8px;
}


.remaind-time {
    justify-content: flex-end;
    font-weight:bold;
}

.view-details {
    justify-content: flex-start;
    float:left;
    font-size:12px;
    font-weight:bold;
}

.text-start {
   color:#515151;
}

.prize-exp {
    font-size:12px;
}

.prize-button {
    font-size: 12px !important
}

.for-prize-info {
    display:flex;
    width:98%;
    background-color: #fff;
    justify-content:space-around;
    align-items:center;
    margin: 0 auto;
    border-radius: 5px;
    padding:10px;
}

.priz-btn {
    width: 32%;
    margin: 0 auto;
    text-align:center;
}

.discounts {
    display:flex;
    padding:5px;
    flex-direction: row;
    justify-content: flex-start;
}

.discount-info {
    width: 32%;
    padding: 5px;
    background-color: #f7ece1;
    border-radius:6px;
    border:1px solid red;
	margin:5px;
}

.my-discount-code {
    padding:5px;
    border:1px dotted red;
    border-radius: 5px;
    font-size: 14px;
    font-weight:bold;
    margin: 5px;
}

.copy-code {
    padding:5px 10px;
    background-color:whitesmoke;
    color: red;
    font-weight:bold;
    border-radius: 6px;
}

#coppied {
   position:fixed;
   bottom:10%;
   left:0;
   background-color: #404040;
   border-radius: 5px;
   padding:10px;
   text-align:center;
   display:none;
}

.coppied-code {
    color: white;
}

.recievd-prize-des {
    margin-bottom: 2px;
}

.recieved-prize-item {
    margin:10px;
}

.used-date {
    margin-right:26px;
    font-style:italic;
}

.recieved-prizes {
    width:98%;
    background-color: #fff;
    margin: 0 auto;
}

@media (max-width: 768px) { 
    .prize-top-div {
        width:100%;
        display:flex;
    }

    .prize-top-div > .first {
        width: 15%;
    }

    .prize-top-div > .second {
        width: 82%;
    }

    .for-prize-info {
        width: 100%;
    }

    .discount-info {
        width: 98%;
    }

    .discounts {
        flex-direction: column;
    }
}

</style>

<div class="container topDistance">
    <div class="row text-center">
            <ul class="discount-container tab">
                <li class="discount-item tablinks active" onclick="openCity(event, 'discounts')">
                      <span class="discount-text ">
                         <i class="fa fa-percentage"></i> &nbsp;  تخفیف ها
                      </span>
                    </a>
                </li>
                <li class="discount-item tablinks" onclick="openCity(event, 'prizes')">
                     <span class="discount-text">
                       <i class="fa-solid fa-award"></i> &nbsp;  جایزه ها  
                    </span>
                </li>
            </ul>
    </div>
    <div class="row dicountAndprizeDiv">
       <div class="col-lg-12 tabcontent" id="discounts">
            <div class="discounts card">
				@if(count($disCountCodes) > 0 )
					@foreach($disCountCodes as $code)
						<div class="discount-info">
							<p class="takfif-name"> کد تخفیف {{number_format($code->Money)}} ریالی شما  </p>
							<div class="dicound-code">
								 <span class="my-discount-code" id="textToCopy{{$loop->index}}">  {{$code->Code}} </span>
								 <span class="copy-code" onclick="copyTakhfifCode({{'\'textToCopy'.$loop->index.'\''}})" id="copyButton{{$loop->index}}"> کپی کردن  </span>
							</div>
							<p class="use-day mt-2"> قابل استفاده تا {{\Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse(date('Y-m-d H:i:s',strtotime($code->AssignDate. ' +'.$code->UseDays.' day'))))->format('Y/m/d');}}   </p>
						</div>
					@endforeach
				@else 
				<h2> شما کد تخفیف ندارید </h2>
				@endif
            </div>
         </div>
        <div class="col-lg-12 tabcontent mt-4" id="prizes"  style="display:none;">   

            <div class="recieved-prizes p-3">
                <h4> جایزه های دریافتی </h4>
				<h5> جوایز بازی </h5>
				@if(count($player)>0)
				@foreach($player as $play)
                 <div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
                        <i class="fa-solid fa-square-{{$loop->iteration}} fa-xl text-danger"> </i>  با توجه به اینکه شما برنده بازی بودید، مبلغ {{$play->prize}} هزار تومان به شما تعلق می‌گیرد.
                    </p>
                    <span class="used-date">  تاریخ : {{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$play->timestamp))->format('Y/m/d')}}</span>
                 </div>
				@endforeach
				@else
				<div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
						<i class="fa-solid fa-square-0 fa-xl text-danger"> </i> ندارید
					</p>
				</div>
				@endif
				<h5> جوایز لاتاری </h5>
				@if(count($prizes)>0)
				@foreach($prizes as $prize)
                 <div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
                        <i class="fa-solid fa-square-{{$loop->iteration}} fa-xl text-danger"></i> با توجه به اینکه شما برنده بازی لاتاری شده‌اید، تبریک می‌گویم! 
						{{$prize->wonPrize}}  با اولین خرید خدمت شما.
						 @if($prize->Istaken==1) ارسال شد @else ارسال می شود @endif
                    </p>
                    <span class="used-date"> تاریخ : {{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$prize->lastTryDate))->format('Y/m/d')}}</span>
                 </div>
				
				@endforeach
				@else
				<div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
						<i class="fa-solid fa-square-0 fa-xl text-danger"> </i> ندارید
					</p>
				</div>
				@endif
				<h5>  تخفیف ها </h5>
				@if(count($takhfifCodes)>0)
				@foreach($takhfifCodes as $code)
                 <div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
                        <i class="fa-solid fa-square-{{$loop->iteration}} fa-xl text-danger"></i>  شما جایزه خویش را با استفاده از کد تخفیف {{$code->Code}}  همرا با خرید مبلغ {{number_format($code->Money)}} ریال  @if($code->isUsed==1) دریافت نمودید.  @else  دریافت خواهید کرد. @endif !
                    </p>
                    <span class="used-date"> تاریخ :{{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$code->assignedDate))->format('Y/m/d')}} </span>
                 </div>
				@endforeach
 				@else
				 <div class="recieved-prize-item"> 
                    <p class="recievd-prize-des">
                        <i class="fa-solid fa-square-0 fa-xl text-danger"></i>
                    </p>
                 </div>
				@endif
            </div>
        </div>

        <div class="col-lg-12" id="coppied">
           <span class="coppied-code"> کپی شد!</span>
        </div>
    </div>
   
</div>


<script>
    function openCity(evt, tabId) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.className += " active";
    }


    function copyTakhfifCode(textToCopyId) {
        var text = document.getElementById(""+textToCopyId+"").innerText;

        localStorage.setItem("discountCode", text);
        
        var tempTextArea = document.createElement("textarea");
        tempTextArea.value = text;

        document.body.appendChild(tempTextArea);

        tempTextArea.select();
        document.execCommand("copy");

        document.body.removeChild(tempTextArea);

       let copyCode =  document.getElementById("coppied");
           copyCode.style.display = "block";
            setTimeout(function() {
                copyCode.style.display = "none";
            }, 2000);
    }

</script>

@endsection