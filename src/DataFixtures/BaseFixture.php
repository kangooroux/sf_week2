<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class BaseFixture
 * Modèle pour les fixtures, on ne peut pas instancier une abstraction
 * @package App\DataFixtures
 */
abstract class BaseFixture extends Fixture {

    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * Méthode à implémenter pour les classes qui héritent de celle-ci et générera les données
     * @param ObjectManager $manager
     */
    abstract protected function loadData(ObjectManager $manager);

    /**
     * Méthode appelée par le système de fixtures
     */
    public function load(ObjectManager $manager)
    {
        //On va enregistrer le ObjectManager
        $this->manager = $manager;
        //On instancie Faker
        $this->faker = Factory::create('fr_FR');

        //on appelle loadData() pour générer les fausses données
        $this->loadData();
        //on éxecute l'enregistrement en base
        $this->manager->flush();
    }

    /**
     * Enregistre plusieurs entités
     *
     * Nombre d'entités à générer
     * @param int $count
     *
     * Fonction qui génère une entité
     * @param callable $factory
     */
    protected function createMany(int $count, callable $factory)
    {
        for ($i = 0;$i < $count;$i++) {
            //on éxecute $factoryqui doit retourner l'entité générée
            $entity = $factory();

            //vérifier que l'entité ait bien été retournée
            if ($entity === null) {
                throw new \LogicException('L\'entité doit être retourné. Auriez-vous oublié un "return" ?');
            }

            //on prépare à l'enregistrement de l'entité
            $this->manager->persist($entity);
        }

        //On enregistre le tout en base de données
        $this->manager->flush();
    }
}