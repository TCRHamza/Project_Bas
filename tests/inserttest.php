<?php
// auteur: Hamza
// functie: unitests class InsertKlant

use PHPUnit\Framework\TestCase;
use Bas\classes\Klant;

// Filename moet gelijk zijn aan de classname KlantTest
class KlantInsertTest extends TestCase{

    protected $klant;

    protected function setUp(): void {
        $this->klant = new Klant();
    }

    public function testInsertKlantTrue() {
        // Test data
        $testData = [
            'klantEmail' => 'test@example.com',
            'klantNaam' => 'Test Naam',
            'klantAdres' => 'Test Adres 123',
            'klantPostcode' => '1234 AB',
            'klantWoonplaats' => 'Test Stad'
        ];

        $result = $this->klant->insertKlant($testData);
        $this->assertTrue($result);
    }
}
?>
