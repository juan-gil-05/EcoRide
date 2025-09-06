<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testUserHasDefaultCredits(): void
    {
        $this->assertEquals(20, $this->user->getNbCredits());
    }

    public function testUserIsActifByDefault(): void
    {
        $this->assertEquals(1, $this->user->getActive());
    }

    public function testUserLoginAttemptsStartsAtZero(): void
    {
        $this->assertEquals(0, $this->user->getLoginAttempts());
    }

    public function testUserIsNotLockedByDefault(): void
    {
        $this->assertNull($this->user->getLockedUntil());
    }
}
