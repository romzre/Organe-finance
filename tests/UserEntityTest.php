<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    public function testGetterAndSetterUser()
    {
        $user = new User();

        $password = "passwordTest";
        $token = random_bytes(20);

        $user->setEmail('user@test.com')
            ->setRoles(["ROLE_USER"])
            ->setPassword($password)
            ->setConfirm_password($password)
            ->setisVerify(true)
            ->setToken($token)
        ;

        $this->assertTrue($user->getEmail() === 'user@test.com');
        $this->assertTrue($user->getRoles() === ["ROLE_USER"]);
        $this->assertTrue($user->getPassword() === $password);
        $this->assertTrue($user->getConfirm_password() === $password);
        $this->assertTrue($user->isIsVerify() === true);
        $this->assertTrue($user->getToken() === $token);

    }

    public function testisFalse()
    {
        $user = new User();

        $password = "passwordTest";
        $date = new \DateTimeImmutable();
        $token = random_bytes(20);

        $user->setEmail('user@test.com')
            ->setRoles(['customer', "ROLE_USER"])
            ->setPassword($password)
            ->setConfirm_password($password)
            ->setisVerify(true)
            ->setUsername("Username")
            ->setToken($token)
        ;

        $this->assertFalse($user->getEmail() === 'user@false.com');
        $this->assertFalse($user->getRoles() === ['customer', "ROLE_ADMIN"]);
        $this->assertFalse($user->getPassword() === $password."false");
        $this->assertFalse($user->getConfirm_password() === $password."false");
        $this->assertFalse($user->getUsername() === "UsernameTestF");
        $this->assertFalse($user->isIsVerify() === false);
        $this->assertFalse($user->getToken() === $token."false");

    }

    public function testisEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEquals($user->getRoles(), ["ROLE_USER"]);
        $this->assertEmpty($user->getUsername());
        $this->assertEmpty($user->isIsVerify());
        $this->assertEmpty($user->getToken());

    }
}
