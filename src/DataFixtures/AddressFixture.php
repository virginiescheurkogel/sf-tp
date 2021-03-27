<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1; $i <= 20; $i++) {
            $address = new Address();
            $address->setStreet($faker->streetAddress)
                ->setZipCode($faker->postcode)
                ->setCity($faker->city);
            $manager->persist($address);

            // Ajout de l'adresse en référence pour plus tard
            $this->addReference("address_$i", $address);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixture::class
        ];
    }
}
