<?php
    $cartNull = 0;
    session_start(); 
    $username = "user1"; //test user1
    $conn = mysqli_connect("localhost", "root", "", "ltw_db");
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * from GioHangBaoGomSP where cUsername = '$username'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0){
        $cartNull = 1;
    }

    if (isset($_POST["deleteButton"])){
        $productId = $_POST["productId"];
        $sql = "DELETE from GioHangBaoGomSP where cProductId = '$productId'";
        $res = mysqli_query($conn, $sql);
        header("Location: cartPage.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Header</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.1/font/bootstrap-icons.css" rel="stylesheet">
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

        .container{
            width: 60%;
            margin-top: 100px;
            margin-bottom: 100px;
        }
        #nullCartFrame{
            margin-top: 50px;
            margin-bottom: 50px;
        }
        #nullCartImage{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50px;
            height: 50px;
        }
        .cartFrameHeader{
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 50px;
            padding: 10px;
            background-color: #FF8C00;
            color: white;
        }
        .cartFrameHeader div{
            font-weight: bold;
            text-align: center;
        }

        .cartFrame{
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-top: 20px;
        }

        .cartFrame input{
            width: 50px;
            text-align: center;
        }
        .deleteButton button{
            background-color: transparent;  
            border: none;
        }
        #orderButtonFrame{
            display: flex;  
            justify-content: flex-end;
            align-items: center;
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-top: 20px;
        }
        #orderButtonFrame #orderButton1{
            margin-top: 20px;
            width: 170px;
            text-align: center;
        }

        #purchaseFrame #displayTotalPrice{
            font-weight: bold;
            font-size: 20px;
        }

        
    </style>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid bg-black pageHeader">
        <nav class="navbar navbar-expand-lg navbar-black bg-black">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="TimeElite" class="img-responsive" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#" style="color: #FF8C00">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex" style="padding-left: 30px; padding-right: 30px">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellow">
                            <img src="images/cart.jpg" alt="" width="30" height="30">
                            <i class="bi bi-cart"></i>Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellowgreen">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: yellowgreen">Sign up</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class = "container">
        <h3 style = "margin-bottom: 50px;">Giỏ hàng của bạn:</h3>
    <?php
        if ($cartNull == 0){?>
        <div id = "nullCartFrame">
            <img id = "nullCartImage" class = "center" src = "nullcart.jpg" alt = "nullcart">
            <p style = "text-align: center">Không có sản phẩm nào trong giỏ hàng</p>
        </div>

    <?php 
    }else{
    ?>
    <form action = "" method = "POST">
    <div class = "cartFrameHeader">
        <div style = "width: 10%;" class = "productImage">Hình ảnh</div>
        <div style = "width: 40%;" class = "productName">Tên sản phẩm</div>
        <div style = "width: 20%;" class = "productPrice">Giá</div>
        <div style = "width: 20%;" class = "numberProduct">Số lượng</div>
        <div style = "width: 10%;" class = "deleteButton">Thao tác</div>
    </div>
    <?php
        while ($row = mysqli_fetch_assoc($res)){
            $res1 = mysqli_query($conn, "SELECT * from SanPham where productId = '$row[cProductId]'");
            $row1 = mysqli_fetch_assoc($res1);
    ?>

        <div class = "cartFrame">
            <div class = "productImage" style = "width: 10%;">
                <img style = "height: 80px; width: 80px; text-align: center;" src = "<?php echo $row1['imageUrl']?>" alt = "product image" />
            </div>
            <div class = "productName" style = "width: 40%;text-align: center;"><?php echo $row1['name']?></div>

            <div class = "productPrice" style = "width: 20%; text-align: center;">$<?php echo $row1['price']?></div>

            <div class = "numberProduct btn-group me-2" role="group" style = "width: 20%; text-align: center;">
                <button type = "button" class = "indeButton btn btn-secondary" onclick = "decreaseNumberProduct(<?php echo $row1['productId']?>)">-</button>
                <input type = "number" value = "1" min = "1" id = "<?php echo $row1['productId']?>" disabled>
                <button type = "button" id  = "increase" class = "indeButton btn btn-secondary" onclick = "increaseNumberProduct(<?php echo $row1['productId']?>)">+</button>
            </div> 
            <div class = "deleteButton" style = "width: 10%;text-align: center;">
                    <input type = "text" name = "productId" value = "<?php echo $row1['productId']?>" hidden>
                    <button type = "submit" name = "deleteButton">Xóa</button>
            </div>
        </div>
    <?php
        }
        }
    ?>
    </form>
    <div id = "orderButtonFrame">
        <button class="btn btn-warning" type = "button" name = "orderButton1" id = "orderButton1" onclick = 'handleOrder()'>Đặt hàng</button>
    </div>

    <div id = "purchaseFrame">

    </div>
    </div>
    <div class = "pageFooter">
        <div class="container-fluid bg-black">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="ft-dm" style="color: gray">Liên Hệ</div>
                    <div class="ft-address">
                        <span style="font-size: 20px">
                            <strong style="color: gray">TIME ELITE</strong>
                        </span>
                        <br>
                        <span style="font-size: 14px">
                            <span style="color: #696969">Địa chỉ:</span>
                            <span style="color: #FF8C00">Showroom: 268 Lý Thường Kiệt, Q.10, Thành phố Hồ Chí Minh</span>
                        </span>
                        <br>
                        <span style="font-size: 14px">
                            <span style="color: #696969">Email:</span>
                            <span style="color: #FF8C00">TimeElite@gmail.com</span>
                            <br>
                            <span style="color: #696969">Hotline tư vấn bán hàng:</span>
                            <span style="color: #FF8C00">0948315737</span>
                            <br>
                            <span style="color: #696969">Facebook:</span>
                            <span style="color: #FF8C00">www.facebook.com/TimeElite.vn</span>
                            <br>
                            <span style="color: #696969">Instagram:</span>
                            <span style="color: #FF8C00">@TimeElite</span>
                            <br>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <span style="font-size: 18px">
                        <strong style="color: gray">DÀNH CHO NGƯỜI DÙNG</strong>
                    </span>
                    <br>
                    <span style="color: #FF8C00">Chính sách thanh toán</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách vận chuyển</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách đổi trả</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách bảo hành sản phẩm</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách kiểm hàng</span>
                    <br>
                    <span style="color: #FF8C00">Chính sách bảo mật thông tin</span>
                    <br>
                </div>
            </div>
        </div>
        <div class="footer_info">
            <div class="row">
                <div class="col-sm-4">
                    <img src="images/thanhtoan.jpg" alt="TimeElite">
                </div>
                <div class="col-sm-4">
                    <img src="images/connect.jpg" alt="TimeElite" width="300" height="150">
                </div>
                <div class="col-sm-4">
                    <img src="images/dangky.jpg" alt="TimeElite">
                </div>
            </div>
        </div>
    </div>
<?php mysqli_close($conn)?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script>
    function decreaseNumberProduct(id){
        var numberProduct = document.getElementById(id);
        if(numberProduct.value > 1){
            numberProduct.value--;
        }
    } 

    function increaseNumberProduct(id){
        var numberProduct = document.getElementById(id);
        numberProduct.value++;
    }

    function handleOrder(){
        var purchaseFrame = document.getElementById("purchaseFrame");
        purchaseFrame.innerHTML = "";
        var cartFrame = document.getElementsByClassName("cartFrame");
        var total = 0;
        for (var i = 0; i < cartFrame.length; i++){
            var productPrice = cartFrame[i].getElementsByClassName("productPrice")[0].innerHTML;
            var numberProduct = cartFrame[i].getElementsByClassName("numberProduct")[0].getElementsByTagName("input")[0].value;
            cartFrame[i].getElementsByClassName("indeButton")[0].disabled = true;
            cartFrame[i].getElementsByClassName("indeButton")[1].disabled = true;
            var productTotal = parseInt(productPrice.substring(1)) * parseInt(numberProduct);
            total += productTotal;
        }
        // display none order button 1
        document.getElementById( "orderButton1" ).style.display = "none";
        purchaseFrame.innerHTML += "<div class = 'totalPrice' id = 'displayTotalPrice'>Tổng thanh toán: $" + total + "</div>";
    }
</script>
</body>
</html>