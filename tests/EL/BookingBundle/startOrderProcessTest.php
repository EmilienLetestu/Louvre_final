<?php
namespace Tests\EL\BookingBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use EL\BookingBundle\Entity\Ticket;
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/07/2017
 * Time: 23:55
 */
class startOrderProcessTest extends WebTestCase
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

        //test form
        $form = $crawler->filter("form")->form();
        $crawler = $client->submit($form,[
            'check_status[temp_order_date]'       => '11-12-2019',
            'check_status[temp_number_of_tickets]'=> 2
        ]);
        //submit form
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('a#link_to_booking')->count());

        //click link
        $link = $crawler
            ->filter('a:contains("Commander des billets")')
            ->link()
        ;

        $crawler = $client->click($link);

        //check page and route match
        $crawler = $client->request('GET','/reservation-billetterie');
        //check status code
        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        //check page content
        $this->assertEquals(1, $crawler->filter('h1:contains("Commander pour ma visite")')->count());
        $this->assertEquals(1, $crawler->filter('body:contains("Votre commande va")')->count());
        $this->assertEquals(0, $crawler->filter('table')->count());

        //form
        $form = $crawler->filter("form")->form();
        $form['ticket[name]'] = 'emilien';
        $form['ticket[surname]'] = 'letestu';
        $form['ticket[dob][day]']->select('19');
        $form['ticket[dob][month]']->select('05');
        $form['ticket[dob][year]']->select('1980');
        $form['ticket[time_access]']->select('a.m.');
        $form['ticket[discount]']->tick();
        //submit form
        $crawler = $client->submit($form);
        //get form values
        $values = $form->getValues();
        //test some values on ticket entity
        $ticket = new Ticket();

        $dob_values = [$values['ticket[dob][day]'],$values['ticket[dob][month]'],$values['ticket[dob][year]']];
        $dob = "{$dob_values[0]}-{$dob_values[1]}-{$dob_values[2]}";

        $ticket->setName($values['ticket[name]']);
        $ticket->setSurname($values['ticket[surname]']);
        $ticket->setDob($dob);
        $ticket->setDiscount($values['ticket[discount]']);

        $this->assertEquals('Emilien',$ticket->getName());
        $this->assertEquals('Letestu',$ticket->getSurname());
        $this->assertEquals('19-05-1980',$ticket->getDob());
        $this->assertEquals(1,$ticket->getDiscount());

        $this->assertEquals(
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}