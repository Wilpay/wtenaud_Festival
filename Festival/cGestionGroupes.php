<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use modele\metier\Groupe;
use modele\dao\GroupeDAO;
use modele\dao\Bdd;
require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}
$action = $_REQUEST['action'];


// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        include("vues/GestionGroupes/vObtenirGroupes.php");
        break;

    case 'detailGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupes/vObtenirDetailGroupe.php");
        break;

    case 'demanderSupprimerGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupes/vSupprimerGroupe.php");
        break;

    case 'demanderCreerGroupe':
        include("vues/GestionGroupes/vCreerModifierGroupe.php");
        break;

    case 'demanderModifierGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupes/vCreerModifierGroupe.php");
        break;

    case 'validerSupprimerGroupe':
        $id = $_REQUEST['id'];
        GroupeDAO::delete($id);
        include("vues/GestionGroupes/vObtenirGroupes.php");
        break;
    

    case 'validerCreerGroupe':
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['nom'];
        $identite = $_REQUEST['identiteResponsable'];
        $adresse = $_REQUEST['adressePostale'];
        $nbPers = $_REQUEST['nombrePersonnes'];
        $nomPays = $_REQUEST['nomPays'];
        $hebergement = $_REQUEST['hebergement'];
        verifierDonneesGroupeC ($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement);
        if (nbErreurs() == 0) {
            GroupeDAO::insert(new Groupe($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement));
            include("vues/GestionGroupes/vObtenirGroupes.php");
        } else {
            include("vues/GestionGroupes/vCreerModifierGroupe.php");
        }
        break;

    case 'validerModifierGroupe':
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['nom'];
        $identite = $_REQUEST['identiteResponsable'];
        $adresse = $_REQUEST['adressePostale'];
        $nbPers = $_REQUEST['nombrePersonnes'];
        $nomPays = $_REQUEST['nomPays'];
        $hebergement = $_REQUEST['hebergement'];
        verifierDonneesGroupeM ($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement); 
        if (nbErreurs() == 0) {
            GroupeDAO::update($id, new Groupe($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement));
            include("vues/GestionGroupes/vObtenirGroupes.php");
        } else {
            include("vues/GestionGroupes/vCreerModifierGroupe.php");
        }
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();


function verifierDonneesGroupeC($id, $nom,  $nbPers, $nomPays) {
    if ($nom == "" || $nbPers == "" || $nomPays == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur
                    ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            if (GroupeDAO::isAnExistingId($id)) {
                ajouterErreur("Le Groupe $id existe déjà");
            }
        }
    }
    if ($nom != "" && GroupeDAO::isAnExistingNom(true, $id, $nom)) {
        ajouterErreur("Le Groupe $nom existe déjà");
    } 
}

function verifierDonneesGroupeM($id, $nom, $nbPers, $nomPays) {
    if ($nom == "" || $nbPers == "" || $nomPays == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($nom != "" && GroupeDAO::isAnExistingNom(false, $id, $nom)) {
        ajouterErreur("Le groupe $nom existe déjà");
    }
}
