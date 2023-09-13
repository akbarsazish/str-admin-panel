@extends('admin.layout')
@section('content')
@if(count($alarmedKalas) > 0 or count($imediatOrders)>0)
@if(count($alarmedKalas) > 0 )
<script>
$(document).ready(function() {
            setTimeout($("#existanceWarningModal").modal("show"),1);
            $("#existanceWarningModal").on('hide.bs.modal', function(){
            document.location.href="/dashboardAdmin";
            });
        });
</script>
@elseif(count($imediatOrders)>0)
<script>
$(document).ready(function() {
            setTimeout($("#imediatOrderModal").modal("show"),1);
            $("#imediatOrderModal").on('hide.bs.modal', function(){
            document.location.href="/dashboardAdmin";
            });
        });
</script>
@endif
@else
<script>
        document.location.href="/dashboardAdmin";
</script>
@endif
<div class='modal fade dragAbleModal' id='imediatOrderModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' >
        <div class='modal-content'>
            <div class='modal-header py-2 text-white bg-success'>
                <h5 class='modal-title' id='exampleModalLongTitle'> آلارم سفارشات فوری </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <table class="table table-striped">
                    <thead class="tableHeader">
                        <tr>
                        <th scope="col"> ردیف </th>
						<th scope="col"> کد </th>
                        <th scope="col"> مشتری </th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach($imediatOrders as $order)
                        <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td> {{ $order->PCode }} </td>
						<td> {{ $order->Name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class='modal fade dragAbleModal' id='existanceWarningModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' >
        <div class='modal-content'>
            <div class='modal-header py-2 text-white bg-success'>
                <h5 class='modal-title' id='exampleModalLongTitle'>لیست کالاهای به هشدار رسیده</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <table class="table table-striped">
                    <thead class="tableHeader">
                        <tr>
                        <th scope="col">ردیف</th>
                        <th scope="col">اسم</th>
                        <th scope="col">موجودی</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach($alarmedKalas as $kala)
                        <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$kala->GoodName}}</td>
                        <td>{{$kala->Amount/1}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
