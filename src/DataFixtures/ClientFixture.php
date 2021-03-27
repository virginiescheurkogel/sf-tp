<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1; $i <= 20; $i++){
            $client = new Client();
            $client->setName($faker->name)
                   ->setFirstName($faker->firstName)
                    ->setAddress($this->getReference("address_". mt_rand(1,1000)));
            $manager->persist($client);

            // Ajout du client en référence pour plus tard
            $this->addReference("client_$i", $client);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return AddressFixture::class;
    }
}
