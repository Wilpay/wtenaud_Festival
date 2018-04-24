<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OffreDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\LieuDao;
        use modele\dao\Bdd;
        use modele\metier\lieu;

require_once __DIR__ . '/../includes/autoload.php';

        Bdd::connecter();

        // Jeu d'essai
        $id = '1';
        echo "<h2>Test de LieuDAO</h2>";

        // Test n°1
        echo "<h3>1- getOneById</h3>";
        $objet = LieuDAO::getOneById($id);
        var_dump($objet);

        // Test n°2
        echo "<h3>2- getAll</h3>";
        $lesObjets = LieuDAO::getAll();
        var_dump($lesObjets);

        
        Bdd::deconnecter();
        ?>


    </body>
</html>
