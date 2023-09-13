<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Admin Panel  </title>
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mainAdmin.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mediaq.css') }}">
    <meta name="viewport" content="width =device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ url('/resources/assets/images/part.png') }}">
    <style>
       
::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:#ececec;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:#ececec;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:#ececec;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:#ececec;
}
::-ms-input-placeholder { /* Microsoft Edge */
   color:#ececec;
}

::placeholder { /* Most modern browsers support this now. */
   color:#ececec;
}

.notLoginInfo{
  margin: 0 auto !important;
  color:#fff;
  text-align:center;
  padding:20px;
}

.theValue {
    color:#e5e5e5;
    font-size:14px;
}

</style>
    
</head>
<body style=" background-image:linear-gradient(#198754, #034620); height:98vh;">
    <section class="account-box container">
        <!-- <div class="register-logo">
            <a>  <img src="{{ url('/resources/assets/images/logo2.gif')}}" style="height:100px" alt=""> </a>
        </div> -->
        <div class="register login" style=" background-image:linear-gradient(#034620, #198754, #034620);">
            <div class="headline" style="color:white;text-align:center">ورود به استار فود</div>
            <div class="content">
                <form action="{{url('/checkAdmin')}}" method="post">
                    @csrf
                    <label for="mobtel" style="color:white">ایمیل یا شماره موبایل</label>
                    <input name="username"  type="text" placeholder="09120000000" required>
                    <label  style="color:white">کلمه عبور</label>
                    <input name="password"   type="password" asp-for="Password" placeholder="کلمه عبور خود را وارد نمایید" required>
                    <div class="acc-agree">
                        <input id="chkbox" type="checkbox" checked>
                        <label for="chkbox" style="color:white"><span>مرا به خاطر داشته باش</span></label>
                    </div>
                    <button type="submit"><i class="fa fa-unlock"></i> ورود به استار فود</button>
                </form>
            </div>
        </div>
     
        <div class="notLoginInfo">
            <h2>شماره تماس :   <span class="theValue"> 48286 </span> </h2>
            <h2>بررسی و شکایات : <span class="theValue"> 49973000 </span> </h2>
            <h2>شرایط حفظ حریم خصوصی </h2>
        </div>
    </section>
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/resources/assets/js/script.js') }}"></script>
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
</body>
</html>