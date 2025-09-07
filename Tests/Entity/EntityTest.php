<?php

namespace App\Tests\Entity;

use App\Entity\Entity;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class EntityTest extends Testcase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testHydrateFunctionWorksCorrectly(): void
    {

        $data = array(
            'pseudo' => 'juan',
            'mail' => 'juan@example.com',
            'password' => 'pass123',
        );

        $this->user->hydrate($data);
        $this->assertNotEmpty($this->user);
    }

    public function testHydrateFunctionReturnsExceptionIfAnyDataPassed(): void
    {
        $this->expectException(\Exception::class);

        $data = array();

        $this->user->hydrate($data);
    }

    public function testHydrateFunctionReturnsExceptionIfMethodDoesntExist(): void
    {
        $this->expectException(\Exception::class);

        $data = array(
            'pseudo' => 'juan',
            'mail' => 'juan@example.com',
            'MotDePasse' => 'pass123',
        );

        $this->user->hydrate($data);
    }
}
