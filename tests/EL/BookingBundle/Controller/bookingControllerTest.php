<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/07/2017
 * Time: 22:16
 */

namespace tests\EL\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class bookingControllerTest extends WebTestCase
{

    public function testBookingAction()
    {
        $client = static::createClient();
        //check if page and route are matching
        $crawler = $client->request('GET','/reservation-billetterie');
        //check that user can't access page if order hasn't begun yet
        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testModifyAction()
    {
        $client = static::createClient();
        //check if page and route are matching
        $crawler = $client->request('GET','/modifier-ticket/1');
        //check that user can't access page if order hasn't begun yet
        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testDeleteAction()
    {
        $client = static::createClient();
        //check if page and route are matching
        $crawler = $client->request('GET','/supprimer-ticket/1');
        //check that user can't access page if order hasn't begun yet
        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }
}