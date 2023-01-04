<?php

namespace App\Controller;

use App\Class\Producer;
use App\Repository\LogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    #[Route('/admin/log', name: 'app_log')]
    public function index(LogRepository $repo):Response
    {
        // $log = $repo->findAll();
        // return $this->render('admin/index.html.twig', array('logs'=>$log));
        return $this->render('admin/index.html.twig');
    }
    
    #[Route('/admin/pagination', name: 'app_paginate')]

    public function logDisplay(Request $request, LogRepository $log, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $response = new JsonResponse();

        if( $request->isMethod('POST') )
        {
            $logs = 0;

            $type = $request->request->get('type');

            $module = $request->request->get('module');

            if( isset($type) || isset($module) )
            {
                $logs = $log->filter($module, $type);
            }

            $pagination = $paginator->paginate( $logs,1, 3 );

            $list = $this->render('admin/paginate.html.twig', array('pagination'=>$pagination))->getContent();

            $count = count($logs);

            $loglist = array('pagination'=>$list, 'count'=>$count);

            $response = new JsonResponse($loglist);
        }
        
        return $response;
    }
}
