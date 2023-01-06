<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AdminTest extends WebTestCase

{

    public function testSomething(): void

    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/log');

        $client ->enableProfiler();

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        // $this->assertIsInt($response->);

        // $responseData = json_decode($response->getContent(), true);

        if ($profile = $client->getProfile())

        {

            // check the number of requests

            $this->assertLessThan(10,$profile->getCollector('db')->getQueryCount());

            $this->assertLessThan(500,$profile->getCollector('time')->getDuration());

        }
        // $client->xmlHttpRequest('POST', '/admin/log', ['page' => '2', 'type' => '0', 'module' => '2']);

        // $request = $client->getRequest();

        // print_r($request);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h3', 'Logs');

        }

}