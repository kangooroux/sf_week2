<?php

namespace App\DataFixtures;

use App\Entity\Producer;

class ProducerFixtures extends BaseFixture
{
    protected function loadData()
    {
        $this->createMany(10, 'producer', function () {
            return (new Producer())
                ->setName($this->faker->unique()->word)
            ;
        });

    }

}
