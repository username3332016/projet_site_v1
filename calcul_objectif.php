<?php
session_start();

// Récupération des données du formulaire
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = $_POST['password'];
$age = $_POST['age'];
$poids = $_POST['poids'];
$taille = $_POST['taille'];
$activite = $_POST['activite'];

// Calcul de l'IMC
$tailleEnMetres = $taille / 100;
$imc = $poids / ($tailleEnMetres * $tailleEnMetres);

// Détermination de l'objectif
function determinerObjectif($imc, $activite, $age) {
    if ($imc < 18.5) {
        return "Prise de masse";
    } elseif ($imc >= 25) {
        return "Perte de poids";
    } else {
        if ($activite == 'sedentaire' || $activite == 'leger') {
            return "Remise en forme";
        } else {
            return "Performance";
        }
    }
}

$objectif = determinerObjectif($imc, $activite, $age);

// Stockage en session
$_SESSION['user_data'] = [
    'prenom' => $prenom,
    'nom' => $nom,
    'email' => $email,
    'age' => $age,
    'poids' => $poids,
    'taille' => $taille,
    'imc' => $imc,
    'objectif' => $objectif
];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats - FitLife</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .resultat-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .objectifs-container {
            margin: 30px 0;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .abonnements-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
        }

        .abonnement-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .abonnement-box:hover {
            transform: translateY(-5px);
        }

        .abonnement-box.premium {
            border: 2px solid #ff4d4d;
        }

        .prix {
            font-size: 2em;
            color: #ff4d4d;
            margin: 20px 0;
        }

        .avantages-list {
            text-align: left;
            margin: 20px 0;
        }

        .avantages-list li {
            margin: 10px 0;
            padding-left: 25px;
            position: relative;
        }

        .avantages-list li:before {
            content: "✓";
            color: #ff4d4d;
            position: absolute;
            left: 0;
        }

        .objectif-recommande {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ff4d4d;
        }

        .btn-abonnement {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
            transition: opacity 0.3s;
        }

        .btn-abonnement:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="resultat-container">
        <div class="objectifs-container">
            <h2>Votre Profil Personnalisé</h2>
            
            <div class="objectif-recommande">
                <h3>Objectif Principal Recommandé</h3>
                <p>En fonction de vos données (IMC: <?php echo round($imc, 1); ?>), nous vous recommandons :</p>
                <ul>
                    <?php if ($imc < 18.5): ?>
                        <li>Objectif Principal : <strong>Prise de Masse</strong></li>
                        <li>Objectifs Secondaires Recommandés : 
                            <ul>
                                <li>Renforcement Musculaire</li>
                                <li>Amélioration de la Force</li>
                            </ul>
                        </li>
                    <?php elseif ($imc >= 25): ?>
                        <li>Objectif Principal : <strong>Perte de Poids</strong></li>
                        <li>Objectifs Secondaires Recommandés : 
                            <ul>
                                <li>Endurance Cardiovasculaire</li>
                                <li>Tonification Musculaire</li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>Objectif Principal : <strong>Optimisation de la Condition Physique</strong></li>
                        <li>Objectifs Secondaires Recommandés : 
                            <ul>
                                <li>Renforcement Global</li>
                                <li>Amélioration de la Flexibilité</li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="abonnements-container">
            <!-- Abonnement Light -->
            <div class="abonnement-box">
                <h3>Abonnement Light</h3>
                <div class="prix">19.99€/mois</div>
                <ul class="avantages-list">
                    <li>Accès aux programmes d'entraînement de base</li>
                    <li>Suivi de progression</li>
                    <li>Recommandations nutritionnelles basiques</li>
                    <li>Accès à la communauté FitLife</li>
                </ul>
                <button class="btn-abonnement" onclick="window.location.href='inscription_light.php'">
                    Choisir Light
                </button>
            </div>

            <!-- Abonnement Plus -->
            <div class="abonnement-box premium">
                <h3>Abonnement Plus</h3>
                <div class="prix">39.99€/mois</div>
                <ul class="avantages-list">
                    <li>Tous les avantages de l'abonnement Light</li>
                    <li>Séances de coaching personnalisées</li>
                    <li>Plan nutritionnel personnalisé</li>
                    <li>Accès aux cours en direct</li>
                    <li>Suivi personnalisé hebdomadaire</li>
                    <li>Programmes spécialisés</li>
                </ul>
                <button class="btn-abonnement" onclick="window.location.href='inscription_plus.php'">
                    Choisir Plus
                </button>
            </div>
        </div>
    </div>
</body>
</html>