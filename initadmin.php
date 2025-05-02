<script type="text/javascript">
function toggle(anId){
node = document.getElementById(anId);
if (node.style.visibility=="hidden") 
{node.style.visibility = "visible"; node.style.height = "auto";} 
else 
{node.style.visibility = "hidden"; node.style.height = "0";}}
</script>

<html>
<body>

<center>
<div style="background-color: #f0f0f0; height : 10%; vertical-align : middle;" >
<a href="retrouveprofil.php">Voir mon profil</a>&nbsp;&nbsp;
<a href="produits.php">Poursuivre mes achats</a>&nbsp;&nbsp;
<a href="deconnect.php">Se deconnecter</a>
</div>

<?php
session_start();
include "connexion.php";
include "fonctions-panier.php";		

echo "<p>Vous etes ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
?>

<br><table border=0>
<tr>
<td bgcolor="#bbbbbb">
<div><b><a  onclick = "toggle('modifproduits')"><b>Modifier les produits</b></a></b></div>
</td>
<td>
<div id="modifproduits" style="visibility:hidden;height:0">
MODIFIER UN PRODUIT ?
</div>
</td>
</tr>




<tr>
<td bgcolor="#bbbbbb">
<div><b><a  onclick = "toggle('modifclients')"><b>Modifier les clients</b></a></b></div>
</td>
<td>
<div id="modifclients" style="visibility:hidden;height:0">
MODIFIER UN CLIENT ?
</div>
</td>
</tr>




<tr>
<td bgcolor="#bbbbbb">
<div><b><a  onclick = "toggle('modifadmins')"><b>Modifier les Administrateurs</b></a></b></div>
</td>
<td>
<div id="modifadmins" style="visibility:hidden;height:0">
MODIFIER UN ADMIN ?
</div>
</td>
</tr>




<tr>
<td bgcolor="#bbbbbb">
<div><b><a  onclick = "toggle('voircommandes')"><b>Voir les commandes</b></a></b></div>
</td>
<td>
<div id="voircommandes" style="visibility:hidden;height:0">
<?php #Affiche les Commandes 
	include "connexion.php";
	$db = mysqli_connect($host,$login,"",$base); 		#se connecte à la base de données
	$result = mysqli_query($db, "SELECT COUNT(*) FROM commande"); 		#requete pour compter le nombre de commandes
	$ligne = mysqli_fetch_row($result);
	$nbCommandes = $ligne[0];
	$result = mysqli_query($db, "SELECT * FROM `commande`"); 

	if ($nbCommandes > 0)
	{
		echo "<table border='1'> <tr><td>Numéro de Commande</td><td>Client</td><td>Date</td></tr>";
	while ($ligne = mysqli_fetch_array($result))
		{
			echo "<tr><td>".$ligne["id"]."</td><td>".$ligne["idclient"]."</td><td>".$ligne["date"]."</td></tr><br>";
		} 
		echo "</table>";
	}
			else 
		{
			echo "<p>Il n'y a pas de commandes pour l'instant</p>";
		}
?>
</div>
</td>
</tr>
</table>



</center> 
</body>
</html>