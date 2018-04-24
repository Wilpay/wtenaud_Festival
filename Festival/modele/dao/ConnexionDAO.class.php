<?php

namespace modele\dao;

use modele\metier\Connexion;
use PDOStatement;
use PDO;

/**
 * Description of EtablissementDAO
 * Classe métier : Etablissement
 * @author prof
 * @version 2017
 */
class ConnexionDAO {

    /**
     * Instancier un objet de la classe Etablissement à partir d'un enregistrement de la table ETABLISSEMENT
     * @param array $enreg
     * @return Etablissement
     */
     protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $nom = $enreg['NOM'];
        $prenom = $enreg['PRENOM'];
        $email = $enreg['EMAIL'];
        $login = $enreg['LOGIN'];
        $motDePasse = $enreg['MOTDEPASSE'];


        $uneConnexion = new Connexion($id, $nom, $prenom, $email, $login, $motDePasse);

        return $uneConnexion;
    }

    /**
     * Valorise les paramètres d'une requête préparée avec l'état d'un objet Etablissement
     * @param type $objetMetier un Etablissement
     * @param type $stmt requête préparée
     */
    protected static function metierVersEnreg(Connexion $objetMetier, PDOStatement $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        // Note : bindParam requiert une référence de variable en paramètre n°2 ; 
        // avec bindParam, la valeur affectée à la requête évoluerait avec celle de la variable sans
        // qu'il soit besoin de refaire un appel explicite à bindParam
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':nom', $objetMetier->getNom());
        $stmt->bindValue(':prenom', $objetMetier->getPrenom());
        $stmt->bindValue(':email', $objetMetier->getEmail());
        $stmt->bindValue(':login', $objetMetier->getLogin());
        $stmt->bindValue(':motDePasse', $objetMetier->getMotDePasse());
    }

    /**
     * Retourne la liste de tous les Etablissements
     * @return array tableau d'objets de type Etablissement
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Utilisateur";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Pour chaque enregisterement
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // instancier un Etablissement et l'ajouter au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

   /**
     * Recherche un établissement selon la valeur de son identifiant
     * @param string $id
     * @return Etablissement l'établissement trouvé ; null sinon
     */
     public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Utilisateur WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    
    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Etablissement $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Connexion $objet) {
        $requete = "INSERT INTO Utilisateur VALUES (:id, :nom, :prenom, :email, :login, :motDePasse)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param Etablissement $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, Connexion $objet) {
        $ok = false;
        $requete = "UPDATE  Utilisateur SET NOM=:nom, PRENOM=:prenom,
           EMAIL=:email, LOGIN=:login, MOTDEPASSE=:motDePasse
           WHERE ID=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

     /**
     * Détruire un enregistrement de la table ETABLISSEMENT d'après son identifiant
     * @param string identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM Utilisateur WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    
    public static function isAnExistingName($estModeCreation, $id, $nom) {
        $nom = str_replace("'", "''", $nom);
        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
        // on vérifie la non existence d'un autre établissement (id!='$id') portant 
        // le même nom
        if ($estModeCreation) {
            $requete = "SELECT COUNT(*) FROM Utilisateur WHERE NOM=:nom";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
        } else {
            $requete = "SELECT COUNT(*) FROM Utilisateur WHERE NOM=:nom AND ID<>:id";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
        }
        return $stmt->fetchColumn(0);
    }

}
