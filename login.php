<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $checkRemember = isset($_POST["rememberMe"]) ? $_POST["rememberMe"] : 0;

    if (empty($username) || empty($password)) {
        echo '<script>alert("Vui lòng nhập đầy đủ thông tin")</script>';
    } else {
        $conn = mysqli_connect("localhost", "root", "", "ltw_db");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $rows = mysqli_query($conn,"
				select * from khachhang where username = '$username' and password = '$password'
			");
			$count = mysqli_num_rows($rows);
			if($count==1){
                session_start();
                $_SESSION['username'] = $username;
                if($checkRemember){
                    setcookie("username", $username, time() + (86400 * 30), "/");
                    setcookie("password", $password, time() + (86400 * 30), "/");
                }
				header("location:hello.php");
                exit();
			}
			else{
                echo '<script>alert("Sai tên người dùng hoặc mật khẩu.")</script>';
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
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="/applogo.png"/>
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

        .pageFooter{
            width: 100%;   
            padding: 0px;
        }
    </style>
</head>
<body>
    <div class="container bg-light mt-3" style="width: 400px; margin-top: 100px; margin-bottom: 100px">
        <div class="row">
            <h3 class="fw-bold text-center mt-2">Đăng nhập</h3>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <input type="text" class="form-control mt-3" id="username" name="username" placeholder="Tên đăng nhập">
            <input type="password" class="form-control mt-3" id="password" name="password" placeholder="Mật khẩu">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="rememberMe" id="rememberMe">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <div class="form-text" style="color: #FF8C00;">Chưa có tài khoản? <a href="register.php" style="color: #FF8C00;">Đăng ký</a></div>
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary mt-3" name="submit" value="Đăng nhập">
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>