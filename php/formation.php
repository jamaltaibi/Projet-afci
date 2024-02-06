

<?php
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