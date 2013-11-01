<?php

namespace Tracko\BaseBundle\Mocks;

use Tracko\BaseBundle\Mocks\Interfaces\MockInterface;

use Mockery as m;

/**
 * Class SecurityEncoderFactoryMock
 *
 * @author Tobias Nyholm
 *
 *
 */
class SecurityEncoderFactoryMock implements MockInterface
{
    /**
     *
     *
     *
     * @return m\MockInterface|\Yay_MockObject
     */
    public static function getMock()
    {
        $encoder = m::mock()
            ->shouldReceive('encodePassword')->andReturn('encodedPassword');

        return m::mock(
            '\Symfony\Component\Security\Core\Encoder\EncoderFactory',
            array(
                'getEncoder' => $encoder,
            )
        );
    }
}
