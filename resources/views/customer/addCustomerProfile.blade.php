@extends('layout.layout')
@section('content')

<style>
   ::placeholder {
        color: rgb(235, 218, 218) !important;
        opacity: 1;
        }
:-ms-input-placeholder {
    color: rgb(235, 218, 218) !important;
    }
::-ms-input-placeholder {
    color: rgb(235, 218, 218) !important;
    }
    .required .form-label:after {
        content:"*";
        color:red;
        padding-right: 0px;
        }
     input.haqiqi{
        background-color: #eeeeee !important;
        opacity: 1;
    }
</style>

<div class="container">
    <div class="row">
        <div class="profielpage">
            <div class="text-black brounded" align="right" style="border-bottom:1px solid red; top:0">
                 <h4> پروفایل </h4>
            </div>
                <div class="c-checkout container tab-design" id="haqiqi">
                    <div class="col-sm-6">
                        <ul class="header-list nav nav-tabs" data-tabs="tabs">
                            <li><a class="active" data-toggle="tab" style="color:black;"  href="#custAddress"> اشخاص حقیقی </a></li>
                            <li><a data-toggle="tab" style="color:black;"  href="#moRagiInfo" style="margin-right:30px"> اشخاص حقوقی </a></li>
                        </ul>
                    </div>

                        <div class="c-checkout tab-content" style="background-color:#f5f5f5; margin:0;  padding:0.3%; border-radius:10px 10px 2px 2px;">
                            <div class="row c-checkout rounded-3 tab-pane active" id="custAddress" style="width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                                <div class="col-sm-12">
                                    <div class="row" style="width:98%; padding:0 1% 2% 0%">
                                        @include('customer.haqiqiHoqoqiForms.haqiqiForm')
                                    </div>
                                </div>
                            </div>
                          <div class="row c-checkout rounded-3 tab-pane" id="moRagiInfo" style="width:99%; margin:0 auto; padding:1% 0% 0% 0%">
                              <div class="col-sm-12">
                                <div class="row" style="width:98%; padding:0 1% 2% 0%;">
                                   
                                   @include('customer.haqiqiHoqoqiForms.hoqoqiForm')
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection