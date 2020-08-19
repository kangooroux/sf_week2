<?php


namespace App\DataFixtures;

use App\Entity\Record;
use Doctrine\Persistence\ObjectManager;

class RecordFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(100, 'record' , function () {
            return (new Record())
                ->setTitle($this->faker->catchPhrase)
                ->setDescription($this->faker->optional(0.8)->realText(200))
                ->setReleasedDate($this->faker->dateTimeBetween('-2 years'))
                ->setArtist($this->getRandomReference('artist'))
            ;
        });
    }

    public function getDependencies()
    {
        return [
            ArtistFixtures::class
        ];
    }
}