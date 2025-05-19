<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traitement du Questionnaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php
session_start();

// Inclure les fichiers nécessaires
include "menu.html";
include "connexion.php";
include "fonctions-panier.php";

// Connexion à la base de données
$db = mysqli_connect($host, $login, "", $base);

// Récupération des données du formulaire
$nom = $_POST["nom"];		
$prenom = $_POST["prenom"];			
$email = $_POST["email"];
$password = $_POST["password"];  
$poids = $_POST["poids"];		
$pas = $_POST["pas"];			
$eau = $_POST["eau"];
$sommeil = $_POST["sommeil"];		
$energie = $_POST["energie"];			
$calories_mangees = $_POST["calories_mangees"];		
$calories_brulees = $_POST["calories_brulees"];		

// Stocker les données dans la session
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['poids'] = $poids;
$_SESSION['pas'] = $pas;
$_SESSION['eau'] = $eau;
$_SESSION['sommeil'] = $sommeil;
$_SESSION['energie'] = $energie;
$_SESSION['calories_mangees'] = $calories_mangees;
$_SESSION['calories_brulees'] = $calories_brulees;

// Création du panier
creationPanier();

echo "<p>Le panier et la session ont été créés.</p>";

// Vérification si l'utilisateur existe déjà
$result = mysqli_query($db, "SELECT count(id) FROM utilisateur WHERE nom='$nom' and prenom='$prenom' and email='$email'");
$ligne = mysqli_fetch_row($result);
if ($ligne[0] == 0) {
    echo "<p>Vous êtes un nouveau client ; on vous insère dans la base de données.</p>";
    mysqli_query($db, "INSERT INTO utilisateur (role, nom, prenom, email, motdepasse) VALUES ('client', '$nom', '$prenom', '$email', '$password')");
} else {
    $result = mysqli_query($db, "SELECT motdepasse FROM utilisateur WHERE nom='$nom' and prenom='$prenom' and email='$email'");
    $ligne = mysqli_fetch_row($result);
    if ($ligne[0] == $password) {
        echo "Bon mot de passe.";
    } else {
        header('Location: index.html');
        exit();
    }
}

// Vérification du rôle de l'utilisateur
$result = mysqli_query($db, "SELECT role, id FROM utilisateur WHERE nom='$nom' and prenom='$prenom' and email='$email'");
$ligne = mysqli_fetch_row($result);
if ($ligne[0] == 'admin') {
    header('Location: initadmin.php');
    exit();
}
?>

</body>
</html>
