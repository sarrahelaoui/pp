<?php include '../computer/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Computer Shop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <style>
        /* Bouton comparer ultra stylé */
        .btn-compare {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .btn-compare:hover {
            background: linear-gradient(135deg, #20c997, #28a745);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-compare:active {
            transform: translateY(1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Barre de filtres multicritères */
        .filter-bar {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .filter-bar h5 {
            margin-bottom: 10px;
        }

        .filter-bar label {
            margin-right: 15px;
            cursor: pointer;
        }

        .filter-bar input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>

<body>

<!-- TOP NAV -->
<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="text-light text-decoration-none">info@company.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="text-light text-decoration-none">010-020-0340</a>
            </div>
        </div>
    </div>
</nav>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-success h1" href="index.html">
            Computer
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="nav navbar-nav mx-auto">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produits.php">Shop</a>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container py-5">
    <form method="POST" action="compare.php">
        <div class="row">

            <!-- SIDEBAR FILTERS -->
            <div class="col-lg-3">
                <div class="filter-bar">
                    <h5>Filtres Multicritères</h5>
                    <?php
                    $crit = $conn->query("SELECT * FROM criteres");
                    while ($c = $crit->fetch_assoc()) {
                        echo "<label>";
                        echo "<input type='checkbox' name='criteres[]' value='".$c['id']."'> ".htmlspecialchars($c['nom']);
                        echo "</label><br>";
                    }
                    ?>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div class="col-lg-9">
                <h2>Liste Produits</h2>
                <div class="row">
                    <?php
                    // Vérifie si des critères ont été choisis
                    $query = "SELECT * FROM produits";
                    if (!empty($_POST['criteres'])) {
                        $ids = implode(',', array_map('intval', $_POST['criteres']));
                        $query .= " WHERE FIND_IN_SET(id_critere, '$ids')"; // suppose que produits.id_critere correspond à critere
                    }
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($row['image'])): ?>
                                    <img src="../computer/uploads/<?= htmlspecialchars($row['image']) ?>" 
                                         class="card-img-top" 
                                         style="height:220px; object-fit:cover;"
                                         alt="<?= htmlspecialchars($row['ModelName']) ?>">
                                <?php else: ?>
                                    <div style="height:220px;background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-laptop fa-2x"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="text-center mt-2">
                                    <a href="details.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-primary btn-sm">
                                       Voir détails
                                    </a>
                                </div>

                                <div class="card-body text-center">
                                    <h5><?= htmlspecialchars($row['ModelName']); ?></h5>
                                    <p><?= htmlspecialchars($row['Manufacturer']); ?></p>
                                    <p class="text-success"><?= $row['prix']; ?> DT</p>
                                    <input type="checkbox" name="compare[]" value="<?= $row['id']; ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Bouton Comparer -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn-compare">
                        🛒 Comparer Maintenant
                    </button>
                </div>
            </div>
        </div>
    </form>
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
                    <li><a class="text-light" href="#">Mini PC</a></li>
                    <li><a class="text-light" href="#">PC Gamer</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h2>Info</h2>
                <ul>
                    <li><a class="text-light" href="index.html">Home</a></li>
                    <li><a class="text-light" href="produits.php">Explore</a></li>
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