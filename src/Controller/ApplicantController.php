<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApplicationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class ApplicantController extends AbstractController
{
    #[Route('/applicant', name: 'app_applicant')]
    public function index(Request $request,ApplicationRepository $repo):Response
    {
        
        return $this->render('applicant/index.html.twig');
    }
    #[Route('/admin/paginate', name: 'app_admin_applicant')]
    public function UserList(Request $request,ApplicationRepository $repo,PaginatorInterface $paginator):Response
    {
        $Applications = $repo->findAll(); 
        $limit=1;
        $offset=3;
        $pagination=$paginator->paginate(
            $Applications,
            $request->query->getInt('page',$limit),
            $offset
        ) ; 
        //  $pagination=$paginator->paginate(
        //     $Applications,
        //     $request->query->getInt('page',1),
        //     3
        // ); 
        $list = $this->render('applicant/paginate.html.twig', array(
            'pagination'=>$pagination

        ))->getContent();

        $count=count($Applications);

        $userlist=array('pagination'=>$list,'count'=>$count);

        $response = new JsonResponse($userlist);
        
        return $response;
    }


}
