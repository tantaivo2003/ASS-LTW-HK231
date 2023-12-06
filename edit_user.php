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
    $sql = "UPDATE khachhang SET fullname='$fullname', phoneNumber='$phoneNumber', email='$email', sex='$sex', address='$address', dateOfBirth='$dateOfBirth', avatar='$avatar', isbanned='$isbanned' WHERE username='$username'";

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

    // prepared statement
    $stmt_user_info = $conn->prepare("SELECT * FROM khachhang WHERE username = ?");
    $stmt_user_info->bind_param("s", $username);
    $stmt_user_info->execute();
    $user_info = $stmt_user_info->get_result();

    $stmt_user_total_orders = $conn->prepare("SELECT * FROM donhang WHERE orderUsername = ?");
    $stmt_user_total_orders->bind_param("s", $username);
    $stmt_user_total_orders->execute();
    $user_total_orders = $stmt_user_total_orders->get_result();
    ?>
        
        <div class="row">
            <div class="col-xs-12 col-md-6 mt-3">

            <?php
            // user info
            if ($user_info->num_rows > 0) {
                $user = $user_info->fetch_assoc();
            ?>        
                <h2 class="mb-3">Thông tin người dùng</h2>
                <!-- Display form --> 
                <form class="mt-3" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username;?>" method="post">
                    <div class="col-xs-12 col-md-9 col-xl-8">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập:</label>                            
                            <input type="hidden" class="form-control" id="username" name="username" value="<?php echo $user['username'];?>">
                            <input type="text" class="form-control" value="<?php echo $user['username'];?>" disabled>
                        </div>    
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['fullname'];?>" >
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Số điện thoại:</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $user['phoneNumber'];?>" >
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'];?>" >
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label">Giới tính:</label>
                            <select class="form-select" id="sex" name="sex" required>
                                <option value="" disabled>Chọn giới tính</option>
                                <option value="Male" <?php echo ($user['sex'] == 'Male') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Female" <?php echo ($user['sex'] == 'Female') ? 'selected' : ''; ?>>Nữ</option>
                                <option value="Other" <?php echo ($user['sex'] == 'Other') ? 'selected' : ''; ?>>Khác</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <textarea class="form-control" id="address" name="address"><?php echo $user['address']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dateOfBirth" class="form-label">Ngày sinh:</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo $user['dateOfBirth']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Image URL:</label>
                            <input type="text" class="form-control" id="avatar" name="avatar" value="<?php echo $user['avatar']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="isbanned" class="form-label">Bị cấm:</label>
                            <input type="hidden" name="isbanned" value="0">
                            <input class="form-check-input mt-0" type="checkbox" name="isbanned" value="1" <?php echo ($user['isbanned'] == 1) ? 'checked' : '' ?>>                
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò:</label>
                            <input type="text" class="form-control" value="<?php echo $user['role']; ?>" readonly disabled>
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
            </div>        
            <?php
            } else {
                echo '<script>alert("Username not found!")</script>';
            }
            ?>
            <!-- display user's orders-->
            <div class="col-xs-12 col-md-6 mt-3">
                <h2 class="mb-3">Lịch sử đơn hàng</h2>
                <?php
                if ($user_total_orders->num_rows > 0) {
                    echo '<table class="table table-bordered mt-3 table table-dark table-striped table-hover align-middle table-responsive w-auto" style="text-align:justify;">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt hàng</th>
                                    <th>Tổng</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>';
                    
                    while ($row_order = $user_total_orders->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><a href="order_info.php?orderId=' . $row_order['orderId'] . '">' . $row_order['orderId'] . '</a></td>';
                        echo '<td>' . $row_order['orderDate'] . '</td>';
                        echo '<td>' ."$" . $row_order['orderTotalPrice'] . '</td>';
                        echo '<td>' . $row_order['status'] . '</td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody></table>';
                } else {
                    echo '<p class="fw-bold">No orders found!</p>';
                }
                ?>

            </div>

        </div>
    <?php
    
} else {
    echo '<script>alert("Invalid Username!")</script>';
}

// Close connection
$conn->close();
?>

<?php
    include('footer.php');
?>