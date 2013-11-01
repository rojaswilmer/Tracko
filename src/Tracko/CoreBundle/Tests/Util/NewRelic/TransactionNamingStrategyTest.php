<?php

namespace Tracko\CoreBundle\Tests\Util\NewRelic;

use Tracko\CoreBundle\Util\NewRelic\TransactionNamingStrategy;
use Mockery as m;

/**
 * Class TransactionNamingStrategyTest
 *
 *
 */
class TransactionNamingStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if the name is what we expect
     */
    public function testGetTransactionName()
    {
        $request = m::mock('Symfony\Component\HttpFoundation\Request')
            ->shouldReceive('get')->with('_controller')->once()
            ->andReturn('Tracko\User\UserBundle\Controller\SecurityController::loginAction')->getMock();

        $tns = new TransactionNamingStrategy();

        $this->assertEquals('Tracko\User\UserBundle\Security::loginAction', $tns->getTransactionName($request));
    }
}
