<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
session_start();

include "menu.html";
include "connexion.php";
include "fonctions-panier.php";

$db = mysqli_connect($host,$login,"",$base);

$nom = $_POST["nom"];		
$prenom = $_POST["prenom"];			
$email = $_POST["email"]; 	
$password = $_POST["password"]; 	
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;

creationPanier() ;

echo "<p>Le panier et la session ont ete crees</p>";

$db = mysqli_connect($host,$login,"",$base);

$result = mysqli_query($db,"SELECT count(id) FROM utilisateur 
							WHERE nom='$nom' and prenom='$prenom' and email='$email'");
$ligne = mysqli_fetch_row($result) ;
if ($ligne[0]==0)
{
echo "<p>Vous etes un nouveau client ; on vous insere dans la base de donnees</p>";
mysqli_query($db,"INSERT INTO utilisateur (role, nom, prenom, email, motdepasse)
				   values('client', '$nom','$prenom','$email', '$password')");
}
else
{
$result = mysqli_query($db,"SELECT motdepasse FROM utilisateur 
							WHERE nom='$nom' and prenom='$prenom' and email='$email'");
$ligne = mysqli_fetch_row($result) ;
if ($ligne[0]==$password)
{
	echo "bon mot de passe";
}
else 
{
	header('Location: index.html');
    exit();
} 
}

$result = mysqli_query($db,"SELECT role , id FROM utilisateur WHERE nom='$nom' and prenom='$prenom' and email='$email'");
$ligne = mysqli_fetch_row($result) ;
if ($ligne[0]=='admin')
{
	header('Location: initadmin.php');
    exit();
}

?>

</body>
</html>