<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Image\Form\ImageData;
use App\Service\Image\ImageService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
#[Route('/frame')]
class FrameController extends AbstractController
{
    #[Route('/{uuid}/check', name: 'api_check_new_images')]
    public function checkForNewImages(User $user, ImageService $imageService): JsonResponse
    {
        $images = $imageService->getNewUndeliveredImagesByFrame($user);

        $data = [
            'newImagesAvailable' => count($images) > 0,
        ];

        return new JsonResponse($data);
    }

    #[Route('/{uuid}/synchronize/images', name: 'api_synchronize_new_images')]
    public function synchronizeNewImages(
        User $user,
        ImageService $imageService,
        SerializerInterface $serializer
    ): JsonResponse {
        $images = $imageService->getNewUndeliveredImagesByFrame($user);

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('read')
            ->toArray();

        $json = $serializer->serialize($images, 'json', $context);

        $data = [
            'images' => json_decode($json),
        ];

        return new JsonResponse($data);
    }

    #[Route('/images/mark/delivered', name: 'api_mark_delivered', methods: ['POST'])]
    public function markImagesAsDelivered(Request $request, ImageService $imageService): Response
    {
        $postData = $request->request->all();
        if (!array_key_exists('ids', $postData)){
            return new JsonResponse([]);
        }

        $ids = $postData['ids'];
        $updated = [];
        foreach ($ids as $id) {
            $image = $imageService->find((int) $id);
            if ($image){
                $data = (new ImageData())->initFrom($image);
                $data->setDelivered(new DateTime());
                $imageService->update($image, $data);
                $updated[] = $id;
            }
        }

        return new JsonResponse($updated);
    }

    #[Route('/images/mark/displayed', name: 'api_mark_displayed', methods: ['POST'])]
    public function markImagesAsDisplayed(Request $request, ImageService $imageService): Response
    {
        $postData = $request->request->all();
        if (!array_key_exists('ids', $postData)){
            return new JsonResponse([]);
        };

        $ids = $postData['ids'];
        $updated = [];
        foreach ($ids as $id) {
            $image = $imageService->find((int) $id);
            if ($image){
                $data = (new ImageData())->initFrom($image);
                $data->setDisplayed(new DateTime());
                $imageService->update($image, $data);
                $updated[] = $id;
            }
        }

        return new JsonResponse($updated);
    }
}