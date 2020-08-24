<?php

namespace App\DataFixtures;

use App\Entity\Artist;

class ArtistFixtures extends BaseFixture
{
    protected function loadData()
    {
        $this->createMany(30, 'artist' , function () {
            return (new Artist())
                ->setName($this->faker->name(null))
                ->setDescription($this->faker->optional(0.5)->realText(200))
            ;
        });
    }
}
