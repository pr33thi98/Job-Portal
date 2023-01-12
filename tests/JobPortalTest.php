<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobPortalTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/list/job');
        $this->assertSelectorTextContains('h1', 'Listing of Jobs');
        $this->assertResponseIsSuccessful();
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
    }
    public function testApplicantlisting(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/applicant');
        $this->assertSelectorTextContains('h1', 'Applicant Details');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

    }
}
