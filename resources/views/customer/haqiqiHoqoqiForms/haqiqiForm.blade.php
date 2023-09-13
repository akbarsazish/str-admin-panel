        <form action="{{url('/storeHaqiqiCustomer') }}" method="POST">
            @csrf
            <input type="hidden" id="haqiqi" name="customerType" value="haqiqi">
            <input type="hidden" name="customerShopSn" value="{{Session::get('psn')}}">
            <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="name" class="form-label">نام:</label>
                    <input onKeyPress="if(this.value.length==10) return false;" type="text" class="form-control haqiqi" value="@if($exacHaqiqi){{trim($exacHaqiqi->customerName)}}@endif"  id="name" placeholder="نام  " name="customerName">
                </div>
            </div>
            {{-- <input type="text" name="customerShopSn" value="{{Session::get('psn')}}@endif"> --}}
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="familyName" class="form-label"> نام خانوادگی  :</label>
                    <input type="text"  onKeyPress="if(this.value.length==10) return false;" class="form-control haqiqi" id="familyName" value="@if($exacHaqiqi){{trim($exacHaqiqi->familyName)}}@endif" placeholder=" نام خانوادگی  " name="familyName">
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="roleNo" class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !"> کد نقش :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="roleNo" value="@if($exacHaqiqi){{trim($exacHaqiqi->codeNaqsh)}}@endif" placeholder="کد نقش"  name="codeNaqsh">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="postalCode"  class="form-label"  data-toggle="tooltip" data-placement="bottom" title="معلومات !">کد پستی :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="postalCode" placeholder="کد پستی" value="@if($exacHaqiqi){{trim($exacHaqiqi->codePosti)}}@endif"  name="codePosti">
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="shenasahmilli" class="form-label" data-toggle="tooltip" data-placement="bottom" title="معلومات !"> شماره ملی   :</label>
                    <input  onKeyPress="if(this.value.length==10) return false;" type="number"  min=0 class="form-control haqiqi" id="codeMilli"  value="@if($exacHaqiqi){{trim($exacHaqiqi->codeMilli)}}@endif" placeholder=" شماره ملی " name="codeMilli">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="mb-1 mt-2">
                    <label for="address" class="form-label"> آدرس :</label>
                    <input onKeyPress="if(this.value.length==26) return false;" type="text" class="form-control haqiqi" id="address" value="@if($exacHaqiqi){{trim($exacHaqiqi->address)}}@endif" placeholder="آدرس " name="address">
                </div>
            </div>

        </div>
      
        <div class="row">
            <div class="mb-1 mt-2">
                <input type="submit" class="btn btn-success" value="ذخیره ">
            </div>
        </div>
        </form>
