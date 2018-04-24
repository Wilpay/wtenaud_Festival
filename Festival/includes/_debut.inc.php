<!DOCTYPE html">
<html lang="fr">
    <head>
        <title>Festival</title>
        <meta http-equiv="Content-Language" content="fr">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/cssGeneral.css" rel="stylesheet" type="text/css">
        <link href="css/cssOnglets.css" rel="stylesheet" type="text/css">
        <center><img id="logo" src="images/logo.png"></center>
    </head>
    <body class='basePage'>
        <br>
        <!--  Tableau contenant le titre et les menus -->
        <table width="100%" cellpadding="0" cellspacing="0">
            <!-- Titre -->
            
            <!-- Menus -->
            <tr> 
                <td>
                    <!-- On inclut le fichier de gestion des onglets ; si on a des 
                    menus traditionnels, il faudra inclure le fichier adéquat -->
                    <?php include("_onglets.inc.php"); ?>
                    
                        <!--<label for="pseudo">Pseudo :</label><input name="pseudo" type="text" id="pseudo" /><br />
                        <label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />-->
                        <ul id="menu">
                            <li id="sousmenu"><?php construireMenu("Accueil", "index.php", 1); ?></li>
                            <li id="sousmenu"><?php construireMenu("Gestion établissements", "cGestionEtablissements.php", 2); ?></li>
                            <li id="sousmenu"><?php construireMenu("Gestion types chambres", "cGestionTypesChambres.php", 3); ?></li>
                            <li id="sousmenu"><?php construireMenu("Offre hébergement", "cOffreHebergement.php", 4); ?></li>
                            <li id="sousmenu"><?php construireMenu("Attribution chambres", "cAttributionChambres.php", 5); ?></li>
                            <li id="sousmenu"><?php construireMenu("Gestion Groupes", "cGestionGroupes.php", 5); ?></li>
                            <li id="sousmenu"><?php construireMenu("Gestion Representation", "cGestionRepresentation.php", 5); ?></li>
                            <li id="sousmenu"><?php construireMenu("Connexion/Deconnexion", "cConnexion.php",5); ?></li> 
                        </ul>
                    

                </td>
            </tr>
            <!-- Fin des menus -->
            <tr>
                <td class="basePage">
                    <br><center><br>


