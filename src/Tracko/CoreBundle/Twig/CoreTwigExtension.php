<?php
namespace Tracko\CoreBundle\Twig;

/**
 * Class CoreTwigExtension
 *
 * @author Tobias Nyholm
 *
 *
 */
class CoreTwigExtension extends \Twig_Extension
{
    private $container;

    /**
     * @param mixed $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        $token = $this->container->get('security.context')->getToken();
        $user = null;

        if ($token) { //it might be null
            $user = $token->getUser();
        }

        //you cant get request if there we run from CLI
        if (defined('STDIN')) {
            $cli = true;
        } else {
            $cli = false;
        }

        //we should only use _varname because that would indicate global vars. 
        return array(
            '_user' => $user,
            '_breadcrumbs' => array(),
            '_cli' => $cli,
        );
    }

    /**
     * Get filters
     *
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('age', array($this, 'ageFilter')),
            new \Twig_SimpleFilter('gender', array($this, 'genderFilter')),
            new \Twig_SimpleFilter('bool2int', array($this, 'bool2intFilter')),
        );
    }

    /**
     * get functions
     *
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('routerParams', array($this, 'routerParams')),
            new \Twig_SimpleFunction('arrayAppend', array($this, 'arrayAppend')),

        );
    }

    /**
     * Return the age of the date
     *
     * @param mixed $birthday
     *
     * @return string
     */
    public static function ageFilter($birthday)
    {
        $now = new \DateTime();
        if (is_object($birthday)) {
            $interval = $now->diff($birthday);
            if ($interval->y > 0) {
                return $interval->format('%y');
            }
        }

        return '--';
    }

    /**
     * return the gener
     *
     * @param int $gender
     * @param bool $onlylabel
     *
     * @return string
     */
    public static function genderFilter($gender, $onlylabel = false)
    {
        $label = '';
        if ($gender == 2) {
            $label = 'female';
        } elseif ($gender == 1) {
            $label = 'male';
        } else {
            $label = '';
        }
        if ($onlylabel) {
            return $label;
        } else {
            return 'profile.gender-options.' . $label;
        }
    }

    /**
     * Convert an bool to int
     *
     * @param bool $boolean
     *
     * @return int
     */
    public static function bool2intFilter($boolean)
    {
        return $boolean ? 1 : 0;
    }

    /**
     * Get router params
     *
     *
     * @return mixed
     */
    public function routerParams()
    {
        $router = $this->container->get('router');
        $request = $this->container->get('request');

        $routeName = $request->attributes->get('_route');
        $routeParams = $request->query->all();
        foreach ($router->getRouteCollection()->get($routeName)->compile()->getVariables() as $variable) {
            $routeParams[$variable] = $request->attributes->get($variable);
        }

        return $routeParams;
    }

    /**
     * Append array
     *
     * @param array $arr
     * @param mixed $entity
     *
     * @return array
     */
    public function arrayAppend(array $arr, $entity)
    {
        $arr[] = $entity;

        return $arr;
    }

    /**
     * Get the name of this extension
     *
     *
     * @return string
     */
    public function getName()
    {
        return 'CoreTwigExtension';
    }
}
