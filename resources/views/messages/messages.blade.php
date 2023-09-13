@extends('admin.layout')
@section('content')
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> پیامها </legend>
					<div class="form-check">
						<label class="form-check-label me-4" for="assesPast"> وضعیت پیام </label>
						<select class="form-select" name="messageState" id="messageState">
							<option value="LastTen"> ده پیام آخر </option>
							<option value="All"> همه </option>
							<option value="unRead"> خوانده نشده </option>
							<option value="Read"> خوانده شده </option>
							<option value="noResponded"> پاسخ داده نشده </option>
							<option value="Responded"> پاسخ داده شده </option>
						</select>
					</div>
					<button class="btn btn-sm btn-success" onclick="filterMessages(document.querySelector('#messageState').value)">  بازخوانی </button>
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader"> </div>
                <div class="row mainContent">
                         <table class="table table-bordered table-sm">
                                <thead class="tableHeader">
                                <tr>
                                    <th class="for-mobil">ردیف</th>
                                    <th> نام مشتری </th>
                                    <th class="for-mobil"> شماره تماس</th>
                                    <th class="for-mobil">تاریخ</th>
                                    <th>عنوان</th>
                                    <th class="for-mobil" style="width:255px;">شرح </th>
                                    <th style="width:88px;">تعداد  </th>
                                    <th>خوانده نشده  </th>
                                    <th class="for-mobil">مشاهده شده </th>
                                    <th>نمایش </th>
                                </tr>
                                </thead>
                                <tbody class="tableBody" id="messagesListBody">
                                    @foreach ($messages as $message)
                                <tr>
                                    <td class="for-mobil">{{$loop->index+1}}</td>
                                    <td>{{$message->Name}}</td>
                                    <td class="for-mobil">{{$message->PhoneStr}} </td>
                                    <td class="for-mobil">{{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$message->messageDate))->format('Y/m/d')}}</td>
                                    <td>شخصی</td>
                                    <td class="for-mobil" style="width:255px;">{{$message->messageContent}}</td>
                                    <td style="width:80px;">{{$message->countAll}} </td>
                                    <td @if($message->countUnread>0) class="existMsg" @else class="" @endif id="{{$message->PSN}}">@if($message->countUnread){{$message->countUnread}}@else 0 @endif </td>
                                    <td class="for-mobil">{{$message->countRead}} </td>
                                    <td style="text-align: center;"><button onclick="showMessages({{$message->PSN,$message->countUnread}})" id="customerViewMessageBtn" style="background-color: #fff;" > <i class="fa fa-eye 3x eyeIcon"> </i></button></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="customerMessage" tabindex="-1" role="dialog" aria-labelledby="customerMessageLabel" aria-hidden="true" style="position: absolute;">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success text-white py-2">
          <h5 class="modal-title" id="exampleModalLabel">پیام های  مشتری</h5>
          <button type="button" class="close text-white bg-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="modalBody">
          </div>
        </div>
        <div class="modal-footer"  id="replay">
                <textarea id="replayMessag" @if( hasPermission(Session::get("adminId"),"messageN") < 1) disabled @endif class="md-textarea form-control" placeholder="جواب شما..."  rows="3"></textarea>
                <a  @if(hasPermission(Session::get( 'adminId'),'messageN' ) > 0) onclick="replayMessage()" @endif class="btn btn-success btn-sm">جواب</a>
        </div>
      </div>
    </div>
  </div>
<script>
 window.onload = function() {
    $(document).on('click', '.form-check-input', (function() {
        $('#customerSn').val($(this).val().split('_')[0]);
        $('#customerGroup').val($(this).val().split('_')[1]);
    }));
 }
	

</script>
@endsection
