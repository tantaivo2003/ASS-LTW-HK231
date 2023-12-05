<?php
    include('header.php');
?>
<a class="btn mt-3" href="admin_page.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
<hr size="5px" color="#FF8C00">
<?php
    include("database.php");

    $sql = "SELECT * FROM khachhang"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display table
        echo '<table class="table table-bordered mt-3 table table-dark table-striped table-hover align-middle table-responsive" style="text-align:justify;">';
        echo '<thead>';
        echo '<tr class="fit-content-row">';
        echo '<th scope="col">Tên đăng nhập</th>';
        echo '<th>Họ và tên</th>';
        echo '<th>Số điện thoại</th>';
        echo '<th>Email</th>';
        echo '<th>Giới tính</th>';
        echo '<th>Địa chỉ</th>';
        echo '<th>Ngày sinh</th>';
        echo '<th>Ảnh đại diện</th>';
        echo '<th>Bị cấm</th>';
        echo '<th>Vai trò</th>';
        echo '<th>Action</th>'; // Column for actions
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) { // sua ten bien
            echo '<tr>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['fullname'] . '</td>';
            echo '<td>'. $row['phoneNumber'] . '</td>';
            echo '<td>'. $row['email'] . '</td>';
            echo '<td>'. $row['sex'] . '</td>';
            echo '<td>'. $row['address'] . '</td>';
            echo '<td>' . $row['dateOfBirth'] . '</td>';
            echo '<td>' . $row['avatar'] . '</td>';
            //echo '<td>'. $row['isbanned'] . '</td>';
            $isBannedValue = $row['isbanned'];
            echo '<td><input class="form-check-input mt-0" type="checkbox" ' . ($isBannedValue == 1 ? 'checked' : '') . ' disabled></td>';

            echo '<td>'. $row['role'] . '</td>';

            // Action buttons
            echo '<td>';
            echo '<a href="edit_user.php?username=' . $row['username'] . '" class="btn btn-primary btn-sm">Chi tiết</a>';
            echo ' ';
            echo '<a href="delete_user.php?username=' . $row['username'] . '" class="btn btn-danger btn-sm">Xóa</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<script>alert("No users found!")</script>';
    }

    // Close connection
    $conn->close();
?>


<?php
    include('footer.php');
?>