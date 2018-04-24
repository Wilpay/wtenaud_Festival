<?php
use modele\dao\GroupeDAO;

include("includes/_debut.inc.php");

// CRÉER OU MODIFIER UN TYPE DE CHAMBRE
// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide
if ($action == 'demanderCreerGroupe') {
    $id = '';
    $nom = '';
    $identite = 'null';
    $adresse = 'null';
    $nbPers = '';
    $nomPays = '';
    $hebergement = '';  
}

// S'il s'agit d'une modification et qu'on ne "vient" pas de ce formulaire, il
// faut récupérer le libellé
if ($action == 'demanderModifierGroupe') {
    $leGroupe = GroupeDAO::getOneById($id);
    $nom = $leGroupe->getNom();
    $identite = $leGroupe->getIdentite();
    $adresse = $leGroupe->getAdresse();
    $nbPers = $leGroupe->getNbPers();
    $nomPays = $leGroupe->getNomPays();
    $hebergement = $leGroupe->getHebergement();
}

// Initialisations en fonction du mode (création ou modification) 
if ($action == 'demanderCreerGroupe' || $action == 'validerCreerGroupe') {
    $creation = true;
    $message = "Nouveau type de groupe"; // Alimentation du message de l'en-tête
    $action = "validerCreerGroupe";
    
} else {
    $creation = false;
    $message = "Id $id"; // Alimentation du message de l'en-tête
    $action = "validerModifierGroupe";
}

echo "
<form method='POST' action='cGestionGroupes.php'>
   <input type='hidden' value='$action' name='action'>
   <br>
   <table width='40%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'><strong>$message</strong></td>
      </tr>";

// En cas de création, l'id est accessible sinon l'id est dans un champ
// caché
if ($creation) {
    echo '
         <tr class="ligneTabNonQuad">
            <td> Id*: </td>
            <td><input type="text" value="' . $id . '" name="id" size="2" 
            maxlength="4"></td>
         </tr>';
} else {
    echo "
         <tr class='autreLigne'>
            <td><input type='hidden' value='$id' name='id'></td><td></td>
         </tr>";
}

echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="' . $nom . '" name="nom" size="30" 
         maxlength="25"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Identité: </td>
         <td><input type="text" value="' . $identite . '" name="identiteResponsable" size="30" 
         maxlength="25"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Adresse: </td>
         <td><input type="text" value="' . $adresse . '" name="adressePostale" size="30" 
         maxlength="25"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre de Personnes*: </td>
         <td><input type="text" value="' . $nbPers . '" name="nombrePersonnes" size="30" 
         maxlength="25"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom du Pays*: </td>
         <td><input type="text" value="' . $nomPays . '" name="nomPays" size="30" 
         maxlength="25"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Hébergement: </td>
         <td><input type="text" value="' . $hebergement . '" name="hebergement" size="30" 
         maxlength="25"></td>
      </tr>
   </table>';

echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
   </table>
   <a href='cGestionGroupes.php'>Retour</a>
</form>";

include("includes/_fin.inc.php");

