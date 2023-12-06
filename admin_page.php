<?php
    include("header.php");
?>
<a class="btn mt-3" href="index_admin.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
<hr size="5px" color="#FF8C00">
<div class="container mt-3">
    <div class="body">
        <h1 class="mt-1" style="color: white; text-align: center;">Quản lí</h1>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-xl-3">
                <div class="d-grid gap-1">
                <button type="button" class="btn btn-block mt-3" style="background-color:#FF8C00; color:white;" id="user-mnm">Quản lí thông tin thành viên</button>
                <button type="button" class="btn btn-block mt-3" style="background-color:#FF8C00; color:white;" id="order-mnm">Quản lí đơn hàng</button>
                <button type="button" class="btn btn-block mt-3" style="background-color:#FF8C00; color:white;" id="comment-mnm">Quản lí bình luận</button>
                <button type="button" class="btn btn-block mt-3" style="background-color:#FF8C00; color:white;" id="product-mnm">Quản lí sản phẩm</button>
                <button type="button" class="btn btn-block mt-3" style="background-color:#FF8C00; color:white;" id="contact-mnm">Quản lí liên hệ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function redirectToPage(page) {
    $.ajax({
        url: page,
        type: 'GET',
        success: function(response) {
            window.location.href = page;
        },
        error: function(error) {
            console.error('Failed to fetch data:', error);
        }
    });
}

$(document).ready(function() {
    $('#user-mnm').click(function() {
        redirectToPage("user_management.php");
    });

    $('#order-mnm').click(function() {
        redirectToPage("order_management.php");
    });

    $('#comment-mnm').click(function() {
        redirectToPage("comment_admin.php");
    });

    $('#product-mnm').click(function() {
        redirectToPage("product_admin.php");
    });

    $('#contact-mnm').click(function() {
        redirectToPage("edit_contact.php");
    });
});
</script>


<?php
    include('footer.php');
?>







