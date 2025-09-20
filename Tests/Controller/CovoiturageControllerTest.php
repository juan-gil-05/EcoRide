<?php

namespace App\Tests\Controller;

use App\Controller\CovoiturageController;
use App\Entity\User;
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
use App\Security\Security;
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
            "nb_place_disponible" => 1
        ];
        $_POST['participate'] = true;
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
        $this->assertTrue($result[5]); // doubleConfirmation
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
}
