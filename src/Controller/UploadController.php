<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ImageUploadType;
use App\Service\CloudinaryApiGateway;
use App\Service\Image\Form\ImageCreateData;
use App\Service\Image\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('{description}/upload', name: 'app_upload')]
    public function index(User $user, Request $request, ImageService $imageService): Response
    {
        $form = $this->createForm(ImageUploadType::class,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('imageFile')->getData();

            $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploadsDirectory, $filename);

            $imageData = new ImageCreateData();
            $imageData->setOwner($user);

            $imageData->setFilePath('uploads/images/' . $filename);

            $imageService->createByData($imageData);
        }

        return $this->render('upload_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
