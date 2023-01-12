<?php

namespace App\Tests;
use App\Enity\Admin;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(AdminRepository::class);
       // $email = 'bestyphilip900@gmail.com';
        // $testUser = $userRepository->find($email);
        // $testUser = $userRepository->findOneByemail('bestyphilip900@gmail.com');
        //print_r($testUser);
        // $client->loginUser($testUser);
        $client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello AdminController! ✅');
    }
}
