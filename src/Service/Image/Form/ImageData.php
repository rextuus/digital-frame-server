<?php

declare(strict_types=1);

namespace App\Service\Image;

use App\Entity\User;
use DateTimeInterface;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class ImageData
{
    private string $name;
    private string $filePath;
    private string $cdnUrl;
    private DateTimeInterface $created;
    private DateTimeInterface $displayed;
    private DateTimeInterface $delivered;
    private User $owner;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ImageData
    {
        $this->name = $name;
        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): ImageData
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getCdnUrl(): string
    {
        return $this->cdnUrl;
    }

    public function setCdnUrl(string $cdnUrl): ImageData
    {
        $this->cdnUrl = $cdnUrl;
        return $this;
    }

    public function getCreated(): DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(DateTimeInterface $created): ImageData
    {
        $this->created = $created;
        return $this;
    }

    public function getDisplayed(): DateTimeInterface
    {
        return $this->displayed;
    }

    public function setDisplayed(DateTimeInterface $displayed): ImageData
    {
        $this->displayed = $displayed;
        return $this;
    }

    public function getDelivered(): DateTimeInterface
    {
        return $this->delivered;
    }

    public function setDelivered(DateTimeInterface $delivered): ImageData
    {
        $this->delivered = $delivered;
        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): ImageData
    {
        $this->owner = $owner;
        return $this;
    }
}