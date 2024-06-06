<?php
use PHPUnit\Framework\TestCase;
use Bas\classes\Verkooporder;

class VerkooporderTest extends TestCase {
    protected $verkooporder;

    protected function setUp(): void {
        // Create an instance of Verkooporder with a real constructor
        $this->verkooporder = new Verkooporder();

        // Create a mock for the PDO connection
        $mockPDO = $this->createMock(PDO::class);

        // Set the mock connection using the new setConnection method
        $this->verkooporder->setConnection($mockPDO);
    }

    public function testInsertVerkooporderSuccess() {
        // Arrange
        $data = [
            'klantId' => 1,
            'artId' => 1,
            'verkOrdDatum' => '2024-06-01',
            'verkOrdBestAantal' => 10,
            'verkOrdStatus' => 'pending'
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($this->arrayHasKey(':klantId'))
                 ->willReturn(true);

        $this->verkooporder::$conn->expects($this->once())
                                  ->method('prepare')
                                  ->with($this->stringContains('INSERT INTO'))
                                  ->willReturn($stmtMock);

        // Act
        $result = $this->verkooporder->insertVerkooporder($data);

        // Assert
        $this->assertTrue($result);
    }

    public function testInsertVerkooporderFailure() {
        // Arrange
        $data = [
            'klantId' => 1,
            'artId' => 1,
            'verkOrdDatum' => '2024-06-01',
            'verkOrdBestAantal' => 10,
            'verkOrdStatus' => 'pending'
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($this->arrayHasKey(':klantId'))
                 ->willReturn(false);

        $this->verkooporder::$conn->expects($this->once())
                                  ->method('prepare')
                                  ->with($this->stringContains('INSERT INTO'))
                                  ->willReturn($stmtMock);

        // Act
        $result = $this->verkooporder->insertVerkooporder($data);

        // Assert
        $this->assertFalse($result);
    }
}
?>
