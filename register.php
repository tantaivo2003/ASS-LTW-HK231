<?php
    if (isset($_POST["submitButton"])) {
        $error = "";
        $fullname = $_POST["fullname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $retypePassword = $_POST["retypePassword"];

        if (strlen($fullname) < 2 || strlen($fullname) > 30) {
            $error .= "Họ và tên phải từ 2 đến 30 kí tự.\n";
        }
        if (strlen($username) < 2 || strlen($username) > 30) {
            $error .=  "Tên đăng nhập phải từ 2 đến 30 kí tự.\n";
        }
        if (strlen($password) < 6) {
            $error .= "Mật khẩu phải chứa ít nhất 6 kí tự.\n";
        }
        if ($password !== $retypePassword) {
            $error .= "Mật khẩu nhập lại không khớp.";
        }

        if ($error == ""){
            $conn = mysqli_connect("localhost", "root", "", "ltw_db");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM KhachHang WHERE username = '$username'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                $error .= "Tên đăng nhập đã tồn tại.";
            } 
            else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO KhachHang (username, password, fullname) VALUES ('$username', '$hashedPassword', '$fullname')";
                $res = mysqli_query($conn, $sql);
                if ($res) {
                    $error .= "Đăng ký tài khoản thành công!";
                } 
                else {
                    $error .= "Đăng ký tài khoản thất bại!";
                }
            }
            mysqli_close($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Đăng ký</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *{
            box-sizing: border-box;
            font-family: "Inter";  
        }

        .pageHeader{
            position: relative;
            width: 100%;
            padding: 0px;
        }
        .pageHeader .nav-item { 
            padding-left: 7px;
            padding-right: 7px;
        }

        .container{
            width: 60%;
            margin-top: 70px;
            margin-bottom: 70px;
        }
        .registerForm{
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 10px;
        }
        .registerForm h2{
            text-align: center;
            margin-top: 40px;
        }
        .registerForm label{
            font-weight: 500;
        }
        .registerForm .registerButton{
            margin-top: 20px;
        }
        .registerForm button{
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
        }
        hr{
            border: 1px solid #000;
            margin: 0px;
        }
        input{
            border: 0px;
        }
        a{
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .registerForm .btn{
            height: 50px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid bg-black pageHeader">
        <nav class="navbar navbar-expand-lg navbar-black bg-black">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="TimeElite" class="img-responsive" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#" style="color: #FF8C00">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex" style="padding-left: 30px; padding-right: 30px">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellow">
                            <img src="images/cart.jpg" alt="" width="30" height="30">
                            <i class="bi bi-cart"></i>Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellowgreen">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellowgreen">Sign up</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class = "container">
        <div class = "registerForm">
            <h2>ĐĂNG KÝ</h2>
            <form action = "" method  = "POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id = "floatingfullname" name = "fullname" placeholder="name@example.com">
                    <label for="floatingInput">Họ và tên</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id = "floatingusername" name = "username" placeholder="name@example.com">
                    <label for="floatingInput">Tên đăng nhập</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name = "password" placeholder="Password">
                    <label for="floatingPassword">Mật khẩu</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingretypePassword" name = "retypePassword" placeholder="Password">
                    <label for="floatingPassword">Nhập lại mật khẩu</label>
                </div>
                <div class = "registerButton">
                    <a href = "login.php">Đã có tài khoản? Đăng nhập</a>
                </div>     
                <button type="button" class="btn btn-dark" onclick = "validateForm()">Đăng ký</button>
                <button style = "display: none" type="submit" class="btn btn-dark" id = "submitButton" name="submitButton">Đăng ký</button>
            </form>
        </div>

    </div>
    <div class = "pageFooter">
        <div class="container-fluid bg-black">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="ft-dm" style="color: gray">Liên Hệ</div>
                    <div class="ft-address">
                        <span style="font-size: 20px">
                            <strong style="color: gray">TIME ELITE</strong>
                        </span>
                        <br>
                        <span style="font-size: 14px">
                            <span style="color: #696969">Địa chỉ:</span>
                            <span style="color: #FF8C00">Showroom: 268 Lý Thường Kiệt, Q.10, Thành phố Hồ Chí Minh</span>
                        </span>
                        <br>
                        <span style="font-size: 14px">
                            <span style="color: #696969">Email:</span>
                            <span style="color: #FF8C00">TimeElite@gmail.com</span>
                            <br>
                            <span style="color: #696969">Hotline tư vấn bán hàng:</span>
                            <span style="color: #FF8C00">0948315737</span>
                            <br>
                            <span style="color: #696969">Facebook:</span>
                            <span style="color: #FF8C00">www.facebook.com/TimeElite.vn</span>
                            <br>
                            <span style="color: #696969">Instagram:</span>
                            <span style="color: #FF8C00">@TimeElite</span>
                            <br>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <span style="font-size: 18px">
                        <strong style="color: gray">DÀNH CHO NGƯỜI DÙNG</strong>
                    </span>
                    <br>
                    <span style="color: #FF8C00">Chính sách thanh toán</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách vận chuyển</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách đổi trả</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách bảo hành sản phẩm</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách kiểm hàng</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách bảo mật thông tin</span>
                    <br>
                </div>
            </div>
        </div>
        <div class="footer_info">
            <div class="row">
                <div class="col-sm-4">
                    <img src="images/thanhtoan.jpg" alt="TimeElite">
                </div>
                <div class="col-sm-4">
                    <img src="images/connect.jpg" alt="TimeElite" width="300" height="150">
                </div>
                <div class="col-sm-4">
                    <img src="images/dangky.jpg" alt="TimeElite">
                </div>
            </div>
        </div>
    </div>
    <?php   
        if (isset($_POST["submitButton"])) {
            if ($error != "") {
                echo "<script>alert('$error');</script>";
            }
        } 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
    function validateForm() {
        var fullname = document.getElementById('floatingfullname').value;
        var username = document.getElementById('floatingusername').value;
        var password = document.getElementById('floatingPassword').value;
        var retypePassword = document.getElementById('floatingretypePassword').value;

        var errorMessage = '';

        if (fullname.length < 2 || fullname.length > 30) {
            errorMessage += 'Họ và tên phải từ 2 đến 30 kí tự.\n';
        }

        if (username.length < 2 || username.length > 30) {
            errorMessage += 'Tên đăng nhập phải từ 2 đến 30 kí tự.\n';
        }

        if (password.length < 6) {
            errorMessage += 'Mật khẩu phải chứa ít nhất 6 kí tự.\n';
        }

        if (password != retypePassword) {
            errorMessage += 'Mật khẩu nhập lại không khớp.\n';
        }

        if (errorMessage != '') {
            alert(errorMessage);
        }
        else{
            document.getElementById('submitButton').click();
        }
    }
</script>
</body>
</html>