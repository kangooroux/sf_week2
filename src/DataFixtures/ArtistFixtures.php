<?php

namespace App\DataFixtures;

use App\Entity\Artist;

class ArtistFixtures extends BaseFixture
{
    public function loadData()
    {
        $this->createMany(50, function () {
            return (new Artist())
                ->setName($this->faker->realText(50))
                ->setDescription($this->faker->optional(0.5)->realText(200))
            ;
        });
    }
}
