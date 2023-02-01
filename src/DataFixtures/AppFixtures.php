<?php

namespace App\DataFixtures;

use App\Entity\Contrat;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contrat = new Contrat();
        $contrat->setDebut(new \DateTime('2023-01-12 00:00:00'))
        ->setFin(new \DateTime('2023-01-12 00:00:00'))
        ->setId(20233);

        $manager->persist($contrat);

        for($i = 0; $i < 25; $i++) {
            $service = new Service();
            $service->setNumeroGroupe(96)
            ->setDepot('MEY')
            ->setDebut(new \DateTime('2023-01-21 16:16:00'))
            ->setFin(new \DateTime('2023-01-21 23:36:00'))
            ->setPause(new \DateTime('2023-01-21 00:43:00'))
            ->setDispo(new \DateTime('2023-01-21 00:07:00'))
            ->setDeplacement(new \DateTime('2023-01-21 00:25:00'))
            ->setCoupure(new \DateTime('2023-01-21 00:00:00'))
            ->setLigne(4)
            ->setContrat($contrat);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
