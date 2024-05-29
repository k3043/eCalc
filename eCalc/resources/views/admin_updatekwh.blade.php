@extends('admintemplate')
@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="/updatekwh" method="post" class="formkwm">
@csrf
<button class="btn">Lưu</button>
<table class="cus-tbl">
    <tr>
        <th>Mã KH</th>
        <th>Tên KH</th>
        <th>Email</th>
        <th></th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{$user->cus_code}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td class="kwh">
            <input type="number" value="{{$user->econ}}" name="kwh[{{$user->id}}]">
        </td>
    </tr>
    @endforeach
</table>

</form>
@endsection