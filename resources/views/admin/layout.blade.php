<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title> Admin Panel </title>
    <link rel="icon" type="image/png" href="{{ url('/resources/assets/images/part.png')}}">
    
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap-grid.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/all.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ url('/resources/assets/vendor/swiper/css/swiper.min.css') }}"> -->
    <link rel="stylesheet" href="{{ url('/resources/assets/slicknav/slicknav.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mainAdmin.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mediaq.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/admin.framework7.bundle.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap-utilities.rtl.min.css')}}">
    <link rel="stylesheet" href="{{url('/resources/assets/js/persianDatepicker-master/css/persianDatepicker-default.css')}}" />
	<link rel="stylesheet" href="{{ url('/resources/assets/css/jquery-ui.css')}}">
    <link rel="icon" type="image/png" href="{{ url('/resources/assets/images/part.png')}}">
    <script type="text/javascript" src="{{ url('/resources/assets/js/jquery.min.js')}}"></script>
</head>
<body>
    <div class="menuBackdrop"></div>
        <section class="topMenu">
            <section class="top-head container">
                <div class="right-head" >
                    <div id="mySidenav" class="sidenav" style="width:0px;overflow-x:hidden;margin-left:100px;padding-right:0;">
                         <a href="{{url('/home')}}" class="sidenav__header" style="background: linear-gradient(#3ccc7a, #034620); text-align:center;">
                            <img width="166px" src="{{ url('/resources/assets/images/logomenu4.png') }}"/>
                        </a>
                        <button onclick="closeNav()" class="closeMenuButton"><i class="fad fa-times"></i></button>
                        <div id='cssmenu' style="direction:rtl;">
                            <ul>
                               <li class='fw-bold'>
                                <a class="mySidenav__item" href="{{url('/dashboardAdmin')}}"><span>
                                <i class="fa-solid fa-dashboard fa-lg" style="color:#fff;"></i>&nbsp; داشبورد </span></a>
                                @if(hasPermission(Session::get("adminId"),"baseInfoN") > -1)
                                    <li class='has-sub'><a class="mySidenav__item" href="{{url('/dashboardAdmin')}}"><span><i class="fa-solid fa-info fa-lg " style="color:#fff"></i>&nbsp;اطلاعات پایه</span></a>
                                        <ul>
                                            @if(hasPermission(Session::get("adminId"),"settingsN") > -1)
                                            <li><a class="mySidenav__item" href="{{url('/controlMainPage')}}">&nbsp;&nbsp;<i class="fa-regular fa-cog fa-lg" style="margin-right: 5%; color:#597c9d"></i>&nbsp; تنظیمات  </a></li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                @if(hasPermission(Session::get("adminId"),"customersN") > -1)
                                    <li class='has-sub'>
                                        <a class="mySidenav__item" href="{{url('/dashboardAdmin')}}"><span>
                                        <i class="fa-light fa-layer-plus"  style="color:#fff"></i> &nbsp; تعریف عناصر  </span></a>
                                        <ul>
                                            <li><a class="mySidenav__item" href="{{url('/listKarbaran')}}">&nbsp;&nbsp;<i class="fa-regular fa-user fa-lg" style="margin-right: 5%; color:#597c9d"></i> &nbsp; کاربران </a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(hasPermission(Session::get("adminId"),"operationN") > -1)
                                    <li class='has-sub'>
                                        <a class="mySidenav__item" href="{{url('/dashboardAdmin')}}"> <span> <i class="fa-light fa-tasks"  style="color:#fff"></i> &nbsp; عملیات </span></a>
                                        <ul>
                                            @if(hasPermission(Session::get("adminId"),"kalasN") > -1)
                                                <li><a class="mySidenav__item" href="{{url('/listKala')}}" > <i class="fa-regular fa-list-radio fa-lg" style="margin-right: 5%;"></i> کالا ها </a></li>
                                            @endif
                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                                <li class="sidebarLi"> 
                                                    <a class="mySidenav__item position-relative" href="{{url('/buyFactors')}}"> &nbsp;&nbsp;
                                                        <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                            @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                        </span>  
                                                        <i class="fa fa-money-bill"></i>
                                                        فاکتور خرید 
                                                    </a> 
                                                </li>
                                            @endif
                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                                <li class="sidebarLi"> 
                                                    <a class="mySidenav__item position-relative" href="{{url('/returnedBuyFactors')}}"> &nbsp;&nbsp;
                                                        <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                            @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                        </span>  
                                                        <i class="fa fa-money-bill"></i>
                                                        فاکتور  برگشت از خرید 
                                                    </a> 
                                                </li>
                                            @endif
                                            
                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                                <li class="sidebarLi"> 
                                                    <a class="mySidenav__item position-relative" href="{{url('/salesFactors')}}"> &nbsp;&nbsp;
                                                        <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                            @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                        </span>  
                                                        <i class="fa fa-money-bill"></i>
                                                        فاکتور فروش 
                                                    </a> 
                                               </li>
                                            @endif

                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                                <li class="sidebarLi">
                                                    <a class="mySidenav__item" href="{{url('/returnedFactors')}}"> &nbsp;&nbsp; 
                                                        <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                            @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                        </span>
                                                        <i class="fa fa-shopping-cart fa-lg"></i>
                                                        فاکتور برگشت از فروش
                                                    </a>
                                                </li>
                                            @endif

                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                                <li class="sidebarLi">
                                                    <a class="mySidenav__item" href="{{url('/salesOrder')}}"> &nbsp;&nbsp; 
                                                        <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                            @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                        </span>
                                                        <i class="fa fa-shopping-cart fa-lg"></i>
                                                        سفارشات فروش 
                                                    </a>
                                                </li>
                                            @endif
                                            @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                            <li class="sidebarLi">
                                                <a class="mySidenav__item" href="{{url('/receives')}}"> &nbsp;&nbsp; 
                                                    <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                        @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                    </span>
                                                    <i class="fa fa-shopping-cart fa-lg"></i>
                                                     دریافت ها 
                                                </a>
                                            </li>
                                          @endif
                                          @if(hasPermission(Session::get("adminId"),"orderSalesN") > -1)
                                            <li class="sidebarLi">
                                                <a class="mySidenav__item" href="{{url('/pays')}}"> &nbsp;&nbsp; 
                                                    <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                        @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif
                                                    </span>
                                                    <i class="fa fa-cc-visa fa-lg"></i>
                                                     پرداخت
                                                </a>
                                            </li>
                                          @endif
                                            @if(hasPermission(Session::get("adminId"),"messageN") > -1)
                                            <li class="sidebarLi">
                                                <a class="mySidenav__item" href="{{url('/messages')}}"> &nbsp;&nbsp; 
                                                <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages">
                                                    @if(hasNewMessage(Session::get('adminId'))>0) {{hasNewMessage(Session::get('adminId'))}} @else 0 @endif
                                                </span>
                                                <i class="far fa-envelope"></i> 
                                                پیامها
                                              </a>
                                          </li>
                                            @endif
                                            <li><a class="mySidenav__item" href="{{url('/notification')}}"> <i class="fa fa-bell fa-lg" style="margin-right: 5%;"></i>  نوتفیکیشن </a>
                                            <li><a class="mySidenav__item" href="{{url('/discountCode')}}"> <i class="fa fa-code fa-lg" style="margin-right: 5%;"></i>  کد تخفیف </a>
                                        </ul>
                                    </li>
                                @endif

                                @if(hasPermission(Session::get("adminId"),"reportN") > -1)
                                    <li class='has-sub'><a class="mySidenav__item" href="{{url('/dashboardAdmin')}}"><span><i class="fa-solid fa-chart-user fa-lg " style="color:#fff"></i> &nbsp;  گزارشات </span></a>
                                        <ul>
                                            @if(hasPermission(Session::get("adminId"),"customerListN") > -1)    
                                                <li><a class="mySidenav__item" href="{{url('/listCustomers')}}"><i class="fa-light fa-users fa-lg" style="margin-right: 5%"></i>&nbsp; مشتریان</a></li>
                                            @endif
                                        @if(hasPermission(Session::get("adminId"),"onlinePaymentN") > -1)
                                            <li><a class="mySidenav__item" href="{{url('/payedOnline')}}"><i class="fa-light fa-credit-card fa-lg" style="margin-right: 5%"></i>&nbsp; پرداخت آنلاین </a></li>
                                        @endif
                                        @if(hasPermission(Session::get("adminId"),"gameAndLotteryN") > -1)
                                        <li class="sidebarLi"> 
                                              <a class="mySidenav__item" href="{{url('/lotteryResult')}}">  &nbsp;&nbsp; 
                                                <span class="position-absolute top-2 start-5 translate-middle badge rounded-pill bg-success imediatNotification1" id="countNewMessages" >@if(hasNewNazar(Session::get('adminId'))+wonLottery(Session::get('adminId'))+usedTakhfifCase(Session::get('adminId'))+usedTakhfifCode(Session::get('adminId'))+playedGame(Session::get('adminId'))>0){{hasNewNazar(Session::get('adminId'))+wonLottery(Session::get('adminId'))+usedTakhfifCase(Session::get('adminId'))+usedTakhfifCode(Session::get('adminId'))+playedGame(Session::get('adminId'))}} @else 0 @endif</span>
                                                <i class="fa-light fa-briefcase fa-lg" ></i>
                                                  تخفیفات و امتیازات
                                             </a>
                                          </li>
                                        @endif
                                        </ul>
                                    </li>
                                @endif
                                <li class='last'><a class="mySidenav__item" href="{{url('/loginAdmin')}}" onclick="logout()"><span><i class="fa-solid fa-sign-out fa-lg" style="color:#fff;" ></i>&nbsp; خروج </span></a></li>
                            </ul>
                           </div>
                    </div>
                    <div id="MenuBack" style="font-size:25px;cursor:pointer;color:white;display:flex;justify-content:flex-start;text-align:right;width:34px">
                        <i onclick="goBack()" class="fas fa-chevron-right"></i>
                    </div>
                    <div style="font-size:25px;cursor:pointer;color:white;display:flex;justify-content:flex-start;text-align:right;width:25px; margin-right: 15px; margin-left: 50px" onclick="openNav()">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
                </div>
                <div class="left-head">
                    <a class="headerOptions" style="font-family: IRANSans !important;" href="{{url('/salesOrder')}}">
                        <i class="far fa-shopping-cart"></i>
                        <span @if($imediatOrderCount < 1) class="headerNotifications0" @else  class="headerNotifications1" @endif id="countNewMessages"> @if($imediatOrderCount){{$imediatOrderCount}} @else 0 @endif </span>
                    </a>
                    <div class="devider"></div>
                    <a class="headerOptions" style="font-family: IRANSans !important;" href="{{url('/messages')}}">
                        <i class="far fa-envelope"></i>
                        <span @if(hasNewMessage(Session::get('adminId')) < 1) class="headerNotifications0" @else  class="headerNotifications1" @endif id="countNewMessages"> @if(hasNewMessage(Session::get('adminId'))>0){{hasNewMessage(Session::get('adminId'))}} @else 0 @endif</span>
                    </a>
                </div>
            </section>
        </section>
    </header>
    @yield('content')

    <script type="text/javascript" src="{{ url('/resources/assets/js/jquery.min.js')}}"></script>
    <script src="{{ url('/resources/assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{url('/resources/assets/js/persianDatepicker-master/js/jquery-1.10.1.min.js')}}"></script>  
    <script src="{{url('/resources/assets/js/persianDatepicker-master/js/persianDatepicker.min.js')}}"></script> 
    <script src="{{ url('/resources/assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{url('/resources/assets/vendor/swiper/js/swiper.min.js')}}"></script>
    <script src="{{url('/resources/assets/js/moustrap.js')}}"></script>
    <script src="{{url('/resources/assets/slicknav/jquery.slicknav.min.js')}}"></script>
    <script src="{{url('/resources/assets/vendor/jquery.countdown.min.js')}}"></script>
    <script defer src="{{url('/resources/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('/resources/assets/js/sweetalert.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{url('/resources/assets/vendor/persianumber.min.js')}}"></script>
    <script src="{{url('/resources/assets/vendor/elevatezoom.js')}}"></script>
    <script src="{{url('/resources/assets/js/script.js') }}"></script>
    <script src="{{url('/resources/assets/js/addNewOrder.js') }}"></script>
    <script src="{{url('/resources/assets/js/bargiri.js') }}"></script>
    <script src="{{url('/resources/assets/js/factors.js') }}"></script>
    <script src="{{url('/resources/assets/js/customer.js') }}"></script>
    <script src="{{url('/resources/assets/js/getAndPay.js') }}"></script>
    <script src="{{url('/resources/assets/js/pays.js') }}"></script>
    <script src="{{url('/resources/assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.js"></script>
    <script src="{{url('/resources/assets/js/tableScript.js') }}"></script>
    
    <script>
        function goBack() {
            window.history.back();
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "260px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: '{{ config("broadcasting.connections.pusher.key") }}',
        //     cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        //     useTLS: true,
        // });

        // Echo.channel('notifications')
        //     .listen('NotificationEvent', (event) => {
        //         alert(event);
        //         console.log(event);
        //     });
</script>

  
</body>
</html>
