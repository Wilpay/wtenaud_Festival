
<?php

    
use modele\dao\GroupeDAO;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;
require_once __DIR__.'/../../includes/autoload.php';
Bdd::connecter();




include("includes/_debut.inc.php");

// AFFICHER L'ENSEMBLE DES GROUPES
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// GROUPE

   
   
include ('verif.php') ;
echo "Bienvenue " ,$_SESSION['pseudo'];


echo "
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Groupes</strong></td>
   </tr>";

$lesGroupes = GroupeDAO::getAll();
// BOUCLE SUR LES GROUPES
foreach ($lesGroupes as $UnGroupe) {
    $id = $UnGroupe->getId();
    $nom = $UnGroupe->getNom();
    echo "
	 <tr class='ligneTabNonQuad'>
         <td width='52%'>$nom</td>";

    // S'il existe déjà des attributions pour les groupes il faudra
    // d'abord les supprimer avant de pouvoir supprimer le groupe
    // if (!existeAttributionsGp($connexion, $id)) {
    $lesAttributionsDeCeGroupes = AttributionDAO::getAllByIdGp($id);
    
    echo "
      </tr>";
}
echo "
</table>
<br>
<a href='cGestionGroupes.php?action=demanderCreerGroupe'>
Création d'un Groupe</a >";

include("includes/_fin.inc.php");
