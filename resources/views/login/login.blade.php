<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>استارفود</title>
    <link rel="stylesheet" href="{{ url('/resources/assets/css/login.css')}}"/>
    <meta name="viewport" content="width =device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/png" href="{{ url('/resources/assets/images/part.png')}}"/>
    <script src="{{url('/resources/assets/js/sweetalert.min.js')}}"></script>
    <script src="{{ url('resources/assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <style>
        .downloadAppimg {
                list-style-type: none;
                height:28px;
            }
        .contactlogin {
            text-decoration:none;
            color:#fff;
            font-size:16px;
            display:block;
        }
        .loginButton{
            padding:5px 6px;
            margin-top:17px;
            font-size:18px;
        }
        .about-img {
                display: flex;
                justify-content: center !important;
                align-items: center !important;
                align-self: center !important;
            }

            /* sweet alert style changes  */
            .about-img img {
                width: 80px;
                height: 80px;
            }
            .trust {
                background-color: white;
                width: 100px;
                height:100px;
                margin:20px;
                border-radius:5px;
            }
            @media only screen and (max-width: 940px) and (min-width:250px) {
                .about-img img {
                    width: 60px;
                    height: 60px;
                    margin-top: 3px;
                }
            }
            @media only screen and (max-width: 940px) and (min-width:250px) {
                .trust {
                    width: 60px;
                    height:60px;
                    margin:3px;
                }
            }

        .deputy {
            border-radius: 5px;
            background-color:#fff;
            margin:3px;

        }
    </style>
    
    <script>
    $(document).ready(function(){
    var keyCodes = [61, 107, 173, 109, 187, 189];
   
    $(document).keydown(function(event) {   
      if (event.ctrlKey==true && (keyCodes.indexOf(event.which) != -1)) {
        alert('حالت زوم کردن غیر فعال است'); 
        event.preventDefault();
       }
    });
   
    $(window).bind('mousewheel DOMMouseScroll', function (event) {
       if (event.ctrlKey == true) {
         alert('حالت زوم کردن غیر فعال است'); 
         event.preventDefault();
       }
     });
   });
</script>
</head>
<body style="background-color:red;">
 <div class="container"> 
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="background: linear-gradient(#cedce9, #f44336, #db8e89); margin-top:33px; border-radius:10px; padding:20px;">
               <span  style="display:flex;justify-content:center; margin-bottom:20px;">
                    <img class="img-responsive text-center" width="88px" height="88px" src="{{ url('/resources/assets/images/starfood.png')}}" alt="logi"></span>
                  <h3 style="text-align:center; margin:10px">ورود به استارفود</h3>
                    <form action="{{url('/checkUser')}}" method="post" >
                        @csrf

                        <div class="mb-1">
                            <label for="exampleFormControlInput1" class="form-label">شماره موبایل</label>
                            <input class="form-control" maxlength="11" name="username" pattern="[0-9]{11}+" type="tel" pattern="[0-9]*" placeholder="0912000000" required>
                        </div>

                        <div class="mb-1">
                            <label for="exampleFormControlInput1" class="form-label">کلمه عبور</label>
                           <input class="form-control pass" id="password" maxlength="4"  name="password" type="tel" pattern="\d*" placeholder="کلمه عبور خود را وارد نمایید" required onchange="changeValue()">
                        </div>
                         <input name="token" type="hidden" id="starTokenInput">
                        <!-- <button type="button" onclick="chekcToken()" style="background-color:rgb(0, 0, 0)"><i class="fa fa-unlock"></i> نوتفیکیشن </button> -->
                        <div class="mb-3 text-center">
                            <button class="btn btn-success btn-lg loginButton" onclick="chekcToken()" type="submit"><i class="fa fa-unlock"></i> ورود به استار فود</button>
                        </div> <hr>
                        
                        @if(isset($loginError))
                            @if($loginError=="نام کاربری و یا رمز ورود اشتباه است")
                                <script>
                                    swal({
                                            title: "خطا!",
                                            text: "نام کاربری و یا رمز ورود اشتباه است",
                                            icon: "warning",
                                            button: "تایید!",
                                        });
                                </script>
                            @elseif ($loginError=="با دفتر شرکت در تماس شوید")
                                <script>
                                    swal({
                                        title: "تایید!",
                                        text: "با دفتر شرکت در تماس شوید",
                                        icon: "warning",
                                        button: "تایید!",
                                    });
                                </script>
                            @endif
                            @php
                                unset($loginError);
                            @endphp
                        @endif
                    
                    </form>
                    <form action="{{url('/downloadApk')}}" method="get" id='myform'>
                        <div class="btn-group mb-1 d-flex justify-content-center" role="group" aria-label="Basic mixed styles example">
                           <a href="javascript:;" onclick="document.getElementById('myform').submit()" class="ms-1 btn btn-success"> 
                              <img class="downloadAppimg" src="{{ url('/resources/assets/images/Gplay.png')}}">
                              <img class="downloadAppimg" src="{{ url('/resources/assets/images/bazaar-logo-and-logotype.png')}}"> </i> <br> دانلود اندرويد</a>  
                           </form>
                             <a href="{{url('/appguide')}}" class="ms-1 btn btn-success"> ios <i class="fab fa-apple fa-xl" style='font-size:16px;' > </i> <br>نسخه وب اپليکيشن </a> 
                        </div>
                    
                    <a class="contactlogin" href="tel://02148286">   <span class="fa fa-phone"></span> <span>&nbsp;ارتباط:</span>  48286-021 </a>
                    <a class="contactlogin" href="tel://02149973000">  <span class="fa fa-user"></span> <span>&nbsp;پشتیبان:</span>  49973000-021 </a>
                        
         </div>
        <div class="col-lg-4"></div>
    </div>
       <div class="row"> 
       <div class="col-lg-4 col-md-4 col-sm-4"></div>                      
            <div class="col-lg-4 col-md-4 col-sm-4 about-img">
            <a  referrerpolicy="origin" href="https://trustseal.enamad.ir/?id=220841&amp;code=dgsiolxgvdofskzzy34r">
                <img class="trust" referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=220841&amp;Code=dGSIolXgVdoFskzzY34R"
                     alt="" style="cursor:pointer" id="dGSIolXgVdoFskzzY34R">
            </a>
            <img class="trust" referrerpolicy='origin' id='nbqewlaosizpjzpefukzrgvj'
                 style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=249763&p=uiwkaodspfvljyoegvkaxlao","Popup", "toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                 alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=249763&p=odrfshwlbsiyyndtwlbqqfti' />  
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"></div> 
        </div>
</div>
<script>

function chekcToken() {
        document.getElementById('starTokenInput').value=localStorage.getItem('token');
    } 

if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
}else{
}

// changing password input field into star
// let password = document.querySelector("#password");
// password.addEventListener('keyup', e =>{
//     let mypass = document.querySelector(".pass");
//     mypass.value = "*".repeat(e.target.value.length);
// });


</script>
</body>
</html>
