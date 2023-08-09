<?php

declare(strict_types=1);

namespace App\Service\User\Form;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class UserCreateData extends UserData
{
    private string $password;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserCreateData
    {
        $this->password = $password;
        return $this;
    }
}