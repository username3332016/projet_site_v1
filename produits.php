<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <?php
    session_start();
    include "menu.html"; 
    include "fonctions-panier.php";
    include "connexion.php";

    // Connexion à la base de données
    $db = mysqli_connect($host,$login,"",$base);
    $result = mysqli_query($db,"SELECT * FROM papeterie");

    echo "<div class='container'>";
    echo "<h2>Nos Produits</h2>";
    echo "<table class='produits-table'>";
    echo "<tr><th>Numéro d'identification</th><th>Désignation</th><th>Image</th><th>Prix</th><th>Commander</th></tr>";

    // Affichage des produits
    while ($ligne = mysqli_fetch_row($result)) {
        echo "<tr>
                <td>".$ligne[0]."</td>
                <td>".$ligne[1]."</td>
                <td><img src='".$ligne[2]."' alt='".$ligne[1]."' class='product-image'></td>
                <td>".$ligne[3]."€</td>
                <td>
                    <form method='GET' action='commande.php'>
                        <input type='hidden' name='article' value='$ligne[0]'>
                        <label>Quantité :</label>
                        <input type='number' name='quantite' value='1' min='1' max='10'>
                        <button type='submit' class='btn-commander'>Commander</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";

    echo "<br /><p>Vous êtes ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
    afficherpanier();
    echo "</div>";

    ?>

</body>
</html>