<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\CommentFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        ArticleFactory::new()->createMany(10);
        CommentFactory::new()->createMany(100);
        TagFactory::new()->createMany(20);
    }
}
