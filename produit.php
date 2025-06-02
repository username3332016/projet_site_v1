<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Produit </title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>

<?php
include "connexion_bdd.php";


$db = mysqli_connect($host, $login, "", $base);
mysqli_set_charset($db, 'utf8');

if (!isset($_GET['id'])) {
    die("Produit introuvable.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM produit WHERE id = $id";
$result = mysqli_query($db, $query);
$produit = mysqli_fetch_assoc($result);

if (!$produit) {
    die("Ce produit n'existe pas.");
}
?>

    <!-- Menu  -->
    <header>
        <div class="nav-left"><strong>FitLife</strong></div>
        <div class="nav-right">
            <a href="register.html">S'inscrire</a>
            <a href="login.html">Se connecter</a>
            <a href="produits.php"><i class="$fa-var-shopping-cart"></i></a>
        </div>
    </header>

    <!-- Affichage produit dynamique  -->
<main class="page-produit">
    <div class="image-container">
        <img src="img/<?= $produit['image'] ?>" alt="<?= $produit['nom'] ?>">
    </div>
    <div class="details">
        <h1><?= $produit['nom'] ?></h1>
        <p class="description"><?= $produit['description'] ?></p>
        <p class="prix"><?= $produit['prix'] ?> €</p>
        <form method="post" action="ajouter-au-panier.php">
            <input type="hidden" name="id" value="<?= $produit['id'] ?>">
            <input type="hidden" name="quantite" value="1">
            <button type="submit" class="add-button">Ajouter au panier</button>
        </form>
    </div>
</main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 FitLife. Coaching personnalisé & boutique sportive.</p>
        <p>Contact : contact@fitlife.fr</p>
    </footer>

</body>
</html>