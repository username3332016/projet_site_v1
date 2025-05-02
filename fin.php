<html>
<head><title>Liste des produits</title></head>
<body>
<br /><hr><p>Contenu actuel du panier</p><hr>
		<?php
		session_start();
		include "menu.html";
		include "connexion.php";
		include "fonctions-panier.php";
		
		afficherpanier();
		

		echo "<p>Vous etes ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
				
		
		$db = mysqli_connect($host,$login,"",$base); 		#se connecte à la base de données
		
		date_default_timezone_set('UTC');
		$today=date("d.m.y");			#definit la date dans $today
		
		$email=$_SESSION['email'];
		$result = mysqli_query($db, "SELECT id FROM utilisateur WHERE email = '$email'"); 		#requete pour trouver l'IdClient
		$ligne = mysqli_fetch_row($result);
		$idClient = $ligne[0];
		mysqli_query($db,"INSERT INTO commande(idclient,date) VALUES($idClient,'$today')"); #ajoute une nouvelle ligne dans la table commande
		

		$idCommande  = mysqli_insert_id($db); #recupere l'ID auto-incrémenté généré par la dernière requête INSERT
		if ($nbArticles > 0) {
		for ($i = 0; $i < $nbArticles; $i++) {
			$idPapeterie = $_SESSION['panier']['id'][$i];
			$quantite = $_SESSION['panier']['quantite'][$i];
			
			# Insérer chaque article dans la table detailcommande
			$query = "INSERT INTO detailcommande(idcommande, idpapeterie, quantite) 
					  VALUES('$idCommande', '$idPapeterie', '$quantite')";
			mysqli_query($db, $query);
		}
		} 
		
/* 		code avant de créer la fonction afficherpanier
		if ($nbArticles > 0) 
		{
		for ($i = 0; $i < $nbArticles; $i++) 
		{
			$idPapeterie = $_SESSION['panier']['id'][$i];
			$quantite = $_SESSION['panier']['quantite'][$i];
			
			mysqli_query($db, "INSERT INTO detailcommande(idcommande, idpapeterie, quantite) VALUES($idCommande, $idPapeterie, $quantite)");			# ajoute les idPapeterie, idCommande et le nbArticles dans la table detailcommande
		}
		} 
		else 
		{
		echo "Le panier est vide, aucune commande n'a été enregistrée.";
		} */
		
		
		
		$_SESSION = array();
		session_destroy();
		?>
<p>Fin de connexion.</p>
</body>
</html>
