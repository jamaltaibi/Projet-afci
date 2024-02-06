
<?php
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