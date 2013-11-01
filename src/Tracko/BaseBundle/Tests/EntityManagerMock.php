<?php

namespace Tracko\BaseBundle\Tests;

use Tracko\BaseBundle\Mocks\Interfaces\MockInterface;

/**
 * Class EntityManagerMock
 *
 * Mock the entity manager
 */
class EntityManagerMock implements MockInterface
{
    /**
     * Get the mock
     *
     *
     * @return \Mockery\MockInterface
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
