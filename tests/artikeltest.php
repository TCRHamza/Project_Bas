
<?php
// auteur: hmidoush
 
use PHPUnit\Framework\TestCase;
use Bas\classes\Artikel;
 
// Filename moet gelijk zijn aan de classname KlantTest
class ArtikelTest extends TestCase{
   
    protected $Artikel;
 
    protected function setUp(): void {
        $this->Artikel = new Artikel();
    }
 
    // Methods moeten starten met de naam test....
    public function testgetArtikelen(){
        $Artikel = $this->Artikel->getArtikelen();
        $this->assertIsArray($Artikel);
        $this->assertTrue(count($Artikel) > 0, "Aantal moet groter dan 0 zijn");
    }
 
    public function testGetArtikel(){
        $ArtikelId = 1; // check of dit ook echt in de database bestaat!
        $Artikel = $this->Artikel->getArtikel($ArtikelId);
        $this->assertEquals($ArtikelId, $Artikel['artId']);
    }
   
}
   
?>