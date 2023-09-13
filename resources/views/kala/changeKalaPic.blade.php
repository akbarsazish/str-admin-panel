@extends ('admin.layout')
@section('content')
<style>
    .showdeleteBtn{
        display: none;
    }
</style>
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
                <div class="row contentHeader" style="height:1%;"> </div>
                <div class="row mainContent">
              <div class="c-listing px-0" style="display:block; height:505px; overflow-y:scroll;">
                <ul class="c-listing__items px-0 mx-auto">
                    @foreach ($listKala as $item)
                     <li class="border-0 px-0">
                        <div class="col-50 medium-25 mb-1 px-0">
                            <div class="c-product-box py-1 c-promotion-box" style="min-height: 290px">
                                <a href="" class="c-product-box__img c-promotion-box__image">
                                    <img style="width:80%; height:44%"  id="mainPicEdit{{$item->GoodSn}}" alt="mainPicEdit" src="{{ url('/resources/assets/images/kala/' . $item->GoodSn . '_1.jpg') }}">
                                </a>
                                <div class="c-product-box__content" style="width: 93%; border-bottom: 1px solid gray; margin-bottom:5px">
                                    <a href="#" class="title"
                                        style="display: block; min-height: 45px">{{ $item->GoodName }}</a>
                                </div>
                                <div class="c-product__add">
                                    <div class="c-product__add" style="display: block">
                                    <iframe name="votar" style="display:none;"></iframe>
                                    <form action="{{ url('/addpicture') }}" onsubmit='document.getElementById("uploadButton{{$item->GoodSn}}").style.backgroundColor="#198754"; document.getElementById("deleteBtn{{$item->GoodSn}}").classList.remove("showdeleteBtn");' target="votar" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <label for="mainPic{{$item->GoodSn}}" style="width: 100px;margin-bottom:5%;" class="btn btn-success editButtonHover">  ویرایش <i class="fa-light fa-image fa-lg"></i></label>
                                        <input type="file"   onchange='document.getElementById("mainPicEdit{{$item->GoodSn}}").src = window.URL.createObjectURL(this.files[0]); document.getElementById("uploadButton{{$item->GoodSn}}").style.backgroundColor="red";' style="display: none" class="form-control" name="firstPic" id="mainPic{{$item->GoodSn}}">
                                            <button style="width: 100px;margin-bottom:5%;" onclick="deleteKalaPicture({{$item->GoodSn}},this)" id="deleteBtn{{$item->GoodSn}}" class="btn editButtonHover btn-danger @if(!file_exists('resources/assets/images/kala/' . $item->GoodSn . '_1.jpg')) showdeleteBtn @endif">حذف عکس</button>
                                        <br/>
                                        <br/>
                                        <label  style="width: 110px;margin-bottom:5%;" class="btn btn-success editButtonHover">  ویرایش <i class="fa-light fa-image fa-lg"></i></label>
                                        <input type="file"   style="display: none" class="form-control"  >
                                        <label  style="width: 110px;margin-bottom:5%;" class="btn btn-success editButtonHover">  ویرایش <i class="fa-light fa-image fa-lg"></i></label>
                                        <input type="file"   style="display: none" class="form-control"  >
                                        <br/>
                                        <label  style="width: 110px;margin-bottom:5%;" class="btn btn-success editButtonHover">  ویرایش <i class="fa-light fa-image fa-lg"></i></label>
                                        <input type="file"   style="display: none" class="form-control"  >
                                        <label  style="width: 110px;margin-bottom:5%;" class="btn btn-success editButtonHover">  ویرایش <i class="fa-light fa-image fa-lg"></i></label>
                                        <input type="file"   style="display: none" class="form-control"  >
                                        <div class="d-flex justify-content-between" style="border-top: 1px solid gray;border-bottom: 1px solid gray;"></div>
                                        <input type="text" name="kalaId" value="{{$item->GoodSn}}" style="display: none">
                                        <button type="submit" id="uploadButton{{$item->GoodSn}}" style="margin: 2%;" class="btn btn-success btn-sm editButtonHover">اپلود</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
                </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>

 @endsection
