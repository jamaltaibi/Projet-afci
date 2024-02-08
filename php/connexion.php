
<?php

if(isset($_GET["page"]) && $_GET["page"] == "connexion" ){
?>

<form method="POST" action="">
    <h2>Nouvel utilisateur</h2>
    <label for=""> utilisateur</label>
    <input type="text" name="newIdentifiant">
    <label for="">Mot de passe</label>
    <input type="text" name="newPasseword">
    <input type="submit" name="createuser">
</form>

<form method="POST" action="">
    <h2>Connexion Utilisateur</h2>
    <label for=""> utilisateur</label>
    <input type="text" name="identifiant">
    <label for="">Mot de passe</label>
    <input type="text" name="password">
    <input type="submit" name="connectuser">
</form>

<?php
}
if (isset($_POST['createuser'])){
    $newIdentifiant = $_POST ['newIdentifiant'];
    $newPasseword = password_hash($_POST['newPasseword'], PASSWORD_DEFAULT);

    $sqlcreate = "INSERT INTO `users`(`identifiant`, `passeword`) VALUES (?, ?)";
    $requeteCreate = $bdd->prepare($sqlcreate);
    $requeteCreate->bindParam(1, $newIdentifiant);
    $requeteCreate->bindParam(2, $newPasseword);
    $requeteCreate->execute();

    echo"utilisateur ajoutée a la base de données";
}

if (isset($_POST['connectuser'])){
    $identifiant = $_POST ['identifiant'];
    $password = $_POST ['password'];

    $sqlverif = "SELECT * FROM `users`WHERE `identifiant` = ?";
    $requeteVerif = $bdd->prepare($sqlverif);
    $requeteVerif->bindParam(1, $identifiant);
    $requeteVerif->execute();
    $resultsVerif = $requeteVerif->fetch(PDO::FETCH_ASSOC);
   

    if ($resultsVerif){
        if(password_verify($password, $resultsVerif['passeword'])){
            echo "Utilisateur connecté";
            echo "<br>";
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Utilisateur non trouvé dans la base de données";
    }


}
?>