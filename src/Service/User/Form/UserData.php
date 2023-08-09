<?php

declare(strict_types=1);

namespace App\Service\User\Form;

use DateTimeInterface;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class UserData
{
    private DateTimeInterface $lastSeen;
    private string $description;

    public function getLastSeen(): DateTimeInterface
    {
        return $this->lastSeen;
    }

    public function setLastSeen(DateTimeInterface $lastSeen): UserData
    {
        $this->lastSeen = $lastSeen;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): UserData
    {
        $this->description = $description;
        return $this;
    }
}