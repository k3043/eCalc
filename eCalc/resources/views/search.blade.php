@extends('template')
@section('content')
@if ($errors->any())
        <div class="alert alert-danger" style="text-align: center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="/search" class="search-form" method="post">
    @csrf
    <input type="text" name="querry" class="search" placeholder="Nhập mã khách hàng">
    <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    @if (isset($result) and $result != null)
    <div class="container" style="margin-top: 30px;">
        <div class="wrap-result">
            <p class="cusname">Tên khách hàng: {{$result->name}}</p>
            <p class="cuscode">Mã khách hàng: {{$result->code}}</p>
            <p class="chiso">Chỉ số điện tháng {{date('m')}}/{{date('Y')}}: {{$result->econ}}</p>
            <div class="time">Cập nhật lúc: {{$result->at}}</div>
            
        </div>
    </div>
    @else
        <p class="noti">Không có thông tin!</p>
    @endif
    
</form>
@endsection