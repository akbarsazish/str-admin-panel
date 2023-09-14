@extends('admin.layout')
@section('content')
<style>
    .gamerListsTable, #aksIdeaTable, #usedTakhfifCaseTable .usedTakhfifCodeTable{
        display:none;
    }
</style>
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> بازیها و لاتری </legend>
                   
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="lotteryResultRadioBtn" checked>
                        <label class="form-check-label me-4" for="assesPast"> نتیجه لاتری  <span @if(wonLottery(Session::get('adminId')) < 1 ) class="headerNotifications0" @else  class="headerNotifications1" @endif style="border-radius: 50%; font-size:11px; padding:2px">@if(wonLottery(Session::get("adminId"))>0){{wonLottery(Session::get("adminId"))}} @else 0 @endif</span> &nbsp;&nbsp; </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="usedTakhfifCaseRadioBtn">
                        <label class="form-check-label me-4" for="assesPast"> استفاده از کیف پول  <span @if(usedTakhfifCase(Session::get('adminId')) < 1 ) class="headerNotifications0" @else  class="headerNotifications1" @endif style="border-radius: 50%; font-size:11px; padding:2px">@if(usedTakhfifCase(Session::get("adminId"))>0){{usedTakhfifCase(Session::get("adminId"))}} @else 0 @endif</span> &nbsp;&nbsp; </label>
                    </div>
					<div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="usedTakhfifCodeRadioBtn">
                        <label class="form-check-label me-4" for="usedTakhfifCodeRadioBtn">  استفاده از کد تخفیف  <span @if(usedTakhfifCode(Session::get('adminId')) < 1 ) class="headerNotifications0" @else  class="headerNotifications1" @endif style="border-radius: 50%; font-size:11px; padding:2px">@if(usedTakhfifCode(Session::get("adminId"))>0){{usedTakhfifCode(Session::get("adminId"))}} @else 0 @endif</span> &nbsp;&nbsp; </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="gamerListRadioBtn">
                        <label class="form-check-label me-4" for="assesPast"> گیمر لیست  <span @if(playedGame(Session::get('adminId')) < 1 ) class="headerNotifications0" @else  class="headerNotifications1" @endif style="border-radius: 50%; font-size:11px; padding:2px">@if(playedGame(Session::get("adminId"))>0){{playedGame(Session::get("adminId"))}} @else 0 @endif</span> &nbsp;&nbsp;  </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="askIdeaResponse">
                        <label class="form-check-label me-4" for="assesPast"> نتایج نظر خواهی  <span @if(hasNewNazar(Session::get('adminId')) < 1 ) class="headerNotifications0" @else  class="headerNotifications1" @endif style="border-radius: 50%; font-size:11px; padding:2px">@if(hasNewNazar(Session::get("adminId"))>0){{hasNewNazar(Session::get("adminId"))}} @else 0 @endif</span> &nbsp;&nbsp; </label>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">
                     <div class="col-sm-4">
                        <div class="form-group mt-2 text-end">
                            <button class="btn btn-sm btn-success usedTakhfifCaseTable" style="display:none" onclick="removeNewTakhfifCaseNotify()" type="button"> حذف نوتیفیکیشن </button>
                            <button class="btn btn-sm btn-success usedTakhfifCodeTable" style="display:none" onclick="removeNewTakhfifCodeNotify()" type="button"> حذف نوتیفیکیشن </button>
                            <button class="btn btn-sm btn-success playedGame" style="display:none" onclick="removeNewPlayedGameScores()" type="button"> حذف نوتیفیکیشن </button>
                        </div>
                     </div>
                 </div>
                <div class="row mainContent">
                    <table class="table table-bordered table-sm" id="lotteryResultTable">
                         <thead class="tableHeader">
                            <tr>
                                <th> ردیف </th>
                                <th> نام مشتری </th>
                                <th> شماره تماس</th>
                                <th> تاریخ </th>
                                <th> جایزه </th>
                                <th> تاریخ تسویه </th>
                                <th> تسویه </th>
                                <th>  حذف  </th>
                            </tr>
                        </thead>
                        <tbody class="tableBody" style="height:222px !important;">
                            @foreach ($lotteryTryResult as $lottery)
                                <tr>
                                    <td style="width:60px">{{$loop->iteration}}</td>
                                    <td>{{$lottery->Name}}</td>
                                    <td>{{$lottery->PhoneStr}}</td>
                                    <td>{{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$lottery->lastTryDate))->format('Y/m/d')}}</td>
                                    <td>{{$lottery->wonPrize}} </td>
                                    @if($lottery->Istaken==1)
                                    <td>{{\Morilog\Jalali\Jalalian::fromCarbon(Carbon\Carbon::createFromFormat('Y-m-d',$lottery->tasviyahDate))->format('Y/m/d')}} </td>
                                    @else
                                    <td>تسویه نشده</td>
                                    @endif
                                    @if($lottery->Istaken==1)
                                    <td>تسویه شده </td>
                                    @else
                                    <td>تسویه نشده</td>
                                    @endif
                                    <td><div>
                                    @if($lottery->Istaken==0)
                                        <form action="{{url('/tasviyeahLottery')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="customerId" value="{{$lottery->customerId}}">
                                            <input type="hidden" name="lotteryTryId" value="{{$lottery->id}}">
                                        <button type="submit" class="btn btn-sm btn-info">تسویه</button>
                                        </form>
                                        @else
                                    تسویه شده
                                    @endif
                                    </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- کیف تخفیفی   -->
                    <table class="table table-bordered table-sm usedTakhfifCaseTable" id="usedTakhfifCaseTable" style="display:none;">
                        <thead class="tableHeader">
                        <tr>
                            <th> ردیف </th>
                            <th> کد </th>
                            <th> نام مشتری </th>
                            <th> شماره تماس </th>
                            <th> مبلغ (تومان) </th>
                            <th> تاریخ </th>
                        </tr>
                        </thead>
                        <tbody class="tableBody">
                            @foreach($takhfifCaseResult as $takhfifResult)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$takhfifResult->PCode}}</td>
                                    <td>{{$takhfifResult->Name}}</td>
                                    <td>{{$takhfifResult->PhoneStr}}</td>
                                    <td>{{number_format($takhfifResult->money/10)}}</td>
                                    <td>{{$takhfifResult->usedDate}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- کد تخفیفی   -->
                    <table class="table table-bordered table-sm usedTakhfifCodeTable" id="usedTakhfifCodeTable">
                        <thead class="tableHeader">
                        <tr>
                            <th> ردیف </th>
                            <th> کد </th>
                            <th> نام مشتری </th>
                            <th> شماره تماس </th>
                            <th> مبلغ (تومان) </th>
                            <th> تاریخ </th>
                        </tr>
                        </thead>
                        <tbody class="tableBody">
                            @foreach($usedTakhfifCodes as $code)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$code->PCode}}</td>
                                    <td>{{$code->Name}}</td>
                                    <td>{{$code->PhoneStr}}</td>
                                    <td>{{number_format($code->UsedMoney/10)}}</td>
                                    <td>{{$code->UsedDate}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- گیمر لیست  -->
                    <table class="table table-bordered table-sm playedGame">
                        <thead class="tableHeader">
                        <tr>
                            <th>ردیف</th>
                            <th>بازی</th>
                            <th> نام مشتری </th>
                            <th>شماره تماس</th>
                            <th>جایزه (تومان)</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody class="tableBody">
                            @foreach ($players as $player)
                                <tr>
                                    <td>{{number_format($loop->index+1)}}</td>
                                    <td>{{$player->GameName}}</td>
                                    <td>{{$player->Name}}</td>
                                    <td>{{$player->PhoneStr}}</td>
                                    <td>{{number_format($player->prize)}}</td>
                                    <td> <i class="fa fa-trash" style="color:red; cursor:pointer"></i> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- نتایج نظر خواهی  -->
                    <div class="row rounded-2 tab-pane" id="aksIdeaTable">
                    <div class="col-lg-12" id="nazaranjicontainer">
                        @foreach($nazars as $nazar)
                        <fieldset class="fieldsetBorder rounded mb-2">
                            <legend  class="float-none w-auto forLegend" style="font-size:14px; margin-bottom:2px;"> {{$nazar->Name}} </legend>	
                            <div class="idea-container">
                                <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},1)"> 1- {{trim($nazar->question1)}} </button>
                                <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},2)"> 2- {{trim($nazar->question2)}} </button>
                                <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},3)"> 3- {{trim($nazar->question3)}} </button>
                                <div class="form-check mt-1">
                                    <input class="form-check-input nazarIdRadio p-2" onclick="editNazar(this)" type="radio" name="nazarNameRadio" value="{{$nazar->nazarId}}" id="">
                                </div>
                            </div>
                        </fieldset>
                        @endforeach
                        <hr>              
                    </div>
                </div>
                <div class="row contentFooter"> </div>
            </div>
        </div>
     </div>
 </div>
<!-- question Modal  -->
<div class="modal fade" id="listQuestionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="listQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="listQuestionModalLabel"> کیفیت کالا  چگونه بود ؟</h5>
      </div>
      <div class="modal-body">
      <div class="card mb-4">
            <div class="card-body">
                <div class="row">
					<div class="col-lg-12">
                      <div class="well">
                        <table class="table table-bordered" id="tableGroupList" >
                            <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام  مشتری</th>
                                    <th> جواب </th>
                                    <th> تاریخ </th>
                                    <th> حذف  </th>
                                </tr>
                            </thead>
                            <tbody class="tableBody" id="nazarListBody">
                                
                            </tbody>
                        </table>
                      </div>
                    </div>
              </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">بستن <i class="fa fa-xmark"></i> </button>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal  view of questions -->
<div class="modal fade" id="viewQuestionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="viewQuestionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
          <h5 class="modal-title" id="viewQuestionLabel"> جواب نظر سنجی  </h5>
      </div>
      <div class="modal-body">
         <div class="row">
              <table class="table table-bordered" id="tableGroupList" >
				  <thead class="tableHeader">
					  <tr>
						  <th>ردیف</th>
						  <th>  سوالات  </th>
						  <th> جوابات </th>
						   <th> حذف </th>
					  </tr>
				  </thead>
				  <tbody class="tableBody">
						  <tr>
							  <th scope="row">1</th>
							  <td>کیفیت کالاهای ما چگونه است؟ </td>
							  <td>کیفت کالا خوب است </td>
							  <td> <i class="fa fa-trash" style="color:red"> </i> </td>
						 </tr>
					     <tr>
						   <th scope="row">2</th>
						   <td>کیفیت کالاهای ما چگونه است؟ </td>
						   <td>کیفت کالا خوب است </td>
						   <td> <i class="fa fa-trash" style="color:red"> </i> </td>
					    </tr>
					   <tr>
						   <th scope="row">3</th>
						   <td>کیفیت کالاهای ما چگونه است؟ </td>
						   <td>کیفت کالا خوب است </td>
						   <td> <i class="fa fa-trash" style="color:red"> </i> </td>
					  </tr>
				  </tbody>
			 </table>
         </div>
      </div>
    </div>
  </div>
</div>

@endsection
