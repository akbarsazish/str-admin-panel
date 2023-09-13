@extends('layout.layout')
@section('content')
<style>
    .list-group-numbered>li::before {
    font-size:18px;
    color: #000;
    font-weight:bold;
}
.explain {
    font-size:16px;
}
</style>
<div class="container topDistance">
    <div class="row text-center my-4 p-2" style="box-shadow: 0 1px 3px 0 #f50303cc; border-radius:4px; min-height:80vh">
        <div class="col-lg-12">
            <div class="mywalet">
                    <span class="walletContent"> @if($moneyTakhfif){{number_format(ceil($moneyTakhfif))}} @else 0 @endif ریال </span> 
            </div>
            <div class="labelContent" style="font-size:16px; margin-top:8px;">
                    موجودی شما 
            </div>

            <div class="mt-2 p-3" id="useWallet">
                 <p class="explain"> استفاده از کیف پول منوط به پرداخت آنلاین می باشد. </p>
                 <a type="button"  class="btn btn-sm btn-success" > استفاده از کیف پول <i class="fa fa-check"></i> </a>
            </div>
           
            <div class="walletGuid mt-2 p-3" id="yesNoBtn" style="font-size:16px; display:none;">
                    <p class="explain">
                        برای استفاده از کیف پول در نظر سنجی ما شرکت نمایید!
                    </p>
                    <a type="button" id="yesBtn" class="btn btn-success" > بلی <i class="fa fa-check"></i> </a>
                    <a href="{{url('/home')}}" type="button" class="btn btn-danger"> خیر <i class="fa fa-xmark"></i> </a>
            </div>
        </div>
    
        <div class="col-lg-12 p-3 rounded-2" id="questionPart" style="text-align:right;">
            <ul class="list-group list-group-numbered px-0">
            <form action="{{url('/addMoneyToCase')}}" method="get">
                        @csrf
                        @foreach($nazars as $nazar)
                        <input type="hidden" name="nazarId" value="{{$nazar->nazarId}}">
                            <li class="list-group-item question"> 
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label"> <b> 1- {{$nazar->question1}}  </b> </label>
                                    <textarea class="form-control" name="answer1" required id="firstTextarea" minlength="15" maxlength="256"  rows="2" ></textarea>
                                </div>
                            </li>
                            <li class="list-group-item question"> 
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label"> <b> 2- {{$nazar->question2}}</b>  </label>
                                    <textarea class="form-control" name="answer2" required id="secondTextarea" minlength="15" maxlength="256"  rows="2"></textarea>
                                </div>
                            </li>
                            <li class="list-group-item question"> 
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label"> <b> 3- {{$nazar->question3}} </b>  </label>
                                    <textarea class="form-control" name="answer3" required id="thirdTextarea" minlength="15" maxlength="256"  rows="2"></textarea>
                                </div>
                            </li>
                        @endforeach
                       <span class="list-group-item question textn-end">
                        <input type="hidden" name="takhfif" value="{{$moneyTakhfif}}">
                       <button class="walletbutton mb-2" @if($moneyTakhfif!=0) disabled @else @endif type="submit"> ارسال <i class="fa fa-send"></i> </button>
                    </form>
                    </span>
            </ul>
        </div>
    </div>
</div>

<script>
    $("#yesBtn").on("click", ()=>{
      $("#questionPart").css("display", "block");
      $("#questionPart").css(" transition", "width 3s ease");
		$("#yesNoBtn").css("display", "none");
     })

    $("#useWallet").on("click", ()=>{
      $(".walletGuid").css("display", "block");
      $(".walletGuid").css(" transition", "width 3s ease");
	  $("#useWallet").css("display", "none");
     })

</script>

@endsection