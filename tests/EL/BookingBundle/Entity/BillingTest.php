<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/06/2017
 * Time: 12:47
 */

namespace Tests\EL\BookingBundle\Entity;

use EL\BookingBundle\Entity\Billing;
use EL\BookingBundle\Managers\Tools;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BillingTest extends TestCase
{
    public function testBilling()
    {
        $tools = new Tools();
        $date_time  = $tools->formatDate('12-12-2020');
        static::assertEquals('12-12-2020 00:00:00',$date_time);

        $billing = new Billing();
        $billing->setEmail('letestu@gmail.com');
        $billing->setName('emilien');
        $billing->setSurname('letestu');
        $billing->setNumberOfTickets(1);
        $billing->setVisitDay(\DateTime::createFromFormat('d-m-Y H:i:s',$date_time));
        $billing->setToken('Commande n°: 5942b7e97e0dd');
        $billing->setStripeToken('tok_1AWS82LvrvnGcwjUzY31imqw');
        $billing->setPrice(16);

        static::assertEquals('letestu@gmail.com',$billing->getEmail());
        static::assertEquals('Emilien',$billing->getName());
        static::assertEquals('Letestu',$billing->getSurname());
        static::assertEquals(1,$billing->getNumberOfTickets());
        static::assertEquals(\DateTime::createFromFormat('d-m-Y H:i:s','12-12-2020 00:00:00'),$billing->getVisitDay());
        static::assertEquals('Commande n°: 5942b7e97e0dd',$billing->getToken());
        static::assertEquals('tok_1AWS82LvrvnGcwjUzY31imqw',$billing->getStripeToken());
        static::assertEquals(16,$billing->getPrice());

    }
}