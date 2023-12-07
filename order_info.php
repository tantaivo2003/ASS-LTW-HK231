<?php
include("header.php");
include("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    // Collect data 
    $orderId = $_GET['orderId'];
    $status = $_POST['status'];

    // Update db
    $sql = "UPDATE donhang SET status='$status' WHERE orderId='$orderId'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Status updated successfully!")</script>';
        echo '<script>window.location.href = "order_management.php"</script>';
    } else {
        echo '<p>Error updating status: ' . $conn->error . '</p>';
    }
}

// Fetch Order details
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];
    
    // prepared statement get donhangbaogomsp
    $stmt_order_info = $conn->prepare("SELECT * FROM donhangbaogomsp WHERE oId = ?");
    $stmt_order_info->bind_param("i", $orderId);
    $stmt_order_info->execute();
    $order_info = $stmt_order_info->get_result();
    
    // prepared statement get donhang
    $stmt_user_total_orders = $conn->prepare("SELECT * FROM donhang WHERE orderId = ?");
    $stmt_user_total_orders->bind_param("i", $orderId);
    $stmt_user_total_orders->execute();
    $user_total_orders = $stmt_user_total_orders->get_result();
    
    $row_total_order = $user_total_orders->fetch_assoc();
    
    echo '<button class="btn mt-3" style="background-color:#FF8C00; color:white; margin-left: 20px;" onclick="goBack()">Quay lại</button>';

    echo '<hr size="5px" color="#FF8C00">';
    echo '<h2 class="mb-3">Đơn hàng #' . $orderId . '</h2>';
    echo '<p class="mb-3">Ngày đặt hàng:  ' . $row_total_order['orderDate'] . '</p>';

    ?>

    <div class="col-xs-12 col-md-6 col-xl-3 mt-3">
        <form class="mt-3" action="<?php echo $_SERVER['PHP_SELF'] . '?orderId=' . $orderId; ?>" method="post">
        <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">    
        <div class="mb-3">
                <label for="status" class="form-label">Trạng thái:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" disabled>Chọn trạng thái</option>
                    <option value="Pending" <?php echo ($row_total_order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Awaiting Payment" <?php echo ($row_total_order['status'] == 'Awaiting Payment') ? 'selected' : ''; ?>>Awaiting Payment</option>
                    <option value="Awaiting Fulfillment" <?php echo ($row_total_order['status'] == 'Awaiting Fulfillment') ? 'selected' : ''; ?>>Awaiting Fulfillment</option>
                    <option value="Awaiting Shipment" <?php echo ($row_total_order['status'] == 'Awaiting Shipment') ? 'selected' : ''; ?>>Awaiting Shipment</option>
                    <option value="Awaiting Pickup" <?php echo ($row_total_order['status'] == 'Awaiting Pickup') ? 'selected' : ''; ?>>Awaiting Pickup</option>
                    <option value="Partially Shipped" <?php echo ($row_total_order['status'] == 'Partially Shipped') ? 'selected' : ''; ?>>Partially Shipped</option>
                    <option value="Shipped" <?php echo ($row_total_order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                    <option value="Completed" <?php echo ($row_total_order['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo ($row_total_order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    <option value="Declined" <?php echo ($row_total_order['status'] == 'Declined') ? 'selected' : ''; ?>>Declined</option>
                    <option value="Refunded" <?php echo ($row_total_order['status'] == 'Refunded') ? 'selected' : ''; ?>>Refunded</option>
                    <option value="Disrupted" <?php echo ($row_total_order['status'] == 'Disrupted') ? 'selected' : ''; ?>>Disrupted</option>
                    <option value="Manual Verification Required" <?php echo ($row_total_order['status'] == 'Manual Verification Required') ? 'selected' : ''; ?>>Manual Verification Required</option>
                    <option value="Partially Refunded" <?php echo ($row_total_order['status'] == 'Partially Refunded') ? 'selected' : ''; ?>>Partially Refunded</option>
                </select>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <input type="submit" class="form-control btn btn-primary" name="update_status" value="Lưu thay đổi">
                </div>
                <div class="col-6">
                    <input type="reset" class="form-control btn btn-danger" name="reset" value="Đặt lại">
                </div>
            </div>
        </form>
    </div>

    <?php
    // user info
    if ($order_info->num_rows > 0) {
        echo '<br>';
        echo '<br>';
        echo '<strong>Chi tiết đơn hàng:</strong>';
        echo '<br>';
        echo '<table class="table table-bordered mt-3 table table-striped table-hover align-middle table-responsive w-auto" style="text-align:justify;">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Mã sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>';
        
        while ($row_order = $order_info->fetch_assoc()) {
            echo '<tr>';    // prepared statement get sanpham
            $stmt_product_info = $conn->prepare("SELECT * FROM sanpham WHERE productId = ?");
            $stmt_product_info->bind_param("i", $row_order['oProductId']);
            $stmt_product_info->execute();
            $product_info = $stmt_product_info->get_result();
            $product = $product_info->fetch_assoc();

            echo '<td><a href="detail_product_logged.php?id=' . $row_order["oProductId"] . '">' . $product['name'] . '</td>';
            echo '<td>' . $row_order['oProductId'] . '</td>';
            echo '<td>' . $product['price'] . '</td>';
            echo '<td>' . $row_order['totalProduct'] . '</td>';
            $totalProductValue = $product['price'] * $row_order['totalProduct'];
            echo '<td>' . $totalProductValue . '</td>';
            echo '</tr>';
        }
        // Display the total row
        echo '<tr>';
        echo '<td colspan="4"><strong>Tổng cộng:</strong></td>';
        echo '<td><strong>$ ' . $row_total_order['orderTotalPrice'] . '</strong></td>';
        echo '</tr>';
        echo '</tbody></table>';
    } else {
        echo '<p class="fw-bold">No orders found!</p>';
    }

} else {
    echo '<script>alert("Invalid Order ID!")</script>';
}
?>

<script>
  function goBack() {
    window.history.back();
  }
</script>
