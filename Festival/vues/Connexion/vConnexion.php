<?php
include("includes/_debut.inc.php");

?>
<html> 
<form action="connexion.php" method="post">
    Pseudo: <input type="text" name="pseudo" value="" />
     
    Mot de passe: <input type="password" name="mdp" value="" />
    <input type="submit" name="connexion" value="Connexion" />
</form>
    <form action="deconnexion.php" method="post">
     
    <input type="submit" name="deconnexion" value="Deconnexion" />
</form>
</html>
<?php
include("includes/_fin.inc.php");
?>