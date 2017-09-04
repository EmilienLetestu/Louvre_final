<?php
namespace tests\EL\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/06/2017
 * Time: 16:05
 */
class homeControllerTest extends WebTestCase
{

    public function testIndexAction()
    {
        $client = static::createClient();
        //check if page and route are matching
        $crawler = $client->request('GET','/accueil-billetterie');
        //check status code
        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        //Home page main title should be : "Bienvenue sur la billetterie du Louvre"
        $this->assertEquals(1, $crawler->filter('h1:contains("Bienvenue sur la billetterie du Louvre")')->count());
        $this->assertEquals(0, $crawler->filter('a#link_to_booking')->count());
    }

}