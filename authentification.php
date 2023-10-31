<?php



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="authentification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <title>Page d'Authentification e-Taxi Bokko</title>
</head>

<body>
    <div class="container">
        <!-- <div class="authentication"> -->
        <div class="auth-section2">
            <h1 class="title_page">Bienvenue</h1>
            <p>Faites votre inscription en renseignant les informations nécessaires.</p>
            <form action="class_user.php" method="post">
                <div class="name-inputs">
                    <div class="name">
                        <label for="firstname">Prénom</label>
                        <input class="input2" type="text" name="prenoms" id="firstname" placeholder="Votre prénom" value="<?php echo isset($_POST['prenoms']) ? $_POST['prenoms'] : ''; ?>" required/>

                        <?php if (isset($errors['prenom'])) { ?>
                            <p class="erreur"><?php echo $errors['prenom']; ?></p>
                        <?php } ?>

                    </div>
                    <div class="name">
                        <label for="lastname">Nom</label>
                        <input class="input2" type="text" name="nom" id="lastname" placeholder="Votre nom" value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : ''; ?>" required>
                    
                        <?php if (isset($errors['nom'])) { ?>
                            <p class="erreur"><?php echo $errors['nom']; ?></p>
                        <?php } ?>

                    </div>
                </div>
                <label for="email">Email</label>
                <input class="input1" type="email" id="email" name="email_signup" placeholder="Saisissez votre email" value="<?php echo isset($_POST['email_signup']) ? $_POST['email_signup'] : ''; ?>" required>
                <?php if (isset($errors['email'])) { ?>
                            <p class="erreur"><?php echo $errors['email']; ?></p>
                        <?php } ?>

                <label for="phone">Téléphone</label>
                <input class="input2" type="tel" id="phone" name="phone" placeholder="Numéro de téléphone (Sénégal)" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
                <?php if (isset($errors['phone'])) { ?>
                            <p class="erreur"><?php echo $errors['phone']; ?></p>
                        <?php } ?>
                <div class="password_inputs">
                    <div class="password">
                        <label for="password1">Mot de passe</label>
                        <input class="input1" type="password" id="password1" name="password_signup" placeholder="Entrez votre mot de passe"  value="<?php echo isset($_POST['password_signup']) ? $_POST['password_signup'] : ''; ?>" required>
                        <?php if (isset($errors['password_signup'])) { ?>
                            <p class="erreur"><?php echo $errors['password_signup']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="password_confirm">
                        <label for="password2">Confirmer Mot de passe</label>
                        <input class="input1" type="password" id="password2" name="password_confirm" placeholder="Entrez le même mot de passe"  value="<?php echo isset($_POST['password_confirm']) ? $_POST['password_confirm'] : ''; ?>" required>
                        <?php if (isset($errors['password_confirm'])) { ?>
                            <p class="erreur"><?php echo $errors['password_confirm']; ?></p>
                        <?php } ?>
                    
                    </div>
                </div>
                <div>
                    <label for="adresse">Adresse </label>
                    <input class="input1" type="text" id="adresse" name="user_adress" placeholder="Votre adresse: Région, Ville et Quartier... " value="<?php echo isset($_POST['user_adress']) ? $_POST['password_confirm'] : ''; ?>" required>
                    <?php if (isset($errors['user_adress'])) { ?>
                            <p class="erreur"><?php echo $errors['user_adress']; ?></p>
                        <?php } ?>
                </div>
                <div class="last_part">
                    <label> <i class="fa-solid fa-gift"></i> Ajouter un code promo</label>
                    <input type="submit" name="sinscrire" class="signup-btn" value="S'inscrire">
                </div>
            </form>
        </div>

        <div class="auth-section1">
            <h1 class="title_page">Connexion</h1>
            <p>Votre chauffeur en un clic !</p>
            <button class="facebook-btn">Continuer avec Facebook</button>
            <div class="separator">OU</div>
            <form action="class_user.php" method="post">
                <label for="email">Email</label>
                <input class="input1" type="email" id="email" name="email_signin" placeholder="Saisissez votre email">
                <label for="password">Mot de passe</label>
                <input class="input1" type="password" id="password" name="password_signin" placeholder="Entrez votre mot de passe">
                <div class="options">
                    <span class="text_simple">J'ai déjà un compte</span>
                    <input type="submit" name="seconnecter" class="signup-btn" value="Se connecter">
                </div>
            </form>
        </div>
        <!-- </div> -->
    </div>
</body>

</html>


<?php

/*

    public function inscription() {
        $database = new Database_connect("etaxibokko_poo", "localhost", "root", "");
        $requete_db = $database->getPDO()->query('INSERT INTO user_etaxibokko( prenom, nom, email, phone, pass, pass_conf, adress, date_insc) 
        VALUES (:prenom, :nom, :email, :phone, :pass, :pass_conf, :adress, :date_insc)');
        $stmt= $pdo->prepare($requete_db) ;

        if ($stmt) {
            [
                ":prenom" => $this->prenom,
                ":nom" => $this->nom,
                ":email" => $this->email,
                ":phone" => $this->phone,
                ":pass" => $this->pass,
                ":pass_conf" => $this->pass_conf,
                ":adress" => $this->adress,
                
            ];
        }
       
        $stmt->execute(
            $this->prenom, $this->nom, $this->email,
            $this->phone, md5($this->pass), md5($this->pass_conf),
            $this->adress );

            echo "Les données renseignées dans le formulaire ont été insérées dans la base de donnée.";
         else {
            echo 'Erreur, les données ne sont pas transmises.';
        }
    
    }


    if (isset($_POST['sinscrire'])) {

        $prenom_u = $_POST['prenoms'];
        $nom_u = $_POST['nom'];
        $email_u = $_POST['email_signup'];
        $phone_u = $_POST['phone'];
        $pass_u = $_POST['password_signup'];
        $pass_conf_u = $_POST['password_confirm'];
        $adress_u = $_POST['user_adress'];
*/






?>