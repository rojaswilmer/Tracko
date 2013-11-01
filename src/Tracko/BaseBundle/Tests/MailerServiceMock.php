<?php

namespace Tracko\BaseBundle\Tests;

use Tracko\Communication\MailerBundle\Entity\Mail;

use Mockery as m;

/**
 * Class MailerServiceMock
 *
 * A class to get a mailer serivce with mocked dependencies
 */
class MailerServiceMock
{
    /**
     * Mock a mailer class
     *
     * @param string $class fqn for the mailer service to mock
     * @param array $param with additional mocks to be used as params
     * @param int $callsToSend how many times the send function should be called
     *
     * @return Object of $class with mocked dependencies
     */
    public static function getWithMockedDep($class, array $param = array(), $callsToSend = 1)
    {
        $mailSender = m::mock('\Tracko\Communication\MailerBundle\Services\MailSenderService');
        $mailSender->shouldReceive('send')->times($callsToSend)->andReturn(true);

        $mail = new Mail();

        $mailFactory = m::mock(
            '\Tracko\Communication\MailerBundle\Factory\MailFactory',
            array(
                'getNew' => $mail,
                'create' => null,
                'remove' => null,
            )
        );
        $mailFactory
            ->shouldReceive('setup')->andReturn($mailFactory)
            ->shouldReceive('addCategory')->andReturn($mailFactory);

        return new $class($mailSender, $mailFactory, $param);
    }
}
