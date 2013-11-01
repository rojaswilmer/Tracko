<?php
namespace Eastit\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tracko\BaseBundle\DataFixtures\BaseFixture;
use Tracko\CompanyBundle\Entity\Company;
use Tracko\EventBundle\Entity\Event;

class LoadCompanyData extends BaseFixture
{


    public function load(ObjectManager $manager)
    {
        $company=new Company();

        $company->setName('Google');
        $this->addReference($company->getName(), 'Company', $company);
        $manager->persist($company);
        $manager->flush();

        $company=new Company();
        $company->setName('HappyRecruiting');
        $this->addReference($company->getName(), 'Company', $company);
        $manager->persist($company);
        $manager->flush();
    }

    public function getOrder()
    {
        return 100;
    }
}
