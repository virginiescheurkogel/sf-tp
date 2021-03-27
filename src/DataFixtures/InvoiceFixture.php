<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class InvoiceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=1; $i <= 20; $i++) {
            $invoice = new Invoice();
            $invoice->setDate($faker->dateTimeBetween("-30months", "now"))
                ->setNumber($faker->numberBetween(001, 10000))
                ->setDiscountRate($faker->numberBetween(5, 50))
                ->setItems($faker->text)
                ->setClient($this->getReference("client_". mt_rand(1,1000)));
            $manager->persist($invoice);
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
