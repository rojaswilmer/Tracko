<?php

namespace Tracko\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Create and load cookies
 *
 */
class CookieService
{
    /**
     * @var string|\Symfony\Component\HttpFoundation\Request request
     *
     *
     */
    private $request;

    /**
     *
     *
     * @param Request $request
     *
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Return the value of a cookie
     *
     * @param string $name
     *
     * @return mixed|false
     */
    public function getCookieValue($name)
    {
        if ($this->request === null) {
            return false;
        }

        $cookies = $this->request->cookies;
        if ($cookies->has($name)) {
            return $cookies->get($name);
        }

        return false;
    }

    /**
     * Set a cookie value
     *
     * @param string $name The name of the cookie
     * @param string $value The value of the cookie
     * @param integer|string|\DateTime $expire The time the cookie expires
     * @param boolean $httpOnly Whether the cookie will be made accessible only through the HTTP protocol
     *
     */
    public function setCookie($name, $value, $expire = 0, $httpOnly = true)
    {
        $response = new Response();
        $response->headers->setCookie(new Cookie($name, $value, $expire, '/', null, false, $httpOnly));
        $response->sendHeaders();
    }
}