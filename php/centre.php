
<?php
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

        $villeCentre = isset($_POST['villeCentre']) ? htmlspecialchars($_POST['villeCentre']) : '';
        $adresseCentre = isset($_POST['adresseCentre']) ? htmlspecialchars($_POST['adresseCentre']) : '';
        $cpCentre = isset($_POST['cpCentre']) ? htmlspecialchars($_POST['cpCentre']) : '';

        if (!empty($villeCentre) && !empty($adresseCentre) && !empty($cpCentre)) {
            // Requête préparée pour l'insertion
            $sqlcentre = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (:villeCentre, :adresseCentre, :cpCentre)";
            $requete = $bdd->prepare($sqlcentre);
            // Liaison des paramètres
            $requete->bindParam(':villeCentre', $villeCentre);
            $requete->bindParam(':adresseCentre', $adresseCentre);
            $requete->bindParam(':cpCentre', $cpCentre);
            // Exécution de la requête
            $requete->execute();

            echo "Données ajoutées dans la base de données.";
        } else {
            echo "Certains champs sont vides.";
        }
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
                        // Récupération et échappement des données
                        $IDcentre = isset($_POST['IDcentre']) ? htmlspecialchars($_POST['IDcentre']) : '';
                        $nouvelVilleCentre = isset($_POST['nouvelVilleCentre']) ? htmlspecialchars($_POST['nouvelVilleCentre']) : '';
                        $nouvelAdresseCentre = isset($_POST['nouvelAdresseCentre']) ? htmlspecialchars($_POST['nouvelAdresseCentre']) : '';
                        $nouveauCentreCp = isset($_POST['nouveauCentreCp']) ? htmlspecialchars($_POST['nouveauCentreCp']) : '';
                    
                        // Vérification si les champs ne sont pas vides
                        if (!empty($IDcentre) && !empty($nouvelVilleCentre) && !empty($nouvelAdresseCentre) && !empty($nouveauCentreCp)) {
                            // Requête préparée pour la mise à jour
                            $sqlcentre = "UPDATE `centres` SET `ville_centre`=:nouvelVilleCentre, `adresse_centre`=:nouvelAdresseCentre, `code_postal_centre`=:nouveauCentreCp WHERE `id_centre` = :IDcentre";
                            $requete = $bdd->prepare($sqlcentre);
                            // Liaison des paramètres
                            $requete->bindParam(':IDcentre', $IDcentre);
                            $requete->bindParam(':nouvelVilleCentre', $nouvelVilleCentre);
                            $requete->bindParam(':nouvelAdresseCentre', $nouvelAdresseCentre);
                            $requete->bindParam(':nouveauCentreCp', $nouveauCentreCp);
                            // Exécution de la requête
                            $requete->execute();
                    
                            echo "Le Centre a été modifié dans la base de données.";
                        } else {
                            echo "Certains champs sont vides.";
                        }
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
                
                        if (isset($_POST['supprimerCentre'])) {
                            // Récupération et échappement des données
                            $IDcentre = isset($_POST['IDcentre']) ? htmlspecialchars($_POST['IDcentre']) : '';
                        
                            // Vérification si l'identifiant du centre n'est pas vide
                            if (!empty($IDcentre)) {
                                // Requête préparée pour la suppression
                                $sqlcentre = "DELETE FROM `centres` WHERE `id_centre`= ?";
                                $requete = $bdd->prepare($sqlcentre);
                                // Exécution de la requête en passant l'IDcentre comme paramètre
                                $requete->execute([$IDcentre]);
                        
                                echo "Le Centre a été supprimé de la base de données.";
                            }
            } 
        } 
    }
}
