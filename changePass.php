<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Add your password validation logic here, similar to the registration form

    if ($newPassword !== $confirmPassword) {
        $error = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } else {
        $username = $_SESSION['username'];
        
        $conn = mysqli_connect("localhost", "root", "", "ltw_db");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM khachhang WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($currentPassword, $row['password'])) {
                    $updateSql = "UPDATE khachhang SET password = '$newPassword' WHERE username = '$username'";
                    $updateResult = mysqli_query($conn, $updateSql);

                    if ($updateResult) {
                        $success = "Đổi mật khẩu thành công!";
                    } else {
                        $error = "Có lỗi xảy ra, vui lòng thử lại sau.";
                    }
                } else {
                    $error = "Mật khẩu hiện tại không đúng.";
                }
            } else {
                $error = "Người dùng không tồn tại.";
            }
        } else {
            $error = "Lỗi trong cơ sở dữ liệu.";
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
    <title>Đổi mật khẩu</title>
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
            <h3 class="fw-bold text-center mt-2">Đổi mật khẩu</h3>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Mật khẩu hiện tại" required>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Mật khẩu mới" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Xác nhận mật khẩu mới" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-primary mt-3" name="changePasswordButton">Đổi mật khẩu</button>
            </div>
        </form>
        <?php   
            if (isset($error)) {
                echo "<div class='alert alert-danger mt-3' role='alert'>$error</div>";
            } elseif (isset($success)) {
                echo "<div class='alert alert-success mt-3' role='alert'>$success</div>";
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
