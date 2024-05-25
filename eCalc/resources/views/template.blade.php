<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="calc.css">
    <title>Electricity</title>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <a href=""><div class="logo">
                <i class="fa-solid fa-bolt"></i>
                <p>Electricity</p>
            </div>
            </a>
            <div class="wrap-user">
                <div class="avatar">
                    @if(Auth::check())
                    <p>{{Auth::user()->name[0]}}</p>
                    @else
                    <i class="fa-solid fa-user"></i>
                    @endif
                </div>
                @if(Auth::check())             
                    <p class="username">{{Auth::user()->name}}</p>        
                    <a class="log" href="/logout"><i class="fa-solid fa-right-from-bracket"></i></a>
                @else
                    <a href="/login" style="color:white">Login</a>     
                    <a href="/login" class="log"><i class="fa-solid fa-right-to-bracket"></i></a>
                @endif
            </div>
        </div>
        <div class="header-bottom">
            <div class="wrap-header-bottom">
                <a href="/" class="ecalc">Tính tiền điện</a>
                <a href="/cost" class="cost">Giá điện</a>
                <a href="/search" class="searchh">Tra cứu</a>
                <a href="/pay" class="pay">Đóng tiền</a>
            </div>
        </div>
    </div>
    @yield('content')
</body>
</html>