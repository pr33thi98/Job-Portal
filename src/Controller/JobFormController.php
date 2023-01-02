<?php

namespace App\Controller;
use App\Entity\Jobs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use App\Form\JobsType;
class JobFormController extends AbstractController
{
    #[Route('/job/form', name: 'app_job_form')]
    public function index(Request $request,JobsRepository $repo, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST'))
        {
            $id=$request->request->get('id');

            $data = $repo->find($id);

            $data->setJobTitle($data->getJobTitle());

            $data->setJobDescription($data->getJobDescription());

            $data->setSkills($data->getSkills());

            $data->setJobDescription($data->getJobDescription());

            $data->setJobLocation($data->getJobLocation());

            $data->setExperience($data->getExperience());

            $data->setExpiry($data->getExpiry());

            

            
       }
        else{
            
//;
    //}
            // if($request)

            $jobs = new Jobs();

            // print_r($jobs);

            $form = $this->createForm(JobsType::class, $jobs);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $date =  new \DateTime('@'.strtotime('now'));

                $jobs->setcreated_at($date);

                $jobs->setmodified_at($date);

                $entityManager->persist($jobs);

                $entityManager->flush();
            }

            return $this->render('job_form/index.html.twig', [
                
                'JobsForm' => $form->createView(),
            ]);

}
}