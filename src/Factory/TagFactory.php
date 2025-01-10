<?php

namespace App\Factory;

use App\Entity\Tag;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

final class TagFactory extends PersistentProxyObjectFactory
{
    public function __construct() {}

    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->realText(20), // Un nom de tag généré aléatoirement
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
        return Tag::class;
    }
}
