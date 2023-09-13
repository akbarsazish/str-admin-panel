@extends('layout.layout')
@section('content')
<style>
.my-discount-code {
    padding:5px;
    border:1px dotted red;
    border-radius: 5px;
    font-size: 14px;
    font-weight:bold;
    margin: 5px;
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

.copyText {
    font-weight:bold;
    font-size:18px;
}
</style>
<div class="container topDistance">
     <div class="row">
        <div class="col-lg-12 invite-code-div">
            <div class="row">
       
            </div>
             <div class="row">
				 <div class="col-lg-7 col-7">   
					 <span class="fs-6"> کد دعوت : </span>
					 <span class="my-discount-code p-1" onclick="copyTakhfifCode()" id="textToCopyId" style="font-family: sans-serif;"> {{$profile->selfIntroCode}} </span > <span class="copyText"> کپی </span> </div>
                <div class="col-lg-5 col-5 text-start">
				   <div class="btn-set" id="device"> </div>
				 </div>
             </div> <hr>
            <p class="paragraph-for-invite">با<span> کلیک</span> روی کد دعوت خود و ارسال آن به همکارانتان، به راحتی می‌توانید از هر مشتری جدیدی که با کد دعوت شما ثبت نام کند، <span class="span-for-p1">مبلغ 40 هزار  تومان</span> به ازای هر یک از همکارانتان که با کد دعوت شما عضو شود، به شما تعلق می‌گیرد ، و  هر کسی که با این کد ثبت نام کند، علاوه بر خرید با کیفیت و اصالت، شما نیز با هر بار خرید همکارانتان، مبلغی از فاکتور آنها به کیف پول شما به عنوان هدیه اضافه می‌شود. </p>
            <p class="paragraph-for-invite"> استار فود بهترین هدیه برای همکارانتان است.<span class="span-for-p2"> ارسال رایگان</span>،<span class="span-for-p1">کیفیت بالا </span>و<span class="span-for-p1"> قیمت مناسب کالا</span>، <span  class="span-for-p1"> و همچنین تنوع بی نظیر محصولات</span>، تنها بخشی از مزایای استار فود است. پس همین حالا شروع کنید! کد دعوت خود را به همه ارسال کنید. </p>
            <p class="paragraph-for-invite"> برای مشاهده اشخاصی که از کد معرف شما استفاده کرده‌اند، به پایین صفحه مراجعه کنید. </p>
            
            <br>
            <h5> اشخاص که از کد دعوت شما استفاده کرده اند </h5>
            <table class="table table-bordered border-info">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> اسم  </th>
                    </tr>
                </thead>
                <tbody>
					@foreach($invitedCustomers as $customer)
						<tr>
						<th> {{$loop->iteration}} </th>
						<td> {{ $customer->Name }} </td>
						</tr>
					@endforeach
                </tbody>
             </table>
        </div>
		  <div class="col-lg-12" id="coppied">
           <span class="coppied-code"> کپی شد!</span>
        </div>
     </div>
</div> 



 <script>
    function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    
        if ( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) { 
        document.getElementsByTagName('body')[0].className+=' ios';
        return ` <a class="button btn btn-danger btn-sm  txt-ios" href="sms:&body=استار فود رو توصیه میکنم! کالاهایی که نیاز داری رو با سرعت و قیمت مناسب و اصالت بخر. ثبت نام رایگان و کیف پول هم داره. از کد دعوت زیر استفاده کن: {{$profile->selfIntroCode}} 
		\n	کلیک نمایید: https://starfoods.ir <br>
			 {{Session::get('username')}}
			"> ارسال
			</a>`; 
        }
            
        else if ( userAgent.match( /Android/i ) ) { 
            document.getElementsByTagName('body')[0].className+=' android';
        return `<a class="button btn btn-danger btn-sm txt-android" href="sms:?body=استار فود رو توصیه میکنم! کالاهایی که نیاز داری رو با سرعت و قیمت مناسب و اصالت بخر. ثبت نام رایگان و کیف پول هم داره. از کد دعوت زیر استفاده کن: {{$profile->selfIntroCode}} 
		\n	کلیک نمایید: https://starfoods.ir \n
			{{Session::get('username')}}
			">
			  ارسال </a>`; 
    }
 
	else { return `<h6 class="text-danger"> برای دعوت دوستان خویش با گوشی وارد شوید! </h6>`; }
}

var deviceType = getMobileOperatingSystem();
document.getElementById("device").innerHTML = deviceType;
	 
	 
   function copyTakhfifCode() {
        var text = document.getElementById("textToCopyId").innerText;
        
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