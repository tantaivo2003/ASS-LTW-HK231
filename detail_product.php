<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ltw_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Elite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .nav-item {
            padding-left: 15px;
            padding-right: 15px;
        }
    </style>
</head>

<body style="background-color:black;">
    <!-- Header -->
    <div class="container-fluid bg-black">
        <nav class="navbar navbar-expand-lg navbar-black bg-black">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="TimeElite" class="img-responsive" width="80" height="80">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#" style="color: #FF8C00">
                            <h4>HOME</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">
                            <h4>ABOUT</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">
                            <h4>SERVICES</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">
                            <h4>CONTACT</h4>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <form class="d-flex" style="padding-left: 50px; padding-right: 50px">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit"
                            style="background-color: #FF8C00; color: white">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">
                            <img src="images/cart.jpg" alt="" width="30" height="30">
                            <i class="bi bi-cart"></i>Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #FF8C00">Sign up</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <hr size="5px" color="#FF8C00">
    <!-- Boby -->
    <div class="container-fluid bg-black" style="width:1200px;">
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="list_product.php"
                        style="text-decoration:none; color:white;">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color:white;">
                    <?php
                    $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                    $result = $conn->query($sql);
                    echo $result->fetch_assoc()["name"];
                    ?>
                </li>
            </ol>
        </nav>
        <div class="container mt-5 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="images p-3">
                                    <div class="text-center p-4"> <img id="main-image" src='<?php
                                    $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                                    $result = $conn->query($sql);
                                    echo $result->fetch_assoc()["imageUrl"];
                                    ?>' width="365px" /> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="product p-4">
                                    <div class="mt-4 mb-3">
                                        <h5 class="text-uppercase">Đồng hồ
                                            <?php
                                            $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                                            $result = $conn->query($sql);
                                            echo $result->fetch_assoc()["name"];
                                            ?>
                                        </h5>
                                        <span class=" text-muted brand">Hãng sản xuất:
                                            <?php
                                            $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                                            $result = $conn->query($sql);
                                            echo $result->fetch_assoc()["productType"];
                                            ?>
                                        </span>

                                    </div>
                                    <p class="about" style="text-align:justify;">
                                        <?php
                                        $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                                        $result = $conn->query($sql);
                                        echo $result->fetch_assoc()["description"];
                                        ?>
                                    </p>
                                    <div class="price d-flex flex-row align-items-center">
                                        <span class="text-muted brand">Giá:
                                            <?php
                                            $sql = "SELECT * FROM `sanpham` WHERE productId = " . $_GET['id'] . ";";
                                            $result = $conn->query($sql);
                                            echo $result->fetch_assoc()["price"];
                                            ?>$ - Giá có thể thay đổi
                                        </span>
                                    </div>
                                    <div class="cart mt-4 align-items-center"> <button
                                            class="btn btn-danger text-uppercase mr-2 px-4">Thêm vào giỏ hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <hr size=" 5px" color="#FF8C00">
    <div class="container-fluid bg-black" style="padding-left:150px; padding-bottom:30px;">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="ft-dm" style="color: gray">LIÊN HỆ</div>
                <div class="ft-address">
                    <span style="font-size: 20px">
                        <strong style="color: gray">TIME ELITE</strong>
                    </span>
                    <br>
                    <span style="font-size: 14px">
                        <span style="color: #696969">Địa chỉ:</span>
                        <span style="color: #FF8C00">Showroom: 268 Lý Thường Kiệt, Q.10, Thành phố Hồ Chí
                            Minh</span>
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
    <div class="footer_info" style="padding-left:150px; background-color:#fdfefd;">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>