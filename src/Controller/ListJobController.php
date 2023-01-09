<?php
namespace App\Controller;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use App\Entity\Jobs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
class ListJobController extends AbstractController
{
    #[Route('/list/job', name: 'app_list_job')]
    public function index(): Response
    {
        return $this->render('list_job/index.html.twig');
    }

    #[Route('/list/job/paginate', name:'app_list_paginate')]
    public function paginate(Request $request,JobsRepository $repo)
    {
        $limit = $request->get('page');

        $jobs = $repo->findList($limit);

        $list = $this->render('list_job/paginate.html.twig', array(

            'pagination'=>$jobs

        ))->getContent();
 
        $count = $repo->recordCount();

        $userlist = array('pagination'=>$list,'count'=>$count);

        $response = new JsonResponse($userlist);

        return $response;

       
    }
       
    }

