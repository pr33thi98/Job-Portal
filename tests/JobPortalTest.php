<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobPortalTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/list/job');
        $client ->enableProfiler();
        if ($profile = $client->getProfile())
        {
            $this->assertSelectorTextContains('h1', 'Listing of Jobs');
        }
        $this->assertLessThan(5,$profile->getCollector('db')->getQueryCount());
        $this->assertSelectorTextContains('h1', 'Listing of Jobs');
        $this->assertResponseIsSuccessful();
        
    }
    // public function testListing(): void
    // {
    //         $client = static::createClient();
    //         $crawler = $client ->request('GET','/delete/job/{id}');
    //         $client ->enableProfiler();
    //         if($profile = $client->getProfile())
    //         {
    //             $this->assertSelectorTextContains('')
    //         }
    // }
}
