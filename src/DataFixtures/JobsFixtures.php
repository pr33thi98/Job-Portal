<?php

namespace App\DataFixtures;
use App\Entity\Jobs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $job = new Jobs();
        $date =  new \DateTime('@'.strtotime('now'));
        $job->setjob_location('kochi');
        $job->setjob_title("software developer");
        $job->setjob_description("should be have good programming knowldge");
        $job->setSkills("python,java,html,javascript,jquery");
        $job->setExperience(5);
        $job->setcreated_at($date);
        $job->setmodified_at($date);
        $job->setExpiry($date);

        $manager->persist($job);

        $manager->flush();
    }
}
