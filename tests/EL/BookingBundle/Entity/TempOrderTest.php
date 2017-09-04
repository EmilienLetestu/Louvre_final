<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 09/06/2017
 * Time: 17:36
 */
namespace Tests\EL\BookingBundle\Entity;

use EL\BookingBundle\Entity\TempOrder;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
class TempOrderTest extends TestCase
{
    public function testTempOrder()
    {
        $temp_order = new TempOrder();
        $temp_order->setTempNumberOfTickets(10);
        $temp_order->setTempOrderDate('05-12-2017 00:00:00');
        $temp_order->setTempOrderToken('Commande n°: ');

        static::assertEquals(10,$temp_order->getTempNumberOfTickets());
        static::assertEquals('05-12-2017 00:00:00',$temp_order->getTempOrderDate());
        static::assertContains('Commande n°: ',$temp_order->getTempOrderToken());

    }
}