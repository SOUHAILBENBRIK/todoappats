<?php

namespace App\DataFixtures;

use App\Entity\Priority;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $priorities = [
            [
                'name' => 'Low',
                'level' => 0,
            ],
            [
                'name' => 'Medium',
                'level' => 1,
            ],
            [
                'name' => 'High',
                'level' => 2,
            ],
        ];

        $statuses = ['Pending', 'In Progress', 'Completed'];

        // Ensure Priorities exist
        foreach ($priorities as $priorityName) {
            if (!$manager->getRepository(Priority::class)->findOneBy(['name' => $priorityName])) {
                $priority = new Priority();
                $priority->setName($priorityName['name']);
                $priority->setLevel($priorityName['level']);
                $manager->persist($priority);
            }
        }

        // Ensure Statuses exist
        foreach ($statuses as $statusName) {
            if (!$manager->getRepository(Status::class)->findOneBy(['name' => $statusName])) {
                $status = new Status();
                $status->setName($statusName);
                $manager->persist($status);
            }
        }

        $manager->flush();
    }
}
