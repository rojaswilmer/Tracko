<?php

namespace Tracko\CoreBundle\Twig;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class MoreExtension
 *
 * A twig extension to truncate strings
 */
class StaticExtension extends \Twig_Extension
{

    /**
     * @inherit
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('static', array($this, 'getStaticVar')),
            new \Twig_SimpleFunction('staticCall', array($this, 'getStaticCall')),
        );
    }

    /**
     * Return the value of the static variable or null if not found
     *
     * @param string $class
     * @param string $property
     *
     * @return mixed|null
     */
    public function getStaticVar($class, $property)
    {
        if (property_exists($class, $property)) {

            return $class::$$property;
        }

        return null;
    }

    /**
     * Return the result of a call to static function
     *
     * @param string $class
     * @param string $function
     * @param mixed $args
     *
     * @return mixed|null
     */
    public function getStaticCall($class, $function, $args = null)
    {
        if (class_exists($class) && method_exists($class, $function)) {

            return $class::$function($args);
        }

        return null;
    }

    /**
     * @inherit
     *
     * @return string
     */
    public function getName()
    {
        return 'static_extension';
    }
}