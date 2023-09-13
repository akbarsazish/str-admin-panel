{{-- @extends('layout.layout')
@section('content')

               <div class="col-sm-9 text-justify">
                <?php if($isHaqiqi=1){?>
                        <div class="o-page__content" >
                            <div class="text-black brounded" align="right" style="border-bottom:1px solid red; top:0">
                                <h4> پروفایل </h4>
                           </div>
                            <div class="c-table-orders homeTables" style="padding-right:0;">
                                <div class="c-table-orders__head--highlighted">
                                    <div>نام  </div>
                                    <div> نام خانوادگی  </div>
                                    <div> شماره ملی </div>
                                    <div> کدپستی </div>
                                    <div> کد نقش </div>
                                    <div> ادرس </div>

                             @if ($officialstate=1)
                                <div> ویرایش </div>
                            @else
                                <div></div>
                                </div>
                                <div class="c-table-orders__body">
                                <div class="table-row">

                            @foreach ($haqiqicustomers as $haqiqicustomer)

                                <div>@if($haqiqicustomer) {{$haqiqicustomer->customerName}}@endif</div>
                                <div>@if($haqiqicustomer) {{$haqiqicustomer->familyName}}@endif</div>
                                <div>@if($haqiqicustomer) {{$haqiqicustomer->codeMilli}} @endif</div>
                                <div>@if($haqiqicustomer) {{$haqiqicustomer->codePosti}}@endif</div>
                                <div>@if($haqiqicustomer) {{$haqiqicustomer->codeNaqsh}}@endif</div>
                            
                                <div>@if($haqiqicustomer) {{$haqiqicustomer->shenasNamahNo}}@endif</div>

                            @endforeach



                                @if($officialstate=1)
                                    <a href=" {{ URL::to('/customerAdd')}}" style="padding:5px; margin-left:10px; color:#0dcaf0"> <i class="fa  fa-check-square fa-3x warning"></i> </a>
                                @else
                                    <a href=" {{ URL::to('/addCustomer')}}" style="padding:5px; margin-left:10px; color:#0dcaf0"> <i class="fa fa-plus-circle  fa-3x warning"></i> </a>
                                @endif

                                </div>
                            </div>
                        </div>


                        <?php }else {?>
                         <div class="o-page__content" >
                            <div class="text-black brounded" align="right" style="border-bottom:1px solid red; top:0">
                                <h4> پروفایل </h4>
                           </div>
                            <div class="c-table-orders homeTables" style="padding-right:0;">
                                <div class="c-table-orders__head--highlighted">
                                    <div> نام شرکت</div>
                                    <div>شناسه ملی  </div>
                                    <div> کدپستی </div>
                                    <div> کد اقتصادی </div>
                                    <div> کد نقش </div>
                                    <div>آدرس </div>
                                    <div> شماره همراه</div>
                                    <div>تلفن ثابت</div>

                                @if ($officialstate=1)
                                    <div> ویرایش </div>
                                @else
                                    <div></div>
                                 @endif

                                </div>
                                <div class="c-table-orders__body">
                                <div class="table-row">
                                    <div>@if($exactCustomer) {{$exactCustomer->companyName}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->shenasahMilli}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->codeEqtisadi}} @endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->codeNaqsh}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->registerNo}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->codePosti}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->address}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->phoneNo}}@endif</div>
                                    <div>@if($exactCustomer) {{$exactCustomer->sabetPhoneNo}}@endif</div>

                                @if($officialstate=1)
                                    <a href=" {{ URL::to('/addCustomer')}}" style="padding:5px; margin-left:10px; color:#0dcaf0"> <i class="fa  fa-check-square fa-3x warning"></i> </a>
                                @else
                                    <a href=" {{ URL::to('/addCustomer')}}" style="padding:5px; margin-left:10px; color:#0dcaf0"> <i class="fa fa-plus-circle  fa-3x warning"></i> </a>
                                @endif

                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    </div>
                    <div class="col-sm-12 text-justify">
                        <div class="o-page__content" >
                            <div class="o-headline o-headline--profile"><span>فاکتور های ثبت شده</span></div>
                            <div class="c-table-orders" style="padding-right:0;">
                                <div class="c-table-orders__head--highlighted">
                                    <div>ردیف</div>
                                    <div>شماره فاکتور</div>
                                    <div>  تاریخ ثبت فاکتور</div>
                                    <div>  تاریخ تحویل کالا</div>
                                    <div>مبلغ قابل پرداخت</div>
                                    <div>عملیات پرداخت</div>
                                    <div>جزءیات</div>
                                </div>
                                <div class="c-table-orders__body text-justify">
                                    @foreach ($factors as $factor)
                                        <div class="table-row">
                                            <div>{{number_format($loop->index+1)}}</div>
                                            <div>{{number_format($factor->FactNo)}}</div>
                                            <div>{{$factor->FactDate}}</div>
                                            <div>{{$factor->FactDate}}</div>
                                            <div>{{number_format($factor->TotalPriceHDS)}}</div>
                                            <div><span class="c-table-orders__payment-status--ok">پرداخت در محل</span></div>
                                            <form method="post" action="{{url('/factorView')}}" method="POST">
                                                @csrf
                                            <input name="factorSn" type="hidden" value="{{$factor->SerialNoHDS}}">
                                            <div><button class="btn btn-info btn-ms" type="submit">
                                                مشاهده
                                            </button></div>
                                        </form>
                                        </div>
                                    @endforeach
                                <a href="#" class="c-table-orders__show-more">مشاهده لیست سفارش ها</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-justify">
                    <div class="col-sm-12">
                        <div class="o-page__content" >
                            <div class="o-headline o-headline--profile"><span>فاکتور های در انتظار ارسال</span></div>
                            <div class="c-table-orders">
                                <div class="c-table-orders__head--highlighted">
                                    <div>ردیف</div>
                                    <div>شماره فاکتور</div>
                                    <div>تاریخ ثبت فاکتور</div>
                                    <div>تاریخ تحویل کالا</div>
                                    <div>مبلغ قابل پرداخت</div>
                                    <div>عملیات پرداخت</div>
                                    <div>جزءیات</div>
                                </div>
                                <div class="c-table-orders__body text-justify">
                                    @foreach ($orders as $order)
                                        <div class="table-row">
                                            <div>{{number_format($loop->index+1)}}</div>
                                            <div>{{number_format($order->OrderNo)}}</div>
                                            <div>{{$order->OrderDate}}</div>
                                            <div>{{$order->OrderDate}}</div>
                                            <div>{{number_format($order->Price)}}</div>
                                            <div><span class="c-table-orders__payment-status--ok">پرداخت در محل</span></div>
                                            <form method="post" action="{{url('/orderView')}}" method="POST">
                                                @csrf
                                            <input name="factorSn" type="hidden" value="{{$order->SnOrder}}">
                                            <div><button  class="btn btn-info btn-ms" type="submit">
                                                مشاهده
                                            </button></div>
                                        </form>
                                        </div>
                                    @endforeach
                                <a href="#" class="c-table-orders__show-more">مشاهده لیست سفارش ها</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="modal-avatar__content">
    <button class="remodal-close"><i class="fa fa-window-close"></i></button>
    <div class="c-remodal-avatar__title">تغییر نمایه کاربری شما</div>
    <ul class="c-profile-avatars">
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/fd4840b2.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/df110dcf.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/b5f7d7b8.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/e8e1a8b5.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/a5a6ccef.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/6cdbab30.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/2a5b1e32.svg)"></span></li>
        <li><span class="c-profile-avatars__item" style="background-image: url(../assets/images/avatars/61f2d6e4.svg)"></span></li>
    </ul>
    </div>
</section>

<section class="product-wrapper container">
 --}}
