@extends ('layout.layout')
@section('content')

<section class="search container topDistance">

    <div class="o-page__content" style="margin: 0 auto; ">
        <div class="c-listing">
            <ul class="c-listing__items">
                @foreach ($groups as $group)
                <li class="border-0">
                    <div class="c-product-box">
                        <a href="/listKala/groupId/{{$group->id}}"  class="c-product-box__img p-0 star-loader" style="height:100%">
                            @if(file_exists('resources/assets/images/mainGroups/' . $group->id . '.jpg'))
                                <img alt="" src="{{url('/resources/assets/images/mainGroups/' . $group->id . '.jpg') }}"/>
                            @else
                              <img alt="" src="{{ url('/resources/assets/images/defaultKalaPics/altKala.png') }}"/>
                            @endif
                        </a>
                        <div class="c-product-box__content pt-1" style="position:sticky;">
                            <a style="line-height: 1rem" href="/listKala/groupId/{{$group->id}}" class="title">{{trim($group->title)}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
   </div>

   <div class="starfood-loader" id="loader">
        <div class="preload1">
          <img class="img-load" src="{{url('resources/assets/images/loader.gif')}}">
        </div>
        <h6 class="loader1">
            <span>لطفآ </span>
            <span>منتظر</span>
            <span>باشید</span>
            <span>...</span>
        </h6>
    </div>

@if(showEnamad("enamadOther")==1)
   <div class="container topDistance">
       <div class="row mb-4"> 
           <div class="col-lg-4 col-md-4 col-sm-4"> </div>
            <div class="col-lg-4 col-md-4 col-sm-4 about-img">
            <a referrerpolicy="origin" href="https://trustseal.enamad.ir/?id=220841&amp;code=dgsiolxgvdofskzzy34r">
                <img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=220841&amp;Code=dGSIolXgVdoFskzzY34R"
                     alt="" style="cursor:pointer" id="dGSIolXgVdoFskzzY34R">
            </a>
            <img referrerpolicy='origin' id='nbqewlaosizpjzpefukzrgvj'
                 style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=249763&p=uiwkaodspfvljyoegvkaxlao",
        "Popup", "toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                 alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=249763&p=odrfshwlbsiyyndtwlbqqfti' />
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"> </div>
        </div> 
    </div>
 @endif
</section>
<!-- <script>
       window.addEventListener('load', function() {
        var spinner = document.getElementById('spinner');
        spinner.style.display = 'none';
    });
  </script> -->
@endsection
