<html>
	<head><title>Liste des produits</title></head>
	<body>
		<?php
		session_start();
		
		include "menu.html";
		
		include "fonctions-panier.php";
		include "connexion.php";
		echo "<br>";
		$id = $_GET["article"];
		$quantite = $_GET['quantite'];
		$db = mysqli_connect($host,$login,"",$base);
		$result = mysqli_query($db,"SELECT * FROM papeterie where id=$id");
		echo "<table border=1>";
		echo "<tr align='center'><td>Numero d'identification</td>
		          <td>Designation de l'article</td>
				  <td>Image</td>
				  <td>Prix de l'article en euros</td></tr>";
		$ligne = mysqli_fetch_row($result);
		echo "<tr align='center'><td>"
		.$ligne[0]."</td><td>"
		.$ligne[1]."</td><td><img src='"
		.$ligne[2]."'></td><td>"
		.$ligne[3]."</td></tr>";
		echo "</table>";

		ajouterArticle($ligne[0],$ligne[1],$quantite,$ligne[3]);
		?>
		<?php
		echo "<p>Vous etes ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
		
		afficherpanier();

		?>

	<p><a href="fin.php">Terminer la commande</a></p>
	</body>
</html>
