<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(50, function () {
            return (new Artist())
                ->setName($this->faker->name(null))
                ->setDescription($this->faker->optional(0.5)->realText(200))
            ;
        });
    }
}
