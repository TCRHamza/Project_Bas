<!--
	Auteur: Hmidoush
	Function: home page CRUD Artikel
-->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../css.css">
</head>

<body>
	<header>
        <h1>CRUD Artikel</h1>
        <nav>
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../Klant/read.php">Klant overzicht</a></li>
            <li><a href="../Klant/insert.php">Toevoegen nieuwe klant</a></li>
            <li><a href="../Artikelen/Read.php">Artikel overzicht</a></li>
        </ul>
    </nav>
    </header>
	<a href='InsertArtikel.php'>Toevoegen nieuw artikel</a><br><br>
<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\Artikel;

// Maak een object Artikel
$artikel = new Artikel;

// Start CRUD
$artikel->crudArtikel();

?>

</body>
</html>