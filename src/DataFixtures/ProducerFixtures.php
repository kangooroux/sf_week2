<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Persistence\ObjectManager;

class ProducerFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'producer', function () {
            return (new Producer())
                ->setName($this->faker->unique()->word)
            ;
        });

    }

}
