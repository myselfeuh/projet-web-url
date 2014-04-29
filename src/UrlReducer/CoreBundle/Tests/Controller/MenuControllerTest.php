<?php

namespace UrlReducer\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    public function testUser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user');
    }

    public function testMember()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/member');
    }

}
