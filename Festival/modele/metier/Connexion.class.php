<?php
namespace modele\metier;

/**
 * Description of Etablissement
 * un établissement a des capacités d'hébergement à offrir au festival
 * @author prof
 */
class Connexion {
    /**
     * code  de 8 caractères alphanum.
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $nom;
    /**
     * 
     * @var string
     */
    private $prenom;
    /**
     * 
     * @var string 
     */
    private $email;
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $motDePasse;

    
    
    function __construct($id, $nom, $prenom, $email, $login, $motDePasse) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->login = $login;
        $this->motDePasse = $motDePasse;

    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogin() {
        return $this->login;
    }

    function getMotDePasse() {
        return $this->motDePasse;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }





    
}
