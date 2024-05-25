@extends('admintemplate')
@section('content')
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
        <td class="role">
            <a href="/deletecus?uid={{$user->id}}" style="color:red">xóa</a>
            <a href="/changerole?uid={{$user->id}}">chuyển role</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection