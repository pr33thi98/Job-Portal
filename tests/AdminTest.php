<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/log');
        // $this->assertCount(4,$crawler->filter(.table));
        // $this->assertResponseIsSuccessful();
         $this->assertSelectorTextContains('h3', 'Logs');
    }
}
