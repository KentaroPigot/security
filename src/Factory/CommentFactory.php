<?php

namespace App\Factory;

use App\Entity\Comment;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Proxy;

final class CommentFactory extends PersistentProxyObjectFactory
{
    public function __construct() {}

    protected function defaults(): array|callable
    {
        return [
            'content' => self::faker()->boolean ? self::faker()->paragraph : self::faker()->sentences(2, true),
            'authorName' => self::faker()->name(),
            'createdAt' => self::faker()->dateTimeBetween('-1 months', '-1 seconds'),
            'isDeleted' => self::faker()->boolean(20),
            'article' => ArticleFactory::random(),  // Référence aléatoire d'un article
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
        return Comment::class;
    }
}
