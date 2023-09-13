@extends('admin.layout')
@section('content')
<style>
.targetCheck{
    width:22px;
    height:22px;
    border-radius:50%;
}
.targetLabel {
    margin-top:5px;
}
.selectBg {
	background-color:red;
	}

#nazaranjicontainer {
      height:388px !important; 
      overflow-y:scroll !important;
      display:block !important;
  }
	
</style>

<div class="container topDistance">
    <div class="c-checkout container-fluid" style="background: linear-gradient(#3ccc7a, #034620); margin:0.2% 0; margin-bottom:0; padding:0.5% !important; border-radius:10px 10px 2px 2px;">
      <div class="col-sm-4" style="margin: 0; padding:0;">
        <ul class="header-list nav nav-tabs" data-tabs="tabs" style="margin: 0; padding:0;">
          <li><a class="active"  data-toggle="tab" style="color:black;"  href="#prizeSettings">تنظیمات جوایز لاتری</a></li>
          <li><a  data-toggle="tab" style="color:black;"  href="#askIdea">  نظر خواهی </a></li>
        </ul>
      </div>
      <div class="c-checkout tab-content" style="background-color:#f5f5f5; margin:0;  padding:0.3%; border-radius:10px 10px 2px 2px;">
        <!-- کالاهای لاتری -->
        <div class="row c-checkout rounded-3 tab-pane active" id="prizeSettings" style="width:99%; margin:0 auto; padding:1% 0% 0% 0%">
            <div class="row">
                <div class="col-lg-12 text-end">
                     <button  data-toggle="modal" type="button"  class="btn btn-sm btn-success text-warning" id="editLotteryPrizeBtn" > ویرایش لاتاری  <i class="fa fa-edit"> </i> </button>
                </div>
            </div>
            <div class="row p-3">
              <div class="prizeSettingTab">
                <div> <span class="prizeName"> جایزه اول :</span>   {{$prizes[0]->firstPrize}} </div>
                <div> <span class="prizeName"> جایزه دوم:  </span> {{$prizes[0]->secondPrize}}</div>
                <div> <span class="prizeName"> جایزه سوم: </span> {{$prizes[0]->thirdPrize}} </div>  
                <div> <span class="prizeName"> جایزه چهارم : </span> {{$prizes[0]->fourthPrize}} </div>
                <div> <span class="prizeName"> جایزه پنجم : </span> {{$prizes[0]->fifthPrize}} </div>
                <div> <span class="prizeName"> جایزه ششم : </span> {{$prizes[0]->sixthPrize}} </div>
                <div> <span class="prizeName"> جایزه هفتم : </span> {{$prizes[0]->seventhPrize}} </div>
                <div> <span class="prizeName"> جایزه هشتم : </span>  {{$prizes[0]->eightthPrize}} </div>
                <div> <span class="prizeName"> جایزه نهم :</span> {{$prizes[0]->ninethPrize}}  </div>
                <div> <span class="prizeName"> جایزه دهم: </span>   {{$prizes[0]->teenthPrize}} </div>
                <div> <span class="prizeName"> جایزه یازدهم :</span>  {{$prizes[0]->eleventhPrize}}  </div>
                <div> <span class="prizeName"> جایزه دوازدهم :</span> {{$prizes[0]->twelvthPrize}}  </div>
                <div> <span class="prizeName"> جایزه سیزدهم :</span> {{$prizes[0]->therteenthPrize}}  </div>
                <div> <span class="prizeName"> جایزه چهاردهم: </span> {{$prizes[0]->fourteenthPrize}}  </div>
                <div> <span class="prizeName"> جایزه پانزدهم: </span> {{$prizes[0]->fifteenthPrize}}  </div>
                <div> <span class="prizeName"> جایزه شانزدهم: </span> {{$prizes[0]->sixteenthPrize}}  </div>
              </div>
              <div class="tab-pane" id="LotterySetting">
                <div class="c-checkout" style="border-radius:10px 10px 2px 2px;">
                  <div class="row p-4">
                    <div class="col-sm-12">
                      <div class="row form-group">
                        <div class="col-sm-3"  style="padding:0">
                          <div>  &nbsp; <i class="fa fa-bullseye 4x" style="color:green; font-size:22px;"></i> <span class="prizeName">حد اقل امتیاز لاتری : {{number_format($lotteryMinBonus)}} </span></div>
                        </div>
                        <div class="col-sm-6" style="margin:0">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>	
            </div> 
            <hr>
             <div class="row text-center me-2">
                <input type="hidden" name="" id="selectTargetId">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 mb-1">
                      <select class="form-select  form-select-sm" aria-label="Default select example" id="selectTarget">
                        @foreach($targets as $target)
                          <option value="{{$target->id}}">{{$target->baseName}}</option>
                        @endforeach
                      </select>
                  </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 mt-3">
                      <!-- <span data-toggle="modal" data-target="#addingTargetModal"><i class="fa fa-plus-circle fa-lg" style="color:#1684db; font-size:33px"></i></span> -->
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 text-end">
                      <button class='btn btn-sm btn-success text-warning' id="targetEditBtn" type="button" disabled  data-toggle="modal" style="margin-top:-3px;">ویرایش تارگت<i class="fa fa-edit fa-lg"></i></button> 
                      <!-- <button class='btn btn-danger text-warning' disabled style="margin-top:-3px;" id="deleteTargetBtn"> حذف <i class="fa fa-trash fa-lg"></i></button>  -->
                    </div>
                </div>

                <div class="row">
                  <table class="table table-bordered border-secondary">
                    <thead>
                      <tr class="targetTableTr">
                      <th scope="col"> ردیف </th>
                        <th scope="col"> اسم تارگت </th>
                        <th scope="col">تارگیت 1</th>
                        <th scope="col"> امتیاز 1</th>
                        <th scope="col">تارگیت 2</th>
                        <th scope="col"> امتیاز 2</th>
                        <th scope="col">تارگیت 3</th>
                        <th scope="col"> امتیاز 3</th>
                        <th scope="col"> انتخاب  </th>
                      </tr>
                    </thead>
                    <tbody id="targetList">
                      @foreach($targets as $target)
                      <tr class="targetTableTr" onclick="setTargetStuff(this)">
                      <td>{{$loop->iteration}}</td>
                          <td>{{$target->baseName}}</td>
                          <td> {{number_format($target->firstTarget)}}</td>
                          <td> {{$target->firstTargetBonus}} </td>
                          <td> {{number_format($target->secondTarget)}}</td>
                          <td> {{$target->secondTargetBonus}} </td>
                          <td> {{number_format($target->thirdTarget)}}</td>
                          <td> {{$target->thirdTargetBonus}} </td>
                          <td> <input class="form-check-input" name="targetId" type="radio" value="{{$target->id}}"></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
		  
            <div class="row c-checkout rounded-3 tab-pane" id="askIdea" style="width:99%; margin:0 auto; padding:1% 0% 0% 0%">
              <div class="col-lg-12 text-end">
                 <button type="button" class="btn btn-sm btn-success" id="insetQuestionBtn"> افزودن  <i class="fa fa-plus"></i> </button>
				 <button type="button" class="btn btn-sm btn-success" id="editQuestionBtn" disabled> ویرایش  <i class="fa fa-edit" style="color:yellow"></i> </button>
			
				   <button type="button" class="btn btn-sm btn-success" onclick="startAgainNazar()" id="startAgainNazarBtn" disabled> از سرگیری نظر خواهی <i class="fa fa-history" style="color:white"></i> </button>
              </div>
              <div class="col-lg-12" id="nazaranjicontainer">
                @foreach($nazars as $nazar)
                  <fieldset class="fieldsetBorder rounded mb-3">
                    <legend  class="float-none w-auto forLegend"> {{$nazar->Name}} </legend>	
					    
                    <div class="idea-container">
                   
					 <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},1)">
                          1- {{trim($nazar->question1)}}
                      </button>
                      <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},2)">
                          2- {{trim($nazar->question2)}}
                      </button>
                      <button class="idea-item listQuestionBtn" onclick="showAnswers({{$nazar->nazarId}},3)">
                           3- {{trim($nazar->question3)}}
                      </button>
						  <div class="form-check mt-1">
						  <input class="form-check-input nazarIdRadio p-3" onclick="editNazar(this)" type="radio" name="nazarNameRadio" value="{{$nazar->nazarId}}" id="">
						</div>
                    </div>
                  </fieldset>
                @endforeach
              </div> <hr>
			 <div class="col-lg-12">
				<table class="table table-striped table-bordered">
					  <thead class="tableHeader">
						<tr>
						  <th scope="col"> دریف </th>
						  <th scope="col"> نام مشتری </th>
						  <th scope="col"> تاریخ </th>
						  <th scope="col"> نظر سنجی </th>
						  <th scope="col">جوابات </th>
						  <th scope="col"> <input type="checkbox"  name="" class="selectAllFromTop form-check-input"/>  </th>
						</tr>
					  </thead>
					  <tbody class="tableBody">
						<tr>
						  <th scope="row">1</th>
						  <td> محمود الیاسی  </td>
						  <td>12/12/1401 </td>
						  <td> نظر سنجی 1401  </td>
						  <td id="viewQuestion"><i class="fa fa-eye"/></td>
						  <td id="checkToStartAgainNazar">  <input class="form-check-input" name="" type="checkbox" value=""> </td>
						</tr>
					  </tbody>
					</table>
			 </div>
            </div>
          </div>
<!-- کالاهای لاتری -->
      </div>
    </div>   
  </div>

<!-- add target-->
<div class="modal fade dragableModal" id="addingTargetModal" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(#3ccc7a, #034620); color:white;">
          <button type="button" class="btn-close text-danger" data-dismiss="modal" aria-label="Close" style="color:red"></button>
          <h5 class="modal-title" id="staticBackdropLabel">  افزودن تارگت  </h5>
      </div>
      <form action="{{url('/addTarget')}}" method="GET" id="addTarget">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> اساس تارگت </label>
                <input type="text" class="form-control" placeholder="خرید اولیه"  name="baseName" aria-describedby="emailHelp">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 1 </label>
                <input type="text" class="form-control" placeholder="تارگت 1" name="firstTarget" aria-describedby="emailHelp">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگیت 1  </label>
                <input type="text" class="form-control" placeholder="" name="firstTargetBonus" aria-describedby="emailHelp">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 2 </label>
                <input type="text" class="form-control" placeholder="تارگت 2" name="secondTarget" aria-describedby="emailHelp">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 2   </label>
                <input type="number" class="form-control" placeholder="20" name="secondTargetBonus" aria-describedby="emailHelp">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگیت 3   </label>
                <input type="number" class="form-control" placeholder="23" name="thirdTarget" aria-describedby="emailHelp">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 3   </label>
                <input type="number" class="form-control" placeholder="20" name="thirdTargetBonus" aria-describedby="emailHelp">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
          <button type="submit" class="btn btn-primary">ذخیره <i class="fa fa-save "></i> </button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- edit target modal -->
<div class="modal fade dragableModal" id="editingTargetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(#3ccc7a, #034620); color:white;">
          <button type="button" class="btn-close text-danger bg-danger" data-dismiss="modal" aria-label="Close" style="color:red"></button>
        <h5 class="modal-title" id="staticBackdropLabel"> ویرایش تارگت </h5>
      </div>
      <form action="{{url('/editTarget')}}" method="GET" id="editTarget">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> اساس تارگت </label>
                <input type="text" class="form-control" disabled placeholder="خرید اولیه"  name="baseName" id="baseName" aria-describedby="emailHelp">
                <input type="hidden" name="targetId" id="targetIdForEdit">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 1 </label>
                <input type="text" class="form-control" placeholder="تارگت 1" name="firstTarget" id="firstTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگیت 1  </label>
                <input type="text" class="form-control" placeholder="" name="firstTargetBonus" id="firstTargetBonus">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگت 2 </label>
                <input type="text" class="form-control" placeholder="تارگت 2" name="secondTarget" id="secondTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 2   </label>
                <input type="text" class="form-control" placeholder="20" name="secondTargetBonus" id="secondTargetBonus">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  تارگیت 3   </label>
                <input type="text" class="form-control" placeholder="23" name="thirdTarget" id="thirdTarget">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">  امتیاز تارگت 3   </label>
                <input type="text" class="form-control" placeholder="20" name="thirdTargetBonus" id="thirdTargetBonus">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
          <button type="submit" class="btn btn-success btn-sm">ذخیره <i class="fa fa-save"></i> </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Bazaryab Modal -->
<div class="modal fade dragableModal" id="editLotteryPrizes" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-white" style="background: linear-gradient(#3ccc7a, #034620); color:white;">
          <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close" style="color:red"></button>
        <h5 class="modal-title" id="staticBackdropLabel">  ویرایش لاتری  </h5>
      </div>
      <form action="{{url('/editLotteryPrize')}}" method="GET" id="addTarget">
        <div class="modal-body">
          <div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> اول  </span>
					       <input type="text" class="form-control" name="firstPrize" id="LotfirstPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showfirstPrize[]" id="showfirstPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دوم   </span>
					       <input type="text" class="form-control" name="secondPrize" id="LotsecondPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showsecondPrize[]" id="showsecondPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> سوم  </span>
					       <input type="text" class="form-control" name="thirdPrize" id="LotthirdPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox m-1" name="showthirdPrize[]" id="showthirdPrize">
					</div>
			  </div>
			 </div>
			
			 <div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> چهارم  </span>
					       <input type="text" class="form-control" name="fourthPrize" id="LotfourthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showfourthPrize[]" id="showfourthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> پنجم   </span>
					       <input type="text" class="form-control" name="fifthPrize" id="LotfifthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showfifthPrize[]" id="showfifthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> ششم  </span>
					       <input type="text" class="form-control" name="sixthPrize" id="LotsixthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox  m-1" name="showsixthPrize[]" id="showsixthPrize">
					</div>
			  </div>
			 </div>
			
			<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> هفتم   </span>
					       <input type="text" class="form-control" name="seventhPrize" id="LotseventhPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showseventhPrize[]" id="showseventhPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> هشتم    </span>
					       <input type="text" class="form-control" name="eightthPrize" id="LoteightthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showeightthPrize[]" id="showeightthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> نهم  </span>
					       <input type="text" class="form-control"  name="ninethPrize" id="LotninethPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showninethPrize[]" id="showninethPrize">
					</div>
			  </div>
			 </div>
			
			
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دهم    </span>
					       <input type="text" class="form-control" name="teenthPrize" id="LotteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showteenthPrize[]" id="showteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> یازده هم     </span>
					       <input type="text" class="form-control"  name="eleventhPrize" id="LoteleventhPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	   <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showeleventhPrize[]" id="showeleventhPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> دوازده هم  </span>
					       <input type="text" class="form-control" name="twelvthPrize" id="LottwelvthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  		 <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showtwelvthPrize[]" id="showtwelvthPrize">
					</div>
			  </div>
			 </div>
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm"> سیزدهم     </span>
					       <input type="text" class="form-control" name="thirteenthPrize" id="LotthirteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showthirteenthPrize[]" id="showthirteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm">چهاردهم      </span>
					       <input type="text" class="form-control" name="fourteenthPrize" id="LotfourteenthPrize" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showfourteenthPrize[]" id="showfourteenthPrize">
					</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
					    	<span class="input-group-text" id="inputGroup-sizing-sm">  پانزدهم   </span>
					       <input type="text" class="form-control" name="fiftheenthPrize" id="LotfiftheenthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					  	<input type="checkbox" class="form-checkbox m-1" name="showfiftheenthPrize[]" id="showfiftheenthPrize">
					</div>
			  </div>
			 </div>
			
		<div class="row">
			  <div class="col-lg-4 col-md-4 col-sm-4"> 
				  <div class="input-group input-group-sm mb-3">
				     <span class="input-group-text" id="inputGroup-sizing-sm">  شانزدهم    </span>
				    <input type="text" class="form-control" name="sixteenthPrize" id="LotsixteenthPrize"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
				  <input type="checkbox" class="form-checkbox prizeCheckbox m-1" name="showsixteenthPrize[]" id="showsixteenthPrize">
				  </div>
			</div>
			 <div class="col-lg-4 col-md-4 col-sm-4"> 

			</div>
		</div>
		
		 </div>
        <div class="modal-footer">
          <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm"> حد اقل امتیاز لاتری  </span>
                <input type="text" class="form-control form-control-sm" @if(hasPermission(Session::get( 'adminId'),'specialSetting' ) < 1) disabled @endif value="{{number_format($lotteryMinBonus)}}" name="lotteryMinBonus">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-group input-group-sm mb-3 d-start">
                <button type="button" class="btn btn-danger btn-sm d-end" data-dismiss="modal"> بستن <i class="fa fa-xmark"></i> </button>
                <button type="submit" class="btn btn-success btn-sm">ذخیره <i class="fa fa-save"></i> </button>
              </div>
            </div>
          </div>  
        </div>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- question Modal  -->
<div class="modal fade" id="listQuestionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="listQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
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



<!-- question Modal  -->
<div class="modal fade" id="insetQuestion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insetQuestionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{url('/addNazarSanji')}}" method="get" id="addNazarSanjiForm">
        @csrf
      <div class="modal-header bg-success text-white">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="insetQuestionLabel"> نظر سنجی جدید </h5>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-2">
                  <label for="exampleFormControlTextarea1" class="form-label fs-6">اسم نظر سنجی</label>
                  <input class="form-control" id="nazarSanjiName" name="nazarSanjiName">
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea2" class="form-label fs-6"> سوال اول </label>
                  <textarea class="form-control" id="content1" name="content1" rows="3"></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea3" class="form-label fs-6"> سوال دوم  </label>
                  <textarea class="form-control" id="content2" name="content2" rows="3"></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea4" class="form-label fs-6"> سوال سوم  </label>
                  <textarea class="form-control" id="content3" name="content3" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">بستن <i class="fa fa-xmark"></i> </button>
        <button type="submit" class="btn btn-success btn-sm"> ذخیره  <i class="fa fa-save"></i></button>
      </div>
    </form>
  </div>
</div>
</div>


<!-- Button trigger modal -->


<!-- Modal edit nazarSanji -->
<div class="modal fade" id="editNazarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editNazarModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <button type="button" class="btn-close bg-danger" data-dismiss="modal" aria-label="Close"></button>
		   <h5 class="modal-title" id="editNazarModal"> ویرایش نظر سنجی  </h5>
      </div>
	 <form action="{{url('/updateQuestion')}}" method="get" id="updateQuestion">
        @csrf
		  <input type="hidden" name="nazarId" id="nazarId" value="">
        <div class="modal-body">
          <div class="card mb-4">
            <div class="card-body">
             <div class="row">
              <div class="col-lg-12">
                <div class="mb-2">
                  <label for="exampleFormControlTextarea1" class="form-label fs-6">اسم نظر سنجی</label>
                  <input class="form-control" id="nazarName1" name="nazarSanjiName" value="">
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea2" class="form-label fs-6"> سوال اول </label>
                  <textarea class="form-control" id="cont1" name="content1" rows="2" value=""></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea3" class="form-label fs-6"> سوال دوم  </label>
                  <textarea class="form-control" id="cont2" name="content2" rows="2" value=""></textarea>
                </div>
                <div class="mb-2">
                  <label for="exampleFormControlTextarea4" class="form-label fs-6"> سوال سوم  </label>
                  <textarea class="form-control" id="cont3" name="content3" rows="2" value=""></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
           <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> بستن <i class="fa fa-xmark"> </i> </button>
		  <button type="submit" class="btn btn-success"> ذخیره <i class="fa fa-save"> </i> </button>
      </div>
	 </form>
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




<script>

function startAgainNazar(){
	swal({
		  title: "آیا مطمئین هستید؟",
		  text: "یک بار نظر خواهی را از سر شروع کردید دوباره بر نمیگردد.",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			swal("شما نظر خواهی را از سر شروع کردید، موفق باشید!", {
			  icon: "success",
			});
		  } else {
			swal("نظر خواهی شروع نگردید");
		  }
		})
}
	
	$("#editLotteryPrizeBtn").on("click", ()=>{
		    if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                  top: 0,
                  left: 0
                });
              }
              $('#sentTosalesFactor').modal({
                backdrop: false,
                show: true
              });
              
              $('.modal-dialog').draggable({
                  handle: ".modal-header"
                });
		
	     	$("#editLotteryPrizes").modal("show");
	})
</script>
@endsection



