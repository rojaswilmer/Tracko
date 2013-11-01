<?php

namespace Tracko\BaseBundle\Factory;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * This is the super class of all Factory objects
 */
abstract class BaseFactory
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager $em
     *
     *
     */
    protected $em;

    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Magic function to make factories better =)
     *
     * @param string $function
     * @param mixed $parameters
     *
     * @return mixed|void
     * @throws Exception
     */
    public function __call($function, $parameters)
    {
        if (method_exists($this, $function . sizeof($parameters))) {
            return call_user_func_array(array($this, $function . sizeof($parameters)), $parameters);
        }
        // function does not exist
        switch ($function) {
            case 'getNew';

                return $this->_getNew();
            case 'create';
            case 'save';

                return $this->_create(array_shift($parameters));
            case 'remove';

                return $this->_remove(array_shift($parameters));
        }

        throw new \Exception('Tried to call unknown method ' . get_class($this) . '::' . $function);
    }

    /**
     * Returns a new object with all empty values
     *
     * @return object
     */
    private function _getNew()
    {
        $class = $this->_getFqn();

        return new $class();
    }

    /**
     * Guess a good class for create new
     *
     *
     * @return string
     * @throws \Exception
     */
    private function _getFqn()
    {
        $fqn = get_class($this);
        //$class is after last / and before "Factory"
        $class = substr($fqn, strrpos($fqn, '\\'), -7);

        //get a namespace
        $namespace = substr($fqn, 0, strrpos($fqn, 'Bundle') + 7) . 'Entity';

        $newFqn = $namespace . $class;
        if (!class_exists($newFqn)) {
            throw new \Exception(sprintf(
                'You must implement the getNew-function in %s. We failed to guess what you wanted to create',
                $fqn
            ));
        }

        return $newFqn;
    }

    /**
     * Create takes a populated object, it may run some function on it.
     * Finally we will persist and flush the object for the first time
     *
     * @param mixed $object
     *
     */
    private function _create($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    /**
     * Remove and flush
     *
     * @param mixed $object
     *
     */
    public function _remove($object)
    {
        $this->em->remove($object);
        $this->em->flush();
    }
}
