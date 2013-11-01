<?php

namespace Tracko\CoreBundle\Services;

use Symfony\Component\Routing\RouterInterface;

/**
 * Class CacheService
 *
 * @author Tobias Nyholm
 *
 * Use this service to control the cache
 *
 */
class CacheService
{

    /**
     * @var \Symfony\Component\Routing\RouterInterface router
     *
     *
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Invalidate the cache
     *
     * @param string $url
     *
     * @return bool true if cache was purged
     */
    protected function invalidateCache($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $status == 200;
    }

    /**
     * Invalidate cache for a route
     *
     * @param string $route
     * @param array $parameters
     *
     * @return bool true if cache was purged
     */
    public function invalidateRoute($route, array $parameters = array())
    {
        $url = $this->router->generate($route, $parameters, true);

        return $this->invalidateCache($url);
    }

    /**
     * Invalidate cache for a url
     *
     * @param string $url
     *
     * @return bool true if cache was purged
     */
    public function invalidateUrl($url)
    {
        return $this->invalidateCache($url);
    }
}