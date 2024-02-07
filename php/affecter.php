
<?
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
                <form method="POST">
                    <label> Id Pedagogie </label>
                    <select name="affecterIdpedago" id="">
                    <?php      
                        foreach( $resultsp as $value ){             
                            echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                        }
                    ?>
                    </select>
                    <label> Id Centre </label>
                    <select name="affecterIdrole" id="">
                    <?php      
                        foreach( $resultsc as $value ){             
                            echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                        }
                    ?>
                    </select>
                    <input type="submit" name="submitAffectation" value="Enregistrer">
                </form>
        </div>
<?php

    if (isset($_POST['submitAffectation'])) {
    // Récupération des données et échappement XSS
    $affecterIdpedago = isset($_POST['affecterIdpedago']) ? $_POST['affecterIdpedago'] : '';
    $affecterIdrole = isset($_POST['affecterIdrole']) ? $_POST['affecterIdrole'] : '';

    // Vérification si les valeurs ne sont pas vides
    if (!empty($affecterIdpedago) && !empty($affecterIdrole)) {
        // Requête préparée pour l'insertion d'une affectation
        $sqlaffecter = "INSERT INTO `affecter`(`id_pedagogie`, `id_centre`) VALUES (?, ?)";
        $requete = $bdd->prepare($sqlaffecter);
        // Exécution de la requête en passant les valeurs comme paramètres
        $requete->execute([$affecterIdpedago, $affecterIdrole]);

        echo "Data ajoutée dans la base de données.";
    } else {
        echo "Certains champs sont vides.";
    }
}

    $sqlaffect = "SELECT `affecter`.`id_pedagogie`,`affecter`.`id_centre`,`pedagogie`.`id_pedagogie`,`pedagogie`.`nom_pedagogie`,`centres`.`id_centre`,`centres`.`ville_centre`
    FROM `affecter`
    LEFT JOIN `pedagogie` ON `affecter`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
    LEFT JOIN `centres` ON `affecter`.`id_centre` = `centres`.`id_centre`";
    $requeteaffect = $bdd->query($sqlaffect);
    $resultsaffect = $requeteaffect->fetchAll(PDO::FETCH_ASSOC);

?>
        <h2>Liste des Affectation :</h2>
            <table border='1'>
            <tr> <th>ID Pedagogie - Nom</th> <th>ID Centre - Ville</th> </tr>
        <?php
        foreach( $resultsaffect as $value ){
            // var_dump($value);
            // echo $value["id_role"] . " - " . $value["nom_role"] . " " . "<br>"; 
        ?>
            <tr>
                <td> <?php echo $value["id_pedagogie"] .'-'. $value["nom_pedagogie"] ?> </td>
                <td> <?php echo $value["id_centre"] .'-'. $value["ville_centre"] ?> </td>
                <td>
                    <form method="POST" action="?page=affecter&type=modifier">
                        <input type="hidden" name="modifaffectPedago" value="<?php echo $value['id_pedagogie'];?>">
                        <input type="hidden" name="modifaffectCentre" value="<?php echo $value['id_centre'];?>">
                       <input type="submit" name="modifAffect" value="Modifier">
                    </form>
                </td>
                <td>
                    <form method="$_POST" action="?page=affecter&type=supprimer">
                        <input type="hidden" name="suppaffectPedago" value="<?php $value['id_pedagogie'];?>">
                        <input type="hidden" name="suppaffectCentre" value="<?php $value['id_centre'];?>">
                        <input type="submit" name="suppAffect" value="Supprimer">
                    </form>
                </td>
            </tr>
<?php 
            } 
?>
            </table>
<?php
            
        if (isset($_GET['type']) && $_GET['type'] == 'modifier') {
            if(isset($_POST["modifaffectPedago"])&& isset($_POST["modifaffectCentre"])){
                $modifaffectPedago = $_POST['modifaffectPedago'];
                $modifaffectCentre = $_POST['modifaffectCentre'];

                echo "<h1 class='titre'>Modification de l'affectation</h1>";
                echo "<form method='POST'>
                        <label> Nouvel Affectation </label>";
                ?>
                <input type='hidden' name='nouvelIDpedago' value=' <?php echo $affecter['id_pedagogie']?>'>
                <label> Id Pedagogie </label>
                <select name="affecterIdpedago">
                <?php      
                foreach( $resultsp as $value ){             
                    echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';   
                    }
                    ?>
                </select>
                <input type='hidden' name='nouvelIDcentre' value=' <?php echo $affecter['id_centre']?>'>
                <label> Id Centre </label>
                <select name="affecterIdcentre">
                <?php      
                foreach( $resultsc as $value ){             
                    echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';   
                    }
?>
                </select>
<?php
                    echo"<input type='submit' name='modifierAffectation' value='Modifier'>
                </form>";
            if (isset($_POST['modifierAffectation'])) {
                $nouvelIDpedago = $_POST['nouvelIDpedago'];
                $nouvelIDcentre = $_POST['nouvelIDcentre'];
                $affecterIdpedago = $_POST['affecterIdpedago'];
                $affecterIdcentre = $_POST['affecterIdcentre'];
    
                $sqlmodif = "UPDATE `affecter` SET `id_pedagogie`='$affecterIdpedago',`id_centre`='$affecterIdcentre' WHERE `id_pedagogie`= '$nouvelIDpedago' AND `id_centre`= '$nouvelIDcentre' ";
                $bdd->query($sqlmodif);
                echo "Le rôle a été modifié dans la base de données.";
                }
            }
        }
        if (isset($_GET['type']) && $_GET['type'] == 'supprimer') {
            if(isset($_POST["suppaffectPedago"])&& isset($_POST["suppaffectCentre"])){
                echo 'sur le point de supprimer';
                $suppaffectPedago = $_POST['suppaffectPedago'];
                $suppaffectCentre = $_POST['suppaffectCentre'];
            
            echo "Vous etes sur le point de supprimer une formation";
            echo "<form method='POST'>
                    <input type='hidden' name='Idpedago' value='" . $suppaffectPedago . "'>
                    <input type='hidden' name='Idcentre' value='" . $suppaffectCentre . "'>
                    <input type='submit' name='supprimeraffect' value='Supprimer'> 
                </form>";
                
            if (isset($_POST['supprimeraffect'])){
                $Idpedago = $_POST['Idpedago'];
                $Idcentre = $_POST['Idcentre'];

                $sqlaffectation = "DELETE FROM `affecter` WHERE `id_pedagogie`= $Idpedago AND `id_centre`= $Idcentre ";
                $bdd->query($sqlaffectation);
                echo "La Formation a été supprimé de la base de données.";

            }
        }                   
    }
}
?>
