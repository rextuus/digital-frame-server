<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Service\User\Form\UserCreateData;
use App\Service\User\Form\UserData;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class UserFactory
{
    public function __construct(private UuidFactory $uuidFactory, private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(): User
    {
        $user = $this->getNewInstance();

        $uuid = $this->uuidFactory->create();
        $user->setUuid($uuid->toBase58());

        return $user;
    }

    public function mapData(User $user, UserData $data): void
    {
        if ($data instanceof UserCreateData) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $data->getPassword()
            );
            $user->setPassword($hashedPassword);
        }

        $user->setLastSeen($data->getLastSeen());
        $user->setDescription($data->getDescription());
    }

    private function getNewInstance(): User
    {
        return new User();
    }
}