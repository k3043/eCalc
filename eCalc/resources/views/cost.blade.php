@extends('template')
@section('content')
<div class="container">
<p class="cost-title main-title">Giá điện hiện tại</p>
        <table class="result-tbl">
            <tr>
                <th></th>
                <th>Đơn giá<br>(đồng/kWh)</th>
                <th>Sản lượng <br>(kWh)</th>
                <th>Thành tiền <br>(đồng)</th>
            </tr>
            <tr>
                <td class="td1">Bậc thang 1</td>
                <td>{{$c1}} </td>
                <td>0 - 50</td>
                <td>{{50*$c1}}</td>
            </tr>
            <tr>
                <td class="td1">Bậc thang 2</td>
                <td>{{$c2}}</td>
                <td>51 - 100</td>
                <td>{{50*$c2}}</td>
            </tr>
            <tr>
                <td class="td1">Bậc thang 3</td>
                <td>{{$c3}}</td>
                <td>101 - 200</td>
                <td>{{100*$c3}}</td>
            </tr>
            <tr>
                <td class="td1">Bậc thang 4</td>
                <td>{{$c4}}</td>
                <td>201 - 300</td>
                <td>{{100*$c4}}</td>
            </tr>
            <tr>
                <td class="td1">Bậc thang 5</td>
                <td>{{$c5}}</td>
                <td>301 - 400</td>
                <td>{{100*$c5}}</td>
            </tr>
            <tr>
                <td class="td1">Bậc thang 6</td>
                <td>{{$c6}}</td>
                <td>> 400</td>
                <td>...</td>
            </tr>
        </table>
    </div>
@endsection