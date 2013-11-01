<?php

namespace Tracko\CoreBundle\Tests\Services;

use Tracko\CoreBundle\Services\StringEncryptionService;
use Tracko\CoreBundle\Services\StringService;

/**
 * Class StringEncryptionServiceTest
 *
 *
 */
class StringEncryptionServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if the encryption is symmetric
     */
    public function testSymetricEncryption()
    {
        $es = new StringEncryptionService(new StringService());
        $this->assertEquals('test', $es->decode($es->encode('test')));
        $this->assertEquals('täst', $es->decode($es->encode('täst')));
        $this->assertEquals('t34st', $es->decode($es->encode('t34st')));
        $this->assertEquals('t#e&t', $es->decode($es->encode('t#e&t')));
        $this->assertEquals('1233', $es->decode($es->encode('1233')));

        $email = 'tobias@webfish.se';
        $this->assertEquals($email, $es->decode($es->encode($email)));

        $email = 'tobi-as.nyho@webfish.se';
        $this->assertEquals($email, $es->decode($es->encode($email)));

        $email = 'töbias@webfish.com';
        $this->assertEquals($email, $es->decode($es->encode($email)));

        $email = 'tobOSaas@web.bVV-sh.se';
        $this->assertEquals($email, $es->decode($es->encode($email)));
    }
}
