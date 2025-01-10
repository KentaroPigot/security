<?php

namespace App\Factory;

use App\Entity\Article;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

final class ArticleFactory extends PersistentProxyObjectFactory
{
    public function __construct() {}

    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->sentence(),
            'content' => self::faker()->paragraph(),
            'author' => self::faker()->name(),
            'heartCount' => self::faker()->numberBetween(5, 100),
            'imageFilename' => self::faker()->randomElement([
                'asteroid.jpeg',
                'mercury.jpeg',
                'lightspeed.png',
            ]),
            'publishedAt' => self::faker()->boolean(70) ? self::faker()->dateTimeBetween('-100 days', '-1 days') : null,
        ];
    }

    protected function initialize(): static
    {
        return $this
            // Optionally, you can hook into the object after it's created.
            // ->afterInstantiate(function(Article $article) {})
        ;
    }

    public static function class(): string
    {
        return Article::class;
    }
}
