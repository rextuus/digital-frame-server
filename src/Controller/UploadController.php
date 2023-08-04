<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageUploadType;
use App\Message\ImageUpload;
use App\Repository\ImageRepository;
use App\Service\CloudinaryApiGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function index(Request $request, CloudinaryApiGateway $cloudinaryApiGateway, MessageBusInterface $bus, ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $image->setName('test');

        $form = $this->createForm(
            ImageUploadType::class,
        );

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
//            $image = $form->get('imageFile')->getData();

            /** @var UploadedFile $file */
            $file = $form->get('imageFile')->getData();

            $uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($uploadsDirectory, $filename);

            $image->setFilePath('uploads/images/' . $filename);

            $imageRepository->save($image);
            $bus->dispatch(new ImageUpload($image->getId()));
        }

        return $this->render('upload_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
