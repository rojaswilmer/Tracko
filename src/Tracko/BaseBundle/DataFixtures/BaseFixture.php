<?php
namespace Tracko\BaseBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class BaseFixture
 *
 * @author Tobias Nyholm
 *
 *
 */
abstract class BaseFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;
    protected $basePath = null;

    /**
     *
     *
     * @param ContainerInterface $container
     *
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Generate the reference slug
     *
     * @param string $name
     * @param string $prefix
     *
     * @return string
     */
    protected function generateReferenceSlug($name, $prefix = null)
    {
        return $prefix . '-' . md5(mb_strtolower($name, 'UTF-8'));
    }

    /**
     * Create a reference slug and saves the object.
     *
     * This may override previous references
     *
     * @param string $name
     * @param object $prefix
     * @param null $object
     *
     */
    public function setReference($name, $prefix, $object = null)
    {
        if ($object === null) { //incase we dont use two parameters
            $object = $prefix;
            $prefix = null;
        }

        parent::setReference($this->generateReferenceSlug($name, $prefix), $object);
    }

    /**
     * Create a reference slug and saves the object.
     *
     * This may NOT override previous references. We will get an error
     *
     * @param string $name
     * @param object $prefix
     * @param null $object
     *
     */
    public function addReference($name, $prefix, $object = null)
    {
        if ($object === null) { //incase we dont use two parameters
            $object = $prefix;
            $prefix = null;
        }

        parent::addReference($this->generateReferenceSlug($name, $prefix), $object);
    }

    /**
     * Returns an object form refrence
     *
     * @param string $name
     * @param null $prefix
     *
     * @return object
     */
    public function getReference($name, $prefix = null)
    {
        return parent::getReference($this->generateReferenceSlug($name, $prefix));
    }

    /**
     * Load a yml file into an array. The file path must be relative to the $this->basePath
     *
     * @param string $filepath
     *
     * @return mixed
     * @throws \RuntimeException
     */
    protected function parseYml($filepath)
    {
        if ($this->basePath == null) {
            throw new \RuntimeException(
                'You must specify $this->basePath in the fixture-file before you can use parseYml()'
            );
        }

        $yaml = new Parser();
        $file = '';
        try {
            $file = $yaml->parse(file_get_contents($this->basePath . $filepath));
        } catch (ParseException $e) {
            throw new \RuntimeException(
                'Error parsing file: ' . $this->basePath . $filepath . '\n Unable to parse the YAML string: '
                . $e->getMessage()
            );
        }

        return $file;
    }
}
