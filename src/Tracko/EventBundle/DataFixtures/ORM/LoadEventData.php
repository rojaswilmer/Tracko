<?php
namespace Eastit\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tracko\BaseBundle\DataFixtures\BaseFixture;
use Tracko\EventBundle\Entity\Event;

class LoadEventsData extends BaseFixture
{


    public function load(ObjectManager $manager)
    {
        $event=new Event();
        $event->setName('Clean the park')
            ->setAddress('Victoria St')
            ->setFounding(400)
            ->setDate(new \DateTime('+1 week'))
            ->setCompany($this->getReference('Google','Company'));

        $manager->persist($event);
        $manager->flush();

        $event=new Event();
        $event->setName('Run a marathon')
            ->setAddress('Dublin')
            ->setFounding(400)
            ->setDate(new \DateTime('-1 day'))
            ->setCompany($this->getReference('HappyRecruiting','Company'));

        $manager->persist($event);
        $manager->flush();
    }

    public function getOrder()
    {
        return 120;
    }
}
