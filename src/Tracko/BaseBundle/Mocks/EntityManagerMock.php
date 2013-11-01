<?php

namespace Tracko\BaseBundle\Mocks;

use Tracko\BaseBundle\Mocks\Interfaces\MockInterface;

/**
 * Class EntityManagerMock
 *
 * @author Tobias Nyholm
 *
 *
 */
class EntityManagerMock implements MockInterface
{
    /**
     *
     *
     *
     * @return \Mockery\MockInterface|\Yay_MockObject
     */
    public static function getMock()
    {
        return \Mockery::mock(
            '\Doctrine\ORM\EntityManager',
            array(
                'persist' => null,
                'remove' => null,
                'flush' => null,
            )
        );
    }
}
