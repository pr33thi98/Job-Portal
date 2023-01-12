<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApplicationRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
class ApplicantController extends AbstractController
{
    #[Route('/applicant', name: 'app_applicant')]
    public function index():Response
    {
        
        return $this->render('applicant/index.html.twig');
    }
    
    #[Route('/admin/paginate', name: 'app_admin_applicant')]
    public function UserList(Request $request,ApplicationRepository $repo):Response
    {
       
        $limit=$request->get('page');

        $applications = $repo->findList($limit);

        $list = $this->render('applicant/paginate.html.twig', array(

            'pagination'=>$applications

        ))->getContent();

        $count=$repo->recordCount();

        $userlist=array('pagination'=>$list,'count'=>$count);

        $response = new JsonResponse($userlist);

        return $response;
    }


}
