<?php

namespace Tracko\UserBundle\Services;

use Tracko\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class SecurityService
 *
 * This handles the secruity of the user... Like passwords and login sessions
 *
 * @package Eastit\UserBundle\Services
 */
class SecurityService
{
    /**
     * @var SecurityContextInterface $securityContext
     *
     */
    protected $securityContext;

    /**
     * @var EventDispatcherInterface $eventDispatcher
     *
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, SecurityContextInterface $securityContext)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->securityContext = $securityContext;
    }

    /**
     * Sign in a user to the current session
     *
     * @param User $user
     * @param Request $request
     */
    public function loginUser(User $user, Request $request)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'default', $user->getRoles());
        $this->securityContext->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch(UserEvents::LOGIN, $event);

    }
}
