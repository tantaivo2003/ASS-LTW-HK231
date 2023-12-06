<?php
    include("header.php");
?>



<?php
include("database.php");



// Fetch Order details
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];
    $username = $_GET['username'];
    ?>
    <a class="btn mt-3" href="edit_user.php?username=<?php echo $username; ?>" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
    <hr size="5px" color="#FF8C00">
    <?php
    echo '<h2 class="mb-3">Đơn hàng ' . $orderId . '</h2>';

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




    echo '<p class="mb-3">Ngày:       ' . $row_total_order['orderDate'] . '</p>';
    echo '<p class="mb-3">Trạng thái: ' . $row_total_order['status'] . '</p>';


    // user info
    if ($order_info->num_rows > 0) {
        echo '<table class="table table-bordered mt-3 table table-dark table-striped table-hover align-middle table-responsive" style="text-align:justify;">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
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

            echo '<td>' . $product['name'] . '</td>';
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
        echo '<td><strong>' . $row_total_order['orderTotalPrice'] . '</strong></td>';
        echo '</tr>';
        echo '</tbody></table>';
    } else {
        echo '<p class="fw-bold">No orders found!</p>';
    }

} else {
    echo '<script>alert("Invalid Order ID!")</script>';
}
?>