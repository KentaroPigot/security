<?php

namespace App\Factory;

use App\Entity\ApiToken;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function class(): string
    {
        return User::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'password' => "Test1234",
            'roles' => self::faker()->randomElement([['ROLE_ADMIN']]),
            'twitterUsername' => self::faker()->userName(),
        ];
    }

    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (User $user): void {
                // Hachage du mot de passe
                $password = $user->getPassword();
                $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);

                // Création des ApiToken associés
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $apiToken = new ApiToken($user);
                    $user->addApiToken($apiToken);
                }
            });
    }
}
