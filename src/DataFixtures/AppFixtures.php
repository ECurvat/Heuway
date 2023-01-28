<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 25; $i++) {
            $service = new Service();
            $service->setNumeroGroupe(96)
            ->setDepot('MEY')
            ->setDebut(new \DateTime('2023-01-21 16:16:00'))
            ->setFin(new \DateTime('2023-01-21 23:36:00'))
            ->setPause(new \DateTime('2023-01-21 00:25:00'))
            ->setDispo(new \DateTime('2023-01-21 00:00:00'))
            ->setDeplacement(new \DateTime('2023-01-21 00:00:00'))
            ->setCoupure(new \DateTime('2023-01-21 00:00:00'))
            ->setLigne(4);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
