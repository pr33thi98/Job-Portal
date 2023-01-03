<?php

namespace App\Controller;

use App\Class\Producer;
use App\Entity\Log;
use App\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    
    #[Route('/admin/log', name: 'app_log')]
    // public function logDisplay(Request $request, LogRepository $log)
    // {
    //     if($request->isMethod('POST'))
    //     {
    //         $type = $request->request->get('type');
    //         if (is_integer($type))
    //         {
    //             $logs = $log->logType($type);

    //             return $logs;
    //         }
    //     }
    // }

    // public function logModule(Request $request, LogRepository $log)
    // {
    //     if($request->isMethod('POST'))
    //     {
    //         $module = $request->request->get('module');
    //         if (is_integer($module))
    //         {
    //             $modules = $log->moduleFilter($module);

    //             return $modules;
    //         }
    //     }
    // }

    // public function logDisplay(Request $request, LogRepository $log)
    // {
    //     if($request->isMethod('POST'))
    //     {
    //         if( !empty($request->request->get('type')) && !empty($request->request->get('module')) )
    //         {
    //             $logtype = $request->request->get('type');

    //             $module = $request->request->get('module');

    //             $logs = $log->filter($module, $logtype);
    //         }

    //         elseif( !empty($request->request->get('type')) )
    //         {
    //             $logtype = $request->request->get('type');

    //             $logs = $log->logType($logtype);
    //         }

    //         else
    //         {
    //             $module = $request->request->get('module');

    //             $logs = $log->moduleFilter($module);
    //         }
    //     }
    // }
    public function index(LogRepository $log): Response
    {
        // $prod = new Producer();

        // $prod->consumerConfig($entityManager);


        
        $logs = $log->findAll();

        return $this->render('admin/index.html.twig', [
            'logs' =>$logs
        ]);
    }
}
