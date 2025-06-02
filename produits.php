
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
session_start();
include "connexion_bdd.php";
include "fonctions_panier.php";

$db = mysqli_connect($host, $login, "", $base);
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

$sql = "SELECT * FROM produit";
if (!empty($categorie)) {
    $sql .= " WHERE categorie = '" . mysqli_real_escape_string($db, $categorie) . "'";
}
$result = mysqli_query($db, $sql);
?>



<header>
    <div class="nav-left"><strong>FitLife</strong></div>
    <div class="nav-right">
        <a href="register.html">S'inscrire</a>
        <a href="login.html">Se connecter</a>
        <a href="produits.php"><i class="$fa-var-shopping-cart"></i></a>
    </div>
</header>

<div class="filter-bar">
    <form method="get">
        <label for="categorie">Catégorie :</label>
        <select name="categorie" onchange="this.form.submit()">
            <option value="">-- Toutes --</option>
            <option value="Produits de Sport" <?= $categorie == 'Produits de Sport' ? 'selected' : '' ?>>Produits de Sport</option>
            <option value="Boxes Culinaires Saines" <?= $categorie == 'Boxes Culinaires Saines' ? 'selected' : '' ?>>Boxes Culinaires</option>
            <option value="Gummies Compléments" <?= $categorie == 'Gummies Compléments' ? 'selected' : '' ?>>Gummies</option>
            <option value="Coaching Personnalisé" <?= $categorie == 'Coaching Personnalisé' ? 'selected' : '' ?>>Coaching</option>
        </select>
    </form>
</div>

<section class="products-section" id="produits">  
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        
        <a href="produit.php?id=<?= $row['id'] ?>">
        <div class="product-card" >
            <img src="<?= $row['image'] ?>" alt="<?= $row['nom'] ?>">
            <div class="info">
                <h3><?= $row['nom'] ?></h3>
                <p><?= $row['description'] ?></p>
                <div class="prix"><?= $row['prix'] ?> €</div>
            </div>
            <form method="post" action="ajouterArticle.php">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="quantite" value="1">
                <button type="submit" class="add-button"><i class="fa fa-cart-plus"></i> Ajouter au panier</button>
            </form>
        </div>
        </a>
    <?php } ?>
</section>



<footer>
    <p>&copy; 2025 FitLife. Coaching personnalisé & boutique sportive.</p>
    <p>Contact : contact@fitlife.fr</p>
</footer>

</body>
</html>
