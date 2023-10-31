<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Accueil</title>
</head>
<body>
    <h1>Bienvenue sur e-Taxi Bokko</h1>

    <?php
require_once('database.php'); 
require_once('class_user.php'); 

$user = new User(@$prenom_l, @$nom_l, null, null, null, null, null, null);

$liste_users = $user->afficher_liste($mydatabase);

if (!empty($liste_users)) {
    echo '<h1>Liste des utilisateurs</h1>';
    echo '<ul>';
    foreach ($liste_users as $utilisateur) {
        echo '<li>' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . '</li>';
    }
    echo '</ul>';
} else {
    echo 'Aucun utilisateur à afficher.';
}
?>

    
</body>
</html>