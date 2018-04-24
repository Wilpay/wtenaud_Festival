<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lieu Test</title>
    </head>
    <body>
        <?php
        use modele\metier\lieu;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Lieu</h2>";
        $objet = new Lieu(1, 'Nantes', '31 rue de ile de Nantes', 110);
        var_dump($objet);
        ?>
    </body>
</html>
