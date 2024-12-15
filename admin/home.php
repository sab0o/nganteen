<?php
session_start();

require '../control.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}

$categories = query("SELECT * FROM categories");
$products = query("SELECT y.*, x.image FROM product_galleries x INNER JOIN product y ON x.product_id = y.id GROUP BY x.product_id LIMIT 4");
//$products = query("SELECT y.*, x.image FROM product_galleries x INNER JOIN product y ON x.id = y.id GROUP BY x.id ORDER BY x.id LIMIT 4");
// var_dump($thumbnail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganteen</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-white navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Nganteen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="product.php" class="nav-link">Product</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Product</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($categories as $category) : ?>
                                <li><a class="dropdown-item" href="categories.php?id=<?= $category['id']; ?>"><?= $category['name']; ?></a></li>
                            <?php endforeach; ?>
                            <li>
                                <hr>
                            </li>
                            <li><a class="dropdown-item" href="categories.php">All Products</a></li>
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                   
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-capitalize" role="button" data-bs-toggle="dropdown"><?= $_SESSION['name']; ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="dashboard/dashboard.php" class="dropdown-item">Dashboard</a></li>
                            
                            <li><a href="../logout.php" class="dropdown-item">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid" style="padding: 0; ">
           
            <div class="row justify-content-center my-5">
                <div class="col-lg-12 col-md-10 text-center">
                    <h1>Best Product</h1>
                    <p>Ini adalah produk terbaik yang ada sajikan</p>
                </div>
            </div>
            <div class="row justify-content-center mx-3">
                <?php foreach ($products as $product) : ?>
                    <div class="col-lg-3 col-md-4">
                        <div class="card shadow h-100">
                            <img src="../assets/<?= $product['image']; ?>" class="card-img-top w-75 mx-auto" alt="product">
                            <div class="card-body text-center">
                                <h5 class="card-title px-4"><?= $product['name']; ?></h5>
                                <p class="card-text">Rp. <?= number_format($product['price'], 2, ',', '.'); ?></p>
                                <a href="detail.php?id=<?= $product['id']; ?>" class="btn btn-dark mb-3">Check Product</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>


    <footer class="mt-5">
        <hr>
        <div class="container text-center">
            <p class="text-muted">Copyright © 2024 | All Right Reserved.</p>
        </div>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>