<?php
/**
 * Contrôleur : gestion des établissements
 */

use modele\dao\EtablissementDAO;
use modele\metier\Etablissement;
use modele\dao\Bdd;
require_once __DIR__.'/includes/autoload.php';
Bdd::connecter();

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// établissements 
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        include("vues/GestionEtablissements/vObtenirEtablissements.php");
        break;

    case 'detailEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vObtenirDetailEtablissement.php");
        break;

    case 'demanderSupprimerEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vSupprimerEtablissement.php");
        break;

    case 'demanderCreerEtab':
        include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
        break;

    case 'demanderModifierEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
        break;

    case 'validerSupprimerEtab':
        $id = $_REQUEST['id'];
        EtablissementDAO::delete($id);
        include("vues/GestionEtablissements/vObtenirEtablissements.php");
        break;

    case 'validerCreerEtab':case 'validerModifierEtab':
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['nom'];
        $adresseRue = $_REQUEST['adresseRue'];
        $codePostal = $_REQUEST['codePostal'];
        $ville = $_REQUEST['ville'];
        $tel = $_REQUEST['tel'];
        $adresseElectronique = $_REQUEST['adresseElectronique'];
        $type = $_REQUEST['type'];
        $civiliteResponsable = $_REQUEST['civiliteResponsable'];
        $nomResponsable = strtoupper($_REQUEST['nomResponsable']);
        $prenomResponsable = $_REQUEST['prenomResponsable'];

        
        if ($action == 'validerCreerEtab') {
            verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $prenomResponsable,$adresseElectronique);
            if (nbErreurs() == 0) {
                $unEtab = new Etablissement($id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                EtablissementDAO::insert($unEtab);
                include("vues/GestionEtablissements/vObtenirEtablissements.php");
            } else {
                include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            }
        } else {
            verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable);
            if (nbErreurs() == 0) {
                $unEtab = new Etablissement($id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                EtablissementDAO::update($id, $unEtab);
                include("vues/GestionEtablissements/vObtenirEtablissements.php");
            } else {
                include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            }
        }
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

function verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $prenomResponsable,$adresseElectronique) {

    if ($id == "" || $nom == "" || $adresseRue == "" || $codePostal == "" ||
            $ville == "" || $tel == "" || $nomResponsable == "" || $prenomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    
    //A note on the regex pattern used above (from the PHP source). 
    //It looks like there is some copyright on it of Michael Rushton. 
    //As stated: "Feel free to use and redistribute this code. But please keep this copyright notice."
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    if (preg_match($pattern, $adresseElectronique) != 1) {
        ajouterErreur('Rentrer un email valide');
    }
    
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur
                    ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            if (EtablissementDAO::isAnExistingId($id)) {
                ajouterErreur("L'établissement $id existe déjà");
            }
        }
    }
    
    if($nomResponsable != ""){
     if (!estLettres($nomResponsable)) {
         ajouterErreur("Le nom du responsable ne peut avoir de caractères spéciaux");
     }  
    }
    
    if($prenomResponsable != ""){
     if (!estLettres($prenomResponsable)) {
         ajouterErreur("Le prenom du responsable ne peut avoir de caractères spéciaux");
     }  
    }
    
    if($nom != ""){
        if (!estLettres($nom)){
            ajouterErreur("Le nom de l'établissement ne peut contenir des caractères spéciaux");
        }
    }
 
    
    if ($tel != ""){
        //Si le numéro n'est pas des chiffres
        //une erreur est générée
        if (!estEntier($tel)){
            ajouterErreur("Le numéro de téléphone doit être que des chiffres");
        }else{
            
            
        }
            
    }
    
    
    
    if ($nom != "" && EtablissementDAO::isAnExistingName(true, $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
    
}


function verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable) {
    if ($nom == "" || $adresseRue == "" || $codePostal == "" || $ville == "" ||
            $tel == "" || $nomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($nom != "" && EtablissementDAO::isAnExistingName(false, $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
}

function estUnCp($codePostal) {
    // Le code postal doit comporter 5 chiffres
    return strlen($codePostal) == 5 && estEntier($codePostal);
}


