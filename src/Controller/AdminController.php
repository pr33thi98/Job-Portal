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
        return $this->render('admin/index.html.twig');
    }
    
    #[Route('/admin/pagination', name: 'app_paginate')]

    public function logDisplay(Request $request, LogRepository $log): Response
    {
        $response = new Response();

        if( $request->isMethod('POST') )
        {
            $pageNo = $request->get('page');

            $type = $request->get('type', '');

            $module = $request->get('module',  '');
            
            $types = array(0,1,'');

            $modules = array(1,2,3,'');

            if(in_array($type,$types) && in_array($module,$modules))
            {

                if( isset($type) || isset($module) )
                {
                    $logs = $log->filter($module, $type, $pageNo);
                }

                if(!empty($logs))
                {
                    $list = $this->render('admin/paginate.html.twig', array('pagination'=>$logs))->getContent();

                    $count = $log->recordCount($type, $module);

                    $loglist = array('pagination'=>$list, 'count'=>$count);

                    $response = new JsonResponse($loglist);
                }
                else
                {
                    $loglist = array('pagination'=>'No Records Found');

                    $response = new JsonResponse($loglist);
                }
            }
            else
            {
                $response = false;
            }
        }
        
        return $response;
    }
}
