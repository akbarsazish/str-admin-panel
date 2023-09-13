@extends('layout.layout')
@section('content')

<style>
.wrapper{ border:1px solid gray; margin:15px;}
.conContent{background-color:#ff2236;}
.sideContent{ text-align:center;display:flex;justify-content:center;}
.sideContent:after{height: 100%;
    margin-left:5px;
    display: block;
    border-left: 5px solid red;
    content: '';}

.contact-log {height: 188px;width: 200px; margin: auto;}
.description{ background-color: #fff;text-align:center;margin-top:12%;border-radius: 8px 0px 0px 8px;
    box-shadow: -3px 0px 2px 3px black;
}
.description h1, p{ color:red;text-shadow: 1px 1px black;}
.contactDiv{margin-top:5%;}
.contactList {color: #fff;text-decoration:none;font-size:16px;
     margin-bottom:5px;
}
.contactList a{text-decoration:none; text-align:right;}
.contactList span.fa{width:44px;height:40px; border-radius: 50%;
    background: #2553b8;margin: 0 auto;text-align:center;
    color:#f00; background-color:#fff;
}

@media only screen and (max-width: 990px) and (min-width:278px) {
.description{box-shadow: 0px 0px 1px 1px red;}
}
	
@media only screen and (max-width: 990px) and (min-width:278px) {
.sideContent{height: 10%;}
}
@media only screen and (max-width: 990px) and (min-width:278px) {
.sideContent:after{border:none; height: 18%;}
}
@media only screen and (max-width: 990px) and (min-width:278px) {
.contact-log{height: 100px;width: 100px; margin-bottom:10px;}
}
@media only screen and (max-width: 990px) and (min-width:278px) {
.contactDiv{margin-top:2%;}
}
@media only screen and (max-width: 990px) and (min-width:278px) {
.conContent{height:66vh;}
}
@media only screen and (max-width: 990px) and (min-width:278px) {
.contactList{font-size:14px;}
}	
</style>
    <div class="container topDistance">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body wrapper">
                        <div class="row">
                          <div class="col-lg-4 sideContent ps-0">
                                  <img class="img-responsive contact-log" src="{{ url('/resources/assets/images/starfood.png')}}" /> 
                            </div>
                            <div class="col-lg-8 conContent">
                                <div class="row"> 
                                    <div class="col-lg-9 description">
                                        <h1 style="font-size:26px">استار فود </h1>
                                        <p style="font-size:20px"> زنجیره تامین هوشمند <br> اقلام شاخص رستوران و فست فود </p>
                                    </div>
                                    <div class="col-lg-3"> </div>
                               </div>
                               <div class="row">
                                     <div class="col-lg-12 contactDiv">
                                        <div class="contactList">
                                            <a class="fw-bold" href="tel://02148286"> <span class=" animatedButton fa fa-phone"></span>  <span class="fw-bold">ارتباط :</span>  48286-021 </a> 
                                        </div>
                                        <div class="contactList">
                                           <a class="fw-bold" href="tel://02149973000"><span class=" animatedButton fa fa-user"></span>  <span class="fw-bold">پشتیبان :</span>     49973000-021 </a>
                                        </div>
                                        
                                        <!-- <div class="contactList">
                                            <span class="fa fa-paper-plane"></span>
                                            <span class="fw-bold"> وب سایت :</span> <a href="https://starfood.ir/"> www.starfod.ir </a> 
                                        </div> -->
                                        <div class="contactList">
                                            <span class="fa fa-map-marker"></span>
                                            <span> تهران، خیابان مولوی،پلاک 875 </span>
                                        </div>
                                   </div>
                              </div>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection