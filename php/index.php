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
        <h1 class="titre">Ajouter un Rôle</h1>
        <input type='submit' value="Ajout d'un rôle" onclick="toggleFormVisibility()">
    <?php

    $sqlrole = "SELECT * FROM role";
    $requeterole = $bdd->query($sqlrole);
    $resultsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Liste des Roles :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom Role</th><th>Modification</th></tr>";

    foreach( $resultsrole as $value ){
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
    ?>
    <div class="roleajout">
        <form method="POST" id="ajoutRoleForm" style="display:none">
            <label> Ajouter un Role </label>
            <input type="text" name="nomRole">
            <input type="submit" name="submitRole" value="Enregistrer">
        </form>
    </div>
    <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutRoleForm');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
        }
    </script>
    
    <?php

    if (isset($_POST['submitRole'])){
        $nomRole = $_POST['nomRole'];

        $sqlrole = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
        $bdd->query($sqlrole);
        echo "data ajoutée dans la bdd";
    }

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $actionrole = $_GET['action'];
        $idrole = $_GET['id'];
    
       if ($actionrole == 'modifier') {
            $sqlrole = "SELECT * FROM role WHERE id_role = $idrole";
            $requeterole = $bdd->query($sqlrole);
            $role = $requeterole->fetch(PDO::FETCH_ASSOC);
    
            echo "<h1 class='titre'>Modification du rôle</h1>";
            echo "<form method='POST'>
                      <label> Nouveau Nom de Role </label>
                      <input type='hidden' name='idrole' value='" . $role['id_role'] . "'>
                      <input type='text' name='nouveauNomRole' value='" . $role['nom_role'] . "'>
                      <input type='submit' name='modifierRole' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierRole'])) {
                $idrole = $_POST['idrole'];
                $nouveauNomRole = $_POST['nouveauNomRole'];

                $sql = "UPDATE role SET nom_role = '$nouveauNomRole' WHERE id_role = $idrole";
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
        <h1 class="titre">Ajouter un Centre</h1>
        <input type='submit' value="Ajout d'un Centre" onclick="toggleFormVisibility()">
    <div class="ajoutcent">
        <form method="POST" id="ajoutcentreForm" style="display:none">
            <label> Ville du Centre </label>
            <input type="text" name="villeCentre">
            <label>Adresse</label>
            <input type="text" name="adresseCentre">
            <label>Code Postale </label>
            <input type="text" name="cpCentre">
            <input type="submit" name="submitCentre" value="Enregistrer">
        </form>
    </div> 
    <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutcentreForm');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
        }
    </script>

    <?php

    if (isset($_POST['submitCentre'])){
        $villeCentre = $_POST['villeCentre'];
        $adresseCentre = $_POST['adresseCentre'];
        $cpCentre = $_POST['cpCentre'];

        $sqlcentre = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
        $bdd->query($sqlcentre);
        echo "data ajoutée dans la bdd";
    }

   $sqlcentre = "SELECT * FROM centres";
   $requetecentre = $bdd->query($sqlcentre);
   $resultscentre = $requetecentre->fetchAll(PDO::FETCH_ASSOC);

   echo "<h2>Liste des centres :</h2>";
   echo "<table border='1'>";
   echo "<tr><th>ID</th><th>Ville</th><th>Adresse</th><th>Code Postal</th><th>Modification</th><th>Suppression</th></tr>";
  
  foreach( $resultscentre as $value ){
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
            $actioncentre = $_GET['action'];
            $idcentre = $_GET['id'];
            
            if ($actioncentre == 'modifier') {
                $sqlcentre = "SELECT * FROM `centres` WHERE `id_centre` = $idcentre";
                $requetecentre = $bdd->query($sqlcentre);
                $centre = $requetecentre->fetch(PDO::FETCH_ASSOC);
        
                echo "<h1 class='titre'>Modification du Centre</h1>";
                echo "<form method='POST'>
                          <input type='hidden' name='IDcentre' value='" . $centre['id_centre'] . "'>
                          <label> Nouvel Ville du Centre </label>
                          <input type='text' name='nouvelVilleCentre' value='" . $centre['ville_centre'] . "'>
                          <label> Nouvel Adresse du Centre </label>
                          <input type='text' name='nouvelAdresseCentre' value='" . $centre['adresse_centre'] . "'>
                          <label> Nouveau Code Postale </label>
                          <input type='text' name='nouveauCentreCp' value='" . $centre['code_postal_centre'] . "'>
                          <input type='submit' name='modifierCentre' value='Modifier'>
                      </form>";
        
                if (isset($_POST['modifierCentre'])) {
                    $IDcentre = $_POST['IDcentre'];
                    $nouvelVilleCentre = $_POST['nouvelVilleCentre'];
                    $nouvelAdresseCentre = $_POST['nouvelAdresseCentre'];
                    $nouveauCentreCp = $_POST['nouveauCentreCp'];

                    $sqlcentre = "UPDATE `centres` SET `id_centre`='$IDcentre ',`ville_centre`='$nouvelVilleCentre',`adresse_centre`='$nouvelAdresseCentre',`code_postal_centre`='$nouveauCentreCp' WHERE `id_centre` = $IDcentre ";
                    $bdd->query($sqlcentre);
                    echo "Le Centre a été modifié dans la base de données.";
                }
            }
            if ($actioncentre == 'supprimer') {
                $sqlcentre = "SELECT * FROM `centres` WHERE `id_centre` = $idcentre";
                $requetecentre = $bdd->query($sqlcentre);
                $centre = $requetecentre->fetch(PDO::FETCH_ASSOC);

                echo "Vous etes sur le point de supprimer un centre";
                echo "<form method='POST'>
                        <input type='hidden' name='IDcentre' value='" . $centre['id_centre'] . "'>
                        <input type='submit' name='supprimerCentre' value='Supprimer'> 
                        </form>";
                
                if (isset($_POST['supprimerCentre'])){
                    $IDcentre = $_POST['IDcentre'];

                    $sqlcentre = "DELETE FROM `centres` WHERE `id_centre`= $IDcentre ";
                    $bdd->query($sqlcentre);
                    echo "Le Centre a été supprimé de la base de données.";
                }
            } 
        } 
}


// Gestion Formation :
// Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "formation" ){
    ?>
        <h1 class="titre">Ajouter une Formation</h1>
        <input type='submit' value="Ajout d'une Formation" onclick="toggleFormVisibility()">
    <div class="ajoutform">
        <form method="POST" id="ajoutformationForm" style="display:none">
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
    </div>
    <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutformationForm');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
        }
    </script>
    <?php

    if (isset($_POST['submitFormation'])){
        $nomFormation = $_POST['nomFormation'];
        $dureeFormation = $_POST['dureeFormation'];
        $niveauformation = $_POST['niveauformation'];
        $descriptionFormation = $_POST['descriptionFormation'];

        $sqlformation = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation ','$dureeFormation ',' $niveauformation','$descriptionFormation ')";
        $bdd->query($sqlformation);
        echo "data ajoutée dans la bdd";
    }

    $sqlformation = "SELECT * FROM formations";
    $requeteformation = $bdd->query($sqlformation);
    $resultsformation = $requeteformation->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des Formations :</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom Formation</th><th>Durée Formation </th> <th>Niveau de Sortie</th> <th>Description</th><th>Modification</th><th>Suppression</th> </tr>";


    foreach( $resultsformation as $value ){
    //var_dump($value);
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
        $actionformation = $_GET['action'];
        $idformation = $_GET['id'];
        
        if ($actionformation == 'modifier') {
            $sqlformation = "SELECT * FROM `formations` WHERE `id_formation` = $idformation";
            $requeteformation = $bdd->query($sqlformation);
            $formation = $requeteformation->fetch(PDO::FETCH_ASSOC);
        
            echo "<h1 class='titre'>Modification de la Formation</h1>";
            echo "<form method='POST'>
                    <input type='hidden' name='nouvelIDformation' value='" . $formation['id_formation'] . "'>
                    <label> Nouveau Nom de la formation </label>
                    <input type='text' name='nouveauNomformation' value='" . $formation['nom_formation'] . "'>
                    <label> Nouvel Durée de la formation </label>
                    <input type='text' name='nouvelDureeformation' value='" . $formation['duree_formation'] . "'>
                    <label> Nouveau Niveau de sortie </label>
                    <input type='text' name='nouveauNiveauformation' value='" . $formation['niveau_sortie_formation'] . "'>
                    <label> Nouvel Description </label>
                    <input type='text' name='nouveldescriptionformation' value='" . $formation['description'] . "'>
                    <input type='submit' name='modifierFormation' value='Modifier'>
                </form>";
        
                if (isset($_POST['modifierFormation'])) {
                    $IDformation = $_POST['nouvelIDformation'];
                    $nouveauNomformation = $_POST['nouveauNomformation'];
                    $nouvelDureeformation = $_POST['nouvelDureeformation'];
                    $nouveauNiveauformation = $_POST['nouveauNiveauformation'];
                    $nouveldescriptionformation = $_POST['nouveldescriptionformation'];

                    $sqlformation = "UPDATE `formations` SET `nom_formation`='$nouveauNomformation',`duree_formation`='$nouvelDureeformation',`niveau_sortie_formation`='$nouveauNiveauformation',`description`='$nouveldescriptionformation' WHERE `id_formation` = $IDformation";
                    $bdd->query($sqlformation);
                    echo "La Formation a été modifié dans la base de données.";
                }
            }
        if ($actionformation == 'supprimer') {
            $sqlformation = "SELECT * FROM `formations` WHERE `id_formation` = $idformation";
            $requeteformation = $bdd->query($sqlformation);
            $formation = $requeteformation->fetch(PDO::FETCH_ASSOC);

            echo "Vous etes sur le point de supprimer une formation";
            echo "<form method='POST'>
                    <input type='hidden' name='IDformation' value='" . $formation['id_formation'] . "'>
                    <input type='submit' name='supprimerFormation' value='Supprimer'> 
                </form>";
                
            if (isset($_POST['supprimerFormation'])){
                $IDformation = $_POST['IDformation'];

                $sqlformation = "DELETE FROM `formations` WHERE `id_formation`= $IDformation ";
                $bdd->query($sqlformation);
                echo "La Formation a été supprimé de la base de données.";

            }
        } 
    }
}


// Gestion Equipe Pédagogique :
// Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "pedagogie" ){

    $sqlrole = "SELECT * FROM role";
    $requeterole = $bdd->query($sqlrole);
    $resultsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <h1 class="titre">Ajouter un Membre de l'équipe pédagogique</h1>
        <input type='submit' value="Ajout d'un Membre de l'équipe pédagogique" onclick="toggleFormVisibility()">
        <div class="ajouep">
            <form method="POST" id="ajoutmembreEP" style="display:none">
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
                    foreach( $resultsrole as $value ){             
                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                    }
                    ?>
                </select>
                <input type="submit" name="submitPedagogie" value="Enregistrer">
            </form>
        </div>
        <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutmembreEP');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
        }
        </script>
    <?php

    if (isset($_POST['submitPedagogie'])){
        $nomMembrepedago = $_POST['nomMembrepedago'];
        $prenomMembrepedago = $_POST['prenomMembrepedago'];
        $mailMembrepedago = $_POST['mailMembrepedago'];
        $numMembrepedago = $_POST['numMembrepedago'];
        $rolepedago = $_POST['rolepedago'];

        $sqlep = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`,`id_role`) VALUES ('$nomMembrepedago','$prenomMembrepedago','$mailMembrepedago','$numMembrepedago','$rolepedago')";
        $bdd->query($sqlep);
        echo "data ajoutée dans la bdd";
    }

    $sqlep = "SELECT `pedagogie`.`id_pedagogie`,`pedagogie`.`nom_pedagogie`, `pedagogie`.`prenom_pedagogie`, `pedagogie`.`mail_pedagogie`,`pedagogie`.`num_pedagogie`, `role`.`id_role`,`role`.`nom_role` FROM `pedagogie` INNER JOIN  `role` on `pedagogie`.`id_role` = `role`.`id_role`";
    $requeteep = $bdd->query($sqlep);
    $resultsep = $requeteep->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Equipe Pédagogique :</h2>";
    echo "<table border='1'>";
    echo "<tr> <th>ID</th> <th>Nom</th> <th>Prénom</th> <th>Mail</th> <th>Numéro Pédagogique</th> <th>ID Role</th><th>Nom Role</th> <th>Modification</th><th>Suppression</th> </tr>";
 

    foreach( $resultsep as $value ){
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
        $actionep = $_GET['action'];
        $idep = $_GET['id'];
    
       if ($actionep == 'modifier') {
            
            $sqlep = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role` FROM `pedagogie` WHERE `id_pedagogie` = $idep";
            $requeteep = $bdd->query($sqlep);
            $pedagogie= $requeteep->fetch(PDO::FETCH_ASSOC);
    
            echo "<h1 class='titre'>Modification d'un Membre de l'equipe pédagogique</h1>";
            ?>
            <div class="moodifep">
                <form method='POST'>
                    <input type='hidden' name='nouvelIDpédagogie' value=' <?php echo $pedagogie['id_pedagogie']?>'>
                    <label> Nouveau Nom </label>
                    <input type='text' name='nouveauNomep' >
                    <label> Nouveau Prenom </label>
                    <input type='text' name='nouveauPrenomep' >
                    <label> Nouveau mail </label>
                    <input type='text' name='nouveauMailep' >
                    <label> Nouveau Numéro </label>
                    <input type='text' name='nouveauNumeroep' >
                    <label> Nouveau Role </label>
                    <select name="nouveaurolepedago" id="">
                        <?php      
                            foreach( $resultsrole as $value ){             
                                echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                            }
                        ?>
                      </select>
                      <input type='submit' name='modifierEquipepédago' value='Modifier'>
                </form>
            </div>
    <?php
            if (isset($_POST['modifierEquipepédago'])) {
                $IDpedagogie = $_POST['nouvelIDpédagogie'];
                $nouveauNomep = $_POST['nouveauNomep'];
                $nouveauPrenomep = $_POST['nouveauPrenomep'];
                $nouveauMailep = $_POST['nouveauMailep'];
                $nouveauNumeroep = $_POST['nouveauNumeroep'];
                $nouveaurolepedago = $_POST['nouveaurolepedago'];


                $sqlep = "UPDATE `pedagogie` SET `nom_pedagogie`='$nouveauNomep',`prenom_pedagogie`='$nouveauPrenomep',`mail_pedagogie`='$nouveauMailep',`num_pedagogie`='$nouveauNumeroep',`id_role`='$nouveaurolepedago' WHERE `id_pedagogie` = $IDpedagogie ";
                $bdd->query($sqlep);
                echo " Un Membre de l'Equipe Pédagogique a été modifié dans la base de données.";
            }
        }
        if ($actionep == 'supprimer') {
            $sqlep = "SELECT * FROM `pedagogie` WHERE `id_pedagogie` = $idep";
            $requeteep = $bdd->query($sqlep);
            $pedagogie = $requeteep->fetch(PDO::FETCH_ASSOC);

            echo "Vous etes sur le point de supprimer un Membre de l'équipe Pédagogique";
            echo "<form method='POST'>
                    <input type='hidden' name='IDpedagogie' value='" . $pedagogie['id_pedagogie'] . "'>
                    <input type='submit' name='supprimerMembreep' value='Supprimer'> 
                    </form>";
            
            if (isset($_POST['supprimerMembreep'])){
                $IDpedagogie = $_POST['IDpedagogie'];

                $sqlep = "DELETE FROM `pedagogie` WHERE `id_pedagogie`= $IDpedagogie  ";
                $bdd->query($sqlep);
                echo "Le Membre de l'équipe Pédagogique a été supprimé de la base de données.";

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

    $sqllo = "SELECT * FROM localiser";
    $requetelo = $bdd->query($sqllo);
    $resultslo = $requetelo->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <h1 class="titre">Ajouter une Session</h1>
        <input type='submit' value="Ajout d'une Session" onclick="toggleFormVisibility()">
        <div class="ajoutsess">
            <form method="POST" id="ajoutsession" style="display:none">
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
                <select name="idcentreSession" id="">
                    <?php      
                        foreach( $resultsc as $value ){             
                            echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                        }
                    ?>
                </select>
                <input type="submit" name="submitSession" value="Enregistrer">
            </form>
        </div>
        <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutsession');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
            }
        </script>
    <?php

    if (isset($_POST['submitSession'])){
        $nomSession = $_POST['nomSession'];
        $dateSession = $_POST['dateSession'];
        $idpedagoSession = $_POST['idpedagosession'];
        $idformationSession = $_POST['idformationsession'];
        $idcentreSession = $_POST['idcentreSession'];
    

        $sql = "INSERT INTO `session`(`nom_session`,`date_debut`,`id_pedagogie`,`id_formation`,`id_centre`) VALUES ('$nomSession','$dateSession','$idpedagoSession','$idformationSession','$idcentreSession')";
        $bdd->query($sql);

        $sqllo = "INSERT INTO `localiser`(`id_formation`, `id_centre`) VALUES ('$idformationSession','$idcentreSession')";
        $bdd->query($sqllo);

        // "INSERT INTO `localiser` (`id_formation`, `id_centre`) VALUES ('$idformationSession', '$idcentreSession') ON DUPLICATE KEY UPDATE `id_formation`='$idformationSession', `id_centre`='$idcentreSession'";

        echo "data ajoutée dans la bdd";
    }

    $sql = "SELECT `session`.`id_session`,`session`.`nom_session`,`session`.`date_debut`,`session`.`id_pedagogie`,`pedagogie`.`nom_pedagogie`,`pedagogie`.`prenom_pedagogie`,`session`.`id_formation`,`formations`.`nom_formation`,`session`.`id_centre`,`centres`.`ville_centre`
    FROM `session`
    LEFT JOIN `formations` ON `session`.`id_formation` = `formations`.`id_formation`
    LEFT JOIN `pedagogie` ON `session`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
    LEFT JOIN   `centres` ON `session`.`id_centre` = `centres`.`id_centre`;";
    $requete = $bdd->query($sql);
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des Sessions :</h2>";
    echo "<table border='1'>";
    echo "<tr> <th>ID</th> <th>Nom</th> <th>Date de Début</th> <th>ID Pédagogique</th><th>Nom Equipe pedago</th> <th>ID Formation</th> <th>Nom formation</th> <th>ID Centre</th><th>Ville centre</th><th>Modification</th><th>Suppression</th> </tr>";

    foreach( $results as $value ){
        // var_dump($value);
        // echo $value["id_session"] . " - " . $value["nom_session"]." - ". $value["date_debut"]. " : " . $value["id_pedagogie"]. " - " . $value["id_formation"] . " - ".$value["id_centre"]. "<br>"; 

        echo "<tr>";
        echo "<td>" . $value["id_session"] . "</td>";
        echo "<td>" . $value["nom_session"] . "</td>";
        echo "<td>" . $value["date_debut"] . "</td>";
        echo "<td>" . $value["id_pedagogie"] . "</td>";
        echo "<td>" . $value["nom_pedagogie"] . "</td>";
        echo "<td>" . $value["id_formation"] . "</td>";
        echo "<td>" . $value["nom_formation"] . "</td>";
        echo "<td>" . $value["id_centre"] . "</td>";
        echo "<td>" . $value["ville_centre"] . "</td>";
        echo "<td>  <a href='?page=session&action=modifier&id=" . $value["id_session"] . "'>Modifier</a> </td>";
        echo "<td>  <a href='?page=session&action=supprimer&id=" . $value["id_session"] . "'>Supprimer</a> </td>";
        echo "</tr>";
    }
        echo "</table>";

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $actionsession = $_GET['action'];
        $idsession = $_GET['id'];
    
        if ($actionsession == 'modifier') {
            $sqlsession = "SELECT * FROM `session` WHERE `id_session` = $idsession";
            $requetesession = $bdd->query($sqlsession);
            $session = $requetesession->fetch(PDO::FETCH_ASSOC);
    
            echo "<h1 class='titre'>Modification de la Session</h1>";
            ?>
            <div class="modifsess">
                <form method="POST">
                    <input type='hidden' name='nouvelIDsession' value=' <?php echo $session['id_session']?>'>
                    <Label>Nouveau Nom de Session </Label>
                    <input type="text" name="nouveauNomSession">
                    <Label>Nouvel Date de Debut Formation </Label>
                    <input type="date" name="nouvelDateSession">
                    <Label>Nouvel Id Pedagogie	 </Label>
                    <select name="nouvelIdpedagosession" id="">
                        <?php      
                            foreach( $resultsp as $value ){             
                                echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                            }   
                        ?>
                    </select>
                    <label>Nouvel Id Formation </label>
                    <select name="nouvelIdformationsession" id="">
                        <?php      
                            foreach( $resultsf as $value ){             
                                echo '<option value="' . $value['id_formation'] .  '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';   
                            }
                        ?>
                    </select>
                    <label>Nouvel Id Centre </label>
                    <select name="nouvelIdcentresession" id="">
                        <?php      
                            foreach( $resultsc as $value ){             
                                echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                            }
                        ?>
                    </select>
                    <input type="submit" name="modifierSession" value="Modifier">
                </form>
            </div>
    <?php
    
            if (isset($_POST['modifierSession'])) {
                $nouvelIDsession = $_POST['nouvelIDsession'];
                $nouveauNomSession = $_POST['nouveauNomSession'];
                $nouvelDateSession = $_POST['nouvelDateSession'];
                $nouvelIdpedagosession = $_POST['nouvelIdpedagosession'];
                $nouvelIdformationsession = $_POST['nouvelIdformationsession'];
                $nouvelIdcentresession = $_POST['nouvelIdcentresession'];

                $sqlsession = "UPDATE `session` SET `id_session`='$nouvelIDsession',`nom_session`='$nouveauNomSession',`date_debut`='$nouvelDateSession',`id_pedagogie`='$nouvelIdpedagosession',`id_formation`='$nouvelIdformationsession',`id_centre`='$nouvelIdcentresession' WHERE `id_session` = $nouvelIDsession";
                $bdd->query($sqlsession);

                $sqllocaliser = "UPDATE `localiser` SET `id_formation`='$nouvelIdformationsession',`id_centre`='$nouvelIdcentresession' WHERE `id_formation` = $nouvelIdformationsession AND `id_centre` = $nouvelIdcentresession ";
                $bdd->query($sqllocaliser);

                echo "La Session a été modifié dans la base de données.";
            }
        }
        if ($actionsession == 'supprimer') {
            $sqlsession = "SELECT * FROM `session` WHERE `id_session` = $idsession";
            $requetesession = $bdd->query($sqlsession);
            $session = $requetesession->fetch(PDO::FETCH_ASSOC);

            echo "Vous etes sur le point de supprimer une Session";
            echo "<form method='POST'>
                    <input type='hidden' name='IDsession' value='" . $session['id_session'] . "'>
                    <input type='submit' name='supprimerSession' value='Supprimer'> 
                    </form>";
            
            if (isset($_POST['supprimerSession'])){
                $IDsession = $_POST['IDsession'];

                $sqlsession = "DELETE FROM `session` WHERE `id_session` = $IDsession ";
                $bdd->query($sqlsession);
                echo "La Session a été supprimé de la base de données.";
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


    $sql = "SELECT `apprenants`.`id_apprenant`,`apprenants`.`nom_apprenant`, `apprenants`.`prenom_apprenant`,`apprenants`.`mail_apprenant`,`apprenants`.`adresse_apprenant`,`apprenants`.`ville_apprenant`,`apprenants`.`code_postal_apprenant`,`apprenants`.`tel_apprenant`,`apprenants`.`date_naissance_apprenant`,`apprenants`.`niveau_apprenant`,`apprenants`.`num_PE_apprenant`,`apprenants`.`num_secu_apprenant`,`apprenants`.`rib_apprenant`,
    `role`.`id_role`,`role`.`nom_role`,`session`.`id_session`,`session`.`nom_session` 
    FROM `apprenants` 
    left JOIN `role` on `apprenants`.id_role = `role`.id_role
    left JOIN `session` on `apprenants`.`id_session` = `session`.id_session";

    $requete = $bdd->query($sql);
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des Apprenants :</h2>";
    
    echo "<div style='width:100vw;' > <table border='1'>";
    echo "<tr> <th>ID</th> <th>Nom</th> <th>Prénom</th> <th>Mail</th> <th>Adresse</th> <th>Ville</th> <th>Code Postale</th> <th>Tel</th> <th>Date de Naissance</th><th>Niveau Scolaire</th> <th>Numéro Pole emploi</th> <th>Numero Secu</th><th>RIB</th> <th>ID Role</th> <th>Nom Role</th> <th>Id Session</th> <th>Nom Session</th><th>Modification</th><th>Suppression</th> </tr>";

    foreach( $results as $value ){
        // var_dump($value);
        //echo $value["id_apprenant"] . " - " . $value["nom_apprenant"] . " - " . $value["prenom_apprenant"] . " - " . $value["mail_apprenant"]. "- " . $value["adresse_apprenant"]. " - " . $value["ville_apprenant"]. " - " . $value["code_postal_apprenant"]. " - " . $value["tel_apprenant"]." - ". $value["date_naissance_apprenant"]. " - " . $value["niveau_apprenant"]. " - " . $value["num_PE_apprenant"]. " - " . $value["num_secu_apprenant"]. " - " . $value["rib_apprenant"]. " - " . $value["id_role"]. " - " . $value["id_session"]. "<br>"; 
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
        echo "<td>  <a href='?page=apprenants&action=modifier&id=" . $value["id_apprenant"] . "'>Modifier</a> </td>";
        echo "<td>  <a href='?page=apprenants&action=supprimer&id=" . $value["id_apprenant"] . "'>Supprimer</a> </td>";
        echo "</tr>";
    }
    echo "</table> </div>";
    

    ?>
    <div style="width: 90vw;"></div>
        <h1 class="titre">Ajouter un Apprenant</h1>
        <input type='submit' value="Ajout d'un Apprenant" onclick="toggleFormVisibility()">
        <div class="ajoutapprenant">
            <form class="ajoutapp" method="POST" id="ajoutapprenant" style="display:none">
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
        </div>
        <script>
        function toggleFormVisibility() {
            const formulaire = document.getElementById('ajoutapprenant');
            formulaire.style.display = (formulaire.style.display === 'none') ? 'block' : 'none';
            }
        </script>
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

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $actionapprenant = $_GET['action'];
        $idapprenant = $_GET['id'];

        if ($actionapprenant == 'modifier') {
            // Récupérer les détails de l'apprenant à modifier
            $sqlapprenant = "SELECT * FROM `apprenants` WHERE `id_apprenant` = $idapprenant";
            $requeteapprenant = $bdd->query($sqlapprenant);
            $apprenant = $requeteapprenant->fetch(PDO::FETCH_ASSOC);

            // Afficher un formulaire de modification pré-rempli
            echo "<h1 class='titre'>Modification d'un Apprenant</h1>";

    ?>
            <div class="modifapprenant">
                <form class="modifapp" method="POST">
                    <input type='hidden' name='nouvelIDapprenant' value=' <?php echo $apprenant['id_apprenant']?>'>
                    <label> Nouveau Nom </label>
                    <input type="text" name="nouveaunomApprenant">
                    <label>Nouveau Prenom</label>
                    <input type="text" name="nouveauprenomApprenant">
                    <label> Nouveau Mail </label>
                    <input type="email" name="nouveaumailApprenant">
                    <label> Nouvel Adresse </label>
                    <input type="text" name="nouveladresseApprenant">
                    <label>Nouvel Ville</label>
                    <input type="text" name="nouvelvilleApprenant">
                    <label> Nouveau Code Postale </label>
                    <input type="text" name="nouveaucpApprenant">
                    <label> Nouveau Télephone </label>
                    <input type="tel" name="nouveautelApprenant">
                    <label>Nouvel Date de Naissance</label>
                    <input type="date" name="nouveldatenaissanceApprenant">
                    <label>Nouveau Niveau </label>
                    <input type="text" name="nouveauniveauApprenant">
                    <label>Nouveau Numero Pole Emploi</label>
                    <input type="text" name="nouveaunumpeApprenant">
                    <label>Nouveau Numero de sécurité sociale</label>
                    <input type="text" name="nouveaunumsecuApprenant">
                    <label> Nouveau RIB </label>
                    <input type="text" name="nouveauribApprenant">
                    <label>Nouvel Id Role </label>
                    <select name="newIdroleapprenant" id="">
                        <?php      
                            foreach( $resultsr as $valuer ){             
                                echo '<option value="' . $valuer['id_role'] .  '">' . $valuer['id_role'] . ' - ' . $valuer['nom_role'] . '</option>';   
                            }
                        ?>
                    </select>
                    <label> Id Session </label>
                    <select name="newidsessionapprenant" id="">
                        <?php      
                            foreach( $resultss as $values ){             
                                echo '<option value="' . $values['id_session'] .  '">' . $values['id_session'] . ' - ' . $values['date_debut'] . '</option>';   
                                }
                        ?>
                    </select>
                    <input type='submit' name='modifierApprenant' value='Modifier'>
                </form>
            </div>
    <?php
                if (isset($_POST['modifierApprenant'])) {
                    $IDapprenant = $_POST['nouvelIDapprenant'];
                    $nouveaunomApprenant = $_POST['nouveaunomApprenant'];
                    $nouveauprenomApprenant = $_POST['nouveauprenomApprenant'];
                    $nouveaumailApprenant = $_POST['nouveaumailApprenant'];
                    $nouveladresseApprenant = $_POST['nouveladresseApprenant'];
                    $nouvelvilleApprenant = $_POST['nouvelvilleApprenant'];
                    $nouveaucpApprenant = $_POST['nouveaucpApprenant'];
                    $nouveautelApprenant = $_POST['nouveautelApprenant'];
                    $nouveldatenaissanceApprenant = 
                    $_POST['nouveldatenaissanceApprenant']; 
                    $nouveauniveauApprenant = $_POST['nouveauniveauApprenant'];
                    $nouveaunumpeApprenant = $_POST['nouveaunumpeApprenant'];
                    $nouveaunumsecuApprenant = $_POST['nouveaunumsecuApprenant'];
                    $nouveauribApprenant = $_POST['nouveauribApprenant'];
                    $newIdroleapprenant = $_POST['newIdroleapprenant'];
                    $newidsessionapprenant = $_POST['newidsessionapprenant'];

                    $sqlapprenant = "UPDATE `apprenants` SET `id_apprenant`='$IDapprenant',`nom_apprenant`='$nouveaunomApprenant',`prenom_apprenant`='$nouveauprenomApprenant',`mail_apprenant`='$nouveaumailApprenant',`adresse_apprenant`='$nouveladresseApprenant',`ville_apprenant`='$nouvelvilleApprenant',`code_postal_apprenant`='$nouveaucpApprenant',`tel_apprenant`='$nouveautelApprenant',`date_naissance_apprenant`='$nouveldatenaissanceApprenant',`niveau_apprenant`='$nouveauniveauApprenant',`num_PE_apprenant`='$nouveaunumpeApprenant',`num_secu_apprenant`='$nouveaunumsecuApprenant',`rib_apprenant`='$nouveauribApprenant',`id_role`='$newIdroleapprenant',`id_session`='$newidsessionapprenant' WHERE `id_apprenant` = $IDapprenant ";
                    $bdd->query($sqlapprenant);
                    echo "L'Apprenant a été modifié dans la base de données.";
                }
            } 

        if ($actionapprenant == 'supprimer') {
            $sqlapprenant = "SELECT * FROM `apprenants` WHERE `id_apprenant` = $idapprenant";
            $requeteapprenant = $bdd->query($sqlapprenant);
            $apprenant = $requeteapprenant->fetch(PDO::FETCH_ASSOC);
        
            echo "Vous etes sur le point de supprimer un Apprenant";
            echo "<form method='POST'>
                <input type='hidden' name='IDapprenant' value='" . $apprenant['id_apprenant'] . "'>
                <input type='submit' name='supprimerApprenant' value='Supprimer'> 
                </form>";
        
            if (isset($_POST['supprimerApprenant'])){
                $IDapprenant = $_POST['IDapprenant'];

                $sqlapprenant = "DELETE FROM `apprenants` WHERE `id_apprenant` = $IDapprenant ";
                $bdd->query($sqlapprenant);
                echo "L'Apprenant a été supprimé de la base de données.";
            }
        } 
    }  
}


// Gestion Affecter :
// Insérer des données dans la BDD
if(isset($_GET["page"]) && $_GET["page"] == "affecter" ){

    $sqlp = "SELECT * FROM pedagogie";
    $requetep = $bdd->query($sqlp);
    $resultsp = $requetep->fetchAll(PDO::FETCH_ASSOC);

    $sqlc = "SELECT * FROM centres";
    $requetec = $bdd->query($sqlc);
    $resultsc = $requetec->fetchAll(PDO::FETCH_ASSOC);

    $sqlaffect = "SELECT 
    `affecter`.`id_pedagogie`,
    `affecter`.`id_centre`,
    `pedagogie`.`id_pedagogie`,
    `pedagogie`.`nom_pedagogie`,
    `centres`.`id_centre`,
    `centres`.`ville_centre`
    FROM `affecter`
    LEFT JOIN `pedagogie` ON `affecter`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
    LEFT JOIN `centres` ON `affecter`.`id_centre` = `centres`.`id_centre`";
    $requeteaffect = $bdd->query($sqlaffect);
    $resultsaffect = $requeteaffect->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <h1 class="titre">Ajouter une affectation</h1>
        <div class="affectationajout">
                <form method="POST" id="ajoutaffectation" style="">
                    <label> Ajouter une Affection </label>
                    <input type="text" name="nomAffect">
                    <label> Id Pedagogie </label>
                    <select name="affecteridpedago" id="">
                <?php      
                    foreach( $resultsaffect as $value ){             
                        echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                    }
                ?>
                    </select>
                    <input type="submit" name="submitAffection" value="Enregistrer">
                </form>
            </div>
    <?php

    
            echo "<h2>Liste des Affectation :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID Pedagogie</th><th>Nom</th><th>ID Centre</th><th>Ville</th></tr>";
        
        foreach( $resultsaffect as $value ){
            // var_dump($value);
            // echo $value["id_role"] . " - " . $value["nom_role"] . " " . "<br>"; 
    ?>
            <label> Id Pedagogie </label>
            <select name="affecteridpedago" id="">
                <?php      
                    foreach( $resultsaffect as $value ){             
                        echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                    }
                ?>
              </select>
    <?php
            echo "<tr>";
            echo "<td>" . $value["id_pedagogie"] . "</td>";
            echo "<td>" . $value["nom_pedagogie"] . "</td>";
            echo "<td>" . $value["id_centre"] . "</td>";
            echo "<td>" . $value["ville_centre"] . "</td>";
            echo "<td> <a href='?page=affecter&action=modifier&id=" . $value["id_pedagogie"] . $value["id_centre"] ." '>Modifier</a></td>";
            echo "<td>  <a href='?page=affecterv&action=supprimer&id=" . $value["id_pedagogie"] . $value["id_centre"] ."'>Supprimer</a> </td>"; 
            echo "</tr>"; 
            } 
            echo "</table>";
        ?>
            
        <?php
        
        if (isset($_POST['submitRole'])){
            $nomRole = $_POST['nomRole'];
        
            $sqlrole = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
            $bdd->query($sqlrole);
            echo "data ajoutée dans la bdd";
        }
        
            if (isset($_GET['action']) && isset($_GET['id'])) {
                $actionrole = $_GET['action'];
                $idrole = $_GET['id'];
            
               if ($actionrole == 'modifier') {
                    $sqlrole = "SELECT * FROM role WHERE id_role = $idrole";
                    $requeterole = $bdd->query($sqlrole);
                    $role = $requeterole->fetch(PDO::FETCH_ASSOC);
            
                    echo "<h1 class='titre'>Modification du rôle</h1>";
                    echo "<form method='POST'>
                              <label> Nouveau Nom de Role </label>
                              <input type='hidden' name='idrole' value='" . $role['id_role'] . "'>
                              <input type='text' name='nouveauNomRole' value='" . $role['nom_role'] . "'>
                              <input type='submit' name='modifierRole' value='Modifier'>
                          </form>";
            
                    if (isset($_POST['modifierRole'])) {
                        $idrole = $_POST['idrole'];
                        $nouveauNomRole = $_POST['nouveauNomRole'];
        
                        $sql = "UPDATE role SET nom_role = '$nouveauNomRole' WHERE id_role = $idrole";
                        $bdd->query($sql);
                        echo "Le rôle a été modifié dans la base de données.";
                    }
                }
            }      
        }

        
?>  
</body>
</html>

