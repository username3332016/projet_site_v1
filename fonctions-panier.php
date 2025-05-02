<?php
function creationPanier(){ 
	$_SESSION['panier']=array(); 
	$_SESSION['panier']['id'] = array(); 
	$_SESSION['panier']['designation'] = array(); 
	$_SESSION['panier']['quantite'] = array(); 
	$_SESSION['panier']['prix'] = array(); 	
	}

function ajouterArticle($id, $libelle,$qte,$prix){ 
	$position = array_search($id, $_SESSION['panier']['id']); 
	if ($position !== false) { 
		$_SESSION['panier']['quantite'][$position] += $qte ; 
		} 
	else { 
  		array_push($_SESSION['panier']['id'],$id); 
		array_push($_SESSION['panier']['designation'],$libelle); 
		array_push($_SESSION['panier']['quantite'],$qte);
 		array_push($_SESSION['panier']['prix'],$prix); 
		} 
	} 
	
function afficherpanier()
{
	$nbArticles = count( $_SESSION['panier']['designation']); 
	if ($nbArticles > 0)
	{
	echo "<p>Votre panier contient les produits suivants :</p>";
		echo "<table border='1'> <tr><td>Identification</td>
		<td>Designation</td>
		<td>Quantite</td>
		<td>Prix Unitaire</td></tr>";
		for ($i=0 ; $i < $nbArticles ; $i++)
			{ 
				echo "<tr><td>";
				echo $_SESSION['panier']['id'][$i]."</td>"; 
				echo "<td>".$_SESSION['panier']['designation'][$i]."</td>";
				echo "<td>".$_SESSION['panier']['quantite'][$i]."</td>";
				echo "<td>".$_SESSION['panier']['prix'][$i]."</td>"; 
 				echo "</tr>";
			} 
			echo "</table>";
	}
			else 
		{
			echo "<p>Votre panier est actuellement vide</p>";
		}
}
?>