<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Admin</title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  </head>
  <body>
    <nav>
      <div class="logo">
        <i class="bx bx-menu menu-icon"></i>
        <span class="logo-name">Electricity</span>
      </div>
      <div class="sidebar">
        <div class="logo">
          <i class="bx bx-menu menu-icon"></i>
          <span class="logo-name">Electricity</span>
        </div>

        <div class="sidebar-content">
          <ul class="lists">
            <li class="list">
              <a href="/customer" class="nav-link">
                <i class='bx bx-smile icon'></i>
                <span class="link">Khách hàng</span>
              </a>
            </li>
            <li class="list">
              <a href="/kwh" class="nav-link">
                <i class="bx bx-bar-chart-alt-2 icon"></i>
                <span class="link">Cập nhật số điện</span>
              </a>
            </li>
            <li class="list">
              <a href="/showcost" class="nav-link">
                <i class='bx bx-purchase-tag-alt icon' ></i>
                <span class="link">Cập nhật giá điện</span>
              </a>
            </li>
            <li class="list">
              <a href="/bill" class="nav-link">
                <i class='bx bx-money-withdraw icon' ></i>
                <span class="link">Hóa đơn</span>
              </a>
            </li>
         
          </ul>

          <div class="bottom-cotent">
            <li class="list">
              <a href="#" class="nav-link">
                <i class="bx bx-cog icon"></i>
                <span class="link">Cài đặt</span>
              </a>
            </li>
            <li class="list">
              <a href="/logout" class="nav-link">
                <i class="bx bx-log-out icon"></i>
                <span class="link">Đăng xuất</span>
              </a>
            </li>
          </div>
        </div>
      </div>
    </nav>
<div class="container">
     @yield('content')
</div>
   
    <script src="script.js"></script>
  </body>
</html>