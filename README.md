<?php
                         

$fichier = "personnes.json";
$personnes = [];


if (file_exists($fichier)) {
    $json = file_get_contents($fichier);
    $personnes = json_decode($json, true) ?? [];
} else {
    $personnes = [];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST['prenom']);
    $nom    = trim($_POST['nom']);
    $adr    = trim($_POST['adr']);
    $tel    = trim($_POST['tel']);

    if ($prenom && $nom && $adr && $tel) {
        // Nouvelle personne
        $nouvellePersonne = [
            "prenom" => $prenom,
            "nom"    => $nom,
            "adr"    => $adr,
            "tel"    => $tel
        ];

        
        $personnes[] = $nouvellePersonne;

      
        file_put_contents($fichier, json_encode($personnes, JSON_PRETTY_PRINT));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP2</title>
     <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<!--
chaque personne est ajoute dans un fichier apple personnes.json et dans un tableau personnes 
afficher le tableau personnes dans le table -->
    <h1 class="text-center text-primary">TP Form & Table</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form method="post">
                        <div class="card-header">Ajout Personne</div>
                        <div class="card-body">
                            <div>
                                <label for="prenom">Prénom</label>
                                <input class="form-control" type="text" name="prenom" id="prenom">
                            </div>
                            <div>
                                <label for="nom">Nom</label>
                                <input class="form-control" type="text" name="nom" id="nom">
                            </div>
                            <div>
                                <label for="adr">Adresse</label>
                                <input class="form-control" type="text" name="adr" id="adr">
                            </div>
                            <div>
                                <label for="tel">Téléphone</label>
                                <input class="form-control" type="text" name="tel" id="tel">
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Liste des personnes</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>

                                <th>#</th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                            </tr>
                            <?php 
$i = 1;
if (!empty($personnes)) {
    foreach ($personnes as $p): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($p['prenom'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['nom'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['adr'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['tel'] ?? '') ?></td>
        </tr>
    <?php endforeach;
} else {
    echo '<tr><td colspan="5" class="text-center text-muted">Aucune personne enregistrée.</td></tr>';
}
?>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
           
            
</body>
</html>
