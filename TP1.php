<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP2 Form & Table</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<!-- 
   - Chaque personne est ajouté dans un fichier appelé personnes.json et dans un tableau personnes
   - Afficher le tableau personnes dans le table
-->


<?php
// Déclarer le tableau de toutes les personnes
$tabPersonnes = [];
// Lire le fichier json 
$jsonFileContent = file_get_contents("personnes.json");
// Mettre le contenu du fichier json dans le tableau $tabPersonnes
$tabPersonnes = json_decode($jsonFileContent,true); // Convertir le contenu json en tableau associatif
             
//Ajout dans le tableau
if (isset($_POST['btnAjout'])) { // Vérifier si la clé btnAjout existe dans le tableau $_POST (Si on a cliqué sur le bouton Ajouter)
    //   Recupération des valeurs des champs du formulaire
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adr'];

    //    Créer un tableau associatif pour une seule personne
    $personne = [
        "prenom" => $prenom,
        "nom" => $nom,
        "tel" => $tel,
        "adresse" => $adresse
    ];
    //  json = java script object notation
          if (isset($_GET['indiceM'])) {
            $indice= $_GET['indiceM'];
            $tabPersonnes[$indice]= $personne;
          }
          else {
              // Ajouter la nouvelle personne dans le tableau
                $tabPersonnes[] = $personne;  
          }
    
    // Reconvertir le tableau en json
    $nouveauJson = json_encode($tabPersonnes, JSON_PRETTY_PRINT);
    // Reecrire dans le fichier
    file_put_contents("personnes.json", $nouveauJson);
    header("location: TP1.php");
} 
    //Suppression dans le tableau
 if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
   $newtab= array_splice($tabPersonnes, $indice, 1); //permet de supprimmer un élement au niveau de l'indice spécifié et de rétourner le nouveua tableau

    $nouveauJson = json_encode($tabPersonnes, JSON_PRETTY_PRINT);
    file_put_contents("personnes.json", $nouveauJson);
    //Redirection vers la page
    header("location: TP1.php");
 }
       
   //Modification dans le tableau
   $per_a_modifier=[];
   if (isset($_GET['indiceM'])) {
    $indice= $_GET['indiceM']; //récuperer l'indice de la personne
    $per_a_modifier= $tabPersonnes[$indice]; //récuperer la personne dans le tableau 
     
    
   }
?>

<body>
    <h1 class="text-center text-primary">TP Form & Table</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form method="post">
                        <div class="card-header bg-primary text-white text-uppercase">Ajout Personne</div>
                        <div class="card-body">
                            <div>
                                <label for="prenom">Prénom</label>
                                <input  value="<?= isset($_GET['indiceM']) ? $per_a_modifier['prenom'] : '' ?>"  class="form-control" type="text" name="prenom" id="prenom">
                            </div>
                            <div>
                                <label for="nom">Nom</label>
                                <input value="<?= isset($_GET['indiceM']) ? $per_a_modifier['nom'] : '' ?>" class="form-control" type="text" name="nom" id="nom">
                            </div>
                            <div>
                                <label for="adr">Adresse</label>
                                <input value="<?= isset($_GET['indiceM']) ? $per_a_modifier['adresse'] : '' ?>"  class="form-control" type="text" name="adr" id="adr">
                            </div>
                            <div>
                                <label for="tel">Téléphone</label>
                                <input value="<?= isset($_GET['indiceM']) ? $per_a_modifier['tel'] : '' ?>"  class="form-control" type="text" name="tel" id="tel">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary" name="btnAjout">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white text-uppercase">Liste des personnes</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($tabPersonnes as $key => $pers) {  ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $pers['prenom'] ?></td>
                                    <td><?= $pers['nom'] ?></td>
                                    <td><?= $pers['adresse'] ?></td>
                                    <td><?= $pers['tel'] ?></td>
                                    <td>
                                        <a class=" btn btn-sm btn-warning" href="?indiceM=<?= $key ?>">Modifier </a>
                                        <a onclick="return confirm('voulez vous supprimmer cette personne ?')" class=" btn btn-sm btn-danger" href="?indice=<?= $key ?>">Suprimmer</a>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>


</html>