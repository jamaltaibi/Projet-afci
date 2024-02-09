
<?php
if(isset($_GET["page"]) && $_GET["page"] == "apprenants" ){

    $resultsr = getRows($bdd, "role");
    $resultss = getRows($bdd, "session");


    $sql = "SELECT `apprenants`.`id_apprenant`,`apprenants`.`nom_apprenant`, `apprenants`.`prenom_apprenant`,`apprenants`.`mail_apprenant`,`apprenants`.`adresse_apprenant`,`apprenants`.`ville_apprenant`,`apprenants`.`code_postal_apprenant`,`apprenants`.`tel_apprenant`,`apprenants`.`date_naissance_apprenant`,`apprenants`.`niveau_apprenant`,`apprenants`.`num_PE_apprenant`,`apprenants`.`num_secu_apprenant`,`apprenants`.`rib_apprenant`,
    `role`.`id_role`,`role`.`nom_role`,`session`.`id_session`,`session`.`nom_session` 
    FROM `apprenants` 
    left JOIN `role` on `apprenants`.id_role = `role`.id_role
    left JOIN `session` on `apprenants`.`id_session` = `session`.id_session";

    $requete = $bdd->query($sql);
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Liste des Apprenants :</h1>";
    
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
        <h2 class="titre">Ajouter un Apprenant</h2>
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

if (isset($_POST['submitApprenant'])) {
    // Récupération des données et échappement XSS
    $nomApprenant = isset($_POST['nomApprenant']) ? htmlspecialchars($_POST['nomApprenant']) : '';
    $prenomApprenant = isset($_POST['prenomApprenant']) ? htmlspecialchars($_POST['prenomApprenant']) : '';
    $mailApprenant = isset($_POST['mailApprenant']) ? htmlspecialchars($_POST['mailApprenant']) : '';
    $adresseApprenant = isset($_POST['adresseApprenant']) ? htmlspecialchars($_POST['adresseApprenant']) : '';
    $villeApprenant = isset($_POST['villeApprenant']) ? htmlspecialchars($_POST['villeApprenant']) : '';
    $cpApprenant = isset($_POST['cpApprenant']) ? htmlspecialchars($_POST['cpApprenant']) : '';
    $telApprenant = isset($_POST['telApprenant']) ? htmlspecialchars($_POST['telApprenant']) : '';
    $datenaissanceApprenant = isset($_POST['datenaissanceApprenant']) ? $_POST['datenaissanceApprenant'] : '';
    $niveauApprenant = isset($_POST['niveauApprenant']) ? htmlspecialchars($_POST['niveauApprenant']) : '';
    $numpeApprenant = isset($_POST['numpeApprenant']) ? htmlspecialchars($_POST['numpeApprenant']) : '';
    $numsecuApprenant = isset($_POST['numsecuApprenant']) ? htmlspecialchars($_POST['numsecuApprenant']) : '';
    $ribApprenant = isset($_POST['ribApprenant']) ? htmlspecialchars($_POST['ribApprenant']) : '';
    $Idroleapprenant = isset($_POST['Idroleapprenant']) ? $_POST['Idroleapprenant'] : '';
    $idsessionapprenant = isset($_POST['idsessionapprenant']) ? $_POST['idsessionapprenant'] : '';

    // Vérification si les champs ne sont pas vides
    if (!empty($nomApprenant) && !empty($prenomApprenant) && !empty($mailApprenant) && !empty($adresseApprenant) && !empty($villeApprenant) && !empty($cpApprenant) && !empty($telApprenant) && !empty($datenaissanceApprenant) && !empty($niveauApprenant) && !empty($numpeApprenant) && !empty($numsecuApprenant) && !empty($ribApprenant) && !empty($Idroleapprenant) && !empty($idsessionapprenant)) {
        // Requête préparée pour l'insertion d'apprenant
        $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $requete = $bdd->prepare($sql);
        // Exécution de la requête en passant les valeurs comme paramètres
        $requete->execute([$nomApprenant, $prenomApprenant, $mailApprenant, $adresseApprenant, $villeApprenant, $cpApprenant, $telApprenant, $datenaissanceApprenant, $niveauApprenant, $numpeApprenant, $numsecuApprenant, $ribApprenant, $Idroleapprenant, $idsessionapprenant]);

        echo "Données ajoutées dans la base de données.";
    } else {
        echo "Certains champs sont vides.";
    }
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
                    // Récupération des données et échappement XSS
                    $IDapprenant = isset($_POST['nouvelIDapprenant']) ? $_POST['nouvelIDapprenant'] : '';
                    $nouveaunomApprenant = isset($_POST['nouveaunomApprenant']) ? htmlspecialchars($_POST['nouveaunomApprenant']) : '';
                    $nouveauprenomApprenant = isset($_POST['nouveauprenomApprenant']) ? htmlspecialchars($_POST['nouveauprenomApprenant']) : '';
                    $nouveaumailApprenant = isset($_POST['nouveaumailApprenant']) ? htmlspecialchars($_POST['nouveaumailApprenant']) : '';
                    $nouveladresseApprenant = isset($_POST['nouveladresseApprenant']) ? htmlspecialchars($_POST['nouveladresseApprenant']) : '';
                    $nouvelvilleApprenant = isset($_POST['nouvelvilleApprenant']) ? htmlspecialchars($_POST['nouvelvilleApprenant']) : '';
                    $nouveaucpApprenant = isset($_POST['nouveaucpApprenant']) ? htmlspecialchars($_POST['nouveaucpApprenant']) : '';
                    $nouveautelApprenant = isset($_POST['nouveautelApprenant']) ? htmlspecialchars($_POST['nouveautelApprenant']) : '';
                    $nouveldatenaissanceApprenant = isset($_POST['nouveldatenaissanceApprenant']) ? $_POST['nouveldatenaissanceApprenant'] : '';
                    $nouveauniveauApprenant = isset($_POST['nouveauniveauApprenant']) ? htmlspecialchars($_POST['nouveauniveauApprenant']) : '';
                    $nouveaunumpeApprenant = isset($_POST['nouveaunumpeApprenant']) ? htmlspecialchars($_POST['nouveaunumpeApprenant']) : '';
                    $nouveaunumsecuApprenant = isset($_POST['nouveaunumsecuApprenant']) ? htmlspecialchars($_POST['nouveaunumsecuApprenant']) : '';
                    $nouveauribApprenant = isset($_POST['nouveauribApprenant']) ? htmlspecialchars($_POST['nouveauribApprenant']) : '';
                    $newIdroleapprenant = isset($_POST['newIdroleapprenant']) ? $_POST['newIdroleapprenant'] : '';
                    $newidsessionapprenant = isset($_POST['newidsessionapprenant']) ? $_POST['newidsessionapprenant'] : '';
                
                    // Vérification si les champs ne sont pas vides
                    if (!empty($IDapprenant) && !empty($nouveaunomApprenant) && !empty($nouveauprenomApprenant) && !empty($nouveaumailApprenant) && !empty($nouveladresseApprenant) && !empty($nouvelvilleApprenant) && !empty($nouveaucpApprenant) && !empty($nouveautelApprenant) && !empty($nouveldatenaissanceApprenant) && !empty($nouveauniveauApprenant) && !empty($nouveaunumpeApprenant) && !empty($nouveaunumsecuApprenant) && !empty($nouveauribApprenant) && !empty($newIdroleapprenant) && !empty($newidsessionapprenant)) {
                        // Requête préparée pour la modification d'apprenant
                        $sqlapprenant = "UPDATE `apprenants` SET `nom_apprenant`=?, `prenom_apprenant`=?, `mail_apprenant`=?, `adresse_apprenant`=?, `ville_apprenant`=?, `code_postal_apprenant`=?, `tel_apprenant`=?, `date_naissance_apprenant`=?, `niveau_apprenant`=?, `num_PE_apprenant`=?, `num_secu_apprenant`=?, `rib_apprenant`=?, `id_role`=?, `id_session`=? WHERE `id_apprenant` = ?";
                        $requete = $bdd->prepare($sqlapprenant);
                        // Exécution de la requête en passant les valeurs comme paramètres
                        $requete->execute([$nouveaunomApprenant, $nouveauprenomApprenant, $nouveaumailApprenant, $nouveladresseApprenant, $nouvelvilleApprenant, $nouveaucpApprenant, $nouveautelApprenant, $nouveldatenaissanceApprenant, $nouveauniveauApprenant, $nouveaunumpeApprenant, $nouveaunumsecuApprenant, $nouveauribApprenant, $newIdroleapprenant, $newidsessionapprenant, $IDapprenant]);
                
                        echo "L'Apprenant a été modifié dans la base de données.";
                    } else {
                        echo "Certains champs sont vides.";
                    }
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
        
                if (isset($_POST['supprimerApprenant'])) {
                    // Récupération de l'ID de l'apprenant
                    $IDapprenant = isset($_POST['IDapprenant']) ? $_POST['IDapprenant'] : '';
                
                    // Vérification si l'ID de l'apprenant n'est pas vide
                    if (!empty($IDapprenant)) {
                        // Requête préparée pour la suppression de l'apprenant
                        $sqlapprenant = "DELETE FROM `apprenants` WHERE `id_apprenant` = ?";
                        $requete = $bdd->prepare($sqlapprenant);
                        // Exécution de la requête en passant l'ID de l'apprenant comme paramètre
                        $requete->execute([$IDapprenant]);
                
                        echo "L'Apprenant a été supprimé de la base de données.";
                    } else {
                        echo "L'ID de l'apprenant est vide.";
                    }
                }
        } 
    }  
}