@extends('admintemplate')
@section('content')
<h2 style="text-align: center;margin:30px 0px;color:brown">Hóa đơn điện tháng {{date('m')}}</h2>
<!-- <form class="formkwm">
@csrf -->

<div class="twobtn">
    <a href="/closebill"><button class="btn btn2">Chốt hóa đơn</button></a>
    <a href="/noti"><button class="btn btn2">Gửi mail</button></a>
</div>

<table class="cus-tbl">
    <tr>
        <th>Mã KH</th>
        <th>Tên KH</th>
        <th>Email</th>
        <th>Số điện</th>
        <th>Thành tiền</th>
        <th>Trạng thái</th>
    </tr>
    @if (isset($users))
    
    @foreach($users as $user)
    <tr>
        <td>{{$user->cus_code}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->used}}</td>
        <td>{{$user->amount}}</td>
        @if($user->status=='đã thanh toán')<td ><p class="ok">{{$user->status}}</p></td>
        @else <td ><p class="not">{{$user->status}}</p></td>
        @endif
    </tr>
    @endforeach
    @endif
</table>

<!-- </form> -->
@endsection