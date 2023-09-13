@extends('layout.layout')
@section('content')
@if($sessions)
<script>
    $(function() {
        $('#myModal').modal('show');
    });
    </script>
@endif
<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">شما با وسایل زیر وارد سایت شده اید</h4>
        </div>
        <div class="modal-body">
          <ul class="c-checkout__items ps-0">
          @foreach ($sessions as $sess)
          <li><h4 style="display:inline;">{{$sess->platform.'   '}}</h4>
          <h4 style="display:inline;">{{$sess->browser}}</h4></li>
          @endforeach
          </ul>
        </div>
        <div class="modal-footer">
            <form action="{{url('/updateChangedPrice')}}" method="POST">
              @csrf
              <input type="text" name="SnHDS" style="display: none;" value="">
              <button type="submit" class="btn btn-default" >ادامه</button>
            </form>
          <a class="btn btn-default" href="{{url('/login')}}" data-dismiss="modal">خیر</a>
        </div>
      </div>
    </div>
  </div>
  @endsection