<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 09/06/2017
 * Time: 22:29
 */

namespace Tests\EL\BookingBundle\Entity;

use EL\BookingBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TicketTest extends TestCase
{
    public function testTicket()
    {
        $dob = new \DateTime('19-05-1980');
        $date = new \DateTime('05-12-2017');

        $ticket = new Ticket();
        $ticket->setDate($date);
        $ticket->setName('emilien');
        $ticket->setSurname('letestu');
        $ticket->setDob($dob);
        $ticket->setDiscount(1);
        $ticket->setToken('emilien','letestu');
        $ticket->setTimeAccess('a.m.');
        $ticket->setPrice(16);
        $ticket->setPriceType($dob,$ticket->getDiscount());
        $ticket->setTimeAccessType('a.m.');
        $ticket->setOrderToken('Commande n°: 592fd5b3d95bd');

        $expected_dates = [$date,$dob];
        static::assertEquals($expected_dates[0],$ticket->getDate());
        static::assertEquals('Emilien',$ticket->getName());
        static::assertEquals('Letestu',$ticket->getSurname());
        static::assertEquals($expected_dates[1],$ticket->getDob());
        static::assertEquals(1,$ticket->getDiscount());
        static::assertContains('E_L: ',$ticket->getToken());
        static::assertEquals('a.m.',$ticket->getTimeAccess());
        static::assertEquals(16,$ticket->getPrice());
        static::assertEquals('Tarif réduit',$ticket->getPriceType());
        static::assertEquals('journée complète',$ticket->getTimeAccessType());
        static::assertEquals('Commande n°: 592fd5b3d95bd',$ticket->getOrderToken());
    }
}