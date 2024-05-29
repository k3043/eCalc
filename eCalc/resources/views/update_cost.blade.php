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
<form action="/updatecost" method="post">@csrf
    <button class="btn">Lưu</button>
    <table class="ecost-tbl">
        <tr>
            <th>Bậc</th>
            <th>Giá</th>
        </tr>
        @if(isset($ecost))
        <tr>
            <td>1</td>
            <td><input type="number" value="{{$ecost->c1}}" name="c1" class="ein"></td>
        </tr>
        <tr>
            <td>2</td>
            <td><input type="number" value="{{$ecost->c2}}" name="c2" class="ein"></td>
        </tr>
        <tr>
            <td>3</td>
            <td><input type="number" value="{{$ecost->c3}}" name="c3" class="ein"></td>
        </tr>
        <tr>
            <td>4</td>
            <td><input type="number" value="{{$ecost->c4}}" name="c4" class="ein"></td>
        </tr>
        <tr>
            <td>5</td>
            <td><input type="number" value="{{$ecost->c5}}" name="c5" class="ein"></td>
        </tr>
        <tr>
            <td>6</td>
            <td><input type="number" value="{{$ecost->c6}}" name="c6" class="ein"></td>
        </tr>
        @endif
        
    </table>
</form>

@endsection