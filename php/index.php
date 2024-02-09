<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFCI - Gestion des Centres</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header >
        <nav>
            <ul>
                <a href="?page=role"> <li>Role</li> </a>
                <a href="?page=centre"> <li>Centre</li> </a>
                <a href="?page=formation"> <li>Formation</li> </a>
                <a href="?page=pedagogie"> <li>Pedagogie</li> </a>
                <a href="?page=session"> <li>Session</li> </a>
                <a href="?page=apprenants"> <li>Apprenants</li> </a>
                <a href="?page=affecter"> <li>Affecter</li> </a>
                <a href="?page=connexion"> <li>Connexion</li> </a>
            </ul>
        </nav>
    </header>
<?php
$host = "mysql"; // Nom du service du conteneur MySQL dans Docker
$port = "3306"; // Le port exposé par le conteneur MySQL dans Docker
$dbname = "afci"; // Remplacez par le nom de votre base de données
$user = "admin"; // Remplacez par votre nom d'utilisateur
$pass = "admin"; // Remplacez par votre mot de passe

    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // echo "Connexion réussie !";
    // // Lire des données dans la BDD
    // $sql = "SELECT * FROM apprenants";
    // $requete = $bdd->query($sql);
    // $results = $requete->fetchAll(PDO::FETCH_ASSOC);
    // foreach( $results as $value ){
    //     foreach($value as $data){
    //         echo $data;
    //         echo "<br>";
    //     }
    //     echo "<br>";
    // }
    // foreach( $results as $value ){
    //     echo "<h2>" . $value["nom_apprenant"] . "</h2>";
    //     echo "<br>";
    // }


    function getRows($bdd, $table) {
        $sql = "SELECT * FROM $table";
        $requete = $bdd->query($sql);
        $results = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

include ('role.php');
include ('centre.php');
include ('formation.php');
include ('equipePedago.php');
include ('Session.php');
include ('Apprenant.php');
include ('affecter.php');
include ('connexion.php');
     
?> 
</body>
</html>

