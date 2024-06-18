<?php
// Auteur: hmidoush
// Functie: definitie class Klant
namespace Bas\classes;

use PDO;
use PDOException;

include_once "functions.php";

class Klant extends Database {
    public $klantId;
    public $klantemail = null;
    public $klantnaam;
    public $klantwoonplaats;
    public $klantAdres;
    public $klantPostcode;
    private $table_name = "Klant";   

    // Method to set the database connection
    public function setConnection($conn) {
        self::$conn = $conn;
    }
    
    // Methods
    
    /**
     * Summary of crudKlant
     * @return void
     */
    public function crudKlant() : void {
        // Haal alle klanten op uit de database mbv de method getKlanten()
        $lijst = $this->getKlanten();

        // Print een HTML tabel van de lijst   
        $this->showTable($lijst);
    }

    /**
     * Summary of getKlanten
     * @return array
     */
    public function getKlanten() : array {
        try {
            // Doe een query: dit is een prepare en execute in 1 zonder placeholders
            $sql = "SELECT * FROM $this->table_name";
            $stmt = self::$conn->query($sql);
            $lijst = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $lijst;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Summary of getKlant
     * @param int $klantId
     * @return array
     */
    public function getKlant(int $klantId) : array {
        try {
            // Doe een fetch op $klantId
            $sql = "SELECT * FROM $this->table_name WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->execute();
            $lijst = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $lijst ?: [];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    public function dropDownKlant($row_selected = -1){
        // Haal alle klanten op uit de database mbv de method getKlanten()
        $lijst = $this->getKlanten();
        
        echo "<label for='Klant'>Choose a klant:</label>";
        echo "<select name='klantId'>";
        foreach ($lijst as $row){
            if($row_selected == $row["klantId"]){
                echo "<option value='$row[klantId]' selected='selected'> $row[klantNaam] $row[klantEmail]</option>\n";
            } else {
                echo "<option value='$row[klantId]'> $row[klantNaam] $row[klantEmail]</option>\n";
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
        if (empty($lijst)) {
            echo "<p>Geen resultaten gevonden.</p>";
            return;
        }

        $txt = "<table>";

        // Voeg de kolomnamen boven de tabel
        $txt .= getTableHeader($lijst[0]);

        foreach($lijst as $row){
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["klantId"] . "</td>";
            $txt .=  "<td>" . $row["klantNaam"] . "</td>";
            $txt .=  "<td>" . $row["klantEmail"] . "</td>";
            $txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
            $txt .=  "<td>" . $row["klantAdres"] . "</td>";
            $txt .=  "<td>" . $row["klantPostcode"] . "</td>";
            
            // Update
            // Wijzig knopje
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='update.php?klantId=$row[klantId]' >       
                <button name='update'>Wzg</button>    
            </form> </td>";

            // Delete
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='delete.php?klantId=$row[klantId]' >       
                <button name='verwijderen'>Verwijderen</button>    
            </form> </td>"; 
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    // Delete klant
    /**
     * Summary of deleteKlant
     * @param int $klantId
     * @return bool
     */
    public function deleteKlant(int $klantId) : bool {
        try {
            // Begin a transaction
            self::$conn->beginTransaction();

            // Delete associated rows in verkooporder
            $sqlVerkooporder = "DELETE FROM verkooporder WHERE klantId = :klantId";
            $stmtVerkooporder = self::$conn->prepare($sqlVerkooporder);
            $stmtVerkooporder->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmtVerkooporder->execute();

            // Delete the klant
            $sqlKlant = "DELETE FROM $this->table_name WHERE klantId = :klantId";
            $stmtKlant = self::$conn->prepare($sqlKlant);
            $stmtKlant->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmtKlant->execute();

            // Commit the transaction
            self::$conn->commit();
            
            return true;
        } catch (PDOException $e) {
            // Rollback the transaction on error
            self::$conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateKlant($row) : bool {
        // Voer de update van de klant uit
        try {
            $sql = "UPDATE $this->table_name SET klantEmail = :klantEmail, klantNaam = :klantNaam, klantWoonplaats = :klantWoonplaats, klantAdres = :klantAdres, klantPostcode = :klantPostcode WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $row['klantId'], PDO::PARAM_INT);
            $stmt->bindParam(':klantEmail', $row['klantEmail'], PDO::PARAM_STR);
            $stmt->bindParam(':klantNaam', $row['klantNaam'], PDO::PARAM_STR);
            $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], PDO::PARAM_STR);
            $stmt->bindParam(':klantAdres', $row['klantAdres'], PDO::PARAM_STR);
            $stmt->bindParam(':klantPostcode', $row['klantPostcode'], PDO::PARAM_STR);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Summary of BepMaxKlantId
     * @return int
     */
    private function BepMaxKlantId() : int {
        // Bepaal uniek nummer
        $sql="SELECT MAX(klantId)+1 FROM $this->table_name";
        return (int) self::$conn->query($sql)->fetchColumn();
    }
    
    /**
     * Summary of insertKlant
     * Voeg een nieuwe klant toe aan de database
     * @param mixed $row Array met klantgegevens
     * @return bool True als het invoegen succesvol is, anders False
     */
    public function insertKlant($row) : bool {
        try {
            // Begin een transactie
            self::$conn->beginTransaction();

            // Bepaal een unieke klantId
           
            $klantId = $this->BepMaxKlantId();
            
            // SQL-query voor het invoegen van een nieuwe klant
            $sql = "INSERT INTO $this->table_name (klantId, klantEmail, klantNaam, klantWoonplaats, klantAdres, klantPostcode) 
                    VALUES (:klantId, :klantEmail, :klantNaam, :klantWoonplaats, :klantAdres, :klantPostcode)";
            
            // Bereid de query voor
            $stmt = self::$conn->prepare($sql);
            
            // Bind de parameters
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->bindParam(':klantEmail', $row['klantEmail'], PDO::PARAM_STR);
            $stmt->bindParam(':klantNaam', $row['klantNaam'], PDO::PARAM_STR);
            $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], PDO::PARAM_STR);
            $stmt->bindParam(':klantAdres', $row['klantAdres'], PDO::PARAM_STR);
            $stmt->bindParam(':klantPostcode', $row['klantPostcode'], PDO::PARAM_STR);
            
            // Voer de query uit
            $stmt->execute();

            // Commit de transactie
            self::$conn->commit();

            return true; // Succesvol ingevoegd
        } catch(PDOException $e) {
            // Rol de transactie terug bij een fout
            self::$conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false; // Fout bij het invoegen
        }
    }

    /**
     * Summary of searchKlanten
     * Zoek klanten op basis van klantNaam
     * @param string $klantNaam
     * @return array
     */
    public function searchKlanten(string $klantNaam) : array {
        try {
            $sql = "SELECT * FROM $this->table_name WHERE klantNaam LIKE :klantNaam";
            $stmt = self::$conn->prepare($sql);
            $naam = '%' . $klantNaam . '%';
            $stmt->bindParam(':klantNaam', $naam, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>
