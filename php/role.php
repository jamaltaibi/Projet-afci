
<?php

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

        $nomRole = isset($_POST['nomRole']) ? htmlspecialchars($_POST['nomRole']) : '';

        if (!empty($nomRole)) {

        $sqlrole = "INSERT INTO `role`(`nom_role`) VALUES (:nomRole)";
        $requete = $bdd->prepare($sqlrole);
        $requete->bindParam(':nomRole', $nomRole);
        $requete->execute();

        echo "Données ajoutée dans la bdd";
    } else{
        echo "Le nom du rôle est vide ou non défini";
    }
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
                      <input type='hidden' name='idrole' value='" . htmlspecialchars($role['id_role']) . "'>
                      <input type='text' name='nouveauNomRole' value='" . htmlspecialchars($role['nom_role']) . "'>
                      <input type='submit' name='modifierRole' value='Modifier'>
                  </form>";
    
            if (isset($_POST['modifierRole'])) {
                
                $idrole = isset($_POST['idrole']) ? intval($_POST['idrole']) : 0;
                $nouveauNomRole = isset($_POST['nouveauNomRole']) ? htmlspecialchars($_POST['nouveauNomRole']) : '';
    
                if ($idrole > 0 && !empty($nouveauNomRole)) {
                    $sql = "UPDATE role SET nom_role = :nouveauNomRole WHERE id_role = :idrole";
                    $requete = $bdd->prepare($sql);
        
                    $requete->bindParam(':nouveauNomRole', $nouveauNomRole);
                    $requete->bindParam(':idrole', $idrole);
        
                    $requete->execute();
        
                    echo "Le rôle a été modifié dans la base de données.";
                    } else {
                    echo "Les données entrées sont invalides.";
                }
            }
        }
    }      
}