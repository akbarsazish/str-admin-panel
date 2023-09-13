@extends('layout.layout')
@section('content')
<section class="profile-page container">
    <div class="o-page__aside">
        <div class="o-page__aside">
            <div class="c-profile-aside">
                <div class="c-profile-box">
                    <div class="c-profile-box__header">
                        <div class="c-profile-box__avatar" style="background-image: url(../assets/images/avatars/fd4840b2.svg)"></div>
                        <button id="avatar-modal" class="c-profile-box__btn-edit"></button>
                    </div>
                </div>
                <div class="c-message-light c-message-light--info">
                    <div class="c-message-light__justify">
                        <p class="c-message-light--text">با پیام ها خود ما را در ارائه بهتر خدمات یاری رسانید </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="o-page__content">
        <div class="o-headline o-headline--profile"><span>پیام جدید</span></div>
        <form action="{{url('/doAddMessage')}}" method="post">
            @csrf
            <textarea placeholder="متن پیام خود را بنویسید"  name="message" style="width: 100%; height: 70px"></textarea>
            <button type="submit" class="btn-light btn-light--gray btn-light--verify" id="btnsave">ارسال پیام</button>
        </form>
    </div>
</section>
<script src="{{ url('/resources/assets/js/script.js')}}"></script>
@endsection
