<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $db;

    $nom = mysqli_real_escape_string($db, $_POST['nom']);
    $prenom = mysqli_real_escape_string($db, $_POST['prenom']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash du mot de passe

    // Vérifier si l'email existe déjà
    $check = mysqli_query($db, "SELECT id FROM utilisateur WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:red;'>Erreur : Cet email est déjà utilisé.</p>";
    } else {
        // Insérer dans la base
        $query = "INSERT INTO utilisateur (nom, prenom, email, motdepasse, role) 
                  VALUES ('$nom', '$prenom', '$email', '$password', 'client')";

        if (mysqli_query($db, $query)) {
            echo "<p style='color:green;'>Le client a été ajouté avec succès.</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors de l'ajout : " . mysqli_error($db) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Client</title>
</head>
<body>
    <h2>Ajouter un Client</h2>
    <form method="post" action="">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" required><br>

        <label>Email :</label>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
