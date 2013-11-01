<?php

namespace Tracko\BaseBundle\Mocks;

use Tracko\BaseBundle\Mocks\Interfaces\MockInterface;

/**
 * Class RepositoryMock
 *
 * @author Tobias Nyholm
 *
 *
 */
class RepositoryMock implements MockInterface
{
    /**
     *
     *
     *
     * @return \Mockery\MockInterface|\Yay_MockObject
     */
    public static function getMock()
    {
        return \Mockery::mock();
    }
}
