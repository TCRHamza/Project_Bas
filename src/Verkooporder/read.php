<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Verkooporder</title>
    <link rel="stylesheet" href="../css.css">
</head>

<body>
    <header>
        <h1>CRUD Verkooporder</h1>
        <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="./Verkooporder/read.php">Verkooporder overzicht</a></li>
            <li><a href="./Klant/read.php">Klant overzicht</a></li>
            <li><a href="./Klant/insert.php">Toevoegen nieuwe klant</a></li>
            <li><a href="./Artikelen/Read.php">Artikel overzicht</a></li>
            <li><a href="./Verkooporder/read.php">Verkooporder toevoegen</a></li>
        </ul>
    </nav>
    </header>
    <a href='insert.php'>Toevoegen nieuwe verkooporder</a><br><br>
    <?php

    // Autoloader classes via composer
    require '../../vendor/autoload.php';

    use Bas\classes\Verkooporder;

    // Maak een object Verkooporder
    $verkooporder = new Verkooporder;

    // Start CRUD
    $verkooporder->crudVerkooporder();

    ?>

</body>
</html>