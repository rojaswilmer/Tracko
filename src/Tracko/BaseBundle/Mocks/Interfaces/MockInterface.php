<?php

namespace Tracko\BaseBundle\Mocks\Interfaces;

/**
 * Class MockInterface
 *
 * @author Tobias Nyholm
 *
 *
 */
interface MockInterface
{
    /**
     * This will return a fake object. This object is not meant to be used to run tests on. You should use
     * this object to make sure your tests are unit.
     */
    public static function getMock();
}
