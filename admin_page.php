<?php
    include("header.php");
?>
<a class="btn mt-3" href="index_admin.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
<hr size="5px" color="#FF8C00">
<div class="container mt-3">
    <div class="body">
        <h1 class="mt-1" style="color: white; text-align: center;">Quản lí thành viên</h1>
        <hr>

        <button type="button" class="btn mt-3" style="background-color:#FF8C00; color:white;" id="user-database">Hiển thị thông tin thành viên</button>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#user-database').click(function() {
        $.ajax({
            url: 'user_management.php',  
            type: 'GET',
            success: function(response) {
                window.location.href = "user_management.php";
            },
            error: function(error) {
                console.error('Failed to fetch data:', error);
            }
        });
    });
});
</script>

<?php
    include('footer.php');
?>







