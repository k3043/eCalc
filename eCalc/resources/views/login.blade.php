<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="log.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<!-- @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000); // 3 giây
        </script>
    @endif -->
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="/login" method="post">
    @csrf
      <h3>Login Here</h3>
        <!--   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->
        <label for="username">Email</label>
        <input type="text" placeholder="Email" id="username" name="email">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password">

        <button>Log In</button>
        <div class="social">
        <p>Don't have account? </p>
          <a href="/register"><div class="fb">Register</div></a>
        </div>
    </form>
</body>
</html>
