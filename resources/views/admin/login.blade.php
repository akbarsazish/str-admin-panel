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

.logo-img {
  height:6rem;
  width:6rem;
}

.login-label {
    float: right !important;
    color:#fff !important;
}

.login-btn {
    margin-top:3rem;
}

</style>  
</head>
<body style="background: #034620;">
    <section class="account-box container">
        <div class="register login">
            <img class="logo-img" src="{{url('/resources/assets/images/starfood.png')}}" alt="logo">
             <div class="headline" style="color:white; text-align:center">ورود به استار فود</div>
              <div class="content">
                <form action="{{url('/checkAdmin')}}" method="post">
                    @csrf
                    <label class="login-label" for="mobtel">ایمیل یا شماره موبایل</label>
                    <input name="username" type="text" placeholder="09120000000" required>
                    <label class="login-label" for="password">کلمه عبور</label>
                    <input name="password" type="password" asp-for="Password" placeholder="کلمه عبور خود را وارد نمایید" required>
                    <button class="login-btn" type="submit"> <i class="fa fa-unlock"></i> ورود به استار فود</button>
                </form>
            </div>
            <div class="notLoginInfo">
                <h2>شماره تماس :   <span class="theValue"> 48286 </span> </h2>
                <h2>بررسی و شکایات : <span class="theValue"> 49973000 </span> </h2>
                <h2>شرایط حفظ حریم خصوصی </h2>
            </div>
        </div>
     
    </section>
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/resources/assets/js/script.js') }}"></script>
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
</body>
</html>