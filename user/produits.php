<?php include '../computer/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Computer Shop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700">

    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <style>
        .btn-compare {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            transition: 0.3s;
        }

        .btn-compare:hover {
            transform: translateY(-3px);
        }

        .filter-bar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .search-box {
            margin-bottom: 20px;
        }

        .card img {
            height: 220px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container">
        <a class="navbar-brand text-success h1" href="index.html">Computer</a>

        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="produits.php">Shop</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container py-5">

<form method="POST" action="">

<div class="row">

<!-- FILTER -->
<div class="col-lg-3">

<div class="filter-bar">

<h5>Recherche Produit</h5>

<div class="search-box">
<input type="text"
       name="search"
       class="form-control"
       placeholder="Tapez une lettre..."
       value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
</div>



<h5>Filtres</h5>

<?php
$crit = $conn->query("SELECT * FROM criteres");

while($c = $crit->fetch_assoc())
{
?>

<label>
<input type="checkbox"
       name="criteres[]"
       value="<?php echo $c['id']; ?>"

<?php
if(isset($_POST['criteres']) && in_array($c['id'], $_POST['criteres']))
{
    echo "checked";
}
?>

>
<?php echo $c['nom']; ?>
</label>

<br>

<?php } ?>

<br>

<button type="submit" class="btn btn-success w-100">
Filtrer
</button>

</div>
</div>

<!-- PRODUCTS -->
<div class="col-lg-9">

<h2 class="mb-4">Liste Produits</h2>

<div class="row">

<?php

$query = "SELECT * FROM produits WHERE 1=1";

/* Search by first letter */
if(!empty($_POST['search']))
{
    $search = $conn->real_escape_string($_POST['search']);
    $query .= " AND ModelName LIKE '$search%'";
}

/* Filter by criteria */
if(!empty($_POST['criteres']))
{
    $ids = implode(',', array_map('intval', $_POST['criteres']));

    $query .= " AND id IN (
        SELECT produit_id
        FROM valeurs_critere
        WHERE critere_id IN ($ids)
    )";
}

$result = $conn->query($query);

if($result->num_rows > 0)
{
while($row = $result->fetch_assoc())
{
?>

<div class="col-md-4 mb-4">

<div class="card h-100">

<?php if(!empty($row['image'])) { ?>

<img src="../computer/uploads/<?php echo $row['image']; ?>">

<?php } else { ?>

<div class="bg-light text-center p-5">
<i class="fas fa-laptop fa-2x"></i>
</div>

<?php } ?>

<div class="card-body text-center">

<h5><?php echo $row['ModelName']; ?></h5>

<p><?php echo $row['Manufacturer']; ?></p>

<p class="text-success">
<?php echo $row['prix']; ?> DT
</p>

<a href="details.php?id=<?php echo $row['id']; ?>"
   class="btn btn-primary btn-sm mb-2">
Voir détails
</a>

<br>

<input type="checkbox"
       name="compare[]"
       value="<?php echo $row['id']; ?>">

Comparer

</div>
</div>
</div>

<?php
}
}
else
{
echo "<h4 class='text-danger'>Aucun produit trouvé</h4>";
}
?>

</div>

<div class="text-center mt-4">
<button type="submit"
        formaction="compare.php"
        class="btn-compare">
🛒 Comparer Maintenant
</button>
</div>

</div>
</div>

</form>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-light pt-5 mt-5">

<div class="container">
<div class="row">



<div class="col-md-4">
<h2>Products</h2>
<ul>
<li>Laptops</li>
<li>PC bureau</li>
<li>PC Portable</li>
<li>Mini PC</li>
<li>PC Gamer</li>
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


</footer>

<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>