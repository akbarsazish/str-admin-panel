@extends('admin.layout')
@section('content')

<style>
    .send-discound-code {
        bottom:10%;
        position:relative;
    }
</style>
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> وضعیت دریافت کد تخفیف </legend>
                <input type="hidden" id="modelSn" name="ModelId" value={{$modelSn}}>
					<input type="hidden" id="sabtDate" name="sabtDate" value={{$sabtDate}}>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group input-group-sm mt-1">
                                <span class="input-group-text" id="inputGroup-sizing-sm">  وضعیت دریافت </span>
                                <select name="original" class="form-select" id="SMSSentState">
									<option value="-1" class="receive"> همه </option>
                                    <option value="1" class="receive"> دریافت کرده </option>
                                    <option value="0" class="receive"> دریافت نکرده </option>
                                </select>
								<span class="input-group-text" id="inputGroup-sizing-sm">  وضعیت استفاده از کد </span>
                                <select name="codeUseState" class="form-select" id="codeUseState">
									<option value="" class="receive"> همه </option>
									<option value="1" class="receive"> استفاده کرده </option>
									<option value="0" class="receive"> استفاده نکرده </option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-2"> 
                        <button class="btn btn-sm btn-success" id="searchnotificationsBtn" onclick="filterSentSMSById()"> بازخوانی <i class="fa fa-history"></i> </button>
                    </div>
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">
					<div class="col-sm-12 text-end mt-1 customerListStaff">
						<button class="btn btn-sm btn-success">ارسال دوباره</button>
					</div>
                </div>
                <div class="row mainContent">
                   <div class="col-lg-12 mx-0 px-0" id="notificationReport">
                        <table class="table table-bordered table-sm">
                            <thead class="tableHeader">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>  تاریخ   </th>
                                        <th> مشتری </th>
                                        <th>  کد تخفیف  </th>
                                        <th> وضعیت دریافت  </th>
										<th> وضعیت استفاده  </th>
                                        <th>انتخاب</th>
                                    </tr>
                            </thead>
                            <tbody class="tableBody" id="sentDiscountCodeList">
								@foreach($sms as $message)
                                 <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$message->hijriDate}} </td>
                                    <td> {{$message->Name}} </td>
                                    <td> {{$message->Code}} </td>
                                    <td>@if(strlen($message->ResponseCode)>15) موفق @else ناموفق @endif </td>
									 <td> @if($message->isUsed==1) استفاده شده @else استفاه نشده @endif </td>
                                    <td> <input type="radio" name="selectModel" > </td>
                                 </tr>
								@endforeach
                            </tbody>
                        </table>
                   </div>
                </div>
                <div class="row contentFooter"> 
                    <div class="button-container">
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success" onclick="getSMSHistroy('TODAY',document.getElementById('modelSn').value)"> امروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success" onclick="getSMSHistroy('YESTERDAY',document.getElementById('modelSn').value)">  دیروز  </button>
                            </div>
                            <div class="button-item">
                                <button type="button" class="btn btn-sm btn-success" onclick="getSMSHistroy('LASTHUNDRED',document.getElementById('modelSn').value)">  صدتای آخر  </button>
                            </div>
                            <div class="button-item">
                                 <button type="button" class="btn btn-sm btn-success" onclick="getSMSHistroy('ALL',document.getElementById('modelSn').value)"> همه   </button>
                            </div>
                    </div>
                </div>
            </div>
    </div>
</div>



@endsection