<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Image;
use App\Entity\User;
use App\Message\ImageUpload;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Service\Image\Form\ImageData;
use App\Service\Image\ImageFactory;
use App\Service\User\Form\UserData;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class UserService
{
    public function __construct(
        private UserRepository $repository,
        private UserFactory $factory,
    )
    {
    }

    public function createByData(UserData $data): User
    {
        $user = $this->factory->create();
        $this->factory->mapData($user, $data);

        $this->repository->save($user);

        return $user;
    }

    public function update(User $user, UserData $data): void
    {
        $this->factory->mapData($user, $data);
        $this->repository->save($user);
    }
}