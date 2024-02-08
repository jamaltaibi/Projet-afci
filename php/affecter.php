
<?php
if(isset($_GET["page"]) && $_GET["page"] == "affecter" ){

    $sqlp = "SELECT * FROM pedagogie";
    $requetep = $bdd->query($sqlp);
    $resultsp = $requetep->fetchAll(PDO::FETCH_ASSOC);

    $sqlc = "SELECT * FROM centres";
    $requetec = $bdd->query($sqlc);
    $resultsc = $requetec->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <h1 class="titre">Ajouter une affectation</h1>
        <div class="affectationajout">
                <form method="POST">
                    <label> Id Pedagogie </label>
                    <select name="affecterIdpedago" id="">
                    <?php      
                        foreach( $resultsp as $value ){             
                            echo '<option value="' . htmlspecialchars($value['id_pedagogie']) .  '">' . htmlspecialchars($value['id_pedagogie']) . ' - ' . htmlspecialchars($value['nom_pedagogie']) . '</option>';   
                        }
                    ?>
                    </select>
                    <label> Id Centre </label>
                    <select name="affecterIdrole" id="">
                    <?php      
                        foreach( $resultsc as $value ){             
                            echo '<option value="' . htmlspecialchars($value['id_centre']) .  '">' . htmlspecialchars($value['id_centre']) . ' - ' . htmlspecialchars($value['ville_centre']) . '</option>';   
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
                <td> <?php echo htmlspecialchars($value["id_pedagogie"]) .'-'. htmlspecialchars($value["nom_pedagogie"]) ?> </td>
                <td> <?php echo htmlspecialchars($value["id_centre"]) .'-'. htmlspecialchars($value["ville_centre"]) ?> </td>
                <td>
                    <form method="POST" action="?page=affecter&type=supprimer">
                        <input type="hidden" name="suppaffectPedago" value="<?php echo htmlspecialchars($value['id_pedagogie'] );?>">
                        <input type="hidden" name="suppaffectCentre" value="<?php echo htmlspecialchars($value['id_centre'] );?>">
                        <input type="submit" name="suppAffect" value="Supprimer">








                        
                    </form>
                </td>
            </tr>
        <?php
            } 
        ?>
            </table>
        <?php
        if (isset($_GET['type']) && $_GET['type'] == 'supprimer') {

                if (isset($_POST['suppaffectPedago']) && isset($_POST['suppaffectCentre'])) {
                    echo "Vous etes sur le point de supprimer les affectations";

                    $suppaffectPedago = $_POST['suppaffectPedago'];
                    $suppaffectCentre = $_POST['suppaffectCentre'];
                    
                    // Création du formulaire de confirmation de suppression
                    echo "<form method='POST'>
                        <input type='hidden' name='Idpedagosupp' value='" . $suppaffectPedago . "'>
                        <input type='hidden' name='Idcentresupp' value='" . $suppaffectCentre . "'>
                        <input type='submit' name='supprimeraffect' value='Supprimer'> 
                    </form>";
            
                } 

            if (isset($_POST['supprimeraffect'])){
                
                $Idpedagosupp = $_POST['Idpedagosupp'];
                $Idcentresupp = $_POST['Idcentresupp'];

                $sqlaffectation = "DELETE FROM `affecter` WHERE `id_pedagogie`= :id_pedagogie AND `id_centre`= :id_centre";
                $requete = $bdd->prepare($sqlaffectation);

                $requete->bindParam(':id_pedagogie', $Idpedagosupp, PDO::PARAM_INT);
                $requete->bindParam(':id_centre', $Idcentresupp, PDO::PARAM_INT);

                $requete->execute();

                echo "Les affectation ont été supprimé de la base de données.";

            }
        
    }
}
?>
