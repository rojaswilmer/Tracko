<?php

namespace Tracko\CoreBundle\Twig;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class MoreExtension
 *
 * A twig extension to truncate strings
 */
class MenuExtension extends \Twig_Extension
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
     * @inherit
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isRoute', array($this, 'isRoute')),
        );
    }

    /**
     * Returns true if any route in $routes matches the current route
     *
     * @param string|array $routes
     *
     * @return bool
     */
    public function isRoute($routes)
    {
        if ($this->request === null) {
            return false;
        }

        if (!is_array($routes)) {
            $routes = array($routes);
        }

        $currentRoute = $this->request->get('_route');
        foreach ($routes as $route) {
            if ($route == $currentRoute) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inherit
     *
     * @return string
     */
    public function getName()
    {
        return 'menu_extension';
    }
}