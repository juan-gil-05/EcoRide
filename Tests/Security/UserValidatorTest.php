<?php

namespace App\Tests\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserValidator;
use PHPUnit\Framework\TestCase;

class UserValidatorTest extends TestCase
{
    private UserValidator $userValidator;
    private User $user;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        $this->user = new User();
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->userValidator = new UserValidator($this->userRepositoryMock);
    }

    public function testSignupFormWithEmptyData(): void
    {
        $errors = $this->userValidator->signUpValidate($this->user, "");
        $this->assertArrayHasKey("pseudoEmpty", $errors);
        $this->assertArrayHasKey("mailEmpty", $errors);
        $this->assertArrayHasKey("passwordEmpty", $errors);
        $this->assertArrayHasKey("roleEmpty", $errors);
    }

    public function testSignupFormWithInvalidMail(): void
    {
        $this->user->setMail("invalidMail");
        $errors = $this->userValidator->signUpValidate($this->user, "");
        $this->assertArrayHasKey("mail", $errors);
    }

    public function testSignupFormWithExistingMail(): void
    {
        $this->user->setMail("existing@example.com");
        $this->userRepositoryMock->method('findOneByMail')->willReturn($this->user);
        $errors = $this->userValidator->signUpValidate($this->user, "");
        $this->assertArrayHasKey("mailUsed", $errors);
    }

    public function testSignupFormWithInvalidPasswordLessThanTwelveCharacters(): void
    {
        $this->user->setPassword("weakpass");
        $errors = $this->userValidator->signUpValidate($this->user, "");
        $this->assertArrayHasKey("passwordLen", $errors);
    }

    public function testSignupFormWithInvalidPasswordNotSecure(): void
    {
        $this->user->setPassword("NotSecurepassword");
        $errors = $this->userValidator->signUpValidate($this->user, "");
        $this->assertArrayHasKey("passwordInfo", $errors);
    }

    public function testSignupFormWithInvalidPasswordThatDoesntMatchsWithPasswordConfirm(): void
    {
        $this->user->setPassword("123456789Azerty!");
        $errors = $this->userValidator->signUpValidate($this->user, "notTheSamePassword");
        $this->assertArrayHasKey("passwordConfirm", $errors);
    }

    public function testHashingPasswordWorksCorrectly(): void
    {
        $this->user->setPassword(password_hash("passwordTest.", PASSWORD_DEFAULT));
        $this->assertTrue(password_verify("passwordTest.", $this->user->getPassword()));
    }
}
