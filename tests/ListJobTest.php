<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListJobTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/list/job/paginate');
        $response = $client->getResponse();
        // $this->assertNotEmpty($jobs);
        $this->assertNotEmpty($response->getContent());
        $this->assertSame('text/html; charset=UTF-8', $response->headers->get('Content-Type'));
        
    }
    public function testingApplicant():void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/paginate');
        $response = $client->getResponse();
        $this->assertNotEmpty($response->getContent());
        $this->assertSame('text/html; charset=UTF-8', $response->headers->get('Content-Type'));


    }
}
