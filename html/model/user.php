<?php
require_once("model/model.php");
/**
 * Summary of User
 */
class User
{
    private string $pseudo;

    private string $nom;

    private string $prenom;

    private int $prenium;

    private int $age;

    private string $mdp;


    public function __construct($pseudo, $nom = null, $prenom = null, $mdp = null, $age = null, $premium = null)
    {
        if ($nom == null && $prenom == null && $mdp == null && $age == null) {
            $this->construcString($pseudo);
        } else {
            $this->pseudo = $pseudo;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->prenium = false;
            $this->age = $age;
            $this->mdp = $mdp;
        }
    }

    public function construcString($pseudo)
    {
        try {
            $this->pseudo = $pseudo;
            $connexion = connexion_to_bd();
            $query = $connexion->prepare("SELECT * FROM USERS WHERE pseudo = :pseudo");
            $res = $query->execute(['pseudo' => $pseudo]);
            if ($res) {
                $user = $query->fetch();
                $this->nom = $user['nom'];
                $this->prenom = $user['prenom'];
                $this->prenium = $user['prenium'] == 1;
                $this->age = $user['age'];
                $this->mdp = $user['mdp'];
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $connexion = null;
        }
    }

    /**
     * Check si l'utilisateur existe dans la base de données
     * @param mixed $pseudo pseudo de l'utilisateur
     * @param mixed $mdp mot de passe de l'utilisateur
     * @return int 1 si l'utilisateur existe, 0 si il n'existe pas, -1 si une erreur est survenue, -2 si le mot de passe est incorrect
     */
    public static function checkUser($pseudo, $mdp)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM USERS WHERE pseudo = :pseudo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if (password_verify($mdp, $result['mdp'])) {
                    return 1;
                } else {
                    return -2;
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        } finally {
            $conn = null;
        }
    }

    public static function exist($pseudo)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM USERS WHERE pseudo = :pseudo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        } finally {
            $conn = null;
        }
    }

    /**
     * Check si l'utilisateur est admin
     * @param mixed $pseudo pseudo de l'utilisateur
     * @return int 1 si l'utilisateur est admin, 0 si il n'est pas admin, -1 si une erreur est survenue
     */
    public static function isAdmin($pseudo)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM have_role WHERE pseudo = :pseudo AND role_name = 'ROLE_ADMIN'";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        } finally {
            $conn = null;
        }
    }

    public function getAdmin()
    {
        return User::isAdmin($this->pseudo);
    }

    /**
     * Ajoute le user dans la base de données
     * @return int 1 si l'utilisateur a été ajouté, -1 si une erreur est survenue, -2 si l'utilisateur existe déjà
     */
    public function pushInBd()
    {
        try {
            $conn = connexion_to_bd();
            if (User::exist($this->pseudo) == 1) {
                return -2;
            }
            $sql = "INSERT INTO USERS (pseudo, nom, prenom, mdp, age) VALUES (:pseudo, :nom, :prenom, :mdp, :age)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':mdp', password_hash($this->mdp, PASSWORD_DEFAULT));
            $stmt->bindParam(':age', $this->age);
            $stmt->execute();

            // add role user
            $stmt = $conn->prepare("INSERT INTO `have_role` (`pseudo`, `role_name`) VALUES (:pseudo, 'ROLE_USER')");
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        } finally {
            $conn = null;
        }
    }

    /**
     * Supprime le user de la base de données
     * @return array liste des utilisateurs
     */
    public static function getAllUsers()
    {
        try {
            $connexion = connexion_to_bd();
            $query = $connexion->prepare("SELECT * FROM USERS");
            $query->execute();
            $res = $query->fetchAll();
            $arrayUser = array();
            foreach ($res as $user) {
                array_push($arrayUser, new User($user['pseudo']));
            }
            return $arrayUser;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $connexion = null;
        }
    }

    /**
     * Pour transformer le user en admin
     */
    public function setAdmin()
    {
        try {
            $connexion = connexion_to_bd();
            $query = $connexion->prepare("UPDATE have_role SET role_name = 'ROLE_ADMIN' WHERE pseudo = :pseudo");
            $res = $query->execute(['pseudo' => $this->pseudo]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $connexion = null;
        }
    }

    public function displayPreview()
    {
        echo "<div class='userPreview'>";
        echo "<h2 id='pseudo'>" . $this->pseudo . "</h2>";
        echo "<p> Nom: " . $this->nom . "</p>";
        echo "<p> Prenom: " . $this->prenom . "</p>";
        echo "<p> Age: " . $this->age . "</p>";
        if (isPremium($this->pseudo)) {
            echo "<p> Prenium </p>";
        }
        // checkbox coché si admin et si on clicke dessus peut changer de role
        echo "<input type='checkbox' name='admin' value='admin'" . strval(($this->getAdmin() == 1) ? 'checked' : '') . " disabled> Admin";
        echo "</div>";
    }

    public static function exportToJson(){
        try {
            $db = connexion_to_bd();
            $query = $db->query("SELECT * FROM USERS");
            $users = array();
            while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
                array_push($users, $user);
            }
            $data = json_encode($users, JSON_UNESCAPED_UNICODE);

            // onextract les roles
            $query = $db->query("SELECT * FROM have_role");
            $roles = array();
            while ($role = $query->fetch(PDO::FETCH_ASSOC)) {
                array_push($roles, $role);
            }
            $data .= json_encode($roles, JSON_UNESCAPED_UNICODE);
            
            // Écrit le contenu dans un fichier
            file_put_contents('users.json', $data);

            // Envoie le fichier en tant que réponse HTTP
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Disposition: attachment; filename="users.json"');
            readfile('users.json');
            exit;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
    }

    public static function importFromJson($fic){
        try{
            $db = connexion_to_bd();
            $data = file_get_contents($fic);
            $users = json_decode($data, true);
            foreach ($users as $user) {
                $sql = "INSERT INTO USERS (pseudo, nom, prenom, mdp, age) VALUES (:pseudo, :nom, :prenom, :mdp, :age)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':pseudo', $user['pseudo']);
                $stmt->bindParam(':nom', $user['nom']);
                $stmt->bindParam(':prenom', $user['prenom']);
                $stmt->bindParam(':mdp', $user['mdp']);
                $stmt->bindParam(':age', $user['age']);
                $stmt->execute();
            }
            $roles = json_decode($data, true);
            foreach ($roles as $role) {
                $sql = "INSERT INTO have_role (pseudo, role_name) VALUES (:pseudo, :role_name)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':pseudo', $role['pseudo']);
                $stmt->bindParam(':role_name', $role['role_name']);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $db = null;
        }
    }

    public function setPrenium()
    {
        try {
            $connexion = connexion_to_bd();
            $query = $connexion->prepare("UPDATE USERS SET prenium = 1 WHERE pseudo = :pseudo");
            $res = $query->execute(['pseudo' => $this->pseudo]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $connexion = null;
        }


    }

}
