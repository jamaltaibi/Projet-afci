
<?php
if(isset($_GET["page"]) && $_GET["page"] == "pedagogie" ){

    $resultsrole = getRows($bdd, "role");


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

if (isset($_POST['submitPedagogie'])) {
    // Récupération des données et échappement XSS
    $nomMembrepedago = isset($_POST['nomMembrepedago']) ? htmlspecialchars($_POST['nomMembrepedago']) : '';
    $prenomMembrepedago = isset($_POST['prenomMembrepedago']) ? htmlspecialchars($_POST['prenomMembrepedago']) : '';
    $mailMembrepedago = isset($_POST['mailMembrepedago']) ? htmlspecialchars($_POST['mailMembrepedago']) : '';
    $numMembrepedago = isset($_POST['numMembrepedago']) ? htmlspecialchars($_POST['numMembrepedago']) : '';
    $rolepedago = isset($_POST['rolepedago']) ? htmlspecialchars($_POST['rolepedago']) : '';

    // Vérification si les champs ne sont pas vides
    if (!empty($nomMembrepedago) && !empty($prenomMembrepedago) && !empty($mailMembrepedago) && !empty($numMembrepedago) && !empty($rolepedago)) {
        // Requête préparée pour l'insertion
        $sqlep = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`,`id_role`) VALUES (?, ?, ?, ?, ?)";
        $requete = $bdd->prepare($sqlep);
        // Exécution de la requête en passant les valeurs comme paramètres
        $requete->execute([$nomMembrepedago, $prenomMembrepedago, $mailMembrepedago, $numMembrepedago, $rolepedago]);

        echo "Données ajoutées dans la base de données.";
    } else {
        echo "Certains champs sont vides.";
    }
}

    $sqlep = "SELECT `pedagogie`.`id_pedagogie`,`pedagogie`.`nom_pedagogie`, `pedagogie`.`prenom_pedagogie`, `pedagogie`.`mail_pedagogie`,`pedagogie`.`num_pedagogie`, `role`.`id_role`,`role`.`nom_role` 
    FROM `pedagogie` 
    INNER JOIN  `role` on `pedagogie`.`id_role` = `role`.`id_role`";
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
            
            $sqlep = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role` 
            FROM `pedagogie` WHERE `id_pedagogie` = $idep";
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
                // Récupération des données et échappement XSS
                $IDpedagogie = isset($_POST['nouvelIDpédagogie']) ? $_POST['nouvelIDpédagogie'] : '';
                $nouveauNomep = isset($_POST['nouveauNomep']) ? htmlspecialchars($_POST['nouveauNomep']) : '';
                $nouveauPrenomep = isset($_POST['nouveauPrenomep']) ? htmlspecialchars($_POST['nouveauPrenomep']) : '';
                $nouveauMailep = isset($_POST['nouveauMailep']) ? htmlspecialchars($_POST['nouveauMailep']) : '';
                $nouveauNumeroep = isset($_POST['nouveauNumeroep']) ? htmlspecialchars($_POST['nouveauNumeroep']) : '';
                $nouveaurolepedago = isset($_POST['nouveaurolepedago']) ? htmlspecialchars($_POST['nouveaurolepedago']) : '';
            
                // Vérification si les champs ne sont pas vides
                if (!empty($IDpedagogie) && !empty($nouveauNomep) && !empty($nouveauPrenomep) && !empty($nouveauMailep) && !empty($nouveauNumeroep) && !empty($nouveaurolepedago)) {
                    // Requête préparée pour la mise à jour
                    $sqlep = "UPDATE `pedagogie` SET `nom_pedagogie`=?, `prenom_pedagogie`=?, `mail_pedagogie`=?, `num_pedagogie`=?, `id_role`=? WHERE `id_pedagogie` = ?";
                    $requete = $bdd->prepare($sqlep);
                    // Exécution de la requête en passant les valeurs comme paramètres
                    $requete->execute([$nouveauNomep, $nouveauPrenomep, $nouveauMailep, $nouveauNumeroep, $nouveaurolepedago, $IDpedagogie]);
            
                    echo "Un Membre de l'Equipe Pédagogique a été modifié dans la base de données.";
                } else {
                    echo "Certains champs sont vides.";
                }
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
            
                    if (isset($_POST['supprimerMembreep'])) {
                        // Récupération de l'identifiant du membre de l'équipe pédagogique et échappement XSS
                        $IDpedagogie = isset($_POST['IDpedagogie']) ? $_POST['IDpedagogie'] : '';
                    
                        // Vérification si l'identifiant n'est pas vide
                        if (!empty($IDpedagogie)) {
                            // Requête préparée pour la suppression
                            $sqlep = "DELETE FROM `pedagogie` WHERE `id_pedagogie`= ?";
                            $requete = $bdd->prepare($sqlep);
                            // Exécution de la requête en passant l'IDpedagogie comme paramètre
                            $requete->execute([$IDpedagogie]);
                    
                            echo "Le Membre de l'équipe Pédagogique a été supprimé de la base de données.";
                        }
                    }
        } 
    } 
}