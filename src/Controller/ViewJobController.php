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
    
    #[Route('/view/job/{id}', name: 'app_view_job')]
    public function index($id,Request $request,JobsRepository $repo): Response
    {
        
        $data = $repo->find($id);

        $id = $data ->getId();

        $job_title = $data ->getjob_title();

        $job_description = $data ->getjob_description();

        $skills = $data ->getSkills();

        $expiry = $data ->getExpiry();

        $create = $data ->getcreated_at();

        $location = $data ->getjob_location();

        $experience = $data->getExperience();

        return  $this->render('view_job/index.html.twig', array(

           'dat' =>$id,

           'job' =>$job_title,

           'description' => $job_description,

           'expiry'=>$expiry,

           'skills'=>$skills,

           'created'=>$create,

           'location'=>$location,

           'experience' =>$experience

        ));


        

    }
}
