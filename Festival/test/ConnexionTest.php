<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Connexion;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Connexion</h2>";
        $objet = new Connexion("1", "tenaud", "willy", "willytenaud@gmail.com", "wtenaud", "secret");
        var_dump($objet);
        ?>
    </body>
</html>
