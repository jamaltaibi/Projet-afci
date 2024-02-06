
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