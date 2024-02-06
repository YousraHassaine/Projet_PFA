<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use App\Entity\TypeRdv;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $typeRdv=new TypeRdv();
        $typeRdv->setLibelle("RDv1");
        $manager->persist($typeRdv);

        $spec=new Speciality();
        $spec->setNomSpeciality("s1");
        $manager->persist($spec);
        $manager->flush();
    }
}
