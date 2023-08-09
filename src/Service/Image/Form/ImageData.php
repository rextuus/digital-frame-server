<?php

declare(strict_types=1);

namespace App\Service\Image\Form;

use App\Entity\Image;
use App\Entity\User;
use DateTimeInterface;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class ImageData
{
    private string $filePath;
    private ?string $cdnUrl = null;
    private ?DateTimeInterface $displayed = null;
    private ?DateTimeInterface $delivered = null;
    private ?DateTimeInterface $uploaded = null;
    private User $owner;

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): ImageData
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getCdnUrl(): ?string
    {
        return $this->cdnUrl;
    }

    public function setCdnUrl(?string $cdnUrl): ImageData
    {
        $this->cdnUrl = $cdnUrl;
        return $this;
    }

    public function getDisplayed(): ?DateTimeInterface
    {
        return $this->displayed;
    }

    public function setDisplayed(?DateTimeInterface $displayed): ImageData
    {
        $this->displayed = $displayed;
        return $this;
    }

    public function getDelivered(): ?DateTimeInterface
    {
        return $this->delivered;
    }

    public function setDelivered(?DateTimeInterface $delivered): ImageData
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

    public function getUploaded(): ?DateTimeInterface
    {
        return $this->uploaded;
    }

    public function setUploaded(?DateTimeInterface $uploaded): ImageData
    {
        $this->uploaded = $uploaded;
        return $this;
    }

    public function initFrom(Image $image): ImageData
    {
        $this->setOwner($image->getOwner());
        $this->setFilePath($image->getFilePath());
        $this->setUploaded($image->getUploaded());
        $this->setDelivered($image->getDelivered());
        $this->setDisplayed($image->getDisplayed());
        $this->setCdnUrl($image->getCdnUrl());
        return $this;
    }
}