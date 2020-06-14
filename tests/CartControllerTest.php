<?php

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
$session = new Session(new MockFileSessionStorage());


use App\Controller\CartController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Book;

class CartControllerTest extends WebTestCase
{
    public function testCartIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
}