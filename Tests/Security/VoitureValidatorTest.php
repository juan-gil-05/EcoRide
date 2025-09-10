<?php

namespace App\Tests\Security;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use App\Security\VoitureValidator;
use PHPUnit\Framework\TestCase;

class VoitureValidatorTest extends TestCase
{
    private VoitureValidator $voitureValidator;
    private Voiture $voiture;
    private $voitureRepositoryMock;

    public function setup(): void
    {
        $this->voiture = new Voiture();
        $this->voitureRepositoryMock = $this->createMock(VoitureRepository::class);
        $this->voitureValidator = new VoitureValidator($this->voitureRepositoryMock);
    }

    public function testNewCarValidateFormWithEmptyDataReturnsAnError(): void
    {
        $errors = $this->voitureValidator->newCarValidate($this->voiture);
        $this->assertArrayHasKey("immatriculationEmpty", $errors);
        $this->assertArrayHasKey("dateImmatriculationEmpty", $errors);
        $this->assertArrayHasKey("modeleEmpty", $errors);
        $this->assertArrayHasKey("marqueEmpty", $errors);
        $this->assertArrayHasKey("couleurEmpty", $errors);
    }

    public function testNewCarValidateFormWithExistingImmatriculationReturnsAnError(): void
    {
        $this->voiture->setImmatriculation("AB-123-CD");
        $this->voitureRepositoryMock->method('findCarByImmatriculation')->willReturn($this->voiture);
        $errors = $this->voitureValidator->newCarValidate($this->voiture);
        $this->assertArrayHasKey("immatriculationExists", $errors);
    }

    public function testNewCarValidateFormWithInvalidImmatriculationReturnsAnError(): void
    {
        $this->voiture->setImmatriculation("Azk12");
        $errors = $this->voitureValidator->newCarValidate($this->voiture);
        $this->assertArrayHasKey("immatriculationIncorrect", $errors);
    }
}
