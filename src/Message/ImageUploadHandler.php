<?php

declare(strict_types=1);

namespace App\Message;

use App\Repository\ImageRepository;
use App\Service\CloudinaryApiGateway;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
#[AsMessageHandler]
class ImageUploadHandler
{
    public function __construct(
        private CloudinaryApiGateway $cloudinaryApiGateway,
        private ImageRepository $imageRepository,
        private LoggerInterface $logger,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    public function __invoke(ImageUpload $message): void
    {

        $image = $this->imageRepository->find($message->getImageId());
        $result = $this->cloudinaryApiGateway->uploadImage($this->parameterBag->get('kernel.project_dir').'/public/'.$image->getFilePath());

        $this->logger->info($image->getFilePath().': '.$result);
    }
}