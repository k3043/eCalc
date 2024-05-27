<h2 style="font-family: 'Courier New', Courier, monospace;color:palevioletred;text-align:center">
Hóa đơn điện
</h2>
<div style="font-family:'Courier New', Courier, monospace;color:palevioletred;">
        Mã khách hàng: {{ $user->cus_code }} <br> 
        Tên khách hàng: {{ $user->name }} <br> 
        Kỳ hạn: {{date('m', strtotime($bill->month))}}-{{date('Y', strtotime($bill->month))}} <br> 
        Số điện đã sử dụng: {{ $bill->kwh_used }} <br> 
        Thành tiền: {{ $bill->amount }} <br>  
        Trạng thái: {{ $bill->status }}
</div>  
