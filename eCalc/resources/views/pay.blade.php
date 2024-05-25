@extends('template')
@section('content')
    @if(isset($bill))
    <div class="container">
        <div class="innertext">
            Mã khách hàng: {{ $user->cus_code }} <br> 
            Tên khách hàng: {{ $user->name }} <br> 
            Kỳ hạn: {{date('m', strtotime($bill->month))}}-{{date('Y', strtotime($bill->month))}} <br> 
            Số điện đã sử dụng: {{ $bill->kwh_used }} <br> 
            Thành tiền: {{ $bill->amount }} <br>  
            Trạng thái: {{ $bill->status }}
        </div>     
        @if ($bill->status =='chờ thanh toán') 
        <a href="/paybill"><button class="bill-btn">Thanh toán</button></a>    
        @elseif  ($bill->status =='đã thanh toán') 
        <button type="button" class="bill-btn bill-inactive">Đã thanh toán</button>  
        @endif   
    </div>    
    @else
        <p>Không có dữ liệu!</p>
    @endif

@endsection