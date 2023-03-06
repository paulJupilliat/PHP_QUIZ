<?php
class score{

    public static function pushTentative($interrogation, $reponse){
        try{
            $connexion = connexion_to_bd();
            $sql = "INSERT INTO QUESTION_TENTATIVES (question_id, proposition) VALUES (:interrogation, :reponse)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':interrogation', $interrogation);
            $stmt->bindParam(':reponse', $reponse);
            $stmt->execute();
            // 
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
        }
        finally {
            $connexion = null;
        }
    }
}