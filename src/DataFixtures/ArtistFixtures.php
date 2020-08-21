<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'artist' , function () {
            return (new Artist())
                ->setName($this->faker->name(null))
                ->setDescription($this->faker->optional(0.5)->realText(200))
            ;
        });
    }
}
