@extends('layout.layout');
@section('content');

<link rel="stylesheet" type="text/css" href="{{url('/resources/assets/lottery/lotteryStyle.css')}}" />

<style>
    #chechIcon {
        display:none;
    }

  .lucky-wheel{
    box-shadow: 0px 0px 4px 0px red inset !important;
    border-radius: 8px;
  }
</style>

 <div class="container topDistance">

 <div class="row my-3">
        <div class="col-lg-12" id='get-credit'>
            <h5 class='mx-3'>شیوه‌ی کسب ستاره از هرکدام از این فعالیت‌ها به شرح زیر است</h5>
             <div class="row mt-2">
                <div class="col-lg-12">
                        <h6 class="me-4"> <i class="fa-solid fa-square-1 text-danger"></i>  خرید از استار فود  </h6>
                        <p class="credit-info me-4">
                        با هر خریدی که از استار فود انجام می‌دهید، به ازای مبلغ و اقلام خریداری شده، ستاره دریافت می‌کنید.
                        </p>
                </div>

                <div class="col-lg-12">
                        <h6 class="me-4"> <i class="fa-solid fa-square-2 text-danger"></i>  شرکت در ستاره استار فود </h6>
                        <p class="credit-info me-4">
                        برای دریافت تعداد بیشتری ستاره، به مدت 7 روز متوالی در استار فود فعالیت کنید و سر بزنید.
                        </p>
                </div>

                <div class="col-lg-12">
                      <h6 class="me-4"> <i class="fa-solid fa-square-3 text-danger"></i>  استفاده از ستاره استار فود  </h6>
                      <p class="credit-info me-4">
                      با جمع آوری هر 500 ستاره، شما در قرعه‌کشی لاتاری شرکت می‌کنید و جوایز خود را با اولین خرید خود دریافت می‌کنید.
                      </p>
                      <p class="credit-info me-4">
                      از این مکانیزم استاره در استار فود بهره‌برداری کنید تا با خرید، شرکت مداوم و جمع آوری ستاره‌ها، به جوایز و مزایای منحصر به فرد دست پیدا کنید.
                      </p>
                </div>
             </div>
        
            <div class="your-star p-3">
                <img style="width:166px" src="{{url('resources/assets/images/siteImage/your-star.png')}}" alt="star" class="">
                <div class="your-star-text" id="allBonusDiv"> {{$allBonus}} <br> ستاره شما  </div>
            </div>
        </div>
      </div>
  
     <div class="row p-3 lucky-wheel">
          <div id="jquery-script-menu" style="marging-top:50px;">
            <div class="mainbox" id="mainbox">
              <div class="box boxBorder" id="box">
                <div class="box1">
                  @if(strlen(trim($products[0]->firstPrize))>0)
                    <span class="font span1"><b> {{$products[0]->firstPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->secondPrize))>0)
                    <span class="font span2"><b>{{$products[0]->secondPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->thirdPrize))>0)
                    <span class="font span3"><b>  {{$products[0]->thirdPrize}} </b></span>
                  @endif
                  @if(strlen(trim($products[0]->fourthPrize))>0)
                    <span class="font span4"><b> {{$products[0]->fourthPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->fifthPrize))>0)
                    <span class="font span5"> <b> {{$products[0]->fifthPrize}} </b> </span>
                  @endif
                  @if(strlen(trim($products[0]->fourteenthPrize))>0)
                    <span class="font span6"> <b> {{$products[0]->fourteenthPrize}} </b> </span>
                  @endif
                  @if(strlen(trim($products[0]->fifteenthPrize))>0)
                    <span class="font span7"> <b> {{$products[0]->fifteenthPrize}} </b> </span>
                  @endif
                  @if(strlen(trim($products[0]->sixteenthPrize))>0)
                    <span class="font span1"> <b> {{$products[0]->sixteenthPrize}} </b> </span>
                  @endif
                </div>
                <div class="box2">
                  @if(strlen(trim($products[0]->sixthPrize))>0)
                    <span class="font span1"><b>{{$products[0]->sixthPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->seventhPrize))>0)
                    <span class="font span2"><b>{{$products[0]->seventhPrize}}</b> </span>
                  @endif
                  @if(strlen(trim($products[0]->eightthPrize))>0)
                    <span class="font span3"> <b>{{$products[0]->eightthPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->ninethPrize))>0)
                    <span class="font span4"> <b>{{$products[0]->ninethPrize}}</b></span>
                  @endif
                  @if(strlen(trim($products[0]->teenthPrize))>0)
                    <span class="font span5"> <b> {{$products[0]->teenthPrize}}</b> </span>
                  @endif
                  @if(strlen(trim($products[0]->eleventhPrize))>0)
                    <span class="font span6"> <b> {{$products[0]->eleventhPrize}}</b> </span>
                  @endif
                  @if(strlen(trim($products[0]->twelvthPrize))>0)
                    <span class="font span7"> <b> {{$products[0]->twelvthPrize}}</b> </span>
                  @endif
                  @if(strlen(trim($products[0]->therteenthPrize))>0)
                    <span class="font span8"> <b> {{$products[0]->therteenthPrize}}</b> </span>
                  @endif
                </div>
              </div>
              <button class="spin" id="spinnerBtn" @if($allBonus >= $lotteryMinBonus) onclick="spin()" @endif>  چرخش   </button>
            </div>
            <audio controls="controls" id="applause" src="{{url('/resources/assets/lottery/applause.mp3')}}" type="audio/mp3"></audio>
            <audio controls="controls" id="wheel" src="{{url('/resources/assets/lottery/wheel.mp3')}}" type="audio/mp3"></audio>
          </div>
      </div>
</section>

<section class="weekly-calendar-container my-3" id="weely-calendar">
     <div class="row">
        <div class="col-lg-12 p-4">
            <h3 class='dialy-credit'>  امتیاز روزانه </h3>
        </div>
     </div>
     
    <div class="weekly-calendar">

	<?php
		$isPresentToday="display:none";
        $isPresent=0;
		$isNotPresentToday="display:block";
		$isPresentOtherday="display:none";
		$isNotPresentOtherday="display:block";

		$today="FirstPr";
		$bonus=5;
		for($i=0 ;$i<=6;$i++){
			$dayNumber=$i+1;
			$currentDay=0;
			switch($i){
				case 0: $currentDay="First";
					break;
				case 1: $currentDay="Second";
					break;
				case 2: $currentDay="Third";
					break;
				case 3: $currentDay="Fourth";
					break;
				case 4: $currentDay="Fifth";
					break;
				case 5: $currentDay="Sixth";
					break;
				case 6: $currentDay="Seventh";
					break;
			}
			
			if($i<=2){
				$bonus=5;
			}elseif($i>2 and $i<5){
				$bonus=10;
			}elseif($i==5){
				$bonus=15;
			}else{
				$bonus=20;
			}
			$y= $currentDay."Pr";
			if(count($presentInfo)>0){
			if(date($presentInfo[0]->$currentDay)== date("Y-m-d")){
				if($presentInfo[0]->$y==1){
						$today=$y;
						$isPresentToday="display:block";
						$isPresent=1;
						$isNotPresentToday="display:none";
				}
	  	echo'
        <div class="week-day"> 
            <div class="day-content curren-day">
                    <div class="top"> '.$bonus.' </div>
                    <div class="daily-bottom">
                        <i class="fas fa-calendar-check fa-lg text-success" style="font-size: 33px; padding-top: 25px; '.$isPresentToday.'" id="chechIcon"></i>
                        <i class="far fa-calendar-times fa-lg text-danger crossIcon" style="font-size: 33px; padding-top: 25px; '.$isNotPresentToday.'" id="crossIcon" onclick="checkCheckboxPresent()"></i> 
                        <input class="form-check-input" style="display:none" type="checkbox" value="'.$y.'_'.$currentDay.'" id="checkDay">
                    </div>
            </div>
            <p class="day-label"> امروز </p>
        </div>';
		 }else{
				$x= $currentDay."Pr";
				if($presentInfo[0]->$x==1){
						$isPresentOtherday="display:block";
						$isNotPresentOtherday="display:none";
				}else{
						$isPresentOtherday="display:none";
						$isNotPresentOtherday="display:block";
				}
       echo'<div class="week-day"> 
            <div class="day-content">
                    <div class="top"> '.$bonus.' </div>
                    <div class="daily-bottom">
                        <i class="fas fa-calendar-check fa-lg text-success"  style="font-size: 33px; padding-top: 25px; '.$isPresentOtherday.'" ></i>
                        <i class="far fa-calendar-times fa-lg text-danger" style="font-size: 33px; padding-top: 25px; '.$isNotPresentOtherday.'"></i> 
                        <input class="form-check-input" style="display:none" type="checkbox" value="" id="">
                    </div>
            </div>
            <p class="day-label"> روز '.$dayNumber.'  </p>
        </div>';
		  	}
		   }else{
				 echo'<div class="week-day"> 
                 <div class="day-content">
                    <div class="top"> '.$bonus.' </div>
                    <div class="daily-bottom">
                        <i class="fas fa-calendar-check fa-lg text-success"  style="'.$isPresentOtherday.'" ></i>
                        <i class="far fa-calendar-times fa-lg text-danger" style="'.$isNotPresentOtherday.'"></i> 
                        <input class="form-check-input" style="display:none" type="checkbox" value="" id="">
                    </div>
                </div>
                 <p class="day-label"> روز '.$dayNumber.'  </p>
            </div>';	
			}
		}
		?> 
    </div>

    <div class="row">
        <div class="col-lg-12 p-2 text-center">
            <p> هفت روز پشت سر هم مراجعه کنید و ستاره های بیشتری را به دست آورید! جایزه‌های ارزشمندی را برای شما در نظر داریم! </p>
			    @if($isPresent==0)
                <button class="btn btn-info"  onclick="checkCheckboxPresent()"> دریافت امتیاز </button>
            @else
                <button class="btn btn-info"> امتیاز امروز دریافت شد </button>
            @endif
        </div>
     </div>
</section> 


		@if(showEnamad("enamadOther")==1)
		   <div class="container">
			   <div class="row mb-4"> 
				   <div class="col-lg-4 col-md-4 col-sm-4"> </div>
					<div class="col-lg-4 col-md-4 col-sm-4 about-img">
					<a referrerpolicy="origin" href="https://trustseal.enamad.ir/?id=220841&amp;code=dgsiolxgvdofskzzy34r">
						<img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=220841&amp;Code=dGSIolXgVdoFskzzY34R"
							 alt="" style="cursor:pointer" id="dGSIolXgVdoFskzzY34R">
					</a>
					<img referrerpolicy='origin' id='nbqewlaosizpjzpefukzrgvj'
						 style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=249763&p=uiwkaodspfvljyoegvkaxlao",
				"Popup", "toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
						 alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=249763&p=odrfshwlbsiyyndtwlbqqfti' />
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4"> </div>
				</div> 
			</div>
		 @endif


<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        const backdrop = document.querySelector('.menuBackdrop');
        document.getElementById("mySidenav").style.width = "0";
        backdrop.classList.remove('show');
    }

//برای لاتری استفاده می شوند.

  function shuffle(array) {
    var currentIndex = array.length,
      randomIndex;
  
    // While there remain elements to shuffle...
    while (0 !== currentIndex) {
      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;
  
      // And swap it with the current element.
      [array[currentIndex], array[randomIndex]] = [
        array[randomIndex],
        array[currentIndex],
      ];
    }
    return array;
  }
  let remainedBonus={{$allBonus}}
  function spin() {
    // Play the sound

    wheel.play();
    // Inisialisasi variabel
    const box = document.getElementById("box");
    const element = document.getElementById("mainbox");
    let SelectedItem = "";

    // Shuffle 450 karena class box1 sudah ditambah 90 derajat diawal. minus 40 per item agar posisi panah pas ditengah.
    // Setiap item memiliki 12.5% kemenangan kecuali item sepeda yang hanya memiliki sekitar 4% peluang untuk menang.
    // Item berupa ipad dan samsung tab tidak akan pernah menang.
    // let Sepeda = shuffle([2210]); //Kemungkinan : 33% atau 1/3

    let FirstPrize= shuffle([(0)]) ;
    let secondPrize= shuffle([(0)]) ;
    let thirdPrize= shuffle([(0)]) ;
    let fourthPrize= shuffle([(0)]) ;
    let fifthPrize= shuffle([(0)]) ;
    let sixthPrize= shuffle([(0)]) ;
    let seventhPrize= shuffle([(0)]) ;
    let eightPrize= shuffle([(0)]) ;
    let ninthPrize= shuffle([(0)]) ;
    let teenthPrize= shuffle([(0)]) ;
    let eleventhPrize= shuffle([(0)]) ;
    let twelvthPrize= shuffle([(0)]) ;
    let therteenthPrize= shuffle([(0)]) ;
    let fourteenthPrize= shuffle([(0)]) ;
    let fifteenthPrize= shuffle([(0)]) ;
    let sixteenthPrize= shuffle([(0)]) ;

    if({{$products[0]->showfirstPrize}} ==1){
     FirstPrize = shuffle([(3766)]);
    }
    if({{$products[0]->showsecondPrize}} ==1){
     secondPrize = shuffle([(3730)]);
    }
    if({{$products[0]->showthirdPrize}} ==1){
     thirdPrize = shuffle([(3682)]);
    }    
    if({{$products[0]->showfourthPrize}} ==1){
     fourthPrize = shuffle([(3643)]);
    }    
    if({{$products[0]->showfifthPrize}} ==1){
     fifthPrize = shuffle([(3610)]);
    }    
    if({{$products[0]->showsixthPrize}} ==1){
     sixthPrize = shuffle([(3579)]);
    }    
    if({{$products[0]->showseventhPrize}} ==1){
     seventhPrize = shuffle([(3545)]);
    }    
    if({{$products[0]->showeightthPrize}} ==1){
     eightPrize = shuffle([(3510)]);
    }
    if({{$products[0]->showninethPrize}} ==1){
     ninthPrize = shuffle([(3466)]);
    }
    if({{$products[0]->showteenthPrize}} ==1){
     teenthPrize = shuffle([(3433)]);
    }
    if({{$products[0]->showeleventhPrize}} ==1){
     eleventhPrize = shuffle([(0)]);
    }
    if({{$products[0]->showtwelvthPrize}} ==1){
     twelvthPrize = shuffle([(0)]);
    }
    if({{$products[0]->showtherteenthPrize}} ==1){
     therteenthPrize = shuffle([(0)]);
    }
    if({{$products[0]->showfourteenthPrize}} ==1){
     fourteenthPrize = shuffle([(0)]);
    }
    if({{$products[0]->showfifteenthPrize}} ==1){
     fifteenthPrize = shuffle([(0)]);
    }
    if({{$products[0]->showsixteenthPrize}} ==1){
     sixteenthPrize = shuffle([(0)]);
    }


    // Bentuk acak
    let Hasil=[];
    let primaryPrizeList = shuffle([
      FirstPrize[0],
      secondPrize[0],
      thirdPrize[0],
      fourthPrize[0],
      fifthPrize[0],
      sixthPrize[0],
      seventhPrize[0],
      eightPrize[0],
      ninthPrize[0],
      teenthPrize[0],
      eleventhPrize[0],
      twelvthPrize[0],
      therteenthPrize[0],
      fourteenthPrize[0],
      fifteenthPrize[0],
      sixteenthPrize[0]
    ]);

    primaryPrizeList.forEach((element)=>{
      if(element>0){
        Hasil.push(element);
      }

    })
    // console.log(Hasil[0]);
  
    // Ambil value item yang terpilih
    if (FirstPrize.includes(Hasil[0]))  SelectedItem ="{{$products[0]->firstPrize}}";
    if (secondPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->secondPrize}}";
    if (thirdPrize.includes(Hasil[0]))  SelectedItem = "{{$products[0]->thirdPrize}}";
    if (fourthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->fourthPrize}}";
    if (fifthPrize.includes(Hasil[0]))  SelectedItem = "{{$products[0]->fifthPrize}}";
    if (sixthPrize.includes(Hasil[0]))  SelectedItem = "{{$products[0]->sixthPrize}}";
    if (seventhPrize.includes(Hasil[0]))SelectedItem = "{{$products[0]->seventhPrize}}";
    if (eightPrize.includes(Hasil[0]))  SelectedItem = "{{$products[0]->eightthPrize}}";
    if (ninthPrize.includes(Hasil[0]))  SelectedItem = "{{$products[0]->ninethPrize}}";
    if (teenthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->teenthPrize}}";
    if (eleventhPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->eleventhPrize}}";
    if (twelvthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->twelvthPrize}}";
    if (therteenthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->therteenthPrize}}";
    if (fourteenthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->fourteenthPrize}}";
    if (fifteenthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->fifteenthPrize}}";
    if (sixteenthPrize.includes(Hasil[0])) SelectedItem = "{{$products[0]->sixteenthPrize}}";
    box.style.setProperty("transition", "all ease 5s");

    box.style.transform = "rotate(" + Hasil[0]+ "deg)";

    element.classList.remove("animate");

    setTimeout(function () {

      element.classList.add("animate");

    }, 500);
  
    // Munculkan Alert
    setTimeout(function () {
      applause.play();
      swal(
        "تبریک",
        " شما برنده ای " +SelectedItem+ "شده اید",
        "success"
      );
      //برای ثبت تاریخچه
      $.ajax({
        method: 'get',
        url: "/setCustomerLotteryHistory",
        data: {
            _token: "{{csrf_token()}}",
            customerId: {{Session::get('psn')}},
            product:SelectedItem
        },
        async: true,
        success: function(data) {
		
          remainedBonus -= 500;

          if(remainedBonus<500){
        
            $("#spinnerBtn").prop("disabled",true);

          }
		
			$("#allBonusDiv").text(remainedBonus);
		
        },
        error:function(errer){

        }
    });
    }, 5500);
  
    // Delay and set to normal state
    setTimeout(function () {
      box.style.setProperty("transition", "initial");
      box.style.transform = "rotate(90deg)";
    }, 6000);


  }
</script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      
      <!-- <script src="{{url('/resources/assets/lottery/lotteryScript.js')}}"></script> -->
     
      <script type="text/javascript">
           var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);
  
    (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
         ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  

  try {
    fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
      return true;
    }).catch(function(e) {
      var carbonScript = document.createElement("script");
      carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
      carbonScript.id = "_carbonads_js";
      document.getElementById("carbon-block").appendChild(carbonScript);
    });
  } catch (error) {
    console.log(error);
  }
		  
$("#useLuckyWheel").on("click", ()=> {
	$("#luckyWheel").css("display","flex");
})

</script>
<script src="{{ url('/resources/assets/js/frontJs/discount.js')}}"></script>
@endsection