<?php
namespace modele\metier;


class Lieu {
    /**
     * code  
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $nom;
    /**
     * n° de rue et rue
     * @var string
     */
    private $adresse;
    /**
     * capacité Accueil
     * @var int
     */
    private $capaciteAccueil;
   
    
    function __construct($id, $nom, $adresse, $capaciteAccueil) {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->capaciteAccueil = $capaciteAccueil;
    }
    
    public function __toString() {
        
    }

        function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getCapaciteAccueil() {
        return $this->capaciteAccueil;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setCapaciteAccueil($capaciteAccueil) {
        $this->capaciteAccueil = $capaciteAccueil;
    }

    


    
}
