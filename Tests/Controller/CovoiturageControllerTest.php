<?php

namespace App\Tests\Controller;

use App\Controller\CovoiturageController;
use App\Entity\User;
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class CovoiturageControllerTest extends TestCase
{
    private CovoiturageController $covoiturageController;
    private $covoiturageRepoMock;
    private $userRepoMock;
    private User $user;

    protected function setUp(): void
    {
        $this->covoiturageController = new CovoiturageController();
        $this->user = new User();
        $this->covoiturageRepoMock = $this->createMock(CovoiturageRepository::class);
        $this->userRepoMock = $this->createMock(UserRepository::class);
        $_POST['covoiturage_id'] = 1;
        $_POST['covoiturage_price'] = 1;
        $_POST['participate'] = true;
    }

    protected function tearDown(): void
    {
        unset(
            $_POST['participate'],
            $_POST['quitCovoiturageAsPassager'],
            $_POST['user_id'],
            $_POST['deleteCovoiturageAsDriver'],
            $_SESSION['user'],
            $_SESSION['message_to_User'],
            $_SESSION['message_code']
        );
    }

    public function testParticipationToCovoiturageWorksCorrectly(): void
    {
        $covoiturageDetail = [
            "id" => 1,
            "prix" => 15,
            "nb_place_disponible" => 1,
            "user_id" => 1
        ];

        $this->user->setId(10);
        $userId = $this->user->getId();
        $_SESSION['user'] = [
            "id" => 10,
            "mail" => "test@example.com"
        ];

        $this->userRepoMock
            ->expects($this->once())
            ->method('findOneByMail')
            ->with('test@example.com')
            ->willReturn($this->user);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("isUserParticipant")
            ->with($userId, $covoiturageDetail["id"]);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("participateToCovoiturage")
            ->with($userId, $covoiturageDetail["id"]);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("updateUserCredits")
            ->with($covoiturageDetail["prix"], $userId, false);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("updatePlacesDisponibles")
            ->with($covoiturageDetail["id"], false);

        $result = $this->covoiturageController->participateToCovoiturage(
            $covoiturageDetail,
            $this->covoiturageRepoMock,
            $this->userRepoMock
        );

        $this->assertEquals(
            'Votre participation au covoiturage a été enregistrée avec succès !',
            $_SESSION['message_to_User']
        );
        $this->assertEquals('success', $_SESSION['message_code']);

        // Avoid printing to stdout during tests (prevents "headers already sent" warnings).
        $doubleConfirmation = (bool) ($result[5] ?? false);
        $this->assertTrue($doubleConfirmation); // doubleConfirmation
    }

    public function testUserCanLeaveACovoiturage(): void
    {
        $_POST['quitCovoiturageAsPassager'] = true;
        $_POST['user_id'] = 1;

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("quitCovoiturageAsPassager")
            ->with($_POST['user_id'], $_POST['covoiturage_id'])
            ->willReturn(true);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("updatePlacesDisponibles")
            ->with($_POST['covoiturage_id'], true)
            ->willReturn(true);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("updateUserCredits")
            ->with($_POST['covoiturage_price'], $_POST['user_id'], true)
            ->willReturn(true);

        $this->covoiturageController->leaveCovoiturage($this->covoiturageRepoMock);

        $this->assertEquals(
            'Votre participation à ce covoiturage a été annulée.',
            $_SESSION['message_to_User']
        );
        $this->assertEquals('success', $_SESSION['message_code']);
    }

    public function testDriverCanDeleteACovoiturage(): void
    {
        $_POST['deleteCovoiturageAsDriver'] = true;

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method('searchCovoiturageDetailsById')
            ->with($_POST['covoiturage_id'])
            ->willReturn([]);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method('searchCovoiturageParticipantsByCovoiturageId')
            ->with($_POST['covoiturage_id'])
            ->willReturn([]);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("deleteCovoiturageAsDriver")
            ->with($_POST['covoiturage_id'])
            ->willReturn(true);

        $result = $this->covoiturageController->deleteCovoiturage($this->covoiturageRepoMock);
        $this->assertEquals(
            'Covoiturage annulé. Les participants ont été informés par e-mail.',
            $_SESSION['message_to_User']
        );
        $this->assertEquals('info', $_SESSION['message_code']);
    }

    public function testParticipationFailsWhenNoDisponiblePlaces(): void
    {
        $covoiturageDetail = [
            "id" => 2,
            "prix" => 20,
            "nb_place_disponible" => 0,
            "user_id" => 99
        ];
        $this->user->setId(11);
        $_SESSION['user'] = [
            "id" => 11,
            "mail" => "user2@example.com"
        ];

        $this->userRepoMock
            ->expects($this->once())
            ->method('findOneByMail')
            ->with('user2@example.com')
            ->willReturn($this->user);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("isUserParticipant")
            ->with(11, $covoiturageDetail["id"]);

        $result = $this->covoiturageController->participateToCovoiturage(
            $covoiturageDetail,
            $this->covoiturageRepoMock,
            $this->userRepoMock
        );

        $noDisponiblePlaces = (bool) ($result[1] ?? false);
        $doubleConfirmation = (bool) ($result[5] ?? false);
        $this->assertTrue($noDisponiblePlaces); // noDisponiblePlaces
        $this->assertFalse($doubleConfirmation); // doubleConfirmation
        $this->assertArrayHasKey(1, $result);
    }

    public function testParticipationFailsWhenNotEnoughCredits(): void
    {
        $covoiturageDetail = [
            "id" => 3,
            "prix" => 50,
            "nb_place_disponible" => 2,
            "user_id" => 88
        ];
        $this->user->setId(12);
        $_SESSION['user'] = [
            "id" => 12,
            "mail" => "user3@example.com"
        ];

        $this->userRepoMock
            ->expects($this->once())
            ->method('findOneByMail')
            ->with('user3@example.com')
            ->willReturn($this->user);

        $this->user
            ->setNbCredits(10); // Not enough credits

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("isUserParticipant")
            ->with(12, $covoiturageDetail["id"]);

        $result = $this->covoiturageController->participateToCovoiturage(
            $covoiturageDetail,
            $this->covoiturageRepoMock,
            $this->userRepoMock
        );

        $noEnoughCredits = (bool) ($result[2] ?? false);
        $doubleConfirmation = (bool) ($result[5] ?? false);
        $this->assertTrue($noEnoughCredits); // noEnoughCredits
        $this->assertFalse($doubleConfirmation); // doubleConfirmation
        $this->assertArrayHasKey(2, $result);
    }

    public function testParticipationFailsWhenUserIsDriver(): void
    {
        $covoiturageDetail = [
            "id" => 4,
            "prix" => 10,
            "nb_place_disponible" => 1,
            "user_id" => 13
        ];
        $this->user->setId(13);
        $_SESSION['user'] = [
            "id" => 13,
            "mail" => "driver@example.com"
        ];

        $this->userRepoMock
            ->expects($this->once())
            ->method('findOneByMail')
            ->with('driver@example.com')
            ->willReturn($this->user);

        $this->covoiturageRepoMock
            ->expects($this->once())
            ->method("isUserParticipant")
            ->with(13, $covoiturageDetail["id"]);

        $result = $this->covoiturageController->participateToCovoiturage(
            $covoiturageDetail,
            $this->covoiturageRepoMock,
            $this->userRepoMock
        );

        $isDriverInCovoiturage = (bool) ($result[7] ?? false);
        $doubleConfirmation = (bool) ($result[5] ?? false);
        $this->assertTrue($isDriverInCovoiturage); // isDriverInCovoiturage
        $this->assertFalse($doubleConfirmation); // doubleConfirmation
    }

    public function testParticipationFailsWhenNotLogged(): void
    {
        $covoiturageDetail = [
            "id" => 5,
            "prix" => 5,
            "nb_place_disponible" => 1,
            "user_id" => 14
        ];

        $result = $this->covoiturageController->participateToCovoiturage(
            $covoiturageDetail,
            $this->covoiturageRepoMock,
            $this->userRepoMock
        );

        $isNotLogged = $result[0] ?? null;
        $doubleConfirmation = $result[5] ?? null;
        $this->assertNull($isNotLogged); // isNotLogged
        $this->assertNull($doubleConfirmation); // doubleConfirmation
    }
}
