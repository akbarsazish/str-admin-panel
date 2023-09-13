        <form action="{{url('/storeHoqoqiCustomer') }}" method="POST">
            @csrf
            <input type="hidden" id="hoqoqi" name="customerType" value="hoqoqi">
            <input type="hidden" name="customerShopSn" value="{{Session::get('psn')}}">
            <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="companyName" class="form-label">نام شرکت :</label>
                    <input onKeyPress="if(this.value.length==10) return false;" type="text" class="form-control haqiqi" value="@if($exactHoqoqi){{trim($exactHoqoqi->companyName)}}@endif"  id="name" placeholder="نام  " name="companyName">
                </div>
            </div>
            {{-- <input type="text" name="customerShopSn" value="{{Session::get('psn')}}"> --}}
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="shenasahmilli" class="form-label" data-toggle="tooltip" data-placement="bottom" title="معلومات !"> شناسه ملی  :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="shenasahMilli"  value="@if($exactHoqoqi){{trim($exactHoqoqi->shenasahMilli)}}@endif" placeholder=" شناسه ملی " name="shenasahMilli">
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="roleNo" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !"> کد نقش :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="roleNo" value="@if($exactHoqoqi){{trim($exactHoqoqi->codeNaqsh)}}@endif" placeholder="کد نقش"  name="codeNaqsh">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="postalCode"  class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !">کد پستی :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="postalCode" placeholder="کد پستی" value="@if($exactHoqoqi){{trim($exactHoqoqi->codePosti)}}@endif"  name="codePosti">
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="sabetPhoneNo" class="form-label"> آدرس :</label>
                    <input onKeyPress="if(this.value.length==26) return false;" type="text" class="form-control haqiqi" id="address" value="@if($exactHoqoqi){{trim($exactHoqoqi->address)}}@endif" placeholder="آدرس " name="address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-1 mt-2">
                <input type="submit" class="btn btn-success" value="ذخیره ">
            </div>
        </div>
        </form>
