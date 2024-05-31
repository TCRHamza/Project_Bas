<?php
namespace Bas\classes;

require_once "Database.php";
include_once "functions.php";

use PDO;

class Verkooporder extends Database {
    public $verkOrdId;
    public $klantId;
    public $artId;
    public $verkOrdDatum;
    public $verkOrdBestAantal;
    public $verkOrdStatus;
    private $table_name = "verkooporder";

    public function crudVerkooporder() : void {
        $lijst = $this->getVerkooporders();
        $this->showTable($lijst);
    }

    public function getVerkooporders() : array {
        $sql = "SELECT verkOrdId, klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        $lijst = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lijst;
    }

    public function showTable(array $lijst) : void {
        $txt = "<table border='1'>";
        $txt .= "<tr><th>ID</th><th>Klant ID</th><th>Artikel ID</th><th>Datum</th><th>Bestel Aantal</th><th>Status</th></tr>";

        foreach ($lijst as $row) {
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["verkOrdId"] . "</td>";
            $txt .=  "<td>" . $row["klantId"] . "</td>";
            $txt .=  "<td>" . $row["artId"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdDatum"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdBestAantal"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdStatus"] . "</td>";
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }
}
?>
