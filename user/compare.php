<!DOCTYPE html>
<html lang="en">

<head>
    <title>computer Shop </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

   
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.html">
               computer
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="produits.php">Explore</a>
                        </li>
                      
                    </ul>
                </div>
               
            </div>

        </div>
    </nav>
    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


<?php
include '../computer/db.php';

// VALIDATION
if (empty($_POST['compare']) || empty($_POST['criteres'])) {
    echo "<p class='text-danger text-center mt-4'>Veuillez sélectionner des produits et des critères !</p>
          <div class='text-center mt-3'>
              <a href='produits.php' class='btn btn-primary'>⬅ Retour aux Produits</a>
          </div>";
    exit;
}

// Récupération des IDs
$ids = array_map('intval', $_POST['compare']);
$criteres_ids = array_map('intval', $_POST['criteres']);

$ids_str = implode(',', $ids);
$crit_str = implode(',', $criteres_ids);

// Récupération des produits
$produits_res = $conn->query("SELECT * FROM produits WHERE id IN ($ids_str)");
$produits = [];
while ($row = $produits_res->fetch_assoc()) {
    $produits[$row['id']] = $row;
}

// Récupération des critères
$crit_res = $conn->query("SELECT * FROM criteres WHERE id IN ($crit_str)");
$criteres = [];
while ($c = $crit_res->fetch_assoc()) {
    $col = strtolower(str_replace(' ', '_', $c['nom']));
    $criteres[] = [
        'nom' => $c['nom'],
        'col' => $col
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison Produits</title>
    <link rel="stylesheet" href="../computer/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../computer/assets/css/fontawesome.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .table th,
        .table td {
            vertical-align: middle !important;
        }
        .product-img {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }
        .table thead th {
            text-align: center;
        }
        .table tbody td {
            text-align: center;
        }
        .btn-back {
            margin-top: 20px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-warning {
            background-color: #fff3cd !important;
        }
    </style>
</head>

<body>
<div class="container py-5">

    <h2 class="mb-4 text-center">Comparaison de Produits</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <!-- HEADER -->
            <thead class="table-dark">
                <tr>
                    <th>Critère</th>
                    <?php foreach ($produits as $p) { ?>
                        <th>
                            <strong><?php echo htmlspecialchars($p['ModelName']); ?></strong><br>
                            <?php 
                            $imgPath = "../computer/uploads/".$p['image'];
                            if (!empty($p['image']) && file_exists($imgPath)) { ?>
                                <img src="<?php echo $imgPath; ?>" class="product-img">
                            <?php } else { ?>
                                <small>Aucune image</small>
                            <?php } ?>
                        </th>
                    <?php } ?>
                </tr>
            </thead>

            <!-- CRITERES -->
            <tbody>
            <?php foreach ($criteres as $c) { ?>
                <tr>
                    <td class="fw-bold"><?php echo htmlspecialchars($c['nom']); ?></td>
                    <?php foreach ($produits as $p) { ?>
                        <td>
                            <?php 
                            $value = $p[$c['col']] ?? '-';
                            echo htmlspecialchars($value);
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>

            <!-- PRIX -->
            <tr class="table-warning">
                <td class="fw-bold">Prix</td>
                <?php foreach ($produits as $p) { ?>
                    <td><?php echo htmlspecialchars($p['prix']); ?> DT</td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center btn-back">
        <a href="produits.php" class="btn btn-primary">⬅ Retour aux Produits</a>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-light pt-5">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h2 class="text-success">Computer Shop</h2>
                <p>Email: info@company.com</p>
                <p>Phone: 010-020-0340</p>
            </div>

            <div class="col-md-4">
                <h2>Products</h2>
                <ul>
                    <li><a class="text-light" href="#">Laptops</a></li>
                    <li><a class="text-light" href="#">PC bureau</a></li>
                     <li><a class="text-light" href="#">PC Portable</a></li>
                      <li><a class="text-light" href="#">Mini PC </a></li>
                       <li><a class="text-light" href="#">PC Gamer</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h2>Info</h2>
                <ul>
                   <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="produits.php">Explore</a>
                        </li>
                      
                    </ul>
                </div>
                </ul>
            </div>

        </div>
    </div>

    <div class="text-center py-3 bg-black">
        <p>© 2026 Computer Shop</p>
    </div>
</footer>

<!-- SCRIPTS -->
<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
