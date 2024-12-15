<?php 
    session_start();

    require '../control.php';

    if(!isset($_SESSION["login"])) {
        header("Location: ../index.php");
        exit;
    }

    // $id = $_GET['id'];

    $categories = query("SELECT * FROM categories");
$products = query("SELECT y.*, x.image FROM product_galleries x INNER JOIN product y ON x.product_id = y.id GROUP BY x.product_id ");

    // $galleries = query("SELECT DISTINCT id, image FROM product_galleries WHERE id = $id ORDER BY id DESC LIMIT 2");
    // $thumbnails = query("SELECT image FROM product_galleries WHERE id = $id LIMIT 1");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganteen</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
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
                        <a href="home.php" class="nav-link active">Home</a>
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

    <main class="py-4">
        <div class="container-fluid" style="padding: 0; ">
           
            <div class="row justify-content-center my-5">
                
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
    <!-- <main class="py-4" id="product">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 mb-3 mx-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach($thumbnails as $thumbnail) :?>
                                        <div class="carousel-item active">
                                            <img src="../assets/<?= $thumbnail['image']; ?>" alt="<?= $thumbnail['image']; ?>" class="d-block w-100">
                                        </div>
                                    <?php endforeach; ?>
                                    <?php foreach($galleries as $key => $gallery) : ?>
                                        <div class="carousel-item">
                                            <img src="../assets/<?= $gallery['image']; ?>" alt="<?= $gallery['image']; ?>" class="d-block w-100">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-4">
                    <?php foreach($products as $product): ?>
                        <h1><?= $product['name'] ?></h1>
                        <h3 class="text-danger">Rp. <?= number_format($product['price'], 2, ',', '.'); ?></h3>
                        <br>
                        <p><?= $product['description']; ?></p>
                        <div class="mt-5">
                            <form action="" method="POST">
                                <div class="row">
                                    <?php if($product['stock'] == 1) : ?>
                                        <p class="text-danger fs-6">Last item on stock!</p>
                                    <?php endif;  ?>
                                    <label for="qyt" class="col-sm-2 col-form-label">Quantity</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="qyt" id="qyt" value="1" class="form-control mb-3">
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="addCart" class="btn btn-dark">Add to Cart</button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main> -->
    <footer class="mt-5">
        <hr>
        <div class="container text-center">
            <p class="text-muted">Copyright © 2024 | All Right Reserved.</p>
        </div>
    </footer>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>