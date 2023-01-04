<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Jobs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
class DeleteJobController extends AbstractController
{
    #[Route('/delete/job/{id}', name: 'app_delete_job')]
    public function index(Request $request,EntityManagerInterface $entityManager,JobsRepository $repo,$id): Response
    {
        

        $data = $repo->findOneBy(["id"=>$id]);

        $entityManager->remove($data);

        $entityManager->flush();

        $message = "Job deleted";

        $userlist=array('message'=>$message);

        $response = new JsonResponse($userlist);

        return $response;

    }
}
