<?php

require_once('database.php');
$errors = [];


class User {

    private $prenom;
    private $nom;
    private $email;
    private $phone;
    private $pass;
    private $pass_conf;
    private $adress;
    private $date;

    function __construct($prenom_u, $nom_u, $email_u, $phone_u, $pass_u, $pass_conf_u, $adress_u, $date_u)
    {

        $this->prenom = $prenom_u;
        $this->nom = $nom_u;
        $this->email = $email_u;
        $this->phone = $phone_u; 
        $this->pass = $pass_u ;
        $this->pass_conf = $pass_conf_u;
        $this->adress = $adress_u ;
        $this->date = $date_u; 
   
    }

    // Getteurs 

    public function getPrenom() {return $this->prenom;}
    public function getNom() {return $this->nom;}
    public function getEmail() {return $this->email;}
    public function getPhone() {return $this->phone;}
    public function getPass() {return $this->pass;}
    public function getPass_conf() {return $this->pass_conf; }
    public function getAdress() {return $this->adress;}
    public function getDate() {return $this->date;}


    // Setteurs et Vérification 

    public function setPrenom($prenom_u)
    {
        $prenom_u = htmlspecialchars($prenom_u);
        if (!empty($prenom_u) && strlen($prenom_u) >= 3 && strlen($prenom_u) <= 50) {
            $this->prenom = $prenom_u;
        } else {
            $errors['prenom'] = "Veuillez saisir un prénom correct.";
        }
    }
    

    public function setNom($nom_u)
    {
        $nom_u = htmlspecialchars($nom_u);
        if (!empty($nom_u) && (strlen($nom_u) >= 2 && strlen($nom_u) <= 50)) {
            $this->nom = $nom_u;
        } else {
            $errors['nom'] = "Veuillez saisir un nom correct.";
        }
    }

    public function setEmail($email_u)
    {
        $email_u = htmlspecialchars($email_u);
        if (!empty($email_u) && !(preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/", $email_u))) {
            $this->email = $email_u;
        } else {
            $errors['email'] = "L'adresse e-mail n'est pas valide.";
        }
    }

    public function setPhone($phone_u)
    {
        $phone_u = is_numeric($phone_u);
        if (!empty($phone_u) && !strlen($phone_u) == 9 && !(preg_match("/^(70|76|77|78)[0-9]{7}/", $phone_u))) {
            $this->phone = $phone_u;
        } else {
            $errors['phone'] = "Le numéro de téléphone saisi n'est pas correct.";
        }
    }

    public function setPass($pass_u)
    {
        $pass_u = strlen($pass_u) > 8;
        if (!preg_match('/[A-Z]/', $pass_u) && preg_match('/[a-z]/', $pass_u) && !preg_match('/[0-9]/', $pass_u)) {
            $this->pass = $pass_u;
        } else {
            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères avec au moins une majuscule, une minuscule et un chiffre.";
        }
    }

    public function setPass_conf($pass_conf_u)
    {
        $pass_conf_u = $pass_conf_u;
        $pass_u = ($_POST['password_signup']);
        if (!empty($pass_conf_u) && $pass_conf_u != $pass_u) {
            $this->pass_conf = $pass_conf_u;     
        } else {
            $errors['password_confirm'] = "Les mots de passe ne correspondent pas.";
        }
    }

    public function setAdress($adress_u)
    {
        $adress_u = htmlspecialchars($adress_u);
        if (!empty($adress_u)) {
            $this->adress = $adress_u;
        } else {
            $errors['user_adress'] = "Veuillez saisir votre adresse.";
        }
    }

    public function setDate($date_u) 
    {
        $date_u = date("Y-m-d H:i:s");
         $this->date = $date_u ;
    }
    // Méthodes

    public function inscription(User $user, $mydatabase) {
       if (!empty($user->prenom) && !empty($user->nom) && !empty($user->email) && !empty($user->phone) && !empty($user->pass) && !empty($user->pass_conf) && !empty($user->adress) && !empty($user->date)) {
        
        $sql=('INSERT INTO user_etaxibokko (prenom, nom, email, phone, pass, pass_conf, adress, date_insc) 
        VALUES (:prenom, :nom, :email, :phone, :pass, :pass_conf, :adress, :date_insc)');

        $requete_insc = $mydatabase->prepare($sql);

        $requete_insc->bindParam(':prenom', $user->prenom, PDO::PARAM_STR);
        $requete_insc->bindParam(':nom', $user->nom, PDO::PARAM_STR);
        $requete_insc->bindParam(':email', $user->email, PDO::PARAM_STR);
        $requete_insc->bindParam(':phone', $user->phone, PDO::PARAM_INT);
        $requete_insc->bindParam(':pass', $user->pass, PDO::PARAM_STR);
        $requete_insc->bindParam(':pass_conf', $user->pass_conf, PDO::PARAM_STR);
        $requete_insc->bindParam(':adress', $user->adress, PDO::PARAM_STR);
        $requete_insc->bindParam(':date_insc', $user->date, PDO::PARAM_STR);
        
            $requete_insc->execute();
  
           echo "Les données renseignées dans le formulaire ont été insérées dans la base de données.";
        } else {
            echo "Erreur : les données ne sont pas transmises.; Veuillez <a href='authentification.php'>Essayer une nouvelle fois</a>.";
        }
       
    }
 
    public function connex(User $user, $pass_c, $mydatabase) {
        $sql = "SELECT email, pass FROM user_etaxibokko WHERE email = :email";
        $requete_conn = $mydatabase->prepare($sql);
        $requete_conn->bindParam(':email', $user->email, PDO::PARAM_STR);
        $requete_conn->execute();
        $user = $requete_conn->fetch(PDO::FETCH_ASSOC);
    
        if ($user !== false) { 
            $db_pass = $user['pass'];
            if ($pass_c === $db_pass) {
                $_SESSION['user'] = $user;
                header('Location: accueil.php');
                return true;
            } else {
                echo "Mot de passe incorrect.";
                return false;
            }
        } else {
            echo "Aucun utilisateur avec cet e-mail. Veuillez vous <a href='authentification.php'>inscrire</a>.";
            return false;
        }
    }
    
    public function afficher_liste($mydatabase) {
    $sql = "SELECT prenom, nom FROM user_etaxibokko";
    $requete = $mydatabase->query($sql);

    if ($requete) {
        $liste_users = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $liste_users;
    } else {
        return [];
    }
    }

}

// Partie Instanciation 
// Methode Inscription 

// var_dump($requete_insc->execute());
// die();

if ($_SERVER['REQUEST_METHOD']=='POST') {

    if (isset($_POST['sinscrire'])) {
    
    $prenom_u = $_POST['prenoms'];
    $nom_u = $_POST['nom'];
    $email_u = $_POST['email_signup'];
    $phone_u = $_POST['phone'];
    $pass_u = $_POST['password_signup'];
    $pass_conf_u = $_POST['password_confirm'];
    $adress_u = $_POST['user_adress'];
    $date_u = date("Y-m-d H:i:s") ;
}

$user = new User (@$prenom_u, @$nom_u, @$email_u, @$phone_u, @$pass_u, @$pass_conf_u, @$adress_u, @$date_u);
$user->inscription($user, $mydatabase);
var_dump($user);

}

// Methode connexion 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['seconnecter'])) {
            $email_c = $_POST['email_signin'];
            $pass_c = $_POST['password_signin'];

            $user = new User(null, null, $email_c, null, $pass_c, null, null, null);
    
            $connexion_result = $user->connex($user, $pass_c, $mydatabase);
    
            if ($connexion_result) {
                // echo "Connexion okay";
                // header('Location: accueil.php');
                exit;
            }
        }
    }
    
