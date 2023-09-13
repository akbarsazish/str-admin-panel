@extends('admin.layout')
@section('content')

<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> تنظیمات </legend>
                    <!-- <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="elseSettingsRadio">
                        <label class="form-check-label me-4" for="assesPast">  سطح دسترسی  </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input p-2 float-start" type="radio" name="settings" id="settingAndTargetRadio">
                        <label class="form-check-label me-4" for="assesPast"> تارگت ها و امتیازات </label>
                    </div> -->
                    
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader"> </div>
                <div class="row mainContent">
                       @foreach ($parts as $part)
                       <form class="p-1" action="{{ url('/doEditGroupPart') }}" method="POST" class='form' autocomplete="off">
                        @csrf
                        <div class="row">
                                    <div class="col-sm-3">
                                        <div class='form-group'>
                                            <label class='form-label'>اسم سطر</label>
                                            <input   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="form-control form-control-sm" type='text' id='partTitle' value="{{   trim($part->partTitle) }}" autocomplete="off" class='form-control' name='partTitle' placeholder=''>
                                            <input type='text' style="display: none" id="partId" value="{{ $part->partId }}" class='form-control' name='partId' placeholder=''>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class='form-group'>
                                            <label class='form-label'>نوع دسته بندی</label>
                                            <select   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="form-select form-select-sm" name='partType' onchange='showDiv(this)' class='form-control' id='partType'>
                                                <option value="{{ $part->partType }}">{{ $part->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class='form-group'>
                                            <label class='form-label'>اولویت</label>
                                            <select   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="form-select form-select-sm"  type='text' id="priority"  class='form-select' name='partPriority' placeholder=''>
                                                @for ($i =3; $i <= (int)$countHomeParts; $i++)
                                                    <option @if((int)$part->priority==$i) selected @endif value="{{$i}}">{{$i-2}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 d-flex align-items-stretch">
                                        <div class="form-group d-flex text-nowrap align-items-center pt-3">
                                            <input   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="form-control d-flex form-check-input align-items-end" type="checkbox" name="activeOrNot" id="activeOrNot" @if ($part->activeOrNot==1) checked @else @endif >
                                            <label class="form-check-label align-items-end" style="font-weight: bold" for="activeOrNot">نمایش</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-end">
                                         <button type="submit"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif class="btn btn-success btn-sm text-warning" style="foloat:left;">ذخیره <i class="fa-light fa-save"></i></button>
                                    </div>
                                </div>

                                <div class="grid-subgroup">
                                    <div class="subgroup-item">
                                         <label class="form-label pt-2">جستجوی  </label>
                                        <input class="form-control form-control-sm" type="text" name=""  id="searchThingGroups">
                                        <table class="tableSection table table-bordered table table-hover table-sm" style='td:hover{ cursor:move;}'>
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>گروه اصلی 99</th>
                                                    <th><input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif  class="selectAllFromTop form-check-input"  ></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody" id="groupsPart">
                                                @foreach ($groups as $group)
                                                    <tr   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) > 0 )  onclick="checkCheckBox(this,event)" @endif>
                                                        <td>{{ $loop->index+1 }}</td>
                                                        <td>{{ $group->title }}</td>
                                                        <td>
                                                            <input class="mainGroupIds form-check-input" type="checkBox" name="mainGroupIds[]" value="{{ $group->id . '_' . $group->title }}" id="flexCheckChecked">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="subgroup-item" style="margin-top:88px;">
                                         <button style="background-color:transparent;" id="addGroupData" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif>
                                            <i class="fa-regular fa-circle-chevron-left fa-2x"></i>
                                        </button> <br>
                                        <button style="background-color:transparent;" id="removeGroupData" type="button" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) <1 ) disabled @endif>
                                            <i class="fa-regular fa-circle-chevron-right fa-2x"></i>
                                        </button>
                                    </div>
                                    <div class="subgroup-item">
                                         <label class="form-label pt-2">جستجوی گروه</label>
                                        <select class="form-select form-select-sm" id="searchGroup">
                                            <option value="0">همه گروه ها</option>
                                        </select>
                                         <table class="tableSection table table-bordered table table-hover table-sm" style='td:hover{ cursor:move;}'>
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th class="position-relative"> گروه اصلی <div style="color:white!important;" class="rounded-circle d-flex position-absolute top-50 justify-content-end w-100 m-0 p-0 px-3">
                                                        <button class='groupPartPriority' style="background-color:transparent; margin-top:-10px;" type="button" value="down"><i class="fa-solid fa-circle-chevron-down fa-sm" style=''></i></button>
                                                        <button class='groupPartPriority' style="background-color:transparent; margin-top:-10px;" type="button" value="up"><i class="fa-solid fa-circle-chevron-up fa-sm" style=''></i></button>
                                                    </th>
                                                    <th><input type="checkbox" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) < 1 ) disabled @endif class="selectAllFromTop form-check-input"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBody"  id="addedGroups">
                                                @foreach ($addedGroups as $group)
                                                    <tr class="addedTr"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) > 0 ) onClick="checkCheckBox(this,event)" @endif>
                                                        <td>{{ $loop->index+1}}</td>
                                                        <td>{{ $group->groupTitle }}</td>
                                                        <td>
                                                            <input class="mainGroupId  form-check-input" type="checkBox" name="groupIds[]" value="{{ $group->groupId.'_'.' '}}" id="flexCheckChecked">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        @endforeach
                    </form>
                </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>


    <script>
        window.onload = function() {
            //used for searching groups to add to a part
            $.ajax({
                method: 'get',
                url: "{{ url('/getSearchGroups') }}",
                async: true,
                success: function(arrayed_result) {
                    $('#searchGroup').empty();
                    $('#searchGroup').append('<option value="0">همه کالا ها</option>');
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#searchGroup').append('<option value="' + arrayed_result[i].id + '">' +
                            arrayed_result[i].title + '</option>');
                    }
                },
                error: function(data) {
                    alert("پیدا نشد");
                }

            });
            //used for searching groups in right side
            $('#searchGroup').on('change', function() {
                //قسمت لیست کالاها آورده شود
                $.ajax({
                    method: 'get',
                    url: "{{ url('/getGroupSearch') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        groupId: $('#searchGroup').val()
                    },
                    success: function(arrayed_result) {
                        $('#groupsPart').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            $('#groupsPart').append(`<tr onClick="checkCheckBox(this,event)">
                                <td>` + (i+1) + `</td>
                                <td>` + arrayed_result[i].title + `</td>
                                <td>
                                    <input class="mainGroupId form-check-input" type="checkBox"
                                        name="mainGroupIds[]" value="` + arrayed_result[i].id +`_`+arrayed_result[i].title+ `"
                                        id="flexCheckChecked">
                                </td>
                            </tr>`);
                        }

                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            });
            //used for searching by input to add groups to a part
            $('#searchThingGroups').on('keyup', function() {
                //قسمت لیست کالاها آورده شود
                $.ajax({
                    method: 'get',
                    url: "{{ url('/searchGroups') }}",
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        searchTerm:$('#searchThingGroups').val()
                    },
                    success: function(arrayed_result) {

                        $('#groupsPart').empty();
                        for (var i = 0; i <= arrayed_result.length - 1; i++) {
                            $('#groupsPart').append(`<tr onClick="checkCheckBox(this,event)">
                                <td>`+(i+1)+`</td>
                                <td>`+arrayed_result[i].title+`</td>
                                <td>
                                    <input class="mainGroupId  form-check-input" type="checkBox"
                                    name="mainGroupIds[]" value="` + arrayed_result[i].id +`_`+arrayed_result[i].title + `"
                                        id="flexCheckChecked">
                                </td>
                            </tr>`);
                        }
                    },
                    error: function(data) {
                        alert("پیدا نشد");
                    }

                });
            });
            //used for adding groups to left side
            $('#addGroupData').on('click', function() {
                var groupListIds = [];
                $('input[name="mainGroupIds[]"]:checked').map(function() {
                    groupListIds.push(($(this).val()));
                });
                $('input[name="mainGroupIds[]"]:checked').parents('tr').css('color','red');
                $('input[name="mainGroupIds[]"]:checked').prop("disabled", true);
                $('input[name="mainGroupIds[]"]:checked').prop("checked", false);
                for (let i = 0; i < groupListIds.length; i++) {
                    $('#addedGroups').append(`<tr class="addedTr" onClick="checkCheckBox(this,event)">
                            <td>` + (i+1) + `</td>
                                <td>` + groupListIds[i].split('_')[1] + `</td>
                                <td>
                                    <input class="mainGroupId  form-check-input" type="checkBox" name="groupIds[]"
                                        value="` + groupListIds[i].split('_')[0] + `"
                                        id="flexCheckChecked" checked>
                                </td>
                            </tr>`);

                }
            });
            //used for removing groups from a part
            $(document).on('click', '#removeGroupData', (function() {
                $('.addedTr').find('input:checkbox:checked').attr("name", "removable[]");
                
                $($('.addedTr').has('input[name="removable[]"]:checked')).css("display","none");
            }));
        }
    </script>
@endsection

