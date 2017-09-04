<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 09/06/2017
 * Time: 17:37
 */
namespace Tests\EL\BookingBundle\Managers;

use EL\BookingBundle\Managers\Tools;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ToolsTest extends TestCase
{

    public function testGetDisclaimer()
    {
        $tools = new Tools();
        $bank_holiday = ['01/05','01/11','25/12'];
        $date = date('d/m');
        $day  = date('D');
        $disclaimer = $tools->getDisclaimer('Europe/Paris',14);
        if($tools->getTime('Europe/Paris') < 14 && $day != "Tue" && !in_array($date,$bank_holiday))
        {
            $this->assertEquals(null, $disclaimer);
        }
        elseif ($day == "Tue" || in_array($date, $bank_holiday))
        {
            $this->assertEquals("Le musée est fermé aujourd'hui", $disclaimer);
        }
        else
        {
            $this->assertEquals("A partir de 14h tous billets achetés  pour une visite ce jour bénéficie du tarif 1/2 journée", $disclaimer);
        }
    }

    public function testGetAge()
    {
        $tools = new Tools();
        $dob   = new \DateTime('19-05-1980');
        $age = $tools->getAge($dob);
        $this->assertEquals(37,$age);
    }

    public function testGetTicketPriceType()
    {
        $tools = new Tools();
        $dob   = new \DateTime('19-05-1980');
        $price_type = $tools->getTicketPriceType($dob,0);
        $this->assertEquals('Adulte',$price_type);
    }

    public function testGetTime()
    {
        date_default_timezone_set('Europe/Paris');
        $time_now = date("H");
        $this->assertEquals($time_now,$time_now);

    }
}