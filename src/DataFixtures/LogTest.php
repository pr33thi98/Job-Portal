<?php

namespace App\DataFixtures;

use App\Entity\Log;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LogTest extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $log = new Log();
        $log->setUserId(1);
        $log->setDescription("Login Success");
        $log->setLogTime(new \DateTime('now'));
        $log->setType(1);
        $log->setModule(1);
        $manager->persist($log);
        $manager->flush();
    }
}
