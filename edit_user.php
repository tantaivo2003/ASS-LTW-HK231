<?php
    include("header.php");
?>
<a class="btn mt-3" href="user_management.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
<hr size="5px" color="#FF8C00">

<?php
include("database.php");

// Check submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    // Collect data 
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $avatar = $_POST['avatar'];
    $isbanned = $_POST['isbanned'];
    $role = $_POST['role'];



    // Update db
    $sql = "UPDATE khachhang SET fullname='$fullname', phoneNumber='$phoneNumber', email='$email', sex='$sex', address='$address', dateOfBirth='$dateOfBirth', avatar='$avatar', isbanned='$isbanned', role='$role' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("User updated successfully!")</script>';
        echo '<script>window.location.href = "user_management.php" </script>';
    } else {
        echo '<p>Error updating user: ' . $conn->error . '</p>';
    }
}

// Fetch product details
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $result = $stmt->get_result();

    

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Display form 
        ?>
        
        <form class="mt-3" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username; ?>" method="post">
            <h2 class="mb-3">Thay đổi thông tin thành viên</h2>
            <div class="col-xs-12 col-md-6 col-xl-3">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" readonly>
                </div>    
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Số điện thoại:</label>
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $user['phoneNumber']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sex" class="form-label">Giới tính:</label>
                    <select class="form-select" id="sex" name="sex" required>
                        <option value="" disabled>Chọn giới tính</option>
                        <option value="male" <?php echo ($user['sex'] == 'male') ? 'selected' : ''; ?>>Nam</option>
                        <option value="female" <?php echo ($user['sex'] == 'female') ? 'selected' : ''; ?>>Nữ</option>
                        <option value="other" <?php echo ($user['sex'] == 'other') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <textarea class="form-control" id="address" name="address" required><?php echo $user['address']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="dateOfBirth" class="form-label">Ngày sinh:</label>
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo $user['dateOfBirth']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Image URL:</label>
                    <input type="text" class="form-control" id="avatar" name="avatar" value="<?php echo $user['avatar']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="isbanned" class="form-label">Bị cấm:</label>
                    <input type="hidden" name="isbanned" value="0">
                    <input class="form-check-input mt-0" type="checkbox" name="isbanned" value="1" <?php echo ($user['isbanned'] == 1) ? 'checked' : '' ?>>                
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Vai trò:</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled>Chọn vai trò</option>
                        <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input type="submit" class="form-control btn btn-primary" name="update_user" value="Lưu thay đổi">
                    </div>
                    <div class="col-6">
                        <input type="reset" class="form-control btn btn-danger" name="reset" value="Đặt lại">
                    </div>
                </div>
            </div>
            
        </form>
        <?php
    } else {
        echo '<script>alert("Username not found!")</script>';
    }
} else {
    echo '<script>alert("Invalid Username!")</script>';
}

// Close connection
$conn->close();
?>

<?php
    include('footer.php');
?>