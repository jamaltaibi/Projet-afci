
<?php
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