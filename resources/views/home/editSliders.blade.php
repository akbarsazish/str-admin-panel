@extends('admin.layout')
@section('content')
<div class="container-fluid containerDiv">
    <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 sideBar">
                <fieldset class="border rounded mt-5 sidefieldSet">
                    <legend  class="float-none w-auto legendLabel mb-0"> سلایدرها  </legend>
                    
                </fieldset>
                </div>
            <div class="col-sm-10 col-md-10 col-sm-12 contentDiv">
                <div class="row contentHeader">
                    <div class="col-lg-12 text-end mt-1">
                        <button form="sliderEditForm" type="submit" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) < 1 ) disabled @endif class="btn btn-success btn-sm text-warning" id="sliderEditSaveBtn">ذخیره <i class="fa fa-save fa-lg" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="row mainContent">
                    @foreach ($parts as $part)
                        <form class="p-0" action="{{ url('/doEditGroupPart') }}" method="POST" enctype="multipart/form-data" class='form' id="sliderEditForm">
                            @csrf
                            @if($picture[0]->partType==4)
                                <label class="form-label fs-6 mt-1">نمایش</label>
                                <input class="float-start" type="checkbox" style="margin:10px;" name="activeOrNot" @if ($part->activeOrNot==1)checked @else @endif>
                            @endif
                            <div class="row d-none">
                                <div class='modal-body'>
                                    <div class='' style='padding-right:0;'>
                                        <div class='form-group d-none'>
                                            <label class='form-label'>اسم سطر</label>
                                            <input type='text' id='partTitle' value="{{ $part->partTitle }}"
                                                class='form-control' name='partTitle' placeholder='' />
                                            <input type='text' id='partId' style="display: none"
                                                value="{{ $part->partId }}" class='form-control' name='partId'
                                                placeholder='' />
                                        </div>
                                        <div class='form-group' style="display: none">
                                            <label class='form-label'>اولویت</label>
                                            <input type='text' id="priority" value="{{ $part->priority }}"
                                                class='form-control' name='partPriority' placeholder=''>
                                        </div>
                                        <div class='form-group d-none'>
                                            <label class='form-label'>نوعیت دسته بندی</label>
                                            <select name='partType' class='form-select'
                                                id='partType'>
                                                <option value="{{ $part->partType }}">{{ $part->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row p-0">
                                <div class="col-sm-12" style="padding: 1%">
                                    <div class="container">
                                        <div class="row p-0">
                                                <div class='modal-body' style="display:flex;  justify-content: flex-end; float:right; margin-left:50px">
                                                    <div id='pslider' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                                                        <div class='product-box swiper-wrapper' style="">
                                                            @foreach ($picture as $pic)
                                                            @if($pic->firstPic)
                                                            <div class='product-item swiper-slide' style='width:30% !important; height:25vh !important;'>
                                                                <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->firstPic}}"/>
                                                                @if($pic->partType==3)
                                                                <img id="imageSrc1" style="width:85% height:45%" src="{{url('/resources/assets/images/mainSlider/'.$pic->firstPic.'')}}">
                                                                @else
                                                                <img id="imageSrc1" style="width:85% height:45%" src="{{url('/resources/assets/images/smallSlider/'.$pic->firstPic.'')}}">
                                                                @endif
                                                                <br/>
                                                                <div>
                                                                    <button class="btn btn-success btn-sm text-warning"  @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 ) onclick="document.getElementById('firstPic').click();" @endif type="button" style="display: inline; margin-right: 2%;">ویرایش</button>
                                                                </div>
                                                                <input type="file"  onchange='document.getElementById("imageSrc1").src = window.URL.createObjectURL(this.files[0])'  name="slider1" id="firstPic" style="display: none"/>
                                                            </div>
                                                            @endif
                                                            {{-- 2 --}}
                                                            @if($pic->secondPic)
                                                            <div class='product-item swiper-slide' style='width:30% !important; height:25vh !important;'>
                                                                <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->secondPic}}"/>
                                                                @if($pic->partType==3)
                                                                <img id="imageSrc2" style="width:85% height:45%" src="{{url('/resources/assets/images/mainSlider/'.$pic->secondPic.'')}}">
                                                                @else
                                                                <img  id="imageSrc2" style="width:85% height:45%" src="{{url('/resources/assets/images/smallSlider/'.$pic->secondPic.'')}}">
                                                                @endif
                                                                <br/>
                                                                <div>
                                                                    <button class="btn btn-success btn-sm text-warning"   @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 )  onclick="document.getElementById('secondPic').click();" @endif type="button" style="display: inline;margin-right: 2%;">ویرایش</button>
                                                                </div>
                                                                <input type="file" onchange='document.getElementById("imageSrc2").src = window.URL.createObjectURL(this.files[0])' name="slider2" id="secondPic" style="display: none"/>
                                                            </div>
                                                            @endif
                                                            {{-- 3 --}}
                                                            @if($pic->thirdPic)
                                                            <div class='product-item swiper-slide' style='width:30% !important; height:25vh !important;'>
                                                                <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->thirdPic}}"/>
                                                                <img id="imageSrc3" style="width:85% height:45%" src="{{url('/resources/assets/images/mainSlider/'.$pic->thirdPic.'')}}">
                                                                <br/>
                                                                <div>
                                                                    <button class="btn btn-success btn-sm text-warning" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 ) onclick="document.getElementById('thirdPic').click();" @endif type="button" style="display: inline;margin-right: 2%;">ویرایش</button>
                                                                </div>
                                                                <input type="file"  onchange='document.getElementById("imageSrc3").src = window.URL.createObjectURL(this.files[0])' name="slider3" id="thirdPic" style="display: none"/>
                                                            </div>
                                                            @endif
                                                            {{-- 4 --}}
                                                            @if($pic->fourthPic)
                                                            <div class='product-item swiper-slide' style='width:30% !important; height:25vh !important;'>
                                                                <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->fourthPic}}"/>
                                                                <img id="imageSrc4" style="width:85% height:45%" src="{{url('/resources/assets/images/mainSlider/'.$pic->fourthPic.'')}}">
                                                                <br/>
                                                                <div>
                                                                    <button class="btn btn-success btn-sm text-warning" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 ) onclick="document.getElementById('fourthPic').click();" @endif type="button" style="display: inline;margin-right: 2%;">ویرایش</button>
                                                                </div>

                                                                <input onchange='document.getElementById("imageSrc4").src = window.URL.createObjectURL(this.files[0])' type="file" name="slider4" id="fourthPic" style="display: none"/>
                                                            </div>
                                                            @endif
                                                            {{-- 5 --}}
                                                            @if($pic->fifthPic)
                                                            <div class='product-item swiper-slide' style='width:30% !important; height:25vh !important;'>

                                                                <input style="display:none" id="pic{{ $loop->iteration }}" value="{{$pic->fifthPic}}"/>

                                                                <img  id="imageSrc5" style="width:85% height:80%" src="{{url('/resources/assets/images/mainSlider/'.$pic->fifthPic.'')}}">
                                                                <br/>
                                                                <div>
                                                                    <button class="btn btn-success btn-sm text-warning" @if(hasPermission(Session::get( 'adminId'),'mainPageSetting' ) >0 ) onclick="document.getElementById('fifthPic').click();" @endif type="button" style="display: inline;margin-right: 2%;">ویرایش</button>
                                                                </div>
                                                                <input onchange='document.getElementById("imageSrc5").src = window.URL.createObjectURL(this.files[0])' type="file" name="slider5" id="fifthPic" style="display: none"/>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach

                </div>
                <div class="row contentFooter"> </div>
            </div>
    </div>
</div>


     <script>    
        var mslider = {
        loop: !0,
        spaceBetween: 30,
        effect: 'fade',
        pagination: {
            el: '.mainslider-btn',
            clickable: !0,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: !1,
        },
    }
    $('.swiper-button-next').hide()
    $('.swiper-button-prev').hide()


    var pslider = {
        slidesPerView: 6,
        spaceBetween: 0,
        autoplay: {
            delay: 7500,
            disableOnInteraction: !1,
        },
        navigation: {
            nextEl: '#pslider-nbtn',
            prevEl: '#pslider-pbtn',
        },
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            }
        }
    }
 
    var swiper = new Swiper('#pslider', pslider);

    $("#sliderEditSaveBtn").on("click", ()=>{
       $("#sliderEditForm").submit();
    })
    
</script>
@endsection