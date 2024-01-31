<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFCI - Gestion des Centres</title>
    <link rel="stylesheet" href="styles.css">
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
      

// Gestion Role :
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "role" ){
?>
    <h1 class="titre">Ajout d'un Role</h1>
    <form method="POST">
        <label> Role </label>
        <input type="text" name="nomRole">
        <input type="submit" name="submitRole" value="Enregistrer">
    </form>
<?php
if (isset($_POST['submitRole'])){
    $nomRole = $_POST['nomRole'];

    $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

 $sql = "SELECT * FROM role";
 $requete = $bdd->query($sql);
 $results = $requete->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des Roles :</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom Role</th><th>Modification</th></tr>";

foreach( $results as $value ){
    // var_dump($value);
    // echo $value["id_role"] . " - " . $value["nom_role"] . " " . "<br>"; 

    echo "<tr>";
        echo "<td>" . $value["id_role"] . "</td>";
        echo "<td>" . $value["nom_role"] . "</td>";
        echo "<td>
                  <a href='?page=role&action=modifier&id=" . $value["id_role"] . "'>Modifier</a> 
              </td>";
        echo "</tr>"; 
    } 
    echo "</table>";

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];
    
       if ($action == 'modifier') {
            
            $sql = "SELECT * FROM role WHERE id_role = $id";
            $requete = $bdd->query($sql);
            $role = $requete->fetch(PDO::FETCH_ASSOC);
    
            echo "<h1 class='titre'>Modification du rôle</h1>";
            echo "<form method='POST'>
                      <label> Nouveau Nom de Role </label>
                      <input type='text' name='nouveauNomRole' value='" . $role['nom_role'] . "'>
                      <input type='submit' name='modifierRole' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierRole'])) {
                $nouveauNomRole = $_POST['nouveauNomRole'];
                $sql = "UPDATE role SET nom_role = '$nouveauNomRole' WHERE id_role = $id";
                $bdd->query($sql);
                echo "Le rôle a été modifié dans la base de données.";
            }
        }
    }      
}


// Gestion Centre 
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "centre"){
?>
    <h1 class="titre">Ajout d'un Centre</h1>
    <form method="POST">
        <label> Ville du Centre </label>
        <input type="text" name="villeCentre">
        <label>Adresse</label>
        <input type="text" name="adresseCentre">
        <label>Code Postale </label>
        <input type="text" name="cpCentre">
        <input type="submit" name="submitCentre" value="Enregistrer">
    </form>

<?php

if (isset($_POST['submitCentre'])){
    $villeCentre = $_POST['villeCentre'];
    $adresseCentre = $_POST['adresseCentre'];
    $cpCentre = $_POST['cpCentre'];

    $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

   $sql = "SELECT * FROM centres";
   $requete = $bdd->query($sql);
   $results = $requete->fetchAll(PDO::FETCH_ASSOC);

   echo "<h2>Liste des centres :</h2>";
   echo "<table border='1'>";
   echo "<tr><th>ID</th><th>Ville</th><th>Adresse</th><th>Code Postal</th><th>Modification</th><th>Suppression</th></tr>";
  
  foreach( $results as $value ){
    // var_dump($value);
    // echo $value["id_centre"] . " - " . $value["ville_centre"] . " - " . $value["adresse_centre"] . " - " . $value["code_postal_centre"]."<br>";

        echo "<tr>";
        echo "<td>" . $value["id_centre"] . "</td>";
        echo "<td>" . $value["ville_centre"] . "</td>";
        echo "<td>" . $value["adresse_centre"] . "</td>";
        echo "<td>" . $value["code_postal_centre"] . "</td>";
        echo "<td>  <a href='?page=centre&action=modifier&id=" . $value["id_centre"] . "'>Modifier</a> </td>";
        echo "<td>  <a href='?page=centre&action=supprimer&id=" . $value["id_centre"] . "'>Supprimer</a> </td>";
        echo "</tr>"; 
  }
        echo "</table>";

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $action2 = $_GET['action'];
            $id2 = $_GET['id'];
        
            if ($action2 == 'supprimer') {
                $sql = "DELETE FROM `centres` WHERE `id_centre` = $id2";
                $bdd->query($sql);
                echo "Le Centre a été supprimé de la base de données.";
            } elseif ($action2 == 'modifier') {
        
                $sql = "SELECT `id_centre`, `ville_centre`, `adresse_centre`, `code_postal_centre` FROM `centres` WHERE `id_centre` = $id2";
                $requete = $bdd->query($sql);
                $role = $requete->fetch(PDO::FETCH_ASSOC);
        
                echo "<h1 class='titre'>Modification du Centre</h1>";
                echo "<form method='POST'>
                          <label> Nouvel ID du Centre </label>
                          <input type='text' name='nouvelIDcentre' value='" . $role['id_centre'] . "'>
                          <label> Nouvel Ville du Centre </label>
                          <input type='text' name='nouvelVilleCentre' value='" . $role['ville_centre'] . "'>
                          <label> Nouvel Adresse du Centre </label>
                          <input type='text' name='nouvelAdresseCentre' value='" . $role['adresse_centre'] . "'>
                          <label> Nouveau Code Postale </label>
                          <input type='text' name='nouveauCentreCp' value='" . $role['code_postal_centre'] . "'>
                          <input type='submit' name='modifierCentre' value='Modifier'>
                      </form>";
        
                if (isset($_POST['modifierCentre'])) {
                    $nouvelIDcentre = $_POST['nouvelIDcentre'];
                    $nouvelVilleCentre = $_POST['nouvelVilleCentre'];
                    $nouvelAdresseCentre = $_POST['nouvelAdresseCentre'];
                    $nouveauCentreCp = $_POST['nouveauCentreCp'];

                    $sql = "UPDATE `centres` SET `id_centre`='$nouvelIDcentre ',`ville_centre`='$nouvelVilleCentre',`adresse_centre`='$nouvelAdresseCentre',`code_postal_centre`='$nouveauCentreCp' WHERE `id_centre` = $id2 ";
                    $bdd->query($sql);
                    echo "Le Centre a été modifié dans la base de données.";
                }
            }
        } 
}


// Gestion Formation :
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "formation" ){
?>
  <h1 class="titre">Ajout d'un Formation</h1>
    <form method="POST">
        <label> Nom Formation </label>
        <input type="text" name="nomFormation">
        <label>Durée</label>
        <input type="text" name="dureeFormation">
        <label>Niveau de sortie </label>
        <input type="text" name="niveauformation">
        <label>Description </label>
        <input type="text" name="descriptionFormation">
        <input type="submit" name="submitFormation" value="Enregistrer">
    </form>
<?php

if (isset($_POST['submitFormation'])){
    $nomFormation = $_POST['nomFormation'];
    $dureeFormation = $_POST['dureeFormation'];
    $niveauformation = $_POST['niveauformation'];
    $descriptionFormation = $_POST['descriptionFormation'];

    $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation ','$dureeFormation ',' $niveauformation','$descriptionFormation ')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

 $sql = "SELECT * FROM formations";
 $requete = $bdd->query($sql);
 $results = $requete->fetchAll(PDO::FETCH_ASSOC);

 echo "<h2>Liste des Formations :</h2>";
 echo "<table border='1'>";
 echo "<tr><th>ID</th><th>Nom Formation</th><th>Durée Formation </th> <th>Niveau de Sortie</th> <th>Description</th><th>Modification</th><th>Suppression</th> </tr>";


foreach( $results as $value ){
//    var_dump($value);
    // echo $value["id_formation"] . " - " . $value["nom_formation"] . " - " . $value["duree_formation"] . " - " . $value["niveau_sortie_formation"]. "<br>" . $value["description"]."<br>"; 

    echo "<tr>";
        echo "<td>" . $value["id_formation"] . "</td>";
        echo "<td>" . $value["nom_formation"] . "</td>";
        echo "<td>" . $value["duree_formation"] . "</td>";
        echo "<td>" . $value["niveau_sortie_formation"] . "</td>";
        echo "<td>" . $value["description"] . "</td>";
        echo "<td>  <a href='?page=formation&action=modifier&id=" . $value["id_formation"] . "'>Modifier</a> </td>";
        echo "<td>  <a href='?page=formation&action=supprimer&id=" . $value["id_formation"] . "'>Supprimer</a> </td>";
        echo "</tr>"; 
}
        echo "</table>";

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $action3 = $_GET['action'];
            $id3 = $_GET['id'];
        
            if ($action3 == 'supprimer') {
                $sql = "DELETE FROM `formations` WHERE `id_formation` = $id3";
                $bdd->query($sql);
                echo "La formation a été supprimé de la base de données.";
            } elseif ($action3 == 'modifier') {
                
                $sql = "SELECT `id_formation`, `nom_formation`, `duree_formation`, `niveau_sortie_formation`,`description` FROM `formations` WHERE `id_formation` = $id3";
                $requete = $bdd->query($sql);
                $role = $requete->fetch(PDO::FETCH_ASSOC);
        
                echo "<h1 class='titre'>Modification de la Formation</h1>";
                echo "<form method='POST'>
                          <label> Nouvel ID de Formation </label>
                          <input type='text' name='nouvelIDformation' value='" . $role['id_formation'] . "'>
                          <label> Nouveau Nom de la formation </label>
                          <input type='text' name='nouveauNomformation' value='" . $role['nom_formation'] . "'>
                          <label> Nouvel Durée de la formation </label>
                          <input type='text' name='nouvelDureeformation' value='" . $role['duree_formation'] . "'>
                          <label> Nouveau Niveau de sortie </label>
                          <input type='text' name='nouveauNiveauformation' value='" . $role['niveau_sortie_formation'] . "'>
                          <label> Nouvel Description </label>
                          <input type='text' name='nouveldescriptionformation' value='" . $role['description'] . "'>
                          <input type='submit' name='modifierFormation' value='Modifier'>
                      </form>";
        
                if (isset($_POST['modifierFormation'])) {
                    $nouvelIDformation = $_POST['nouvelIDformation'];
                    $nouveauNomformation = $_POST['nouveauNomformation'];
                    $nouvelDureeformation = $_POST['nouvelDureeformation'];
                    $nouveauNiveauformation = $_POST['nouveauNiveauformation'];
                    $nouveldescriptionformation = $_POST['nouveldescriptionformation'];

                    $sql = "UPDATE `formations` SET `id_formation`='$nouvelIDformation',`nom_formation`='$nouveauNomformation',`duree_formation`='$nouvelDureeformation',`niveau_sortie_formation`='$nouveauNiveauformation',`description`='$nouveldescriptionformation' WHERE `id_formation` = $id3";
                    $bdd->query($sql);
                    echo "La Formation a été modifié dans la base de données.";
                }
            }
        }
}


// Gestion Equipe Pédagogique :
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "pedagogie" ){

    $sql = "SELECT * FROM role";
    $requete = $bdd->query($sql);
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

?>
    <h1 class="titre">Ajout d'un membre de l'equipe pédagogique</h1>
    <form method="POST">
        <label> Nom </label>
        <input type="text" name="nomMembrepedago">
        <label>Prenom</label>
        <input type="text" name="prenomMembrepedago">
        <label> Mail </label>
        <input type="text" name="mailMembrepedago">
        <label>Numéro Pédagogique </label>
        <input type="text" name="numMembrepedago">
        <label>Role</label>
        <select name="rolepedago" id="">
            <?php      
                foreach( $results as $value ){             
                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                }
                ?>
        </select>
        <input type="submit" name="submitPedagogie" value="Enregistrer">
    </form>
<?php

if (isset($_POST['submitPedagogie'])){
    $nomMembrepedago = $_POST['nomMembrepedago'];
    $prenomMembrepedago = $_POST['prenomMembrepedago'];
    $mailMembrepedago = $_POST['mailMembrepedago'];
    $numMembrepedago = $_POST['numMembrepedago'];
    $rolepedago = $_POST['rolepedago'];

    $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`,`id_role`) VALUES ('$nomMembrepedago','$prenomMembrepedago','$mailMembrepedago','$numMembrepedago','$rolepedago')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

 $sql = "SELECT `pedagogie`.`id_pedagogie`,`pedagogie`.`nom_pedagogie`, `pedagogie`.`prenom_pedagogie`, `pedagogie`.`mail_pedagogie`,`pedagogie`.`num_pedagogie`, `role`.`id_role`,`role`.`nom_role` FROM `pedagogie` INNER JOIN  `role` on `pedagogie`.`id_role` = `role`.`id_role`";
 $requete = $bdd->query($sql);
 $results = $requete->fetchAll(PDO::FETCH_ASSOC);

 echo "<h2>Equipe Pédagogique :</h2>";
 echo "<table border='1'>";
 echo "<tr> <th>ID</th> <th>Nom</th> <th>Prénom</th> <th>Mail</th> <th>Numéro Pédagogique</th> <th>ID Role</th><th>Nom Role</th><th>Modification</th><th>Suppression</th> </tr>";
 

foreach( $results as $value ){
//    echo $value["id_pedagogie"] . " - " . $value["nom_pedagogie"] . " - " . $value["prenom_pedagogie"] . " - " . $value["mail_pedagogie"]. " - " . $value["num_pedagogie"]. "-" . $value["id_role"]."<br>"; 

    echo "<tr>";
    echo "<td>" . $value["id_pedagogie"] . "</td>";
    echo "<td>" . $value["nom_pedagogie"] . "</td>";
    echo "<td>" . $value["prenom_pedagogie"] . "</td>";
    echo "<td>" . $value["mail_pedagogie"] . "</td>";
    echo "<td>" . $value["num_pedagogie"] . "</td>";
    echo "<td>" . $value["id_role"] . "</td>";
    echo "<td>" . $value["nom_role"] . "</td>";
    echo "<td>  <a href='?page=pedagogie&action=modifier&id=" . $value["id_pedagogie"] . "'>Modifier</a> </td>";
    echo "<td>  <a href='?page=pedagogie&action=supprimer&id=" . $value["id_pedagogie"] . "'>Supprimer</a> </td>";
    echo "</tr>"; 
    }
    echo "</table>";

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action4 = $_GET['action'];
        $id4 = $_GET['id'];
    
        if ($action4 == 'supprimer') {
            $sql = "DELETE FROM `centres` WHERE `id_centre` = $id4";
            $bdd->query($sql);
            echo "Un Membre de l'Equipe Pédagogique a été supprimé de la base de données.";
        } elseif ($action4 == 'modifier') {
            // Récupérer les détails du rôle à modifier
            $sql = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role` FROM `pedagogie` WHERE `id_centre` = $id4;"
            $requete = $bdd->query($sql);
            $role = $requete->fetch(PDO::FETCH_ASSOC);
    
            // Afficher un formulaire de modification pré-rempli
            echo "<h1 class='titre'>Modification du Centre</h1>";
            echo "<form method='POST'>
                      <label> Nouvel ID du Centre </label>
                      <input type='text' name='nouvelIDcentre' value='" . $role['id_centre'] . "'>
                      <label> Nouvel Ville du Centre </label>
                      <input type='text' name='nouvelVilleCentre' value='" . $role['ville_centre'] . "'>
                      <label> Nouvel Adresse du Centre </label>
                      <input type='text' name='nouvelAdresseCentre' value='" . $role['adresse_centre'] . "'>
                      <label> Nouveau Code Postale </label>
                      <input type='text' name='nouveauCentreCp' value='" . $role['code_postal_centre'] . "'>
                      <input type='submit' name='modifierCentre' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierCentre'])) {
                $nouvelIDcentre = $_POST['nouvelIDcentre'];
                $nouvelVilleCentre = $_POST['nouvelVilleCentre'];
                $nouvelAdresseCentre = $_POST['nouvelAdresseCentre'];
                $nouveauCentreCp = $_POST['nouveauCentreCp'];

                $sql = "UPDATE `centres` SET `id_centre`='$nouvelIDcentre ',`ville_centre`='$nouvelVilleCentre',`adresse_centre`='$nouvelAdresseCentre',`code_postal_centre`='$nouveauCentreCp' WHERE `id_centre` = $id2 ";
                $bdd->query($sql);
                echo "Un Membre de l'Equipe Pédagogique a été modifié dans la base de données.";
            }
        }
    } 
}


// Gestion Session :
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "session" ){

    $sqlp = "SELECT * FROM pedagogie";
    $requetep = $bdd->query($sqlp);
    $resultsp = $requetep->fetchAll(PDO::FETCH_ASSOC);

    $sqlf = "SELECT * FROM formations";
    $requetef = $bdd->query($sqlf);
    $resultsf = $requetef->fetchAll(PDO::FETCH_ASSOC);

    $sqlc = "SELECT * FROM centres";
   $requetec = $bdd->query($sqlc);
   $resultsc = $requetec->fetchAll(PDO::FETCH_ASSOC);

?>
    <h1 class="titre">Ajout d'une Session</h1>
    <form method="POST">
        <Label>Nom de Session </Label>
        <input type="text" name="nomSession">
        <Label>Date de Debut Formation </Label>
        <input type="date" name="dateSession">
        <Label>Id Pedagogie	 </Label>
        <select name="idpedagosession" id="">
            <?php      
                foreach( $resultsp as $value ){             
                        echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                }
                ?>
        </select>

        <label>Id Formation </label>
        <select name="idformationsession" id="">
            <?php      
                foreach( $resultsf as $value ){             
                        echo '<option value="' . $value['id_formation'] .  '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';   
                }
                ?>
        </select>
        <label>Id Centre </label>
        <select name="idcentresession" id="">
            <?php      
                foreach( $resultsc as $value ){             
                        echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                }
                ?>
        </select>

        <input type="submit" name="submitSession" value="Enregistrer">
    </form>
<?php

if (isset($_POST['submitSession'])){
    $nomSession = $_POST['nomSession'];
    $dateSession = $_POST['dateSession'];
    $idpedagoSession = $_POST['idpedagosession'];
    $idformationSession = $_POST['idformationsession'];
    

    $sql = "INSERT INTO `session`(`nom_session`,`date_debut`,`id_pedagogie`,`id_formation`,`id_centre`) VALUES ('$nomSession','$dateSession','$idpedagoSession','$idformationSession','$idcentreSession')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

 $sql = "SELECT
 `session`.`id_session`,
 `session`.`nom_session`,
 `session`.`date_debut`,
 `session`.`id_pedagogie`,
 `pedagogie`.`nom_pedagogie`,
 `pedagogie`.`prenom_pedagogie`,
 `session`.`id_formation`,
 `formations`.`nom_formation`,
 `session`.`id_centre`,
 `centres`.`ville_centre`
 FROM
 `session`
 LEFT JOIN
 `formations` ON `session`.`id_formation` = `formations`.`id_formation`
 LEFT JOIN
 `pedagogie` ON `session`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
 LEFT JOIN
 `centres` ON `session`.`id_centre` = `centres`.`id_centre`;";
 $requete = $bdd->query($sql);
 $results = $requete->fetchAll(PDO::FETCH_ASSOC);

 echo "<h2>Liste des Sessions :</h2>";
 echo "<table border='1'>";
 echo "<tr> <th>ID</th> <th>Nom</th> <th>Date de Début</th> <th>ID Pédagogique</th> <th>ID Formation</th> <th>Nom formation</th> <th>ID Centre</th><th>Ville centre</th> </tr>";

foreach( $results as $value ){
    // var_dump($value);
    // echo $value["id_session"] . " - " . $value["nom_session"]." - ". $value["date_debut"]. " : " . $value["id_pedagogie"]. " - " . $value["id_formation"] . " - ".$value["id_centre"]. "<br>"; 

    echo "<tr>";
   echo "<td>" . $value["id_session"] . "</td>";
   echo "<td>" . $value["nom_session"] . "</td>";
   echo "<td>" . $value["date_debut"] . "</td>";
   echo "<td>" . $value["id_pedagogie"] . "</td>";
   echo "<td>" . $value["id_formation"] . "</td>";
   echo "<td>" . $value["nom_formation"] . "</td>";
   echo "<td>" . $value["id_centre"] . "</td>";
   echo "<td>" . $value["ville_centre"] . "</td>";
   echo "</tr>";
    }
    echo "</table>";

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action2 = $_GET['action'];
        $id2 = $_GET['id'];
    
        if ($action2 == 'supprimer') {
            $sql = "DELETE FROM `centres` WHERE `id_centre` = $id2";
            $bdd->query($sql);
            echo "Le rôle a été supprimé de la base de données.";
        } elseif ($action2 == 'modifier') {
            // Récupérer les détails du rôle à modifier
            $sql = "SELECT `id_centre`, `ville_centre`, `adresse_centre`, `code_postal_centre` FROM `centres` WHERE `id_centre` = $id2";
            $requete = $bdd->query($sql);
            $role = $requete->fetch(PDO::FETCH_ASSOC);
    
            // Afficher un formulaire de modification pré-rempli
            echo "<h1 class='titre'>Modification du Centre</h1>";
            echo "<form method='POST'>
                      <label> Nouvel ID du Centre </label>
                      <input type='text' name='nouvelIDcentre' value='" . $role['id_centre'] . "'>
                      <label> Nouvel Ville du Centre </label>
                      <input type='text' name='nouvelVilleCentre' value='" . $role['ville_centre'] . "'>
                      <label> Nouvel Adresse du Centre </label>
                      <input type='text' name='nouvelAdresseCentre' value='" . $role['adresse_centre'] . "'>
                      <label> Nouveau Code Postale </label>
                      <input type='text' name='nouveauCentreCp' value='" . $role['code_postal_centre'] . "'>
                      <input type='submit' name='modifierCentre' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierCentre'])) {
                $nouvelIDcentre = $_POST['nouvelIDcentre'];
                $nouvelVilleCentre = $_POST['nouvelVilleCentre'];
                $nouvelAdresseCentre = $_POST['nouvelAdresseCentre'];
                $nouveauCentreCp = $_POST['nouveauCentreCp'];

                $sql = "UPDATE `centres` SET `id_centre`='$nouvelIDcentre ',`ville_centre`='$nouvelVilleCentre',`adresse_centre`='$nouvelAdresseCentre',`code_postal_centre`='$nouveauCentreCp' WHERE `id_centre` = $id2 ";
                $bdd->query($sql);
                echo "Le rôle a été modifié dans la base de données.";
            }
        }
    } 
}



// Gestion Apprenants :
    // Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "apprenants" ){

    $sqlr = "SELECT * FROM role";
    $requeter = $bdd->query($sqlr);
    $resultsr = $requeter->fetchAll(PDO::FETCH_ASSOC);

    $sqls = "SELECT * FROM session";
    $requetes = $bdd->query($sqls);
    $resultss = $requetes->fetchAll(PDO::FETCH_ASSOC);


?>
    <h1 class="titre">Ajout d'un Apprenant</h1>
    <form method="POST">
        <label> Nom </label>
        <input type="text" name="nomApprenant">
        <label>Prenom</label>
        <input type="text" name="prenomApprenant">
        <label> Mail </label>
        <input type="email" name="mailApprenant">
        <label> Adresse </label>
        <input type="text" name="adresseApprenant">
        <label>Ville</label>
        <input type="text" name="villeApprenant">
        <label> Code Postale </label>
        <input type="text" name="cpApprenant">
        <label> Télephone </label>
        <input type="tel" name="telApprenant">
        <label>Date de Naissance</label>
        <input type="date" name="datenaissanceApprenant">
        <label> Niveau </label>
        <input type="text" name="niveauApprenant">
        <label> Numero Pole Emploi</label>
        <input type="text" name="numpeApprenant">
        <label>Numero de sécurité sociale</label>
        <input type="text" name="numsecuApprenant">
        <label> RIB </label>
        <input type="text" name="ribApprenant">
        <label> Id Role </label>
        <select name="Idroleapprenant" id="">
            <?php      
                foreach( $resultsr as $valuer ){             
                        echo '<option value="' . $valuer['id_role'] .  '">' . $valuer['id_role'] . ' - ' . $valuer['nom_role'] . '</option>';   
                }
                ?>
        </select>
        <label> Id Session </label>
        <select name="idsessionapprenant" id="">
            <?php      
                foreach( $resultss as $values ){             
                        echo '<option value="' . $values['id_session'] .  '">' . $values['id_session'] . ' - ' . $values['date_debut'] . '</option>';   
                }
                ?>
        </select>

        <input type="submit" name="submitApprenant" value="Enregistrer">
    </form>
<?php

if (isset($_POST['submitApprenant'])){
    $nomApprenant = $_POST['nomApprenant'];
    $prenomApprenant = $_POST['prenomApprenant'];
    $mailApprenant = $_POST['mailApprenant'];
    $adresseApprenant = $_POST['adresseApprenant'];
    $villeApprenant = $_POST['villeApprenant'];
    $cpApprenant = $_POST['cpApprenant'];
    $telApprenant = $_POST['telApprenant'];
    $datenaissanceApprenant = $_POST['datenaissanceApprenant'];
    $niveauApprenant = $_POST['niveauApprenant'];
    $numpeApprenant = $_POST['numpeApprenant'];
    $numsecuApprenant = $_POST['numsecuApprenant'];
    $ribApprenant = $_POST['ribApprenant'];
    $Idroleapprenant = $_POST['Idroleapprenant'];
    $idsessionapprenant = $_POST['idsessionapprenant'];


    $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`,`id_role`, `id_session`) VALUES ('$nomApprenant','$prenomApprenant','$mailApprenant','$adresseApprenant','$villeApprenant','$cpApprenant','$telApprenant','$datenaissanceApprenant','$niveauApprenant','$numpeApprenant','$numsecuApprenant','$ribApprenant','$Idroleapprenant','$idsessionapprenant')";
    $bdd->query($sql);
    echo "data ajoutée dans la bdd";
}

 $sql = "SELECT 
 `apprenants`.`id_apprenant`,
 `apprenants`.`nom_apprenant`, 
 `apprenants`.`prenom_apprenant`,
 `apprenants`.`mail_apprenant`,
 `apprenants`.`adresse_apprenant`,
 `apprenants`.`ville_apprenant`,
 `apprenants`.`code_postal_apprenant`,
 `apprenants`.`tel_apprenant`,
 `apprenants`.`date_naissance_apprenant`,
 `apprenants`.`niveau_apprenant`,
 `apprenants`.`num_PE_apprenant`,
 `apprenants`.`num_secu_apprenant`,
 `apprenants`.`rib_apprenant`,
 `role`.`id_role`,
 `role`.`nom_role`,
 `session`.`id_session`,
 `session`.`nom_session` 
 FROM 
 `apprenants` 
 left JOIN 
 `role` on `apprenants`.id_role = `role`.id_role
 left JOIN 
 `session` on `apprenants`.`id_session` = `session`.id_session";
 $requete = $bdd->query($sql);
 $results = $requete->fetchAll(PDO::FETCH_ASSOC);

 echo "<h2>Liste des Apprenants :</h2>";
 echo "<table border='1'>";
 echo "<tr> <th>ID</th> <th>Nom</th> <th>Prénom</th> <th>Mail</th> <th>Adresse</th> <th>Ville</th> <th>Code Postale</th> <th>Tel</th> <th>Date de Naissance</th><th>Niveau Scolaire</th> <th>Numéro Pole emploi</th> <th>Numero Secu</th><th>RIB</th> <th>ID Role</th> <th>Nom Role</th> <th>Id Session</th> <th>Nom Session</th> </tr>";

foreach( $results as $value ){
    // var_dump($value);
//    echo $value["id_apprenant"] . " - " . $value["nom_apprenant"] . " - " . $value["prenom_apprenant"] . " - " . $value["mail_apprenant"]. "- " . $value["adresse_apprenant"]. " - " . $value["ville_apprenant"]. " - " . $value["code_postal_apprenant"]. " - " . $value["tel_apprenant"]." - ". $value["date_naissance_apprenant"]. " - " . $value["niveau_apprenant"]. " - " . $value["num_PE_apprenant"]. " - " . $value["num_secu_apprenant"]. " - " . $value["rib_apprenant"]. " - " . $value["id_role"]. " - " . $value["id_session"]. "<br>"; 

   echo "<tr>";
   echo "<td>" . $value["id_apprenant"] . "</td>";
   echo "<td>" . $value["nom_apprenant"] . "</td>";
   echo "<td>" . $value["prenom_apprenant"] . "</td>";
   echo "<td>" . $value["mail_apprenant"] . "</td>";
   echo "<td>" . $value["adresse_apprenant"] . "</td>";
   echo "<td>" . $value["ville_apprenant"] . "</td>";
   echo "<td>" . $value["code_postal_apprenant"] . "</td>";
   echo "<td>" . $value["tel_apprenant"] . "</td>";
   echo "<td>" . $value["date_naissance_apprenant"] . "</td>";
   echo "<td>" . $value["niveau_apprenant"] . "</td>";
   echo "<td>" . $value["num_PE_apprenant"] . "</td>";
   echo "<td>" . $value["num_secu_apprenant"] . "</td>";
   echo "<td>" . $value["rib_apprenant"] . "</td>";
   echo "<td>" . $value["id_role"] . "</td>";
   echo "<td>" . $value["nom_role"] . "</td>";
   echo "<td>" . $value["id_session"] . "</td>";
   echo "<td>" . $value["nom_session"] . "</td>";
   echo "</tr>";
    }
    echo "</table>";

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action2 = $_GET['action'];
        $id2 = $_GET['id'];
    
        if ($action2 == 'supprimer') {
            $sql = "DELETE FROM `centres` WHERE `id_centre` = $id2";
            $bdd->query($sql);
            echo "Le rôle a été supprimé de la base de données.";
        } elseif ($action2 == 'modifier') {
            // Récupérer les détails du rôle à modifier
            $sql = "SELECT `id_centre`, `ville_centre`, `adresse_centre`, `code_postal_centre` FROM `centres` WHERE `id_centre` = $id2";
            $requete = $bdd->query($sql);
            $role = $requete->fetch(PDO::FETCH_ASSOC);
    
            // Afficher un formulaire de modification pré-rempli
            echo "<h1 class='titre'>Modification du Centre</h1>";
            echo "<form method='POST'>
                      <label> Nouvel ID du Centre </label>
                      <input type='text' name='nouvelIDcentre' value='" . $role['id_centre'] . "'>
                      <label> Nouvel Ville du Centre </label>
                      <input type='text' name='nouvelVilleCentre' value='" . $role['ville_centre'] . "'>
                      <label> Nouvel Adresse du Centre </label>
                      <input type='text' name='nouvelAdresseCentre' value='" . $role['adresse_centre'] . "'>
                      <label> Nouveau Code Postale </label>
                      <input type='text' name='nouveauCentreCp' value='" . $role['code_postal_centre'] . "'>
                      <input type='submit' name='modifierCentre' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierCentre'])) {
                $nouvelIDcentre = $_POST['nouvelIDcentre'];
                $nouvelVilleCentre = $_POST['nouvelVilleCentre'];
                $nouvelAdresseCentre = $_POST['nouvelAdresseCentre'];
                $nouveauCentreCp = $_POST['nouveauCentreCp'];

                $sql = "UPDATE `centres` SET `id_centre`='$nouvelIDcentre ',`ville_centre`='$nouvelVilleCentre',`adresse_centre`='$nouvelAdresseCentre',`code_postal_centre`='$nouveauCentreCp' WHERE `id_centre` = $id2 ";
                $bdd->query($sql);
                echo "Le rôle a été modifié dans la base de données.";
            }
        }
    } 
}

?>
    
</body>
</html>

