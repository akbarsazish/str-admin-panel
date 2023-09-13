@extends('admin.layout')
@section('content')
    <div class="container">
        <h5 style="border-bottom:2px solid gray; width:50%"> نتیجه بازی </h5>
    <div class="card mb-1">
      <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label fs-6"> جستجو</label>
                                    <input type="text" name="" size="20" class="form-control" id="allKalaFirst">
                                </div>
                            </div>
                        </div><br>
                            <table class="table table-bordered message">
                                <thead class="tableHeader">
                                <tr>
                                    <th>ردیف</th>
                                    <th> نام مشتری </th>
                                    <th>شماره تماس</th>
                                    <th>جایزه (تومان)</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody class="tableBody">
                            @foreach ($players as $player)
                                <tr>
                                    <td>{{number_format($loop->index+1)}}</td>
                                    <td>{{$player->Name}}</td>
                                    <td>{{$player->Name}}</td>
                                    <td>{{number_format($player->prize)}}</td>
                                    <td> <i class="fa fa-trash" style="color:red; cursor:pointer"></i> </td>
                                 </tr>
                              @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
