<?php

namespace Tracko\BaseBundle\Manager;

use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class BaseSecurityManager
 *
 * This is the base security manager that every security manager should inherit from
 */
abstract class BaseSecurityManager
{
    /**
     * @var SecurityContextInterface context
     *
     *
     */
    protected $context;

    /**
     * Default constructor
     *
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->context = $securityContext;
    }

    /**
     * Does the current user have $mask permissions on $object?
     *
     * @param string $mask can be VIEW, EDIT, DELETE, OPERATOR etc
     * @param mixed &$object any entity
     *
     * @return boolean
     */
    protected function userIsGranted($mask, &$object)
    {
        // check for access with ACL
        return $this->context->isGranted($mask, $object);
    }
}