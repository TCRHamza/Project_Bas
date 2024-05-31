<?php
// auteur: Hmidoush
// functie: definitie class artikel
namespace Bas\classes;

include_once "functions.php";
require_once "Database.php";

class artikel extends Database {
    public $artId;
    public $artOmschrijving;
    public $artInkoop;
    public $artVerkoop;
    public $artMinVoorraad;
    public $artMaxVoorraad;
    public $artLocatie;
    private $table_name = "artikel";

    // Methods

    public function crudartikel() : void {
        $lijst = $this->getartikelen();
        $this->showTable($lijst);
    }

    public function getartikelen() : array {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artMinVoorraad, artMaxVoorraad, artLocatie FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        $lijst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $lijst;
    }

    /**
     * Summary of getartikel
     * @param int $artId
     * @return array
     */
    public function getartikel(int $artId) : array {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artMinVoorraad, artMaxVoorraad, artLocatie FROM " . $this->table_name . " WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        $stmt->execute();
        $artikel = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $artikel ? $artikel : [];
    }

    public function dropDownartikel($row_selected = -1) {
        // Haal alle artikelen op uit de database mbv de method getartikelen()
        $lijst = $this->getartikelen();
        
        echo "<label for='artikel'>Choose an artikel:</label>";
        echo "<select name='artId'>";
        foreach ($lijst as $row) {
            if ($row_selected == $row["artId"]) {
                echo "<option value='{$row["artId"]}' selected='selected'> {$row["artOmschrijving"]} {$row["artLocatie"]}</option>\n";
            } else {
                echo "<option value='{$row["artId"]}'> {$row["artOmschrijving"]} {$row["artLocatie"]}</option>\n";
            }
        }
        echo "</select>";
    }

    /**
     * Summary of showTable
     * @param array $lijst
     * @return void
     */
    public function showTable(array $lijst) : void {
        $txt = "<table>";

        // Voeg de kolomnamen boven de tabel
        $txt .= getTableHeader($lijst[0]);

        foreach ($lijst as $row) {
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["artId"] . "</td>";
            $txt .=  "<td>" . $row["artOmschrijving"] . "</td>";
            $txt .=  "<td>" . $row["artInkoop"] . "</td>";
            $txt .=  "<td>" . $row["artVerkoop"] . "</td>";
            $txt .=  "<td>" . $row["artMinVoorraad"] . "</td>";
            $txt .=  "<td>" . $row["artMaxVoorraad"] . "</td>";
            $txt .=  "<td>" . $row["artLocatie"] . "</td>";
            
            // Update
            // Wijzig knopje
            $txt .=  "<td>
            <form method='post' action='update.php?artId={$row["artId"]}' >       
                <button name='update'>Wzg</button>    
            </form> </td>";

            // Delete
            $txt .=  "<td>
            <form method='post' action='delete.php?artId={$row["artId"]}' >       
                <button name='verwijderen'>Verwijderen</button>     
            </form> </td>";    
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    // Delete artikel
    /**
     * Summary of deleteartikel
     * @param int $artId
     * @return bool
     */
    public function deleteartikel(int $artId) : bool {
        $sql = "DELETE FROM " . $this->table_name . " WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateartikel($row) : bool {
        $sql = "UPDATE " . $this->table_name . " SET artOmschrijving = :artOmschrijving, artInkoop = :artInkoop, artVerkoop = :artVerkoop, artMinVoorraad = :artMinVoorraad, artMaxVoorraad = :artMaxVoorraad, artLocatie = :artLocatie WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $row['artId'], \PDO::PARAM_INT);
        $stmt->bindParam(':artOmschrijving', $row['artOmschrijving'], \PDO::PARAM_STR);
        $stmt->bindParam(':artInkoop', $row['artInkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVerkoop', $row['artVerkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artMinVoorraad', $row['artMinVoorraad'], \PDO::PARAM_STR);
        $stmt->bindParam(':artMaxVoorraad', $row['artMaxVoorraad'], \PDO::PARAM_STR);
        $stmt->bindParam(':artLocatie', $row['artLocatie'], \PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Summary of BepMaxArtId
     * @return int
     */
    private function BepMaxArtId() : int {
        // Bepaal uniek nummer
        $sql = "SELECT MAX(artId)+1 FROM " . $this->table_name;
        return (int) self::$conn->query($sql)->fetchColumn();
    }

    /**
     * Summary of insertartikel
     * @param array $row
     * @return bool
     */
    public function insertartikel(array $row) : bool {
        // Bepaal een unieke artId
        $artId = $this->BepMaxArtId();
        
        // query
        $sql = "INSERT INTO " . $this->table_name . " (artId, artOmschrijving, artInkoop, artVerkoop, artMinVoorraad, artMaxVoorraad, artLocatie) VALUES (:artId, :artOmschrijving, :artInkoop, :artVerkoop, :artMinVoorraad, :artMaxVoorraad, :artLocatie)";
        
        // Prepare
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        $stmt->bindParam(':artOmschrijving', $row['artOmschrijving'], \PDO::PARAM_STR);
        $stmt->bindParam(':artInkoop', $row['artInkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVerkoop', $row['artVerkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artMinVoorraad', $row['artMinVoorraad'], \PDO::PARAM_STR);
        $stmt->bindParam(':artMaxVoorraad', $row['artMaxVoorraad'], \PDO::PARAM_STR);
        $stmt->bindParam(':artLocatie', $row['artLocatie'], \PDO::PARAM_STR);
        
        // Execute
        return $stmt->execute();
    }
}
?>