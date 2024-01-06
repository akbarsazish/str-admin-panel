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
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body{
    background-color: #034620;
    color:#fff;
}

.login-container {
    text-align:center;
    position: relative; 
    width: 100%; 
    height: 100vh; 
    overflow: hidden; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
}

.background{
  width: 430px;
  height: 520px;
  position: absolute;
  transform: translate(-50%,-50%);
  left: 50%;
  top: 50%;
}


.content{
  height: 520px;
  width: 400px;
  background-color: rgba(255,255,255,0.13);
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  border-radius: 10px;
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255,255,255,0.1);
  box-shadow: 0 0 40px rgba(8,7,16,0.6);
  padding: 30px;
}

@media only screen and (max-width: 786px) {
  .content{
    height: 500px;
    width: 380px;
    padding: 22px 20px;
  }
}


form *{
  color: #ffffff;
  letter-spacing: 0.5px;
  outline: none;
  border: none;
}

.login-label {
  margin-top:1rem;
}

label{
  display: block;
  margin-top: 28px;
  font-size: 1.1rem;
  font-weight: 500;
  float:right;
}

input{
  display: block;
  height: 44px;
  width: 100%;
  background-color: #fff;
  border-radius: 3px;
  padding: 0 10px;
  margin-top: 8px;
  font-size: 14px;
  font-weight: 300;
  color:#000;
}

input:focus{
  color:#000;
  border:1px dotted green;
  background-color: #eee;
 
}

::placeholder{
    color: gray;
}

button{
    margin-top: 50px;
    width: 100%;
    background-color: #004623;
    color: #fff;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}

button:hover{
    background-color: #fff;
    color: #004623;
}

.social{
  margin-top: 30px;
  display: flex;
}

.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
}

.logo-img{
    width:77px;
    height:77px;
    margin: 0 auto;
}

.notLoginInfo {
    z-index: inherit;
}

.contact-label {
    text-align:right;
    font-size: 1rem;
    margin-top:.5rem;
}

span { 
    position: absolute; 
    bottom: -50px; 
    background: transparent; 
    border-radius: 50%; 
    pointer-events: none; 
    box-shadow: inset 0 0 10px  rgba(225, 225, 225, 0.5); 
    animation: animate 4s linear infinite; 
}

@keyframes animation { 
        0% { 
            transform: translateY(0%); 
            opacity: 1; 
        } 
        99% { 
            opacity: 1; 
        } 
        100% { 
            transform: translateY(-1000%); 
            opacity: ; 
        } 
    } 
</style>
</head>
<body>
    <section class="login-container">
        <div class="content">
                <img class="logo-img" src="{{url('/resources/assets/images/starfood.png')}}" alt="logo">
                 <h3 class="login-label">ورود به استار فود </h3>
                <form action="{{url('/checkAdmin')}}" method="post" data-parsley-validate="">
                    @csrf
                    <label class="label" for="mobtel"> شماره موبایل</label>
                    <input name="username" type="text" required data-parsley-type="number" id="username" placeholder="09120000000"  data-parsley-trigger="change" required="">

                    <label class="label" for="password">کلمه عبور</label>
                    <input name="password" type="password" asp-for="Password" placeholder="کلمه عبور خود را وارد نمایید" required>
                    <button class="login-btn" type="submit"> <i class="fa fa-unlock"></i> ورود به استار فود</button>
                </form> <br>
                <div class="notLoginInfo">
                    <h3 class="contact-label">شماره تماس :   48286  </h3>
                    <h3 class="contact-label">بررسی و شکایات :  49973000  </h3>
                </div>
            </div>
    </section>
    <script type="text/javascript"> 
        function createBubble() { 
            const section =  document.querySelector("section"); 
            const createElement = document.createElement("span"); 
            var size = Math.random() * 60; 

            createElement.style.animation = "animation 6s linear infinite"; 
            createElement.style.width = 180 + size + "px"; 
            createElement.style.height = 180 + size + "px"; 
            createElement.style.left =  Math.random() * innerWidth + "px"; 
            section.appendChild(createElement); 

            setTimeout(() => { 
                createElement.remove(); 
            }, 4000); 
        } 
        setInterval(createBubble, 1000); 
    </script> 
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/resources/assets/js/script.js') }}"></script>
    <script src="{{ url('/resources/assets/js/jquery.min.js') }}"></script>
   
</body>
</html>