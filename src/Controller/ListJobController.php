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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
class ListJobController extends AbstractController
{
    #[Route('/list/job', name: 'app_list_job')]
    public function index(JobsRepository $repo,Request $request,PaginatorInterface $paginator ): Response
    {

        $jobs = $repo->findAll();
        $pagination=$paginator->paginate(
            $jobs,
            $request->query->getInt('page',1),
            5
        ); 

        return $this->render('list_job/index.html.twig', [
            'job' => $pagination,
        ]);
    }
}
