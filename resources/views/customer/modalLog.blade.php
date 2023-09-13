<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ali Akbar Sazish">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">
    <title> استار فود</title>
    <link rel="icon" type="image/png" href="{{ url('resources/assets/images/part.png')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{url('/resources/assets/jquery-ui-1.12.1/jquery-ui-1.12.1/jquery-ui.min.css')}}"/> -->
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/mediaq.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/framework7.bundle.min.css')}}">
    <link rel="stylesheet" href="{{url('/resources/assets/js/persianDatepicker-master/css/persianDatepicker-default.css')}}" />
    <link rel="stylesheet" href="{{ url('/resources/assets/js/jquery-ui.css')}}"/>
    <script src="{{ url('resources/assets/js/jquery.min.js')}}"></script>
    <script src="{{ url('/resources/assets/js/jquery-ui.min.js')}}"></script>
    <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
      <style>
		  button[disabled] {background-color: #0f3c6e !important;border-color: #198754 !important; color: white !important; }
		  .header-modal { text-align: center;}
		  .modal-content{background: linear-gradient(#cedce9, #f44336, #db8e89);}
		  tbody, td, tfoot, th, thead, tr{font-size:14px;}
      .select {
        color:#fff !important;
      }

      .modal-backdrop {
          background-color: red;
        }
	</style>
</head>

@if($sessionIds) 
<script >
window.onload = function() {
    $('#myModal').modal('show');
    }
</script>
@else
@endif 
<main>

<div class="modal fade" id="myModal" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="text-center header-modal border-bottom">
        <p class="modal-title p-1"> <b> شما با مرورگر های زیر وارد شده اید!</b> <br>  لطفاً یکی از مرورگر ها را برای خروج انتخاب کنید</p>
      </div>
      <div class="modal-body p-0">
      <form action="{{url('/logOutConfirm')}}" method="POST">
            @csrf
        <table class="table text-center mb-0">
          <thead addedStocks>
            <tr>
              <th >انتخاب</th>
              <th>مرورگر</th>
              <th >سیستم عامل</th>
				<th> </th>
            </tr>
          </thead>
          <tbody>
               @foreach ($sessionIds as $sess)
                  <tr name="selectedDevice">
                    <td class="select">
                      <input class="form-check-input p-3 select" type="radio" name="selectedDevice" value="{{$sess->sessionId.'__'.$sess->customerId}}" id="flexCheckIndeterminate">
                    </td>
                    <td class="select">{{$sess->browser}}</td>
                    <td class="select">{{$sess->platform}}</td>
					 <td> </td>
                  </tr>
                @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer p-1 border-0" >
        <button type="submit" class="btn btn-success" disabled id="submitConfirm">ادامه </button>
      </form>
        <a type="button" class="btn btn-danger" data-bs-dismiss="modal"   href="{{url('/login')}}" >خیر</a>
      </div>
    </div>
  </div>
</div>
  <script>
    $("input[name='selectedDevice']").on("change",()=>{
      $("#submitConfirm").prop('disabled',false);
    });
</script>
<script src="{{url('/resources/assets/js/persianDatepicker-master/js/jquery-1.10.1.min.js')}}"></script>
<script src="{{url('/resources/assets/js/persianDatepicker-master/js/persianDatepicker.min.js')}}"></script> 
<link rel="apple-touch-icon" href="{{ asset('logo.PNG')}}">
<script src="{{ url('/resources/assets/js/script.js')}}"></script>
<script defer src="{{ url('/resources/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/sw.js') }}"></script> 
</body>
</html>