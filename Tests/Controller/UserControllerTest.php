<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\PreferenceRepository;
use App\Repository\UserRepository;
use App\Security\UserValidator;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private User $user;
    private UserController $userController;
    private $userRepoMock;
    private $uservalidatorMock;
    private $preferenceRepoMock;
    private $errors = [];

    protected function setUp(): void
    {
        $this->user = new User();
        $this->userController = new UserController();
        $this->userRepoMock = $this->createMock(UserRepository::class);
        $this->uservalidatorMock = $this->createMock(UserValidator::class);
        $this->preferenceRepoMock = $this->createMock(PreferenceRepository::class);
    }

    protected function tearDown(): void
    {
        unset(
            $_POST['deletePreference'],
            $_POST['prefId'],
            $_SESSION['message_to_User'],
            $_SESSION['message_code']
        );
    }

    public function testCreationOfPassagerUserAccountWorksCorrectly(): void
    {
        $this->user->setRoleId("1");

        $this->userRepoMock
            ->expects($this->once())
            ->method("createUser")
            ->with($this->user);

        $result = $this->userController->createUserDependingOnRole(
            $this->user,
            $this->userRepoMock,
            $this->uservalidatorMock,
            $this->errors
        );

        $this->assertTrue($result);
    }

    public function testCreationOfDriverUserAccountWorksCorrectly(): void
    {
        $this->user->setRoleId("2");
        $this->user->setphoto("photo.jpg");

        $this->uservalidatorMock
            ->method("userPhotoValidate")
            ->with($this->user)
            ->willReturn([]); // pas d'erreurs

        $this->userRepoMock
            ->expects($this->once())
            ->method("createDriverUser")
            ->with($this->user);

        $result = $this->userController->createUserDependingOnRole(
            $this->user,
            $this->userRepoMock,
            $this->uservalidatorMock,
            $this->errors
        );

        $this->assertTrue($result);
    }

    public function testDeleteADriverPreferenceWorksCorrectly(): void
    {
        $_POST['deletePreference'] = true;
        $_POST['prefId'] = 1;

        $this->preferenceRepoMock
            ->expects($this->once())
            ->method("deletePreferenceById")
            ->with($_POST['prefId']);

        $this->userController->deletePreference($this->preferenceRepoMock);

        $this->assertEquals('La préférence a été supprimée.', $_SESSION['message_to_User']);
        $this->assertEquals('success', $_SESSION['message_code']);
    }
}
