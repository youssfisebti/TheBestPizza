<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Pizza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ingrédients
        $ingredients1 = new Ingredient();
        $ingredients1->setName('farine');
        $ingredients1->setPrice(2);
        $manager->persist($ingredients1);

        $ingredients2 = new Ingredient();
        $ingredients2->setName('levure de boulanger');
        $ingredients2->setPrice(3);
        $manager->persist($ingredients2);

        $ingredients3 = new Ingredient();
        $ingredients3->setName('sel');
        $ingredients3->setPrice(1);
        $manager->persist($ingredients3);

        $ingredients4 = new Ingredient();
        $ingredients4->setName('huile d\'olive');
        $ingredients4->setPrice(3);
        $manager->persist($ingredients4);

        $ingredients5 = new Ingredient();
        $ingredients5->setName('sauce tomates');
        $ingredients5->setPrice(2);
        $manager->persist($ingredients5);

        $ingredients6 = new Ingredient();
        $ingredients6->setName('ail');
        $ingredients6->setPrice(2);
        $manager->persist($ingredients6);

        $ingredients7 = new Ingredient();
        $ingredients7->setName('olives');
        $ingredients7->setPrice(2);
        $manager->persist($ingredients7);

        $ingredients8 = new Ingredient();
        $ingredients8->setName('olives');
        $ingredients8->setPrice(2);
        $manager->persist($ingredients8);

        // pizza

        $pizza1 = new Pizza();
        $pizza1->setName('pizza végétarien');
        $manager->persist($pizza1);
        $pizza2 = new Pizza();
        $pizza2->setName('pizza végétarien');
        $manager->persist($pizza2);

        $pizza3 = new Pizza();
        $pizza3->setName('pizza végétarien');
        $manager->persist($pizza3);

        $pizza4 = new Pizza();
        $pizza4->setName('pizza végétarien');
        $manager->persist($pizza4);

        $pizza5 = new Pizza();
        $pizza5->setName('pizza végétarien');
        $manager->persist($pizza5);

        $pizza6 = new Pizza();
        $pizza6->setName('pizza végétarien');
        $manager->persist($pizza6);

        $pizza7 = new Pizza();
        $pizza7->setName('pizza végétarien');
        $manager->persist($pizza7);

        $pizza8 = new Pizza();
        $pizza8->setName('pizza végétarien');
        $manager->persist($pizza8);

        $pizza9 = new Pizza();
        $pizza9->setName('pizza végétarien');
        $manager->persist($pizza9);

        $manager->flush();
    }
}
