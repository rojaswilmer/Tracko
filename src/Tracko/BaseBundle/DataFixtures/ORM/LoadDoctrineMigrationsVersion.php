<?php
namespace Tracko\BaseBundle\DataFixtures\ORM;

use Symfony\Component\Finder\Finder;
use Doctrine\Common\Persistence\ObjectManager;
use Tracko\BaseBundle\DataFixtures\BaseFixture;

/**
 * Class LoadDoctrineMigrationsVersion
 *
 * @author Tobias Nyholm
 *
 * Populate the migrations table
 */
class LoadDoctrineMigrationsVersion extends BaseFixture
{

    /**
     *
     *
     * @param ObjectManager $em
     *
     */
    public function load(ObjectManager $em)
    {
        return;
        $this->basePath = $this->container->get('kernel')->getRootDir() . '/../app/DoctrineMigrations/';

        try {
            $res = $em->getConnection()->fetchColumn('SELECT version FROM migration_versions');
            if (strlen($res) > 3) {
                //do nothing if you already have a migration
                return;
            }
        } catch (\Exception $e) {
            //proceed
        }

        //Only if we don't have any migrations
        $versions = $this->findMigrationVersions();

        $this->createTable($em);
        foreach ($versions as $version) {
            $em->getConnection()->query(
                'INSERT INTO migration_versions SET version="' . $version . '"'
            );
        }
    }

    /**
     * Create the table
     *
     * @param ObjectManager &$em
     *
     */
    protected function createTable(ObjectManager &$em)
    {
        $em->getConnection()->query(
            '
                    DROP TABLE IF EXISTS migration_versions;
                    '
        );

        $em->getConnection()->query(
            '
                    CREATE TABLE `migration_versions` (
                      `version` varchar(255) NOT NULL,
                      PRIMARY KEY (`version`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    '
        );
    }

    /**
     * Get the latest migration
     *
     *
     * @return array
     */
    protected function findMigrationVersions()
    {
        $finder = new Finder();
        $finder->files()->in($this->basePath);
        $finder->sortByName();

        $versions = array();
        foreach ($finder as $file) {
            $versions[] = substr($file->getFilename(), 7, -4);
        }

        return $versions;
    }

    /**
     * Get the order
     *
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
