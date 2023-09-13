<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Javad Akhlaqi & Ali Akbar Sazish">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">
    <title> استار فود</title>
    <link rel="icon" type="image/png" href="{{ url('resources/assets/images/part.png')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/resources/assets/jquery-ui-1.12.1/jquery-ui-1.12.1/jquery-ui.min.css')}}"/>
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/loader.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mediaq.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/framework7.bundle.min.css')}}">
    <link rel="stylesheet" href="{{url('/resources/assets/js/persianDatepicker-master/css/persianDatepicker-default.css')}}" />
    <link rel="stylesheet" href="{{ url('/resources/assets/js/jquery-ui.css')}}"/>
    <script src="{{ url('resources/assets/js/jquery.min.js')}}"></script>
    <script src="{{ url('/resources/assets/js/jquery-ui.min.js')}}"></script>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

	<style>
		.pubSearchItem{
			color:#000 !important;
		}
		.pubSearchItem:hover{
			color:blue !important;
		}

		#searchInputParentDiv{
            position:absolute;
            top:60px;
			border-radius:33px !important;
			padding:5px !important;
            overflow-y: scroll;
            height: 77vh;
            width: 30%;
		}

        @media only screen and (max-width: 920px) { 
            #searchInputParentDiv{
                width: 100%;
                margin: 0 auto;
           }

          #searchInputParentDiv{
             right:0;
		  }
        }

        #ulForSearchResult {
            padding:0px;
            border-radius:8px;
        }

        #searchInputParentDiv::-webkit-scrollbar {
            width: 10px;
            background: gray;
            border-radius: 6px;
            margin-top:22px;
        }
       
	</style>
</head>

<body>
    <div class="bottomNav">
        <a class="footerOptions bottomNav__item"  href="{{url('/allGroups')}}"><i class="fal fa-th"> </i> دسته بندی</a>
        <a class="footerOptions bottomNav__item"  href="{{url('/home')}}"> <i class="far fa-home"></i> صفحه اصلی  </a>

        <a class="footerOptions bottomNav__item"  href="{{url('/carts')}}">
        <i class="fal fa-shopping-cart"></i>
        <span id="basketCountWebBottom" @if($countBoughtAghlam < 1) class="footerBage danger" @else  class="headerNotifications1" @endif>@if($countBoughtAghlam>0){{$countBoughtAghlam}}@else 0 @endif</span> سبد خرید </a>
        
    </div>
    <div class="menuBackdrop" style="z-index:99"></div>
      <header class="px-0 mx-0" style="position:fixed; top:0; left:0; right:0;">
            <section class="topMenu top-head container" style="padding-right: 5px !important; padding-left: 0px !important;">
                <div class="right-head">
                    <div id="mySidenav" class="sidenav" style="width:0px;overflow-x:hidden;margin-left:100px;padding-right:0;">
                        <a href="{{url('/home')}}" class="sidenav__header">
                          <img width="166px" src="{{ url('/resources/assets/images/logomenu.png') }}" /> 
                        </a>
                        <button onclick="closeNav()" class="closeMenuButton"> <i class="fal fa-times fa-lg"></i> </button>
                        <a href="{{url('/profile')}}"> <i class="fal fa-user fa-lg"></i> {{Session::get('username')}} </a>
                        <a href="{{url('/allGroups')}}"> <i class="fal fa-th-large fa-lg"></i> دسته بندی کالا </a>
                        <a href="{{url('/listFavorits')}}"><i class="fal fa-heart-square fa-lg"></i> مورد علاقه ها  </a>
                       
                        <a href="{{url('/messageList')}}"> <i class="far fa-envelope fa-lg"></i>   پیام ها 
                        <span id="replayCountWeb" @if($countNewReplayMessage < 1) class="headerNotifications0 translate-middle badge rounded-pill bg-dark" @else class="headerNotifications1 position-absolute start-200 translate-middle badge rounded-pill bg-dark" @endif>@if($countNewReplayMessage>0){{$countNewReplayMessage}}@else 0 @endif</span>
                        </a>
                        <a href="{{url('/bagCash')}}"> <i class="fal fa-star fa-lg"> </i> ستاره استارفود </a>
                        <a href="{{url('/requestCheck')}}"> <i class="fas fa-money-check fa-lg"> </i> خرید چکی  </a>
                        <a href="{{url('/callUs')}}"> <i class="fal fa-phone-square fa-lg"> </i> تماس با ما  </a>
					   <!-- <a href="{{url('/saveEarth/0')}}"> <i class="fas fa-gamepad fa-lg"> </i> نجات زمین </a> -->
                       <!-- <a href="{{url('/saveEarth/1')}}"><i class="fas fa-hexagon lg"></i> بازی با رنگ  </a> -->
					   <a href="{{url('/saveEarth/2')}}"> <i class="far fa-gopuram lg"></i>  برج سازی  </a>
                        @if($exitAllowance==1)
                        <a href="{{url('/logout')}}" onclick="logout()"><i class="fal fa-sign-out fa-lg "></i> خروج </a>
                        @else
                        @endif
                        <div class="sidenav__socialMedia social-div">
                            <a class="socialMedia" href="https://instagram.com/{{$instagram}}"><i class="fab fa-instagram"></i></a>
                            <a class="socialMedia" href="https://telegram.me/{{$telegram}}"> <i class="fab fa-telegram"></i> </a>
                            <a class="socialMedia" href="https://wa.me/{{$whatsapp}}"> <i class="fab fa-whatsapp"></i> </a>
                        </div>
                    </div>
                    <div id="MenuBack" style="font-size:25px; display:none; cursor:pointer;color:white;justify-content:flex-start;text-align:right; width:40px">
                        <i onclick="goBack()" class="fas fa-chevron-right" id="toPrevious"></i>
                    </div>
                    <div style="font-size:25px;cursor:pointer;color:white;display:flex;justify-content:flex-start;text-align:right;width:25px; margin-left: 30px" onclick="openNav()">
                        <i  class="fas fa-bars"></i>
                    </div>
                     <i class="fa fa-search" id="searchIcon" style="font-size:22px; color:#fff;"></i>
                     <input class="form-control w-100 publicSearch" autocomplete="on" type="text" id="txtsearch" placeholder="چی لازم داری ؟  ...">
                </div>

                <div id="leftPart"> 
                    <a class="footerOptions bottomNav__item mx-2"  href="{{url('/inviteCode')}}"> 
                    <i class="fa-solid fa-people-arrows" style="color: #f5f5f5; font-size:30px"></i>
                    </a> 
                    <a class="headerOptions" href="{{url('/carts')}}">  <i class="far fa-shopping-cart"></i>
                        <span id="basketCountWeb"  @if($countBoughtAghlam < 1) class="headerNotifications0" @else  class="headerNotifications1" @endif>@if($countBoughtAghlam>0){{$countBoughtAghlam}}@else 0 @endif</span>
                    </a>
                </div>
            </section>
    </header>
  
    @yield('content')

<script>
	var currentUrl = window.location.pathname;
	if (currentUrl != '\/home' && currentUrl != '\/') {
	  document.querySelector("#MenuBack").style.display = "initial";
	}

    function goBack() {
      window.history.back();
    }

    function openNav() {
      document.getElementById("mySidenav").style.width = "222px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
    
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }else{

    }

    var input = $("#txtsearch");
       input.on("keyup", function(event) {
        if (event.keyCode === 13) {
            if (input.val().length<1) {
                event.preventDefault();
                window.location.href = "/home";
            } else {
                event.preventDefault();
                window.location.href = "/searchKala/" + input.val();
            }
        }
		
		if(input.val().length>0){
			if($("#ulForSearchResult").length<1){
				$("#searchInputParentDiv").append('<div class="ulForSearchResult px-0"  id="ulForSearchResult"></div>');
			}
			$.get(baseUrl+"/searchKalaOnChange",{name:input.val(),psn:{{Session::get("psn")}}},(respond,status)=>{
				$("#ulForSearchResult").empty();
				respond.forEach((element)=>{
                    if (input.val().length>0) {
                        $("#ulForSearchResult").append('<div class="row pubSearchItem mx-0" id="publicSeachItem"><a href="https://starfoods.ir/searchKala/'+element.GoodName+'"> <li class="list-group-item"><img width="30" height="30" style="margin-left:10px; border:2px solid lightblue;" src="https://starfoods.ir/resources/assets/images/kala/'+element.GoodSn+'_1.jpg">'+element.GoodName+'</li></a></div>');
                    }
                });
			});
		}else{
			$("#ulForSearchResult").empty();
		}
    });
	
	input.on("focus",(event)=>{
		if($("#searchInputParentDiv").length<1){
			input.after('<div id="searchInputParentDiv" class="container-fluid shadow-sm pubSearchResult-Container"> </div>');
            $(".menuBackdrop").css("display", "block");
            $("body").css("overflow", "hidden");
		}
	});
	
	input.on("blur",(event)=>{
		setTimeout(()=>{
		if($("#searchInputParentDiv").length>0){
			$("#searchInputParentDiv").remove();
			$("#ulForSearchResult").remove();
            $(".menuBackdrop").css("display", "none");
            $('#txtsearch').val('');
		}
		},200);
			});
	
    $("#searchIcon").on("click", ()=>{
        input.css({"display":"block", "width": "100%"});
        $("#searchIcon").css("display", "none");
    })

    if (window.matchMedia('(max-width: 920px)').matches){
        $("#searchIcon").on("click", ()=>{
            $(".headerNew").css("display", "none");
        })
    }
</script>

    <script src="{{url('/resources/assets/js/persianDatepicker-master/js/jquery-1.10.1.min.js')}}"></script>
    <script src="{{url('/resources/assets/js/persianDatepicker-master/js/persianDatepicker.min.js')}}"></script> 
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG')}}">
    <script src="{{ url('/resources/assets/js/script.js')}}"></script>
    <script defer src="{{ url('/resources/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/sw.js') }}"></script> 
    <script src="{{url('/resources/assets/js/sweetalert.min.js')}}"></script>
</body>
</html>
