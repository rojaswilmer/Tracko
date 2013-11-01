<?php

namespace Tracko\BaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class BaseCommand
 *
 * @author Tobias Nyholm
 *
 */
abstract class BaseCommand extends ContainerAwareCommand
{
    private $em;

    /**
     * Get the entity manager
     *
     * @param string $name (optional)
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEntityManager($name = null)
    {
        if ($this->em == null) {
            $this->em = $this->getContainer()->get('doctrine')->getManager($name);
        }

        return $this->em;
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
     * Just a simple alias
     *
     * @param string $service
     *
     * @return object
     */
    protected function get($service)
    {
        return $this->getContainer()->get($service);
    }
}