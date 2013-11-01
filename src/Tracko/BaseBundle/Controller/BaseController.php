<?php

namespace Tracko\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BaseController
 *
 * Every controller should inherit from this class. Here is some good to have functions
 */
abstract class BaseController extends Controller
{
    /**
     * Get the entity manager
     *
     * @param string $name (optional)
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEntityManager($name = null)
    {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * Return a repository for that entity
     *
     * @param string $entity
     * @param \Doctrine\Common\Persistence\ObjectManager $em (optional)
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepo($entity, $em = null)
    {
        if (!$em) {
            $em = $this->getEntityManager();
        }

        return $em->getRepository($entity);
    }

    /**
     * This is an alias for the parents getUser. We have this one to improve the doc
     *
     *
     * @return \Tracko\User\UserBundle\Entity\User
     */
    public function getUser()
    {
        return parent::getUser();
    }

    /**
     * Better for url generation
     *
     * @param mixed $object
     * @param string $string
     * @param array $cmpObj
     * @param bool $absolute
     *
     * @return string url
     */
    public function blaze($object, $string, array $cmpObj = array(), $absolute = false)
    {
        return $this->get('happy_r_blaze.blaze_service')->getPath($object, $string, $cmpObj, $absolute);
    }

    /**
     * Add a flash message
     *
     * @param string $type (success|fail|warning|notice)
     * @param string $message
     *
     */
    public function addFlash($type, $message)
    {
        $this->get('session')->getFlashbag()->add($type, $message);
    }
}
