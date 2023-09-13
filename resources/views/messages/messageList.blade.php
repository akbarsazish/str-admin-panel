@extends('layout.layout')
@section('content')

<div class="container topDistance">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 messageList">
    <p style="font-size:16px; text-align:center;">با پیام ها خود ما را در ارائه بهتر خدمات یاری رسانید <i class="fa fa-handshake fa-lg" style="color: #ef3d52" aria-hidden="true"></i>  </p>
    <div class="row d-flex justify-content-center mb-10">
      <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card" id="chat1" style="border-radius: 15px;">
          <div class="card-body messageBody" id="messageList" style="overflow-y: scroll; height:350px; ">
                @foreach ($messages as $message)
                    <div class="d-flex flex-row justify-content-start mb-2">
                        <img src="/resources/assets/images/boy.png" alt="avatar 1" style="width: 45px; height: 100%;">
                        <div class="p-3 ms-2" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                        <span class="text-info text-end">{{$message->messageHijriDate}}</span>
                        <p class="small mb-0" style="font-size:1rem;">  {{$message->messageContent}} </p>
                        </div>
                    </div>
                @foreach ($message->replay as $replays)
                    <div class="d-flex flex-row justify-content-end mb-2">
                        <div class="p-3 me-3 border" id="replayDiv'.$replay->id.'" style="border-radius:10px; background-color: #fbfbfb;">
                        <span class="text-info  text-end">{{$replays->replayHijriDate}}</span>
                        <p class="small mb-0" style="font-size:1rem;"> {{$replays->replayContent}} </p>
                        </div>
                        <img src="/resources/assets/images/girl.png" alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>
                @endforeach
                @endforeach
          </div>
        </div>
        <div class="form-outline messageDiv" style="top:0; left:10%; bottom:90%; right:10%;">
            <textarea class="form-control" name="messageContent" id="messageContent" placeholder="متن پیام خود را بنویسید" rows="3"></textarea>
            <button type="button" onclick="doAddPM()" class="btn btn-primary btn-sm mt-2 p-2" id="btnSaveMsg">ارسال پیام</button>
         </div>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<script>

 window.onload = function() {
    $(document).on('click', '.form-check-input', (function() {
        $('#customerSn').val($(this).val().split('_')[0]);
        $('#customerGroup').val($(this).val().split('_')[1]);
    }));
 }
</script>
<script src="{{ url('/resources/assets/js/script.js')}}"></script>
@endsection