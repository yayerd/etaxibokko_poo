<?php


// Connexion à la base de données 

class Database_connect {

    private $dbname;
    private $host;
    private $username;
    private $password;
    public $mydatabase;

    public function __construct() {

        $this->dbname = "etaxibokko_poo";
        $this->host = "localhost";
        $this->username = "root";
        $this->password = "";
   
        try {
            $mydatabase = new PDO(
                "mysql:dbname=$this->dbname; 
                host=$this->host",
                $this->username,
                $this->password
            );

            $mydatabase->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );
            $this->mydatabase = $mydatabase;
            echo '<h1> 😃 Great! Connexion à la base de donnée réussie.👏 <br> Voici les données qui viennent d\'être insérer:</h1>';
        } catch (PDOException $e) {
            echo "<h1> 😬 Sorry! Connexion à la base de donnée échouée: 🤏</h1>" . $e->getMessage();
        };
    }
}

$connect = new Database_connect(); 
$mydatabase = $connect->mydatabase;
// var_dump($mydatabase); 

?>