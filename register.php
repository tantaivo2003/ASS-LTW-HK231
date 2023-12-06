<?php
    if (isset($_POST["submitButton"])) {
        $error = "";
        $fullname = $_POST["fullname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $retypePassword = $_POST["retypePassword"];
        $gender = $_POST["gender"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $email = $_POST["email"];

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
        // Additional checks for email, phone, gender, and address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Email không hợp lệ.\n";
        }

        // Adjust the phone validation based on your requirements
        if (!preg_match('/^[0-9]{10,}$/', $phone)) {
            $error .= "Số điện thoại không hợp lệ.\n";
        }

        if ($gender !== 'male' && $gender !== 'female' && $gender !== 'other') {
            $error .= "Vui lòng chọn giới tính.\n";
        }

        if (empty($address)) {
            $error .= "Vui lòng nhập địa chỉ.\n";
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
                $sql = "INSERT INTO KhachHang (username, password, fullname, sex, phoneNumber, address, email) 
                        VALUES ('$username', '$password', '$fullname', '$gender', '$phone', '$address', '$email')";
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
    </style>
</head>
<body>

    <div class="container bg-light mt-3" style="width: 400px; margin-top: 100px; margin-bottom: 100px">
        <div class="row">
            <h3 class="fw-bold text-center mt-2">Đăng kí</h3>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="mb-3">
                <label for="floatingfullname" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="floatingfullname" name="fullname" placeholder="Họ và tên">
            </div>
            <div class="mb-3">
                <label for="floatingusername" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="floatingusername" name="username" placeholder="Tên đăng nhập">
            </div>
            <div class="mb-3">
                <label for="floatingPassword" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Mật khẩu">
            </div>
            <div class="mb-3">
                <label for="floatingretypePassword" class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="floatingretypePassword" name="retypePassword" placeholder="Nhập lại mật khẩu">
            </div>
            <div class="mb-3">
                <label for="floatingGender" class="form-label">Giới tính</label>
                <select class="form-select" id="floatingGender" name="gender">
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="floatingPhone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="floatingPhone" name="phone" placeholder="Số điện thoại">
            </div>
            <div class="mb-3">
                <label for="floatingAddress" class="form-label">Địa chỉ</label>
                <textarea class="form-control" id="floatingAddress" name="address" rows="3" placeholder="Địa chỉ"></textarea>
            </div>
            <div class="mb-3">
                <label for="floatingEmail" class="form-label">Email</label>
                <input type="textl" class="form-control" id="floatingEmail" name="email" placeholder="Email">
            </div>
            <div class="registerButton mb-3">
                <a href="login.php">Đã có tài khoản? Đăng nhập</a>
            </div>
            <button type="button" class="btn btn-dark" onclick="validateForm()">Kiểm tra</button>
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary mt-3" id="submitButton" name="submitButton" value="Đăng kí">
            </div>
        </form>
    </div>
    <?php   
        if (isset($_POST["submitButton"])) {
            if ($error != "") {
                echo "<script>alert('$error');</script>";
            }
        } 
    ?>
    <script>
        function validateForm() {
            var fullname = document.getElementById('floatingfullname').value;
            var username = document.getElementById('floatingusername').value;
            var password = document.getElementById('floatingPassword').value;
            var retypePassword = document.getElementById('floatingretypePassword').value;
            var gender = document.getElementById('floatingGender').value;
            var phone = document.getElementById('floatingPhone').value;
            var address = document.getElementById('floatingAddress').value;
            var email = document.getElementById('floatingEmail').value;

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

            if (gender === '') {
                errorMessage += 'Vui lòng chọn giới tính.\n';
            }

            // Validate email using a simple regex
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage += 'Email không hợp lệ.\n';
            }

            // Validate phone using a simple regex (you may need to adjust this based on your requirements)
            var phoneRegex = /^[0-9]{10,}$/;
            if (!phoneRegex.test(phone)) {
                errorMessage += 'Số điện thoại không hợp lệ.\n';
            }

            // Validate address (you may need to adjust this based on your requirements)
            if (address.trim() === '') {
                errorMessage += 'Vui lòng nhập địa chỉ.\n';
            }

            if (errorMessage != '') {
                alert(errorMessage);
            } else {
                alert('Thông tin đăng kí hợp lệ!');
                document.getElementById('submitButton').click(); // Submit the form if validation passes
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
