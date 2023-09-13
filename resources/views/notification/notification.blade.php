@extends('admin.layout')
@section('content')


<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> نوتفیکیشن </legend>
                
                    <div class="col-sm-12">
                        <div class="input-group input-group-sm mt-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> از تاریخ  </span>
                            <input type="text" class="form-control" id="firstDateSearchNotification">
                        </div>
                    </div>

                    <div class="col-sm-12">                        
                        <div class="input-group input-group-sm mt-1">
                            <span class="input-group-text" id="inputGroup-sizing-sm"> تا تاریخ  </span>
                            <input type="text" class="form-control" id="secondDateSearchNotification">
                        </div>
                    </div>

                    <div class="col-sm-12">                        
                        <div class="input-group input-group-sm mt-1">
                        
                            <button class="btn btn-sm btn-success" id="searchnotificationsBtn" onclick="searchNotificationsByDate()"> بازخوانی <i class="fa fa-history"></i> </button>

                        </div>
                    </div>

                    <div class="col-sm-12 text-center mt-2"> 
                        <button class="btn btn-sm btn-success" id="sendNotificationBtn"> نوتیفیکیشن جدید <i class="fa fa-send"></i> </button>
                    </div>
                    
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader"> 
					<div class="col-sm-12 text-end mt-1 customerListStaff">
						<div>
							@if($settings[0]->showDeleteNotification==1)
							<button class="btn btn-sm btn-danger" id="deleteNotificationHistoryBtn"> حذف تاریخچه </button>
							@endif
						</div>
					</div>
                </div>
                <div class="row mainContent">
                   <div class="col-lg-12 mx-0 px-0" id="notificationReport">
                        <table class="table table-bordered table-sm">
                            <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th> کد  </th>
                                        <th>  تاریخ   </th>
                                        <th> اسم  </th>
                                        <th> عنوان </th>
                                        <th>  متن  </th>
                                        <th>انتخاب</th>
                                    </tr>
                            </thead>
                            <tbody class="tableBody" id="sentNotifList">
                                @foreach($notifications as $notify)
                                    <tr>
                                        <td> {{$loop->iteration}} </td>
                                        <td> {{$notify->PCode}} </td>
                                        <td> {{$notify->sendPersianDate}} </td>
                                        <td> {{$notify->Name}} </td>
                                        <td> {{$notify->title}} </td>
                                        <td> {{$notify->body}} </td>
                                        <td> <input class="form-check-input" type="radio" value="" id="" name="notificationRadio"> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                </div>
                <div class="row contentFooter"> 
                    <div class="button-container">
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success"> امروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success">  دیروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success">  صدتای آخر  </button>
                            </div>
                            <div class="button-item">
                                 <button type="button" class="btn btn-sm btn-success"> همه   </button>
                            </div>
                    </div>
                </div>
            </div>
    </div>
</div>



<!-- Modal for sendign notification individually -->
<div class="modal fade" id="sendNotificationModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-fullscreen" style=" overflow-x: hidden !important; overflow-y:visiable">
    <div class="modal-content">
      <div class="modal-header py-2 bg-success text-white">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> نوتیفیکیشن جدید </h5>
        </div>
      <div class="modal-body p-1"> 
           <div class="row mb-1 rounded">
           </div>
            <div class="notificationTable">
                <div class="firstFr">  
					<label  class="form-label mb-1 fs-6"> شهر </label>                          
					<div class="input-group input-group-sm">
						<select class="form-select form-select-sm" id="searchCityNotification">
							<option value="0">همه</option>
							@foreach($cities as $city)
								<option value="{{$city->SnMNM}}">{{$city->NameRec}}</option>
							@endforeach
						</select>
					</div>
					<label  class="form-label mb-1 fs-6"> منطقه </label>                          
					<div class="input-group input-group-sm">
						<select class="form-select form-select-sm" id="selectMantiqahNotification">
						</select>
					</div>
					<label  class="form-label mb-1 fs-6"> پشتیبان </label>                          
					<div class="input-group input-group-sm">
						<select class="form-select form-select-sm" id="poshtibanName">
							<option value="">همه</option>
							@foreach($poshtibans as $poshtiban)
								<option value="{{$poshtiban->name.''.$poshtiban->lastName}}">{{$poshtiban->name.' '.$poshtiban->lastName}}</option>
							@endforeach
						</select>
					</div>
					<label  class="form-label mb-1 fs-6"> جستجو </label>    
					<input type="text" class="form-control form-control-sm" id="bynameCodePhoneSearch">
					<label  class="form-label mb-1 fs-6">  از تاریخ خرید </label>    
					<input type="text" name="secondDateBuy" placeholder="" class="form-control form-control-sm" id="firstDateNotify">
					<label  class="form-label mb-1 fs-6"> تا تاریخ خرید </label>    
					<input type="text" class="form-control form-control-sm" id="secondDateNotify">
					<button class="btn btn-sm btn-success m-2" onclick="searchCustomersForNotification()">جستجو</button>
                </div>
                <div class="secondFr">
                    <table class="table table-bordered table-sm">
                        <thead class="tableHeader">
                                <tr>
                                    <th>  ردیف  </th>
                                    <th>  مشتری  </th>
                                    <th>  شماره تماس </th>
                                    <th>  <input type="checkbox" class="selectAllFromTop form-check-input">  </th>
                                </tr>
                        </thead>
                        <tbody class="tableBody" id="customerList" style="height:calc(100vh - 220px)">
                        </tbody>
                    </table>
                </div>
                <div class="thirdFr">
                   <div class='modal-body' style="position:relative; right: 15%; top: 30%;">
                        <div style="">
                            <a id="addToNotify">
                            	<i class="fa-regular fa-circle-chevron-left fa-4x chevronHover"></i>
                            </a>
                            <br />
                            <a id="removeFromNotify">
                                <i class="fa-regular fa-circle-chevron-right fa-4x chevronHover"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="fourthFr"> 
                    <table class="table table-bordered table-sm">
                        <thead class="tableHeader">
                            <tr>
                                <th> ردیف </th>
                                <th>  مشتری  </th>
                                <th>  انتخاب </th>
                            </tr>
                        </thead>
                        <tbody class="tableBody" id="addedCustomes" style="height:calc(100vh - 220px)">
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">  بستن  </button>
        <button type="button" class="btn btn-success btn-sm" id="sendIdividuallyBtn" data-target="#sendNotiveModal" data-toggle="modal"> افزودن پیام </button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for sendign notification  -->
<div class="modal fade" id="sendNotiveModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header py-2 text-white" style="background-color:#0b4e2f">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="staticBackdropLabel"> ارسال نوتفیکیشن    </h5>
        </div>
      <div class="modal-body">
         <div class="mb-0">
            <label for="exampleFormControlInput1" class="form-label fs-6"> عنوان </label>
            <input type="text" class="form-control" id="title" required>
         </div>
         <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label fs-6"> متن </label>
            <textarea class="form-control" id="content" rows="5" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">  بستن  </button>
        <button type="button" onclick="sendNotification()" class="btn btn-success btn-sm"> ارسال </button>
      </div>
    </div>
  </div>
</div>
<script>
    function sendNotification() {
        var customerListID = [];
        let title=$("#title").val();
        let content=$("#content").val();
        let customers=$("#customers").val();
        $('input[name="addCustomerToNotify[]"]:checked').map(function () {
            customerListID.push($(this).val());
        });
        $.post("https://starfoods.ir/addNotificationMessage",{_token: "{{ csrf_token() }}",title:title,content:content,customerIDs:customerListID},function(response,status){
            
            if(response.done===1){
                $("#sentNotifList").empty();
                response.notifications.forEach((element,index)=>{
    
                    $("#sentNotifList").append(
                        `<tr>
                            <td> `+(index+1)+` </td>
                            <td> `+element.Name+` </td>
                            <td> `+element.PCode+` </td>
                            <td> `+element.title+` </td>
                            <td> `+element.body+` </td>
                            <td> `+element.sendPersianDate+` </td>
                            <td> <input class="form-check-input" type="radio" value="" name="notificationRadio"> </td>
                        </tr>`);
    
                });
                $('#addedCustomes').empty();
                $("#customerList").empty();
                $("#sendNotiveModal").modal("hide");
                $("#sendNotificationModal").modal("hide");
            }else{
                alert("اطلاعات قبلا وارد نشده است.");
            }
    
        })
        
    }
    </script>
@endsection