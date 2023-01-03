<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Jobs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
class ViewJobController extends AbstractController
{
    #Route('/view/job/form)',name:'app_view_job')]
    #[Route('/view/job/{id}', name: 'app_view_job')]
    public function index($id,Request $request,JobsRepository $repo): Response
    {
        
        $data = $repo->find($id);

        echo "<prev>";

        print_r($data);

        echo "</prev>";

        exit();

        return $this->render('view_job/index.html.twig', [
            'data' => $data,
        ]);

        

    }
}
